<?php

class Nilai_fisik_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function s_nilai_fisik() {
        return $this->db->select('t_nilai_fisik.*,m_mahasiswa.nim')
                        ->from('t_nilai_fisik')
                        ->join('m_mahasiswa', 'm_mahasiswa.id = t_nilai_fisik.mahasiswa_id', 'left');
    }

    function get_many($data_type = NULL, $term = array(), $limit = NULL, $offset = NULL) {
        $this->s_nilai_fisik();
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
                $options[$row->id] = $row->nilai_fisik;
            }
            echo json_encode($options);
        } else {
            return $query;
        }
    }

    function search($query_array, $limit, $offset, $sort_by, $sort_order) {
        $sort_order = ($sort_order == 'desc') ? 'desc' : 'asc';
        $sort_by = 'id';

        $this->s_nilai_fisik()
                ->limit($limit, $offset)
                ->order_by($sort_by, $sort_order);

        if ($query_array['nim'] != '') {
            $this->db->where('m_mahasiswa.nim', $query_array['nim']);
        }

        if ($query_array['nilai_fisik'] != '') {
            $this->db->where('t_nilai_fisik.nilai_fisik', $query_array['nilai_fisik']);
        }

        if ($query_array['active'] != '') {
            $this->db->where('t_nilai_fisik.active', $query_array['active']);
        }

        $q = $this->db->get();
        //debug echo $this->db->last_query();
        $ret['results'] = $q;
        $ret['num_rows'] = $this->count_nilai_fisik($query_array);
        return $ret;
    }

    function count_nilai_fisik($query_array) {

        $this->s_nilai_fisik();

        if ($query_array['nim'] != '') {
            $this->db->where('m_mahasiswa.nim', $query_array['nim']);
        }

        if ($query_array['nilai_fisik'] != '') {
            $this->db->where('t_nilai_fisik.nilai_fisik', $query_array['nilai_fisik']);
        }

        if ($query_array['active'] != '') {
            $this->db->where('t_nilai_fisik.active', $query_array['active']);
        }
        return $this->db->count_all_results();
    }

    function set_default() {
        $fields = $this->db->list_fields('t_nilai_fisik');
        foreach ($fields as $field) {
            $data[$field] = '';
        }
        return $data;
    }

}

