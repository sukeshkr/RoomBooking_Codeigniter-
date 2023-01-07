<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php'; //include Rest Controller library

class Room extends REST_Controller {

    public function __construct() { 
        parent::__construct();

        $this->load->model('api/Room_model','model'); //load user model
        $this->load->library('upload');
        $this->load->library('image_lib');
    }

    public function room_post() {

    	$roomData = array();

		$id = $this->post('id');

		$roomData['room_no']  = $this->post('room_no');
        $roomData['branch_id']  = $this->post('branch_id');
        $roomData['room_type_id'] = $this->post('room_type_id');
        $roomData['rate']  = $this->post('rate');
        $roomData['capacity']  = $this->post('capacity');
        $roomData['location']  = $this->post('location');
        $roomData['extra_bed_rate']  = $this->post('extra_bed_rate');
        $roomData['description']  = $this->post('description');

        $facility_id = array();
        $facility_id = json_decode($_POST['facility_id'], true);

        if(!empty($_FILES)) {

            if (!is_dir('uploads/room'))
            {
                mkdir('uploads/room/', 0755, TRUE);
            }

            if($_FILES['upl_files']['name'])
            {

                $number_of_files_uploaded = count($_FILES['upl_files']['name']);

                for ($i = 0; $i < $number_of_files_uploaded; $i++) :

                    $_FILES['userfile']['name']     = $_FILES['upl_files']['name'][$i];
                    $_FILES['userfile']['type']     = $_FILES['upl_files']['type'][$i];
                    $_FILES['userfile']['tmp_name'] = $_FILES['upl_files']['tmp_name'][$i];
                    $_FILES['userfile']['error']    = $_FILES['upl_files']['error'][$i];
                    $_FILES['userfile']['size']     = $_FILES['upl_files']['size'][$i];
                    $config = array(
                    'allowed_types' => '*',
                    'max_size'      => 600000000000,
                    'overwrite'     => FALSE,
                    'upload_path'   => 'uploads/room/',
                    'encrypt_name'  => TRUE,
                    'remove_spaces' =>  TRUE,
                    );
                    $this->upload->initialize($config);

                    if ( ! $this->upload->do_upload()) {

                        $error = array('error' => $this->upload->display_errors());

                        $this->response([
                        'status' => FALSE,
                        'message'=>$error
                        ], REST_Controller::HTTP_OK);

                    }
                    else {
                    $data = $this->upload->data();
                    // Continue processing the uploaded data
                    $multi_images[] = $data['file_name'];

                    $this->load->library('upload', $config);

                    $file_name = $data['file_name'];  
                    $params['gambar'] = $file_name;
                    $config['image_library'] = 'gd2';
                    $config['source_image'] = 'uploads/room/'.$file_name;
                    $config['create_thumb'] = FALSE;
                    $config['maintain_ratio'] = TRUE;
                    $config['width']     = 500;
                    $config['height']   = 500;
                    $config['new_image']        = 'uploads/room/' .$file_name;

                    $this->image_lib->clear();
                    $this->image_lib->initialize($config);
                    $this->image_lib->resize();

                    }

                endfor;
            }
            else{

                $multi_images[] = "";
            }
        }

        else{

             $multi_images[] = "";

        }
      
		if(!empty($roomData['branch_id']) && !empty($roomData['room_type_id']) && !empty($roomData['capacity'])  && !empty($roomData['location']) ) {

    	        $insert = $this->model->insertRoomData($roomData,$multi_images,$facility_id,$id);
    			
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
        $status = $this->post('status');

        if(!empty($id)) {

            $key =$this->model->putRoomDeactivateData($status,$id); 

            $list = $this->model->getRoomDeactivateData($id);  
 
            if($list){

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

            $list = $this->model->getRoomData($id);  
 
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

    public function room_detail_get_post() //Each seller wise with all details
    {
        $id = $this->post('id');

        if(!empty($id)) {

            $room_facility = $this->model->getRoomFacilityData(); 

            $room_type = $this->model->getRoomTypeData(); 

            if($room_facility || $room_type){

                $this->response([
                    'status' => TRUE,
                    'room_facility'=> $room_facility,
                    'room_type'=> $room_type
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
    
    
    public function room_data_get_post() //Each seller wise with all details
    {
        $user_id = $this->post('user_id');

        if(!empty($user_id)) {

            $booking_type = $this->model->getRoomBookingType(); 

            $customer = $this->model->getCustomerData(); 

            if($booking_type || $customer){

                $this->response([
                    'status' => TRUE,
                    'booking_type'=> $booking_type,
                    'customer'=> $customer
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

}

?>