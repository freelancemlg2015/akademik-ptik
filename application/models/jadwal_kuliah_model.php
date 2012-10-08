<?php

class Jadwal_kuliah_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function s_jadwal_kuliah() {
        return $this->db->select('t_jadwal_kuliah.*,m_data_ruang.nama_ruang,m_dosen.nama_dosen')
                        ->from('t_jadwal_kuliah')
                        ->join('m_data_ruang', 'm_data_ruang.id = t_jadwal_kuliah.nama_ruang_id', 'left')
                        ->join('t_dosen_ajar', 't_dosen_ajar.id = t_jadwal_kuliah.dosen_ajar_id', 'left')
                        ->join('m_dosen', 'm_dosen.id = t_dosen_ajar.dosen_id', 'left');
    }

    function get_many($data_type = NULL, $term = array(), $limit = NULL, $offset = NULL) {
        $this->s_jadwal_kuliah();
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
                $options[$row->id] = $row->kode_ruang;
            }
            echo json_encode($options);
        } else {
            return $query;
        }
    }

    function search($query_array, $limit, $offset, $sort_by, $sort_order) {
        $sort_order = ($sort_order == 'desc') ? 'desc' : 'asc';
        $sort_by = 'id';

        $this->s_jadwal_kuliah()
                ->limit($limit, $offset)
                ->order_by($sort_by, $sort_order);

        if ($query_array['nama_dosen'] != '') {
            $this->db->like('m_dosen_ruang.nama_dosen', $query_array['nama_dosen']);
        }
        
        if ($query_array['nama_ruang'] != '') {
            $this->db->like('m_data_ruang.nama_ruang', $query_array['nama_ruang']);
        }

        if ($query_array['active'] != '') {
            $this->db->where('t_jadwal_kuliah.active', $query_array['active']);
        }

        $q = $this->db->get();
        //debug echo $this->db->last_query();
        $ret['results'] = $q;
        $ret['num_rows'] = $this->count_jadwal_kuliah($query_array);
        return $ret;
    }

    function count_jadwal_kuliah($query_array) {

        $this->s_jadwal_kuliah();

        if ($query_array['nama_dosen'] != '') {
            $this->db->like('m_dosen.nama_dosen', $query_array['nama_dosen']);
        }
        
        if ($query_array['nama_ruang'] != '') {
            $this->db->like('m_data_ruang.nama_ruang', $query_array['nama_ruang']);
        }

        if ($query_array['active'] != '') {
            $this->db->where('t_jadwal_kuliah.active', $query_array['active']);
        }

        return $this->db->count_all_results();
    }

    function set_default() {
        $fields = $this->db->list_fields('t_jadwal_kuliah');
        foreach ($fields as $field) {
            $data[$field] = '';
        }
        return $data;
    }
}

