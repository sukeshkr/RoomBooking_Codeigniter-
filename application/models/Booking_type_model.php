<?php

Class Booking_type_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        
    }


    var $table = 'room_booking_type';

    var $column_order = array('booking_type_name','description'); //set column field database for datatable orderable
    var $column_search = array('booking_type_name','description'); //set column field database for datatable searchable just firstname , lastname , address are searchable
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

      public function insertData() {

        $booking_type_name = $this->input->post('booking_type_name');
        $description = $this->input->post('description');


        $value = array('booking_type_name' => $booking_type_name,'description' => $description);

        $this->db->insert($this->table, $value);       
    }

  
    public function viewData($id) {
        $this->db->select('*');
        $this->db->from($this->table);
        $this->db->where('id', $id);
        $query = $this->db->get();
        return $query->result();
    }

    public function updateData($id) {

        $booking_type_name = $this->input->post('booking_type_name');
        $description = $this->input->post('description');
     
        $value = array('booking_type_name' => $booking_type_name, 'description' => $description);
       
        $this->db->where('id', $id);
        $this->db->update($this->table, $value);
        
    }

    public function delete($id) {

        $this->db->delete($this->table, array('id' => $id));
    }

  

}
     