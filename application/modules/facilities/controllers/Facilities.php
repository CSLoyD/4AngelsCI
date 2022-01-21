<?php

defined('BASEPATH') OR exit('No direct script access allowed');


class Facilities extends MY_Controller {

	public function index(){
		$data = array(
            'title' => 'Facilities',
        );
		$this->load_page('index',$data);
	}

	public function viewScheduleCalendar($code='', $fac_n=''){
        $data = array(
			'title'   		=> 'Facility Calendar',
			'facDetails' 	=> $this->getFacilityDetails($code),
		);
        $this->load_page('schedule',$data);
	}

	public function getFacilityDetails($code='', $fac_n='') {
		$output = array();
		$getFacID["select"]	= "facility_id,facility_name";
		$getFacID["where"]	= array("facility_code" => $code);
		$getFacIDquery = $this->MY_Model->getRows("ahs_facilities", $getFacID);
		return $getFacIDquery[0];
	}

	// Fetch Data for Datatable
	public function getFacilities(){
		$limit = $this->input->post('length');
		$offset = $this->input->post('start');
		$search = $this->input->post('search');
		$order = $this->input->post('order');
		$draw = $this->input->post('draw');
		$select = "facility_id,facility_name,facility_status,date_added,facility_code";
		$column_order = array('facility_id','facility_name','date_added');
		$join = array();
		$where = "facility_status != 0";
		$list = $this->MY_Model->get_datatables('ahs_facilities',$column_order, $select, $where, $join, $limit, $offset ,$search, $order);
		$new_array = array();
		foreach ($list['data'] as $key => $value) {
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

	public function addFacility(){
		$respond = array();
        if (isset($_POST)) {
			$ctr = 0;

			$facilityname	= trim($this->input->post('facilityname'));
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
			for ($i=0; $codequery > 0 ; $i++) {
				$code 	   = $this->generate_code(8).''.$this->generate_num(4);
				$codequery = $this->MY_Model->getRows('ahs_facilities',array('where' => array('facility_code' => $code )),'count');
			}
            if ($ctr == 0) {
				$addFacilityData = array(
					'facility_name'	=> $facilityname,
					'facility_code'	=> $code,
				);
				$addFacility = $this->MY_Model->insert('ahs_facilities',$addFacilityData);
				if ($addFacility) {
					$respond['status'] = "success";
					$respond['msg'] = "Facility Added Successfully";
				} else {
					$respond['status'] = "error";
					$respond['msg'] = 'Error adding Facility';
				}
			}
			json($respond);
        }
	}

	public function getFacilityInfo(){
		$facility_id = $_POST['facility_id'];
		$parameters['select'] = "facility_name";
		$parameters['where'] = array('facility_id' => $facility_id);
		$data = $this->MY_Model->getRows('ahs_facilities', $parameters, 'row');
		json($data);
	}

	public function updateFacility() {
		$respond = array();
        if (isset($_POST)) {
			$ctr = 0;
			$facility_id	= trim($this->input->post('up_facility_id'));
			$facility_name	= trim($this->input->post('facilityname'));

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
				$updateFacilityData = array(
					'set'	=> array(
						'facility_name'	=> $facility_name,
					),
					'where'	=> array(
						'facility_id'	=> $facility_id,
					),
				);
				$updateFacility = $this->MY_Model->update('ahs_facilities',$updateFacilityData['set'],$updateFacilityData['where']);
				if ($updateFacility) {
					$respond['status'] = "success";
					$respond['msg'] = "Facility Updated Successfully";
				} else {
					$respond['status'] = "error";
					$respond['msg'] = 'Error Updating Facility';
				}
			}
		json($respond);
		}
	}

	public function removeFacility() {
		$facility_id = $_POST['facility_id'];
		$removeFacilityData = array(
			'set'   => array( 'facility_status' => 0),
			'where' => array( 'facility_id' => $facility_id),
		);
		$removeFacility = $this->MY_Model->update('ahs_facilities', $removeFacilityData['set'], $removeFacilityData['where']);
		if ($removeFacility) {
			$respond['status'] = "success";
			$respond['msg']    = "Facility has been removed";
		} else {
			$respond['status'] = "error";
			$respond['msg'] = 'Error removing Facility';
		}
		json($respond);
	}
	//=======================Shifts===========================//

	// Fetch Data for Shifts Request Datatable
	public function getShifts(){
		$limit = $this->input->post('length');
		$offset = $this->input->post('start');
		$search = $this->input->post('search');
		$order = $this->input->post('order');
		$draw = $this->input->post('draw');
		$select = "schedule_id, CONCAT(emp.firstname,' ', emp.lastname) as employeename, fac.facility_name, schedule_date, schedule_status";
		$column_order = array('schedule_id', 'emp.firstname', 'fac.facility_name', 'schedule_date', 'schedule_status');
		$join = array('ahs_employees as emp' => 'sch.fk_user_id = emp.employee_id', 'ahs_facilities as fac' => 'sch.fk_facility_id = fac.facility_id');
		$where = "schedule_status != 1";
		// $where = array("schedule_status !=" => 1, "fk_facility_id" => 9);
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

	//=======================Schedule===========================//

	// Fetch Data for Datatable
	public function getSchedules($facility_id = ''){
		$output = array();
		$data = array(
			'select'	=> '*',
			'where'		=> array('fk_facility_id' => $facility_id)
		);
		$query = $this->MY_Model->getRows('ahs_schedules', $data,'obj');
		
		foreach($query as $scheDetails){
			$scheduleDate = $scheDetails->schedule_date;
			$start = $scheduleDate.'T'.$scheDetails->time_start;
			$end = $scheduleDate.'T'.$scheDetails->time_end;
			
			switch($scheDetails->schedule_status){
				case 1;
					$title 	= 'OPEN';
					break;
				case 2;
					$title = 'FILLED';
					break;
				case 3;
					$title = 'DECLINE';
					break;
				case 4;
					$title = 'CLOSE';
					break;
				case 5;
					$title = 'COMPLETED';
					break;
			}

			$output[] = array(
				"id"		=> $scheDetails->schedule_id,
        		'title' 	=> $title ,
				'start' 	=> $start,
				'end' 		=> $end,
				// 'allDay' => 'false'
			);

		}
	
		echo json_encode($output);
	}
	
	public function addSchedule(){
		$respond = array();
		
        if (isset($_POST)) {
			$ctr = 0;

			// $facilityname	= trim($this->input->post('facilityname'));
			$DateShift	= $this->input->post('Shift_Date');
			$StartShift	= $this->input->post('Shift_Time_Start');
			$EndShift	= $this->input->post('Shift_Time_End');
			$facilityID	= $this->input->post('facilityID');
				

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
				$addScheduleData = array(
					'fk_facility_id' => $facilityID,
					'schedule_date'	=> $DateShift,
					'time_start'	=> $StartShift,
					'time_end'	=> $EndShift,
					'schedule_status'	=> 1,
					'date_added' => date("Y-m-d")
				);
				$addSchedule = $this->MY_Model->insert('ahs_schedules',$addScheduleData);
				if ($addSchedule) {
					$respond['status'] = "success";
					$respond['msg'] = "Schedule Added Successfully";
				} else {
					$respond['status'] = "error";
					$respond['msg'] = 'Error adding Schedule';
				}
			}
			json($respond);
        }
	}

	public function addMultiSchedule(){
		$respond = array();	
        if (isset($_POST)) {
			$ctr = 0;

			$lastDayOfMonth	= $this->input->post('lastDayofMonth');
			$DateShift	= $this->input->post('Start_Date');
			$EndDateShift	= $this->input->post('End_Date');
			$StartShift	= $this->input->post('Shift_Time_Start');
			$EndShift	= $this->input->post('Shift_Time_End');
			$facilityID	= $this->input->post('facilityID');

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

				$DateShiftDay = substr($DateShift,8);
				$EndDateShiftDay = substr($EndDateShift,8);
				$DateShiftMonth = substr($DateShift,5,2);
				$EndDateShiftMonth = substr($EndDateShift,5,2);

				if($DateShiftMonth  != $EndDateShiftMonth){
					$EndDateShiftDayRes = $lastDayOfMonth - $DateShiftDay;
					$EndDateShiftDay += $EndDateShiftDayRes; 
					$respond['status'] = "success";
					$respond['msg'] = 'Error adding Schedule: Please select days without overlapping a month';
					json($respond);
					exit;
				}
				

				$dateDiff = strtotime($EndDateShift) - strtotime($DateShift);
				$dateDiff = round($dateDiff / (60 * 60 * 24));


				// $respond['status'] = "success|".$DateShift."   ".$DateShiftDay."-".$EndDateShiftDay;
				// $respond['msg'] = "Schedule Added Successfully|".$EndDateShift."   ".$DateShiftMonth."-".$EndDateShiftMonth." Last=".$lastDayOfMonth;

				

				// $respond['msg2'] = '';

				$scheduleDates = array();
				$schedulesDates[] = $DateShift;

				$diffResult = $EndDateShiftDay - $DateShiftDay;
				$newMonthCounter = 0;
				$ConstDateShiftDay = substr($DateShift,8);
				for($counter = 1;$counter > 0;$counter++){

					$diffResult = $EndDateShiftDay - $DateShiftDay;
					if($diffResult == 1){
						// $respond['msg2'] = $respond['msg2'].' added: '.$DateShift;
						$schedulesDates[] = $EndDateShift;
						// $respond['msg2'] = $respond['msg2'].' added: '.$EndDateShift;
						break;
					}else{
						if($newMonthCounter == 0){
							
							$NewDateShiftDay = $ConstDateShiftDay + $counter;
							$NewDateShift = substr($DateShift,0,8);
							
							if($NewDateShiftDay == $lastDayOfMonth){
								$NewDateShift = $NewDateShift.$NewDateShiftDay;
								$schedulesDates[] = $NewDateShift;
								// $respond['msg2'] = $respond['msg2'].' added: '.$NewDateShift;
								$newMonthCounter++;
							}else{
								if($NewDateShiftDay < 10){
									$NewDateShift = $NewDateShift.'0'.$NewDateShiftDay;
								}else{
									$NewDateShift = $NewDateShift.$NewDateShiftDay;
								}
								$schedulesDates[] = $NewDateShift;
								// $respond['msg2'] = $respond['msg2'].' added: '.$NewDateShift;
								$DateShiftDay++;
							}
						}else{
							$NewDateShiftDay = $ConstDateShiftDay + $newMonthCounter;
							$NewDateShift = substr($DateShift,0,8);
							$NewDateShift = $NewDateShift.$NewDateShiftDay;
							$schedulesDates[] = $NewDateShift;
							// $respond['msg2'] = $respond['msg2'].' added: '.$NewDateShift;
							$newMonthCounter++;
							$DateShiftDay++;
							
						}
						

						
						
					}
				}
				
				for($counter = 0;$counter < count($schedulesDates);$counter++){

					$addScheduleData = array(
						'fk_facility_id' => $facilityID,
						'schedule_date'	=> $schedulesDates[$counter],
						'time_start'	=> $StartShift,
						'time_end'	=> $EndShift,
						'schedule_status'	=> 1,
						'date_added' => date("Y-m-d")
					);
					$addSchedule = $this->MY_Model->insert('ahs_schedules',$addScheduleData);
					if ($addSchedule) {
						$respond['status'] = "success";
						$respond['msg'] = "Schedule Added Successfully";
					} else {
						$respond['status'] = "error";
						$respond['msg'] = 'Error adding Schedule';
					}

				}
				
			}
			json($respond);
        }
	}

	public function getScheduleInfo(){
		$schedule_id = $_POST['schedule_id'];
		$parameters['select'] = "schedule_date,time_start,time_end";
		$parameters['where'] = array('schedule_id' => $schedule_id);
		$data = $this->MY_Model->getRows('ahs_schedules', $parameters, 'row');
		json($data);
	}

	public function updateSchedule() {
		$respond = array();
        if (isset($_POST)) {
			$ctr = 0;
			$schedule_id	= trim($this->input->post('upsched_id'));
			$shiftDate		= trim($this->input->post('upShift_Date'));
			$shiftTimeStart	= trim($this->input->post('upShift_Time_Start'));
			$shiftTimeEnd	= trim($this->input->post('upShift_Time_End'));
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
				$updateScheduleData = array(
					'set'	=> array(
						'schedule_date'	=> $shiftDate,
						'time_start'	=> $shiftTimeStart,
						'time_end'		=> $shiftTimeEnd,
					),
					'where'	=> array(
						'schedule_id'	=> $schedule_id,
					),
				);
				$updateSchedule = $this->MY_Model->update('ahs_schedules',$updateScheduleData['set'],$updateScheduleData['where']);
				if ($updateSchedule) {
					$respond['status'] = "success";
					$respond['msg'] = "Schedule Updated Successfully";
				} else {
					$respond['status'] = "error";
					$respond['msg'] = 'Error Updating Schedule';
				}
			}
		json($respond);
		}
	}

	public function removeSchedule() {
		$schedule_id = $_POST['schedule_id'];
		$data = array('schedule_id' => $schedule_id);
		$removeSchedule = $this->MY_Model->delete('ahs_schedules', $data);
		if($removeSchedule) {
			$respond['status'] = "success";
			$respond['msg'] = "Schedule Removed Successfully";
		} else {
			$respond['status'] = "error";
			$respond['msg'] = 'Error Removing Schedule';
		}
		json($respond);
	}

}
?>

