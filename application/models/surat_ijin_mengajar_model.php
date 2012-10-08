<?php

class Surat_ijin_mengajar_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function s_surat_ijin_mengajar() {
        return $this->db->select('m_surat_ijin_mengajar.*')
                        ->from('m_surat_ijin_mengajar');
    }

    function get_many($data_type = NULL, $term = array(), $limit = NULL, $offset = NULL) {
        $this->s_surat_ijin_mengajar();
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
                $options[$row->id] = $row->surat_ijin_mengajar;
            }
            echo json_encode($options);
        } else {
            return $query;
        }
    }

    function search($query_array, $limit, $offset, $sort_by, $sort_order) {
        $sort_order = ($sort_order == 'desc') ? 'desc' : 'asc';
        $sort_by = 'id';

        $this->s_surat_ijin_mengajar()
                ->limit($limit, $offset)
                ->order_by($sort_by, $sort_order);

        if ($query_array['surat_ijin_mengajar'] != '') {
            $this->db->where('m_surat_ijin_mengajar.surat_ijin_mengajar', $query_array['surat_ijin_mengajar']);
        }

        if ($query_array['active'] != '') {
            $this->db->where('m_surat_ijin_mengajar.active', $query_array['active']);
        }

        $q = $this->db->get();
        //debug echo $this->db->last_query();
        $ret['results'] = $q;
        $ret['num_rows'] = $this->count_surat_ijin_mengajar($query_array);
        return $ret;
    }

    function count_surat_ijin_mengajar($query_array) {

        $this->s_surat_ijin_mengajar();

        if ($query_array['surat_ijin_mengajar'] != '') {
            $this->db->where('m_surat_ijin_mengajar.surat_ijin_mengajar', $query_array['surat_ijin_mengajar']);
        }

        if ($query_array['active'] != '') {
            $this->db->where('m_surat_ijin_mengajar.active', $query_array['active']);
        }

        return $this->db->count_all_results();
    }

    function set_default() {
        $fields = $this->db->list_fields('m_surat_ijin_mengajar');
        foreach ($fields as $field) {
            $data[$field] = '';
        }
        return $data;
    }

}

