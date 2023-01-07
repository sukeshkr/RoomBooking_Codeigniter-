<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

Class User_login_model extends MY_model {

    public function __construct() {

        parent::__construct();
        $this->load->database();
    }

    var $table = 'branch';

    public function loginWithCredentials($userid) //check email id and password are equal with DB email id and password.
    {

        $this->db->select('*');

        $this->db->from($this->table);

        $this->db->where('userid', $userid);

        $this->db->where('status',1);

        $query = $this->db->get();

        return $query->row();

    }

    public function insertKey($value,$id) { 

        $this->db->where('user_id',$id);
        $query = $this->db->get('otp_table');

        if($query->num_rows()  > 0 )
        {
            $this->db->where('user_id',$id);
            $this->db->update('otp_table',$value);
            return true;
        }

       else{

         $this->db->insert('otp_table', $value);
          return true;
       }

    }

    public function insertKeyByEmail($value,$email) { 

        $this->db->where('mobile',$email);
        $query = $this->db->get('otp_table');

        if($query->num_rows()  > 0 )
        {
            $this->db->where('mobile',$email);
            $this->db->update('otp_table',$value);
            return true;
        }

       else{

         $this->db->insert('otp_table', $value);
          return true;
       }

    }

    public function checkOtpNumber($key,$email)
    {

        $this->db->where('mobile',$email);
        $this->db->where('key_word',$key);
        $query = $this->db->get('otp_table');

        if ($query->num_rows() > 0){

            return true;        
        }
        else{

           return false;
        }
    }

    public function updatePassword($password,$id)
    {

        $value = array('auth_key' =>$password );

        $this->db->where('branch.id', $id);
        $this->db->update('branch', $value);

        return true;
    }

    public function getWithCredentials($user_id) //check email id and password are equal with DB email id and password.
    {

        $this->db->select('*');

        $this->db->from($this->table);

        $this->db->where('id', $user_id);

        $this->db->where('status',1);

        $query = $this->db->get();

        return $query->row();

    }

    public function getWithCredentialsByEmail($email) //check email id and password are equal with DB email id and password.
    {

        $this->db->select('*');

        $this->db->from($this->table);

        $this->db->where('email', $email);

        $this->db->where('status',1);

        $query = $this->db->get();
        
        return $query->row();

    }

    
}