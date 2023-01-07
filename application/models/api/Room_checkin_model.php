<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

Class Room_checkin_model extends MY_model {

    public function __construct() {

        parent::__construct();
        $this->load->database();
    }

    var $table = 'room_checkin';
    
    public function chkRoomAvailability($id='',$start_date='',$end_date='') { 

        $array = implode("','",$id);

        $query = $this->db->query("SELECT * FROM room_checkin_sub INNER JOIN room_checkin ON room_checkin_sub.checkin_id = room_checkin.id WHERE ((room_checkin.check_in_date BETWEEN '".$start_date."' AND '".$end_date."') OR (room_checkin.check_out_date BETWEEN '".$start_date."' AND '".$end_date."')) AND room_checkin_sub.selected_room IN ('".$array."') ");

        if ($query->num_rows() >= 1) {

            return $query->result();

        }
        else{

            return 0;

        }        
    }

    public function insertRoomCheckinData($data='',$selected_room='',$id='') {

        $value= array('booked_status' => 1);

        foreach ($selected_room as $key => $rows) {

            $this->db->where('room.id', $rows);
            $this->db->update('room',$value);
          
        }

        if(empty($id)) {

            $this->db->insert($this->table, $data);

            $insert_id = $this->db->insert_id();

            if(!empty($selected_room[0])) {

                foreach ($selected_room as $key => $rows) {

                    $sub_data= array('checkin_id' => $insert_id,'selected_room' => $rows);

                    $this->db->insert('room_checkin_sub', $sub_data);
              
                }
            }

            return $insert_id;
            
        }
        else{

            $this->db->where('room_checkin.id',$id);
            $this->db->update($this->table, $data);

            if(!empty($selected_room[0])) {

                foreach ($selected_room as $key => $rows) {

                    $sub_data= array('checkin_id' => $id,'selected_room' => $rows);

                    $this->db->insert('room_checkin_sub', $sub_data);
              
                }
            }

            return $id;
        }      

    }

    public function putRoomDeactivateData($status='',$id='') {       

        $value= array('status' => $status);

        $this->db->update($this->table, $value, array('id'=>$id));
        
        $this->db->update('room_checkin_sub', $value, array('checkin_id'=>$id));

        return ($this->db->affected_rows() != 1) ? false : true;
           
    }

    public function getRoomDeactivateData($user_id='') {

        $this->db->select("room_checkin.id,room_checkin.customer_id,room_checkin.selected_room,room_checkin.booking_type_id,room_checkin.advanced_amt,room_checkin.total_amt,room_checkin.description,room_checkin.check_in_date,room_checkin.check_out_date,room_checkin.cur_date,room_checkin.status");
        $this->db->from('room_checkin');
        $this->db->order_by('room_checkin.id','DESC');
        $query = $this->db->get();

        return $query->result_array();
    }

    public function getRoomData()
    {

        $this->db->select("room_checkin.id,room_checkin.customer_id,room_checkin.selected_room,room_checkin.booking_type_id,room_checkin.advanced_amt,room_checkin.total_amt,room_checkin.description,room_checkin.check_in_date,room_checkin.check_out_date,room_checkin.cur_date,room_checkin.status");
        $this->db->from('room_checkin');
        $this->db->order_by('room_checkin.id','DESC');
        $query = $this->db->get();

        return $query->result_array();
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

            $categories[$i]->facility = $this->getFacilityListSub($p_cat->id);

            $categories[$i]->image = $this->getRoomImageListSub($p_cat->id);

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
    
    public function getRoomCheckoutPendingData($id='',$date='') {

        $this->db->select("room.id,room.room_no,room.location,room_checkin.id as room_checkin_id,room_checkin.customer_id,room_checkin.booking_type_id,room_booking_type.booking_type_name,room_checkin.advanced_amt,room_checkin.total_amt,room_checkin.description,room_checkin.check_in_date,room_checkin.check_out_date,room_checkin.cur_date,room_checkin.status");
        $this->db->from('room_checkin');
        $this->db->join('room_checkin_sub', 'room_checkin.id = room_checkin_sub.checkin_id');
        $this->db->join('room', 'room_checkin_sub.selected_room = room.id');
        $this->db->join('room_booking_type', 'room_checkin.booking_type_id = room_booking_type.id');
        $this->db->where('room.branch_id',$id);
        $this->db->where('DATE_FORMAT(room_checkin.check_out_date,"%Y-%m-%d")',$date);
        $this->db->where('room_checkin.status',1);
        $this->db->order_by('room_checkin.id','DESC');
        $query = $this->db->get();

        return $query->result_array();
    }
    
    public function getRoomCheckoutPendingget($id='') {

        $this->db->select("room.id,room.room_no,room.location,room_checkin.id as room_checkin_id,room_checkin.customer_id,room_checkin.booking_type_id,room_booking_type.booking_type_name,room_checkin.advanced_amt,room_checkin.total_amt,room_checkin.description,room_checkin.check_in_date,room_checkin.check_out_date,room_checkin.cur_date,room_checkin.status");
        $this->db->from('room_checkin');
        $this->db->join('room_checkin_sub', 'room_checkin.id = room_checkin_sub.checkin_id');
        $this->db->join('room_booking_type', 'room_checkin.booking_type_id = room_booking_type.id');
        $this->db->join('room', 'room_checkin_sub.selected_room = room.id');
        $this->db->where('room.branch_id',$id);
        $this->db->where('room_checkin.status',1);
        $this->db->order_by('room_checkin.id','DESC');
        $query = $this->db->get();

        return $query->result_array();
    }
    
    public function putCheckoutData($data='',$check_in_id='',$user_id='') {
        
        if(!array_key_exists('check_out_date', $data)) {
            
            $data['check_out_date'] = date("Y-m-d H:i:s");
        }

        $value= array('booked_status' => 0);

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

   

    
}