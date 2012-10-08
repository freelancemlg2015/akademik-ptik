<?php

class Ujian_skripsi_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function s_ujian_skripsi() {
        return $this->db->select('t_ujian_skripsi.*,m_mahasiswa.nim')
                        ->from('t_ujian_skripsi')
                        ->join('m_mahasiswa', 'm_mahasiswa.id = t_ujian_skripsi.mahasiswa_id', 'left');
    }

    function get_many($data_type = NULL, $term = array(), $limit = NULL, $offset = NULL) {
        $this->s_ujian_skripsi();
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
                $options[$row->id] = $row->judul_skripsi;
            }
            echo json_encode($options);
        } else {
            return $query;
        }
    }

    function search($query_array, $limit, $offset, $sort_by, $sort_order) {
        $sort_order = ($sort_order == 'desc') ? 'desc' : 'asc';
        $sort_by = 'id';

        $this->s_ujian_skripsi()
                ->limit($limit, $offset)
                ->order_by($sort_by, $sort_order);

        if ($query_array['nim'] != '') {
            $this->db->like('m_mahasiswa.nim', $query_array['nim']);
        }
        
        if ($query_array['judul_skripsi'] != '') {
            $this->db->where('t_judul_skripsi.judul_skripsi', $query_array['judul_skripsi']);
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
        $ret['num_rows'] = $this->count_ujian_skripsi($query_array);
        return $ret;
    }

    function count_ujian_skripsi($query_array) {

        $this->s_ujian_skripsi();

        if ($query_array['judul_skripsi'] != '') {
            $this->db->where('t_judul_skripsi.judul_skripsi', $query_array['judul_skripsi']);
        }

        if ($query_array['nim'] != '') {
            $this->db->like('t_judul_skripsi.nim', $query_array['nim']);
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
        $fields = $this->db->list_fields('t_ujian_skripsi');
        foreach ($fields as $field) {
            $data[$field] = '';
        }
        return $data;
    }

   

}

