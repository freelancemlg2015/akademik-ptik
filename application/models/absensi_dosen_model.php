<?php

class Absensi_dosen_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function s_jadwal_ujian() {
        return 	$this->db->select('t_jadwal_ujian.*,m_data_ruang.nama_ruang,m_dosen.nama_dosen,
						m_mata_kuliah.nama_mata_kuliah, m_jenis_ujian.kode_ujian,
						m_hari.nama_hari')
                        ->from('t_jadwal_ujian')
                        ->join('m_mata_kuliah', 'm_mata_kuliah.id = t_jadwal_ujian.mata_kuliah_id and akademik_m_mata_kuliah.angkatan_id = akademik_t_jadwal_ujian.angkatan_id and akademik_m_mata_kuliah.program_studi_id = akademik_t_jadwal_ujian.program_studi_id', 'left')						
						->join('m_data_ruang', 'm_data_ruang.id = t_jadwal_ujian.nama_ruang_id', 'left')
						->join('m_jenis_ujian', 'm_jenis_ujian.id = t_jadwal_ujian.jenis_ujian_id', 'left')
                        ->join('t_dosen_ajar', 't_dosen_ajar.id = t_jadwal_ujian.dosen_ajar_id', 'left')
                        ->join('m_semester', 't_jadwal_ujian.semester_id = m_semester.id', 'left')
                        ->join('m_angkatan', 'm_angkatan.id = t_jadwal_ujian.angkatan_id', 'left')
						->join('m_hari', 'm_hari.id = t_jadwal_ujian.hari_id', 'left')
                        ->join('m_dosen', 'm_dosen.id = t_dosen_ajar.dosen_id', 'left');
	}

    function get_many($data_type = NULL, $term = array(), $limit = NULL, $offset = NULL) {
        $this->s_jadwal_ujian();
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

    function search($query_array, $limit, $offset, $sort_by='id', $sort_order) {
        $sort_order = ($sort_order == 'desc') ? 'desc' : 'asc';
        $this->s_jadwal_ujian()
                ->limit($limit, $offset)
                ->order_by($sort_by, $sort_order);

        if ($query_array['nama_dosen'] != '') {
            $this->db->like('m_dosen_ruang.nama_dosen', $query_array['nama_dosen']);
        }
        
        if ($query_array['nama_ruang'] != '') {
            $this->db->like('m_data_ruang.nama_ruang', $query_array['nama_ruang']);
        }

	 if (@$query_array['kode_semester'] != '') {
            $this->db->where('ceil(akademik_m_semester.kode_semester)', $query_array['kode_semester']);
        }

        if (@$query_array['kode_angkatan'] != '') {
            $this->db->where('m_angkatan.kode_angkatan', $query_array['kode_angkatan']);
        }

        if (@$query_array['minggu'] != '') {
            $this->db->where('t_jadwal_ujian.minggu-ke', $query_array['minggu']);
        }

        if ($query_array['active'] != '') {
            $this->db->where('t_jadwal_ujian.active', $query_array['active']);
        }

        $q = $this->db->get();
        //debug echo $this->db->last_query();
        $ret['results'] = $q;
        $ret['num_rows'] = $this->count_jadwal_ujian($query_array);
        return $ret;
    }

    function count_jadwal_ujian($query_array) {

        $this->s_jadwal_ujian();

        if ($query_array['nama_dosen'] != '') {
            $this->db->like('m_dosen.nama_dosen', $query_array['nama_dosen']);
        }
        
        if ($query_array['nama_ruang'] != '') {
            $this->db->like('m_data_ruang.nama_ruang', $query_array['nama_ruang']);
        }

	 if (@$query_array['kode_semester'] != '') {
            $this->db->where('ceil(akademik_m_semester.kode_semester)', $query_array['kode_semester']);
        }

        if (@$query_array['kode_angkatan'] != '') {
            $this->db->where('m_angkatan.kode_angkatan', $query_array['kode_angkatan']);
        }

        if (@$query_array['minggu'] != '') {
            $this->db->where('t_jadwal_ujian.minggu-ke', $query_array['minggu']);
        }

        if ($query_array['active'] != '') {
            $this->db->where('t_jadwal_ujian.active', $query_array['active']);
        }

        return $this->db->count_all_results();
    }

    function set_default() {
        $fields = $this->db->list_fields('t_jadwal_ujian');
        foreach ($fields as $field) {
            $data[$field] = '';
        }
        return $data;
    }
}

