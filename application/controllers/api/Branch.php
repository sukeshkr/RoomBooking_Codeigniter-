<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php'; //include Rest Controller library

class Branch extends REST_Controller {

    public function __construct() { 
        parent::__construct();

        $this->load->library('bcrypt');
        $this->load->model('api/Branch_model','model'); //load user model
    }

    public function branch_post() {

    	$branchData = array();

		$id = $this->post('id');

        $id = preg_replace('/\s+/', '', $id);

		$branchData['branch_name']  = $this->post('branch_name');
        $branchData['location'] = $this->post('location');
        $branchData['description'] = $this->post('description');

        $branchData['userid'] = $this->post('userid');

        $password  = $this->post('password');

        $branchData['auth_key'] = $this->bcrypt->hash_password($password);


		if(!empty($branchData['userid']) && !empty($branchData['auth_key']) && !empty($branchData['branch_name']) && !empty($branchData['location'])) {

            $block = $this->model->getCountBranchUser();

            if($block){

    	        $insert = $this->model->insertBranchRegister($branchData,$id);
    			
    			//check if the user data updated
    			if($insert){
    				//set the response and exit
    				$this->response([
    					'status' => TRUE,
    					'message' => 'Branch has been inserted successfully.'
    				], REST_Controller::HTTP_OK);
    			}else{
    				//set the response and exit
    				$this->response([
    					'status' => TRUE,
    					'message' => 'UserId Already registered..please login..'
    				], REST_Controller::HTTP_OK);
    			}

            }

            else{
                //set the response and exit
                $this->response([
                    'status' => TRUE,
                    'message' => 'Branch Creation limit is exeed'
                ], REST_Controller::HTTP_OK);
            }

        }else{
			//set the response and exit
            $this->response("Provide complete user information to update.", REST_Controller::HTTP_BAD_REQUEST);
		}
	}

	public function branch_deactivate_get_post() //Each seller wise with all details
    {
        $id = $this->post('id');
        $status = 0;

        if(!empty($id)) {

            $key =$this->model->putUserDeactivateData($status,$id); 

            $list = $this->model->getUserDeactivateData($id);  
 
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

    public function branches_get_post() //Each seller wise with all details
    {
        $id = $this->post('id');
        
        $type_id = $this->post('type_id');

        if(!empty($id)) {

            $list = $this->model->getBranchesData($type_id);  
 
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
    
    public function get_branches_wise_post() //Each seller wise with all details
    {
        $id = $this->post('id');

        if(!empty($id)) {

            $list = $this->model->getBrancheWiseData($id);  
 
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