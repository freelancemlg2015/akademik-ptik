<?php

class Plot_semester_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function s_plot_semester() {
        return 	$this->db->select('t_plot_semester.*,m_angkatan.nama_angkatan,m_angkatan.kode_angkatan,m_angkatan.tahun_akademik_id,
								  m_semester.nama_semester,m_tahun_akademik.tahun_ajar_mulai,m_tahun_akademik.tahun_ajar_akhir')
                        ->from('t_plot_semester')
                        //->join('m_mata_kuliah.angkatan_id = akademik_t_plot_semester.angkatan_id and akademik_m_mata_kuliah.program_studi_id = akademik_t_plot_semester.program_studi_id', 'left')						
						//->join('m_data_ruang', 'm_data_ruang.id = t_plot_semester.nama_ruang_id', 'left')
                        
						->join('m_semester', 't_plot_semester.semester_id = m_semester.id', 'left')
						//->join('m_tahun_akademik', 't_plot_semester.tahun_akademik = m_tahun_akademik.id', 'left')
                       // ->join('m_jam_pelajaran', 'm_jam_pelajaran.id = t_plot_semester.jenis_waktu', 'left')
						//->join('m_metode_ajar', 'm_metode_ajar.id = t_plot_semester.metode_ajar_id', 'left')
						
                        ->join('m_angkatan', 'm_angkatan.id = t_plot_semester.angkatan_id', 'left')
						->join('m_tahun_akademik', 'm_tahun_akademik.id = m_angkatan.tahun_akademik_id', 'left');
						//->join('m_hari', 'm_hari.id = t_plot_semester.hari_id', 'left')
						//->join('t_dosen_ajar', 't_dosen_ajar.id = t_plot_semester.dosen_ajar_id', 'left')
                        //->join('m_dosen', 'm_dosen.id = t_dosen_ajar.dosen_id', 'left');
    }

    function get_many($data_type = NULL, $term = array(), $limit = NULL, $offset = NULL) {
        $this->s_plot_semester();
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
        //$sort_by = 'id';
        $this->s_plot_semester()
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
            $this->db->where('t_plot_semester.minggu-ke', $query_array['minggu']);
        }

        if ($query_array['active'] != '') {
            $this->db->where('t_plot_semester.active', $query_array['active']);
        }

        $q = $this->db->get();
        //debug echo $this->db->last_query();
        $ret['results'] = $q;
        $ret['num_rows'] = $this->count_plot_semester($query_array);
        return $ret;
    }

    function count_plot_semester($query_array) {

        $this->s_plot_semester();

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
            $this->db->where('t_plot_semester.minggu-ke', $query_array['minggu']);
        }

        if ($query_array['active'] != '') {
            $this->db->where('t_plot_semester.active', $query_array['active']);
        }

        return $this->db->count_all_results();
    }

    function set_default() {
        $fields = $this->db->list_fields('t_plot_semester');
        foreach ($fields as $field) {
            $data[$field] = '';
        }
        return $data;
    }
}

