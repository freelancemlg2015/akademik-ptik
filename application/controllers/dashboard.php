<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Dashboard
 *
 * @author Fachrul Rozi
 */
class Dashboard extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('crud_model', 'crud');
    }

    function index() {

        $this->load->model('dashboard_model', 'dashboard');
        $data = array(
            'wo_open' => $this->dashboard->wo_open(),
            'wo_today' => $this->dashboard->wo_today(),
            'wo_close_today' => $this->dashboard->wo_close_today(),
            'wo_under_repair' => $this->dashboard->wo_under_repair(),
            'wo_canceled' => $this->dashboard->wo_canceled(),
            'wo_close' => $this->dashboard->wo_close()
        );
        $this->load->view('home', $this->data);
    }

}

?>
