<?php

class Jam_pelajaran_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function s_jam_pelajaran() {
        return $this->db->select('m_jam_pelajaran.*')
                        ->from('m_jam_pelajaran');
    }

    function get_many($data_type = NULL, $term = array(), $limit = NULL, $offset = NULL) {
        $this->s_jam_pelajaran();
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
                $options[$row->id] = $row->kode_jam;
            }
            echo json_encode($options);
        } else {
            return $query;
        }
    }

    function search($query_array, $limit, $offset, $sort_by, $sort_order) {
        $sort_order = ($sort_order == 'desc') ? 'desc' : 'asc';
        $sort_by = 'id';

        $this->s_jam_pelajaran()
                ->limit($limit, $offset)
                ->order_by($sort_by, $sort_order);

        if ($query_array['kode_jam'] != '') {
            $this->db->where('m_jam_pelajaran.kode_jam', $query_array['kode_jam']);
        }

        if ($query_array['jam_normal'] != '') {
            $this->db->like('m_jam_pelajaran.jam_normal', $query_array['jam_normal']);
        }
        
        if ($query_array['jam_puasa'] != '') {
            $this->db->like('m_jam_pelajaran.jam_puasa', $query_array['jam_puasa']);
        }
        
        if ($query_array['active'] != '') {
            $this->db->where('m_jam_pelajaran.active', $query_array['active']);
        }

        $q = $this->db->get();
        //debug echo $this->db->last_query();
        $ret['results'] = $q;
        $ret['num_rows'] = $this->count_jam_pelajaran($query_array);
        return $ret;
    }

    function count_jam_pelajaran($query_array) {

        $this->s_jam_pelajaran();

        if ($query_array['kode_jam'] != '') {
            $this->db->where('m_jam_pelajaran.kode_jam', $query_array['kode_jam']);
        }

        if ($query_array['jam_normal'] != '') {
            $this->db->like('m_jam_pelajaran.jam_normal', $query_array['jam_normal']);
        }
        
        if ($query_array['jam_puasa'] != '') {
            $this->db->like('m_jam_pelajaran.jam_puasa', $query_array['jam_puasa']);
        }

        if ($query_array['active'] != '') {
            $this->db->where('m_jam_pelajaran.active', $query_array['active']);
        }

        return $this->db->count_all_results();
    }

    function set_default() {
        $fields = $this->db->list_fields('m_jam_pelajaran');
        foreach ($fields as $field) {
            $data[$field] = '';
        }
        return $data;
    }

}

