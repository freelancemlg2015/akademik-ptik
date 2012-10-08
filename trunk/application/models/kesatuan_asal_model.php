<?php

class Kesatuan_asal_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function s_kesatuan_asal() {
        return $this->db->select('m_kesatuan_asal.*')
                        ->from('m_kesatuan_asal');
    }

    function get_many($data_type = NULL, $term = array(), $limit = NULL, $offset = NULL) {
        $this->s_kesatuan_asal();
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
                $options[$row->id] = $row->kode_kesatuan_asal;
            }
            echo json_encode($options);
        } else {
            return $query;
        }
    }

    function search($query_array, $limit, $offset, $sort_by, $sort_order) {
        $sort_order = ($sort_order == 'desc') ? 'desc' : 'asc';
        $sort_by = 'id';

        $this->s_kesatuan_asal()
                ->limit($limit, $offset)
                ->order_by($sort_by, $sort_order);

        if ($query_array['kode_kesatuan_asal'] != '') {
            $this->db->where('m_kesatuan_asal.kode_kesatuan_asal', $query_array['kode_kesatuan_asal']);
        }

        if ($query_array['nama_kesatuan_asal'] != '') {
            $this->db->like('m_kesatuan_asal.nama_kesatuan_asal', $query_array['nama_kesatuan_asal']);
        }

        if ($query_array['active'] != '') {
            $this->db->where('m_kesatuan_asal.active', $query_array['active']);
        }

        $q = $this->db->get();
        //debug echo $this->db->last_query();
        $ret['results'] = $q;
        $ret['num_rows'] = $this->count_kesatuan_asal($query_array);
        return $ret;
    }

    function count_kesatuan_asal($query_array) {

        $this->s_kesatuan_asal();

        if ($query_array['kode_kesatuan_asal'] != '') {
            $this->db->where('m_kesatuan_asal.kode_kesatuan_asal', $query_array['kode_kesatuan_asal']);
        }

        if ($query_array['nama_kesatuan_asal'] != '') {
            $this->db->like('m_kesatuan_asal.nama_kesatuan_asal', $query_array['nama_kesatuan_asal']);
        }

        if ($query_array['active'] != '') {
            $this->db->where('m_kesatuan_asal.active', $query_array['active']);
        }

        return $this->db->count_all_results();
    }

    function set_default() {
        $fields = $this->db->list_fields('m_kesatuan_asal');
        foreach ($fields as $field) {
            $data[$field] = '';
        }
        return $data;
    }

}

