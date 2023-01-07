<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

Class Branch_model extends MY_model {

    public function __construct() {

        parent::__construct();
        $this->load->database();
    }

    var $table = 'branch';

    public function getCountBranchUser() {

        $this->db->select('branch.id');//select each seller
        $query = $this->db->get($this->table);

        if($query->num_rows() > 12 )
        {
            return false;

        }
        else{

            return true;

        }
         
    }

    public function insertBranchRegister($data='',$id='') {

        if(empty($id)) {

            $this->db->select('branch.id');//select each seller
            $this->db->where('branch.userid',$data['userid']);//select each seller
            $query = $this->db->get($this->table);

            if ($query->num_rows() < 1) {

                $this->db->insert($this->table, $data);

                $insert_id = $this->db->insert_id();

                return $insert_id;
            }
            else{

                return FALSE;

            } 
        }
        else{

            $this->db->select('branch.id');
            $this->db->where('branch.id !=',$id);
            $this->db->where('branch.userid',$data['userid']);
            $query = $this->db->get($this->table);

            if ($query->num_rows() < 1) {

                $this->db->where('branch.id',$id);
                $this->db->update($this->table, $data);

                return $id;
            }
            else{

                return FALSE;

            } 

        }      

    }

    public function putUserDeactivateData($status='',$id='') {       

        $value= array('status' => $status);

        $this->db->update('branch', $value, array('id'=>$id));

        return ($this->db->affected_rows() != 1) ? false : true;
           
    }

    public function getUserDeactivateData($user_id='') {

        $this->db->select("branch.id,branch.branch_name,branch.userid,branch.location,branch.description,branch.status");
        $this->db->from('branch');
        $this->db->where('branch.role !=','super_admin');
        $this->db->order_by('branch.id','DESC');
        //$this->db->where('user_registration.id',$user_id);
        $query = $this->db->get();

        return $query->result_array();
    }

    public function getBranchesData($type_id='') {

        $this->db->select("branch.id,branch.branch_name,branch.userid,branch.location,branch.description,branch.status");
        $this->db->from('branch');
        $this->db->where('branch.role !=','super_admin');
        $this->db->where('branch.status',1);
        $this->db->order_by('branch.id','DESC');
        $query = $this->db->get();

        $categories = $query->result();

        $i=0;

        foreach($categories as $p_cat){

            $categories[$i]->rooms = $this->getBranchesSubData($p_cat->id);

            $categories[$i]->bookings = $this->getBranchesSubBooking($p_cat->id,$type_id);

            $categories[$i]->pending = $this->getBranchePendingSubData($p_cat->id,$type_id);

            $categories[$i]->available = $this->getchkRoomAvailabilitySub($p_cat->id);


            $i++;
        }
        
        return $categories;
    }
    
    public function getBranchesSubData($id='') {

        $this->db->select("room.id");
        $this->db->from('room');
        $this->db->where('room.branch_id',$id);
        $this->db->where('room.status',1);
        $query = $this->db->get();

        return $query->num_rows();
    }

    public function getBranchesSubBooking($id='',$type_id='') {

        $this->db->select("room.id");
        $this->db->from('room_checkin_sub');
        $this->db->join('room_checkin', 'room_checkin_sub.checkin_id = room_checkin.id');
        $this->db->join('room', 'room_checkin_sub.selected_room = room.id');
        $this->db->where('room.branch_id',$id);
        $this->db->where('room_checkin.status',1);
        $this->db->where('room.status',1);

        if(!empty($type_id)) {

            $this->db->where('room_checkin.booking_type_id',$type_id);

        }

        $query = $this->db->get();


        return $query->num_rows();
    }

    public function getBranchePendingSubData($id='',$type_id='') {

        $this->db->select("room.id");
        $this->db->from('room_checkin_sub');
        $this->db->join('room_checkin', 'room_checkin_sub.checkin_id = room_checkin.id');
        $this->db->join('room', 'room_checkin_sub.selected_room = room.id');
        $this->db->where('room.branch_id',$id);
        $this->db->where('room_checkin_sub.status',1);

        if(!empty($type_id)) {

            $this->db->where('room_checkin.booking_type_id',$type_id);

        }

        $query = $this->db->get();

        return $query->num_rows();
    }
    
    
    public function getchkRoomAvailabilitySub($id='') { 

        $query = $this->db->query("SELECT * FROM room_checkin_sub INNER JOIN room_checkin ON room_checkin_sub.checkin_id = room_checkin.id INNER JOIN room ON room_checkin_sub.selected_room = room.id WHERE room.branch_id = '".$id."' GROUP BY room.id ");

        return $query->num_rows();              
    }
    
    public function getBrancheWiseData($id) {

        $this->db->select("branch.id,branch.branch_name,branch.userid,branch.location,branch.description,branch.status");
        $this->db->from('branch');
        $this->db->where('branch.id',$id);
        $this->db->order_by('branch.status',1);
        $query = $this->db->get();

        $categories = $query->result();

        $i=0;

        foreach($categories as $p_cat){

            $categories[$i]->rooms = $this->getBrancheWiseDataSub($p_cat->id);

            $categories[$i]->bookings = $this->getBrancheWiseBookingSub($p_cat->id);

            $categories[$i]->pending = $this->getBrancheWisePendingDataSub($p_cat->id);

            $categories[$i]->booking_amt = $this->getBrancheWiseBookingAmtSub($p_cat->id);

            $categories[$i]->pending_amt = $this->getBrancheWisePendingAmtSub($p_cat->id);

            $i++;
        }
        
        return $categories;  
    }

    public function getBrancheWiseDataSub($id='') {

        $this->db->select("room.id");
        $this->db->from('room');
        $this->db->where('room.branch_id',$id);
        $this->db->where('room.status',1);
        $query = $this->db->get();

        return $query->num_rows();
    }

    public function getBrancheWiseBookingSub($id='') {

        $this->db->select("room.id");
        $this->db->from('room_checkin_sub');
        $this->db->join('room', 'room_checkin_sub.selected_room = room.id');
        $this->db->where('room.branch_id',$id);
        $this->db->where('room.status',1);
        $query = $this->db->get();

        return $query->num_rows();
    }

    public function getBrancheWisePendingDataSub($id='') {

        $this->db->select("room.id");
        $this->db->from('room_checkin_sub');
        $this->db->join('room', 'room_checkin_sub.selected_room = room.id');
        $this->db->where('room.branch_id',$id);
        $this->db->where('room_checkin_sub.status',1);
        $query = $this->db->get();

        return $query->num_rows();
    }

    public function getBrancheWiseBookingAmtSub($id='') {

        $this->db->select("SUM(room_checkin.total_amt) as total_amt");
        $this->db->from('room_checkin_sub');
        $this->db->join('room_checkin', 'room_checkin_sub.checkin_id = room_checkin.id');
        $this->db->join('room', 'room_checkin_sub.selected_room = room.id');
        $this->db->where('room.branch_id',$id);
        $this->db->where('room.status',1);
        $query = $this->db->get();

        if ($query->num_rows() >= 1) {

            $result = $query->result_array()[0]['total_amt'];
        }

        else {

            $result = 0.00;
        }

        return $result;
    }

    public function getBrancheWisePendingAmtSub($id='') {

        $this->db->select("COALESCE(SUM(room_checkin.total_amt - room_checkin.advanced_amt),0) as total_amt");
        $this->db->from('room_checkin_sub');
        $this->db->join('room_checkin', 'room_checkin_sub.checkin_id = room_checkin.id');
        $this->db->join('room', 'room_checkin_sub.selected_room = room.id');
        $this->db->where('room.branch_id',$id);
        $this->db->where('room_checkin.status',1);
        $query = $this->db->get();

        if ($query->num_rows() >= 1) {

            $result = $query->result_array()[0]['total_amt'];
        }

        else {

            $result = 0.00;
        }

        return $result;
    }

   

    
}