<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Reports_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        
        //load database library
        $this->load->database();
    }

    var $table = 'ledger';
    var $order = array('id' => 'desc');

    public function getUserName($user_id='')
    {
        $this->db->select('user_registration.branch_name');
        $this->db->from('user_registration');
        $this->db->where('user_registration.id',$user_id);
        $query = $this->db->get();

        if ($query->num_rows() > 0) {

            $res = $query->result()[0]->branch_name;
        }

        else{

            $res = "";

        }

        return $res;

    }

    public function getDailyPurchaseReports($user_id='',$date)
    {
        $this->db->select('purchase.id as purchase_id,ledger.id as ledger_id,ledger.op_balance,ledger.ledger_name,purchase.particular,purchase.ledger_id,purchase.net_amt,purchase.pay_amt,purchase.bill_no,purchase.created_at,purchase.type,purchase.status');
        $this->db->from('purchase');
        $this->db->join('ledger','purchase.ledger_id = ledger.id');
        $this->db->join('acc_groups', 'ledger.group_id = acc_groups.id');
        $this->db->where('purchase.user_id',$user_id);
        $this->db->where('purchase.created_at =',$date);
        $this->db->order_by('purchase.id','DESC');
        $query = $this->db->get();

        $categories = $query->result();

        $i=0;

        foreach($categories as $p_cat){

            $categories[$i]->balance = $this->getDayBookPurchaseDataSub($p_cat->purchase_id);

            $i++;
        }

        return $categories;

    }
    
    

    public function getDayBookPurchaseDataSub($id)
    {
        $this->db->select('COALESCE(SUM(purchase.net_amt - purchase.pay_amt),0) AS balance');
        $this->db->from('purchase');
        $this->db->where('purchase.id',$id);
        $query = $this->db->get();

        if ($query->num_rows() > 0) {

            $categories = $query->result()[0]->balance;
        }

        else{

            $categories = 0;

        }

        return $categories;

    }

    public function getDailyPurchaseReportsTotal($user_id='',$date)
    {

        $this->db->select('COALESCE(SUM(purchase.net_amt),0) AS total_net_amt,COALESCE(SUM(purchase.pay_amt),0) AS total_pay_amt,COALESCE(SUM(purchase.net_amt - purchase.pay_amt),0) AS total_balance,COALESCE(SUM(purchase.net_amt - purchase.pay_amt),0) AS grand_total');
        $this->db->from('purchase');
        $this->db->where('purchase.user_id',$user_id);
        $this->db->where('purchase.created_at =',$date);
        $query = $this->db->get();

        $categories = $query->result();

        return $categories;

    }
    
    public function geLedgerOpBalance($user_id='')
    {
        $this->db->select('ledger.op_balance');
        $this->db->from('ledger');
        $this->db->where('ledger.user_id',$user_id);
        $query = $this->db->get();

        $res = $query->result()[0]->op_balance;

        if ($res) {

            $categories = $res;
        }

        else{

            $categories = 0;

        }

        return $categories;

    }
    
    public function gePurchaseOpBalance($user_id='',$date)
    {
        $new_date = date('Y-m-d',(strtotime ( '-1 day' , strtotime ( $date) ) ));

        $this->db->select('COALESCE(SUM(purchase.net_amt - purchase.pay_amt),0) AS op_balance');
        $this->db->from('purchase');
        $this->db->where('purchase.user_id',$user_id);
        $this->db->where('purchase.created_at <=',$new_date);
        $query = $this->db->get();
        
        $res = $query->result()[0]->op_balance;

        if ($res) {

            $categories = $query->result()[0]->op_balance;
        }

        else{

            $categories = 0;

        }
        
        return $categories;
    }

    public function getDailySalesReports($user_id='',$date)
    {
        $this->db->select('sales.id as sales_id,ledger.id as ledger_id,ledger.ledger_name,sales.particular,sales.ledger_id,sales.net_amt,sales.pay_amt,sales.bill_no,sales.created_at,sales.type,sales.status');
        $this->db->from('sales');
        $this->db->join('ledger','sales.ledger_id = ledger.id');
        $this->db->join('acc_groups', 'ledger.group_id = acc_groups.id');
        $this->db->where('sales.user_id',$user_id);
        $this->db->where('sales.created_at =',$date);
        $this->db->order_by('sales.id','DESC');
        $query = $this->db->get();

        $categories = $query->result();

        return $categories;
    }

    public function getDailySalesReportsTotal($user_id='',$date)
    {
        $this->db->select('COALESCE(SUM(sales.net_amt),0) AS total');
        $this->db->from('sales');
        $this->db->where('sales.user_id',$user_id);
        $this->db->where('sales.created_at =',$date);
        $query = $this->db->get();

        if ($query->num_rows() > 0) {

            $categories = $query->result()[0]->total;
        }

        else{

            $categories = 0;

        }

        return $categories;

    }

    public function getDailyExpenseReports($user_id='',$date)
    {
        $this->db->select('expence.id as expence_id,ledger.id as ledger_id,ledger.ledger_name,expence.particular,expence.ledger_id,expence.net_amt,expence.pay_amt,expence.bill_no,expence.created_at,expence.type,expence.status');
        $this->db->from('expence');
        $this->db->join('ledger','expence.ledger_id = ledger.id');
        $this->db->join('acc_groups', 'ledger.group_id = acc_groups.id');
        $this->db->where('expence.user_id',$user_id);
        $this->db->where('expence.created_at =',$date);
        $this->db->order_by('expence.id','DESC');
        $query = $this->db->get();

        $categories = $query->result();

        return $categories;
    }

    public function getDailyExpenseReportsTotal($user_id='',$date)
    {
        $this->db->select('COALESCE(SUM(expence.pay_amt),0) AS total');
        $this->db->from('expence');
        $this->db->where('expence.user_id',$user_id);
        $this->db->where('expence.created_at =',$date);
        $query = $this->db->get();

        if ($query->num_rows() > 0) {

            $categories = $query->result()[0]->total;
        }

        else{

            $categories = 0;

        }

        return $categories;

    }

    public function getDailyReportsByUser($user_id='',$date='') {

        $this->db->select("z.id as id,z.name,z.particular,z.ledger_id,ledger.op_balance,ledger.ledger_name as ledger_name,z.net_amt,z.pay_amt,0 as receipt,z.pay_amt as payment,z.bill_no,z.created_at,z.user_id,z.type,z.status");
        $this->db->from("purchase AS z");
        $this->db->join('ledger','z.ledger_id = ledger.id');
        $this->db->where("z.status",1);
        $this->db->where("z.user_id",$user_id);
        $this->db->where("z.created_at",$date);
        $query1 = $this->db->get_compiled_select(); // It resets the query just like a get()

        $this->db->select("s.id as id,s.name,s.particular,s.ledger_id,ledger.op_balance,ledger.ledger_name as ledger_name,s.net_amt,s.pay_amt,s.net_amt as receipt,s.pay_amt as payment,s.bill_no,s.created_at,s.user_id,s.type,s.status");
        $this->db->from("sales AS s");
        $this->db->join('ledger','s.ledger_id = ledger.id');
        $this->db->where("s.status",1);
        $this->db->where("s.user_id",$user_id);
        $this->db->where("s.created_at",$date);
        $query2 = $this->db->get_compiled_select(); 

        $this->db->select("e.id as id,e.name,e.particular,e.ledger_id,ledger.op_balance,ledger.ledger_name as ledger_name,e.net_amt,e.pay_amt,e.net_amt as receipt,e.pay_amt as payment,e.bill_no,e.created_at,e.user_id,e.type,e.status");
        $this->db->from("expence AS e");
        $this->db->join('ledger','e.ledger_id = ledger.id');
        $this->db->where("e.status",1);
        $this->db->where("e.user_id",$user_id);
        $this->db->where("e.created_at",$date);
        $query3 = $this->db->get_compiled_select(); 

        $query = $this->db->query($query1." UNION ".$query2." UNION ".$query3);
      
        $categories = $query->result();

        $i=0;

        foreach($categories as $p_cat) {

            if($p_cat->type=="purchase")
            {
                $categories[$i]->balance = $this->getDailyReportsByPurchaseSub($p_cat->id);
            }

            if($p_cat->type=="sales")
            {
                //$categories[$i]->balance = $this->getDailyReportsBySalesSub($p_cat->id);
                
                $categories[$i]->balance = 0;
            }

            if($p_cat->type=="expence")
            {
                //$categories[$i]->balance = $this->getDailyReportsByExpenseSub($p_cat->id);
                
                $categories[$i]->balance = 0;
            }

            $i++;
        }

        return $categories;
    }

    public function getDailyReportsByExpenseSub($id='')
    {
        $this->db->select('COALESCE(SUM(expence.pay_amt),0) AS total');
        $this->db->from('expence');
        $this->db->where('expence.id',$id);
        $query = $this->db->get();

        if ($query->num_rows() > 0) {

            $categories = $query->result()[0]->total;
        }

        else{

            $categories = 0;

        }

        return $categories;

    }

    public function getDailyReportsBySalesSub($id='')
    {
        $this->db->select('COALESCE(SUM(sales.net_amt),0) AS total');
        $this->db->from('sales');
        $this->db->where('sales.id',$id);
        $query = $this->db->get();

        if ($query->num_rows() > 0) {

            $categories = $query->result()[0]->total;
        }

        else{

            $categories = 0;

        }

        return $categories;

    }

    public function getDailyReportsByPurchaseSub($id)
    {
        $this->db->select('COALESCE(SUM(purchase.net_amt - purchase.pay_amt),0) AS balance');
        $this->db->from('purchase');
        $this->db->where('purchase.id',$id);
        $query = $this->db->get();

        if ($query->num_rows() > 0) {

            $categories = $query->result()[0]->balance;
        }

        else{

            $categories = 0;

        }

        return $categories;

    }

    ///////////////////////////////////////////////////////////////////////

    public function getWeeklyPurchaseReports($user_id='',$from_date='',$to_date='')
    {
        $this->db->select('purchase.id as purchase_id,ledger.id as ledger_id,ledger.op_balance,ledger.ledger_name,purchase.particular,COALESCE(SUM(purchase.net_amt),0) AS total_net_amt,COALESCE(SUM(purchase.pay_amt),0) AS total_pay_amt,purchase.type,purchase.status,COALESCE(SUM(purchase.net_amt - purchase.pay_amt),0) AS total_balance');
        $this->db->from('purchase');
        $this->db->join('ledger','purchase.ledger_id = ledger.id');
        $this->db->where('purchase.user_id',$user_id);
        $this->db->where('purchase.created_at >=',$from_date);
        $this->db->where('purchase.created_at <=',$to_date);
        $this->db->group_by('ledger.id');
        $this->db->order_by('ledger.ledger_name','ASC');
        $query = $this->db->get();

        $categories = $query->result();

        $i=0;

        foreach($categories as $p_cat){

            $categories[$i]->date = $this->getWeeklyPurchaseReportByDateSub($p_cat->ledger_id,$from_date,$to_date);

            $i++;
        }

        return $categories;

    }

    public function getWeeklyPurchaseReportByDateSub($ledger_id='',$from_date='',$to_date='')
    {
        $this->db->select('purchase.id as purchase_id,ledger.id as ledger_id,ledger.ledger_name,purchase.particular,purchase.ledger_id,purchase.net_amt,purchase.pay_amt,purchase.bill_no,purchase.created_at,DATE_FORMAT(purchase.created_at, "%a") as day,DATE_FORMAT(purchase.created_at, "%w") as day_num,purchase.type,purchase.status,');
        $this->db->from('purchase');
        $this->db->join('ledger','purchase.ledger_id = ledger.id');
        $this->db->join('acc_groups', 'ledger.group_id = acc_groups.id');
        $this->db->where('purchase.created_at >=',$from_date);
        $this->db->where('purchase.created_at <=',$to_date);
        $this->db->where('ledger.id =',$ledger_id);
        $query = $this->db->get();

        $categories = $query->result();

        $i=0;

        foreach($categories as $p_cat){

            $categories[$i]->balance = $this->getWeeklyPurchaseReportsSub($p_cat->purchase_id);

            $i++;
        }

        return $categories;

    }

    public function getWeeklyPurchaseReportsSub($id)
    {
        $this->db->select('COALESCE(SUM(purchase.net_amt - purchase.pay_amt),0) AS balance');
        $this->db->from('purchase');
        $this->db->where('purchase.id',$id);
        $query = $this->db->get();

        if ($query->num_rows() > 0) {

            $categories = $query->result()[0]->balance;
        }

        else{

            $categories = 0;

        }

        return $categories;

    }

    public function getWeeklyPurchaseReportsTotal($user_id='',$from_date='',$to_date='')
    {

        $this->db->select('COALESCE(SUM(purchase.net_amt),0) AS total_net_amt,COALESCE(SUM(purchase.pay_amt),0) AS total_pay_amt,COALESCE(SUM(purchase.net_amt - purchase.pay_amt),0) AS total_balance,COALESCE(SUM(purchase.net_amt - purchase.pay_amt),0) AS grand_total');
        $this->db->from('purchase');
        $this->db->where('purchase.user_id',$user_id);
        $this->db->where('purchase.created_at >=',$from_date);
        $this->db->where('purchase.created_at <=',$to_date);
        $query = $this->db->get();

        $categories = $query->result();

        return $categories;

    }

    public function getWeeklySalesReports($user_id='',$from_date='',$to_date='')
    {
        $this->db->select('sales.id as sales_id,ledger.id as ledger_id,ledger.ledger_name,sales.particular,sales.ledger_id,COALESCE(SUM(sales.net_amt),0) AS total_net_amt,COALESCE(SUM(sales.pay_amt),0) AS total_pay_amt,sales.type,COALESCE(SUM(sales.net_amt - sales.pay_amt),0) AS total_balance,sales.bill_no,sales.created_at,DATE_FORMAT(sales.created_at, "%a") as day,sales.type,sales.status');
        $this->db->from('sales');
        $this->db->join('ledger','sales.ledger_id = ledger.id');
        $this->db->join('acc_groups', 'ledger.group_id = acc_groups.id');
        $this->db->where('sales.user_id',$user_id);
        $this->db->where('sales.created_at >=',$from_date);
        $this->db->where('sales.created_at <=',$to_date);
        $this->db->group_by('ledger.id');
        $this->db->order_by('ledger.ledger_name','ASC');
        $query = $this->db->get();

        $categories = $query->result();

        $i=0;

        foreach($categories as $p_cat){

            $categories[$i]->date = $this->getWeeklySalesReportByDateSub($p_cat->ledger_id,$from_date,$to_date);

            $i++;
        }

        return $categories;
    }

    public function getWeeklySalesReportByDateSub($ledger_id='',$from_date='',$to_date='')
    {
        $this->db->select('sales.id as purchase_id,ledger.id as ledger_id,ledger.ledger_name,sales.particular,sales.ledger_id,sales.net_amt,sales.pay_amt,sales.bill_no,sales.created_at,DATE_FORMAT(sales.created_at, "%a") as day,DATE_FORMAT(sales.created_at, "%w") as day_num,sales.type,sales.status,');
        $this->db->from('sales');
        $this->db->join('ledger','sales.ledger_id = ledger.id');
        $this->db->join('acc_groups', 'ledger.group_id = acc_groups.id');
        //$this->db->where('purchase.user_id',$user_id);
        $this->db->where('ledger.id =',$ledger_id);
        $this->db->where('sales.created_at >=',$from_date);
        $this->db->where('sales.created_at <=',$to_date);
        $query = $this->db->get();

        $categories = $query->result();        

        return $categories;

    }

    public function getWeeklySalesReportsTotal($user_id='',$from_date='',$to_date='')
    {
        $this->db->select('COALESCE(SUM(sales.net_amt),0) AS total');
        $this->db->from('sales');
        $this->db->where('sales.user_id',$user_id);
        $this->db->where('sales.created_at >=',$from_date);
        $this->db->where('sales.created_at <=',$to_date);
        $query = $this->db->get();

        if ($query->num_rows() > 0) {

            $categories = $query->result()[0]->total;
        }

        else{

            $categories = 0;

        }

        return $categories;

    }

    public function getWeeklyExpenseReports($user_id='',$from_date='',$to_date='')
    {
        $this->db->select('expence.id as expence_id,ledger.id as ledger_id,ledger.ledger_name,expence.particular,expence.ledger_id,COALESCE(SUM(expence.net_amt),0) AS total_net_amt,COALESCE(SUM(expence.pay_amt),0) AS total_pay_amt,COALESCE(SUM(expence.pay_amt),0) AS total_balance,expence.bill_no,expence.created_at,DATE_FORMAT(expence.created_at, "%a") as day,expence.type,expence.status');
        $this->db->from('expence');
        $this->db->join('ledger','expence.ledger_id = ledger.id');
        $this->db->join('acc_groups', 'ledger.group_id = acc_groups.id');
        $this->db->where('expence.user_id',$user_id);
        $this->db->where('expence.created_at >=',$from_date);
        $this->db->where('expence.created_at <=',$to_date);
        $this->db->group_by('ledger.id');
        $this->db->order_by('day','ASC');
        $query = $this->db->get();

        $categories = $query->result();

         $i=0;

        foreach($categories as $p_cat){

            $categories[$i]->date = $this->getWeeklyExpenseByDateSub($p_cat->ledger_id,$from_date,$to_date);

            $i++;
        }

        return $categories;
    }

    public function getWeeklyExpenseByDateSub($ledger_id='',$from_date='',$to_date='')
    {
        $this->db->select('expence.id as purchase_id,ledger.id as ledger_id,ledger.ledger_name,expence.particular,expence.ledger_id,expence.net_amt,expence.pay_amt,expence.bill_no,expence.created_at,DATE_FORMAT(expence.created_at, "%a") as day,DATE_FORMAT(expence.created_at, "%w") as day_num,expence.type,expence.status,');
        $this->db->from('expence');
        $this->db->join('ledger','expence.ledger_id = ledger.id');
        $this->db->join('acc_groups', 'ledger.group_id = acc_groups.id');
        //$this->db->where('purchase.user_id',$user_id);
        $this->db->where('ledger.id =',$ledger_id);
        $this->db->where('expence.created_at >=',$from_date);
        $this->db->where('expence.created_at <=',$to_date);
        $query = $this->db->get();

        $categories = $query->result();        

        return $categories;

    }

    public function getWeeklyExpenseReportsTotal($user_id='',$from_date='',$to_date='')
    {
        $this->db->select('COALESCE(SUM(expence.pay_amt),0) AS total');
        $this->db->from('expence');
        $this->db->where('expence.user_id',$user_id);
        $this->db->where('expence.created_at >=',$from_date);
        $this->db->where('expence.created_at <=',$to_date);
        $query = $this->db->get();

        if ($query->num_rows() > 0) {

            $categories = $query->result()[0]->total;
        }

        else{

            $categories = 0;

        }

        return $categories;

    }

    public function getWeeklyReportsByUser($user_id='',$from_date='',$to_date='') {

        $this->db->select("z.id as id,ledger.id as ledger_id,ledger.op_balance,ledger.ledger_name as ledger_name,z.name,z.particular,z.user_id,z.type,z.status,
        COALESCE(SUM(z.net_amt),0) AS total_net_amt,COALESCE(SUM(z.pay_amt),0) AS total_pay_amt,COALESCE(SUM(z.net_amt - z.pay_amt),0) AS total_balance,0 AS receipt,COALESCE(SUM(z.pay_amt),0) AS payment");
        $this->db->from("purchase AS z");
        $this->db->join('ledger','z.ledger_id = ledger.id');
        $this->db->where("z.status",1);
        $this->db->where("z.user_id",$user_id);
        $this->db->where('z.created_at >=',$from_date);
        $this->db->where('z.created_at <=',$to_date);
        $this->db->group_by('ledger.id');
        $query1 = $this->db->get_compiled_select(); // It resets the query just like a get()

        $this->db->select("s.id as id,ledger.id as ledger_id,ledger.op_balance,ledger.ledger_name as ledger_name,s.name,s.particular,s.user_id,s.type,s.status,
        COALESCE(SUM(s.net_amt),0) AS total_net_amt,COALESCE(SUM(s.pay_amt),0) AS total_pay_amt,COALESCE(SUM(s.pay_amt),0) AS total_balance,COALESCE(SUM(s.net_amt),0) AS payment,COALESCE(SUM(s.pay_amt),0) AS receipt");
        $this->db->from("sales AS s");
        $this->db->join('ledger','s.ledger_id = ledger.id');
        $this->db->where("s.status",1);
        $this->db->where("s.user_id",$user_id);
        $this->db->where('s.created_at >=',$from_date);
        $this->db->where('s.created_at <=',$to_date);
        $this->db->group_by('ledger.id');
        $query2 = $this->db->get_compiled_select(); 

        $this->db->select("e.id as id,ledger.id as ledger_id,ledger.op_balance,ledger.ledger_name as ledger_name,e.name,e.particular,e.user_id,e.type,e.status,
        COALESCE(SUM(e.net_amt),0) AS total_net_amt,COALESCE(SUM(e.pay_amt),0) AS total_pay_amt,COALESCE(SUM(e.net_amt),0) AS total_balance,COALESCE(SUM(e.net_amt),0) AS receipt,COALESCE(SUM(e.pay_amt),0) AS payment");
        $this->db->from("expence AS e");
        $this->db->join('ledger','e.ledger_id = ledger.id');
        $this->db->where("e.status",1);
        $this->db->where("e.user_id",$user_id);
        $this->db->where('e.created_at >=',$from_date);
        $this->db->where('e.created_at <=',$to_date);
        $this->db->group_by('ledger.id');
        $query3 = $this->db->get_compiled_select(); 

        $query = $this->db->query($query1." UNION ".$query2." UNION ".$query3."ORDER BY ledger_name ASC");
      
        $categories = $query->result();

        $i=0;

        foreach($categories as $p_cat) {

            if($p_cat->type=="purchase")
            {
                $categories[$i]->date = $this->getWeeklyReportsByPurchaseDateSub($p_cat->ledger_id,$from_date,$to_date);
            }

            if($p_cat->type=="sales")
            {
                $categories[$i]->date = $this->getWeeklyReportsBySaleDateSub($p_cat->ledger_id,$from_date,$to_date);

            }

            if($p_cat->type=="expence")
            {
                $categories[$i]->date = $this->getWeeklyReportsByExpenceDateSub($p_cat->ledger_id,$from_date,$to_date);
            }

            $i++;
        }

        return $categories;
    }

    public function getWeeklyReportsByExpenceDateSub($ledger_id='',$from_date='',$to_date='')
    {
        $this->db->select('expence.id,ledger.id as ledger_id,ledger.ledger_name,expence.particular,expence.ledger_id,expence.net_amt,expence.pay_amt,expence.bill_no,expence.created_at,DATE_FORMAT(expence.created_at, "%a") as day,DATE_FORMAT(expence.created_at, "%w") as day_num,expence.type,expence.status,');
        $this->db->from('expence');
        $this->db->join('ledger','expence.ledger_id = ledger.id');
        $this->db->join('acc_groups', 'ledger.group_id = acc_groups.id');
        //$this->db->where('purchase.user_id',$user_id);
        $this->db->where('ledger.id =',$ledger_id);
        $this->db->where('expence.created_at >=',$from_date);
        $this->db->where('expence.created_at <=',$to_date);
        $query = $this->db->get();

        $categories = $query->result();  

        $i=0;

        foreach($categories as $p_cat) {

            $categories[$i]->balance = $this->getWeeklyReportsByExpenseSub($p_cat->id);   

            $i++;
        }

        return $categories;

    }

    public function getWeeklyReportsByExpenseSub($id='')
    {
        $this->db->select('COALESCE(SUM(expence.pay_amt),0) AS total');
        $this->db->from('expence');
        $this->db->where('expence.id',$id);
        $query = $this->db->get();

        if ($query->num_rows() > 0) {

            $categories = $query->result()[0]->total;
        }

        else{

            $categories = 0;

        }

        return $categories;

    }


    public function getWeeklyReportsBySaleDateSub($ledger_id='',$from_date='',$to_date='')
    {
        $this->db->select('sales.id,ledger.id as ledger_id,ledger.ledger_name,sales.particular,sales.ledger_id,sales.net_amt,sales.pay_amt,sales.bill_no,sales.created_at,DATE_FORMAT(sales.created_at, "%a") as day,DATE_FORMAT(sales.created_at, "%w") as day_num,sales.type,sales.status,');
        $this->db->from('sales');
        $this->db->join('ledger','sales.ledger_id = ledger.id');
        $this->db->join('acc_groups', 'ledger.group_id = acc_groups.id');
        //$this->db->where('purchase.user_id',$user_id);
        $this->db->where('ledger.id =',$ledger_id);
        $this->db->where('sales.created_at >=',$from_date);
        $this->db->where('sales.created_at <=',$to_date);
        $query = $this->db->get();

        $categories = $query->result();  

        $i=0;

        foreach($categories as $p_cat) {

            $categories[$i]->balance = $this->getWeeklyReportsBySalesSub($p_cat->id); 

            $i++;
        }

        return $categories;

    }


    public function getWeeklyReportsBySalesSub($id='')
    {
        $this->db->select('COALESCE(SUM(sales.net_amt),0) AS total');
        $this->db->from('sales');
        $this->db->where('sales.id',$id);
        $query = $this->db->get();

        if ($query->num_rows() > 0) {

            $categories = $query->result()[0]->total;
        }

        else{

            $categories = 0;

        }

        return $categories;

    }


    public function getWeeklyReportsByPurchaseDateSub($ledger_id='',$from_date='',$to_date='')
    {
        $this->db->select('purchase.id,ledger.id as ledger_id,ledger.ledger_name,purchase.particular,purchase.ledger_id,purchase.net_amt,purchase.pay_amt,purchase.bill_no,purchase.created_at,DATE_FORMAT(purchase.created_at, "%a") as day,DATE_FORMAT(purchase.created_at, "%w") as day_num,purchase.type,purchase.status,');
        $this->db->from('purchase');
        $this->db->join('ledger','purchase.ledger_id = ledger.id');
        $this->db->join('acc_groups', 'ledger.group_id = acc_groups.id');
        $this->db->where('purchase.created_at >=',$from_date);
        $this->db->where('purchase.created_at <=',$to_date);
        $this->db->where('ledger.id =',$ledger_id);
        $query = $this->db->get();

        $categories = $query->result();

        $i=0;

        foreach($categories as $p_cat) {

            $categories[$i]->balance = $this->getWeeklyReportsByPurchaseSub($p_cat->id);

            $i++;
        }

        return $categories;

    }

    public function getWeeklyReportsByPurchaseSub($id)
    {
        $this->db->select('COALESCE(SUM(purchase.net_amt - purchase.pay_amt),0) AS balance');
        $this->db->from('purchase');
        $this->db->where('purchase.id',$id);
        $query = $this->db->get();

        if ($query->num_rows() > 0) {

            $categories = $query->result()[0]->balance;
        }

        else{

            $categories = 0;

        }

        return $categories;

    }

    ///////////////////////////////////////////////////////////////////////////

    public function getMonthlyPurchaseReports($user_id='',$from_date='',$to_date='')
    {
        $this->db->select('purchase.id as purchase_id,ledger.id as ledger_id,ledger.op_balance,ledger.ledger_name,purchase.particular,COALESCE(SUM(purchase.net_amt),0) AS total_net_amt,COALESCE(SUM(purchase.pay_amt),0) AS total_pay_amt,purchase.type,purchase.status,COALESCE(SUM(purchase.net_amt - purchase.pay_amt),0) AS total_balance');
        $this->db->from('purchase');
        $this->db->join('ledger','purchase.ledger_id = ledger.id');
        $this->db->where('purchase.user_id',$user_id);
        $this->db->where('purchase.created_at >=',$from_date);
        $this->db->where('purchase.created_at <=',$to_date);
        $this->db->group_by('ledger.id');
        $this->db->order_by('ledger.ledger_name','ASC');
        $query = $this->db->get();

        $categories = $query->result();

        $i=0;

        foreach($categories as $p_cat){

            $categories[$i]->date = $this->getMonthlyPurchaseReportsByDateSub($p_cat->ledger_id,$from_date,$to_date);

            $i++;
        }

        return $categories;

    }


    public function getMonthlyPurchaseReportsByDateSub($ledger_id='',$from_date='',$to_date='')
    {
        $this->db->select('purchase.id as purchase_id,ledger.id as ledger_id,ledger.ledger_name,purchase.particular,purchase.ledger_id,COALESCE(SUM(purchase.net_amt),0) AS total_net_amt,COALESCE(SUM(purchase.pay_amt),0) AS total_pay_amt,COALESCE(SUM(purchase.net_amt - purchase.pay_amt),0) AS total_balance,purchase.bill_no,purchase.created_at,DATE_FORMAT(purchase.created_at, "%b") as month,DATE_FORMAT(purchase.created_at, "%m") as month_num,purchase.type,purchase.status,');
        $this->db->from('purchase');
        $this->db->join('ledger','purchase.ledger_id = ledger.id');
        $this->db->join('acc_groups', 'ledger.group_id = acc_groups.id');
        $this->db->where('purchase.created_at >=',$from_date);
        $this->db->where('purchase.created_at <=',$to_date);
        $this->db->where('ledger.id =',$ledger_id);
        $this->db->group_by('month');
        $this->db->order_by('month_num','ASC');
        $query = $this->db->get();

        $categories = $query->result();

        return $categories;

    }


    public function getMonthlyPurchaseReportsTotal($user_id='',$from_date='',$to_date='')
    {

        $this->db->select('COALESCE(SUM(purchase.net_amt),0) AS total_net_amt,COALESCE(SUM(purchase.pay_amt),0) AS total_pay_amt,COALESCE(SUM(purchase.net_amt - purchase.pay_amt),0) AS total_balance,COALESCE(SUM(purchase.net_amt - purchase.pay_amt),0) AS grand_total');
        $this->db->from('purchase');
        $this->db->where('purchase.user_id',$user_id);
        $this->db->where('purchase.created_at >=',$from_date);
        $this->db->where('purchase.created_at <=',$to_date);
        $query = $this->db->get();

        $categories = $query->result();

        return $categories;

    }


    public function getMonthlySalesReports($user_id='',$from_date='',$to_date='')
    {
        $this->db->select('sales.id as sales_id,ledger.id as ledger_id,ledger.ledger_name,sales.particular,COALESCE(SUM(sales.net_amt),0) AS total_net_amt,COALESCE(SUM(sales.pay_amt),0) AS total_pay_amt,sales.type,sales.status,COALESCE(SUM(sales.net_amt - sales.pay_amt),0) AS total_balance');
        $this->db->from('sales');
        $this->db->join('ledger','sales.ledger_id = ledger.id');
        $this->db->join('acc_groups', 'ledger.group_id = acc_groups.id');
        $this->db->where('sales.user_id',$user_id);
        $this->db->where('sales.created_at >=',$from_date);
        $this->db->where('sales.created_at <=',$to_date);
        $this->db->group_by('ledger.id');
        $this->db->order_by('ledger.ledger_name','ASC');
        $query = $this->db->get();

        $categories = $query->result();

        $i=0;

        foreach($categories as $p_cat){

            $categories[$i]->date = $this->getMonthlySalesReportsByDateSub($p_cat->ledger_id,$from_date,$to_date);

            $i++;
        }

        return $categories;
    }

    public function getMonthlySalesReportsByDateSub($ledger_id='',$from_date='',$to_date='')
    {
        $this->db->select('sales.id as sales_id,ledger.id as ledger_id,ledger.ledger_name,sales.particular,sales.ledger_id,COALESCE(SUM(sales.net_amt),0) AS total_net_amt,COALESCE(SUM(sales.pay_amt),0) AS total_pay_amt,COALESCE(SUM(sales.net_amt - sales.pay_amt),0) AS total_balance,sales.bill_no,sales.created_at,DATE_FORMAT(sales.created_at, "%b") as month,DATE_FORMAT(sales.created_at, "%m") as month_num,sales.type,sales.status,');
        $this->db->from('sales');
        $this->db->join('ledger','sales.ledger_id = ledger.id');
        $this->db->join('acc_groups', 'ledger.group_id = acc_groups.id');
        $this->db->where('sales.created_at >=',$from_date);
        $this->db->where('sales.created_at <=',$to_date);
        $this->db->where('ledger.id =',$ledger_id);
        $this->db->group_by('month');
        $this->db->order_by('month_num','ASC');
        $query = $this->db->get();

        $categories = $query->result();

        return $categories;

    }

    public function getMonthlySalesReportsTotal($user_id='',$from_date='',$to_date='')
    {
        $this->db->select('COALESCE(SUM(sales.net_amt),0) AS total');
        $this->db->from('sales');
        $this->db->where('sales.user_id',$user_id);
        $this->db->where('sales.created_at >=',$from_date);
        $this->db->where('sales.created_at <=',$to_date);
        $query = $this->db->get();

        if ($query->num_rows() > 0) {

            $categories = $query->result()[0]->total;
        }

        else{

            $categories = 0;

        }

        return $categories;

    }

    public function getMonthlyExpenseReports($user_id='',$from_date='',$to_date='')
    {
        $this->db->select('expence.id as expence_id,ledger.id as ledger_id,ledger.ledger_name,expence.particular,COALESCE(SUM(expence.net_amt),0) AS total_net_amt,COALESCE(SUM(expence.pay_amt),0) AS total_pay_amt,expence.type,expence.status,COALESCE(SUM(expence.pay_amt),0) AS total_balance');
        $this->db->from('expence');
        $this->db->join('ledger','expence.ledger_id = ledger.id');
        $this->db->join('acc_groups', 'ledger.group_id = acc_groups.id');
        $this->db->where('expence.user_id',$user_id);
        $this->db->where('expence.created_at >=',$from_date);
        $this->db->where('expence.created_at <=',$to_date);
        $this->db->group_by('ledger.id');
        $this->db->order_by('ledger.ledger_name','ASC');
        $query = $this->db->get();

        $categories = $query->result();

        $i=0;

        foreach($categories as $p_cat){

            $categories[$i]->date = $this->getMonthlyExpenseReportsByDateSub($p_cat->ledger_id,$from_date,$to_date);

            $i++;
        }

        return $categories;
    }

    public function getMonthlyExpenseReportsByDateSub($ledger_id='',$from_date='',$to_date='')
    {
        $this->db->select('expence.id as expence_id,ledger.id as ledger_id,ledger.ledger_name,expence.particular,expence.ledger_id,COALESCE(SUM(expence.net_amt),0) AS total_net_amt,COALESCE(SUM(expence.pay_amt),0) AS total_pay_amt,COALESCE(SUM(expence.pay_amt),0) AS total_balance,expence.bill_no,expence.created_at,DATE_FORMAT(expence.created_at, "%b") as month,DATE_FORMAT(expence.created_at, "%m") as month_num,expence.type,expence.status,');
        $this->db->from('expence');
        $this->db->join('ledger','expence.ledger_id = ledger.id');
        $this->db->join('acc_groups', 'ledger.group_id = acc_groups.id');
        $this->db->where('expence.created_at >=',$from_date);
        $this->db->where('expence.created_at <=',$to_date);
        $this->db->where('ledger.id =',$ledger_id);
        $this->db->group_by('month');
        $this->db->order_by('month_num','ASC');
        $query = $this->db->get();

        $categories = $query->result();

        return $categories;

    }

    public function getMonthlyExpenseReportsTotal($user_id='',$from_date='',$to_date='')
    {
        $this->db->select('COALESCE(SUM(expence.pay_amt),0) AS total');
        $this->db->from('expence');
        $this->db->where('expence.user_id',$user_id);
        $this->db->where('expence.created_at >=',$from_date);
        $this->db->where('expence.created_at <=',$to_date);
        $query = $this->db->get();

        if ($query->num_rows() > 0) {

            $categories = $query->result()[0]->total;
        }

        else{

            $categories = 0;

        }

        return $categories;

    }

    public function geTotalOpBalanceByLedger($user_id='') {

        $this->db->select("SUM(ledger.op_balance) as total_op_balance");
        $this->db->from("ledger");
        $this->db->where("ledger.status",1);
        $this->db->where("ledger.user_id",$user_id);
        $query = $this->db->get();
        
        if ($query->num_rows() > 0) {

            $res = $query->result()[0]->total_op_balance;
        }
        else{

            $res = 0;

        }

        return $res;
    }


    public function getMonthlyReportsByUser($user_id='',$from_date='',$to_date='') {

        $this->db->select("z.id as id,ledger.id as ledger_id,ledger.op_balance,ledger.ledger_name as ledger_name,z.name,z.particular,z.user_id,z.type,z.status,
        SUM(z.net_amt) AS total_net_amt,SUM(z.pay_amt) AS total_pay_amt,SUM(z.net_amt - z.pay_amt) AS total_balance,0 AS receipt,SUM(z.pay_amt) AS payment");
        $this->db->from("purchase AS z");
        $this->db->join('ledger','z.ledger_id = ledger.id');
        $this->db->where("z.status",1);
        $this->db->where("z.user_id",$user_id);
        $this->db->where('z.created_at >=',$from_date);
        $this->db->where('z.created_at <=',$to_date);
        $this->db->group_by('ledger.id');
        $query1 = $this->db->get_compiled_select(); // It resets the query just like a get()

        $this->db->select("s.id as id,ledger.id as ledger_id,ledger.op_balance,ledger.ledger_name as ledger_name,s.name,s.particular,s.user_id,s.type,s.status,
        SUM(s.net_amt) AS total_net_amt,SUM(s.pay_amt) AS total_pay_amt,SUM(s.pay_amt) AS total_balance,SUM(s.net_amt) AS payment,SUM(s.pay_amt) AS receipt");
        $this->db->from("sales AS s");
        $this->db->join('ledger','s.ledger_id = ledger.id');
        $this->db->where("s.status",1);
        $this->db->where("s.user_id",$user_id);
        $this->db->where('s.created_at >=',$from_date);
        $this->db->where('s.created_at <=',$to_date);
        $this->db->group_by('ledger.id');
        $query2 = $this->db->get_compiled_select(); 

        $this->db->select("e.id as id,ledger.id as ledger_id,ledger.op_balance,ledger.ledger_name as ledger_name,e.name,e.particular,e.user_id,e.type,e.status,SUM(e.net_amt) AS total_net_amt,
        SUM(e.pay_amt) AS total_pay_amt,SUM(e.net_amt) AS total_balance,SUM(e.net_amt) AS receipt,SUM(e.pay_amt) AS payment");
        $this->db->from("expence AS e");
        $this->db->join('ledger','e.ledger_id = ledger.id');
        $this->db->where("e.status",1);
        $this->db->where("e.user_id",$user_id);
        $this->db->where('e.created_at >=',$from_date);
        $this->db->where('e.created_at <=',$to_date);
        $this->db->group_by('ledger.id');
        $query3 = $this->db->get_compiled_select(); 

        $query = $this->db->query($query1." UNION ".$query2." UNION ".$query3." ORDER BY ledger_name ASC");
      
        $categories = $query->result();

        $i=0;

        foreach($categories as $p_cat) {

            if($p_cat->type=="purchase")
            {
                $categories[$i]->date = $this->getMonthlyReportsByPurchaseDateSub($p_cat->ledger_id,$from_date,$to_date);
            }

            if($p_cat->type=="sales")
            {
                $categories[$i]->date = $this->getMonthlyReportsBySaleDateSub($p_cat->ledger_id,$from_date,$to_date);
            }

            if($p_cat->type=="expence")
            {
                $categories[$i]->date = $this->getMonthlyReportsByExpenceDateSub($p_cat->ledger_id,$from_date,$to_date);
            }

            $i++;
        }

        return $categories;
    }

    public function getMonthlyReportsByExpenceDateSub($ledger_id='',$from_date='',$to_date='')
    {
        $this->db->select('expence.id as expence_id,ledger.id as ledger_id,ledger.ledger_name,expence.particular,expence.ledger_id,COALESCE(SUM(expence.net_amt),0) AS total_net_amt,COALESCE(SUM(expence.pay_amt),0) AS total_pay_amt,COALESCE(SUM(expence.pay_amt),0) AS total_balance,expence.bill_no,expence.created_at,DATE_FORMAT(expence.created_at, "%b") as month,DATE_FORMAT(expence.created_at, "%m") as month_num,expence.type,expence.status,');
        $this->db->from('expence');
        $this->db->join('ledger','expence.ledger_id = ledger.id');
        $this->db->join('acc_groups', 'ledger.group_id = acc_groups.id');
        $this->db->where('expence.created_at >=',$from_date);
        $this->db->where('expence.created_at <=',$to_date);
        $this->db->where('ledger.id =',$ledger_id);
        $this->db->group_by('month');
        $this->db->order_by('month_num','ASC');
        $query = $this->db->get();

        $categories = $query->result();

        return $categories;

    }

    public function getMonthlyReportsBySaleDateSub($ledger_id='',$from_date='',$to_date='')
    {
        $this->db->select('sales.id as sales_id,ledger.id as ledger_id,ledger.ledger_name,sales.particular,sales.ledger_id,COALESCE(SUM(sales.net_amt),0) AS total_net_amt,COALESCE(SUM(sales.pay_amt),0) AS total_pay_amt,COALESCE(SUM(sales.net_amt - sales.pay_amt),0) AS total_balance,sales.bill_no,sales.created_at,DATE_FORMAT(sales.created_at, "%b") as month,DATE_FORMAT(sales.created_at, "%m") as month_num,sales.type,sales.status,');
        $this->db->from('sales');
        $this->db->join('ledger','sales.ledger_id = ledger.id');
        $this->db->join('acc_groups', 'ledger.group_id = acc_groups.id');
        $this->db->where('sales.created_at >=',$from_date);
        $this->db->where('sales.created_at <=',$to_date);
        $this->db->where('ledger.id =',$ledger_id);
        $this->db->group_by('month');
        $this->db->order_by('month_num','ASC');
        $query = $this->db->get();

        $categories = $query->result();

        return $categories;

    }

    public function getMonthlyReportsByPurchaseDateSub($ledger_id='',$from_date='',$to_date='')
    {
        $this->db->select('purchase.id as purchase_id,ledger.id as ledger_id,ledger.ledger_name,purchase.particular,purchase.ledger_id,COALESCE(SUM(purchase.net_amt),0) AS total_net_amt,COALESCE(SUM(purchase.pay_amt),0) AS total_pay_amt,COALESCE(SUM(purchase.net_amt - purchase.pay_amt),0) AS total_balance,purchase.bill_no,purchase.created_at,DATE_FORMAT(purchase.created_at, "%b") as month,DATE_FORMAT(purchase.created_at, "%m") as month_num,purchase.type,purchase.status,');
        $this->db->from('purchase');
        $this->db->join('ledger','purchase.ledger_id = ledger.id');
        $this->db->join('acc_groups', 'ledger.group_id = acc_groups.id');
        $this->db->where('purchase.created_at >=',$from_date);
        $this->db->where('purchase.created_at <=',$to_date);
        $this->db->where('ledger.id =',$ledger_id);
        $this->db->group_by('month');
        $this->db->order_by('month_num','ASC');
        $query = $this->db->get();

        $categories = $query->result();

        return $categories;

    }
    
    public function getOwnerallReports($user_id='',$from_date='',$to_date='')
    {
        $this->db->select('user_registration.id,user_registration.branch_name,user_registration.phone,user_registration.location,user_registration.address,user_registration.status');
        $this->db->from('user_registration');
        $this->db->where('user_registration.role','admin');
        $this->db->where('user_registration.status',1);
        $this->db->order_by('user_registration.id','ASC');
        $query = $this->db->get();

        $categories = $query->result();

        $i=0;

        foreach($categories as $p_cat){

            $purchase = $this->getOwnerPurchaseReportsUserBySub($p_cat->id,$from_date,$to_date);

            $expense = $this->getOwnerExpenseReportsUserBySub($p_cat->id,$from_date,$to_date);

            $sales = $this->getOwnerSalesReportsUserBySub($p_cat->id,$from_date,$to_date);

            $opbalance = $this->getLedgerOpBalUserBySub($p_cat->id);

            $total = $purchase[0]->total_pay_amt + $expense[0]->total_pay_amt;

            $categories[$i]->payment = $total;

            $categories[$i]->receipt = $sales[0]->total_net_amt;

            $categories[$i]->balance = $categories[$i]->receipt - $categories[$i]->payment;

            $categories[$i]->out_standing  =$purchase[0]->total_balance + $opbalance;

            $i++;
        }

        return $categories;
    }

    public function getLedgerOpBalUserBySub($user_id='')
    {
        $this->db->select('SUM(ledger.op_balance) AS op_balance');
        $this->db->from('ledger');
        $this->db->where('ledger.user_id',$user_id);
        $query = $this->db->get();

        if ($query->num_rows() > 0) {

            $res = $query->result()[0]->op_balance;
        }
        else{

            $res = 0;

        }

        return $res;
    }

    public function getOwnerPurchaseReportsUserBySub($user_id='',$from_date='',$to_date='')
    {
        $this->db->select('purchase.id,ledger.id as ledger_id,purchase.particular,purchase.ledger_id,purchase.bill_no,purchase.type,purchase.status,COALESCE(SUM(purchase.net_amt),0) AS total_net_amt,COALESCE(SUM(purchase.pay_amt),0) AS total_pay_amt,COALESCE(SUM(purchase.net_amt - purchase.pay_amt),0) AS total_balance');
        $this->db->from('purchase');
        $this->db->join('ledger','purchase.ledger_id = ledger.id');
        $this->db->join('acc_groups', 'ledger.group_id = acc_groups.id');
        $this->db->where('purchase.user_id',$user_id);
        $this->db->where('purchase.created_at >=',$from_date);
        $this->db->where('purchase.created_at <=',$to_date);
        $query = $this->db->get();

        $categories = $query->result();        

        return $categories;

    }

    public function getOwnerSalesReportsUserBySub($user_id='',$from_date='',$to_date='')
    {
        $this->db->select('sales.id as id,ledger.id as ledger_id,ledger.ledger_name,sales.particular,sales.ledger_id,sales.bill_no,sales.created_at,DATE_FORMAT(sales.created_at, "%a") as day,DATE_FORMAT(sales.created_at, "%w") as day_num,sales.type,sales.status,COALESCE(SUM(sales.net_amt),0) AS total_net_amt,COALESCE(SUM(sales.pay_amt),0) AS total_pay_amt,COALESCE(SUM(sales.net_amt - sales.pay_amt),0) AS total_balance');
        $this->db->from('sales');
        $this->db->join('ledger','sales.ledger_id = ledger.id');
        $this->db->join('acc_groups', 'ledger.group_id = acc_groups.id');
        $this->db->where('sales.user_id',$user_id);
        $this->db->where('sales.created_at >=',$from_date);
        $this->db->where('sales.created_at <=',$to_date);
        $query = $this->db->get();

        $categories = $query->result();        

        return $categories;

    }

    public function getOwnerExpenseReportsUserBySub($user_id='',$from_date='',$to_date='')
    {
        $this->db->select('expence.id as id,ledger.id as ledger_id,ledger.ledger_name,expence.particular,expence.ledger_id,expence.bill_no,expence.created_at,DATE_FORMAT(expence.created_at, "%a") as day,DATE_FORMAT(expence.created_at, "%w") as day_num,expence.type,expence.status,SUM(expence.net_amt) AS total_net_amt,COALESCE(SUM(expence.pay_amt),0) AS total_pay_amt,COALESCE(SUM(expence.pay_amt - expence.net_amt),0) AS total_balance');
        $this->db->from('expence');
        $this->db->join('ledger','expence.ledger_id = ledger.id');
        $this->db->join('acc_groups', 'ledger.group_id = acc_groups.id');
        $this->db->where('expence.user_id',$user_id);
        $this->db->where('expence.created_at >=',$from_date);
        $this->db->where('expence.created_at <=',$to_date);
        $query = $this->db->get();

        $categories = $query->result();        

        return $categories;

    }
    
    

                   
}

?>