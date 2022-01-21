<?php

defined('BASEPATH') OR exit('No direct script access allowed');


class Employees extends MY_Controller {

	public function index(){
		$data = array(
            'title' => 'Employees',
        );
		$this->load_page('index',$data);
	}

	public function viewDocuments($code = 'viewDocs'){
        $data = array(
			'title'   	=> 'Employee Documents',
			'details' 	=> $this->getDocumentDetails($code),
		);
        $this->load_page('documents',$data);
	}

	public function getDocumentDetails($code = 'viewFacility'){
		$data = array(
			'select' => "employee_id, CONCAT(firstname,' ',lastname) as fullname",
			'where'  => array('employee_code' => $code)
		);
		$query = $this->MY_Model->getRows('ahs_employees',$data);
		if (count($query) > 0) {
			return $query[0];
		}else{
			header('Location: '.base_url('employees'));
		}
	}

	// Fetch Data for Datatable
	public function getEmployees(){
		$limit = $this->input->post('length');
		$offset = $this->input->post('start');
		$search = $this->input->post('search');
		$order = $this->input->post('order');
		$draw = $this->input->post('draw');
		$select = "employee_id,employee_code,email,firstname,lastname,phone,employee_status,profile_image";
		$column_order = array('employee_id','firstname','lastname','email','phone','employee_status','employee_id');
		$join = array();
		$where = "employee_status != 0";
		$list = $this->MY_Model->get_datatables('ahs_employees',$column_order, $select, $where, $join, $limit, $offset ,$search, $order);
		$new_array = array();
		foreach ($list['data'] as $key => $value) {
		$users = array();
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


	// Fetch Data for Datatable
	public function getDocuments(){
		$employee_id = $_POST['employee_id'];
		$limit = $this->input->post('length');
		$offset = $this->input->post('start');
		$search = $this->input->post('search');
		$order = $this->input->post('order');
		$draw = $this->input->post('draw');
		$select = "doc_id,doc_name,doc_type,doc_status,doc_path,date_added";
		$column_order = array('doc_name','doc_type','doc_status','date_added');
		$join = array();
		$where = "fk_employee_id = '$employee_id'";
		$list = $this->MY_Model->get_datatables('ahs_employeedocs',$column_order, $select, $where, $join, $limit, $offset ,$search, $order);
		$new_array = array();
		foreach ($list['data'] as $key => $value) {
		$users = array();
			$value->date_added = date('M d, Y', strtotime($value->date_added));
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

	public function addEmployee(){
		$respond = array();
		$file_path = "./assets/uploads/images/";
        if (isset($_POST) || isset($_FILES)) {
			$ctr = 0;
			$files_key = "";
            //getting the key for upload file
            foreach ($_FILES as $key => $value) {
                $files_key = $key;
			}
			// Assign Original File name
			$orig_filename = $_FILES[$files_key]['name'];

			$password	= trim($this->input->post('emppassword'));
			$cpassword	= trim($this->input->post('empconfpassword'));
			if($cpassword != $password) {
				$respond['empconfpassword'] = 'Password does not match';
				$ctr += 1;
			}

			$firstname	= trim($this->input->post('empfirstname'));
			$lastname	= trim($this->input->post('emplastname'));
			$phone		= trim($this->input->post('empphone'));
			$address	= trim($this->input->post('empaddress'));
			$username	= trim($this->input->post('empusername'));
			$email		= trim($this->input->post('empemail'));
			$codequery 		= 1;

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
			for($i=0; $codequery > 0 ; $i++) {
				$code 	   = $this->generate_code(8).''.$this->generate_num(4);
				$codequery = $this->MY_Model->getRows('ahs_employees',array('where' => array('employee_code' => $code )),'count');
			}
            if ($ctr == 0) {

				if(!empty($orig_filename)) {
					// Image File Saving configuration
					$config['upload_path']		= $file_path;
					$config["allowed_types"]	= 'jpg|jpeg|png|gif';
					$config['max_size']			= 0;
					$config['encrypt_name']		= TRUE;
					$this->load->library('upload', $config);
					if (!$this->upload->do_upload($files_key)) {
						$respond['status'] = 'error';
						$respond[$files_key] = $this->upload->display_errors();
					}else{
						$filename = $this->upload->data('file_name');
						$allfilepath = $file_path . $filename;

						$addEmployeeData = array(
							'employee_code'	=> $code,
							'username'		=> $username,
							'password'		=> password_hash($password,PASSWORD_DEFAULT),
							'email'			=> $email,
							'firstname'		=> $firstname,
							'lastname'		=> $lastname,
							'phone'			=> $phone,
							'address'		=> $address,
							'profile_image'	=> $allfilepath,
						);
						$addEmployee = $this->MY_Model->insert('ahs_employees',$addEmployeeData);
						if ($addEmployee) {
							$respond['status'] = "success";
							$respond['msg'] = "Employee Added Successfully";
						} else {
							$respond['status'] = "error";
							$respond['msg'] = 'Error adding Employee';
						}
					}
				} else {
					$addEmployeeData = array(
						'employee_code'	=> $code,
						'username'		=> $username,
						'email'			=> $email,
						'firstname'		=> $firstname,
						'lastname'		=> $lastname,
						'phone'			=> $phone,
						'address'		=> $address,
					);
					if(isset($_POST['emppassword']) && !empty($_POST['emppassword'])){
						$addEmployeeData['password'] = password_hash(trim($_POST['emppassword']),PASSWORD_DEFAULT);
					}
					$addEmployee = $this->MY_Model->insert('ahs_employees',$addEmployeeData);
					if ($addEmployee) {
						$respond['status'] = "success";
						$respond['msg'] = "Employee Added Successfully";
					} else {
						$respond['status'] = "error";
						$respond['msg'] = 'Error adding Employee';
					}
				}
			}
			json($respond);
        }
	}

	public function getEmployeeInfo(){
		$employee_id = $_POST['employee_id'];
		$parameters['select'] = "employee_id,username,email,firstname,lastname,phone,address,profile_image";
		$parameters['where'] = array('employee_id' => $employee_id);
		$data = $this->MY_Model->getRows('ahs_employees', $parameters, 'row');
		json($data);
	}

	public function updateEmployee() {
		$respond = array();
        $file_path = "./assets/uploads/images/";
        if (isset($_POST) || isset($_FILES)) {
			$ctr = 0;
			$files_key = "";

			//validation for inputs
			if(empty($_POST['upemppassword'])) {
				unset( $_POST['upemppassword']);
				unset( $_POST['upempconfpassword']);
			} else {
				$password		= trim($this->input->post('upemppassword'));
				$cpassword		= trim($this->input->post('upempconfpassword'));
				if($cpassword != $password) {
					$respond['upempconfpassword'] = 'Password does not match';
					$ctr += 1;
				}
			}
			// For Default Image
			$defaultPath	= trim($this->input->post('upprofile_image'));
			if($_POST['upprofile_image'] == "") {
				unset($_POST['upprofile_image']);
				$defaultPath = "";
			}

			//getting the key for upload file
			foreach ($_FILES as $key => $value) {
				$files_key = $key;
			}
			$orig_filename = $_FILES[$files_key]['name'];

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
			
			$employee_id	= trim($this->input->post('upemployee_id'));	
			$firstname		= trim($this->input->post('upempfirstname'));	
			$lastname		= trim($this->input->post('upemplastname'));	
			$phone			= trim($this->input->post('upempphone'));	
			$address		= trim($this->input->post('upempaddress'));	
			$username		= trim($this->input->post('upempusername'));	
			$email			= trim($this->input->post('upempemail'));

            if ($ctr == 0) {
				if ($orig_filename == "") {
					$data = array(
						'set' => array(
							'username'		=> $username,
							'email'         => $email,
							'firstname'     => $firstname,
							'lastname'    	=> $lastname,
							'phone'      	=> $phone,
							'address'      	=> $address,
							'profile_image' => $defaultPath,
							'date_updated' 	=> date('Y-m-d H:i:s'),
						),
						'where' => array(
							'employee_id' => $employee_id
						)
					);
					if(isset($_POST['upemppassword']) && !empty($_POST['upemppassword'])){
						$data['set']['password'] = password_hash(trim($_POST['upemppassword']),PASSWORD_DEFAULT);
					}
					$updateData = $this->MY_Model->update('ahs_employees',$data['set'],$data['where']);
					if($updateData) {
						$respond['status'] = "success";
						$respond['msg']    = "Employee Updated Successfully";
					} else {
						$respond['status'] = "error";
						$respond['msg'] = 'Error Updating Employee';
					}
				} else {
					if (file_exists($defaultPath) || $defaultPath != '') {
						file_exists($defaultPath) ? unlink($defaultPath) : "";
					}
					$config['upload_path']          = $file_path;
					$config["allowed_types"]        = 'jpg|jpeg|png|gif';
					$config['max_size']             = 0;
					$config['encrypt_name']         = TRUE;
					$this->load->library('upload', $config);
					if (!$this->upload->do_upload($files_key)) {
						$respond[$files_key] = $this->upload->display_errors();
					} else {
						//upload to db
						$filename = $this->upload->data('file_name');
						$allfilepath = $file_path . $filename;
						$data = array(
							'set' => array(
								'username'		=> $username,
								'email'         => $email,
								'firstname'     => $firstname,
								'lastname'    	=> $lastname,
								'phone'      	=> $phone,
								'address'      	=> $address,
								'profile_image' => $allfilepath,
								'date_updated' 	=> date('Y-m-d H:i:s'),
							),
							'where' => array(
								'employee_id' => $employee_id
							)
						);
						if(isset($_POST['upemppassword']) && !empty($_POST['upemppassword'])){
							$data['set']['password'] = password_hash(trim($_POST['upemppassword']),PASSWORD_DEFAULT);
						}
						$updateData = $this->MY_Model->update('ahs_employees',$data['set'],$data['where']);
						if($updateData) {
							$respond['status'] = "success";
							$respond['msg']    = "Employee Updated Successfully";
						} else {
							$respond['status'] = "error";
							$respond['msg'] = 'Error Updating Employee';
						}
					}
				}
			}
		json($respond);
		}
	}

	public function removeEmployee() {
		$employee_id = $_POST['employee_id'];
		$removeEmployeeData = array(
			'set'   => array( 'employee_status' => 0),
			'where' => array( 'employee_id' => $employee_id),
		);
		$removeEmployee = $this->MY_Model->update('ahs_employees', $removeEmployeeData['set'], $removeEmployeeData['where']);
		if ($removeEmployee) {
			$respond['status'] = "success";
			$respond['msg']    = "Employee has been removed";
		} else {
			$respond['status'] = "error";
			$respond['msg'] = 'Error removing Employee';
		}
		json($respond);
	}

	public function updateEmployeeStatus(){
		$employee_id = $_POST['employee_id'];
		$employee_status = $_POST['employee_status'];
		$fstatus = ($employee_status == 1?2:1);//1 - Enable / 2 - Disable
		$data = array(
			'set'   => array('employee_status' => $fstatus,'date_updated' => date('Y-m-d H:i:s')),
			'where' => array('employee_id' => $employee_id)
		);
		$updateEmployee = $this->MY_Model->update('ahs_employees',$data['set'],$data['where']);
		if ($updateEmployee) {
			response('success', 'success', 'Status Updated');
		} else {
			response('error', 'danger', 'Something went wrong');
		}
	}

	public function addDocument() {
		$respond = array();
        $file_path = "./assets/uploads/documents/";
        if (isset($_POST) || isset($_FILES)) {
            $ctr = 0;
            $files_key = "";
            //getting the key for upload file
            foreach ($_FILES as $key => $value) {
                $files_key = $key;
			}
			$doctype 		= $this->input->post('doctype');
			$employee_id 	= $this->input->post('addemployee_id');
			// Assign Original File name
			$orig_filename = $_FILES[$files_key]['name'];

			//validation for inputs
			if (empty($orig_filename) ) {
				$_POST['docfile'] = '';
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
				$chkfile = array(
					'select'	=> 'doc_name',
					'where'		=> array('doc_name' => $orig_filename),
				);
				$chkfilename = $this->MY_Model->getRows('ahs_employeedocs',$chkfile);
				if($chkfilename) {
					$respond['docfile'] = 'Filename exists. Please rename';
					$ctr += 1;
				} else {
					// Document File Saving configuration
					$config['upload_path']		= $file_path;
					$config["allowed_types"]	= "docx|doc|pdf|xls|xlsx|zip|jpeg|jpg|png";
					$config['max_size']			= 0;
					$config['encrypt_name']		= FALSE;
					$this->load->library('upload', $config);
					if (!$this->upload->do_upload($files_key)) {
						$respond['status'] = 'error';
						$respond[$files_key] = $this->upload->display_errors();
					}else{
						//upload to db
						$filename = $this->upload->data('file_name');
						$allfilepath = $file_path . $filename;
						$data= array(
							'fk_employee_id'	=> $employee_id,
							'doc_name'			=> $orig_filename,
							'doc_type'         	=> $doctype,
							'doc_path'      	=> $allfilepath,
						);
						$query = $this->MY_Model->insert('ahs_employeedocs',$data);
						if ($query) {
							$respond['status']	= "success";
							$respond['msg'] 	= "Document File Added Successfully";
						}else{
							$respond['status']	= "error";
							$respond['msg'] 	= "Something went wrong";
						}
					}
				}
			}	
        }
        json($respond);
	}

	// Fetch Document File Information
	public function getDocInfo(){
		$doc_id = $_POST['doc_id'];
		$parameters['select'] = "doc_id,doc_name,doc_type,doc_path";
		$parameters['where'] = array('doc_id' => $doc_id);
		$data = $this->MY_Model->getRows('ahs_employeedocs', $parameters, 'row');
		json($data);
	}

	// Update Document File
	// public function updateDocument(){
	// 	$respond = array();
	// 	// Assigning
	// 	$file_path 			= "./assets/uploads/documents/";
	// 	$doc_id   			= trim($this->input->post('updoc_id'));
	// 	$doctype   			= trim($this->input->post('updoctype'));
	// 	$updoc_path 		= trim($this->input->post('updoc_path'));

	// 	if (isset($_POST) || isset($_FILES)) {
	// 		$ctr = 0;
	// 		$files_key = "";
	// 		//getting the key for upload file
	// 		foreach ($_FILES as $key => $value) {
	// 			$files_key = $key;
	// 		}
	// 		$orig_filename = $_FILES[$files_key]['name'];
	// 		//validation for inputs
	// 		foreach ($_POST as $key => $value) {
	// 			$this->form_validation->set_rules($key, $key, 'required', array('required' => '{field} is required'));
	// 			if (!$this->form_validation->run()) {
	// 				if ($value == '') {
	// 					$respond[$key] = form_error($key);
	// 					$ctr += 1;
	// 				}
	// 			}
	// 		}
	// 		if ($ctr == 0) {
	// 			if($orig_filename == "") {
	// 				$data = array(
	// 					'set' => array(
	// 						'doc_type'         	=> $doctype,
	// 						'doc_path'         	=> $updoc_path,
	// 						'date_updated'      => date('Y-m-d H:i:s'),
	// 					),
	// 					'where' => array(
	// 						'doc_id' => $doc_id
	// 					)
	// 				);
	// 				if (update('ahs_employeedocs', $data['set'], $data['where'])) {
	// 					$respond['status'] = "success";
	// 					$respond['msg']    = "Document File Updated Successfully";
	// 				} else {
	// 					$respond['status'] = "error";
	// 					$respond['msg'] = 'Error Updating Document File';
	// 				}
	// 			} else {
	// 				$chkfile = array(
	// 					'select'	=> 'doc_name',
	// 					'where'		=> array('doc_name' => $orig_filename, 'doc_id !=' => $doc_id),
	// 				);
	// 				$chkfilename = $this->MY_Model->getRows('ahs_employeedocs',$chkfile);
	// 				if($chkfilename) {
	// 					$respond['docfile'] = 'Filename exists. Please rename';
	// 					$ctr += 1;
	// 				} else {
	// 					if (file_exists($updoc_path) || $updoc_path != '') {
	// 						file_exists($updoc_path) ? unlink($updoc_path) : "";
	// 						$config['upload_path']          = $file_path;
	// 						$config["allowed_types"]        = "doc|docx|pdf|xls|xlsx|zip|jpeg|jpg|png";
	// 						$config['max_size']             = 0;
	// 						$config['encrypt_name']         = FALSE;
	// 						$this->load->library('upload', $config);
	// 						if (!$this->upload->do_upload($files_key)) {
	// 							$respond[$files_key] = $this->upload->display_errors();
	// 						} else {
	// 							//upload to db
	// 							$filename = $this->upload->data('file_name');
	// 							$allfilepath = $file_path . $filename;
	// 							$data = array(
	// 								'set' => array(
	// 									'doc_name'         	=> $orig_filename,
	// 									'doc_type'         	=> $doctype,
	// 									'doc_path'         	=> $allfilepath,
	// 									'date_updated'      => date('Y-m-d H:i:s'),
	// 								),
	// 								'where' => array(
	// 									'doc_id' => $doc_id
	// 								)
	// 							);
	// 							if (update('ahs_employeedocs', $data['set'], $data['where'])) {
	// 								$respond['status'] = "success";
	// 								$respond['msg']    = "Document File Updated Successfully";
	// 							} else {
	// 								$respond['status'] = "error";
	// 								$respond['msg'] = 'Error Updating Document File';
	// 							}
	// 						}
	// 					}
	// 				}
	// 			}
	// 		}
	// 	}
	// 	json($respond);
	// }

	// Remove/Delete Document File
	public function removeDocument(){
		$doc_id	= $_POST['doc_id'];
		$doc_path	= $_POST['doc_path'];
		$data = array('doc_id' => $doc_id);
		$query = $this->MY_Model->delete('ahs_employeedocs',$data);
		if ($query) {
			unlink($doc_path);
			response('success', 'success', 'Document File has been removed');
		} else {
			response('error', 'danger', 'Something went wrong');
		}
	}

	// Document Status
	public function updateDocumentStatus(){
		$doc_id = $_POST['doc_id'];
		$doc_status = $_POST['doc_status'];
		$fstatus = ($doc_status == 1?2:1);//1 - Verify / 2 - Unverify
		$data = array(
			'set'   => array('doc_status' => $fstatus,'date_updated' => date('Y-m-d H:i:s')),
			'where' => array('doc_id' => $doc_id)
		);
		$updateDocumentStatus = $this->MY_Model->update('ahs_employeedocs',$data['set'],$data['where']);
		if($updateDocumentStatus) {
			response('success', 'success', 'Document Status Updated');
		} else {
			response('error', 'danger', 'Something went wrong');
		}
	}

}
?>

