<?php

class Kategori_berita_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function s_kategori_berita() {
        return $this->db->select('m_kategori_berita.*')
                        ->from('m_kategori_berita');
    }

    function get_many($data_type = NULL, $term = array(), $limit = NULL, $offset = NULL) {
        $this->s_kategori_berita();
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
                $options[$row->id] = $row->kategori_berita;
            }
            echo json_encode($options);
        } else {
            return $query;
        }
    }

    function search($query_array, $limit, $offset, $sort_by, $sort_order) {
        $sort_order = ($sort_order == 'desc') ? 'desc' : 'asc';
        $sort_by = 'id';

        $this->s_kategori_berita()
                ->limit($limit, $offset)
                ->order_by($sort_by, $sort_order);

        if ($query_array['kategori_berita'] != '') {
            $this->db->like('m_kategori_berita.kategori_berita', $query_array['kategori_berita']);
        }

        if ($query_array['active'] != '') {
            $this->db->where('m_kategori_berita.active', $query_array['active']);
        }

        $q = $this->db->get();
        //debug echo $this->db->last_query();
        $ret['results'] = $q;
        $ret['num_rows'] = $this->count_kategori_berita($query_array);
        return $ret;
    }

    function count_kategori_berita($query_array) {

        $this->s_kategori_berita();

        if ($query_array['kategori_berita'] != '') {
            $this->db->like('m_kategori_berita.kategori_berita', $query_array['kategori_berita']);
        }

        if ($query_array['active'] != '') {
            $this->db->where('m_kategori_berita.active', $query_array['active']);
        }

        return $this->db->count_all_results();
    }

    function set_default() {
        $fields = $this->db->list_fields('m_kategori_berita');
        foreach ($fields as $field) {
            $data[$field] = '';
        }
        return $data;
    }

    //AJAX Impl

    function suggestion($terms = NULL) {
        //return json
        $this->db->select('m_kategori_berita.id,m_kategori_berita.kategori_berita');
        $this->db->from('m_kategori_berita');

        if (isset($terms['kategori_berita']) && $terms['kategori_berita'] != '') {
            $this->db->like('m_kategori_berita.kategori_berita', $terms['kategori_berita']);
        }

        $this->db->limit(10);
        $query = $this->db->get();

        //echo $this->db->last_query();exit;
        if (sizeof($query->result()) > 0) {
            foreach ($query->result() as $row) {
                $options_id[$row->id] = $row->id;
                $options_kategori_berita[$row->kategori_berita] = $row->kategori_berita;
            }
            $options['id_options'] = $options_id;
            $options['kategori_berita_options'] = $options_kategori_berita;
            echo json_encode($options);
        } else {
            return $query;
        }
    }

}

