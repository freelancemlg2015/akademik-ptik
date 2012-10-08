<?php

class Kategori_pejabat_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function s_kategori_pejabat() {
        return $this->db->select('m_kategori_pejabat.*')
                        ->from('m_kategori_pejabat');
    }

    function get_many($data_type = NULL, $term = array(), $limit = NULL, $offset = NULL) {
        $this->s_kategori_pejabat();
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

        $this->s_kategori_pejabat()
                ->limit($limit, $offset)
                ->order_by($sort_by, $sort_order);

        if ($query_array['nama_jenis_pejabat'] != '') {
            $this->db->like('m_kategori_pejabat.nama_jenis_pejabat', $query_array['nama_jenis_pejabat']);
        }

        if ($query_array['active'] != '') {
            $this->db->where('m_kategori_pejabat.active', $query_array['active']);
        }

        $q = $this->db->get();
        //debug echo $this->db->last_query();
        $ret['results'] = $q;
        $ret['num_rows'] = $this->count_kategori_pejabat($query_array);
        return $ret;
    }

    function count_kategori_pejabat($query_array) {

        $this->s_kategori_pejabat();

        if ($query_array['nama_jenis_pejabat'] != '') {
            $this->db->like('m_kategori_pejabat.nama_jenis_pejabat', $query_array['nama_jenis_pejabat']);
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

    //AJAX Impl

    function suggestion($terms = NULL) {
        //return json
        $this->db->select('m_kategori_pejabat.id,kategori_pejabat.nama_jenis_pejabat');
        $this->db->from('m_kategori_pejabat');

        if (isset($terms['nama_jenis_pejabat']) && $terms['nama_jenis_pejabat'] != '') {
            $this->db->like('m_kategori_pejabat.nama_jenis_pejabat', $terms['nama_jenis_pejabat']);
        }

        $this->db->limit(10);
        $query = $this->db->get();

        //echo $this->db->last_query();exit;
        if (sizeof($query->result()) > 0) {
            foreach ($query->result() as $row) {
                $options_id[$row->id] = $row->id;
                $options_nama_jenis_pejabat[$row->id] = $row->nama_jenis_pejabat;
            }
            $options['id_options'] = $options_id;
            $options['nama_jenis_pejabat_options'] = $options_nama_jenis_pejabat;
            echo json_encode($options);
        } else {
            return $query;
        }
    }

}

