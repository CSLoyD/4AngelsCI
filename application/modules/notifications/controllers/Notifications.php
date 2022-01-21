<?php

defined('BASEPATH') OR exit('No direct script access allowed');


class Notifications extends MY_Controller {

	public function get_schedules() {
		$data = array(
			'select'	=> '*',
			'where'		=> array('title' => "New Notifications")
		);
		$queryNotif = $this->MY_Model->getRows('ahs_notifications', $data,'obj');
		json($queryNotif);
	}

	public function index(){
		if(isset($_GET['notif'])){
			$notif_id = $_GET['notif'];

			$read_notif = array(
				'set'	=> array( 'notif_status'	=> "read", ),
				'where'	=> array( 'notif_id'		=> $notif_id, ),
			);
			$this->MY_Model->update('ahs_notifications',$read_notif['set'],$read_notif['where']);
		}

		$data['notifications'] = $this->db->
		select('*')->
		order_by('notif_status','DESC')->
		order_by('date_added','DESC')->
		limit(100)->
		from('ahs_notifications')->
		get()->result();

      	$data['title'] = 'Notifications List';
		$data['route'] = $this->router->fetch_class();
		$data['__assets__'] = $this->assets_;
		$this->schedule_notif('index', $data);
	}
}
?>

