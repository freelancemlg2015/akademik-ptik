<?php

class Kalender_akademik_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function s_kalender_akademik() {
        return $this->db->select("t_kalender_akademik.*,m_angkatan.nama_angkatan,CONCAT(tahun_ajar_mulai,'-',tahun_ajar_akhir) AS tahun,m_semester.nama_semester",false)
                        ->from('t_kalender_akademik')
                        ->join('m_angkatan', 'm_angkatan.id = t_kalender_akademik.angkatan_id', 'left')
                        ->join('m_tahun_akademik', 'm_tahun_akademik.id = t_kalender_akademik.tahun_akademik_id', 'left')
                        ->join('m_semester', 'm_semester.id = t_kalender_akademik.semester_id', 'left');
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
                $options[$row->id] = $row->nama_kegiatan;
            }
            echo json_encode($options);
        } else {
            return $query;
        }
    }

    function search($query_array, $limit, $offset, $sort_by, $sort_order) {
        $sort_order = ($sort_order == 'desc') ? 'desc' : 'asc';
        $sort_by = 'id';

        $this->s_kalender_akademik()
                ->limit($limit, $offset)
                ->order_by($sort_by, $sort_order);

        if ($query_array['nama_angkatan'] != '') {
            $this->db->like('m_angkatan.nama_angkatan', $query_array['nama_angkatan']);
        }
        
        if ($query_array['tahun'] != '') {
            $this->db->where('m_tahun_akademik.tahun', $query_array['tahun']);
        }

        if ($query_array['nama_semester'] != '') {
            $this->db->like('m_semester.nama_semster', $query_array['nama_semster']);
        }
        
        if ($query_array['nama_kegiatan'] != '') {
            $this->db->like('t_kalender_akademik.nama_kegiatan', $query_array['nama_kegiatan']);
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
        $ret['num_rows'] = $this->count_kalender_akademik($query_array);
        return $ret;
    }

    function count_kalender_akademik($query_array) {

        $this->s_kalender_akademik();

        if ($query_array['nama_angkatan'] != '') {
            $this->db->like('m_angkatan.nama_angkatan', $query_array['nama_angkatan']);
        }
        
        if ($query_array['tahun'] != '') {
            $this->db->where('m_tahun_akademik.tahun', $query_array['tahun']);
        }

        if ($query_array['nama_semester'] != '') {
            $this->db->like('m_semester.nama_semster', $query_array['nama_semster']);
        }
        
        if ($query_array['nama_kegiatan'] != '') {
            $this->db->like('t_kalender_akademik.nama_kegiatan', $query_array['nama_kegiatan']);
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
        $fields = $this->db->list_fields('t_kalender_akademik');
        foreach ($fields as $field) {
            $data[$field] = '';
        }
        return $data;
    }

   

}

