<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php'; //include Rest Controller library

class Room_checkin extends REST_Controller {

    public function __construct() { 
        parent::__construct();

        $this->load->model('api/Room_checkin_model','model'); //load user model
    }

    public function room_checkin_post() {

    	$roomData = array();

		$id = $this->post('id');
		
		$roomData['cur_date']  = date('Y-m-d G:i:s', time());

        $roomData['check_in_date']  = $this->post('check_in_date');
		$roomData['check_out_date']  = $this->post('check_out_date');
        $roomData['customer_id'] = $this->post('customer_id');
        $roomData['booking_type_id']  = $this->post('booking_type_id');
        $roomData['advanced_amt']  = $this->post('advanced_amt');
        $roomData['total_amt']  = $this->post('total_amt');
        $roomData['description']  = $this->post('description');

        $selected_room = array();
        $selected_room = json_decode($_POST['selected_room'], true);
      
		if(!empty($roomData['check_in_date']) && !empty($roomData['check_out_date']) && !empty($roomData['customer_id'])) {

            $chk_exist = $this->model->chkRoomAvailability($selected_room,$roomData['check_in_date'],$roomData['check_out_date']);

            if(empty($chk_exist)) {

    	        $insert = $this->model->insertRoomCheckinData($roomData,$selected_room,$id);
    			
    			//check if the user data updated
    			if($insert){
    				//set the response and exit
    				$this->response([
    					'status' => TRUE,
    					'message' => 'Room has been booked successfully.'
    				], REST_Controller::HTTP_OK);
    			}else{
    				//set the response and exit
    				$this->response([
    					'status' => TRUE,
    					'message' => 'Something went wrong'
    				], REST_Controller::HTTP_OK);
    			}

            }

            else{

                $this->response([
                        'status' => False,
                        'result'=> $chk_exist,
                        'message' => 'Customer Booking is pending...'
                    ], REST_Controller::HTTP_OK);

            }

          
        }else{
			//set the response and exit
            $this->response("Provide complete user information to update.", REST_Controller::HTTP_BAD_REQUEST);
		}
	}

	public function room_checkin_status_post() //Each seller wise with all details
    {
        $id = $this->post('id');
        $status = $this->post('status');

        if(!empty($id)) {

            $key =$this->model->putRoomDeactivateData($status,$id); 

            $list = $this->model->getRoomDeactivateData($id);  
 
            if($key){

                $this->response([
                    'status' => TRUE,
                    'result'=> $list
                    ], REST_Controller::HTTP_OK);
            }
         
            else{

                $this->response([
                    'status' => TRUE,
                    'message' => 'No data found'
                    ], REST_Controller::HTTP_OK);
            }

        }
        else{
            //set the response and exit
            $this->response("Provide complete feature information to insert.", REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    public function room_checkin_get_post() //Each seller wise with all details
    {
        $id = $this->post('id');

        if(!empty($id)) {

            $list = $this->model->getRoomData();  
 
            if($list){

                $this->response([
                    'status' => TRUE,
                    'result'=> $list
                    ], REST_Controller::HTTP_OK);
            }
         
            else{

                $this->response([
                    'status' => TRUE,
                    'message' => 'No branch found'
                    ], REST_Controller::HTTP_OK);
            }

        }
        else{
            //set the response and exit
            $this->response("Provide complete feature information to insert.", REST_Controller::HTTP_BAD_REQUEST);
        }
    }
    
    public function room_availability_get_post() //Home page data details
    {
        $branch_id = $this->post('branch_id');

        $start_date = $this->post('start_date');

        $end_date = $this->post('end_date');

        if(!empty($branch_id) && !empty($start_date) && !empty($end_date)) {

            $list = $this->model->getRoomAvailabilityByDate($branch_id,$start_date,$end_date);

            if($list) {

                $this->response([
                    'status' => TRUE,
                    'result'=> $list
                    ], REST_Controller::HTTP_OK);
            }
     
            else{

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
    
    public function pending_checkout_list_post() //Home page data details
    {
        $user_id = $this->post('user_id');
        
        $date = $this->post('date');

        if(!empty($user_id) && !empty($date)) {

            $list = $this->model->getRoomCheckoutPendingData($user_id,$date);

            if($list) {

                $this->response([
                    'status' => TRUE,
                    'result'=> $list
                    ], REST_Controller::HTTP_OK);
            }
     
            else{

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
    
    public function checkout_put_post() {

        $user_id = $this->post('user_id');

        $check_in_id  = $this->post('check_in_id');
        $roomData['total_amt']  = $this->post('total_amt');
        $roomData['status']  = 2;

        if(!empty($user_id) && !empty($check_in_id)) {

            $list = $this->model->putCheckoutData($roomData,$check_in_id,$user_id);

            if($list) {

                $this->response([
                    'status' => TRUE,
                    'message'=> "sucessfully checked out"
                    ], REST_Controller::HTTP_OK);
            }
     
            else{

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
    
    public function pending_checkout_get_post() //Home page data details
    {
        $user_id = $this->post('user_id');
        
        if(!empty($user_id)) {

            $list = $this->model->getRoomCheckoutPendingget($user_id);

            if($list) {

                $this->response([
                    'status' => TRUE,
                    'result'=> $list
                    ], REST_Controller::HTTP_OK);
            }
     
            else{

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