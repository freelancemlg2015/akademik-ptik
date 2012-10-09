<?php

class Dosen_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function s_dosen() {
        return $this->db->select('m_dosen.*,m_angkatan.nama_angkatan,m_angkatan.kode_angkatan,m_program_studi.nama_program_studi,m_jenjang_studi.jenjang_studi,
                                  m_jenis_kelamin.jenis_kelamin,m_agama.agama,m_jabatan_akademik.nama_jabatan_akademik,m_jabatan_tertinggi.jabatan_tertinggi,
                                  m_status_kerja_dosen.status_kerja_dosen,m_status_aktivitas_dosen.status_aktivitas_dosen,m_semester_mulai_aktivitas.semester_mulai_aktivitas,
                                  m_akta_mengajar.nama_akta_mengajar, m_surat_ijin_mengajar.surat_ijin_mengajar,m_pangkat.nama_pangkat,m_golongan.golongan
                                 ')
                        ->from('m_dosen')
                        ->join('m_angkatan', 'm_angkatan.id = m_dosen.angkatan_id', 'left')
                        ->join('m_program_studi', 'm_program_studi.id = m_dosen.program_studi_id', 'left')
                        ->join('m_jenjang_studi', 'm_jenjang_studi.id = m_dosen.jenjang_studi_id', 'left')
                        ->join('m_pangkat', 'm_pangkat.id = m_dosen.pangkat_id', 'left')
                        ->join('m_jenis_kelamin', 'm_jenis_kelamin.id = m_dosen.jenis_kelamin_id', 'left')
                        ->join('m_agama', 'm_agama.id = m_dosen.agama_id', 'left')
                        ->join('m_jabatan_akademik', 'm_jabatan_akademik.id = m_dosen.jabatan_akademik_id', 'left')
                        ->join('m_jabatan_tertinggi', 'm_jabatan_tertinggi.id = m_dosen.jabatan_tertinggi_id', 'left')
                        ->join('m_status_kerja_dosen', 'm_status_kerja_dosen.id = m_dosen.status_kerja_dosen_id', 'left')
                        ->join('m_status_aktivitas_dosen', 'm_status_aktivitas_dosen.id = m_dosen.status_aktivitas_dosen_id', 'left')
                        ->join('m_semester_mulai_aktivitas', 'm_semester_mulai_aktivitas.id = m_dosen.semester_mulai_aktivitas_id', 'left')
                        ->join('m_akta_mengajar', 'm_akta_mengajar.id = m_dosen.akta_mengajar_id', 'left')
                        ->join('m_surat_ijin_mengajar', 'm_surat_ijin_mengajar.id = m_dosen.surat_ijin_mengajar_id', 'left')
                        ->join('m_golongan', 'm_golongan.id = m_dosen.golongan_id', 'left');
    }

    function get_many($data_type = NULL, $term = array(), $limit = NULL, $offset = NULL) {
        $this->s_dosen();
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
                $options[$row->id] = $row->no_karpeg_dosen;
            }
            echo json_encode($options);
        } else {
            return $query;
        }
    }

    function search($query_array, $limit, $offset, $sort_by, $sort_order) {
        $sort_order = ($sort_order == 'desc') ? 'desc' : 'asc';
        $sort_by = 'id';

        $this->s_dosen()
                ->limit($limit, $offset)
                ->order_by($sort_by, $sort_order);

        if ($query_array['no_karpeg_dosen'] != '') {
            $this->db->where('m_dosen.no_karpeg_dosen', $query_array['no_karpeg_dosen']);
        }

        if ($query_array['nama_dosen'] != '') {
            $this->db->like('m_dosen.nama_dosen', $query_array['nama_dosen']);
        }

        if (@$query_array['nama_program_studi'] != '') {
            $this->db->where('m_program_studi.nama_program_studi', $query_array['nama_program_studi']);
        }

        if ($query_array['kode_angkatan'] != '') {
            $this->db->where('m_angkatan.kode_angkatan', $query_array['kode_angkatan']);
        }

        if ($query_array['active'] != '') {
            $this->db->where('m_dosen.active', $query_array['active']);
        }

        $q = $this->db->get();
        //debug echo $this->db->last_query();
        $ret['results'] = $q;
        $ret['num_rows'] = $this->count_dosen($query_array);
        return $ret;
    }

    function count_dosen($query_array) {

        $this->s_dosen();

        if ($query_array['no_karpeg_dosen'] != '') {
            $this->db->where('m_dosen.no_karpeg_dosen', $query_array['no_karpeg_dosen']);
        }

        if ($query_array['nama_dosen'] != '') {
            $this->db->like('m_dosen.nama_dosen', $query_array['nama_dosen']);
        }

	if (@$query_array['nama_program_studi'] != '') {
            $this->db->where('m_program_studi.nama_program_studi', $query_array['nama_program_studi']);
        }

        if ($query_array['kode_angkatan'] != '') {
            $this->db->where('m_angkatan.kode_angkatan', $query_array['kode_angkatan']);
        }

        if ($query_array['active'] != '') {
            $this->db->where('m_dosen.active', $query_array['active']);
        }

        return $this->db->count_all_results();
    }

    function set_default() {
        $fields = $this->db->list_fields('m_dosen');
        foreach ($fields as $field) {
            $data[$field] = '';
        }
        return $data;
    }

    //AJAX Impl

    function suggestion($terms = NULL) {
        //return json
        $this->db->select('m_dosen.id,m_dosen.nama_dosen');
        $this->db->from('m_dosen');

        if (isset($terms['nama_dosen']) && $terms['nama_dosen'] != '') {
            $this->db->like('m_dosen.nama_dosen', $terms['nama_dosen']);
        }

        $this->db->limit(10);
        $query = $this->db->get();

        //echo $this->db->last_query();exit;
        if (sizeof($query->result()) > 0) {
            foreach ($query->result() as $row) {
                $options_id[$row->id] = $row->id;
                $options_nama_dosen[$row->nama_dosen] = $row->nama_dosen;
                $options_id_dosen[$row->nama_dosen] = $row->id;
            }
            $options['id_options'] = $options_id;
            $options['nama_dosen_options'] = $options_nama_dosen;
            $options['id_dosen_options'] = $options_id_dosen;
            echo json_encode($options);
        } else {
            return $query;
        }
    }

}

