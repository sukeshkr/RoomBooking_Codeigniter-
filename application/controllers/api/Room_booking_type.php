<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php'; //include Rest Controller library

class Room_booking_type extends REST_Controller {

    public function __construct() { 
        parent::__construct();

        $this->load->library('bcrypt');
        $this->load->model('api/Room_booking_type_model','model'); //load user model
    }

    public function room_booking_type_post() {

    	$roomData = array();

		$id = $this->post('id');

        $roomData['booking_type_name'] = $this->post('booking_type_name');
        $roomData['description'] = $this->post('description');
      
		if(!empty($roomData['booking_type_name']) && !empty($roomData['description'])) {

    	        $insert = $this->model->insertRoomData($roomData,$id);
    			
    			//check if the user data updated
    			if($insert){
    				//set the response and exit
    				$this->response([
    					'status' => TRUE,
    					'message' => 'Booking type has been inserted successfully.'
    				], REST_Controller::HTTP_OK);
    			}else{
    				//set the response and exit
    				$this->response([
    					'status' => TRUE,
    					'message' => 'Something not correct'
    				], REST_Controller::HTTP_OK);
    			}

          

        }else{
			//set the response and exit
            $this->response("Provide complete user information to update.", REST_Controller::HTTP_BAD_REQUEST);
		}
	}

	public function booking_type_deactivate_post() //Each seller wise with all details
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

    public function room_booking_type_get_post() //Each seller wise with all details
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
                    'message' => 'No Data found'
                    ], REST_Controller::HTTP_OK);
            }

        }
        else{
            //set the response and exit
            $this->response("Provide complete feature information to insert.", REST_Controller::HTTP_BAD_REQUEST);
        }
    }
    
    public function booking_type_data_get_post() //Each seller wise with all details
    {
        $id = $this->post('id');

        if(!empty($id)) {

            $list = $this->model->getRoomBookingTypeData($id); 
 
            if($list){

                $this->response([
                    'status' => TRUE,
                    'result'=> $list
                    ], REST_Controller::HTTP_OK);
            }
         
            else{

                $this->response([
                    'status' => TRUE,
                    'message' => 'No Data found'
                    ], REST_Controller::HTTP_OK);
            }

        }
        else{
            //set the response and exit
            $this->response("Provide complete feature information to insert.", REST_Controller::HTTP_BAD_REQUEST);
        }
    }
    
    public function booking_type_details_get_post()  {

        $id = $this->post('id');

        if(!empty($id)) {

            $list = $this->model->getRoomDataDetails($id); 
 
            if($list){

                $this->response([
                    'status' => TRUE,
                    'result'=> $list
                    ], REST_Controller::HTTP_OK);
            }
         
            else{

                $this->response([
                    'status' => TRUE,
                    'message' => 'No Data found'
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