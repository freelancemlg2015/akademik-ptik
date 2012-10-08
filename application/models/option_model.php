<?php

class Option_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function get_options($data_type = NULL, $term = array(), $limit = NULL, $offset = NULL) {
        if (!empty($term)) {
            foreach ($term as $key => $val) {
                $where[$key] = $val;
            }
            $this->db->where($where);
        }
        $query = $this->db->get('m_options');

        if ($data_type == 'json') {
            foreach ($query->result() as $row) {
                $options[$row->option] = $row->option_value;
            }
            echo json_encode($options);
        } else {
            return $query;
        }
    }

    function search($query_array, $limit, $offset, $sort_by, $sort_order) {
        $sort_order = ($sort_order == 'desc') ? 'desc' : 'asc';
        $sort_by = 'option';

        // results query
        $this->db->select('*')
                ->from('m_options')
                ->limit($limit, $offset)
                ->order_by($sort_by, $sort_order);
        if ($query_array['option'] != '') {
            $this->db->like('option', strtoupper($query_array['option']));
        }
        $q = $this->db->get();
        //debug echo $this->db->last_query();
        $ret['results'] = $q;
        $ret['num_rows'] = $this->count_options($query_array);
        return $ret;
    }

    function count_options($query_array) {

        // results query
        $this->db->select('id')
                ->from('m_options');
        if ($query_array['option'] != '') {
            $this->db->like('option', strtoupper($query_array['option']));
        }
        //debug echo $this->db->last_query();
        return $this->db->count_all_results();
    }

    function create_option($data = array()) {

        $this->db->where('option', $data['option']);
        $query = $this->db->get('m_options');
        if ($query->num_rows() > 0) {
            //do nothing
        } else {
            //// Insert into the main table
            $this->db->insert('m_options', $data);

            // grab insert id
            return $this->db->insert_id();
        }
    }

    function update_option($data = array()) {
        
        $this->db->where('option', $data['option']);
        unset($data['option']);
        $this->db->update('m_options', $data);
    }

    function set_default() {
        $fields = $this->db->list_fields('m_options');
        foreach ($fields as $field) {
            $data[$field] = '';
        }
        return $data;
    }

}

