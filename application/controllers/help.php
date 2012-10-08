<?php

/**
 * Description of user_guide
 *
 * @author Fachrul Rozi
 */
class Help extends CI_Controller {
    public function __construct() {
        parent::__construct();
    }
    
    function index(){
        $data['auth'] = $this->auth;
        $this->load->view('help',$data);
    }
}

?>
