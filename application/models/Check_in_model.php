<?php

Class Check_in_model extends CI_Model {

    public function __construct() {
        
        parent::__construct();
        
    }

    var $table = 'room_checkin';

    var $column_order = array('type_name','description'); //set column field database for datatable orderable
    var $column_search = array('type_name','description'); //set column field database for datatable searchable just firstname , lastname , address are searchable
    var $order = array('id' => 'desc'); // default order 



    private function get_datatables_query() {
        
        $this->db->select('room_checkin.id,room_checkin.check_in_date,room_checkin.advanced_amt,room_checkin.total_amt,room_checkin.check_out_date,customer.name,customer.phone,room_booking_type.booking_type_name,room_checkin.status');
        $this->db->from($this->table);
        $this->db->join('customer', 'room_checkin.customer_id = customer.id');
        $this->db->join('room_booking_type', 'room_checkin.booking_type_id = room_booking_type.id');
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

    public function getCustomerData() {
        $this->db->select('customer.id,customer.name');
        $this->db->from('customer');
        $query = $this->db->get();
        return $query->result();
    }

    public function getBookingTypeData() {
        $this->db->select('room_booking_type.id,room_booking_type.booking_type_name');
        $this->db->from('room_booking_type');
        $query = $this->db->get();
        return $query->result();
    }

    public function getBookingServiceData() {
        $this->db->select('service.id,service.service_name,service.rate');
        $this->db->from('service');
        $query = $this->db->get();
        return $query->result();
    }

    public function insertData($data='',$room_id='',$services='',$qty='') {

        $this->db->insert($this->table, $data); 

        $insert_id = $this->db->insert_id(); 

        foreach ($room_id as $key => $room_ids) 
        {
            $value = array('checkin_id' => $insert_id,'selected_room' => $room_ids);

            $this->db->insert('room_checkin_sub', $value);
        }

        if($services) {

            foreach ($services as $key => $services_row) 
            {
                $value = array('checkin_id' => $insert_id,'selected_service' => $services_row,'qty' => $qty[$key]);

                $this->db->insert('room_checkin_services', $value);
            }

        }


        return true;     
    }

  
    public function getRoomsData($id) {

        $this->db->select('room.id,room.room_no,room.location,room.room_image');
        $this->db->from('room_checkin_sub');
        $this->db->join('room', 'room_checkin_sub.selected_room = room.id');
        $this->db->where('room_checkin_sub.checkin_id', $id);

        $query = $this->db->get();

        $categories = $query->result();

        $i=0;

        foreach($categories as $p_cat){

            $categories[$i]->room_image = $this->getRoomsDataSub($p_cat->id);

            $i++;
        }

        return $categories; 
    }

    public function getRoomsDataSub($id)
    {
        $this->db->select('room_images.room_image');
        $this->db->from('room_images');
        $this->db->where('room_images.room_id',$id);
        $query = $this->db->get();

        if ($query->num_rows() > 0) {

            $res = $query->result()[0]->room_image;
        }

        else{

            $res = "no image";

        }

        return $res;   
    }


    public function delete($id) {

        $this->db->delete($this->table, array('id' => $id));

        $this->db->delete('room_checkin_sub', array('checkin_id' => $id));
    }

    public function getRoomAvailabilityByDate($branch_id='',$start_date='',$end_date='') {

        $date = date('Y-m-d G:i:s', time());

        $value= array('booked_status' => 0);

        $this->db->select("room_checkin_sub.selected_room");
        $this->db->from('room_checkin_sub');
        $this->db->join('room_checkin', 'room_checkin_sub.checkin_id = room_checkin.id');
        $this->db->where('room_checkin.check_out_date <=',$date);
        $query = $this->db->get();

        foreach ($query->result_array() as $key => $rows) {

            $this->db->where('room.id', $rows['selected_room']);
            $this->db->update('room',$value);

        }

        $this->db->select("room.id,room.room_no,room.room_type_id,room_type.type_name,room.rate,room.capacity,room.location,room.extra_bed_rate,room.description,room.booked_status,room.status");
        $this->db->from('room');
        $this->db->join('room_type', 'room.room_type_id = room_type.id');
        $this->db->where('room.branch_id',$branch_id);
        $this->db->order_by('room.id','DESC');
        $query = $this->db->get();

        $categories = $query->result();

        $i = 0;

        foreach($categories as $p_cat) {

            $categories[$i]->chk_status = $this->checkExistingDataSub($p_cat->id,$start_date,$end_date);

            $i++;
        }
        
        return $categories;  

    }

    public function checkExistingDataSub($id='',$start_date='',$end_date='') { 

        $query = $this->db->query("SELECT * FROM room_checkin_sub INNER JOIN room_checkin ON room_checkin_sub.checkin_id = room_checkin.id WHERE ((room_checkin.check_in_date BETWEEN '".$start_date."' AND '".$end_date."') OR (room_checkin.check_out_date BETWEEN '".$start_date."' AND '".$end_date."')) AND room_checkin_sub.selected_room = '".$id."' ");

        if ($query->num_rows() >= 1) {

            return 1;

        }
        else{

            return 0;

        }        
    }

    public function getTotalProductPrice($id='') {

        $query = $this->db->query("SELECT id,rate FROM room  WHERE id IN (".$id.") ");

        return $query->result_array();

    }

  

}
     