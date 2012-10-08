<?php

class Konsentrasi_studi_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function s_konsentrasi_studi() {
        return $this->db->select('m_konsentrasi_studi.*')
                        ->from('m_konsentrasi_studi');
    }

    function get_many($data_type = NULL, $term = array(), $limit = NULL, $offset = NULL) {
        $this->s_konsentrasi_studi();
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
                $options[$row->id] = $row->kode_konsentrasi_studi;
            }
            echo json_encode($options);
        } else {
            return $query;
        }
    }

    function search($query_array, $limit, $offset, $sort_by, $sort_order) {
        $sort_order = ($sort_order == 'desc') ? 'desc' : 'asc';
        $sort_by = 'id';

        $this->s_konsentrasi_studi()
                ->limit($limit, $offset)
                ->order_by($sort_by, $sort_order);

        if ($query_array['kode_konsentrasi_studi'] != '') {
            $this->db->where('m_konsentrasi_studi.kode_konsentrasi_studi', $query_array['kode_konsentrasi_studi']);
        }

        if ($query_array['nama_konsentrasi_studi'] != '') {
            $this->db->like('m_konsentrasi_studi.nama_konsentrasi_studi', $query_array['nama_konsentrasi_studi']);
        }

        if ($query_array['active'] != '') {
            $this->db->where('m_konsentrasi_studi.active', $query_array['active']);
        }

        $q = $this->db->get();
        //debug echo $this->db->last_query();
        $ret['results'] = $q;
        $ret['num_rows'] = $this->count_konsentrasi_studi($query_array);
        return $ret;
    }

    function count_konsentrasi_studi($query_array) {

        $this->s_konsentrasi_studi();

        if ($query_array['kode_konsentrasi_studi'] != '') {
            $this->db->where('m_konsentrasi_studi.kode_konsentrasi_studi', $query_array['kode_konsentrasi_studi']);
        }

        if ($query_array['nama_konsentrasi_studi'] != '') {
            $this->db->like('m_konsentrasi_studi.nama_konsentrasi_studi', $query_array['nama_konsentrasi_studi']);
        }

        if ($query_array['active'] != '') {
            $this->db->where('m_konsentrasi_studi.active', $query_array['active']);
        }

        return $this->db->count_all_results();
    }

    function set_default() {
        $fields = $this->db->list_fields('m_konsentrasi_studi');
        foreach ($fields as $field) {
            $data[$field] = '';
        }
        return $data;
    }

}

