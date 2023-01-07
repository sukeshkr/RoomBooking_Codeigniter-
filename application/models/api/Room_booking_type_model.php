<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

Class Room_booking_type_model extends MY_model {

    public function __construct() {

        parent::__construct();
        $this->load->database();
    }

    var $table = 'room_booking_type';


    public function insertRoomData($data='',$id='')
    {

        if(empty($id)) {

            $this->db->insert($this->table, $data);

            $insert_id = $this->db->insert_id();

            return $insert_id;
            
        }
        else{

            $this->db->where('room_booking_type.id',$id);
            $this->db->update($this->table, $data);

            return $id;
        }      

    }

    public function putRoomDeactivateData($status='',$id='') {       

        $value= array('status' => $status);

        $this->db->update($this->table, $value, array('id'=>$id));

        return ($this->db->affected_rows() != 1) ? false : true;
           
    }

    public function getRoomDeactivateData($user_id='') {

        $this->db->select("room_booking_type.id,room_booking_type.booking_type_name,room_booking_type.description,room_booking_type.status");
        $this->db->from('room_booking_type');
        $this->db->order_by('room_booking_type.id','DESC');
        $query = $this->db->get();

        return $query->result_array();
    }

    public function getRoomData() {

        $this->db->select("room_booking_type.id,room_booking_type.booking_type_name,room_booking_type.description,room_booking_type.status");
        $this->db->from('room_booking_type');
        $this->db->order_by('room_booking_type.id','DESC');
        $query = $this->db->get();

        $categories = $query->result();

        $i=0;

        foreach($categories as $p_cat) {

            $categories[$i]->count = $this->getRoomTypeGetDataSub($p_cat->id);

            $i++;
        }

        return $categories;
    }
    
    public function getRoomTypeGetDataSub($id='') {

        $this->db->select("room_checkin.id");
        $this->db->from('room_checkin');
        $this->db->where('room_checkin.booking_type_id',$id);
        $this->db->where('room_checkin.status',1);
        $query = $this->db->get();

        $categories = $query->num_rows();

        return $categories;

    }
    
    public function getRoomBookingTypeData($id='') {


        $this->db->select("room.id,room.room_no,room.room_type_id,room_type.type_name,room.rate,room.capacity,room.location,room.extra_bed_rate,room.description,room.booked_status,room.status,room_booking_type.booking_type_name");
        $this->db->from('room');
        $this->db->join('room_type', 'room.room_type_id = room_type.id');
        $this->db->join('room_checkin_sub', 'room.id = room_checkin_sub.selected_room');
        $this->db->join('room_checkin', 'room_checkin_sub.checkin_id = room_checkin.id');
        $this->db->join('room_booking_type', 'room_checkin.booking_type_id = room_booking_type.id');
        $this->db->where('room_booking_type.id',$id);
        $this->db->group_by('room.id');
        $query = $this->db->get();

        $categories = $query->result();
        
        $i = 0;

        foreach($categories as $p_cat) {

            $categories[$i]->facility = $this->getFacilityListSub($p_cat->id);

            $categories[$i]->image = $this->getRoomImageListSub($p_cat->id);

            $i++;
        }
        
        return $categories;  

    }

    public function getRoomImageListSub($id='') {

        $this->db->select("room_images.id,room_images.room_image");
        $this->db->from('room_images');
        $this->db->where('room_images.room_id',$id);
        $this->db->order_by('room_images.id','DESC');
        $query = $this->db->get();

        return $query->result_array();
    }

    public function getFacilityListSub($id='') {

        $this->db->select("room_facility.id,room_facility.facility,room_facility.description,room_facility.status");
        $this->db->from('multiple_room_facility');
        $this->db->join('room_facility', 'multiple_room_facility.room_facility = room_facility.id');
        $this->db->where('multiple_room_facility.room_id',$id);
        $this->db->order_by('room_facility.facility','ASC');
        $query = $this->db->get();

        return $query->result_array();
    }
    
   
    public function getRoomDataDetails($id='') {

        $this->db->select("room.id as room_id,room_checkin.id as checkin_id,room_checkin.customer_id,room_booking_type.id,room_booking_type.booking_type_name,room_checkin.advanced_amt,room_checkin.total_amt,room_checkin.check_in_date,room_checkin.check_out_date,room.room_no,room_checkin.status");
        $this->db->from('room_checkin');
        $this->db->join('room_checkin_sub', 'room_checkin.id = room_checkin_sub.checkin_id');
        $this->db->join('room_booking_type', 'room_checkin.booking_type_id = room_booking_type.id');
        $this->db->join('room', 'room_checkin_sub.selected_room = room.id');
        $this->db->where('room_checkin.booking_type_id',$id);
        $this->db->where('room_checkin.status',2);
        $query = $this->db->get();

        $categories = $query->result();

        return $categories;

    }
   
    
}