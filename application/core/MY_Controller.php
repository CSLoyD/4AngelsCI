<?php
defined('BASEPATH') OR exit('No direct script access allowed');

ob_start();

class MY_Controller extends MX_Controller {
	public $assets_ = array(
		'users' => array(
			'css' => array(),
			'js' => array('users.min.js'),
		),
		'login' => array(
			'css' => array('login.min.css'),
			'js' => array('login.min.js'),
		),
		'employees' => array(
			'css' => array('employees.min.css'),
			'js' => array('employees.min.js'),
		),
		'facilities' => array(
			'css' => array('facilities.css'),
			'js' => array('facilities.min.js'),
		),
		'attendance' => array(
			'css' => array(),
			'js' => array('attendance.min.js'),
		),
		'schedules' => array(
			'css' => array(),
			'js' => array('schedules.min.js'),
		),
		'shifts' => array(
			'css' => array('shifts.min.css'),
			'js' => array('shifts.min.js'),
		),
		'notifications' => array(
			'css' => array('cPager.css', 'custom-notifs.css'),
			'js' => array('notifications.min.js', 'template.js', 'cPager.js'),
		),
	);

	public $_token = "ChrisnilLoydAlextidesRonald";

	public function __construct(){
		$this->_token = sha1($this->_token);
		$route = $this->router->fetch_class();
		$exceptions = array('forgotpassword','reactapi');
		if(!in_array($route,$exceptions)) {
			if($route == 'login'){
				if($this->session->has_userdata('user_id','user_type')){
					redirect(base_url('employees'));
				}
			} else {
				if(!$this->session->has_userdata('user_id','user_type')){
					redirect(base_url('login'));
				}
			}
		}
	}

	public function load_page($page, $data = array()){
		$data['profile'] = $this->get_profile();
		$data['route'] = $this->router->fetch_class();
		$data['__assets__'] = $this->assets_;
      	$this->load->view('includes/head',$data);
      	$this->load->view($page,$data);
      	$this->load->view('includes/footer',$data);
    }

	public function login_page($page, $data = array()){
		$data['__assets__'] = $this->assets_;
      	$this->load->view('includes/login_head',$data);
      	$this->load->view($page,$data);
      	$this->load->view('includes/login_footer',$data);
    }

	public function get_profile(){
		$data = array(
			'select' => 'firstname,lastname,username,email',
			'where'	 => array('user_id' => $_SESSION['user_id']),
		);
		$query = $this->MY_Model->getRows('ahs_users',$data,'row');
		return $query;
	}

	protected function generate_num($strength = 4) {
        $permitted_chars = '0123456789';
        $input_length = strlen($permitted_chars);
        $random_string = '';
        for ($i = 0; $i < $strength; $i++) {
            $random_character = $permitted_chars[mt_rand(0, $input_length - 1)];
            $random_string .= $random_character;
        }

        return $random_string;
	}

	protected function generate_code($strength = 20) {
        $permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $input_length = strlen($permitted_chars);
        $random_string = '';
        for ($i = 0; $i < $strength; $i++) {
            $random_character = $permitted_chars[mt_rand(0, $input_length - 1)];
            $random_string .= $random_character;
        }
        return strtolower($random_string);
	}

	public function exist_email_address($email=''){
		$isexist = false;
		$users_email = $this->MY_Model->getRows('ecl_users',array('select'=>"email_address",'where'=>array('email_address'=>$email)));
		if ($users_email) {
			$isexist = true;
		}
		return $isexist;
	}

	public function exist_username($uname=''){
		$isexist = false;
		$users_uname = $this->MY_Model->getRows('ecl_users',array('select'=>"username",'where'=>array('username'=>$uname)));
		if ($users_uname) {
			$isexist = true;
		}
		return $isexist;
	}

	public function exist_code($code=''){
		$isexist = false;
		$iscode = $this->MY_Model->getRows('ecl_discounts',array('select'=>"code",'where'=>array('code'=>$code)));
		if ($iscode) {
			$isexist = true;
		}
		return $isexist;
	}

	public function set_rules_from_post($data, $unrequired_fields=array()){
		$email = '';
		$uname = '';
		if (isset($_POST['email_address'])) {
			if (isset($_POST['orig_email_address'])) {
				$email = ($_POST['orig_email_address'] != $_POST['email_address'])?'|is_unique[ecl_users.email_address]':'';
			}else{
				$email = '|is_unique[ecl_users.email_address]';
			}
		}
		if (isset($_POST['username'])) {
			if (isset($_POST['orig_username'])) {
				$uname = ($_POST['orig_username'] != $_POST['username'])?'|is_unique[ecl_users.username]':'';
			}else{
				$uname = '|is_unique[ecl_users.username]';
			}
		}
		foreach ($data as $key => $value) {
			if(!empty($unrequired_fields) && in_array($key, $unrequired_fields)) continue;
			$this->form_validation->set_rules($key, ucfirst(str_replace('_', ' ', $key)), 'trim|required', array('required' => '{field} is required'));
			if($key == 'username'){
				$rule = $this->form_validation->set_rules($key, 'Username', 'trim|required'.$uname, array('is_unique' => 'The Username already exists.'));
				$rule;
			}
			if($key == 'email_address'){
				$rule = $this->form_validation->set_rules($key, 'Email Address', 'trim|required|valid_email'.$email, array('valid_email' => 'Please provide a valid {field}','is_unique' => 'The Email Address already exists.'));
				$rule;
			}
			if ($key == 'confirm_password') {
				$rule = $this->form_validation->set_rules($key, 'Password Confirmation', 'trim|required|matches[password]');
				$rule;
			}
		}
	}


	protected function sendmail($to_email='web2.loyd@gmail.com',$from_name='sanaol',$subject='Email Notification',$message='',$use_html_template=false,$cc=""){
		  $config = Array(
              	'protocol' 	  => 'smtp',
                'smtp_host'   => 'secure.emailsrvr.com',
                'smtp_port'   => 587,
                'smtp_user'   => 'onlineform12@proweaver.net',
                'smtp_pass'   => 'qSit1#nc1_flrORLWM',
  				'mailtype' 	  => 'html',
  		        'charset'     => 'iso-8859-1',
  		        'wordwrap' 	  => TRUE,
  		        'set_newline' => "\r\n"
          );
		$this->load->library('email');
		$this->email->initialize($config);
		$this->email->set_mailtype("html");
 		$this->email->set_newline("\r\n");
 		$this->email->to($to_email);
		!empty($cc)? $this->email->cc($cc): "";
 		$this->email->from('onlineform@proweaver.net',$from_name);
 		$this->email->subject($subject);
		$this->email->message($message);
		if ($use_html_template) {
			$messageData['title']   =$subject;
			$messageData['content'] =$message;
			$message = $this->load->view('mail_template',$messageData,true);
	 		$this->email->message($message);
		}else{
	 		$this->email->message($message);
		}
		if($this->email->send()){
			return true;
		}else{
			return false;
		}
	}

	public function schedule_notif($page, $data = array(), $add_to_footer="",$add_to_header=""){
		// $params['select'] = "*";
		// $params['where'] = array('notif_status' => "unread");
		// $data = $this->MY_Model->getRows('ahs_notifications', $params, 'row');
		// return $data;

		// $data = array(
		// 	'select' => '*',
		// 	'where'	 => array('notif_status' => "unread"),
		// );
		// $query = $this->MY_Model->getRows('ahs_notifications',$data,'row');
		// return $query;
	
		$data["notifs"] = $this->db->
		select('*')->
		where('notif_status', 'unread')->
		limit(3)->
		order_by('date_added', 'DESC')->
		from('ahs_notifications')->
		get()->result();

		if (!empty($add_to_footer)) {
			$data["add_to_footer"]=$add_to_footer;
		}
		if (!empty($add_to_header)) {
			$data["add_to_header"]=$add_to_header;
		}

		$data['route'] = $this->router->fetch_class();
		$data['__assets__'] = $this->assets_;
      	$this->load->view('includes/head',$data);
      	$this->load->view($page,$data);
      	$this->load->view('includes/footer',$data);
	}

}
