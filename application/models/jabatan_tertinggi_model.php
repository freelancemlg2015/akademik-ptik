<?php

class Jabatan_tertinggi_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function s_jabatan_tertinggi() {
        return $this->db->select('m_jabatan_tertinggi.*,m_status_akreditasi.status_akreditasi')
                        ->from('m_jabatan_tertinggi')
                        ->join('m_status_akreditasi', 'm_status_akreditasi.id = m_jabatan_tertinggi.status_akreditasi_id', 'left');
    }

    function get_many($data_type = NULL, $term = array(), $limit = NULL, $offset = NULL) {
        $this->s_jabatan_tertinggi();
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
                $options[$row->id] = $row->kode_jabatan_tertinggi;
            }
            echo json_encode($options);
        } else {
            return $query;
        }
    }

    function search($query_array, $limit, $offset, $sort_by, $sort_order) {
        $sort_order = ($sort_order == 'desc') ? 'desc' : 'asc';
        $sort_by = 'id';

        $this->s_jabatan_tertinggi()
                ->limit($limit, $offset)
                ->order_by($sort_by, $sort_order);

        if ($query_array['kode_jabatan_tertinggi'] != '') {
            $this->db->where('m_jabatan_tertinggi.kode_jabatan_tertinggi', $query_array['kode_jabatan_tertinggi']);
        }

        if ($query_array['jabatan_tertinggi'] != '') {
            $this->db->like('m_jabatan_tertinggi.jabatan_tertinggi', $query_array['jabatan_tertinggi']);
        }

        if ($query_array['active'] != '') {
            $this->db->where('m_jabatan_tertinggi.active', $query_array['active']);
        }

        $q = $this->db->get();
        //debug echo $this->db->last_query();
        $ret['results'] = $q;
        $ret['num_rows'] = $this->count_jabatan_tertinggi($query_array);
        return $ret;
    }

    function count_jabatan_tertinggi($query_array) {

        $this->s_jabatan_tertinggi();

        if ($query_array['kode_jabatan_tertinggi'] != '') {
            $this->db->where('m_jabatan_tertinggi.kode_jabatan_tertinggi', $query_array['kode_jabatan_tertinggi']);
        }

        if ($query_array['jabatan_tertinggi'] != '') {
            $this->db->like('m_jabatan_tertinggi.jabatan_tertinggi', $query_array['jabatan_tertinggi']);
        }

        if ($query_array['active'] != '') {
            $this->db->where('m_jabatan_tertinggi.active', $query_array['active']);
        }

        return $this->db->count_all_results();
    }

    function set_default() {
        $fields = $this->db->list_fields('m_jabatan_tertinggi');
        foreach ($fields as $field) {
            $data[$field] = '';
        }
        return $data;
    }

}

