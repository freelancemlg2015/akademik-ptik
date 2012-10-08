<?php

class Status_aktivitas_dosen_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function s_status_aktivitas_dosen() {
        return $this->db->select('m_status_aktivitas_dosen.*')
                        ->from('m_status_aktivitas_dosen');
    }

    function get_many($data_type = NULL, $term = array(), $limit = NULL, $offset = NULL) {
        $this->s_status_aktivitas_dosen();
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
                $options[$row->id] = $row->kode_status_aktivitas;
            }
            echo json_encode($options);
        } else {
            return $query;
        }
    }

    function search($query_array, $limit, $offset, $sort_by, $sort_order) {
        $sort_order = ($sort_order == 'desc') ? 'desc' : 'asc';
        $sort_by = 'id';

        $this->s_status_aktivitas_dosen()
                ->limit($limit, $offset)
                ->order_by($sort_by, $sort_order);

        if ($query_array['kode_status_aktivitas'] != '') {
            $this->db->where('m_status_aktivitas_dosen.kode_status_aktivitas', $query_array['kode_status_aktivitas']);
        }

        if ($query_array['status_aktivitas_dosen'] != '') {
            $this->db->like('m_status_aktivitas_dosen.status_aktivitas_dosen', $query_array['status_aktivitas_dosen']);
        }

        if ($query_array['active'] != '') {
            $this->db->where('m_status_aktivitas_dosen.active', $query_array['active']);
        }

        $q = $this->db->get();
        //debug echo $this->db->last_query();
        $ret['results'] = $q;
        $ret['num_rows'] = $this->count_status_aktivitas_dosen($query_array);
        return $ret;
    }

    function count_status_aktivitas_dosen($query_array) {

        $this->s_status_aktivitas_dosen();

        if ($query_array['kode_status_aktivitas'] != '') {
            $this->db->where('m_status_aktivitas_dosen.kode_status_aktivitas', $query_array['kode_status_aktivitas']);
        }

        if ($query_array['status_aktivitas_dosen'] != '') {
            $this->db->like('m_status_aktivitas_dosen.status_aktivitas_dosen', $query_array['status_aktivitas_dosen']);
        }

        if ($query_array['active'] != '') {
            $this->db->where('m_status_aktivitas_dosen.active', $query_array['active']);
        }

        return $this->db->count_all_results();
    }

    function set_default() {
        $fields = $this->db->list_fields('m_status_aktivitas_dosen');
        foreach ($fields as $field) {
            $data[$field] = '';
        }
        return $data;
    }

}

