<?php

class Frekuensi_pemutakhiran_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function s_frekuensi_pemutakhiran() {
        return $this->db->select('m_frekuensi_pemutahiran.*')
                        ->from('m_frekuensi_pemutahiran');
    }

    function get_many($data_type = NULL, $term = array(), $limit = NULL, $offset = NULL) {
        $this->s_frekuensi_pemutakhiran();
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
                $options[$row->id] = $row->frekuensi_pemutahiran_kurikulum;
            }
            echo json_encode($options);
        } else {
            return $query;
        }
    }

    function search($query_array, $limit, $offset, $sort_by, $sort_order) {
        $sort_order = ($sort_order == 'desc') ? 'desc' : 'asc';
        $sort_by = 'id';

        $this->s_frekuensi_pemutakhiran()
                ->limit($limit, $offset)
                ->order_by($sort_by, $sort_order);

        if ($query_array['frekuensi_pemutahiran_kurikulum'] != '') {
            $this->db->like('m_frekuensi_pemutahiran.frekuensi_pemutahiran_kurikulum', $query_array['frekuensi_pemutahiran_kurikulum']);
        }

        if ($query_array['active'] != '') {
            $this->db->where('m_frekuensi_pemutahiran.active', $query_array['active']);
        }

        $q = $this->db->get();
        //debug echo $this->db->last_query();
        $ret['results'] = $q;
        $ret['num_rows'] = $this->count_frekuensi_pemutakhiran($query_array);
        return $ret;
    }

    function count_frekuensi_pemutakhiran($query_array) {

        $this->s_frekuensi_pemutakhiran();

        if ($query_array['frekuensi_pemutahiran_kurikulum'] != '') {
            $this->db->like('m_frekuensi_pemutahiran.frekuensi_pemutahiran_kurikulum', $query_array['frekuensi_pemutahiran_kurikulum']);
        }

        if ($query_array['active'] != '') {
            $this->db->where('m_frekuensi_pemutahiran.active', $query_array['active']);
        }

        return $this->db->count_all_results();
    }

    function set_default() {
        $fields = $this->db->list_fields('m_frekuensi_pemutahiran');
        foreach ($fields as $field) {
            $data[$field] = '';
        }
        return $data;
    }

}

