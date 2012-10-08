<?php

class MY_Input extends CI_Input {

    function __construct() {
        parent::__construct();
    }

    function save_query($query_array) {
        $MY_this =& get_instance();
        $MY_this->db->insert('query', array('query_string' => http_build_query($query_array)));
        return $MY_this->db->insert_id();
    }

    function load_query($query_id) {
        $MY_this =& get_instance();
        $q = $MY_this->db->get_where('query', array('id' => $query_id));
        $row = $q->row();
        if (!empty($row)) {
            parse_str($row->query_string, $_GET);
        }
    }
    /*
     * @desc custom query untuk macam2 ( dashboard, dll )
     */
    function load_custom_query($query_name) {
        $MY_this =& get_instance();
        $q = $MY_this->db->get_where('query', array('name' => $query_name));
        $row = $q->row();
        if (!empty($row)) {
            parse_str($row->query_string, $_GET);
        }
    }

}
