<?php

/**
 * Description of user_guide
 *
 * @author Fachrul Rozi
 */
class Web_desain_ian extends CI_Controller {
    public function __construct() {
        parent::__construct();
    }
    
    function index(){
        $data['auth'] = $this->auth;
        $this->load->view('web_desain_ian',$data);
    }
}

?>
