<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class ap_voluntary extends Controller {

	function ap_voluntary() {
        parent::Controller();
        //$this->load->model("map_airline");
    }
	
	function index(){
		echo 'test';
	}
	
	function show() {
        $lang = $this->session->userdata('app_language');
		if(empty($lang)) $this->load->view("ap_voluntary/show");
		else if($lang == "id") $this->load->view("ap_voluntary/show");
		else if($lang == "en") $this->load->view("ap_voluntary/show_en");
    }
	
	function insert(){
		$this->load->view("ap_voluntary/insert");
	}

}?>