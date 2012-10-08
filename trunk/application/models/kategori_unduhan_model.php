<?php

class Kategori_unduhan_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function s_kategori_unduhan() {
        return $this->db->select('m_kategori_unduhan.*')
                        ->from('m_kategori_unduhan');
    }

    function get_many($data_type = NULL, $term = array(), $limit = NULL, $offset = NULL) {
        $this->s_kategori_unduhan();
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
                $options[$row->id] = $row->kategori_unduhan;
            }
            echo json_encode($options);
        } else {
            return $query;
        }
    }

    function search($query_array, $limit, $offset, $sort_by, $sort_order) {
        $sort_order = ($sort_order == 'desc') ? 'desc' : 'asc';
        $sort_by = 'id';

        $this->s_kategori_unduhan()
                ->limit($limit, $offset)
                ->order_by($sort_by, $sort_order);

        if ($query_array['kategori_unduhan'] != '') {
            $this->db->like('m_kategori_unduhan.kategori_unduhan', $query_array['kategori_unduhan']);
        }

        if ($query_array['active'] != '') {
            $this->db->where('m_kategori_unduhan.active', $query_array['active']);
        }

        $q = $this->db->get();
        //debug echo $this->db->last_query();
        $ret['results'] = $q;
        $ret['num_rows'] = $this->count_kategori_unduhan($query_array);
        return $ret;
    }

    function count_kategori_unduhan($query_array) {

        $this->s_kategori_unduhan();

        if ($query_array['kategori_unduhan'] != '') {
            $this->db->like('m_kategori_unduhan.kategori_unduhan', $query_array['kategori_unduhan']);
        }

        if ($query_array['active'] != '') {
            $this->db->where('m_kategori_unduhan.active', $query_array['active']);
        }

        return $this->db->count_all_results();
    }

    function set_default() {
        $fields = $this->db->list_fields('m_kategori_unduhan');
        foreach ($fields as $field) {
            $data[$field] = '';
        }
        return $data;
    }
}

