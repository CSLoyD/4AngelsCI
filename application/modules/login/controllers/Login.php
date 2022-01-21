<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends MY_Controller {

	public function index(){
		$data = array(
            'title' => 'Login',
        );
        $this->login_page('index',$data);
		
	}

	public function auth(){
		$title = array('title' => 'Login');
		$this->form_validation->set_rules('uname', 'Username / Email Address', 'trim|required');
        $this->form_validation->set_rules('pass', 'Password', 'trim|required');
		if ($this->form_validation->run() === FALSE) {
	        $this->login_page('index',$title);
        }else{
			$user = trim($this->input->post('uname'));
			$pass = trim($this->input->post('pass'));
			$data = array(
               'select' => '*',
               'where' => array('username' => $user),
               'or_where' => array('email' => $user),
            );
			$query = $this->MY_Model->getRows('ahs_users',$data,'obj');
			if (!$query) {
				$this->session->set_flashdata('error', 'No record found');
		        $this->login_page('index',$title);
			}else{
				$verifypass = password_verify($pass, $query[0]->password);
				if ($verifypass) {
					if ($query[0]->user_status == 2) {
						$this->session->set_flashdata('error', 'This account has been disabled');
				        $this->login_page('index',$title);
					} else if($query[0]->user_status == 0) {
						$this->session->set_flashdata('error', 'No record found');
				        $this->login_page('index',$title);
					} else{
						$arr_session = array(
							'user_id'		=> $query[0]->user_id,
							'user_type'		=> $query[0]->user_type,
							'username'		=> $query[0]->username,
						);
						$this->session->set_userdata($arr_session);
						redirect(base_url('employees'));
					}
				}else{
					$this->session->set_flashdata('error', 'Invalid Credentials');
			        $this->login_page('index',$title);
				}

			}

        }
	}
	// Forgot Password Functionality
	public function forgotPass(){
		$respond = array();
        if (isset($_POST)) {
			$ctr = 0;

            //validation for inputs
			foreach ($_POST as $key => $value) {
				$name = ucfirst(str_replace('_', ' ', $key));
				$this->form_validation->set_rules($key, $name, 'trim|required', array('required' => '{field} is required'));
				if (!$this->form_validation->run()) {
					if ($value == '') {
						$respond[$key] = form_error($key);
						$ctr += 1;
					}
				}
			}
            if ($ctr == 0) {
				$email	= trim($this->input->post('email'));
				$base_url	= trim($this->input->post('base_url'));
				$chkmail = array(
					'select'	=> '*',
					'where'		=> array('email' => $email),
				);
				$chkemail = $this->MY_Model->getRows('ahs_users',$chkmail);
				if(!$chkemail) {
					$respond['email'] = 'Email Not Found';
					$ctr += 1;
				} else {
					$chkstat = array(
						'select'	=> 'user_status',
						'where'		=> array('user_status' => 2),
					);
					$chkstatus = $this->MY_Model->getRows('ahs_users',$chkstat);
					if($chkstatus) {
						$respond['email'] = 'Account Has Been Disabled By Admin';
						$ctr += 1;
					} else {
						$token	= $chkemail[0]['user_id'].'|'.date("Ymdhis");
						$name	= $chkemail[0]['firstname'];
						$passData= array(
							'fk_userid'	=> $chkemail[0]['user_id'],
							'token'		=> $token,
						);
						$insertForgot = $this->MY_Model->insert('ahs_forgotpassword',$passData);
						$subject = 'Forgot Password';
						$tokenID = $this->mysecurity->encrypt_url($insertForgot);
						$siteurl = str_replace('/employee-schedule/', '', $base_url);
						$url = "{$base_url}/forgotpassword/index/{$tokenID}";

						$message = '<div style="margin-bottom:10px;text-align:center;">Change Password</div>
						<div class="form_table" style="width:700px; height:auto; font-size:12px; color:#333333; letter-spacing:1px; line-height:20px; margin: 0 auto;">
						<div style="border:8px double #c3c3d0; padding:12px;">
						<table width="90%" cellspacing="2" cellpadding="5" align="center" style="font-family:Verdana; font-size:13px">
						<tr><td>Hello '.$name.',</td></tr>
						<tr><td>A request has been received to change the password for your 4Angels Healthcare account</td></tr>
						<tr><td><br /></td></tr>
						<tr><td><button><a href='.$url.' style="text-decoration: none;color:#000"> Reset Password </a></button></td></tr>
						<tr><td><br /></td></tr>
						<tr><td>If you did not initiate this request, please contact us immediately at </td></tr>
						<tr><td><a href="'.$siteurl.'/charity-organization-contact-us">Contact Us</a></td></tr>
						<tr><td><br /></td></tr>
						<tr><td><br /></td></tr>
						<tr><td>Thank you,</td></tr>
						<tr><td>The 4Angels Healthcare Team</td></tr>
						</table></div></div>';
						// sent to user
						$this->sendmail($email,'4Angels Healthcare',$subject,$message,true,'');
						$respond['status'] = "success";
						$respond['msg'] = 'Please Check The Inbox On Your Email';
					}
				}
			}
			json($respond);
        }
	}

}

?>
