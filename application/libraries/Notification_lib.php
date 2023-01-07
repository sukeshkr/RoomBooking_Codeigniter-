<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Notification_lib  {

    public function __construct() {

        $this->CI =& get_instance();
    }

    public function test($id) { 

        $result =$this->CI->Notification_model->getSingleTokenBySellerData($seller_id);


    }

    public function get_single_token_byuser_post($user_id) {

        $this->CI->load->model('api/Notification_model');

        $result =$this->CI->Notification_model->getSingleTokenByUserData($user_id);

        $tokens = array();

        array_push($tokens, $result[0]['fcm_token']);

        return $tokens;
    }

    public function get_token_byuser_post($user_id) {

        $this->CI->load->model('api/Notification_model');

        $result = $this->CI->Notification_model->getTokenByUserData($user_id);

        $tokens = array();
        
        foreach ($result as $token) {

            if(isset($token[0]['fcm_token'])){

                array_push($tokens, $token[0]['fcm_token']);
            }

        }

        return $tokens;
    }

    public function get_single_token_byseller_post($seller_id) {

        $this->CI->load->model('api/Notification_model');

        $result =$this->CI->Notification_model->getSingleTokenBySellerData($seller_id);

        $tokens = array();

        foreach ($result as $token) {

            if(isset($token[0]['seller_fcm_token'])){

                array_push($tokens, $token[0]['seller_fcm_token']);
            }

        }

        return $tokens;
    }

    public function get_token_byseller_post($seller_id) {

        $this->CI->load->model('api/Notification_model');

        $result = $this->CI->Notification_model->getTokenBySellerData($seller_id);

        $tokens = array();
        
        foreach ($result as $token) {

            if(isset($token[0]['seller_fcm_token'])){

                array_push($tokens, $token[0]['seller_fcm_token']);
            }

        }

        return $tokens;
    }

    public function send_post($registration_ids, $message) { //user notification function

        $fields = array(
            'registration_ids' => $registration_ids,
            'data' => $message,
        );

        return $this->sendPushNotification_post($fields);
    }
    
    private function sendPushNotification_post($fields) { //user notification function

        //firebase server url to send the curl request
        $url = 'https://fcm.googleapis.com/fcm/send';

        //building headers for the request
        $headers = array(
            'Authorization: key=' . FIREBASE_API_KEY,
            'Content-Type: application/json'
        );
 
        //Initializing curl to open a connection
        $ch = curl_init();
 
        //Setting the curl url
        curl_setopt($ch, CURLOPT_URL, $url);
        
        //setting the method as post
        curl_setopt($ch, CURLOPT_POST, true);
 
        //adding headers 
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
 
        //disabling ssl support
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        
        //adding the fields in json format 
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
 
        //finally executing the curl request 
        $result = curl_exec($ch);

        if ($result === FALSE) {
            die('Curl failed: ' . curl_error($ch));
        }
 
        //Now close the connection
        curl_close($ch);
 
        //and return the result 
        return $result;
    }

    public function send_seller_post($registration_ids, $message) { //seller notification function

        $fields = array(
            'registration_ids' => $registration_ids,
            'data' => $message,
        );

        return $this->sendPushNotification_seller_post($fields);
    }

    private function sendPushNotification_seller_post($fields) { //seller notification function

        //firebase server url to send the curl request
        $url = 'https://fcm.googleapis.com/fcm/send';

        //building headers for the request
        $headers = array(
            'Authorization: key=' . FIREBASE_API_KEY_SELLER,
            'Content-Type: application/json'
        );

        //Initializing curl to open a connection
        $ch = curl_init();
 
        //Setting the curl url
        curl_setopt($ch, CURLOPT_URL, $url);
        
        //setting the method as post
        curl_setopt($ch, CURLOPT_POST, true);
 
        //adding headers 
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
 
        //disabling ssl support
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        //adding the fields in json format 
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
 
        //finally executing the curl request 
        $result = curl_exec($ch);

        if ($result === FALSE) {
            die('Curl failed: ' . curl_error($ch));
        }
 
        //Now close the connection
        curl_close($ch);

        //and return the result 
        return $result;

    }

}