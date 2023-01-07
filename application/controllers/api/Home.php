<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php'; //include Rest Controller library

class Home extends REST_Controller {

    public function __construct() { 
        parent::__construct();
        $this->load->model('api/Home_model','model'); //load user model
    }

    ///** daily reports **///

    public function get_home_post() {

        $user_id  = $this->post('user_id');

        if(!empty($user_id)) {

            $branch_count = $this->model->geAllBranches();

            $branch_room_count = $this->model->geAllBranchesRoom();

            $branch_booking_count = $this->model->totalBookingAllBranches(2);

            $booking_pending_count = $this->model->totalBookingAllBranches(1);

            $collected_amt = $this->model->totalCollectedAllBranches(2);

            $pending_amt = $this->model->totalCollectedAllBranches(1);

            $branch_list = $this->model->geAllBranchesList();
            
            $available_room = $this->model->getchkRoomAvailability();

            //check if the user data updated
            if($branch_count || $branch_room_count || $branch_booking_count || $branch_list) {

                    //set the response and exit
                    $this->response([
                        'status'   => TRUE,
                        'cur_date' => date("Y-m-d"),
                        'branch_count'   => $branch_count,
                        'branch_room_count'   => $branch_room_count,
                        'branch_booking_count'   => $branch_booking_count,
                        'booking_pending_count'   => $booking_pending_count,
                        'collected_amt'   => $collected_amt,
                        'pending_amt'   => $pending_amt,
                        'available_room'  => $available_room,
                        'branch_list'   => $branch_list
                    ], REST_Controller::HTTP_OK);
            }else{

                //set the response and exit
                $this->response([
                        'status' => TRUE,
                        'message' => 'No row affected'
                    ], REST_Controller::HTTP_OK);
            }
        }
        else{
            //set the response and exit
            $this->response("Provide complete feature information to insert.", REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    public function get_home_branch_post() {

        $branch_id  = $this->post('branch_id');

        if(!empty($branch_id)) {

            $branch_room_count = $this->model->geBranchesRoom($branch_id);

            $branch_booking_count = $this->model->getBookingBranchesWise($branch_id);

            $booking_pending_count = $this->model->getBookingPendingBranchesWise($branch_id);

            $collected_amt = $this->model->getCollectedBranchesWise($branch_id);

            $pending_amt = $this->model->getPendingBranchesWise($branch_id);
            
            $available_room = $this->model->getchkRoomAvailabilityBranchesWise($branch_id);

            //check if the user data updated
            if($branch_room_count || $branch_booking_count || $booking_pending_count) {

                    //set the response and exit
                    $this->response([
                        'status'   => TRUE,
                        'cur_date' => date("Y-m-d"),
                        'branch_room_count'   => $branch_room_count,
                        'branch_booking_count'   => $branch_booking_count,
                        'booking_pending_count'   => $booking_pending_count,
                        'collected_amt'   => $collected_amt,
                        'pending_amt'   => $pending_amt,
                        'available_room'  => $available_room
                    ], REST_Controller::HTTP_OK);
            }else{

                //set the response and exit
                $this->response([
                        'status' => TRUE,
                        'message' => 'No row affected'
                    ], REST_Controller::HTTP_OK);
            }
        }
        else{
            //set the response and exit
            $this->response("Provide complete feature information to insert.", REST_Controller::HTTP_BAD_REQUEST);
        }
    }

}

?>
