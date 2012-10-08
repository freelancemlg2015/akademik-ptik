<?php

class Pejabat_kategori_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function s_pejabat_kategori() {
        return $this->db->select('m_kategori_pejabat.*')
                        ->from('m_kategori_pejabat');
    }

    function get_many($data_type = NULL, $term = array(), $limit = NULL, $offset = NULL) {
        $this->s_pejabat_kategori();
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
                $options[$row->id] = $row->nama_jenis_pejabat;
            }
            echo json_encode($options);
        } else {
            return $query;
        }
    }

    function search($query_array, $limit, $offset, $sort_by, $sort_order) {
        $sort_order = ($sort_order == 'desc') ? 'desc' : 'asc';
        $sort_by = 'id';

        $this->s_pejabat_kategori()
                ->limit($limit, $offset)
                ->order_by($sort_by, $sort_order);

        if ($query_array['nama_jenis_pejabat'] != '') {
            $this->db->where('m_kategori_pejabat.nama_jenis_pejabat', $query_array['nama_jenis_pejabat']);
        }

        if ($query_array['keterangan'] != '') {
            $this->db->like('m_kategori_pejabat.keterangan', $query_array['keterangan']);
        }

        if ($query_array['active'] != '') {
            $this->db->where('m_kategori_pejabat.active', $query_array['active']);
        }

        $q = $this->db->get();
        //debug echo $this->db->last_query();
        $ret['results'] = $q;
        $ret['num_rows'] = $this->count_pejabat_kategori($query_array);
        return $ret;
    }

    function count_pejabat_kategori($query_array) {

        $this->s_pejabat_kategori();

        if ($query_array['nama_jenis_pejabat'] != '') {
            $this->db->where('m_kategori_pejabat.nama_jenis_pejabat', $query_array['nama_jenis_pejabat']);
        }

        if ($query_array['keterangan'] != '') {
            $this->db->like('m_kategori_pejabat.katerangan', $query_array['keterangan']);
        }

        if ($query_array['active'] != '') {
            $this->db->where('m_kategori_pejabat.active', $query_array['active']);
        }

        return $this->db->count_all_results();
    }

    function set_default() {
        $fields = $this->db->list_fields('m_kategori_pejabat');
        foreach ($fields as $field) {
            $data[$field] = '';
        }
        return $data;
    }

}

