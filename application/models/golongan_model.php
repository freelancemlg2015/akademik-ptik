<?php

class Golongan_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function s_golongan() {
        return $this->db->select('m_golongan.*')
                        ->from('m_golongan');
    }

    function get_many($data_type = NULL, $term = array(), $limit = NULL, $offset = NULL) {
        $this->s_golongan();
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
                $options[$row->id] = $row->golongan;
            }
            echo json_encode($options);
        } else {
            return $query;
        }
    }

    function search($query_array, $limit, $offset, $sort_by, $sort_order) {
        $sort_order = ($sort_order == 'desc') ? 'desc' : 'asc';
        $sort_by = 'id';

        $this->s_golongan()
                ->limit($limit, $offset)
                ->order_by($sort_by, $sort_order);

        if ($query_array['kode_golongan'] != '') {
            $this->db->where('m_golongan.kode_golongan', $query_array['kode_golongan']);
        }

        if ($query_array['golongan'] != '') {
            $this->db->like('m_golongan.golongan', $query_array['golongan']);
        }

        if ($query_array['active'] != '') {
            $this->db->where('m_golongan.active', $query_array['active']);
        }

        $q = $this->db->get();
        //debug echo $this->db->last_query();
        $ret['results'] = $q;
        $ret['num_rows'] = $this->count_golongan($query_array);
        return $ret;
    }

    function count_golongan($query_array) {

        $this->s_golongan();

        if ($query_array['kode_golongan'] != '') {
            $this->db->where('m_golongan.kode_golongan', $query_array['kode_golongan']);
        }

        if ($query_array['golongan'] != '') {
            $this->db->like('m_golongan.golongan', $query_array['golongan']);
        }

        if ($query_array['active'] != '') {
            $this->db->where('m_golongan.active', $query_array['active']);
        }

        return $this->db->count_all_results();
    }

    function set_default() {
        $fields = $this->db->list_fields('m_golongan');
        foreach ($fields as $field) {
            $data[$field] = '';
        }
        return $data;
    }

}

