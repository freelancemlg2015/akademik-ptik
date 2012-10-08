<?php

class Jenis_kelamin_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function s_jenis_kelamin() {
        return $this->db->select('m_jenis_kelamin.*')
                        ->from('m_jenis_kelamin');
    }

    function get_many($data_type = NULL, $term = array(), $limit = NULL, $offset = NULL) {
        $this->s_jenis_kelamin();
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
                $options[$row->id] = $row->jenis_kelamin;
            }
            echo json_encode($options);
        } else {
            return $query;
        }
    }

    function search($query_array, $limit, $offset, $sort_by, $sort_order) {
        $sort_order = ($sort_order == 'desc') ? 'desc' : 'asc';
        $sort_by = 'id';

        $this->s_jenis_kelamin()
                ->limit($limit, $offset)
                ->order_by($sort_by, $sort_order);

        if ($query_array['jenis_kelamin'] != '') {
            $this->db->where('m_jenis_kelamin.jenis_kelamin', $query_array['jenis_kelamin']);
        }

        if ($query_array['active'] != '') {
            $this->db->where('m_jenis_kelamin.active', $query_array['active']);
        }

        $q = $this->db->get();
        //debug echo $this->db->last_query();
        $ret['results'] = $q;
        $ret['num_rows'] = $this->count_jenis_kelamin($query_array);
        return $ret;
    }

    function count_jenis_kelamin($query_array) {

        $this->s_jenis_kelamin();

        if ($query_array['jenis_kelamin'] != '') {
            $this->db->where('m_jenis_kelamin.jenis_kelamin', $query_array['jenis_kelamin']);
        }

        if ($query_array['active'] != '') {
            $this->db->where('m_jenis_kelamin.active', $query_array['active']);
        }

        return $this->db->count_all_results();
    }

    function set_default() {
        $fields = $this->db->list_fields('m_jenis_kelamin');
        foreach ($fields as $field) {
            $data[$field] = '';
        }
        return $data;
    }

}

