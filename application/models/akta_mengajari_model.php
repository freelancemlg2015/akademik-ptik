<?php

class Akta_mengajar_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function s_akta_mengajar() {
        return $this->db->select('m_akta_mengajar.*')
                        ->from('m_akta_mengajar');
    }

    function get_many($data_type = NULL, $term = array(), $limit = NULL, $offset = NULL) {
        $this->s_akta_mengajar();
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
                $options[$row->id] = $row->nama_akta_mengajar;
            }
            echo json_encode($options);
        } else {
            return $query;
        }
    }

    function search($query_array, $limit, $offset, $sort_by, $sort_order) {
        $sort_order = ($sort_order == 'desc') ? 'desc' : 'asc';
        $sort_by = 'id';

        $this->s_akta_mengajar()
                ->limit($limit, $offset)
                ->order_by($sort_by, $sort_order);

        if ($query_array['kode_akta'] != '') {
            $this->db->where('m_akta_mengajar.kode_akta', $query_array['kode_akta']);
        }
        
        if ($query_array['nama_akta_mengajar'] != '') {
            $this->db->like('m_akta_mengajar.nama_akta_mengajar', $query_array['nama_akta_mengajar']);
        }

        if ($query_array['active'] != '') {
            $this->db->where('m_akta_mengajar.active', $query_array['active']);
        }

        $q = $this->db->get();
        //debug echo $this->db->last_query();
        $ret['results'] = $q;
        $ret['num_rows'] = $this->count_akta_mengajar($query_array);
        return $ret;
    }

    function count_akta_mengajar($query_array) {

        $this->s_akta_mengajar();

        if ($query_array['kode_akta'] != '') {
            $this->db->where('m_akta_mengajar.kode_akta', $query_array['kode_akta']);
        }
        
        if ($query_array['nama_akta_mengajar'] != '') {
            $this->db->like('m_akta_mengajar.nama_akta_mengajar', $query_array['nama_akta_mengajar']);
        }

        if ($query_array['active'] != '') {
            $this->db->where('m_akta_mengajar.active', $query_array['active']);
        }

        return $this->db->count_all_results();
    }

    function set_default() {
        $fields = $this->db->list_fields('m_akta_mengajar');
        foreach ($fields as $field) {
            $data[$field] = '';
        }
        return $data;
    }

}

