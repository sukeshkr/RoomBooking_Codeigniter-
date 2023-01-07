<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

Class Customer_model extends MY_model {

    public function __construct() {

        parent::__construct();
        $this->load->database();
    }

    var $table = 'customer';


    public function insertCustomerRegister($data='',$id='')
    {

        if(empty($id)) {

            $this->db->insert($this->table, $data);

            $insert_id = $this->db->insert_id();

            return $insert_id;
            
        }
        else{

            $this->db->where('customer.id',$id);
            $this->db->update($this->table, $data);

            return $id;
        }      

    }

    public function putCustomerDeactivateData($status='',$id='') {       

        $value= array('status' => $status);

        $this->db->update('customer', $value, array('id'=>$id));

        return ($this->db->affected_rows() != 1) ? false : true;
           
    }

    public function getCustomerDeactivateData($user_id='') {

        $this->db->select("customer.id,customer.name,customer.address,customer.country,customer.prof_image,customer.id_proof_type,customer.id_proof_no,customer.reference,customer.phone,customer.email,customer.phone1,customer.status");
        $this->db->from('customer');
        $this->db->order_by('customer.id','DESC');
        $query = $this->db->get();

        return $query->result_array();
    }

    public function getCustomerData()
    {

        $this->db->select("customer.id,customer.name,customer.address,customer.country,customer.prof_image,customer.id_proof_type,customer.id_proof_no,customer.reference,customer.phone,customer.email,customer.phone1,customer.state,customer.status");
        $this->db->from('customer');
        $this->db->order_by('customer.id','DESC');
        $query = $this->db->get();

        return $query->result_array();
    }

   

    
}