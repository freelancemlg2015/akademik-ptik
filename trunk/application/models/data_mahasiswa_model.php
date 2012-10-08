<?php

class Data_mahasiswa_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function s_data_mahasiswa() {
        return $this->db->select('m_data_mahasiswa.*,m_angkatan.nama_angkatan')
                        ->from('m_data_mahasiswa')
                        ->join('m_angkatan', 'm_angkatan.id = m_data_mahasiswa.angkatan_id', 'left')
                        ->join('m_program_studi', 'm_program_studi.id = m_data_mahasiswa.program_studi_id', 'left')
                        ->join('m_konsentrasi_studi', 'm_konsentrasi.id = m_data_mahasiswa.kons_studi_id', 'left')
                        ->join('m_jenis_kelamin', 'm_jenis_kelamin.id = m_data_mahasiswa.jenis_kelamin_id', 'left')
                        ->join('m_agama', 'm_agama.id = m_data_mahasiswa.agama_id', 'left')
                        ->join('m_status_dosen_penasehat', 'm_status_dosen_penasehat.id = m_data_mahasiswa.penasehat_akademik_id', 'left')
                        ->join('m_jabatan_tertinggi', 'm_jabatan_tertinggi.id = m_data_mahasiswa.jabatan_akhir_id', 'left')
                        ->join('m_kesatuan_asal', 'm_kesatuan_asal.id = m_data_mahasiswa.satuan_asal_id', 'left')
                        ->join('m_pangkat', 'm_pangkat.id = m_data_mahasiswa.pangkat_id', 'left')
                        ->join('m_agama', 'm_agama.id = m_data_mahasiswa.agama_ayah_id', 'left')
                        ->join('m_agama', 'm_agama.id = m_data_mahasiswa.agama_wali_id', 'left');
    }

    function get_many($data_type = NULL, $term = array(), $limit = NULL, $offset = NULL) {
        $this->s_data_mahasiswa();
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

        $this->s_data_mahasiswa()
                ->limit($limit, $offset)
                ->order_by($sort_by, $sort_order);

        if ($query_array['nim'] != '') {
            $this->db->where('m_data_mahasiswa.nim', $query_array['nim']);
        }

        if ($query_array['nama'] != '') {
            $this->db->like('m_data_mahasiswa.nama', $query_array['nama']);
        }

        if ($query_array['active'] != '') {
            $this->db->where('m_data_mahasiswa.active', $query_array['active']);
        }

        $q = $this->db->get();
        //debug echo $this->db->last_query();
        $ret['results'] = $q;
        $ret['num_rows'] = $this->count_data_mahasiswa($query_array);
        return $ret;
    }

    function count_data_mahasiswa($query_array) {

        $this->s_data_mahasiswa();

        if ($query_array['nim'] != '') {
            $this->db->where('m_data_mahasiswa.nim', $query_array['nim']);
        }

        if ($query_array['nama'] != '') {
            $this->db->like('m_data_mahasiswa.nama', $query_array['nama']);
        }

        if ($query_array['active'] != '') {
            $this->db->where('m_data_mahasiswa.active', $query_array['active']);
        }

        return $this->db->count_all_results();
    }

    function set_default() {
        $fields = $this->db->list_fields('m_data_mahasiswa');
        foreach ($fields as $field) {
            $data[$field] = '';
        }
        return $data;
    }

}

