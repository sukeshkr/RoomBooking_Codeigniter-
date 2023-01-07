<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends MY_Auth_Controller {

    public function __construct() {
        parent::__construct();

        $this->load->model('Home_model','model');
        
        if (!$this->is_logged_in()) {

            redirect('Login');
        }
    }

    public function index() {

        if($this->userDetails->role == 'super_admin')
        {

            $this->get_home();

        }
        else{

            $this->get_home_branch();

        }


    }

    public function get_home() {

        $data['branch_count'] = $this->model->geAllBranches();

        $data['branch_room_count'] = $this->model->geAllBranchesRoom();

        $data['branch_booking_count'] = $this->model->totalBookingAllBranches(2);

        $data['booking_pending_count'] = $this->model->totalBookingAllBranches(1);

        $data['booking_cancel_count'] = $this->model->totalBookingAllBranches(0);

        $data['collected_amt'] = $this->model->totalCollectedAllBranches(2);

        $data['pending_amt'] = $this->model->totalCollectedAllBranches(1);

        $data['branch_list'] = $this->model->geAllBranchesList();
        
        $data['available_room'] = $this->model->getchkRoomAvailability();

        $this->load->view('index.php',$data);
      
    }

    public function get_home_branch() {

        $branch_id  = $this->userDetails->id;

        $data['branch_count'] = $this->userDetails->branch_name;

        $data['branch_room_count'] = $this->model->geBranchesRoom($branch_id);

        $data['branch_booking_count'] = $this->model->getBookingBranchesWise($branch_id);

        $data['booking_pending_count'] = $this->model->getBookingPendingBranchesWise($branch_id);

        $data['booking_cancel_count'] = $this->model->getBookingCancelBrancheWise($branch_id);

        $data['collected_amt'] = $this->model->getCollectedBranchesWise($branch_id);

        $data['pending_amt'] = $this->model->getPendingBranchesWise($branch_id);
            
        $data['available_room'] = $this->model->getchkRoomAvailabilityBranchesWise($branch_id);

        $this->load->view('index.php',$data);
        
    }

}
