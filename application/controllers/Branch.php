<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Branch extends MY_Auth_Controller  //extend MY_Auth_Controller from CI_controller in core
{ 

  public function __construct() 
  {
    parent::__construct();
    $this->load->model('Branch_model', 'model');
    $this->load->library('bcrypt');
    if (!$this->is_logged_in()) 
    {
      redirect('login');
    }
  }

    public function index() 
    {
      $data['profile']=$this->model->getBranchesData();
      $this->load->view('branch/view',$data);
    }

    public function create() 
    {
      $this->form_validation->set_rules('branch_name', 'Branch name', 'trim|required|xss_clean');
      $this->form_validation->set_rules('role', 'Role', 'trim|required|xss_clean');
      $this->form_validation->set_rules('userid','User ID','required|callback_exists_email');
      $this->form_validation->set_rules('password','Password','trim|required|xss_clean');
      $this->form_validation->set_rules('location','Location','trim|required|xss_clean');
      $this->form_validation->set_rules('description','Description','trim|required|xss_clean');


      if($this->form_validation->run() == FALSE) 
      {
        $this->load->view('branch/add');
      } 
      else 
      {
        $branch_name = $this->input->post('branch_name');
        $role = $this->input->post('role');
        $userid = $this->input->post('userid');
        $password = $this->input->post('password');
        $hash = $this->bcrypt->hash_password($password);
        $location = $this->input->post('location');
        $description = $this->input->post('description');

        $value = array('location'=> $location,'description'=> $description,'branch_name'=> $branch_name,'role'=>$role,'userid' => $userid,'auth_key' => $hash);
   
        $data['result'] = $this->model->insertBranch($value);
        $this->session->set_flashdata('add', 'Added Successfully');
        redirect('Branch');
      }
    }

    // delete with modal popup
    public function delete() 
    {
      $this->load->view('branch/delete');
      if (isset($_POST['delete'])) 
        {
          $id = $this->input->post('id');
          $this->model->delete($id);
          $this->session->set_flashdata('delete', 'Deleted Successfully');
          redirect('Branch');
        }
    }

    public function edit() {

      $id = $this->uri->segment(3);

      $data['profile']=$this->model->getBranchesData($id);

      $this->load->view('branch/edit', $data);     
    }

    public function update() {

    $this->form_validation->set_rules('branch_name', 'Branch name', 'trim|required|xss_clean');
    $this->form_validation->set_rules('role', 'Role', 'trim|required|xss_clean');
    $this->form_validation->set_rules('userid','User ID','required|xss_clean');
    $this->form_validation->set_rules('password','Password','trim|required|xss_clean');
    $this->form_validation->set_rules('location','Location','trim|required|xss_clean');
    $this->form_validation->set_rules('description','Description','trim|required|xss_clean');

    $id = $this->input->post('id');

    if($this->form_validation->run() == FALSE) 
    {
      
      $data['profile']=$this->model->getBranchesData($id);
      $this->load->view('branch/edit', $data);
    } 
    else 
    {

      $branch_name = $this->input->post('branch_name');
      $role = $this->input->post('role');
      $userid = $this->input->post('userid');
      $password = $this->input->post('password');
      $hash = $this->bcrypt->hash_password($password);

      $location = $this->input->post('location');
      $description = $this->input->post('description');

      $value = array('location'=> $location,'description'=> $description,'branch_name'=> $branch_name,'role'=>$role,'userid' => $userid,'auth_key' => $hash);
   
      $data['result'] = $this->model->updateBranch($value,$id);
      $this->session->set_flashdata('add', 'Added Successfully');
      redirect('branch');

    }
  }

  
    public function changepassword() 
    {
        $this->load->view('branch/change_password');
    }

  //update password function
    public function updatepassword() 
    {
        $currentPassword = $this->input->post('currentPassword');
        $newPassword = $this->input->post('newPassword');
        $hash = $this->bcrypt->hash_password($newPassword);
        $confirmPassword = $this->input->post('confirmPassword');
        $this->form_validation->set_rules('currentPassword', 'Current Password', 'trim|required|callback_currentPasswordCheck');
        $this->form_validation->set_rules('newPassword', 'New Password', 'required|trim');
        $this->form_validation->set_rules('confirmPassword', 'Confirm Password', 'required|trim|matches[newPassword]');
      if ($this->form_validation->run() == FALSE) 
      {
        $this->changepassword();
      } else {
        $this->model->changePasswordDet($hash, $this->userDetails->id);
        $this->session->set_flashdata('changepwd', 'Password Changed Successfully !');
        redirect('User/changePassword');
      }
    }

    //password check either correct or not from callback_currentPasswordCheck
    public function currentPasswordCheck($currentPassword) 
    {

      if (!$this->bcrypt->check_password($currentPassword, $this->userDetails->password) )
      {
        $this->form_validation->set_message('currentPasswordCheck', 'The current password field is wrong');
        return false;
      } else {
        return true;
      }
    }

    #uniqueness of username
    function exists_email($str)
    {
        $value=$this->model->key_exists($str);
      if ($value)
      {
        return TRUE;
      }
      else
      {
        $this->form_validation->set_message('exists_email', 'Email already exists!... Please choose another one');
        return FALSE;
      }
    }


} ?>