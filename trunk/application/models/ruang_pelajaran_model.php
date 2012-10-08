<?php

class Ruang_pelajaran_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function s_ruang_pelajaran() {
        return $this->db->select('m_data_ruang.*,m_jenis_ruang.jenis_ruang')
                        ->from('m_data_ruang')
                        ->join('m_jenis_ruang', 'm_jenis_ruang.id = m_data_ruang.jenis_ruang_id', 'left');
    }

    function get_many($data_type = NULL, $term = array(), $limit = NULL, $offset = NULL) {
        $this->s_ruang_pelajaran();
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
                $options[$row->id] = $row->kode_ruang;
            }
            echo json_encode($options);
        } else {
            return $query;
        }
    }

    function search($query_array, $limit, $offset, $sort_by, $sort_order) {
        $sort_order = ($sort_order == 'desc') ? 'desc' : 'asc';
        $sort_by = 'id';

        $this->s_ruang_pelajaran()
                ->limit($limit, $offset)
                ->order_by($sort_by, $sort_order);

        if ($query_array['kode_ruang'] != '') {
            $this->db->where('m_data_ruang.kode_ruang', $query_array['kode_ruang']);
        }

        if ($query_array['nama_ruang'] != '') {
            $this->db->like('m_data_ruang.nama_ruang', $query_array['nama_ruang']);
        }

        if ($query_array['active'] != '') {
            $this->db->where('m_data_ruang.active', $query_array['active']);
        }

        $q = $this->db->get();
        //debug echo $this->db->last_query();
        $ret['results'] = $q;
        $ret['num_rows'] = $this->count_ruang_pelajaran($query_array);
        return $ret;
    }

    function count_ruang_pelajaran($query_array) {

        $this->s_ruang_pelajaran();

        if ($query_array['kode_ruang'] != '') {
            $this->db->where('m_data_ruang.kode_ruang', $query_array['kode_ruang']);
        }

        if ($query_array['nama_ruang'] != '') {
            $this->db->like('m_data_ruang.nama_ruang', $query_array['nama_ruang']);
        }

        if ($query_array['active'] != '') {
            $this->db->where('m_data_ruang.active', $query_array['active']);
        }

        return $this->db->count_all_results();
    }

    function set_default() {
        $fields = $this->db->list_fields('m_data_ruang');
        foreach ($fields as $field) {
            $data[$field] = '';
        }
        return $data;
    }
    
    //AJAX Impl

    function suggestion($terms = NULL) {
        //return json
        $this->db->select('m_data_ruang.id,m_data_ruang.kode_ruang,m_data_ruang.nama_ruang');
        $this->db->from('m_data_ruang');

        if (isset($terms['nama_ruang']) && $terms['nama_ruang'] != '') {
            $this->db->like('m_data_ruang.nama_ruang', $terms['nama_ruang']);
        }

        $this->db->limit(10);
        $query = $this->db->get();

        //echo $this->db->last_query();exit;
        if (sizeof($query->result()) > 0) {
            foreach ($query->result() as $row) {
                $options_id[$row->id] = $row->id;
                $options_kode_ruang[$row->kode_ruang] = $row->kode_ruang;
                $options_nama_ruang[$row->kode_ruang] = $row->nama_ruang;
            }
            $options['id_options'] = $options_id;
            $options['kode_ruang_options'] = $options_kode_ruang;
            $options['nama_ruang_options'] = $options_nama_ruang;
            echo json_encode($options);
        } else {
            return $query;
        }
    }
}

