<?php

class ap_aviation_personal extends Controller {

	public function ap_sms_voluntary() {
        parent::Controller();
		$this->load->model("map_sms_voluntary");
    }
	
} ?>