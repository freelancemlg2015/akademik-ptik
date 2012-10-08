<?php

class Subdirektorat_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function s_subdirektorat() {
        return $this->db->select('m_subdirektorat.*,m_direktorat.nama_direktorat')
                        ->from('m_subdirektorat')
                        ->join('m_direktorat', 'm_direktorat.id = m_subdirektorat.direktorat_id', 'left');    
    }

    function get_many($data_type = NULL, $term = array(), $limit = NULL, $offset = NULL) {
        $this->s_subdirektorat();
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
                $options[$row->id] = $row->nama_subdirektorat;
            }
            echo json_encode($options);
        } else {
            return $query;
        }
    }

    function search($query_array, $limit, $offset, $sort_by, $sort_order) {
        $sort_order = ($sort_order == 'desc') ? 'desc' : 'asc';
        $sort_by = 'id';

        $this->s_subdirektorat()
                ->limit($limit, $offset)
                ->order_by($sort_by, $sort_order);

        if ($query_array['nama_direktorat'] != '') {
            $this->db->like('m_direktorat.nama_direktorat', $query_array['nama_direktorat']);
        }
        
        if ($query_array['nama_subdirektorat'] != '') {
            $this->db->like('m_subdirektorat.nama_subdirektorat', $query_array['nama_subdirektorat']);
        }

        if ($query_array['active'] != '') {
            $this->db->where('m_subdirektorat.active', $query_array['active']);
        }

        $q = $this->db->get();
        //debug echo $this->db->last_query();
        $ret['results'] = $q;
        $ret['num_rows'] = $this->count_subdirektorat($query_array);
        return $ret;
    }

    function count_subdirektorat($query_array) {

        $this->s_subdirektorat();

        if ($query_array['nama_direktorat'] != '') {
            $this->db->like('m_direktorat.nama_direktorat', $query_array['nama_direktorat']);
        }
       
        if ($query_array['nama_subdirektorat'] != '') {
            $this->db->like('m_subdirektorat.nama_subdirektorat', $query_array['nama_subdirektorat']);
        }

        if ($query_array['active'] != '') {
            $this->db->where('m_subdirektorat.active', $query_array['active']);
        }

        return $this->db->count_all_results();
    }

    function set_default() {
        $fields = $this->db->list_fields('m_subdirektorat');
        foreach ($fields as $field) {
            $data[$field] = '';
        }
        return $data;
    }
}

