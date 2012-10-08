<?php

class Status_dosen_penasehat_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function s_status_dosen_penasehat() {
        return $this->db->select('m_status_dosen_penasehat.*')
                        ->from('m_status_dosen_penasehat');
    }

    function get_many($data_type = NULL, $term = array(), $limit = NULL, $offset = NULL) {
        $this->s_status_dosen_penasehat();
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
                $options[$row->id] = $row->status_dosen_penasehat;
            }
            echo json_encode($options);
        } else {
            return $query;
        }
    }

    function search($query_array, $limit, $offset, $sort_by, $sort_order) {
        $sort_order = ($sort_order == 'desc') ? 'desc' : 'asc';
        $sort_by = 'id';

        $this->s_status_dosen_penasehat()
                ->limit($limit, $offset)
                ->order_by($sort_by, $sort_order);

        if ($query_array['status_dosen_penasehat'] != '') {
            $this->db->where('m_status_dosen_penasehat.status_dosen_penasehat', $query_array['status_dosen_penasehat']);
        }

        if ($query_array['active'] != '') {
            $this->db->where('m_status_dosen_penasehat.active', $query_array['active']);
        }

        $q = $this->db->get();
        //debug echo $this->db->last_query();
        $ret['results'] = $q;
        $ret['num_rows'] = $this->count_status_dosen_penasehat($query_array);
        return $ret;
    }

    function count_status_dosen_penasehat($query_array) {

        $this->s_status_dosen_penasehat();

        if ($query_array['status_dosen_penasehat'] != '') {
            $this->db->where('m_status_dosen_penasehat.status_dosen_penasehat', $query_array['status_dosen_penasehat']);
        }

        if ($query_array['active'] != '') {
            $this->db->where('m_status_dosen_penasehat.active', $query_array['active']);
        }

        return $this->db->count_all_results();
    }

    function set_default() {
        $fields = $this->db->list_fields('m_status_dosen_penasehat');
        foreach ($fields as $field) {
            $data[$field] = '';
        }
        return $data;
    }

}

