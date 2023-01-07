<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

Class Room_model extends MY_model {

    public function __construct() {

        parent::__construct();
        $this->load->database();
    }

    var $table = 'room';


    public function insertRoomData($data='',$file='',$facility_id='',$id='')
    {

        if(empty($id)) {

            $this->db->insert($this->table, $data);

            $insert_id = $this->db->insert_id();

            if(!empty($file[0])) {

                foreach($file as  $index => $files) 
                {

                    $value_file= array('room_id' => $insert_id,'room_image' => $files);
                    $this->db->insert('room_images', $value_file);
                }

            }


            if(!empty($facility_id[0])) {

                foreach($facility_id as  $index => $facility_ids) 
                {

                    $value_facility= array('room_id' => $insert_id,'room_facility' => $facility_ids);
                    $this->db->insert('multiple_room_facility', $value_facility);
                }

            }

            return $insert_id;
            
        }
        else{

            $this->db->where('room.id',$id);
            $this->db->update($this->table, $data);

            if(!empty($file[0])) {

                foreach($file as  $index => $files) {

                    $value_file= array('room_id' => $id,'room_image' => $files);
                    $this->db->insert('room_images', $value_file);
                }

            }

            if(!empty($facility_id[0])) {
                
                $this->db->where('room_id',$id);
                $this->db->delete('multiple_room_facility');

                foreach($facility_id as  $index => $facility_ids) 
                {

                    $value_facility= array('room_id' => $id,'room_facility' => $facility_ids);
                    $this->db->insert('multiple_room_facility', $value_facility);
                }

            }

            return $id;
        }      

    }

    public function putRoomDeactivateData($status='',$id='') {       

        $value= array('status' => $status);

        $this->db->update($this->table, $value, array('id'=>$id));

        return ($this->db->affected_rows() != 1) ? false : true;
           
    }

    public function getRoomDeactivateData() {

        $this->db->select("room.id,room.room_no,room.room_type_id,room.rate,room.capacity,room.location,room.room_image,room.extra_bed_rate,room.description,room.booked_status,room.status");
        $this->db->from('room');
        $this->db->order_by('room.id','DESC');
        $query = $this->db->get();

        return $query->result_array();
    }

    public function getRoomData($id='') {

        $this->db->select("room.id,room.room_no,room.room_type_id,room_type.type_name,room.rate,room.capacity,room.location,room.extra_bed_rate,room.description,room.booked_status,room.status");
        $this->db->from('room');
        $this->db->join('room_type', 'room.room_type_id = room_type.id');
        $this->db->where('room.branch_id',$id);
        $this->db->order_by('room.id','DESC');
        $query = $this->db->get();

        $categories = $query->result();

        $i=0;

        foreach($categories as $p_cat){

            $categories[$i]->facility = $this->getFacilityListSub($p_cat->id);

            $categories[$i]->image = $this->getRoomImageListSub($p_cat->id);

            $i++;
        }
        
        return $categories;  

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

    public function getRoomImageListSub($id='') {

        $this->db->select("room_images.id,room_images.room_image");
        $this->db->from('room_images');
        $this->db->where('room_images.room_id',$id);
        $this->db->order_by('room_images.id','DESC');
        $query = $this->db->get();

        return $query->result_array();
    }


    public function getRoomFacilityData() {

        $this->db->select("room_facility.id,room_facility.facility,room_facility.description,room_facility.status");
        $this->db->from('room_facility');
        $this->db->order_by('room_facility.id','DESC');
        $query = $this->db->get();

        return $query->result_array();
    }

    public function getRoomTypeData()
    {

        $this->db->select("room_type.id,room_type.type_name,room_type.description,room_type.status");
        $this->db->from('room_type');
        $this->db->order_by('room_type.id','DESC');
        $query = $this->db->get();

        return $query->result_array();
    }
    
    public function getRoomBookingType() {

        $this->db->select("room_booking_type.id,room_booking_type.booking_type_name,room_booking_type.description,room_booking_type.status");
        $this->db->from('room_booking_type');
        $this->db->order_by('room_booking_type.id','DESC');
        $query = $this->db->get();

        return $query->result_array();
    }

    public function getCustomerData() {

        $this->db->select("customer.id,customer.name,customer.email,customer.location,customer.state,customer.country,customer.id_proof_type,customer.id_proof_no,customer.joining_date,customer.address,customer.phone,customer.phone1,customer.status");
        $this->db->from('customer');
        $this->db->order_by('customer.id','DESC');
        $query = $this->db->get();

        return $query->result_array();
    }

   

    
}