<?php

class Semester_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function s_semester() {
        return $this->db->select('m_semester.*')
                        ->from('m_semester');
    }

    function get_many($data_type = NULL, $term = array(), $limit = NULL, $offset = NULL) {
        $this->s_semester();
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
                $options[$row->id] = $row->kode_semester;
            }
            echo json_encode($options);
        } else {
            return $query;
        }
    }

    function search($query_array, $limit, $offset, $sort_by, $sort_order) {
        $sort_order = ($sort_order == 'desc') ? 'desc' : 'asc';
        $sort_by = 'id';

        $this->s_semester()
                ->limit($limit, $offset)
                ->order_by($sort_by, $sort_order);

        if ($query_array['kode_semester'] != '') {
            $this->db->where('m_semester.kode_semester', $query_array['kode_semester']);
        }

        if ($query_array['nama_semester'] != '') {
            $this->db->like('m_semester.nama_semester', $query_array['nama_semester']);
        }

        if ($query_array['active'] != '') {
            $this->db->where('m_semester.active', $query_array['active']);
        }

        $q = $this->db->get();
        //debug echo $this->db->last_query();
        $ret['results'] = $q;
        $ret['num_rows'] = $this->count_semester($query_array);
        return $ret;
    }

    function count_semester($query_array) {

        $this->s_semester();

        if ($query_array['kode_semester'] != '') {
            $this->db->where('m_semester.kode_semester', $query_array['kode_semester']);
        }

        if ($query_array['nama_semester'] != '') {
            $this->db->like('m_semester.nama_semester', $query_array['nama_semester']);
        }

        if ($query_array['active'] != '') {
            $this->db->where('m_semester.active', $query_array['active']);
        }

        return $this->db->count_all_results();
    }

    function set_default() {
        $fields = $this->db->list_fields('m_semester');
        foreach ($fields as $field) {
            $data[$field] = '';
        }
        return $data;
    }
    
    //AJAX Impl

    function suggestion($terms = NULL) {
        //return json
        $this->db->select('m_semester.id,m_semester.kode_semester,m_semester.nama_semester');
        $this->db->from('m_semester');

        if (isset($terms['nama_semester']) && $terms['nama_semester'] != '') {
            $this->db->like('m_semester.nama_semester', $terms['nama_semester']);
        }

        $this->db->limit(10);
        $query = $this->db->get();

        //echo $this->db->last_query();exit;
        if (sizeof($query->result()) > 0) {
            foreach ($query->result() as $row) {
                $options_id[$row->id] = $row->id;
                $options_kode_semester[$row->kode_semester] = $row->kode_semester;
                $options_nama_semester[$row->kode_semester] = $row->nama_semester;
            }
            $options['id_options'] = $options_id;
            $options['kode_semester_options'] = $options_kode_semester;
            $options['nama_semester_options'] = $options_nama_semester;
            echo json_encode($options);
        } else {
            return $query;
        }
    }

}

