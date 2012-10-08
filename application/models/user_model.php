<?php

class User_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function login($username, $pass) {
        $this->db->select('*');
        $this->db->from('m_users');
        $this->db->where('username = ' . "'" . $username . "'");
        //$this->db->where('pass = ' . "'" . MD5($pass) . "'");
        $this->db->where('pass = ' . "'" . $pass . "'");
        $this->db->limit(1);

        $query = $this->db->get();
        if ($query->num_rows() == 1) {
            return $query->result();
        } else {
            return false;
        }
    }

    function get_users($data_type = NULL, $term = array(), $limit = NULL, $offset = NULL) {

        if (!empty($term)) {
            foreach ($term as $key => $val) {
                $where[$key] = $val;
            }
            $this->db->where($where);
        }
        $query = $this->db->get('m_users');
        // $this->db->last_query();
        if ($data_type == 'json') {
            foreach ($query->result() as $row) {
                $options[$row->id] = $row->username;
            }
            echo json_encode($options);
        } else {
            return $query;
        }
    }

    function create_user($data = array()) {
        // Insert into the main table
        $this->db->insert('m_users', $data);

        // grab insert id
        $user_id = $this->db->insert_id();

        // always count
        $count_data['category'] = 'users';

        $get_count = $this->db->get_where('count', array('category' => 'users'));
        foreach ($get_count->result() as $count) {
            $cur_count = $count->count;
        }
        $count_data['count'] = ( $get_count->num_rows() > 0 ) ? $cur_count + 1 : 0;
        if ($get_count->num_rows() > 0)
            $this->db->update('count', $count_data);
        else
            $this->db->insert('count', $count_data);

        return $user_id;
    }

    function update_user($data = array()) {

        echo "<pre>";
        echo var_dump($data);
        echo "</pre>\n";

        $this->db->get('m_users');
        $this->db->where('id', $data['id']);
        unset($data['id']);
        $this->db->update('m_users', $data);
    }

    function get_user_info($args = array()) {
        if (!empty($args)) {
            foreach ($args as $key => $val) {
                $where[$key] = $val;
            }
            $this->db->where($where);
        }
        //echo $this->db->last_query();
        return $this->db->get('m_users');
    }

    function search($query_array, $limit, $offset, $sort_by, $sort_order) {
        $sort_order = ($sort_order == 'desc') ? 'desc' : 'asc';
        $sort_by = 'username';

        // results query
        $this->db->select('*')
                ->from('m_users')
                ->limit($limit, $offset)
                ->order_by($sort_by, $sort_order);
        if ($query_array['username'] != '') {
            $this->db->like('username', strtoupper($query_array['username']));
        }
        $q = $this->db->get();
        //debug echo $this->db->last_query();
        $ret['results'] = $q;
        $ret['num_rows'] = $this->count_user($query_array);
        return $ret;
    }

    function count_user($query_array) {

        // results query
        $this->db->select('id')
                ->from('m_users');
        if ($query_array['username'] != '') {
            $this->db->like('username', strtoupper($query_array['username']));
        }
        //debug echo $this->db->last_query();
        return $this->db->count_all_results();
    }

    function set_default() {
        $fields = $this->db->list_fields('m_users');
        foreach ($fields as $field) {
            $data[$field] = '';
        }
        return $data;
    }

    function get_capability_by_role($id_role) {

        $sql = "SELECT a.role FROM mr_m_users a, mr_m_roles b WHERE a.role=b.`id` AND a.role= '$id_role'";
        $query = $this->db->query($sql);
    }

}

