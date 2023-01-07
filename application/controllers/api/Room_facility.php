<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php'; //include Rest Controller library

class Room_facility extends REST_Controller {

    public function __construct() { 
        parent::__construct();

        $this->load->model('api/Room_facility_model','model'); //load user model
    }

    public function room_post() {

    	$roomData = array();

		$id = $this->post('id');

        $roomData['facility'] = $this->post('facility');
        $roomData['description'] = $this->post('description');
      
		if(!empty($roomData['facility']) && !empty($roomData['description']) ) {

    	        $insert = $this->model->insertRoomData($roomData,$id);
    			
    			//check if the user data updated
    			if($insert){
    				//set the response and exit
    				$this->response([
    					'status' => TRUE,
    					'message' => 'Room has been inserted successfully.'
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

	public function room_deactivate_get_post() //Each seller wise with all details
    {
        $id = $this->post('id');

        if(!empty($id)) {

            $key =$this->model->deleteRoomDeactivateData($id); 

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

    public function room_get_post() //Each seller wise with all details
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

}

?>