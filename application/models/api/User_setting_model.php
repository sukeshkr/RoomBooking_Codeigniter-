<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class User_setting_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        
        //load database library
        $this->load->database();
    }

    var $table = 'user_registration';
    var $order = array('id' => 'desc');

    public function getUserNotification($id='') {

        $this->db->select("user_registration.notification");
        $this->db->from('user_registration');
        $this->db->where('user_registration.id',$id);
        $this->db->where('user_registration.status',1);
        $query = $this->db->get();

        $result= $query->result_array();

        return $result[0]['notification'];
        
    }

    public function setNotificationStatus($user_id='',$status='') {

        $value= array('notification' => $status);

        $this->db->update('user_registration', $value, array('id'=>$user_id));      

        return true;
    }



    public function putUserDeactivateData($status='',$user_id='') {       

        $value= array('status' => $status);

        $this->db->update('user_registration', $value, array('id'=>$user_id));

        return ($this->db->affected_rows() != 1) ? false : true;
           
    }

    public function getUserDeactivateData($user_id='')
    {

        $this->db->select("user_registration.id,user_registration.user_name,user_registration.location,user_registration.prof_image,user_registration.status");
        $this->db->from('user_registration');
        $this->db->order_by('user_registration.id','DESC');
        $this->db->where('user_registration.id',$user_id);
        $query = $this->db->get();

        return $query->result_array();
    }


    public function changePhoneNumber($user_id='',$new_number='') {

        $this->db->where('phone',$new_number);
        $query = $this->db->get('user_registration');

        if ($query->num_rows() >= 1) {

            return false;
        }

        else{

            $value= array('phone' => $new_number);

            $this->db->update('user_registration', $value, array('id'=>$user_id));

            return true;
        }
    }

    public function insertKey($value,$mobile,$key_word,$time) { 

        $this->db->where('mobile',$mobile);
        $query = $this->db->get('otp_table');

        $update_val=array('key_word'=> $key_word,'date_exp'=>$time,'create_at'=>date("Y-m-d H:i:s"));

        if($query->num_rows()  > 0 )
        {
            $this->db->where('mobile',$mobile);
            $this->db->update('otp_table',$update_val);
            return true;
        }

       else{

         $this->db->insert('otp_table', $value);
          return true;
       }

    }

    public function checkPhoneData($mobile,$id)
    {
        $this->db->where('user_registration.phone',$mobile);
        $this->db->where('user_registration.id',$id);
        $query = $this->db->get('user_registration');

        if ($query->num_rows() >= 1) {

            return true;
        }

        else{
            return false; 
        }
    }
    public function checkNumberExp($key,$number,$time)
    {

        $this->db->where('mobile',$number);
        $this->db->where('date_exp <=',$time);
        $query = $this->db->get('otp_table');

        if ($query->num_rows() > 0){
            return false; 
        }
        else{
            return true; 
        }
    }

    public function checkOtpNumber($key,$number)
    {

        $this->db->where('mobile',$number);
        $this->db->where('key_word',$key);
        $query = $this->db->get('otp_table');

        if ($query->num_rows() > 0){

            return true;        
        }
        else{

           return false;
        }
    }

     public function updateFcmToken($fcm_token,$mobile) { 

        $update_val=array('fcm_token'=> $fcm_token);

        $this->db->where('mobile',$mobile);
        $this->db->update('otp_table',$update_val);
        return true;

    }

    public function getPdfData($id='') {

        $this->db->select("");
        $this->db->from('ledger');
        $query = $this->db->get();

        $result= $query->result_array();

        return $result;
        
    }


    public function getPdf($id='') {

        $query = $this->db->query("SHOW columns FROM ledger");

        $result= $query->result_array();

        return $result;
        
    }
   
}

?>