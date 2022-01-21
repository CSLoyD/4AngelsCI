<?php

defined('BASEPATH') OR exit('No direct script access allowed');


class Shifts extends MY_Controller {

	public function index(){
		$data = array(
            'title' => 'Shifts',
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
	public function getShifts(){
		$filter = $_POST['filter'];
		$limit = $this->input->post('length');
		$offset = $this->input->post('start');
		$search = $this->input->post('search');
		$order = $this->input->post('order');
		$draw = $this->input->post('draw');
		$select = "schedule_id, CONCAT(emp.firstname,' ', emp.lastname) as employeename, fac.facility_name, schedule_date, schedule_status";
		$column_order = array('schedule_id', 'emp.firstname', 'fac.facility_name', 'schedule_date', 'schedule_status');
		$join = array('ahs_employees as emp' => 'sch.fk_user_id = emp.employee_id', 'ahs_facilities as fac' => 'sch.fk_facility_id = fac.facility_id');
		$where = "schedule_status != 1";
		($filter != 'all') ? $where .= " AND schedule_status = '$filter'" : "" ;
		$list = $this->MY_Model->get_datatables('ahs_schedules as sch',$column_order, $select, $where, $join, $limit, $offset ,$search, $order);
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

	public function updateShiftStatus($schedule_status=''){
		if($schedule_status == "2"){
			$data = array(
				'set'   => array('schedule_status' => 4,'date_updated' => date('Y-m-d H:i:s')),
				'where' => array('schedule_id' => 1)
			);
		}else if($schedule_status == "4"){
			$data = array(
				'set'   => array('schedule_status' => 1,'date_updated' => date('Y-m-d H:i:s')),
				'where' => array('schedule_id' => 1)
			);
		}

		$updateShiftStatus = $this->MY_Model->update('ahs_schedules',$data['set'],$data['where']);
		if ($updateShiftStatus) {
			response('success', 'success', 'Status Updated');
		} else {
			response('error', 'danger', 'Something went wrong');
		}
	}
}
?>

