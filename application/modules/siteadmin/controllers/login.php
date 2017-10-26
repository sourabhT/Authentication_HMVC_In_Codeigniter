<?php

class Login extends CI_Controller {

    public $moduleName = 'login';

    public function __construct() {
        parent::__construct();
        //$this->load->library('encrypt');
        $this->load->model('authentication_model');
        echo $this->load->authentication_model->checkLoggedInAtLogin();
    }

    public function index() {
        $ip = $this->input->ip_address();
        $timezone = "Asia/Calcutta";
        if (function_exists('date_default_timezone_set')) {
            date_default_timezone_set($timezone);
        }
        $localtime = date('Y-m-d H:i:s');
        $this->user_logs($user_id = 0, $username = "", $fullname = "", $log_title = "Login Try", $log_description = "Trying", $localtime);
        $getVar = (isset($_GET['logtmsl']) && $_GET['logtmsl'] == 'pie' ? TRUE : FALSE);
        //if('182.74.40.26' == $ip || '219.91.158.218' == $ip || $getVar || isset($_POST["submit"])){
        if (1) {
            if (1) {
                //print_r($this->session->all_userdata());
                $countPU = $this->session->userdata('PrevUsername');
                $count = $this->session->userdata('loginCountAttempt');
                if (isset($_POST["submit"])) {
                    $result = $this->load->authentication_model->doLogin();
                    if (isset($result->username) && $result->username != '' && isset($result->user_id) && $result->user_id != '') {

                        $this->user_logs($result->user_id, $result->username, $result->fullname, 'Login', 'Login Successfully', $localtime);
                        $this->session->set_userdata('userid', $result->user_id);
                        $this->session->set_userdata('role_id', $result->role_id);
                        $this->session->set_userdata('parent_id', $result->parent_id);
                        $this->session->set_userdata('username', $result->username);
                        $this->session->set_userdata('fullname', $result->fullname);
                        $this->session->set_userdata('email', $result->email);

                        redirect(site_url() . 'siteadmin/dashboard/index');
                    } else {
                        $this->session->set_flashdata('error', 'Invalid Login Details...');
                        $this->load->view('siteadmin/login/index');
                    }
                } else {
                    $this->load->view('siteadmin/login/index');
                }
            } else {
                $this->load->view('siteadmin/errorPage');
                echo $this->output->get_output();
                exit;
            }
        } else {
            //redirect('http://www.ina.com/');
        }
    }

    public function user_logs($user_id, $username, $fullname, $log_title, $log_description, $localtime) {
        $ip = $this->input->ip_address();
        $userLogData = array('user_id' => $user_id, 'username' => $username, 'fullname' => $fullname, 'log_title' => $log_title, 'log_description' => $log_description, 'localtime' => $localtime, 'ip_address' => $ip);
        $this->db->insert('logs', $userLogData);
    }

}