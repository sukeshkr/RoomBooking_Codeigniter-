<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

Class Room_facility_model extends MY_model {

    public function __construct() {

        parent::__construct();
        $this->load->database();
    }

    var $table = 'room_facility';


    public function insertRoomData($data='',$id='')
    {

        if(empty($id)) {

            $this->db->insert($this->table, $data);

            $insert_id = $this->db->insert_id();

            return $insert_id;
            
        }
        else{

            $this->db->where('room_facility.id',$id);
            $this->db->update($this->table, $data);

            return $id;
        }      

    }

    public function deleteRoomDeactivateData($id='') {       


        $this->db->where('id',$id);
        $this->db->delete($this->table);

        return ($this->db->affected_rows() != 1) ? false : true;
           
    }

    public function getRoomDeactivateData($user_id='') {

        $this->db->select("room_facility.id,room_facility.facility,room_facility.description,room_facility.status");
        $this->db->from('room_facility');
        $this->db->order_by('room_facility.id','DESC');
        $query = $this->db->get();

        return $query->result_array();
    }

    public function getRoomData()
    {

        $this->db->select("room_facility.id,room_facility.facility,room_facility.description,room_facility.status");
        $this->db->from('room_facility');
        $this->db->order_by('room_facility.id','DESC');
        $query = $this->db->get();

        return $query->result_array();
    }

   

    
}