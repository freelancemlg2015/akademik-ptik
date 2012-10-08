<?php

class Bobot_nilai_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function s_bobot_nilai() {
        return $this->db->select('m_bobot_nilai.*')
                        ->from('m_bobot_nilai');
    }

    function get_many($data_type = NULL, $term = array(), $limit = NULL, $offset = NULL) {
        $this->s_bobot_nilai();
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
                $options[$row->id] = $row->keterangan_nilai;
            }
            echo json_encode($options);
        } else {
            return $query;
        }
    }

    function search($query_array, $limit, $offset, $sort_by, $sort_order) {
        $sort_order = ($sort_order == 'desc') ? 'desc' : 'asc';
        $sort_by = 'id';

        $this->s_bobot_nilai()
                ->limit($limit, $offset)
                ->order_by($sort_by, $sort_order);

        if ($query_array['kode_bobot_nilai'] != '') {
            $this->db->where('m_bobot_nilai.kode_bobot_nilai', $query_array['kode_bobot_nilai']);
        }
        
        if ($query_array['keterangan_nilai'] != '') {
            $this->db->like('m_bobot_nilai.keterangan_nilai', $query_array['keterangan_nilai']);
        }

        if ($query_array['active'] != '') {
            $this->db->where('m_bobot_nilai.active', $query_array['active']);
        }

        $q = $this->db->get();
        //debug echo $this->db->last_query();
        $ret['results'] = $q;
        $ret['num_rows'] = $this->count_bobot_nilai($query_array);
        return $ret;
    }

    function count_bobot_nilai($query_array) {

        $this->s_bobot_nilai();

        if ($query_array['kode_bobot_nilai'] != '') {
            $this->db->where('m_bobot_nilai.kode_bobot_nilai', $query_array['kode_bobot_nilai']);
        }
        
        if ($query_array['keterangan_nilai'] != '') {
            $this->db->like('m_bobot_nilai.keterangan_nilai', $query_array['keterangan_nilai']);
        }

        if ($query_array['active'] != '') {
            $this->db->where('m_bobot_nilai.active', $query_array['active']);
        }

        return $this->db->count_all_results();
    }

    function set_default() {
        $fields = $this->db->list_fields('m_bobot_nilai');
        foreach ($fields as $field) {
            $data[$field] = '';
        }
        return $data;
    }

}

