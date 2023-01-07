<?php

Class Customer_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        
    }


    var $table = 'customer';
    var $column_order = array('name','phone', 'phone1'); //set column field database for datatable orderable
    var $column_search = array('name','phone', 'phone1'); //set column field database for datatable searchable just firstname , lastname , address are searchable
    var $order = array('id' => 'desc'); // default order 



    private function get_datatables_query()
    {
        $this->db->from($this->table);
        $i = 0;
        foreach ($this->column_search as $item) // loop column 
        {
        if($_POST['search']['value']) // if datatable send POST for search
        {
        if($i===0) // first loop
        {
        $this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
        $this->db->like($item, $_POST['search']['value']);
        }
        else
        {
        $this->db->or_like($item, $_POST['search']['value']);
        }

        if(count($this->column_search) - 1 == $i) //last loop
        $this->db->group_end(); //close bracket
        }
        $i++;
        }

        if(isset($_POST['order'])) // here order processing
        {
        $this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } 
        else if(isset($this->order))
        {
        $order = $this->order;
        $this->db->order_by(key($order), $order[key($order)]);
        }
    }


    public function get_datatables() {

        $this->get_datatables_query();
        if($_POST['length'] != -1)
        $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }

    public function count_filtered() {

        $this->get_datatables_query();
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all() {

        $this->db->from($this->table);
        return $this->db->count_all_results();
    }

    public function get_by_id($id) {

        $this->db->from($this->table);
        $this->db->where('id',$id);
        $query = $this->db->get();
        return $query->row();
    }
    //json load view end //

      public function insertCustomerData($value) {

        $this->db->insert($this->table, $value);       
    }

    public function viewData($id) {
        $this->db->select('*');
        $this->db->from($this->table);
        $this->db->where('id', $id);
        $query = $this->db->get();
        return $query->result();
    }

    public function updateCustomer($id='',$date='') {

        $this->db->where('id', $id);
        $this->db->update($this->table, $date);
        
    }

    public function delete($id,$name) {
        $this->db->trans_start();
        $this->db->delete($this->table, array('id' => $id));
        unlink("uploads/customer/" . $name);
        $this->db->trans_complete();
    }

  

}
     