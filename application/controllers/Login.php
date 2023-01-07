<?php defined('BASEPATH') OR exit('No direct script access allowed');



class Login extends MY_controller {



    public function __construct() {

        parent::__construct();

        $this->load->library('bcrypt');

        $this->load->model('Auth_model', 'model');

    }



    public function index(){ 

	    $this->do_login();

    }



    public function do_login() 

    {

    	$this->form_validation->set_rules('user_id', 'UserID', 'trim|required|xss_clean');

        $this->form_validation->set_rules('password', 'Password', 'trim|required|xss_clean');

        

        if ($this->form_validation->run() == FALSE) {

            $this->load->view('auth/login');

        } 

        else 

        {

		    $user_id    =  $this->input->post('user_id');

	      	$password =  $this->input->post('password');

	        $hash = $this->bcrypt->hash_password($password);

	        $res = $this->model->loginWithCredentials($user_id);

	        $db_password=$res->auth_key;

	        $db_userid=$res->userid;

	        

			if (($this->bcrypt->check_password($password, $db_password)) && ($user_id==$db_userid))

			{

				$this->session->set_userdata('userDetails', $res);

			    redirect('/home');

			}

			else

			{

				$this->session->set_flashdata('msg','<div class="alert-danger text-center">Username or Password are incorrect</div>');

			    redirect('/Login');

		}

	    }

	}



	public function logout()  //logout

    { 

        $this->session->sess_destroy();

        $this->session->set_flashdata('msg', 'Successfully logged out');

        redirect('/Login');

    }

}

