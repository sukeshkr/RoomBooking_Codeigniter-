<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Home_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        
        //load database library
        $this->load->database();
    }

    var $table = 'ledger';
    var $order = array('id' => 'desc');
    
    public function getchkRoomAvailability() { 

        $query = $this->db->query("SELECT * FROM room WHERE status != 0 ");

        return $query->num_rows();              
    }
    
    public function getchkRoomAvailabilityBranchesWise($id) { 

        $query = $this->db->query("SELECT * FROM room WHERE room.branch_id  = '".$id."' AND room.status != 0 ");

        return $query->num_rows();              
    }


    public function geAllBranches()
    {
        $this->db->select('branch.id');
        $this->db->from('branch');
        $this->db->where('branch.status',1);
        $this->db->where('branch.role !=','super_admin');
        $query = $this->db->get();

        return $query->num_rows();   

    }

    public function geAllBranchesRoom()
    {
        $this->db->select('room.id');
        $this->db->from('room');
        $this->db->where('room.status',1);
        $query = $this->db->get();

        return $query->num_rows();   
    }

    public function totalBookingAllBranches($status='')
    {
        $this->db->select('room_checkin.id');
        $this->db->from('room_checkin');
        $this->db->where('room_checkin.status',$status);
        $query = $this->db->get();

        return $query->num_rows();   
    }

    public function totalCollectedAllBranches($status='')
    {
        $this->db->select('COALESCE(SUM(room_checkin.total_amt),0) as total');
        $this->db->from('room_checkin');
        $this->db->where('room_checkin.status',$status);
        $query = $this->db->get();

        if ($query->num_rows() > 0) {

            $res = $query->result()[0]->total;
        }

        else{

            $res = "";

        }

        return $res;   
    }

    public function geAllBranchesList()
    {
        $this->db->select('branch.id,branch.branch_name,branch.location,branch.address');
        $this->db->from('branch');
        $this->db->where('branch.status',1);
        $this->db->where('branch.role !=','owner');
        $query = $this->db->get();

        $categories = $query->result();

        $i=0;

        foreach($categories as $p_cat){

            $categories[$i]->room_count = $this->geAllBranchesListSub($p_cat->id);

            $i++;
        }

        return $categories; 

    }


    public function geAllBranchesListSub($id)
    {
        $this->db->select('room.id');
        $this->db->from('room');
        $this->db->where('room.branch_id',$id);
        $query = $this->db->get();

        return $query->num_rows();
    }

    public function geBranchesRoom($branch_id) {

        $this->db->select('room.id');
        $this->db->from('room');
        $this->db->where('room.branch_id',$branch_id);
        //$this->db->where('room_checkin_sub.status',1);
        $query = $this->db->get();

        return $query->num_rows();   
    }

    public function getBookingBranchesWise($branch_id='') {

        $this->db->select('room.id');
        $this->db->from('room_checkin_sub');
        $this->db->join('room', 'room_checkin_sub.selected_room = room.id');
        $this->db->where('room.branch_id',$branch_id);
        $this->db->where('room_checkin_sub.status',1);
        $query = $this->db->get();

        return $query->num_rows();   
    }

    public function getBookingPendingBranchesWise($branch_id='') {

        $date = date("Y-m-d");

        $this->db->select('room.id');
        $this->db->from('room_checkin_sub');
        $this->db->join('room_checkin', 'room_checkin_sub.checkin_id = room_checkin.id');
        $this->db->join('room', 'room_checkin_sub.selected_room = room.id');
        $this->db->where('DATE_FORMAT(room_checkin.check_out_date,"%Y-%m-%d")',$date);
        $this->db->where('room.branch_id',$branch_id);
        $this->db->where('room_checkin_sub.status',1);
        $query = $this->db->get();

        return $query->num_rows();   
    }

    public function getBookingCancelBrancheWise($branch_id='') {

        $date = date("Y-m-d");

        $this->db->select('room.id');
        $this->db->from('room_checkin_sub');
        $this->db->join('room_checkin', 'room_checkin_sub.checkin_id = room_checkin.id');
        $this->db->join('room', 'room_checkin_sub.selected_room = room.id');
        $this->db->where('DATE_FORMAT(room_checkin.check_out_date,"%Y-%m-%d")',$date);
        $this->db->where('room.branch_id',$branch_id);
        $this->db->where('room_checkin_sub.status',0);
        $query = $this->db->get();

        return $query->num_rows();   
    }

    public function getCollectedBranchesWise($branch_id='') {

        $this->db->select('COALESCE(SUM(room_checkin.total_amt),0) as total');
        $this->db->from('room_checkin');
        $this->db->join('room_checkin_sub', 'room_checkin.id = room_checkin_sub.checkin_id');
        $this->db->join('room', 'room_checkin_sub.selected_room = room.id');
        $this->db->where('room.branch_id',$branch_id);
        $this->db->where('room_checkin_sub.status',2);
        $query = $this->db->get();

        if ($query->num_rows() > 0) {

            $res = $query->result()[0]->total;
        }

        else{

            $res = 0;

        }

        return $res;   
    }

    public function getPendingBranchesWise($branch_id='') {

        $this->db->select('COALESCE(SUM(room_checkin.total_amt),0) as total');
        $this->db->from('room_checkin');
        $this->db->join('room_checkin_sub', 'room_checkin.id = room_checkin_sub.checkin_id');
        $this->db->join('room', 'room_checkin_sub.selected_room = room.id');
        $this->db->where('room.branch_id',$branch_id);
        $this->db->where('room_checkin_sub.status',1);
        $query = $this->db->get();

        if ($query->num_rows() > 0) {

            $res = $query->result()[0]->total;
        }

        else{

            $res = 0;

        }

        return $res;   
    }
          
                     
}

?>