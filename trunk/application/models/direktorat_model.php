<?php

class Direktorat_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function s_direktorat() {
        return $this->db->select('m_direktorat.*')
                        ->from('m_direktorat');
    }

    function get_many($data_type = NULL, $term = array(), $limit = NULL, $offset = NULL) {
        $this->s_direktorat();
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
                $options[$row->id] = $row->nama_direktorat;
            }
            echo json_encode($options);
        } else {
            return $query;
        }
    }

    function search($query_array, $limit, $offset, $sort_by, $sort_order) {
        $sort_order = ($sort_order == 'desc') ? 'desc' : 'asc';
        $sort_by = 'id';

        $this->s_direktorat()
                ->limit($limit, $offset)
                ->order_by($sort_by, $sort_order);

        if ($query_array['nama_direktorat'] != '') {
            $this->db->like('m_direktorat.nama_direktorat', $query_array['nama_direktorat']);
        }

        if ($query_array['active'] != '') {
            $this->db->where('m_direktorat.active', $query_array['active']);
        }

        $q = $this->db->get();
        //debug echo $this->db->last_query();
        $ret['results'] = $q;
        $ret['num_rows'] = $this->count_direktorat($query_array);
        return $ret;
    }

    function count_direktorat($query_array) {

        $this->s_direktorat();

        if ($query_array['nama_direktorat'] != '') {
            $this->db->like('m_direktorat.nama_direktorat', $query_array['nama_direktorat']);
        }

        if ($query_array['active'] != '') {
            $this->db->where('m_direktorat.active', $query_array['active']);
        }

        return $this->db->count_all_results();
    }

    function set_default() {
        $fields = $this->db->list_fields('m_direktorat');
        foreach ($fields as $field) {
            $data[$field] = '';
        }
        return $data;
    }
    
    function suggestion($terms = NULL) {
        //return json
        $this->db->select('m_direktorat.id,m_direktorat.nama_direktorat');
        $this->db->from('m_direktorat');

        if (isset($terms['nama_direktorat']) && $terms['nama_direktorat'] != '') {
            $this->db->like('m_direktorat.nama_direktorat', $terms['nama_direktorat']);
        }

        $this->db->limit(10);
        $query = $this->db->get();

        //echo $this->db->last_query();exit;
        if (sizeof($query->result()) > 0) {
            foreach ($query->result() as $row) {
                $options_id[$row->id] = $row->id;
                $options_nama_direktorat[$row->nama_direktorat] = $row->nama_direktorat;
                $options_id_direktorat[$row->nama_direktorat] = $row->id;
            }
            $options['id_options'] = $options_id;
            $options['nama_direktorat_options'] = $options_nama_direktorat;
            $options['id_direktorat_options'] = $options_id_direktorat;
            echo json_encode($options);
        } else {
            return $query;
        }
    }
}

