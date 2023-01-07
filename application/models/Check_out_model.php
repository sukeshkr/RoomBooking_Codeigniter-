<?php

Class Check_out_model extends CI_Model {

    public function __construct() {
        
        parent::__construct();
        
    }

    var $table = 'room_checkin';

    var $column_order = array('type_name','description'); //set column field database for datatable orderable
    var $column_search = array('type_name','description'); //set column field database for datatable searchable just firstname , lastname , address are searchable
    var $order = array('id' => 'desc'); // default order 



    private function get_datatables_query()
    {
        $this->db->select('room_checkin.id,room_checkin.check_in_date,room_checkin.advanced_amt,room_checkin.total_amt,room_checkin.check_out_date,customer.name,customer.phone,room_booking_type.booking_type_name');
        $this->db->from($this->table);
        $this->db->join('customer', 'room_checkin.customer_id = customer.id');
        $this->db->join('room_booking_type', 'room_checkin.booking_type_id = room_booking_type.id');
        $this->db->where('room_checkin.status', 1);
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

    public function getCheckinDate($id) {

        $this->db->select('room_checkin.id,room_checkin.check_out_date');
        $this->db->from('room_checkin');
        $this->db->where('room_checkin.id', $id);

        $query = $this->db->get();

        return $query->result();
    }

  
    public function getRoomsData($id) {

        $this->db->select('room.id,room.room_no,room.location,room.room_image');
        $this->db->from('room_checkin_sub');
        $this->db->join('room', 'room_checkin_sub.selected_room = room.id');
        $this->db->where('room_checkin_sub.checkin_id', $id);

        $query = $this->db->get();

        return $query->result();
    }

     public function getRoomsCheckOutData($id) {

        $this->db->select('room_checkin.id,SUM(room_checkin.total_amt) as totalamt,SUM(room_checkin.advanced_amt) as advanced_amt,SUM(room_checkin.total_amt -  room_checkin.advanced_amt) as balanceamt');
        $this->db->from('room_checkin');
        $this->db->where('room_checkin.id', $id);

        $query = $this->db->get();

        $categories = $query->result();

        $i=0;

        foreach($categories as $p_cat){

            $categories[$i]->service_amt = $this->getRoomsCheckOutDataSub($p_cat->id);

            $i++;
        }

        return $categories;
    }

     public function getRoomsCheckOutDataSub($id) {

        $this->db->select('SUM(service.rate * room_checkin_services.qty) as totalservice');
        $this->db->from('room_checkin_services');
        $this->db->join('service', 'room_checkin_services.selected_service = service.id');
        $this->db->where('room_checkin_services.checkin_id', $id);

        $query = $this->db->get();

        if ($query->num_rows() > 0) {

            $categories = $query->result_array()[0]['totalservice'];
                       
        }
        else{

            $categories = 0.00;

        }

        return $categories;
    }


    public function delete($id) {

        $this->db->delete($this->table, array('id' => $id));

        $this->db->delete('room_checkin_sub', array('checkin_id' => $id));
    }

    public function putCheckoutData($data='',$check_in_id='',$user_id='') {

        if(!array_key_exists('check_out_date', $data)){
            
            $data['check_out_date'] = date("Y-m-d G:i:s");

        }

        $value = array('booked_status' => 0);

        $this->db->select("room_checkin_sub.selected_room");
        $this->db->from('room_checkin_sub');
        $this->db->where('room_checkin_sub.checkin_id',$check_in_id);
        $query = $this->db->get();

        foreach ($query->result_array() as $key => $rows) {

            $this->db->where('room.id', $rows['selected_room']);
            $this->db->update('room',$value);
        }

        $this->db->where('room_checkin.id',$check_in_id);
        $this->db->update($this->table, $data);

        $sub_data = array('status' => 2);

        $this->db->where('room_checkin_sub.checkin_id',$check_in_id);
        $this->db->update('room_checkin_sub', $sub_data);

        return true;

    }

    public function putServiceData($check_in_id='',$services='',$qty='') {

        if($services) {

            foreach ($services as $key => $services_row)  {

                $value = array('checkin_id' => $check_in_id,'selected_service' => $services_row,'qty' => $qty[$key]);

                $this->db->insert('room_checkin_services', $value);
            }

        }

        return true;

    }

     public function putExtendedData($id='',$date='') {

        $value = array('check_out_date' => $date);

        $this->db->where('room_checkin.id',$id);
        $this->db->update('room_checkin', $value);

        return true;
    }

    public function getBookingServiceData() {
        $this->db->select('service.id,service.service_name,service.rate');
        $this->db->from('service');
        $query = $this->db->get();
        return $query->result();
    }

   

}
     