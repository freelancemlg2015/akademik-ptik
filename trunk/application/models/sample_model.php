<?php

class Sample_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function s_sample() {
        return $this->db->select('m_sample.*')
                        ->from('m_sample');
    }

    function get_many($data_type = NULL, $term = array(), $limit = NULL, $offset = NULL) {
        $this->s_sample();
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
                $options[$row->id] = $row->sample;
            }
            echo json_encode($options);
        } else {
            return $query;
        }
    }

    function search($query_array, $limit, $offset, $sort_by, $sort_order) {
        $sort_order = ($sort_order == 'desc') ? 'desc' : 'asc';
        $sort_by = 'id';

        $this->s_sample()
                ->limit($limit, $offset)
                ->order_by($sort_by, $sort_order);

        if ($query_array['sample'] != '') {
            $this->db->like('m_sample.sample', $query_array['sample']);
        }

        if ($query_array['active'] != '') {
            $this->db->where('m_sample.active', $query_array['active']);
        }

        $q = $this->db->get();
        //debug echo $this->db->last_query();
        $ret['results'] = $q;
        $ret['num_rows'] = $this->count_sample($query_array);
        return $ret;
    }

    function count_sample($query_array) {

        $this->s_sample();

        if ($query_array['sample'] != '') {
            $this->db->like('m_sample.sample', $query_array['sample']);
        }

        if ($query_array['active'] != '') {
            $this->db->where('m_sample.active', $query_array['active']);
        }

        return $this->db->count_all_results();
    }

    function set_default() {
        $fields = $this->db->list_fields('m_sample');
        foreach ($fields as $field) {
            $data[$field] = '';
        }
        return $data;
    }

}

