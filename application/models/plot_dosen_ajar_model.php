<?php

class Plot_dosen_ajar_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function s_plot_dosen_ajar() {
        return $this->db->select('t_dosen_ajar.*,m_angkatan.nama_angkatan,m_tahun_akademik.tahun_ajar_mulai,
                                                 m_semester.nama_semester,m_mata_kuliah.nama_mata_kuliah,
                                                 m_dosen.nama_dosen,m_mahasiswa.nama')
                        ->from('t_dosen_ajar')
                        ->join('m_angkatan', 'm_angkatan.id = t_dosen_ajar.angkatan_id', 'left')
                        ->join('m_tahun_akademik', 'm_tahun_akademik.id = t_dosen_ajar.tahun_akademik_id', 'left')
                        ->join('m_semester', 'm_semester.id = t_dosen_ajar.semester_id', 'left')
                        ->join('m_mata_kuliah', 'm_mata_kuliah.id = t_dosen_ajar.mata_kuliah_id', 'left')
                        ->join('m_dosen', 'm_dosen.id = t_dosen_ajar.dosen_id', 'left')
                        ->join('m_mahasiswa', 'm_mahasiswa.id = t_dosen_ajar.mahasiswa_id', 'left');
    }

    function get_many($data_type = NULL, $term = array(), $limit = NULL, $offset = NULL) {
        $this->s_plot_dosen_ajar();
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
                $options[$row->id] = $row->nama_angkatan;
            }
            echo json_encode($options);
        } else {
            return $query;
        }
    }

    function search($query_array, $limit, $offset, $sort_by, $sort_order) {
        $sort_order = ($sort_order == 'desc') ? 'desc' : 'asc';
        $sort_by = 'id';

        $this->s_plot_dosen_ajar()
                ->limit($limit, $offset)
                ->order_by($sort_by, $sort_order);

        if ($query_array['nama_angkatan'] != '') {
            $this->db->like('m_angkatan.nama_angkatan', $query_array['nama_angkatan']);
        }

        if ($query_array['tahun_ajar'] != '') {
            $this->db->where('m_tahun_akademik.tahun_ajar', $query_array['tahun_ajar']);
        }

        if ($query_array['active'] != '') {
            $this->db->where('t_dosen_ajar.active', $query_array['active']);
        }

        $q = $this->db->get();
        //debug echo $this->db->last_query();
        $ret['results'] = $q;
        $ret['num_rows'] = $this->count_plot_dosen_ajar($query_array);
        return $ret;
    }

    function count_plot_dosen_ajar($query_array) {

        $this->s_plot_dosen_ajar();

        if ($query_array['nama_angkatan'] != '') {
            $this->db->like('m_angkatan.nama_angkatan', $query_array['nama_angkatan']);
        }

        if ($query_array['tahun_ajar'] != '') {
            $this->db->where('m_tahun_akademik.tahun_ajar', $query_array['tahun_ajar']);
        }

        if ($query_array['active'] != '') {
            $this->db->where('t_dosen_ajar.active', $query_array['active']);
        }

        return $this->db->count_all_results();
    }

    function set_default() {
        $fields = $this->db->list_fields('t_dosen_ajar');
        foreach ($fields as $field) {
            $data[$field] = '';
        }
        return $data;
    }
}

