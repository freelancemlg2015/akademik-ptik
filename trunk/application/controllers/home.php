<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Home extends CI_Controller {

    function __construct() {
        parent::__construct();
        //$this->output->set_header("Pragma: no-cache");
    }

    function index() {
        if ($this->session->userdata('logged_in')) {
            $this->load->helper('snippets');
            $session_data = $this->session->userdata('logged_in');
            
            //set session
            $data['username'] = $session_data['username'];
            $data['role'] = $session_data['role'];
            $data['auth'] = $this->auth;
            
            $this->load->model('dashboard_model', 'dashboard');

            $this->load->view('home', $data);
        } else {
            //If no session, redirect to login page
            redirect(base_url());
        }
    }

    function logout() {
        $this->session->unset_userdata('logged_in');
        $logout = $this->session->sess_destroy();
        if (!isset($logout)) {
            redirect(base_url());
        }
    }

    function as400db_tester() {
        $data['auth'] = $this->auth;
        $data['page_title'] = 'test AS400 conn';
        $this->load->model('as400db_sukucadang_model');
        $data['results'] = $this->as400db_sukucadang_model->get_sukucadang();
        $this->load->view('home', $data);
    }

}
