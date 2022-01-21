<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Forgotpassword extends MY_Controller {

    public function index($tokenID = 'token'){
        $tokenID = $this->mysecurity->decrypt_url($tokenID);

        $chkdata = array ('select' => '*','where' => array('forgot_id' => $tokenID));
        $getTokenData = $this->MY_Model->getRows('ahs_forgotpassword',$chkdata);
        if($getTokenData > 0) {
            $date_expire 	= $getTokenData[0]['date_added'];
            $date			= new DateTime($date_expire);
            $now 			= new DateTime();
            $diff 			= $date->diff($now)->format("%d");
            $used		    = FALSE;

            if($getTokenData[0]['expired'] != 0 || $diff != 0 ) {
                $used	    = TRUE;
            }
            $data = array(
                'title'     => 'Forgot Password',
                'user_id'   => $getTokenData[0]['fk_userid'],
                'token'     => $getTokenData[0]['forgot_id'],
                'used'      => $used,
            );
            $this->login_page('index',$data);
        }
    }

    public function changePassword(){
        $this->form_validation->set_rules('pass', 'New Password', 'trim|required');
        $this->form_validation->set_rules('cpass', 'New Password Confirmation', 'trim|required');
        if ($this->form_validation->run() === FALSE) {
            $this->login_page('index');
        }else{
            $pass       = trim($this->input->post('pass'));
            $user_id    = trim($this->input->post('fk_userid'));
            $forgot_id    = trim($this->input->post('forgot_id'));
            //Update User Password
            $passdata = array(
                'set'   => array('password'  => password_hash($pass, PASSWORD_DEFAULT),'date_updated' => date('Y-m-d H:i:s')),
                'where' => array('user_id' => $user_id)
            );
            $updatepass = $this->MY_Model->update('ahs_users',$passdata['set'],$passdata['where']);
            // Update Token To Expired
            $tokendata = array(
                'set'   => array('expired'  => 0),//0 - Expired
                'where' => array('forgot_id' => $forgot_id)
            );
            $updatetoken = $this->MY_Model->update('ahs_forgotpassword',$tokendata['set'],$tokendata['where']);
            if ($updatepass && $updatetoken) {
                $datas = array(
                    'title'     => 'Password Updated',
                );
                $this->login_page('passupdated',$datas);
            } else {
                $this->session->set_flashdata('error', 'Something went wrong');
            }
        }
    }
}

?>

