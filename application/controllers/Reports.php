<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/tcpdf/tcpdf.php'; //include Rest Controller library

class Reports extends MY_Auth_Controller {

    public function __construct() { 
        parent::__construct();

        $this->load->model('Reports_model','model'); //load user model
    }

    public function checkin() { 

        $this->form_validation->set_rules('from', 'From Date', 'trim|required|xss_clean');
        $this->form_validation->set_rules('to', 'To Date', 'trim|required|xss_clean');
   
        if ($this->form_validation->run() == FALSE) {

            $this->load->view('reports/checkin');

        } else {

            $from = $this->input->post('from');
            $to = $this->input->post('to');

            $user_id  = $this->userDetails->id;

            $date_from = date("d-F-Y", strtotime($from));

            $date_to = date("d-F-Y", strtotime($to));

            if(!empty($user_id)) {

                $user_name = $this->model->getUserName($user_id);

                $result = $this->model->getCheckInData($user_id,$from,$to);

                $output = '';  

                $no = '';

                $total_advanced_amt = 0;

                $total_total_amt = 0;

                $total_service_amt = 0;
            
                $grand_amt = 0;
             
                foreach($result as $row) {

                    $total_advanced_amt += $row->advanced_amt;

                    $total_service_amt += $row->service_amt;

                    $total_total_amt += $row->total_amt;

                    $grand_amt += $total_total_amt + $total_service_amt;

                    $grand = $row->total_amt + $row->service_amt.'.00';

                    $no++;

                    $output .= 

                    '<tr align="justify">  
                        <td>'.$no.'</td>  
                        <td>'.$row->name.'</td>  
                        <td>'.$row->booking_type_name.'</td>  
                        <td>'.date("d-F-Y h:i:sa", strtotime($row->check_in_date)).'</td> 
                        <td>'.date("d-F-Y h:i:sa", strtotime($row->check_out_date)).'</td>
                        <td>'.$row->advanced_amt.'</td>
                        <td>'.$row->service_amt.'</td>
                        <td>'.$grand.'</td>                     
                    </tr>'; 

                     }

                    $output .= 

                        '<tr align="justify">  
                            <td width="100%" colspan="2">Total Advance    = '.$total_advanced_amt.'</td>                     
                        </tr>
                        <tr>  
                            <td width="100%" colspan="2">Total Service  = '.$total_service_amt.'</td>                     
                        </tr>
                         <tr>  
                            <td width="100%" colspan="2">Grand Total  = '.$grand_amt.'</td>                     
                        </tr>';  
 
                $obj_pdf = new TCPDF('P', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);  
                $obj_pdf->SetCreator(PDF_CREATOR);  
                $obj_pdf->SetTitle("Export HTML Table data to PDF using TCPDF in PHP");  
                $obj_pdf->SetHeaderData('', '', PDF_HEADER_TITLE, PDF_HEADER_STRING);  
                $obj_pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));  
                $obj_pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));  
                $obj_pdf->SetDefaultMonospacedFont('helvetica');  
                $obj_pdf->SetFooterMargin(PDF_MARGIN_FOOTER);  
                $obj_pdf->SetMargins(PDF_MARGIN_LEFT, '5', PDF_MARGIN_RIGHT);  
                $obj_pdf->setPrintHeader(false);  
                $obj_pdf->setPrintFooter(false);  
                $obj_pdf->SetAutoPageBreak(TRUE, 10);  
                $obj_pdf->SetFont('helvetica', '', 12);  
                $obj_pdf->AddPage();  
                $content = '';  
                $content .= '

               <h3 align="center">Checkin Date Wise Report </h3><hr>
                <p align="center"><b>From:</b> '.$date_from.' <b>- To:</b> '.$date_to.' </p> 
                <p align="center"><b>Branch Name:</b> '.$user_name.' </p><br /> 
                <table border="1" cellspacing="0" cellpadding="5">  
                   <tr align="justify">  
                        <th width="5%">Slno</th>  
                        <th width="15%">Customer</th>  
                        <th width="11%">Booking Type</th>  
                        <th width="18%">Checkin Date</th>
                        <th width="18%">Checkout Date</th>
                        <th width="11%">Advance Rs</th>
                        <th width="11%">Service Rs</th>
                        <th width="11%">Total Rs</th> 
                   </tr>
                   
              ';  
              $content .= $output;  
              $content .= '</table>';  
              $obj_pdf->writeHTML($content);  
              $name=rand(10,100);
              $obj_pdf->Output($name.'.pdf', 'I');    


            }
            else{
                //set the response and exit
                $this->response("Provide complete feature information to insert.", REST_Controller::HTTP_BAD_REQUEST);
            }

        }
    }

    public function checkout() { 

        $this->form_validation->set_rules('from', 'From Date', 'trim|required|xss_clean');
        $this->form_validation->set_rules('to', 'To Date', 'trim|required|xss_clean');
   
        if ($this->form_validation->run() == FALSE) {

            $this->load->view('reports/checkout');

        } else {

            $from = $this->input->post('from');
            $to = $this->input->post('to');

            $user_id  = $this->userDetails->id;

            $date_from = date("d-F-Y", strtotime($from));

            $date_to = date("d-F-Y", strtotime($to));

            if(!empty($user_id)) {

                $user_name = $this->model->getUserName($user_id);

                $result = $this->model->getCheckOutData($user_id,$from,$to);

                $output = '';  

                $no = '';

                $total_advanced_amt = 0;

                $total_service_amt = 0;
            
                $grand_amt = 0;
             
                foreach($result as $row) {

                    $total_advanced_amt += $row->advanced_amt;

                    $total_service_amt += $row->service_amt;

                    $total_total_amt += $row->total_amt;

                    $grand_amt += $total_total_amt + $total_service_amt;

                    $grand = $row->total_amt + $row->service_amt.'.00';

                    $no++;

                    $output .= 

                    '<tr align="justify">  
                        <td>'.$no.'</td>  
                        <td>'.$row->name.'</td>  
                        <td>'.$row->booking_type_name.'</td>  
                        <td>'.date("d-F-Y h:i:sa", strtotime($row->check_in_date)).'</td> 
                        <td>'.date("d-F-Y h:i:sa", strtotime($row->check_out_date)).'</td>
                        <td>'.$row->advanced_amt.'</td>
                        <td>'.$row->service_amt.'</td>
                        <td>'.$grand.'</td>                     
                    </tr>'; 

                     }

                    $output .= 

                        '<tr align="justify">  
                            <td width="100%" colspan="2">Total Advance    = '.$total_advanced_amt.'</td>                     
                        </tr>
                        <tr>  
                            <td width="100%" colspan="2">Total Service  = '.$total_service_amt.'</td>                     
                        </tr>
                         <tr>  
                            <td width="100%" colspan="2">Grand Total  = '.$grand_amt.'</td>                     
                        </tr>';  
 
                $obj_pdf = new TCPDF('P', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);  
                $obj_pdf->SetCreator(PDF_CREATOR);  
                $obj_pdf->SetTitle("Export HTML Table data to PDF using TCPDF in PHP");  
                $obj_pdf->SetHeaderData('', '', PDF_HEADER_TITLE, PDF_HEADER_STRING);  
                $obj_pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));  
                $obj_pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));  
                $obj_pdf->SetDefaultMonospacedFont('helvetica');  
                $obj_pdf->SetFooterMargin(PDF_MARGIN_FOOTER);  
                $obj_pdf->SetMargins(PDF_MARGIN_LEFT, '5', PDF_MARGIN_RIGHT);  
                $obj_pdf->setPrintHeader(false);  
                $obj_pdf->setPrintFooter(false);  
                $obj_pdf->SetAutoPageBreak(TRUE, 10);  
                $obj_pdf->SetFont('helvetica', '', 12);  
                $obj_pdf->AddPage();  
                $content = '';  
                $content .= '

               <h3 align="center">Checkin Date Wise Report </h3><hr>
                <p align="center"><b>From:</b> '.$date_from.' <b>- To:</b> '.$date_to.' </p> 
                <p align="center"><b>Branch Name:</b> '.$user_name.' </p><br /> 
                <table border="1" cellspacing="0" cellpadding="5">  
                   <tr align="justify">  
                        <th width="5%">Slno</th>  
                        <th width="15%">Customer</th>  
                        <th width="11%">Booking Type</th>  
                        <th width="18%">Checkin Date</th>
                        <th width="18%">Checkout Date</th>
                        <th width="11%">Advance Rs</th>
                        <th width="11%">Service Rs</th>
                        <th width="11%">Total Rs</th> 
                   </tr>
                   
              ';  
              $content .= $output;  
              $content .= '</table>';  
              $obj_pdf->writeHTML($content);  
              $name=rand(10,100);
              $obj_pdf->Output($name.'.pdf', 'I');    


            }
            else{
                //set the response and exit
                $this->response("Provide complete feature information to insert.", REST_Controller::HTTP_BAD_REQUEST);
            }

        }
    }

    public function customers() { 

        $this->form_validation->set_rules('from', 'From Date', 'trim|required|xss_clean');
        $this->form_validation->set_rules('to', 'To Date', 'trim|required|xss_clean');
   
        if ($this->form_validation->run() == FALSE) {

            $this->load->view('reports/customers');

        } else {

            $from = $this->input->post('from');
            $to = $this->input->post('to');

            $user_id  = $this->userDetails->id;

            $date_from = date("d-F-Y", strtotime($from));

            $date_to = date("d-F-Y", strtotime($to));

            if(!empty($user_id)) {

                $user_name = $this->model->getUserName($user_id);

                $result = $this->model->getCustomerData($user_id,$from,$to);

                $output = '';  

                $no = '';

                foreach($result as $row) {

                    $no++;

                    $output .= 

                    '<tr align="justify">  
                        <td>'.$no.'</td>  
                        <td>'.$row->name.'</td>  
                        <td>'.$row->phone.'</td>  
                        <td>'.$row->location.'</td>
                        <td>'.$row->id_proof_type.'</td>
                        <td>'.$row->id_proof_no.'</td>  
                        <td>'.$row->state.'</td>                    
                    </tr>'; 

                     }
 
                $obj_pdf = new TCPDF('P', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);  
                $obj_pdf->SetCreator(PDF_CREATOR);  
                $obj_pdf->SetTitle("Export HTML Table data to PDF using TCPDF in PHP");  
                $obj_pdf->SetHeaderData('', '', PDF_HEADER_TITLE, PDF_HEADER_STRING);  
                $obj_pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));  
                $obj_pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));  
                $obj_pdf->SetDefaultMonospacedFont('helvetica');  
                $obj_pdf->SetFooterMargin(PDF_MARGIN_FOOTER);  
                $obj_pdf->SetMargins(PDF_MARGIN_LEFT, '5', PDF_MARGIN_RIGHT);  
                $obj_pdf->setPrintHeader(false);  
                $obj_pdf->setPrintFooter(false);  
                $obj_pdf->SetAutoPageBreak(TRUE, 10);  
                $obj_pdf->SetFont('helvetica', '', 12);  
                $obj_pdf->AddPage();  
                $content = '';  
                $content .= '

               <h3 align="center">Customer Wise Report </h3><hr>
                <p align="center"><b>From:</b> '.$date_from.' <b>- To:</b> '.$date_to.' </p> 
                <p align="center"><b>Branch Name:</b> '.$user_name.' </p><br /> 
                <table border="1" cellspacing="0" cellpadding="5">  
                   <tr align="justify">  
                        <th width="5%">Slno</th>  
                        <th width="20%">Name</th>  
                        <th width="20%">Phone</th>  
                        <th width="20%">Location</th>
                        <th width="10%">ID Proof Type</th>
                        <th width="10%">ID Proof No.</th>
                        <th width="15%">State</th> 
                   </tr>
                   
              ';  
              $content .= $output;  
              $content .= '</table>';  
              $obj_pdf->writeHTML($content);  
              $name=rand(10,100);
              $obj_pdf->Output($name.'.pdf', 'I');    


            }
            else{
                //set the response and exit
                $this->response("Provide complete feature information to insert.", REST_Controller::HTTP_BAD_REQUEST);
            }

        }
    } 

    public function booking_type() { 

        $this->form_validation->set_rules('from', 'From Date', 'trim|required|xss_clean');
        $this->form_validation->set_rules('to', 'To Date', 'trim|required|xss_clean');
   
        if ($this->form_validation->run() == FALSE) {

            $data['booking'] = $this->model->BookingTypeGet();

            $this->load->view('reports/booking_type',$data);

        } else {

            $from = $this->input->post('from');
            $to = $this->input->post('to');

            $booking_type_id = $this->input->post('booking_type_id');

            $user_id  = $this->userDetails->id;

            $date_from = date("d-F-Y", strtotime($from));

            $date_to = date("d-F-Y", strtotime($to));

            if(!empty($user_id)) {

                $user_name = $this->model->getUserName($user_id);

                $result = $this->model->getBookingTypeData($user_id,$from,$to,$booking_type_id);

                $output = '';  

                $no = '';

                $total_advanced_amt = 0;

                $total_service_amt = 0;
            
                $grand_amt = 0;

                $total_total_amt =0;
             
                foreach($result as $row) {

                    $total_advanced_amt += $row->advanced_amt;

                    $total_service_amt += $row->service_amt;

                    $total_total_amt += $row->total_amt;

                    $grand_amt += $total_total_amt + $total_service_amt;

                    $grand = $row->total_amt + $row->service_amt.'.00';

                    $no++;

                    $output .= 

                    '<tr align="justify">  
                        <td>'.$no.'</td>  
                        <td>'.$row->booking_type_name.'</td>  
                        <td>'.date("d-F-Y h:i:sa", strtotime($row->check_in_date)).'</td> 
                        <td>'.date("d-F-Y h:i:sa", strtotime($row->check_out_date)).'</td>
                        <td>'.$row->advanced_amt.'</td>
                        <td>'.$row->service_amt.'</td>
                        <td>'.$grand.'</td>                     
                    </tr>'; 

                     }

                    $output .= 

                        '<tr align="justify">  
                            <td width="100%" colspan="2">Total Advance    = '.$total_advanced_amt.'</td>                     
                        </tr>
                        <tr>  
                            <td width="100%" colspan="2">Total Service  = '.$total_service_amt.'</td>                     
                        </tr>
                         <tr>  
                            <td width="100%" colspan="2">Grand Total  = '.$grand_amt.'</td>                     
                        </tr>';  
 
                $obj_pdf = new TCPDF('P', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);  
                $obj_pdf->SetCreator(PDF_CREATOR);  
                $obj_pdf->SetTitle("Export HTML Table data to PDF using TCPDF in PHP");  
                $obj_pdf->SetHeaderData('', '', PDF_HEADER_TITLE, PDF_HEADER_STRING);  
                $obj_pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));  
                $obj_pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));  
                $obj_pdf->SetDefaultMonospacedFont('helvetica');  
                $obj_pdf->SetFooterMargin(PDF_MARGIN_FOOTER);  
                $obj_pdf->SetMargins(PDF_MARGIN_LEFT, '5', PDF_MARGIN_RIGHT);  
                $obj_pdf->setPrintHeader(false);  
                $obj_pdf->setPrintFooter(false);  
                $obj_pdf->SetAutoPageBreak(TRUE, 10);  
                $obj_pdf->SetFont('helvetica', '', 12);  
                $obj_pdf->AddPage();  
                $content = '';  
                $content .= '

               <h3 align="center">Booking Type Wise Report </h3><hr>
                <p align="center"><b>From:</b> '.$date_from.' <b>- To:</b> '.$date_to.' </p> 
                <p align="center"><b>Branch Name:</b> '.$user_name.' </p><br /> 
                <table border="1" cellspacing="0" cellpadding="5">  
                   <tr align="justify">  
                        <th width="5%">Slno</th>  
                        <th width="20%">Booking Type</th>  
                        <th width="20%">Checkin Date</th>
                        <th width="20%">Checkout Date</th>
                        <th width="10%">Advance Rs</th>
                        <th width="10%">Service Rs</th>
                        <th width="15%">Total Rs</th> 
                   </tr>
                   
              ';  
              $content .= $output;  
              $content .= '</table>';  
              $obj_pdf->writeHTML($content);  
              $name=rand(10,100);
              $obj_pdf->Output($name.'.pdf', 'I');    


            }
            else{
                //set the response and exit
                $this->response("Provide complete feature information to insert.", REST_Controller::HTTP_BAD_REQUEST);
            }

        }
    }

    public function day_book() { 

        $this->form_validation->set_rules('from', 'From Date', 'trim|required|xss_clean');
        $this->form_validation->set_rules('to', 'To Date', 'trim|required|xss_clean');
   
        if ($this->form_validation->run() == FALSE) {

            $this->load->view('reports/day_book.php');

        } else {

            $from = $this->input->post('from');
            $to = $this->input->post('to');

            $user_id  = $this->userDetails->id;

            $date_from = date("d-F-Y", strtotime($from));

            $date_to = date("d-F-Y", strtotime($to));

            if(!empty($user_id)) {

                $user_name = $this->model->getUserName($user_id);

                $result = $this->model->getDayBookData($user_id,$from,$to);

                $output = '';  

                $no = '';

                $total_amt = 0;

                $total_payment = 0;
            
                $total_balance =0;
             
                foreach($result as $row) {

                    $total_amt += $row->total_amt;

                    $total_payment += $row->payment;

                    $total_balance += $row->balance;

                    $description = mb_strimwidth($row->description, 0, 60, "...");

                    $no++;

                    $output .= 

                    '<tr align="justify">  
                        <td>'.$no.'</td>  
                        <td>'.date("d-F-Y", strtotime($row->date_time)).'</td> 
                        <td>'.$row->total_amt.'</td>
                        <td>'.$row->payment.'</td>
                        <td>'.$row->balance.'</td>
                        <td>'.$description.'</td>                    
                    </tr>'; 

                     }

                    $output .= 

                        '<tr align="justify">  
                            <td width="100%" colspan="2">Total Amount    = '.$total_amt.'</td>                     
                        </tr>
                        <tr>  
                            <td width="100%" colspan="2">Total Payment  = '.$total_payment.'</td>                     
                        </tr>
                         <tr>  
                            <td width="100%" colspan="2">Total Balance  = '.$total_balance.'</td>                     
                        </tr>';  
 
                $obj_pdf = new TCPDF('P', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);  
                $obj_pdf->SetCreator(PDF_CREATOR);  
                $obj_pdf->SetTitle("Export HTML Table data to PDF using TCPDF in PHP");  
                $obj_pdf->SetHeaderData('', '', PDF_HEADER_TITLE, PDF_HEADER_STRING);  
                $obj_pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));  
                $obj_pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));  
                $obj_pdf->SetDefaultMonospacedFont('helvetica');  
                $obj_pdf->SetFooterMargin(PDF_MARGIN_FOOTER);  
                $obj_pdf->SetMargins(PDF_MARGIN_LEFT, '5', PDF_MARGIN_RIGHT);  
                $obj_pdf->setPrintHeader(false);  
                $obj_pdf->setPrintFooter(false);  
                $obj_pdf->SetAutoPageBreak(TRUE, 10);  
                $obj_pdf->SetFont('helvetica', '', 12);  
                $obj_pdf->AddPage();  
                $content = '';  
                $content .= '

               <h3 align="center">Day Book Report </h3><hr>
                <p align="center"><b>From:</b> '.$date_from.' <b>- To:</b> '.$date_to.' </p> 
                <p align="center"><b>Branch Name:</b> '.$user_name.' </p><br /> 
                <table border="1" cellspacing="0" cellpadding="5">  
                   <tr align="justify">  
                        <th width="5%">Slno</th>  
                        <th width="17%">Date</th>  
                        <th width="15%">Amount</th>
                        <th width="15%">Payment</th>
                        <th width="15%">Balance</th>
                        <th width="33%">description</th>
                   </tr>
                   
              ';  
              $content .= $output;  
              $content .= '</table>';  
              $obj_pdf->writeHTML($content);  
              $name=rand(10,100);
              $obj_pdf->Output($name.'.pdf', 'I');    


            }
            else{
                //set the response and exit
                $this->response("Provide complete feature information to insert.", REST_Controller::HTTP_BAD_REQUEST);
            }

        }
    }     
   
}

?>
