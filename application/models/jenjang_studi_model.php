<?php

class Jenjang_studi_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function s_jenjang_studi() {
        return $this->db->select('m_jenjang_studi.*')
                        ->from('m_jenjang_studi');
    }

    function get_many($data_type = NULL, $term = array(), $limit = NULL, $offset = NULL) {
        $this->s_jenjang_studi();
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
                $options[$row->id] = $row->jenjang_studi;
            }
            echo json_encode($options);
        } else {
            return $query;
        }
    }

    function search($query_array, $limit, $offset, $sort_by, $sort_order) {
        $sort_order = ($sort_order == 'desc') ? 'desc' : 'asc';
        $sort_by = 'id';

        $this->s_jenjang_studi()
                ->limit($limit, $offset)
                ->order_by($sort_by, $sort_order);

        if ($query_array['jenjang_studi'] != '') {
            $this->db->where('m_jenjang_studi.jenjang_studi', $query_array['jenjang_studi']);
        }

        if ($query_array['active'] != '') {
            $this->db->where('m_jenjang_studi.active', $query_array['active']);
        }

        $q = $this->db->get();
        //debug echo $this->db->last_query();
        $ret['results'] = $q;
        $ret['num_rows'] = $this->count_jenjang_studi($query_array);
        return $ret;
    }

    function count_jenjang_studi($query_array) {

        $this->s_jenjang_studi();

        if ($query_array['jenjang_studi'] != '') {
            $this->db->where('m_jenjang_studi.jenjang_studi', $query_array['jenjang_studi']);
        }

        if ($query_array['active'] != '') {
            $this->db->where('m_jenjang_studi.active', $query_array['active']);
        }

        return $this->db->count_all_results();
    }

    function set_default() {
        $fields = $this->db->list_fields('m_jenjang_studi');
        foreach ($fields as $field) {
            $data[$field] = '';
        }
        return $data;
    }

}

