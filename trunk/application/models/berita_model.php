<?php

class Berita_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function s_berita() {
        return $this->db->select('m_berita.*,m_kategori_berita.kategori_berita')
                        ->from('m_berita')
                        ->join('m_kategori_berita', 'm_kategori_berita.id = m_berita.kategori_berita_id', 'left');
    }

    function get_many($data_type = NULL, $term = array(), $limit = NULL, $offset = NULL) {
        $this->s_berita();
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
                $options[$row->id] = $row->judul_berita;
            }
            echo json_encode($options);
        } else {
            return $query;
        }
    }

    function search($query_array, $limit, $offset, $sort_by, $sort_order) {
        $sort_order = ($sort_order == 'desc') ? 'desc' : 'asc';
        $sort_by = 'id';

        $this->s_berita()
                ->limit($limit, $offset)
                ->order_by($sort_by, $sort_order);

        if ($query_array['kategori_berita'] != '') {
            $this->db->like('m_kategori_berita.kategori_berita', $query_array['kategori_berita']);
        }

        if ($query_array['judul_berita'] != '') {
            $this->db->like('m_berita.judul_berita', $query_array['judul_berita']);
        }

        if ($query_array['active'] != '') {
            $this->db->where('m_berita.active', $query_array['active']);
        }

        $q = $this->db->get();
        //debug echo $this->db->last_query();
        $ret['results'] = $q;
        $ret['num_rows'] = $this->count_berita($query_array);
        return $ret;
    }

    function count_berita($query_array) {

        $this->s_berita();

        if ($query_array['kategori_berita'] != '') {
            $this->db->like('m_kategori_berita.kategori_berita', $query_array['kategori_berita']);
        }

        if ($query_array['judul_berita'] != '') {
            $this->db->like('m_berita.judul_berita', $query_array['judul_berita']);
        }

        if ($query_array['active'] != '') {
            $this->db->where('m_berita.active', $query_array['active']);
        }

        return $this->db->count_all_results();
    }

    function set_default() {
        $fields = $this->db->list_fields('m_berita');
        foreach ($fields as $field) {
            $data[$field] = '';
        }
        return $data;
    }
}

