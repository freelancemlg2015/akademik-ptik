<?php

class Mahasiswa_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function s_mahasiswa() {
        return $this->db->select('m_mahasiswa.*,m_angkatan.nama_angkatan,m_program_studi.nama_program_studi,m_jenjang_studi.jenjang_studi,m_konsentrasi_studi.nama_konsentrasi_studi,
                                  m_jenis_kelamin.jenis_kelamin,m_agama.agama,m_jabatan_tertinggi.jabatan_tertinggi,m_kesatuan_asal.nama_kesatuan_asal,m_pangkat.nama_pangkat,m_anak.nama_anak
                                 ')
                        ->from('m_mahasiswa')
                        ->join('m_angkatan', 'm_angkatan.id = m_mahasiswa.angkatan_id', 'left')
                        ->join('m_program_studi', 'm_program_studi.id = m_mahasiswa.program_studi_id', 'left')
                        ->join('m_jenjang_studi', 'm_jenjang_studi.id = m_mahasiswa.jenjang_studi_id', 'left')
                        ->join('m_konsentrasi_studi', 'm_konsentrasi_studi.id = m_mahasiswa.kons_studi_id', 'left')
                        ->join('m_jenis_kelamin', 'm_jenis_kelamin.id = m_mahasiswa.jenis_kelamin_id', 'left')
                        ->join('m_agama', 'm_agama.id = m_mahasiswa.agama_id', 'left')
                        ->join('m_jabatan_tertinggi', 'm_jabatan_tertinggi.id = m_mahasiswa.jabatan_akhir_id', 'left')
                        ->join('m_kesatuan_asal', 'm_kesatuan_asal.id = m_mahasiswa.kesatuan_asal_id', 'left')
                        ->join('m_pangkat', 'm_pangkat.id = m_mahasiswa.pangkat_id', 'left')
                        ->join('m_anak', 'm_anak.id = m_mahasiswa.anak_id', 'left');
                        
    }

    function get_many($data_type = NULL, $term = array(), $limit = NULL, $offset = NULL) {
        $this->s_mahasiswa();
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

        $this->s_mahasiswa()
                ->limit($limit, $offset)
                ->order_by($sort_by, $sort_order);

        if ($query_array['nim'] != '') {
            $this->db->where('m_mahasiswa.nim', $query_array['nim']);
        }

        if ($query_array['nama'] != '') {
            $this->db->like('m_mahasiswa.nama', $query_array['nama']);
        }

        if ($query_array['kode_angkatan'] != '') {
            $this->db->where('m_angkatan.kode_angkatan', $query_array['kode_angkatan']);
        }

        if ($query_array['active'] != '') {
            $this->db->where('m_mahasiswa.active', $query_array['active']);
        }

        $q = $this->db->get();
        //debug echo $this->db->last_query();
        $ret['results'] = $q;
        $ret['num_rows'] = $this->count_mahasiswa($query_array);
        return $ret;
    }

    function count_mahasiswa($query_array) {

        $this->s_mahasiswa();

        if ($query_array['nim'] != '') {
            $this->db->where('m_mahasiswa.nim', $query_array['nim']);
        }

        if ($query_array['nama'] != '') {
            $this->db->like('m_mahasiswa.nama', $query_array['nama']);
        }

        if ($query_array['kode_angkatan'] != '') {
            $this->db->where('m_angkatan.kode_angkatan', $query_array['kode_angkatan']);
        }

        if ($query_array['active'] != '') {
            $this->db->where('m_mahasiswa.active', $query_array['active']);
        }

        return $this->db->count_all_results();
    }

    function set_default() {
        $fields = $this->db->list_fields('m_mahasiswa');
        foreach ($fields as $field) {
            $data[$field] = '';
        }
        return $data;
    }

}

