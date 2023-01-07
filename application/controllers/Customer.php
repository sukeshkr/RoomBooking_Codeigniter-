<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Customer extends MY_Auth_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Customer_model','model');
        $this->load->library('Image');//custom image library to crop
        
        if (!$this->is_logged_in()) {
            redirect('Login');
        }
    }

    public function index() {

        $this->load->view('customer/list');
    }

    public function customer_list(){

        $list = $this->model->get_datatables();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $customer) {
        $no++;
        $row = array();
        $row[] = $no;
        $row[] = $customer->name;
        $row[] = $customer->phone;
        $row[] = $customer->location;
        $row[] = $customer->id_proof_type;
        $row[] = $customer->id_proof_no;
        $row[] = '<img src="'.CUSTOM_BASE_URL.'uploads/customer/'.$customer->prof_image.'" class="img-responsive" height=60 width=80 /></a>';
          
        //add html for action
        $row[] = '<a data-id='.$customer->id.' data-toggle="modal" data-target="#view-modal" class="btn  btn-info circle" href="#"><i class="fa fa-eye"></i></a>
        <a href="customer/edit/'.$customer->id.'" class="btn  btn-warning" href="#"><i class="fa fa-edit" aria-hidden="true"></i></a>
        <a data-toggle="modal" data-id='.$customer->id.' data-name='.$customer->prof_image.' data-target="#del-modal" class="btn  btn-danger" href="#"><i class="fa  fa-trash-o" aria-hidden="true"></i></a>';
        $data[] = $row;
        }
        $output = array(
        "draw" => $_POST['draw'],
        "recordsTotal" => $this->model->count_all(),
        "recordsFiltered" => $this->model->count_filtered(),
        "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }
   
   
     

    public function create() {

        $this->form_validation->set_rules('name', 'Name', 'trim|required|xss_clean');
        $this->form_validation->set_rules('address', 'Address', 'trim|required|xss_clean');
        $this->form_validation->set_rules('phone', 'Phone', 'trim|required|xss_clean');
        $this->form_validation->set_rules('id_proof_type', 'ID Proof Type', 'trim|required|xss_clean');
        $this->form_validation->set_rules('id_proof_no', 'ID Proof No', 'trim|required|xss_clean');


        if (empty($_FILES['image_file']['name'])){

            $this->form_validation->set_rules('image_file', 'Image', 'required');
        }


        if ($this->form_validation->run() == FALSE) {
            $this->load->view('customer/add');
        } else {

            $this->image->imageCropAdd();//call custom image library

            $image= $this->image->crop_image_name;

            $name = $this->input->post('name');
            $address = $this->input->post('address');
            $phone = $this->input->post('phone');
            $alternate_phone = $this->input->post('alternate_phone');
            $email = $this->input->post('email');
            $location = $this->input->post('location');
            $state = $this->input->post('state');
            $country = $this->input->post('country');
            $id_proof_type = $this->input->post('id_proof_type');
            $id_proof_no = $this->input->post('id_proof_no');
            $reference = $this->input->post('reference');

            $value = array('name' => $name,'address' => $address,'phone' => $phone, 'phone1' => $alternate_phone,'email'=>$email,'location'=>$location,'state'=>$state,'country'=>$country,'id_proof_type'=>$id_proof_type,'id_proof_no'=>$id_proof_no,'reference'=>$reference,'prof_image'=>$image);

            $this->model->insertCustomerData($value);
            $this->session->set_flashdata('add', 'Added Successfully');
            redirect('customer');
        }
    }

    public function view() {
        $id = $this->input->post('rowid');
        $data['customer'] = $this->model->viewData($id);
        $this->load->view('customer/view', $data);
    }

    public function edit($id) {
        $data['customer'] = $this->model->viewData($id);
        $this->load->view('customer/edit', $data);
    }

    public function update() {

        if (isset($_POST['submit'])) {

            $id = $this->input->post('id');
            $this->image->imageCropAdd();//call custom image library

            if($_FILES['image_file']['name'])//if there is image and pdf is null
            {
                $image =  $this->image->crop_image_name;

            } 
            else{
                $image =  "";

            }

            $name = $this->input->post('name');
            $address = $this->input->post('address');
            $phone = $this->input->post('phone');
            $alternate_phone = $this->input->post('alternate_phone');
            $email = $this->input->post('email');
            $location = $this->input->post('location');
            $state = $this->input->post('state');
            $country = $this->input->post('country');
            $id_proof_type = $this->input->post('id_proof_type');
            $id_proof_no = $this->input->post('id_proof_no');
            $reference = $this->input->post('reference');

            if($image !="") {

                 $value = array('name' => $name,'address' => $address,'phone' => $phone, 'phone1' => $alternate_phone,'email'=>$email,'location'=>$location,'state'=>$state,'country'=>$country,'id_proof_type'=>$id_proof_type,'id_proof_no'=>$id_proof_no,'reference'=>$reference,'prof_image'=>$image);

            }     
            else {

                $value = array('name' => $name,'address' => $address,'phone' => $phone, 'phone1' => $alternate_phone,'email'=>$email,'location'=>$location,'state'=>$state,'country'=>$country,'id_proof_type'=>$id_proof_type,'id_proof_no'=>$id_proof_no,'reference'=>$reference);
            }

            $this->model->updateCustomer($id,$value);
            $this->session->set_flashdata('update', 'Updated Successfully');
            redirect('customer');
        }
    }

    public function delete() {
        $this->load->view('customer/delete');
        if (isset($_POST['delete'])) {
            $id = $this->input->post('id');
            $name = $this->input->post('name');
            $this->model->delete($id,$name);
            $this->session->set_flashdata('delete', 'Deleted Successfully');
            redirect('customer');
        }
    }

   

}
