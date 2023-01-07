<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

Class Room_type_model extends MY_model {

    public function __construct() {

        parent::__construct();
        $this->load->database();
    }

    var $table = 'room_type';


    public function insertRoomTypeData($data='',$id='')
    {

        if(empty($id)) {

            $this->db->insert($this->table, $data);

            $insert_id = $this->db->insert_id();

            return $insert_id;
            
        }
        else{

            $this->db->where('room_type.id',$id);
            $this->db->update($this->table, $data);

            return $id;
        }      

    }

    public function deleteRoomTypeDeactivateData($id='') {       

        $this->db->where('id',$id);
        $this->db->delete($this->table);

        return ($this->db->affected_rows() != 1) ? false : true;
           
    }

    public function getRoomTypeDeactivateData($user_id='') {

        $this->db->select("room_type.id,room_type.type_name,room_type.description,room_type.status");
        $this->db->from('room_type');
        $this->db->order_by('room_type.id','DESC');
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

   

    
}