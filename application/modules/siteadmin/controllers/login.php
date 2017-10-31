<?php

class Login extends MX_Controller {

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
        if (1) {
            if (1) {
                //print_r($this->session->all_userdata());
                $countPU = $this->session->userdata('PrevUsername');
                $count = $this->session->userdata('loginCountAttempt');
                if (isset($_POST["submit"])) {
                    $result = $this->load->authentication_model->doLogin();
                    if (isset($result->username) && $result->username != '' && isset($result->user_id) && $result->user_id != '') {

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


}
