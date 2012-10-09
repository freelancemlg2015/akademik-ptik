<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Laporan extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->output->set_header("Pragma: no-cache");
    }

    function index() {
        redirect('laporan/laporan_daftar_mahasiswa');
    }

}
