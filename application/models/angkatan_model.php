<?php

class Angkatan_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function s_angkatan() {
        return $this->db->select('m_angkatan.*,m_tahun_akademik.tahun_ajar_mulai,m_tahun_akademik.tahun_ajar_akhir')
                        ->from('m_angkatan')
                        ->join('m_tahun_akademik', 'm_tahun_akademik.id = m_angkatan.id', 'left');
    }

    function get_many($data_type = NULL, $term = array(), $limit = NULL, $offset = NULL) {
        $this->s_angkatan();
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
                $options[$row->id] = $row->nama_angkatan;
            }
            echo json_encode($options);
        } else {
            return $query;
        }
    }

    function search($query_array, $limit, $offset, $sort_by, $sort_order) {
        $sort_order = ($sort_order == 'desc') ? 'desc' : 'asc';
        $sort_by = 'id';

        $this->s_angkatan()
                ->limit($limit, $offset)
                ->order_by($sort_by, $sort_order);

        if ($query_array['kode_angkatan'] != '') {
            $this->db->where('m_angkatan.kode_angkatan', $query_array['kode_angkatan']);
        }

        if ($query_array['nama_angkatan'] != '') {
            $this->db->like('m_angkatan.nama_angkatan', $query_array['nama_angkatan']);
        }

        if ($query_array['active'] != '') {
            $this->db->where('m_angkatan.active', $query_array['active']);
        }

        $q = $this->db->get();
        //debug echo $this->db->last_query();
        $ret['results'] = $q;
        $ret['num_rows'] = $this->count_angkatan($query_array);
        return $ret;
    }

    function count_angkatan($query_array) {

        $this->s_angkatan();

        if ($query_array['kode_angkatan'] != '') {
            $this->db->where('m_angkatan.kode_angkatan', $query_array['kode_angkatan']);
        }

        if ($query_array['nama_angkatan'] != '') {
            $this->db->like('m_angkatan.nama_angkatan', $query_array['nama_angkatan']);
        }

        if ($query_array['active'] != '') {
            $this->db->where('m_angkatan.active', $query_array['active']);
        }

        return $this->db->count_all_results();
    }

    function set_default() {
        $fields = $this->db->list_fields('m_angkatan');
        foreach ($fields as $field) {
            $data[$field] = '';
        }
        return $data;
    }

    //AJAX Impl

    function suggestion($terms = NULL) {
        //return json
        $this->db->select('m_angkatan.id,m_angkatan.kode_angkatan,m_angkatan.nama_angkatan');
        $this->db->from('m_angkatan');

        if (isset($terms['nama_angkatan']) && $terms['nama_angkatan'] != '') {
            $this->db->like('m_angkatan.nama_angkatan', $terms['nama_angkatan']);
        }

        $this->db->limit(10);
        $query = $this->db->get();

        //echo $this->db->last_query();exit;
        if (sizeof($query->result()) > 0) {
            foreach ($query->result() as $row) {
                $options_id[$row->id] = $row->id;
                $options_nama_angkatan[$row->nama_angkatan] = $row->nama_angkatan;
                $options_id_angkatan[$row->nama_angkatan] = $row->id;
            }
            $options['id_options'] = $options_id;
            $options['nama_angkatan_options'] = $options_nama_angkatan;
            $options['id_angkatan_options'] = $options_id_angkatan;
            echo json_encode($options);
        } else {
            return $query;
        }
    }

}

