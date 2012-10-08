<?php

class Paket_matakuliah_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function s_paket_matakuliah() {
        return $this->db->select('t_paket_mata_kuliah.*,m_angkatan.nama_angkatan,m_tahun_akademik.tahun_ajar,m_mata_kuliah.nama_mata_kuliah,m_semester.nama_semester')
                        ->from('t_paket_mata_kuliah')
                        ->join('m_angkatan', 'm_angkatan.id   = t_paket_mata_kuliah.angkatan_id', 'left')
                        ->join('m_tahun_akademik', 'm_tahun_akademik.id = t_paket_mata_kuliah.tahun_akademik_id', 'left')
                        ->join('m_semester', 'm_semester.id = t_paket_mata_kuliah.semester_id', 'left')
                        ->join('m_mata_kuliah', 'm_mata_kuliah.id = t_paket_mata_kuliah.mata_kuliah_id', 'left');
    }

    function get_many($data_type = NULL, $term = array(), $limit = NULL, $offset = NULL) {
        $this->s_paket_matakuliah();
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
                $options[$row->id] = $row->nama_paket;
            }
            echo json_encode($options);
        } else {
            return $query;
        }
    }

    function search($query_array, $limit, $offset, $sort_by, $sort_order) {
        $sort_order = ($sort_order == 'desc') ? 'desc' : 'asc';
        $sort_by = 'id';

        $this->s_paket_matakuliah()
                ->limit($limit, $offset)
                ->order_by($sort_by, $sort_order);

        if ($query_array['nama_angkatan'] != '') {
            $this->db->like('m_angkatan.nama_angkatan', $query_array['nama_angkatan']);
        }
        
        if ($query_array['tahun_ajar'] != '') {
            $this->db->where('m_tahun_akademik.tahun_ajar', $query_array['tahun_ajar']);
        }

        if ($query_array['nama_semester'] != '') {
            $this->db->like('m_semester.nama_semster', $query_array['nama_semster']);
        }
        
        if ($query_array['nama_paket'] != '') {
            $this->db->like('t_paket_mata_kuliah.nama_paket', $query_array['nama_paket']);
        }

        if (isset($query_array['tgl_ujian_start']) && $query_array['tgl_ujian_start'] != 0 && isset($query_array['tgl_ujian_akhir']) && $query_array['tgl_ujian_akhir'] != 0) {
            $date = new DateTime();
            $format = 'Y-m-j';
            $tgl_start_ujian = $query_array['tgl_ujian_start'];
            $tgl_akhir_ujian = $query_array['tgl_ujian_akhir'];
            $this->db->where("(( akademik_t_ujian_skripsi.tgl_ujian >= '" . $tgl_start_ujian . "' AND akademik_t_ujian_skripsi.tgl_ujian <='" . $tgl_akhir_ujian . "'))");
        }

        $q = $this->db->get();
        //debug echo $this->db->last_query();
        $ret['results'] = $q;
        $ret['num_rows'] = $this->count_paket_matakuliah($query_array);
        return $ret;
    }

    function count_paket_matakuliah($query_array) {

        $this->s_paket_matakuliah();

        if ($query_array['nama_angkatan'] != '') {
            $this->db->like('m_angkatan.nama_angkatan', $query_array['nama_angkatan']);
        }
        
        if ($query_array['tahun_ajar'] != '') {
            $this->db->where('m_tahun_akademik.tahun_ajar', $query_array['tahun_ajar']);
        }

        if ($query_array['nama_semester'] != '') {
            $this->db->like('m_semester.nama_semster', $query_array['nama_semster']);
        }
        
        if ($query_array['nama_paket'] != '') {
            $this->db->like('t_paket_mata_kuliah.nama_paket', $query_array['nama_paket']);
        }

        if (isset($query_array['tgl_ujian_start']) && $query_array['tgl_ujian_start'] != 0 && isset($query_array['tgl_ujian_akhir']) && $query_array['tgl_ujian_akhir'] != 0) {
            $date = new DateTime();
            $format = 'Y-m-j';
            $tgl_start_ujian = $query_array['tgl_ujian_start'];
            $tgl_akhir_ujian = $query_array['tgl_ujian_akhir'];
            $this->db->where("(( akademik_t_ujian_skripsi.tgl_ujian >= '" . $tgl_start_ujian . "' AND akademik_t_ujian_skripsi.tgl_ujian <='" . $tgl_akhir_ujian . "'))");
        }

        return $this->db->count_all_results();
    }

    function set_default() {
        $fields = $this->db->list_fields('t_paket_mata_kuliah');
        foreach ($fields as $field) {
            $data[$field] = '';
        }
        return $data;
    }

   

}

