<?php

class Semester_mulai_aktivitas_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function s_semester_mulai_aktivitas() {
        return $this->db->select('m_semester_mulai_aktivitas.*')
                        ->from('m_semester_mulai_aktivitas');
    }

    function get_many($data_type = NULL, $term = array(), $limit = NULL, $offset = NULL) {
        $this->s_semester_mulai_aktivitas();
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
                $options[$row->id] = $row->semester_mulai_aktivitas;
            }
            echo json_encode($options);
        } else {
            return $query;
        }
    }

    function search($query_array, $limit, $offset, $sort_by, $sort_order) {
        $sort_order = ($sort_order == 'desc') ? 'desc' : 'asc';
        $sort_by = 'id';

        $this->s_semester_mulai_aktivitas()
                ->limit($limit, $offset)
                ->order_by($sort_by, $sort_order);

        if ($query_array['semester_mulai_aktivitas'] != '') {
            $this->db->where('m_semester_mulai_aktivitas.semester_mulai_aktivitas', $query_array['semester_mulai_aktivitas']);
        }

        if ($query_array['active'] != '') {
            $this->db->where('m_semester_mulai_aktivitas.active', $query_array['active']);
        }

        $q = $this->db->get();
        //debug echo $this->db->last_query();
        $ret['results'] = $q;
        $ret['num_rows'] = $this->count_semester_mulai_aktivitas($query_array);
        return $ret;
    }

    function count_semester_mulai_aktivitas($query_array) {

        $this->s_semester_mulai_aktivitas();

        if ($query_array['semester_mulai_aktivitas'] != '') {
            $this->db->where('m_semester_mulai_aktivitas.semester_mulai_aktivitas', $query_array['semester_mulai_aktivitas']);
        }

        if ($query_array['active'] != '') {
            $this->db->where('m_semester_mulai_aktivitas.active', $query_array['active']);
        }

        return $this->db->count_all_results();
    }

    function set_default() {
        $fields = $this->db->list_fields('m_semester_mulai_aktivitas');
        foreach ($fields as $field) {
            $data[$field] = '';
        }
        return $data;
    }

}

