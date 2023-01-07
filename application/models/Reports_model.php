<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Reports_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        
        //load database library
        $this->load->database();
    }

    var $table = 'room_checkin';
    var $order = array('id' => 'desc');

    public function getUserName($user_id='')
    {
        $this->db->select('branch.branch_name');
        $this->db->from('branch');
        $this->db->where('branch.id',$user_id);
        $query = $this->db->get();

        if ($query->num_rows() > 0) {

            $res = $query->result()[0]->branch_name;
        }

        else{

            $res = "";

        }

        return $res;

    }

    public function getCheckInData($user_id='',$from_date='',$to_date='') {

        $this->db->select('room_checkin.id,room_checkin.check_in_date,room_checkin.advanced_amt,room_checkin.service_amt,room_checkin.total_amt,room_checkin.check_out_date,customer.name,customer.phone,room_booking_type.booking_type_name,room_checkin.status');
        $this->db->from($this->table);
        $this->db->join('customer', 'room_checkin.customer_id = customer.id');
        $this->db->join('room_booking_type', 'room_checkin.booking_type_id = room_booking_type.id');
        $this->db->join('room_checkin_sub', 'room_checkin.id = room_checkin_sub.checkin_id');
         $this->db->join('room', 'room_checkin_sub.selected_room = room.id');
        $this->db->where('room.branch_id',$user_id);
        $this->db->where('room_checkin.check_in_date >=',$from_date);
        $this->db->where('room_checkin.check_out_date <=',$to_date);
        $query = $this->db->get();

        $categories = $query->result();

        return $categories;

    }

    public function getCheckOutData($user_id='',$from_date='',$to_date='') {
        
        $this->db->select('room_checkin.id,room_checkin.check_in_date,room_checkin.advanced_amt,room_checkin.service_amt,room_checkin.total_amt,room_checkin.check_out_date,customer.name,customer.phone,room_booking_type.booking_type_name,room_checkin.status');
        $this->db->from($this->table);
        $this->db->join('customer', 'room_checkin.customer_id = customer.id');
        $this->db->join('room_booking_type', 'room_checkin.booking_type_id = room_booking_type.id');
        $this->db->join('room_checkin_sub', 'room_checkin.id = room_checkin_sub.checkin_id');
        $this->db->join('room', 'room_checkin_sub.selected_room = room.id');
        $this->db->where('room.branch_id',$user_id);
        $this->db->where('room_checkin.check_in_date >=',$from_date);
        $this->db->where('room_checkin.check_out_date <=',$to_date);
        $this->db->where('room_checkin.status',1);
        $query = $this->db->get();

        $categories = $query->result();

        return $categories;

    }

    public function getCustomerData($user_id='',$from_date='',$to_date='') {

        $this->db->select('customer.id,customer.name,customer.phone,customer.email,customer.location,customer.state,customer.id_proof_no,customer.id_proof_type,customer.status');
        $this->db->from('customer');
        $query = $this->db->get();

        $categories = $query->result();

        return $categories;

    }

    public function getBookingTypeData($user_id='',$from_date='',$to_date='',$booking_type_id='')
    {
        $this->db->select('room_checkin.id,room_booking_type.id as booking_type_id,room_checkin.check_in_date,room_checkin.advanced_amt,room_checkin.service_amt,room_checkin.total_amt,room_checkin.check_out_date,room_booking_type.booking_type_name,room_checkin.status');
        $this->db->from($this->table);
        $this->db->join('room_booking_type', 'room_checkin.booking_type_id = room_booking_type.id');
        $this->db->join('room_checkin_sub', 'room_checkin.id = room_checkin_sub.checkin_id');
        $this->db->join('room', 'room_checkin_sub.selected_room = room.id');
        $this->db->where('room.branch_id',$user_id);
        $this->db->where('room_checkin.check_in_date >=',$from_date);
        $this->db->where('room_checkin.check_out_date <=',$to_date);
        $this->db->where('room_booking_type.id',$booking_type_id);
        $query = $this->db->get();

        $categories = $query->result();

        return $categories;

    }

    public function getDayBookData($user_id='',$from_date='',$to_date='')
    {
        $this->db->select('daybook.id,daybook.total_amt,daybook.payment,daybook.balance,daybook.date_time,daybook.description');
        $this->db->from('daybook');
        $this->db->where('daybook.user_id',$user_id);
        $this->db->where('daybook.date_time >=',$from_date);
        $this->db->where('daybook.date_time <=',$to_date);
        $query = $this->db->get();

        $categories = $query->result();

        return $categories;

    }

    public function BookingTypeGet() {

        $this->db->select('room_booking_type.id,room_booking_type.booking_type_name');
        $this->db->from('room_booking_type');
        $query = $this->db->get();
        return $query->result();
    }

                   
}

?>