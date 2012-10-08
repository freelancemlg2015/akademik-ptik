<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Template_report extends CI_Controller {

    function __construct() {
        parent::__construct();
    }

    function index() {
        $this->load->view('laporan/laporan_kelulusan');      
    }

}
