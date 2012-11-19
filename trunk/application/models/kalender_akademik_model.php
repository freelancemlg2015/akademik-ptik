<?php

class Kalender_akademik_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function s_kalender_akademik() {
        return 	$this->db->select('t_kalender_akademik.*,t_plot_semester.tgl_kalender_mulai,m_semester.nama_semester,
		                          m_angkatan.nama_angkatan,m_angkatan.kode_angkatan,m_angkatan.tahun_akademik_id,
								  m_tahun_akademik.tahun_ajar_mulai,m_tahun_akademik.tahun_ajar_akhir')
                        ->from('t_kalender_akademik')                                         
						->join('t_plot_semester', 't_plot_semester.id = t_kalender_akademik.plot_semester_id', 'left')
						->join('m_semester', 't_plot_semester.semester_id = m_semester.id', 'left')
                        ->join('m_angkatan', 'm_angkatan.id = t_plot_semester.angkatan_id', 'left')
						->join('m_tahun_akademik', 'm_tahun_akademik.id = m_angkatan.tahun_akademik_id', 'left');
    }

    function get_many($data_type = NULL, $term = array(), $limit = NULL, $offset = NULL) {
        $this->s_kalender_akademik();
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
        $this->s_kalender_akademik()
                ->limit($limit, $offset)
                ->order_by($sort_by, $sort_order);

	   if (@$query_array['kode_semester'] != '') {
            $this->db->where('ceil(akademik_m_semester.kode_semester)', $query_array['kode_semester']);
        }

        if (@$query_array['kode_angkatan'] != '') {
            $this->db->where('m_angkatan.kode_angkatan', $query_array['kode_angkatan']);
        }

        if ($query_array['active'] != '') {
            $this->db->where('t_kalender_akademik.active', $query_array['active']);
        }

        $q = $this->db->get();
        //debug echo $this->db->last_query();
        $ret['results'] = $q;
        $ret['num_rows'] = $this->count_kalender_akademik($query_array);
        return $ret;
    }

    function count_kalender_akademik($query_array) {

        $this->s_kalender_akademik();

 /*?>        if ($query_array['nama_dosen'] != '') {
            $this->db->like('m_dosen.nama_dosen', $query_array['nama_dosen']);
        }
        
        if ($query_array['nama_ruang'] != '') {
            $this->db->like('m_data_ruang.nama_ruang', $query_array['nama_ruang']);
        }<?php */

	    if (@$query_array['kode_semester'] != '') {
            $this->db->where('ceil(akademik_m_semester.kode_semester)', $query_array['kode_semester']);
        }

        if (@$query_array['kode_angkatan'] != '') {
            $this->db->where('m_angkatan.kode_angkatan', $query_array['kode_angkatan']);
        }
		
        if ($query_array['active'] != '') {
            $this->db->where('t_kalender_akademik.active', $query_array['active']);
        }

        return $this->db->count_all_results();
    }

    function set_default() {
        $fields = $this->db->list_fields('t_kalender_akademik');
        foreach ($fields as $field) {
            $data[$field] = '';
        }
        return $data;
    }
}

