<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Option extends CI_Controller {

//blum kepake pakein langsung di create servicenya di controller
    function __construct() {
        parent::__construct();
        $this->output->set_header("Pragma: no-cache");
    }

    function update_service_no() {
        $sys_date = new DateTime();
        $sys_month = $sys_date->format('m');
        $sys_year = $sys_date->format('y');

        $this->load->model('option_model');
        $month = $this->option_model->get_options('', array('option' => 't_service_month'))->row();
        $year = $this->option_model->get_options('', array('option' => 't_service_year'))->row();
    }

}
