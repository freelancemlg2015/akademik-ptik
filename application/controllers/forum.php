<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Forum extends CI_Controller {

    function __construct() {
        parent::__construct();
    }

    function index() {
        $this->load->view('general/forum');      
    }

}
