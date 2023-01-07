<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Service extends MY_Auth_Controller {

    public function __construct() {
        parent::__construct();

        $this->load->model('Service_model','model');
        
        if (!$this->is_logged_in()) {

            redirect('Login');
        }
    }

    public function index() {

        $this->load->view('service/list');
    }

    public function type_list(){

        $list = $this->model->get_datatables();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $types) {
        $no++;
        $row = array();
        $row[] = $no;
        $row[] = $types->service_name;      
          
        //add html for action
        $row[] = '<a data-id='.$types->id.' data-toggle="modal" data-target="#view-modal" class="btn  btn-info circle" href="#"><i class="fa fa-eye"></i></a>
        <a href="service/edit/'.$types->id.'" class="btn  btn-warning" href="#"><i class="fa fa-edit" aria-hidden="true"></i></a>
        <a data-toggle="modal" data-id='.$types->id.' data-target="#del-modal" class="btn  btn-danger" href="#"><i class="fa  fa-trash-o" aria-hidden="true"></i></a>';
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

        $this->form_validation->set_rules('service', 'Service', 'trim|required|xss_clean');
        $this->form_validation->set_rules('rate', 'Rate', 'trim|required|xss_clean');


        if ($this->form_validation->run() == FALSE) {
            $this->load->view('service/add');
        } else {

            $this->model->insertData();

            $this->session->set_flashdata('add', 'Added Successfully');
            redirect('service');
        }
    }

    public function view() {
        $id = $this->input->post('rowid');
        $data['service'] = $this->model->viewData($id);
        $this->load->view('service/view', $data);
    }

    public function edit($id) {
        $data['service'] = $this->model->viewData($id);
        $this->load->view('service/edit', $data);
    }

    public function update() {

        if (isset($_POST['submit'])) {

            $id = $this->input->post('id');

            $this->model->updateData($id);
            $this->session->set_flashdata('update', 'Updated Successfully');
            redirect('service');
        }
    }

    public function delete() {

        $this->load->view('service/delete');

        if (isset($_POST['delete'])) {

            $id = $this->input->post('id');
            
            $this->model->delete($id);

            $this->session->set_flashdata('delete', 'Deleted Successfully');
            redirect('service');
        }

    }

   

}
