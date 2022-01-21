<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Attendance extends MY_Controller {

	public function index(){
		$data = array(
            'title' 	=> 'Attendance',
			'employees'	=> $this->getAllEmployees(),
        );
		$this->load_page('index',$data);
	}

	public function getAllEmployees() {
		$data = array('select' => "employee_id, CONCAT(firstname,' ',lastname) as employeename");
		$query = $this->MY_Model->getRows('ahs_employees',$data);
		if (count($query) > 0) {
			return $query;
		}else{
			header('Location: '.base_url('attendance'));
		}
	}

	// Fetch Data for Datatable
	public function getAttendance(){
		$employee = $_POST['employee'];
		$date = $_POST['date'];
		$time = $_POST['time'];

		$limit = $this->input->post('length');
		$offset = $this->input->post('start');
		$search = $this->input->post('search');
		$order = $this->input->post('order');
		$draw = $this->input->post('draw');
		$select = "attendance_id,clockin_time,total_hrs_rendered,att.date_added,CONCAT(emp.firstname,' ', emp.lastname) as employeename";
		$column_order = array('emp.firstname','att.date_added','total_hrs_rendered');
		$join = array('ahs_employees as emp' => 'att.fk_employee_id = emp.employee_id');
		$where = "emp.employee_status != 0";
		($employee != 'all') ? $where .= " AND att.fk_employee_id = '$employee'" : "" ;
		($date != '') ? $where .= " AND DATE_FORMAT(att.date_added,'%Y-%m-%d') = '$date'" : "" ;
		if($time == 'morning') {
			$where .= " AND TIME_FORMAT(clockin_time,'%H') >= 6 AND TIME_FORMAT(clockin_time,'%H') <= 11";
		} else if($time == 'afternoon') {
			$where .= " AND TIME_FORMAT(clockin_time,'%H') >= 12 AND TIME_FORMAT(clockin_time,'%H') <= 17";
		} else if($time == 'evening') {
			$where .= " AND TIME_FORMAT(clockin_time,'%H') >= 18 AND TIME_FORMAT(clockin_time,'%H') <= 23";
		} else if($time == 'midnight') {
			$where .= " AND TIME_FORMAT(clockin_time,'%H') >= 0 AND TIME_FORMAT(clockin_time,'%H') <= 5";
		}
		$list = $this->MY_Model->get_datatables('ahs_attendance as att',$column_order, $select, $where, $join, $limit, $offset ,$search, $order);
		$new_array = array();
		foreach ($list['data'] as $key => $value) {
			$value->date_added = date('M d, Y', strtotime($value->date_added));
			$value->clockin_time = date('h:i A', strtotime($value->clockin_time));
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

	public function getAttendanceInfo(){
		$attendance_id = $_POST['attendance_id'];
		$type = $_POST['type'];
		$parameters['select'] = "attendance_id,fk_employee_id,clockin_time,clockout_time,total_hrs_rendered,date_added";
		$parameters['where'] = array('attendance_id' => $attendance_id);
		$data = $this->MY_Model->getRows('ahs_attendance', $parameters, 'row');
		if($type == 'view') {
			$data->date_added = date('M d, Y', strtotime($data->date_added));
			$data->clockin_time = date('h:i A', strtotime($data->clockin_time));
			$data->clockout_time = date('h:i A', strtotime($data->clockout_time));
		} else {
			$data->clockin_time = date('H:i', strtotime($data->clockin_time));
			$data->clockout_time = date('H:i', strtotime($data->clockout_time));
		}
		json($data);
	}

	public function updateAttendance() {
		$respond = array();
        if (isset($_POST)) {
			$ctr = 0;
			$attendance_id	= trim($this->input->post('upattendance_id'));
			$clockin_time	= trim($this->input->post('upclockin'));
			$clockout_time	= trim($this->input->post('upclockout'));
			$total			= date('H', strtotime($clockout_time)) - date('H', strtotime($clockin_time));

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
				$updateAttendanceData = array(
					'set'	=> array(
						'clockin_time '			=> $clockin_time,
						'clockout_time'			=> $clockout_time,
						'total_hrs_rendered'	=> $total,
					),
					'where'	=> array(
						'attendance_id'	=> $attendance_id,
					),
				);
				$updateAttendance = $this->MY_Model->update('ahs_attendance',$updateAttendanceData['set'],$updateAttendanceData['where']);
				if ($updateAttendance) {
					$respond['status'] = "success";
					$respond['msg'] = "Attendance Updated Successfully";
				} else {
					$respond['status'] = "error";
					$respond['msg'] = 'Error Updating Attendance';
				}
			}
		json($respond);
		}
	}

}
?>

