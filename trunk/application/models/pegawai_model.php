<?php

class Pegawai_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function s_pegawai() {
        return $this->db->select('m_pegawai.*,                                m_jenis_kelamin.jenis_kelamin,m_agama.agama,m_jabatan_akademik.nama_jabatan_akademik,m_jabatan_tertinggi.jabatan_tertinggi, m_pangkat.nama_pangkat
                                 ')
                        ->from('m_pegawai')
                        ->join('m_pangkat', 'm_pangkat.id = m_pegawai.pangkat_id', 'left')
                        ->join('m_jenis_kelamin', 'm_jenis_kelamin.id = m_pegawai.jenis_kelamin_id', 'left')
                        ->join('m_agama', 'm_agama.id = m_pegawai.agama_id', 'left')
                        ->join('m_jabatan_akademik', 'm_jabatan_akademik.id = m_pegawai.jabatan_akademik_id', 'left')
                        ->join('m_jabatan_tertinggi', 'm_jabatan_tertinggi.id = m_pegawai.jabatan_tertinggi_id', 'left');
    }

    function get_many($data_type = NULL, $term = array(), $limit = NULL, $offset = NULL) {
        $this->s_pegawai();
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
                $options[$row->id] = $row->no_karpeg_pegawai;
            }
            echo json_encode($options);
        } else {
            return $query;
        }
    }

    function search($query_array, $limit, $offset, $sort_by, $sort_order) {
        $sort_order = ($sort_order == 'desc') ? 'desc' : 'asc';
        $sort_by = 'id';

        $this->s_pegawai()
                ->limit($limit, $offset)
                ->order_by($sort_by, $sort_order);

        if ($query_array['no_karpeg_pegawai'] != '') {
            $this->db->where('m_pegawai.no_karpeg_pegawai', $query_array['no_karpeg_pegawai']);
        }

        if ($query_array['nama_pegawai'] != '') {
            $this->db->like('m_pegawai.nama_pegawai', $query_array['nama_pegawai']);
        }

        if ($query_array['active'] != '') {
            $this->db->where('m_pegawai.active', $query_array['active']);
        }

        $q = $this->db->get();
        //debug echo $this->db->last_query();
        $ret['results'] = $q;
        $ret['num_rows'] = $this->count_pegawai($query_array);
        return $ret;
    }

    function count_pegawai($query_array) {

        $this->s_pegawai();

        if ($query_array['no_karpeg_pegawai'] != '') {
            $this->db->where('m_pegawai.no_karpeg_pegawai', $query_array['no_karpeg_pegawai']);
        }

        if ($query_array['nama_pegawai'] != '') {
            $this->db->like('m_pegawai.nama_pegawai', $query_array['nama_pegawai']);
        }

        if ($query_array['active'] != '') {
            $this->db->where('m_pegawai.active', $query_array['active']);
        }

        return $this->db->count_all_results();
    }

    function set_default() {
        $fields = $this->db->list_fields('m_pegawai');
        foreach ($fields as $field) {
            $data[$field] = '';
        }
        return $data;
    }

    //AJAX Impl

    function suggestion($terms = NULL) {
        //return json
        $this->db->select('m_pegawai.id,m_pegawai.nama_pegawai');
        $this->db->from('m_pegawai');

        if (isset($terms['nama_pegawai']) && $terms['nama_pegawai'] != '') {
            $this->db->like('m_pegawai.nama_pegawai', $terms['nama_pegawai']);
        }

        $this->db->limit(10);
        $query = $this->db->get();

        //echo $this->db->last_query();exit;
        if (sizeof($query->result()) > 0) {
            foreach ($query->result() as $row) {
                $options_id[$row->id] = $row->id;
                $options_nama_pegawai[$row->nama_pegawai] = $row->nama_pegawai;
                $options_id_pegawai[$row->nama_pegawai] = $row->id;
            }
            $options['id_options'] = $options_id;
            $options['nama_pegawai_options'] = $options_nama_pegawai;
            $options['id_pegawai_options'] = $options_id_pegawai;
            echo json_encode($options);
        } else {
            return $query;
        }
    }

}

