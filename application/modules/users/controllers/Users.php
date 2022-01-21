<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends MY_Controller {

	public function index(){
		if($_SESSION['user_type'] == 1) {
		$data = array(
			'title'			=> 'Users',
		);
		$this->load_page('index',$data);
		} else {
			redirect(base_url('employees'));
		}
	}

	// Fetch Data for Datatable
	public function getUsersList(){
		$filter = $_POST['filter'];
		$limit = $this->input->post('length');
		$offset = $this->input->post('start');
		$search = $this->input->post('search');
		$order = $this->input->post('order');
		$draw = $this->input->post('draw');
		$select = "user_id,CONCAT(firstname,' ',lastname) as fullname, email, user_status,user_type";
		$column_order = array('user_id','firstname','email','user_status','user_id');
		$join = array();
		$where = "user_status != 0";
		($filter != 'all') ? $where .= " AND user_type = '$filter'" : "" ;
		$list = $this->MY_Model->get_datatables('ahs_users',$column_order, $select, $where, $join, $limit, $offset ,$search, $order);
		$new_array = array();
        foreach ($list['data'] as $key => $value) {
            $new_array[] = $value;
        }
		$output = array(
			"draw" => $draw,
			"recordsTotal" => $list['count_all'],
			"recordsFiltered" => $list['count'],
			"data" => $new_array,
		);
		echo json_encode($output);
	}

	public function addUser(){
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
				$usertype		= trim($this->input->post('usertype'));
				$firstname		= trim($this->input->post('firstname'));
				$lastname		= trim($this->input->post('lastname'));
				$email			= trim($this->input->post('email'));
				$username		= trim($this->input->post('username'));
				$password		= trim($this->input->post('password'));
				$cpassword		= trim($this->input->post('cpassword'));

				if($cpassword != $password) {
					$respond['cpassword'] = 'Password does not match';
					$ctr += 1;
				} else {
					$chkuser = array(
						'select'	=> 'username',
						'where'		=> array('username' => $username),
					);
					$chkusername = $this->MY_Model->getRows('ahs_users',$chkuser);
					if($chkusername) {
						$respond['username'] = 'Username Exists';
						$ctr += 1;
					} else {
						$chkmail = array(
							'select'	=> 'email',
							'where'		=> array('email' => $email),
						);
						$chkmail = $this->MY_Model->getRows('ahs_users',$chkmail);
						if($chkmail) {
							$respond['email'] = 'Email Exists';
							$ctr += 1;
						} else {
							$savedata= array(
								'user_type'			=> $usertype,
								'firstname'			=> $firstname,
								'lastname'			=> $lastname,
								'email'				=> $email,
								'username'			=> $username,
								'password'			=> password_hash($password, PASSWORD_DEFAULT),
							);
							$insertuser = $this->MY_Model->insert('ahs_users',$savedata);
							if ($insertuser) {
								$respond['status'] = "success";
								$respond['msg'] = "User Added Successfully";
							}
						}
					}
				}
			}
			json($respond);
        }
	}
	// Update User Status
	public function userStatus(){
		$user_id = $_POST['user_id'];
		$user_status = $_POST['user_status'];
		$fstatus = ($user_status == 1?2:1);//1 - Active / 2 - Inactive
		$data = array(
			'set'   => array('user_status' => $fstatus,'date_updated' => date('Y-m-d H:i:s')),
			'where' => array('user_id' => $user_id)
		);
		$updateUser = $this->MY_Model->update('ahs_users',$data['set'],$data['where']);
		if ($updateUser) {
			response('success', 'success', 'Status Updated');
		} else {
			response('error', 'danger', 'Something went wrong');
		}
	}

	public function removeUser(){
		$user_id = $_POST['user_id'];
		$data = array(
			'set'   => array( 'user_status' => 0 ),
			'where' => array( 'user_id' => $user_id ),
		);
		$query = $this->MY_Model->update('ahs_users', $data['set'], $data['where']);
		if ($query) {
			$respond['status'] = "success";
			$respond['msg']    = "User has been removed";
		} else {
			$respond['status'] = "error";
			$respond['msg'] = 'Error removing user';
		}
		json($respond);
	}

	public function getUserInfo(){
		$user_id = $_POST['user_id'];
		$parameters['select'] = "user_id,username,email,firstname,lastname,user_type";
		$parameters['where'] = array('user_id' => $user_id);
		$data = $this->MY_Model->getRows('ahs_users', $parameters, 'row');
		json($data);
	}

	public function updateUser(){
		$respond = array();
        if (isset($_POST)) {
			$ctr = 0;

            //validation for inputs
			if(empty($_POST['uppassword'])) {
				unset( $_POST['uppassword']);
				unset( $_POST['upcpassword']);
			} else {
				$password		= trim($this->input->post('uppassword'));
				$cpassword		= trim($this->input->post('upcpassword'));
				if($cpassword != $password) {
					$respond['upcpassword'] = 'Password does not match';
					$ctr += 1;
				}
			}
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
				$user_id		= trim($this->input->post('tbl_user_id'));
				$usertype		= trim($this->input->post('upusertype'));
				$firstname		= trim($this->input->post('upfirstname'));
				$lastname		= trim($this->input->post('uplastname'));
				$email			= trim($this->input->post('upemail'));
				$username		= trim($this->input->post('upusername'));

				$chkuser = array(
					'select'	=> 'username',
					'where'		=> array('username' => $username, 'user_id !=' => $user_id),
				);
				$chkusername = $this->MY_Model->getRows('ahs_users',$chkuser);
				if($chkusername) {
					$respond['upusername'] = 'Username Exists';
					$ctr += 1;
				} else {
					$chkmail = array(
						'select'	=> 'email',
						'where'		=> array('email' => $email, 'user_id !=' => $user_id),
					);
					$chkmail = $this->MY_Model->getRows('ahs_users',$chkmail);
					if($chkmail) {
						$respond['upemail'] = 'Email Exists';
						$ctr += 1;
					} else {
						$updatedata= array(
							'set'	=> array(
								'user_type'			=> $usertype,
								'firstname'			=> $firstname,
								'lastname'			=> $lastname,
								'email'				=> $email,
								'username'			=> $username,
							),
							'where'	=> array('user_id' => $user_id,),
						);
						if(isset($_POST['uppassword']) && !empty($_POST['uppassword'])){
							$updatedata['set']['password'] = password_hash(trim($_POST['uppassword']),PASSWORD_DEFAULT);
						}
						$updateuser = $this->MY_Model->update('ahs_users',$updatedata['set'],$updatedata['where']);
						if ($updateuser) {
							$respond['status'] = "success";
							$respond['msg'] = "User Updated Successfully";
						}
					}
				}
			}
			json($respond);
        }
	}

// End of Functions
}

?>

