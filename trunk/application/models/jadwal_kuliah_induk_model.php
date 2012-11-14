<?php

class Jadwal_kuliah_induk_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function s_jadwal_kuliah_induk() {
        /*
		return 	$this->db->select('t_jadwal_kuliah.*,m_data_ruang.nama_ruang,m_dosen.nama_dosen,
						m_jam_pelajaran.kode_jam, m_jam_pelajaran.jam_normal_mulai, m_jam_pelajaran.jam_normal_akhir, 
						m_mata_kuliah.nama_mata_kuliah, m_metode_ajar.metode_ajar, m_kegiatan.nama_kegiatan,
						m_hari.nama_hari')
                        ->from('t_jadwal_kuliah')
                        ->join('m_mata_kuliah', 'm_mata_kuliah.id = t_jadwal_kuliah.mata_kuliah_id and akademik_m_mata_kuliah.angkatan_id = akademik_t_jadwal_kuliah.angkatan_id and akademik_m_mata_kuliah.program_studi_id = akademik_t_jadwal_kuliah.program_studi_id', 'left')						
						->join('m_data_ruang', 'm_data_ruang.id = t_jadwal_kuliah.nama_ruang_id', 'left')
                        ->join('m_semester', 't_jadwal_kuliah.semester_id = m_semester.id', 'left')
                        ->join('m_jam_pelajaran', 'm_jam_pelajaran.id = t_jadwal_kuliah.jenis_waktu', 'left')
						->join('m_metode_ajar', 'm_metode_ajar.id = t_jadwal_kuliah.metode_ajar_id', 'left')
						->join('m_kegiatan', 'm_kegiatan.id = t_jadwal_kuliah.kegiatan_id', 'left')
                        ->join('m_angkatan', 'm_angkatan.id = t_jadwal_kuliah.angkatan_id', 'left')
						->join('m_hari', 'm_hari.id = t_jadwal_kuliah.hari_id', 'left')
						->join('t_dosen_ajar', 't_dosen_ajar.id = t_jadwal_kuliah.dosen_ajar_id', 'left')
                        ->join('m_dosen', 'm_dosen.id = t_dosen_ajar.dosen_id', 'left');
		*/
		/*
		return 	$this->db->select('i.*, d.hari_id, d.jenis_waktu')
                        ->from('t_jadwal_kuliah_induk as i')
						->join('akademik_t_jadwal_kuliah_induk_detil as d', 'd.jadwal_kuliah_induk_id = i.id', 'left');
                        //->join('m_mata_kuliah', 'm_mata_kuliah.id = i.mata_kuliah_id and akademik_m_mata_kuliah.angkatan_id = akademik_i.angkatan_id and akademik_m_mata_kuliah.program_studi_id = akademik_i.program_studi_id', 'left');
						//->join('m_data_ruang', 'm_data_ruang.id = i.nama_ruang_id', 'left')
                        //->join('m_semester', 'i.semester_id = m_semester.id', 'left')
                        //->join('m_jam_pelajaran', 'm_jam_pelajaran.id = i.jenis_waktu', 'left')
						//->join('m_metode_ajar', 'm_metode_ajar.id = i.metode_ajar_id', 'left')
						//->join('m_kegiatan', 'm_kegiatan.id = i.kegiatan_id', 'left')
                        //->join('m_angkatan', 'm_angkatan.id = i.angkatan_id', 'left')
						//->join('m_hari', 'm_hari.id = i.hari_id', 'left')
						//->join('t_dosen_ajar', 't_dosen_ajar.id = i.dosen_ajar_id', 'left')
                        //->join('m_dosen', 'm_dosen.id = t_dosen_ajar.dosen_id', 'left');
						*/
    
		
		return 	$this->db->select('t_jadwal_kuliah_induk.*, d.id as dtl_id, d.jadwal_kuliah_induk_id, d.active, 
						d.pelaksanaan_kuliah, 
						k.nama_mata_kuliah, h.nama_hari, w.jam_normal_mulai, w.jam_normal_akhir')
                        ->from('t_jadwal_kuliah_induk')
                        ->join('t_jadwal_kuliah_induk_detil as d', 'd.jadwal_kuliah_induk_id=t_jadwal_kuliah_induk.id', 'left')						
						->join('t_dosen_ajar as s', 't_jadwal_kuliah_induk.dosen_ajar_id=s.id', 'left')
                        ->join('m_mata_kuliah as k', 's.mata_kuliah_id=k.id', 'left')
                        ->join('m_hari as h', 'd.hari_id=h.id', 'left')
						->join('m_jam_pelajaran as w', 'd.jenis_waktu=w.id', 'left');
						
    }

    function get_many($data_type = NULL, $term = array(), $limit = NULL, $offset = NULL) {
        $this->s_jadwal_kuliah_induk();
        if (!empty($term)) {
            foreach ($term as $key => $val) {
                $where[$key] = $val;
            }
            $this->db->where($where);
        }
        $query = $this->db->get();
        //echo $this->db->last_query();
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
        //$sort_by = 'id';
        $this->s_jadwal_kuliah_induk()
                ->limit($limit, $offset)
                ->order_by($sort_by, $sort_order);

        /*
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
            $this->db->where('t_jadwal_kuliah.minggu-ke', $query_array['minggu']);
        }
		*/

        if ($query_array['active'] != '') {
            $this->db->where('t_jadwal_kuliah_induk.active', $query_array['active']);
        }

        $q = $this->db->get();
        //debug echo $this->db->last_query();
        $ret['results'] = $q;
        $ret['num_rows'] = $this->count_jadwal_kuliah($query_array);
        return $ret;
    }

    function count_jadwal_kuliah($query_array) {

        $this->s_jadwal_kuliah_induk();

        /*
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
            $this->db->where('t_jadwal_kuliah.minggu-ke', $query_array['minggu']);
        }

        */
		if ($query_array['active'] != '') {
            $this->db->where('t_jadwal_kuliah_induk.active', $query_array['active']);
        }

        return $this->db->count_all_results();
    }

    function set_default() {
        $fields = $this->db->list_fields('t_jadwal_kuliah_induk');
        foreach ($fields as $field) {
            $data[$field] = '';
        }
        return $data;
    }
}

