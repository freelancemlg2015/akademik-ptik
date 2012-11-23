<?php

class aviation_personal extends Controller {

	public function ap_aviation_personal() {
        parent::Controller();
		//$this->load->model("map_sms_voluntary");
    }
	
	public function index($id){
        $this->load->helper("session");
        if (is_login_in ()) {
            $data = array(
                "top" => "position/top",
                "center" => "aviation_personal/index",
                "bottom" => "position/bottom",
                "title" => "Aviation Personal",
                "id" => $id
            );
            $this->load->view("vindex", $data);
        } else {
            redirect('login/');
        }
    }
	
} 
?>