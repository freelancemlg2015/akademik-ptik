<?php

class Admin_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function get_users() {
        return $this->db->get('mr_m_users');
    }

}

