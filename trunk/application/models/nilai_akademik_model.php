<?php

class Nilai_akademik_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function s_nilai_akademik() {
        return $this->db->select('t_nilai_akademik.*,m_mahasiswa.nim,m_mata_kuliah.nama_mata_kuliah')
                        ->from('t_nilai_akademik')
                        ->join('m_mahasiswa', 'm_mahasiswa.id     = t_nilai_akademik.mahasiswa_id', 'left')
                        ->join('m_mata_kuliah', 'm_mata_kuliah.id = t_nilai_akademik.mata_kuliah_id', 'left');
    }

    function get_many($data_type = NULL, $term = array(), $limit = NULL, $offset = NULL) {
        $this->s_nilai_akademik();
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
                $options[$row->id] = $row->nim;
            }
            echo json_encode($options);
        } else {
            return $query;
        }
    }

    function search($query_array, $limit, $offset, $sort_by, $sort_order) {
        $sort_order = ($sort_order == 'desc') ? 'desc' : 'asc';
        $sort_by = 'id';

        $this->s_nilai_akademik()
                ->limit($limit, $offset)
                ->order_by($sort_by, $sort_order);

        if ($query_array['nim'] != '') {
            $this->db->where('m_mahasiswa.nim', $query_array['nim']);
        }
        
        if ($query_array['nama_mata_kuliah'] != '') {
            $this->db->where('m_mata_kuliah.nama_mata_kuliah', $query_array['nama_mata_kuliah']);
        }

        if ($query_array['active'] != '') {
            $this->db->where('t_nilai_akademik.active', $query_array['active']);
        }

        $q = $this->db->get();
        //debug echo $this->db->last_query();
        $ret['results'] = $q;
        $ret['num_rows'] = $this->count_nilai_akademik($query_array);
        return $ret;
    }

    function count_nilai_akademik($query_array) {

        $this->s_nilai_akademik();

        if ($query_array['nim'] != '') {
            $this->db->where('m_mahasiswa.nim', $query_array['nim']);
        }
        
        if ($query_array['nama_mata_kuliah'] != '') {
            $this->db->where('m_mata_kuliah.nama_mata_kuliah', $query_array['nama_mata_kuliah']);
        }

        if ($query_array['active'] != '') {
            $this->db->where('t_nilai_akademik.active', $query_array['active']);
        }
        return $this->db->count_all_results();
    }

    function set_default() {
        $fields = $this->db->list_fields('t_nilai_akademik');
        foreach ($fields as $field) {
            $data[$field] = '';
        }
        return $data;
    }

}

