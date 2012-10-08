<?php

class Pangkat_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function s_pangkat() {
        return $this->db->select('m_pangkat.*')
                        ->from('m_pangkat');
    }

    function get_many($data_type = NULL, $term = array(), $limit = NULL, $offset = NULL) {
        $this->s_pangkat();
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
                $options[$row->id] = $row->kode_pangkat;
            }
            echo json_encode($options);
        } else {
            return $query;
        }
    }

    function search($query_array, $limit, $offset, $sort_by, $sort_order) {
        $sort_order = ($sort_order == 'desc') ? 'desc' : 'asc';
        $sort_by = 'id';

        $this->s_pangkat()
                ->limit($limit, $offset)
                ->order_by($sort_by, $sort_order);

        if ($query_array['kode_pangkat'] != '') {
            $this->db->where('m_pangkat.kode_pangkat', $query_array['kode_pangkat']);
        }

        if ($query_array['nama_pangkat'] != '') {
            $this->db->like('m_pangkat.nama_pangkat', $query_array['nama_pangkat']);
        }

        if ($query_array['active'] != '') {
            $this->db->where('m_pangkat.active', $query_array['active']);
        }

        $q = $this->db->get();
        //debug echo $this->db->last_query();
        $ret['results'] = $q;
        $ret['num_rows'] = $this->count_pangkat($query_array);
        return $ret;
    }

    function count_pangkat($query_array) {

        $this->s_pangkat();

        if ($query_array['kode_pangkat'] != '') {
            $this->db->where('m_pangkat.kode_pangkat', $query_array['kode_pangkat']);
        }

        if ($query_array['nama_pangkat'] != '') {
            $this->db->like('m_pangkat.nama_pangkat', $query_array['nama_pangkat']);
        }

        if ($query_array['active'] != '') {
            $this->db->where('m_pangkat.active', $query_array['active']);
        }

        return $this->db->count_all_results();
    }

    function set_default() {
        $fields = $this->db->list_fields('m_pangkat');
        foreach ($fields as $field) {
            $data[$field] = '';
        }
        return $data;
    }

}

