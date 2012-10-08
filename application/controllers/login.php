<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Login extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('user_model');
        $this->output->set_header("Pragma: no-cache");
    }

    function index() {
        //This method will have the credentials validation
        $this->load->library('form_validation');

        $this->form_validation->set_rules('username', 'Username', 'trim|required|xss_clean');
        $this->form_validation->set_rules('pass', 'Password', 'trim|required|xss_clean|callback_verify');
        $this->form_validation->set_error_delimiters('<span class="notice">', '</span>');
        if ($this->form_validation->run() == FALSE) {
            $this->load->library(array('table'));
            $this->load->helper(array('snippets'));
            //Field validation failed.  User redirected to login page
            // Redirect
            if ($this->session->userdata('logged_in'))
                redirect('home');
            else
                $this->load->view('login');
        } else {
            //Go to private area
            redirect('home');
        }
    }

    function verify($pass) {
        //Field validation succeeded.  Validate against database
        $username = $this->input->post('username');

        //query the database
        $result = $this->user_model->login($username, $pass);
        if ($result) {
            $sess_arr = array();
            foreach ($result as $row) {
                $sess_arr = array(
                    'username' => $row->username,
                    'role' => $row->role
                );
                $this->session->set_userdata('logged_in', $sess_arr);
            }
            return TRUE;
        } else {
            $this->form_validation->set_message('verify', 'Invalid NIP or password'); //'verify' adalah callback error pada saat pengecekan
            return FALSE;
        }
    }

}
