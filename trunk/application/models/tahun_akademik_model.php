<?php

class Tahun_akademik_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function s_tahun_akademik() {
        return $this->db->select("id,kode_tahun_ajar,tgl_mulai,tahun_ajar_mulai,tahun_ajar_akhir,CONCAT(tahun_ajar_mulai,'-',tahun_ajar_akhir) AS tahun",false)
                        ->from('m_tahun_akademik');
    }

    function get_many($data_type = NULL, $term = array(), $limit = NULL, $offset = NULL) {
        $this->s_tahun_akademik();
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
                $options[$row->id] = $row->tahun_ajar;
            }
            echo json_encode($options);
        } else {
            return $query;
        }
    }

    function search($query_array, $limit, $offset, $sort_by, $sort_order) {
        $sort_order = ($sort_order == 'desc') ? 'desc' : 'asc';
        $sort_by = 'id';

        $this->s_tahun_akademik()
                ->limit($limit, $offset)
                ->order_by($sort_by, $sort_order);

        if ($query_array['kode_tahun_ajar'] != '') {
            $this->db->where('m_tahun_akademik.kode_tahun_ajar', $query_array['kode_tahun_ajar']);
        }

        if ($query_array['active'] != '') {
            $this->db->where('m_tahun_akademik.active', $query_array['active']);
        }

        $q = $this->db->get();
        //[debug] echo $this->db->last_query();
        $ret['results'] = $q;
        $ret['num_rows'] = $this->count_tahun_akademik($query_array);
        return $ret;
    }

    function count_tahun_akademik($query_array) {

        $this->s_tahun_akademik();

        if ($query_array['kode_tahun_ajar'] != '') {
            $this->db->where('m_tahun_akademik.kode_tahun_ajar', $query_array['kode_tahun_ajar']);
        }
        
        if ($query_array['active'] != '') {
            $this->db->where('m_tahun_akademik.active', $query_array['active']);
        }

        return $this->db->count_all_results();
    }

    function set_default() {
        $fields = $this->db->list_fields('m_tahun_akademik');
        foreach ($fields as $field) {
            $data[$field] = '';
        }
        return $data;
    }
    
    //AJAX Impl

    function suggestion($terms = NULL) {
        //return json
        $this->db->select("m_tahun_akademik.id,m_tahun_akademik.kode_tahun_ajar,CONCAT(tahun_ajar_mulai,'-',tahun_ajar_akhir) AS tahun",false);
        $this->db->from('m_tahun_akademik');

        if (isset($terms['tahun']) && $terms['tahun'] != '') {
            $this->db->like('m_tahun_akademik.tahun', $terms['tahun']);
        }

        $this->db->limit(10);
        $query = $this->db->get();

        //echo $this->db->last_query();exit;
        if (sizeof($query->result()) > 0) {
            foreach ($query->result() as $row) {
                $options_id[$row->id] = $row->id;
                $options_tahun[$row->tahun] = $row->tahun;
                $options_id_tahun_ajar[$row->tahun] = $row->id;
            }
            $options['id_options'] = $options_id;
            $options['tahun_options'] = $options_tahun;
            $options['id_tahun_ajar_options'] = $options_id_tahun_ajar;
            echo json_encode($options);
        } else {
            return $query;
        }
    }
}

