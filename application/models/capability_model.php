<?php

class Capability_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function get_capability($data_type = NULL, $term = array(), $limit = NULL, $offset = NULL) {
        $this->db->select('m_capabilities.*');
        $this->db->from('m_capabilities');

        if (!empty($term)) {
            foreach ($term as $key => $val) {
                $where[$key] = $val;
            }
            $this->db->where($where);
        }
        $query = $this->db->get();
        //[debug]echo $this->db->last_query();
        if ($data_type == 'json') {
            foreach ($query->result() as $row) {
                $options[$row->id] = $row->capability;
            }
            echo json_encode($options);
        } else {
            return $query;
        }
    }

    function search($query_array, $limit, $offset, $sort_by, $sort_order) {
        $sort_order = ($sort_order == 'desc') ? 'desc' : 'asc';
        $sort_by = 'capability';

        // results query
        $this->db->select('*')
                ->from('m_capabilities')
                ->limit($limit, $offset)
                ->order_by($sort_by, $sort_order);

        if ($query_array['capability'] != '') {
            $this->db->like('capability', strtoupper($query_array['capability']));
        }

        $q = $this->db->get();
        //debug echo $this->db->last_query();
        $ret['results'] = $q;
        $ret['num_rows'] = $this->count_capability($query_array);
        return $ret;
    }

    function count_capability($query_array) {

        // results query
        $this->db->select('id')
                ->from('m_capabilities');

        if ($query_array['capability'] != '') {
            $this->db->like('capability', strtoupper($query_array['capability']));
        }

        //debug echo $this->db->last_query();
        return $this->db->count_all_results();
    }

    function create_capability($data = array()) {

        $this->db->where('capability', $data['capability']);
        $query = $this->db->get('m_capabilities');
        if ($query->num_rows() > 0) {
            //do nothing
        } else {
            //// Insert into the main table
            $this->db->insert('m_capabilities', $data);

            // grab insert id
            $id = $this->db->insert_id();

            return $id;
        }
    }

    function update_capability($data = array()) {
        $this->db->where('id', $data['id']);
        unset($data['id']);
        $this->db->update('m_capabilities', $data);
    }

    function set_default() {
        $fields = $this->db->list_fields('m_capabilities');
        foreach ($fields as $field) {
            $data[$field] = '';
        }
        return $data;
    }

}

