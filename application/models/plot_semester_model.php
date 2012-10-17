<?php

class Plot_semester_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function s_plot_semester() {
        return $this->db->select('t_plot_semester.*,m_angkatan.nama_angkatan,m_angkatan.kode_angkatan,m_tahun_akademik.tahun_ajar_mulai,m_semester.nama_semester')
                        ->from('t_plot_semester')
                        ->join('m_angkatan', 'm_angkatan.id = t_plot_semester.angkatan_id', 'left')
                        ->join('m_tahun_akademik', 'm_tahun_akademik.id = t_plot_semester.tahun_akademik_id', 'left')
                        ->join('m_semester', 'm_semester.id = t_plot_semester.semester_id', 'left');
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

        $this->s_plot_semester()
                ->limit($limit, $offset)
                ->order_by($sort_by, $sort_order);

        if ($query_array['no_karpeg_dosen'] != '') {
            $this->db->where('t_plot_semester.no_karpeg_dosen', $query_array['no_karpeg_dosen']);
        }

        if ($query_array['nama_dosen'] != '') {
            $this->db->like('t_plot_semester.nama_dosen', $query_array['nama_dosen']);
        }

        if ($query_array['kode_angkatan'] != '') {
            $this->db->where('m_angkatan.kode_angkatan', $query_array['kode_angkatan']);
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

        if ($query_array['no_karpeg_dosen'] != '') {
            $this->db->where('t_plot_semester.no_karpeg_dosen', $query_array['no_karpeg_dosen']);
        }

        if ($query_array['nama_dosen'] != '') {
            $this->db->like('t_plot_semester.nama_dosen', $query_array['nama_dosen']);
        }

        if ($query_array['kode_angkatan'] != '') {
            $this->db->where('m_angkatan.kode_angkatan', $query_array['kode_angkatan']);
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

    //AJAX Impl

    function suggestion($terms = NULL) {
        //return json
        $this->db->select('t_plot_semester.id,t_plot_semester.nama_dosen');
        $this->db->from('t_plot_semester');

        if (isset($terms['t_plot_semester']) && $terms['nama_dosen'] != '') {
            $this->db->like('t_plot_semester.nama_dosen', $terms['nama_dosen']);
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

