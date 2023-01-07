<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Check_out extends MY_Auth_Controller {

    public function __construct() {
        parent::__construct();

        $this->load->model('Check_out_model','model');
        
        if (!$this->is_logged_in()) {

            redirect('Login');
        }
    }

    public function index() {

        $this->load->view('checkout/list');
    }

    public function type_list(){

        $list = $this->model->get_datatables();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $types) {
        $no++;
        $row = array();
        $row[] = $no;
        $row[] = $types->name;
        $row[] = $types->phone;
        $row[] = $types->booking_type_name;      
        $row[] = $types->check_in_date;
        $row[] = $types->check_out_date;
        $row[] = $types->advanced_amt;
        $row[] = $types->total_amt;
          
        //add html for action
        $row[] = '<a data-id='.$types->id.' data-toggle="modal" data-target="#checkout-modal" class="btn btn-info  btn-info circle" href="#">CheckOut</a>
        <a data-id='.$types->id.' data-toggle="modal" data-target="#Extendmodal" class="btn  btn-info circle" href="#"><i class="fa fa-plus"></i>Extend Date</a>
        <a data-id='.$types->id.' data-toggle="modal" data-target="#view-modal" class="btn  btn-info circle" href="#"><i class="fa fa-plus"></i></a>
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
   
    public function ServiceCharge() {

        $id = $this->input->post('rowid');

        $data['checkinid'] = $id;

        $data['service'] = $this->model->getBookingServiceData();

        $data['rooms'] = $this->model->getRoomsData($id);

        $this->load->view('checkout/view', $data);

    }

    public function ExtendCheckin() {

        $id = $this->input->post('rowid');

        $data['checkinid'] = $id;

        $data['rooms'] = $this->model->getCheckinDate($id);

        $this->load->view('checkout/extended_view', $data);

    }

    public function checkOutRoom() {

        $id = $this->input->post('rowid');

        $data['rooms'] = $this->model->getRoomsCheckOutData($id);

        $this->load->view('checkout/check-out', $data);

    }

    public function checkout_put() {

        $user_id = $this->userDetails->id;

        $check_in_id  = $this->input->post('check_in_id');
        $roomData['total_amt']  = $this->input->post('total_amt');
        $roomData['service_amt']  = $this->input->post('service_amt');
        $roomData['payment_type']  = $this->input->post('payment_type');
        $roomData['status']  = 2;

        $list = $this->model->putCheckoutData($roomData,$check_in_id,$user_id);

        $this->session->set_flashdata('add', 'Added Successfully');

        redirect('Check_out');
       
    }

    public function service_put() {

        $check_in_id = $this->input->post('check_in_id');

        $services = $this->input->post('services');

        $qty = $this->input->post('qty');

        $list = $this->model->putServiceData($check_in_id,$services,$qty);

        $this->session->set_flashdata('add', 'Added Successfully');

        redirect('Check_out');
       
    }

    public function extended_put() {

        $check_in_id = $this->input->post('check_in_id');

        $check_out_date = $this->input->post('check_out_date');

        $list = $this->model->putExtendedData($check_in_id,$check_out_date);

        $this->session->set_flashdata('add', 'Added Successfully');

        redirect('Check_out');
       
    }

    public function delete() {

        $this->load->view('check/delete');

        if (isset($_POST['delete'])) {

            $id = $this->input->post('id');
            
            $this->model->delete($id);

            $this->session->set_flashdata('delete', 'Deleted Successfully');
            redirect('Check_in');
        }

    }


   

}
