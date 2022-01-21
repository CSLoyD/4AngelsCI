<?php

defined('BASEPATH') OR exit('No direct script access allowed');

// header('Content-Type: application/json; charset=utf-8');
// header('Access-Control-Allow-Methods: POST, GET, DELETE, PUT, PATCH, OPTIONS');
// header('Access-Control-Allow-Headers: token, Content-Type');
// header('Access-Control-Allow-Origin: *');

class Reactapi extends MY_Controller {

    public $_reactV = "1.1.8";

//     public function __construct(){
//         parent::__construct();
        
//         $react = (!empty($_POST))?$_POST['reactV']:'';
//         $token = (!empty($_POST))?$_POST['token']:'';

//         if($this->_token !== $token) {
//             exit;
//         }
//         if($this->_reactV !== $react) {
//             $output = array(
//                 'stat'  => "Failed",
//                 'msg'   => "Outdated! Please update your App",
//             ); 
//             echo json_encode($output);
//             exit;
//         }
//    }

    function LoginEmployee() {
        $output = '';

        $username = $_POST['username'];
        $pass     = $_POST['password'];

        $chkUserData = array(
            'select' => 'employee_id,username,password',
            'where' => array('username' => $username),
            'or_where' => array('email' => $username),
         );
        $chkUser = $this->MY_Model->getRows('ahs_employees',$chkUserData,'obj');
        if($chkUser) {
            $verifypass = password_verify($pass, $chkUser[0]->password);
            if ($verifypass) {
                $passData = array(
                    'employee_id'       => $chkUser[0]->employee_id,
                    'username'          => $chkUser[0]->username,
                );
                $output = array(
                    'stat'  => "Success",
                    'msg'   => "Login Successfully",
                    'datas' => $passData,
                );
            } else {
                $output = array(
                    'stat'  => "Failed",
                    'msg'   => "Wrong/Invalid Password",
                );
            }
        } else {
            $output = array(
                'stat'  => "Failed",
                'msg'   => "Invalid Username",
            ); 
        }
        echo json_encode($output);
        exit;
    }

    public function fetchProfile() {
        $output = '';
        $employee_id = $_POST['employee_id'];

        $getData = array(
            'select'    => 'email,firstname,lastname,address,phone,profile_image',
            'where'     => "employee_id = '$employee_id'"
        );
        $getDataQuery = $this->MY_Model->getRows('ahs_employees',$getData);
        if($getDataQuery) {
            $getDataQuery[0]['profile_image'] = ($getDataQuery[0]['profile_image'] != "") ? base_url($getDataQuery[0]['profile_image']) : "" ;
            $output = array(
                'stat'  => "Success",
                'msg'   => "Profile Fetched",
                'datas' => $getDataQuery[0],
            );
        } else {
            $output = array(
                'stat'  => "Failed",
                'msg'   => "Something went wrong.",
            );
        }
        echo json_encode($output);
        exit;
    }

    public function updateProfile() {
        
        $output = '';
		$file_path      = "./assets/uploads/images/";
        $fullpath       = "";
        $username       = $_POST['username'];
        $firstname      = $_POST['firstname'];
        $lastname       = $_POST['lastname'];
        $email          = $_POST['email'];
        $phone          = $_POST['phone'];
        $address        = $_POST['address'];
        $employee_id    = $_POST['employee_id'];

        if(isset($_POST['file'])) {
            $files = json_decode($_POST['file']);
            $files->data = str_replace(' ', '+', $files->data);
            $decoded = base64_decode($files->data);
            $moveFile = file_put_contents($file_path.$files->name, $decoded);
            $fullpath = ($moveFile !== "")? $file_path.$files->name : "";
        }
        
        $data = array(
            'set' => array(
                'username'		=> $username,
                'email'         => $email,
                'firstname'     => $firstname,
                'lastname'    	=> $lastname,
                'phone'      	=> $phone,
                'address'      	=> $address,
                'date_updated' 	=> date('Y-m-d H:i:s'),
            ),
            'where' => array(
                'employee_id' => $employee_id
            )
        );
        (isset($_POST['file'])) ? $data['set']['profile_image'] = $fullpath : "" ;
        $updateData = $this->MY_Model->update('ahs_employees',$data['set'],$data['where']);
        if($updateData) {
            $output = array(
                'stat'  => "Success",
                'msg'   => "Profile Updated Successfully",
            );
        } else {
            $output = array(
                'stat'  => "Failed",
                'msg'   => "Error Saving Profile.",
            );
        }

        echo json_encode($output);
        exit;
    }

    public function profileUpdatePass() {
        $output = '';

        $employee = $_POST['employee_id'];
        $currentPass = $_POST['currentPass'];
        $newPass = $_POST['newPass'];
        $confPass = $_POST['confPass'];

        $fetchCurrentPassData = array(
            'select'    => 'password',
            'where'     => "employee_id = '$employee'",
        );
        $fetchCurrentPass = $this->MY_Model->getRows('ahs_employees',$fetchCurrentPassData,'obj');
        ($fetchCurrentPass)?$verifypass = password_verify($currentPass, $fetchCurrentPass[0]->password):"";
        if($verifypass) {
            ($newPass == $confPass)?$confirmedNew = true:$confirmedNew = false;
            if($confirmedNew) {
                $upatePassData = array(
                    'set'   => array(
                        'password'      => password_hash($newPass,PASSWORD_DEFAULT)
                    ),
                    'where' => array(
                        'employee_id'   => $employee
                    )
                );
                $updatePass = $this->MY_Model->update('ahs_employees',$upatePassData['set'],$upatePassData['where']);
                if($updatePass) {
                    $output = array(
                        'stat'  => "Success",
                        'msg'   => "Password Updated Successfully",
                    );
                } else {
                    $output = array(
                        'stat'  => "Failed",
                        'msg'   => "Failed to Update Password",
                    );
                }
            } else {
                $output = array(
                    'stat'  => "Failed",
                    'msg'   => "Password Confirmation Mismatch",
                );
            }
        } else {
            $output = array(
                'stat'  => "Failed",
                'msg'   => "Current Password Mismatch",
            );
        }
        echo json_encode($output);
        exit;
    }

    public function fetchFacilities(){

        $output = '';

        $getData = array(
            'select'    => 'facility_id,facility_name,facility_status,date_added,facility_code',
            'where'     => "facility_status != 0"
        );
        $getDataQuery = $this->MY_Model->getRows('ahs_facilities',$getData);
        if($getDataQuery) {
            // $getDataQuery[0]['profile_image'] = ($getDataQuery[0]['profile_image'] != "") ? base_url($getDataQuery[0]['profile_image']) : "" ;
            $output = array(
                'stat'  => "Success",
                'msg'   => "Profile Fetched",
                'datas' => $getDataQuery,
            );
        } else {
            $output = array(
                'stat'  => "Failed",
                'msg'   => "Something went wrong.",
            );
        }
        echo json_encode($output);
        exit;

    }

}
?>

