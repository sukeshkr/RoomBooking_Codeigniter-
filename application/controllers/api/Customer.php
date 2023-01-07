<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php'; //include Rest Controller library

class Customer extends REST_Controller {

    public function __construct() { 
        parent::__construct();

        $this->load->library('bcrypt');
        $this->load->model('api/Customer_model','model'); //load user model
        $this->load->library('Image');
    }

    public function customer_post() {

    	$customerData = array();

		$id = $this->post('id');

		$customerData['name']  = $this->post('name');
        $customerData['phone'] = $this->post('phone');
        $customerData['phone1'] = $this->post('phone1');
        $customerData['email'] = $this->post('email');
        $customerData['address'] = $this->post('address');
        $customerData['state'] = $this->post('state');
        $customerData['country'] = $this->post('country');
        $customerData['id_proof_type'] = $this->post('id_proof_type');
        $customerData['id_proof_no'] = $this->post('id_proof_no');
        $customerData['reference'] = $this->post('reference');

        if(!empty($_FILES)) {

            $this->image->customer_image();//call custom image library

            $customerData['prof_image']= $this->image->image_name;

        }
     
		if(!empty($customerData['name']) && !empty($customerData['phone']) && !empty($customerData['address']) && !empty($customerData['id_proof_type']) && !empty($customerData['id_proof_no'])) {

    	        $insert = $this->model->insertCustomerRegister($customerData,$id);
    			
    			//check if the user data updated
    			if($insert){
    				//set the response and exit
    				$this->response([
    					'status' => TRUE,
    					'message' => 'Customer has been inserted successfully.'
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

	public function customer_deactivate_get_post() //Each seller wise with all details
    {
        $id = $this->post('id');
        $status = $this->post('status');

        if(!empty($id)) {

            $key =$this->model->putCustomerDeactivateData($status,$id); 

            $list = $this->model->getCustomerDeactivateData($id);  
 
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

    public function customer_get_post() //Each seller wise with all details
    {
        $id = $this->post('id');

        if(!empty($id)) {

            $list = $this->model->getCustomerData();  
 
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