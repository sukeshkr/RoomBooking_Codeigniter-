<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php'; //include Rest Controller library

class Reports extends REST_Controller {

    public function __construct() { 
        parent::__construct();
        $this->load->library('notification_lib');
        $this->load->model('api/Reports_model','model'); //load user model
    }

    public function get_daily_purchase_post() {

        $user_id  = $this->post('user_id');

        $date  = $this->post('date');

        if(!empty($user_id)) {

            $total = $this->model->getDailyPurchaseReportsTotal($user_id,$date);
            
            foreach ($total as $key => $row) {

                $total_net_amt = $row->total_net_amt;
                
                $total_pay_amt = $row->total_pay_amt;

                $total_balance = $row->total_balance;
                
            }
            
            $cu_balance = $this->model->gePurchaseOpBalance($user_id,$date);
            

            //update user data
            $result = $this->model->getDailyPurchaseReports($user_id,$date);

            $op_balance = $this->model->geTotalOpBalanceByLedger($user_id);
            
            $tot_balane = $cu_balance + $op_balance;
            
            $outstanding = $tot_balane + $total_balance;

            //check if the user data updated
            if($result || $cu_balance) {

                    //set the response and exit
                    $this->response([
                        'status' => TRUE,
                        'op_balance' => $tot_balane,
                        'total_net_amt' => $total_net_amt,
                        'total_pay_amt' => $total_pay_amt,
                        'total_balance' => $total_balance,
                        'outstanding_total' => $outstanding,
                        'result' => $result
                    ], REST_Controller::HTTP_OK);
            }else{

                //set the response and exit
                $this->response([
                        'status' => FALSE,
                        'message' => 'No row affected'
                    ], REST_Controller::HTTP_OK);
            }
        }
        else{
            //set the response and exit
            $this->response("Provide complete feature information to insert.", REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    public function get_daily_sales_post() {

        $user_id  = $this->post('user_id');

        $date  = $this->post('date');

        if(!empty($user_id)) {

            $total = $this->model->getDailySalesReportsTotal($user_id,$date);

            //update user data
            $result = $this->model->getDailySalesReports($user_id,$date);

            //check if the user data updated
            if($result) {

                    //set the response and exit
                    $this->response([
                        'status' => TRUE,
                        'total' => $total,
                        'result' => $result
                    ], REST_Controller::HTTP_OK);
            }else{

                //set the response and exit
                $this->response([
                        'status' => FALSE,
                        'message' => 'No row affected'
                    ], REST_Controller::HTTP_OK);
            }
        }
        else{
            //set the response and exit
            $this->response("Provide complete feature information to insert.", REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    public function get_daily_expense_post() {

        $user_id  = $this->post('user_id');

        $date  = $this->post('date');

        if(!empty($user_id)) {

            $total = $this->model->getDailyExpenseReportsTotal($user_id,$date);

            //update user data
            $result = $this->model->getDailyExpenseReports($user_id,$date);

            //check if the user data updated
            if($result) {

                    //set the response and exit
                    $this->response([
                        'status' => TRUE,
                        'total' => $total,
                        'result' => $result
                    ], REST_Controller::HTTP_OK);
            }else{

                //set the response and exit
                $this->response([
                        'status' => FALSE,
                        'message' => 'No row affected'
                    ], REST_Controller::HTTP_OK);
            }
        }
        else{
            //set the response and exit
            $this->response("Provide complete feature information to insert.", REST_Controller::HTTP_BAD_REQUEST);
        }
    }
  
    public function get_daily_reports_post() {

        $user_id  = $this->post('user_id');

        $date  = $this->post('date');

        if(!empty($user_id)) {
            
            $cu_balance = $this->model->gePurchaseOpBalance($user_id,$date);
            
            $result = $this->model->getDailyReportsByUser($user_id,$date);
            
            $op_balance = $this->model->geTotalOpBalanceByLedger($user_id);

            $net_amt_sum = 0;

            $pay_amt_sum = 0;
            
            $total_balance = 0;

            foreach ($result as $key => $row) {

                $net_amt_sum += $row->receipt;

                $pay_amt_sum += $row->pay_amt;
                
                $total_balance += $row->balance;
                
            }
            
            $balance_amt = $net_amt_sum - $pay_amt_sum;
            
            $tot_balance = $op_balance + $cu_balance;

            $outstanding_total = $tot_balance + $total_balance;

            //check if the user data updated
            if($result) {

                    //set the response and exit
                    $this->response([
                        'status' => TRUE,
                        'op_balance' => $tot_balance,
                        'total_receipt' => $net_amt_sum,
                        'total_pay_amt' => $pay_amt_sum,
                        'total_balance' => $total_balance,
                        'balance_amt' => $balance_amt,
                        'outstanding_total' => $outstanding_total,
                        'result' => $result
                    ], REST_Controller::HTTP_OK);
            }else{

                //set the response and exit
                $this->response([
                        'status' => FALSE,
                        'message' => 'No row affected'
                    ], REST_Controller::HTTP_OK);
            }
        }
        else{
            //set the response and exit
            $this->response("Provide complete feature information to insert.", REST_Controller::HTTP_BAD_REQUEST);
        }
    }

////////////////////////////////////////////////////////////////////////////////////////

    public function get_weekly_purchase_post() {

        $user_id  = $this->post('user_id');

        $from_date  = $this->post('from_date');

        $to_date  = $this->post('to_date');

        if(!empty($user_id)) {
            
            $cu_balance = $this->model->gePurchaseOpBalance($user_id,$from_date);

            $op_balance = $this->model->geTotalOpBalanceByLedger($user_id);

            $total = $this->model->getWeeklyPurchaseReportsTotal($user_id,$from_date,$to_date);
            
            foreach ($total as $key => $row) {

                $net_amt_sum = $row->total_net_amt;

                $pay_amt_sum = $row->total_pay_amt;
                
                $total_balance = $row->total_balance;
               
            }

            $grand_total = $net_amt_sum - $pay_amt_sum;

            //update user data
            $result = $this->model->getWeeklyPurchaseReports($user_id,$from_date,$to_date);
            
           
            $tot_balane = $cu_balance + $op_balance;
            
            $outstanding = $tot_balane + $total_balance;

            //check if the user data updated
            if($result) {

                    //set the response and exit
                    $this->response([
                        'status' => TRUE,
                        'op_balance' => $tot_balane,
                        'total_receipt' => $net_amt_sum,
                        'total_pay_amt' => $pay_amt_sum,
                        'total_balance' => $total_balance,
                        'outstanding_total' => $outstanding,
                        'balance_amt' => $grand_total,
                        'result' => $result
                    ], REST_Controller::HTTP_OK);
            }else{

                //set the response and exit
                $this->response([
                        'status' => FALSE,
                        'message' => 'No row affected'
                    ], REST_Controller::HTTP_OK);
            }
        }
        else{
            //set the response and exit
            $this->response("Provide complete feature information to insert.", REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    public function get_weekly_sales_post() {

        $user_id  = $this->post('user_id');

        $from_date  = $this->post('from_date');

        $to_date  = $this->post('to_date');

        if(!empty($user_id)) {

            $total = $this->model->getWeeklySalesReportsTotal($user_id,$from_date,$to_date);

            //update user data
            $result = $this->model->getWeeklySalesReports($user_id,$from_date,$to_date);

            //check if the user data updated
            if($result) {

                    //set the response and exit
                    $this->response([
                        'status' => TRUE,
                        'total' => $total,
                        'result' => $result
                    ], REST_Controller::HTTP_OK);
            }else{

                //set the response and exit
                $this->response([
                        'status' => FALSE,
                        'message' => 'No row affected'
                    ], REST_Controller::HTTP_OK);
            }
        }
        else{
            //set the response and exit
            $this->response("Provide complete feature information to insert.", REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    public function get_weekly_expense_post() {

        $user_id  = $this->post('user_id');

        $from_date  = $this->post('from_date');

        $to_date  = $this->post('to_date');

        if(!empty($user_id)) {

            $total = $this->model->getWeeklyExpenseReportsTotal($user_id,$from_date,$to_date);

            //update user data
            $result = $this->model->getWeeklyExpenseReports($user_id,$from_date,$to_date);

            //check if the user data updated
            if($result) {

                    //set the response and exit
                    $this->response([
                        'status' => TRUE,
                        'total' => $total,
                        'result' => $result
                    ], REST_Controller::HTTP_OK);
            }else{

                //set the response and exit
                $this->response([
                        'status' => FALSE,
                        'message' => 'No row affected'
                    ], REST_Controller::HTTP_OK);
            }
        }
        else{
            //set the response and exit
            $this->response("Provide complete feature information to insert.", REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    public function get_weekly_reports_post() {

        $user_id  = $this->post('user_id');

        $from_date  = $this->post('from_date');

        $to_date  = $this->post('to_date');

        if(!empty($user_id)) {
            
            $cu_balance = $this->model->gePurchaseOpBalance($user_id,$from_date);

            //update user data
            $result = $this->model->getWeeklyReportsByUser($user_id,$from_date,$to_date);

            $op_balance = $this->model->geTotalOpBalanceByLedger($user_id);

            $net_amt_sum = 0;

            $pay_amt_sum = 0;
            
            $total_balance = 0;
            
            foreach ($result as $key => $row) {

                $net_amt_sum += $row->receipt;

                $pay_amt_sum += $row->total_pay_amt;
                
                $total_balance += $row->total_balance;
                               
            }

            $grand_total = $net_amt_sum - $pay_amt_sum;
            
            $tot_balane = $cu_balance + $op_balance;

            $outstanding = $tot_balane + $total_balance;

            //check if the user data updated
            if($result) {

                    //set the response and exit
                    $this->response([
                        'status' => TRUE,
                        'op_balance' => $tot_balane,
                        'total_pay_amt' => $pay_amt_sum,
                        'total_receipt' => $net_amt_sum,
                        'total_balance' => $total_balance,
                        'outstanding_total' => $outstanding,
                        'balance_amt' => $grand_total,
                        'result' => $result
                    ], REST_Controller::HTTP_OK);
            }else{

                //set the response and exit
                $this->response([
                        'status' => FALSE,
                        'message' => 'No row affected'
                    ], REST_Controller::HTTP_OK);
            }
        }
        else{
            //set the response and exit
            $this->response("Provide complete feature information to insert.", REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    /////////////////////////////////////////////////////////////////////////////////

    public function get_monthly_purchase_post() {

        $user_id  = $this->post('user_id');

        $from_date  = $this->post('from_date');

        $to_date  = $this->post('to_date');

        if(!empty($user_id)) {

            $total = $this->model->getMonthlyPurchaseReportsTotal($user_id,$from_date,$to_date);
            
            foreach ($total as $key => $row) {

                $net_amt_sum = $row->total_net_amt;

                $pay_amt_sum = $row->total_pay_amt;

                $total_balance = $row->total_balance;
               
            }
            
            $cu_balance = $this->model->gePurchaseOpBalance($user_id,$from_date);

            $op_balance = $this->model->geTotalOpBalanceByLedger($user_id);

            //update user data
            $result = $this->model->getMonthlyPurchaseReports($user_id,$from_date,$to_date);
                        
            $tot_balane = $cu_balance + $op_balance;
            
            $outstanding_total = $tot_balane + $total_balance;

            //check if the user data updated
            if($result) {

                    //set the response and exit
                    $this->response([
                        'status' => TRUE,
                        'op_balance' => $tot_balane,
                        'total_net_amt' => $net_amt_sum,
                        'total_pay_amt' => $pay_amt_sum,
                        'total_balance' => $total_balance,
                        'outstanding_total' => $outstanding_total,
                        'result' => $result
                    ], REST_Controller::HTTP_OK);
            }else{

                //set the response and exit
                $this->response([
                        'status' => FALSE,
                        'message' => 'No row affected'
                    ], REST_Controller::HTTP_OK);
            }
        }
        else{
            //set the response and exit
            $this->response("Provide complete feature information to insert.", REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    public function get_monthly_sales_post() {

        $user_id  = $this->post('user_id');

        $from_date  = $this->post('from_date');

        $to_date  = $this->post('to_date');

        if(!empty($user_id)) {

            $total = $this->model->getMonthlySalesReportsTotal($user_id,$from_date,$to_date);

            //update user data
            $result = $this->model->getMonthlySalesReports($user_id,$from_date,$to_date);

            //check if the user data updated
            if($result) {

                    //set the response and exit
                    $this->response([
                        'status' => TRUE,
                        'total' => $total,
                        'result' => $result
                    ], REST_Controller::HTTP_OK);
            }else{

                //set the response and exit
                $this->response([
                        'status' => FALSE,
                        'message' => 'No row affected'
                    ], REST_Controller::HTTP_OK);
            }
        }
        else{
            //set the response and exit
            $this->response("Provide complete feature information to insert.", REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    public function get_monthly_expense_post() {

        $user_id  = $this->post('user_id');

        $from_date  = $this->post('from_date');

        $to_date  = $this->post('to_date');

        if(!empty($user_id)) {

            $total = $this->model->getMonthlyExpenseReportsTotal($user_id,$from_date,$to_date);

            //update user data
            $result = $this->model->getMonthlyExpenseReports($user_id,$from_date,$to_date);

            //check if the user data updated
            if($result) {

                    //set the response and exit
                    $this->response([
                        'status' => TRUE,
                        'total' => $total,
                        'result' => $result
                    ], REST_Controller::HTTP_OK);
            }else{

                //set the response and exit
                $this->response([
                        'status' => FALSE,
                        'message' => 'No row affected'
                    ], REST_Controller::HTTP_OK);
            }
        }
        else{
            //set the response and exit
            $this->response("Provide complete feature information to insert.", REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    public function get_monthly_reports_post() {

        $user_id  = $this->post('user_id');

        $from_date  = $this->post('from_date');

        $to_date  = $this->post('to_date');

        if(!empty($user_id)) {
            
            $cu_balance = $this->model->gePurchaseOpBalance($user_id,$from_date);

            $op_balance = $this->model->geTotalOpBalanceByLedger($user_id);

            //update user data
            $result = $this->model->getMonthlyReportsByUser($user_id,$from_date,$to_date);

            $pay_amt_sum = 0;
            
            $total_balance = 0;
            
            $receipt_sum = 0;
            
            foreach ($result as $key => $row) {

                $pay_amt_sum += $row->total_pay_amt;
                
                $receipt_sum += $row->receipt;
                
                $total_balance += $row->total_balance;
                               
            }
            
            $tot_balance = $op_balance + $cu_balance;

            $outstanding_total = $tot_balance + $total_balance;
            
            $tot_bal_total = $receipt_sum - $pay_amt_sum;
            
            

            //check if the user data updated
            if($op_balance) {

                    //set the response and exit
                    $this->response([
                        'status' => TRUE,
                        'op_balance' => $tot_balance,
                        'total_pay_amt' => $pay_amt_sum,
                        'receipt_sum' => $receipt_sum,
                        'total_balance' => $total_balance,
                        'balance_amt' => $tot_bal_total,
                        'outstanding_total' => $outstanding_total,
                        'result' => $result
                    ], REST_Controller::HTTP_OK);
            }else{

                //set the response and exit
                $this->response([
                        'status' => FALSE,
                        'message' => 'No row affected'
                    ], REST_Controller::HTTP_OK);
            }
        }
        else{
            //set the response and exit
            $this->response("Provide complete feature information to insert.", REST_Controller::HTTP_BAD_REQUEST);
        }
    }
    
    
    public function get_owner_reports_post() {

        $user_id  = $this->post('user_id');

        $from_date  = $this->post('from_date');

        $to_date  = $this->post('to_date');

        if(!empty($user_id)) {

            //update user data
            $result = $this->model->getOwnerallReports($user_id,$from_date,$to_date);

            $total_balance = 0;
            $total_receipt = 0;
            $total_payment = 0;
            $total_outstanding = 0;

            foreach ($result as $key => $row) {

                $total_balance += $row->balance;

                $total_receipt += $row->receipt;

                $total_payment += $row->payment;

                $total_outstanding += $row->out_standing;
               
            }

            //check if the user data updated
            if($result) {

                    //set the response and exit
                    $this->response([
                        'status' => TRUE,
                        'total_receipt' => $total_receipt,
                        'total_payment' => $total_payment,
                        'total_balance' => $total_balance,
                        'total_outstanding' => $total_outstanding,
                        'result' => $result
                    ], REST_Controller::HTTP_OK);
            }else{

                //set the response and exit
                $this->response([
                        'status' => TRUE,
                        'message' => 'No row affected'
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
