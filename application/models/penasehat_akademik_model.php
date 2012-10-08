<?php

class Penasehat_akademik_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function s_penasehat_akademik() {
        return $this->db->select('t_penasehat_akademik.*,m_angkatan.kode_angkatan,m_jenjang_studi.jenjang_studi,m_program_studi.kode_program_studi,m_program_studi.nama_program_studi')
                        ->from('t_penasehat_akademik')
                        ->join('m_angkatan', 'm_angkatan.id = t_penasehat_akademik.angkatan_id', 'left')
                        ->join('m_jenjang_studi', 'm_jenjang_studi.id = t_penasehat_akademik.jenjang_studi_id', 'left')
                        ->join('m_program_studi', 'm_program_studi.id = t_penasehat_akademik.program_studi_id', 'left');
        ;
    }

    function get_many($data_type = NULL, $term = array(), $limit = NULL, $offset = NULL) {
        $this->s_penasehat_akademik();
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
                $options[$row->id] = $row->penasehat_akademik;
            }
            echo json_encode($options);
        } else {
            return $query;
        }
    }

    function search($query_array, $limit, $offset, $sort_by, $sort_order) {
        $sort_order = ($sort_order == 'desc') ? 'desc' : 'asc';
        $sort_by = 'id';

        $this->s_penasehat_akademik()
                ->limit($limit, $offset)
                ->order_by($sort_by, $sort_order);

        if ($query_array['kode_angkatan'] != '') {
            $this->db->where('m_angkatan.kode_angkatan', $query_array['kode_angkatan']);
        }
        if ($query_array['jenjang_studi'] != '') {
            $this->db->where('m_jenjang_studi.jenjang_studi', $query_array['jenjang_studi']);
        }
        if ($query_array['program_studi'] != '') {
            $this->db->where('m_program_studi.program_studi', $query_array['program_studi']);
        }
        if ($query_array['penasehat_akademik'] != '') {
            $this->db->where('t_penasehat_akademik.penasehat_akademik', $query_array['penasehat_akademik']);
        }

        if ($query_array['active'] != '') {
            $this->db->where('t_penasehat_akademik.active', $query_array['active']);
        }

        $q = $this->db->get();
        //debug echo $this->db->last_query();
        $ret['results'] = $q;
        $ret['num_rows'] = $this->count_penasehat_akademik($query_array);
        return $ret;
    }

    function count_penasehat_akademik($query_array) {

        $this->s_penasehat_akademik();

        if ($query_array['kode_angkatan'] != '') {
            $this->db->where('m_angkatan.kode_angkatan', $query_array['kode_angkatan']);
        }
        if ($query_array['jenjang_studi'] != '') {
            $this->db->where('m_jenjang_studi.jenjang_studi', $query_array['jenjang_studi']);
        }
        if ($query_array['program_studi'] != '') {
            $this->db->where('m_program_studi.program_studi', $query_array['program_studi']);
        }
        if ($query_array['penasehat_akademik'] != '') {
            $this->db->where('t_penasehat_akademik.penasehat_akademik', $query_array['penasehat_akademik']);
        }
        if ($query_array['active'] != '') {
            $this->db->where('t_penasehat_akademik.active', $query_array['active']);
        }
        return $this->db->count_all_results();
    }

    function set_default() {
        $fields = $this->db->list_fields('t_penasehat_akademik');
        foreach ($fields as $field) {
            $data[$field] = '';
        }
        return $data;
    }

}

