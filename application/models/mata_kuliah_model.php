<?php

class Mata_kuliah_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function s_mata_kuliah() {
        return $this->db->select('m_mata_kuliah.*,m_angkatan.nama_angkatan,m_program_studi.nama_program_studi,
                                  m_jenjang_studi.jenjang_studi,m_tahun_akademik.tahun_ajar_mulai,m_tahun_akademik.tahun_ajar_akhir,
                                  m_semester.nama_semester,m_status_matakuliah.nama_matakuliah')
                        ->from('m_mata_kuliah')
                        ->join('m_angkatan', 'm_angkatan.id = m_mata_kuliah.angkatan_id','left')
                        ->join('m_program_studi', 'm_program_studi.id = m_mata_kuliah.program_studi_id','left')
                        ->join('m_jenjang_studi', 'm_jenjang_studi.id = m_mata_kuliah.jenjang_studi_id','left')
                        ->join('m_tahun_akademik', 'm_tahun_akademik.id = m_mata_kuliah.tahun_akademik_id','left')
                        ->join('m_semester', 'm_semester.id = m_mata_kuliah.semester','left')
                        ->join('m_status_matakuliah', 'm_status_matakuliah.id = m_mata_kuliah.status_mata_kuliah_id','left');
    }

    function get_many($data_type = NULL, $term = array(), $limit = NULL, $offset = NULL) {
        $this->s_mata_kuliah();
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
                $options[$row->id] = $row->kode_mata_kuliah;
            }
            echo json_encode($options);
        } else {
            return $query;
        }
    }

    function search($query_array, $limit, $offset, $sort_by, $sort_order) {
        $sort_order = ($sort_order == 'desc') ? 'desc' : 'asc';
        $sort_by = 'id';

        $this->s_mata_kuliah()
                ->limit($limit, $offset)
                ->order_by($sort_by, $sort_order);

        if ($query_array['kode_mata_kuliah'] != '') {
            $this->db->where('m_mata_kuliah.kode_mata_kuliah', $query_array['kode_mata_kuliah']);
        }

        if ($query_array['nama_mata_kuliah'] != '') {
            $this->db->like('m_mata_kuliah.nama_mata_kuliah', $query_array['nama_mata_kuliah']);
        }
        
        if ($query_array['active'] != '') {
            $this->db->where('m_mata_kuliah.active', $query_array['active']);
        }

        $q = $this->db->get();
        //debug echo $this->db->last_query();
        $ret['results'] = $q;
        $ret['num_rows'] = $this->count_mata_kuliah($query_array);
        return $ret;
    }

    function count_mata_kuliah($query_array) {

        $this->s_mata_kuliah();

        if ($query_array['kode_mata_kuliah'] != '') {
            $this->db->where('m_mata_kuliah.kode_mata_kuliah', $query_array['kode_mata_kuliah']);
        }

        if ($query_array['nama_mata_kuliah'] != '') {
            $this->db->like('m_mata_kuliah.nama_mata_kuliah', $query_array['nama_mata_kuliah']);
        }
	 
        if ($query_array['active'] != '') {
            $this->db->where('m_mata_kuliah.active', $query_array['active']);
        }

        return $this->db->count_all_results();
    }

    function set_default() {
        $fields = $this->db->list_fields('m_mata_kuliah');
        foreach ($fields as $field) {
            $data[$field] = '';
        }
        return $data;
    }
}
