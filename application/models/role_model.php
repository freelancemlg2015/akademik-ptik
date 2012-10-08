<?php

class Role_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function get_roles($data_type = NULL, $term = array(), $limit = NULL, $offset = NULL) {
        $this->db->select('*');
        $this->db->from('m_roles');
        if (!empty($term)) {
            foreach ($term as $key => $val) {
                $where[$key] = $val;
            }
            $this->db->where($where);
        }
        $query = $this->db->get();

        if ($data_type == 'json') {
            foreach ($query->result() as $row) {
                $options[$row->id] = $row->role;
            }
            echo json_encode($options);
        } else {
            return $query;
        }
    }

    function search($query_array, $limit, $offset, $sort_by, $sort_order) {
        $sort_order = ($sort_order == 'desc') ? 'desc' : 'asc';
        $sort_by = 'role';

        // results query
        $this->db->select('m_roles.*')
                ->from('m_roles')
                ->join('m_capabilities', 'm_roles.capabilities_id = m_capabilities.id', 'left')
                ->limit($limit, $offset)
                ->order_by($sort_by, $sort_order);
        if ($query_array['role'] != '') {
            $this->db->like('role', strtoupper($query_array['role']));
        }
        $q = $this->db->get();
        //debug echo $this->db->last_query();
        $ret['results'] = $q;
        $ret['num_rows'] = $this->count_role($query_array);
        return $ret;
    }

    function count_role($query_array) {

        // results query
        $this->db->select('id')
                ->from('m_roles');
        if ($query_array['role'] != '') {
            $this->db->like('role', strtoupper($query_array['role']));
        }
        //debug echo $this->db->last_query();
        return $this->db->count_all_results();
    }

    function create_role($data = array()) {
        // Insert into the main table
        $this->db->insert('m_roles', $data);

        // grab insert id
        $id = $this->db->insert_id();

        return $id;
    }

    function update_role($data = array()) {
        $this->db->where('id', $data['id']);
        unset($data['id']);
        $this->db->update('m_roles', $data);
    }

    function set_default() {
        $fields = $this->db->list_fields('m_roles');
        foreach ($fields as $field) {
            $data[$field] = '';
        }
        return $data;
    }

}

