<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Feedback_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        
        //load database library
        $this->load->database();
    }

    var $table = 'user_feedback';
    var $order = array('id' => 'desc');

    public function insertFeedback($data='') { 

        $this->db->insert($this->table, $data);

        return ($this->db->affected_rows() != 1) ? false : true;
    }


    public function insertUserReportIssue($data='') { 

        $this->db->insert('user_report_issue', $data);

        return ($this->db->affected_rows() != 1) ? false : true;
    }

    public function insertSellerFeedback($data='') { 

        $this->db->insert('seller_feedback', $data);

        return ($this->db->affected_rows() != 1) ? false : true;
    }

    public function insertSellerReportIssue($data='') { 

        $this->db->insert('seller_report_issue', $data);

        return ($this->db->affected_rows() != 1) ? false : true;
    }

    public function getUserFeedBackList($id='')
    {
        $this->db->select('user_feedback.id,user_feedback.user_id,user_feedback.feel_about,user_feedback.feedback_message,user_feedback.created_at,user_registration.user_name,user_registration.phone,user_feedback.status');
        $this->db->from('user_feedback');
        $this->db->join('user_registration', 'user_feedback.user_id = user_registration.id');
        $this->db->where('user_feedback.user_id',$id);
        $this->db->order_by('user_feedback.id','DESC');
        $query = $this->db->get();

        return $query->result_array();
    }

    public function getSellerFeedBackList($id='')
    {
        $this->db->select('seller_feedback.id,seller_feedback.seller_id,seller_feedback.feel_about,seller_feedback.feedback_message,seller_feedback.created_at,register.bus_name,register.phone,seller_feedback.status');
        $this->db->from('seller_feedback');
        $this->db->join('register', 'seller_feedback.seller_id = register.reg_id');
        $this->db->where('seller_feedback.seller_id',$id);
        $this->db->order_by('seller_feedback.id','DESC');
        $query = $this->db->get();

        return $query->result_array();
    }

    public function getUserReportIssue($id='')
    {
        $this->db->select('user_report_issue.id,user_report_issue.user_id,user_report_issue.priority,user_report_issue.problem,user_report_issue.report_message,user_report_issue.created_at,user_registration.user_name,user_registration.phone,user_report_issue.status');
        $this->db->from('user_report_issue');
        $this->db->join('user_registration', 'user_report_issue.user_id = user_registration.id');
        $this->db->where('user_report_issue.user_id',$id);
        $this->db->order_by('user_report_issue.id','DESC');
        $query = $this->db->get();

        return $query->result_array();
    }

    public function getSellerReportIssue($id='')
    {
        $this->db->select('seller_report_issue.id,seller_report_issue.seller_id,seller_report_issue.priority,seller_report_issue.problem,seller_report_issue.report_message,seller_report_issue.created_at,register.bus_name,register.phone,seller_report_issue.status');
        $this->db->from('seller_report_issue');
        $this->db->join('register', 'seller_report_issue.seller_id = register.reg_id');
        $this->db->where('seller_report_issue.seller_id',$id);
        $this->db->order_by('seller_report_issue.id','DESC');
        $query = $this->db->get();

        return $query->result_array();
    }


}
