<?php

class Provinsi_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function s_provinsi() {
        return $this->db->select('m_provinsi.*')
                        ->from('m_provinsi');
    }

    function get_many($data_type = NULL, $term = array(), $limit = NULL, $offset = NULL) {
        $this->s_provinsi();
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
                $options[$row->id] = $row->nama_provinsi;
            }
            echo json_encode($options);
        } else {
            return $query;
        }
    }

    function search($query_array, $limit, $offset, $sort_by, $sort_order) {
        $sort_order = ($sort_order == 'desc') ? 'desc' : 'asc';
        $sort_by = 'id';

        $this->s_provinsi()
                ->limit($limit, $offset)
                ->order_by($sort_by, $sort_order);

        if ($query_array['nama_provinsi'] != '') {
            $this->db->like('m_provinsi.nama_provinsi', $query_array['nama_provinsi']);
        }

        if ($query_array['active'] != '') {
            $this->db->where('m_provinsi.active', $query_array['active']);
        }

        $q = $this->db->get();
        //debug echo $this->db->last_query();
        $ret['results'] = $q;
        $ret['num_rows'] = $this->count_provinsi($query_array);
        return $ret;
    }

    function count_provinsi($query_array) {

        $this->s_provinsi();

        if ($query_array['nama_provinsi'] != '') {
            $this->db->like('m_provinsi.nama_provinsi', $query_array['nama_provinsi']);
        }

        if ($query_array['active'] != '') {
            $this->db->where('m_provinsi.active', $query_array['active']);
        }

        return $this->db->count_all_results();
    }

    function set_default() {
        $fields = $this->db->list_fields('m_provinsi');
        foreach ($fields as $field) {
            $data[$field] = '';
        }
        return $data;
    }

}

