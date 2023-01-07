<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Daybook extends MY_Auth_Controller {

    public function __construct() {
        parent::__construct();

        $this->load->model('Daybook_model','model');
        
        if (!$this->is_logged_in()) {

            redirect('Login');
        }
    }

    public function index() {

        $this->load->view('daybook/list');
    }

    public function daybook_list() {

        $list = $this->model->get_datatables();

        $data = array();
        $no = $_POST['start'];
        foreach ($list as $rows) {

            if($rows->balance < 1) {

                $status='<button type="button" class="btn btn-success">Completed</button>';

                $modal = '#modal';

            }
            else{

                $status='<button type="button" class="btn btn-warning">Pending</button>';

                $modal = '#payment-modal';

            }

            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $rows->total_amt;
            $row[] = $rows->payment;
            $row[] = $rows->balance;
            $row[] = $rows->date_time;

            $row[] = $status;
              
            //add html for action
            $row[] = '<a data-id='.$rows->id.' data-toggle="modal" data-target='.$modal.' class="btn  btn-info circle" href="#">+ Payment</i></a>
            <a data-id='.$rows->id.' data-toggle="modal" data-target="#view-modal" class="btn  btn-info circle" href="#"><i class="fa fa-eye"></i></a>
           
            <a data-toggle="modal" data-id='.$rows->id.' data-target="#del-modal" class="btn  btn-danger" href="#"><i class="fa  fa-trash-o" aria-hidden="true"></i></a>';
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

        $this->form_validation->set_rules('date', 'Date', 'trim|required|xss_clean');
        $this->form_validation->set_rules('payment_amt', 'Payment amount', 'trim|required|xss_clean');
        $this->form_validation->set_rules('total_amt', 'Total amount', 'trim|required|xss_clean');
        $this->form_validation->set_rules('particular', 'Particular', 'trim|required|xss_clean');

        if ($this->form_validation->run() == FALSE) {

            $this->load->view('daybook/add');

        } else {

            $date = $this->input->post('date');
            $total_amt = $this->input->post('total_amt');
            $payment_amt = $this->input->post('payment_amt');
            $particular = $this->input->post('particular');

            $balance = $total_amt - $payment_amt;

            $user_id = $this->userDetails->id;
          
            if($payment_amt > $total_amt) {

                $data['amt_err'] = "Payment amount Graterthan Total Amount";

                $this->load->view('daybook/add',$data);

                return false;
            }

            $time = date("G:i:s", time());

            $date = $date.' '.$time;

            $value = array('user_id' => $user_id,'total_amt' => $total_amt,'payment' => $payment_amt,'balance' => $balance,'date_time' => $date,'description' => $particular);

            $this->model->insertData($value);

            $this->session->set_flashdata('add', 'Added Successfully');
            redirect('daybook');
        }
    }
   
    public function view() {

        $id = $this->input->post('rowid');

        $data['daybook'] = $this->model->getDaybookData($id);

        $this->load->view('daybook/view', $data);

    }

    public function delete() {

        $this->load->view('daybook/delete');

        if (isset($_POST['delete'])) {

            $id = $this->input->post('id');
            
            $this->model->delete($id);

            $this->session->set_flashdata('delete', 'Deleted Successfully');
            redirect('daybook');
        }

    }

    public function payment() {

        $id = $this->input->post('rowid');

        $data['daybook'] = $this->model->getPaymentDaybookData($id);

        $this->load->view('daybook/payment', $data);

    }

    public function payment_put() {

        $id = $this->input->post('id');

        $total_amt = $this->input->post('total_amt');

        $old_payment = $this->input->post('old_payment');

        $payment = $this->input->post('payment');

        $sub_payment = $old_payment + $payment;

        $balance = $total_amt - $sub_payment;

        $value = array('payment' => $sub_payment,'balance' => $balance);

        $this->model->updatPaymentData($id,$value);

        $this->session->set_flashdata('add', 'Added Successfully');

        redirect('daybook');
       
    }

}
