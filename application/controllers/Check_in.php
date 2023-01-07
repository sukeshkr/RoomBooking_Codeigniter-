<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Check_in extends MY_Auth_Controller {

    public function __construct() {
        parent::__construct();

        $this->load->model('Check_in_model','model');
        
        if (!$this->is_logged_in()) {

            redirect('Login');
        }
    }

    public function index() {

        $this->load->view('check/list');
    }

    public function type_list() {

        $list = $this->model->get_datatables();

        $data = array();
        $no = $_POST['start'];
        foreach ($list as $types) {

            $check_in_date = date( 'd-M-Y g:i A', strtotime($types->check_in_date));

            $check_out_date = date( 'd-M-Y g:i A', strtotime($types->check_out_date));

            if($types->status==1) {

                $status='<button type="button" class="btn btn-warning">Pending</button>';

            }
            if($types->status==2) {

                $status='<button type="button" class="btn btn-success">Completed</button>';

            }

            if($types->status==0) {

                $status='<button type="button" class="btn btn-danger">Canceled</button>';

            }

            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $types->name;
            $row[] = $types->phone;
            $row[] = $types->booking_type_name;      
            $row[] = $check_in_date;
            $row[] = $check_out_date;
            $row[] = $types->advanced_amt;
            $row[] = $types->total_amt;
            $row[] = $status;
              
            //add html for action
            $row[] = '<a data-id='.$types->id.' data-toggle="modal" data-target="#view-modal" class="btn  btn-info circle" href="#"><i class="fa fa-eye"></i></a>
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

        $this->form_validation->set_rules('customer_id', 'Customer', 'trim|required|xss_clean');
        $this->form_validation->set_rules('booking_type_id', 'booking from', 'trim|required|xss_clean');
        $this->form_validation->set_rules('check_in_date', 'Check In Date', 'trim|required|xss_clean');
        $this->form_validation->set_rules('check_out_date', 'Check Out Date', 'trim|required|xss_clean');
        $this->form_validation->set_rules('booking_id', 'booking Id', 'trim|required|xss_clean');
        $this->form_validation->set_rules('available_id[]', 'Available Room', 'trim|required|xss_clean');
         $this->form_validation->set_rules('total_amount', 'Total Amount', 'trim|required|xss_clean');
          $this->form_validation->set_rules('advanced_amount', 'Advanced Amount', 'trim|required|xss_clean');


        if ($this->form_validation->run() == FALSE) {

            $data['customer'] = $this->model->getCustomerData();

            $data['booking'] = $this->model->getBookingTypeData();

            $data['service'] = $this->model->getBookingServiceData();

            $this->load->view('check/add',$data);

        } else {

            $customer_id = $this->input->post('customer_id');
            $booking_type_id = $this->input->post('booking_type_id');
            $check_in_date = $this->input->post('check_in_date');
            $check_out_date = $this->input->post('check_out_date');
            $booking_id = $this->input->post('booking_id');
            $available_id = $this->input->post('available_id');
            $total_amount = $this->input->post('total_amount');
            $discount_amount = 0;
            $discount_amount = $this->input->post('discount_amount');
            $advanced_amount = $this->input->post('advanced_amount');

            $services = $this->input->post('services');

            $grand = $total_amount - $discount_amount;

            $qty = $this->input->post('qty');

            if($advanced_amount > $grand)
            {

                $data['customer'] = $this->model->getCustomerData();

                $data['booking'] = $this->model->getBookingTypeData();

                $data['service'] = $this->model->getBookingServiceData();

                $data['exceed'] = "Advance amount graterthan total Amount";

                $this->load->view('check/add',$data);

                return false;
            }

            $time = date("G:i:s", time());

            $check_in_date = $check_in_date.' '.$time;

            $check_out_date = $check_out_date.' '.$time;

            $value = array('check_in_date' => $check_in_date,'check_out_date' => $check_out_date,'total_amt' => $total_amount,'discount_amount' => $discount_amount,'advanced_amt' => $advanced_amount,'customer_id' => $customer_id,'booking_type_id' => $booking_type_id,'cur_date' => date("Y-m-d H:i:s"));

            $this->model->insertData($value,$available_id,$services,$qty);

            $this->session->set_flashdata('add', 'Added Successfully');
            redirect('Check_in');
        }
    }
   
    public function view() {

        $id = $this->input->post('rowid');

        $data['rooms'] = $this->model->getRoomsData($id);

        $this->load->view('check/view', $data);

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

    public function getAvailableRoom() {

        $time = date("G:i:s", time());

        $check_in  = $_POST['check_in'].' '.$time;

        $check_out = $_POST['check_out'].' '.$time;

        $branch_id = $this->userDetails->id;

        $list = $this->model->getRoomAvailabilityByDate($branch_id,$check_in,$check_out);

        if($list) {


             echo '<select id="multiselect" multiple="multiple" onchange="getval(this)" class="form-control" name="available_id[]">
             <option value="">Please Select</option>';


            foreach ($list as $key => $row) { 

                if($row->chk_status == 0)
                {

                    echo '<option value="'.$row->id.'">'.$row->room_no.'</option>';

                }
              
            }

            echo '</select>';
        }
        else{

            echo "No room available";
        }

    }

    public function getPriceList() {

        $id=$_POST['rowid'];

        $result = $this->model->getTotalProductPrice($id);

        $sum_list_price = 0;

        foreach ($result as $key => $value) {

            $sum_list_price += $value['rate'];
            
        }

        if($sum_list_price)
        {

            echo $sum_list_price;

        }
        else{

            echo 0;
        }

        
        
    }

   

}
