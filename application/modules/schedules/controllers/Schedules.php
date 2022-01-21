<?php

defined('BASEPATH') OR exit('No direct script access allowed');


class Schedules extends MY_Controller {

	public function index(){
		$data = array(
            'title' => 'Facilities',
        );
		$this->load_page('index',$data);
	}

	// Fetch Data for Datatable
	public function getFacilities(){
		$limit = $this->input->post('length');
		$offset = $this->input->post('start');
		$search = $this->input->post('search');
		$order = $this->input->post('order');
		$draw = $this->input->post('draw');
		$select = "facility_id,facility_name,facility_status,date_added";
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

}
?>
