<?php

class Plot_dosen_penanggung_jawab_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function s_plot_dosen_penanggung_jawab() {
        return $this->db->select('t_dosen_ajar.*,m_angkatan.nama_angkatan,m_tahun_akademik.tahun_ajar_mulai,
                                                 m_tahun_akademik.tahun_ajar_akhir,m_semester.nama_semester,m_mata_kuliah.nama_mata_kuliah,m_kelompok_matakuliah.nama_kelompok_mata_kuliah')
                        ->from('t_dosen_ajar')
                        ->join('m_angkatan', 'm_angkatan.id = t_dosen_ajar.angkatan_id', 'left')
                        ->join('m_tahun_akademik', 'm_tahun_akademik.id = t_dosen_ajar.tahun_akademik_id', 'left')
                        ->join('m_semester', 'm_semester.id = t_dosen_ajar.semester_id', 'left')
                        ->join('m_mata_kuliah', 'm_mata_kuliah.id = t_dosen_ajar.mata_kuliah_id', 'left')
                        ->join('t_plot_mata_kuliah', 't_plot_mata_kuliah.id = t_dosen_ajar.plot_mata_kuliah_id', 'left')
                        ->join('m_kelompok_matakuliah', 'm_kelompok_matakuliah.id = t_plot_mata_kuliah.kelompok_mata_kuliah_id', 'left');
    }

    function get_many($data_type = NULL, $term = array(), $limit = NULL, $offset = NULL) {
        $this->s_plot_dosen_penanggung_jawab();
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

        $this->s_plot_dosen_penanggung_jawab()
                ->limit($limit, $offset)
                ->order_by($sort_by, $sort_order);

        if ($query_array['nama_angkatan'] != '') {
            $this->db->like('m_angkatan.nama_angkatan', $query_array['nama_angkatan']);
        }

        if ($query_array['nama_semester'] != '') {
            $this->db->where('m_semester.nama_semester', $query_array['nama_semester']);
        }

        if ($query_array['active'] != '') {
            $this->db->where('t_dosen_ajar.active', $query_array['active']);
        }

        $q = $this->db->get();
        //debug echo $this->db->last_query();
        $ret['results'] = $q;
        $ret['num_rows'] = $this->count_plot_dosen_penanggung_jawab($query_array);
        return $ret;
    }

    function count_plot_dosen_penanggung_jawab($query_array) {

        $this->s_plot_dosen_penanggung_jawab();

        if ($query_array['nama_angkatan'] != '') {
            $this->db->like('m_angkatan.nama_angkatan', $query_array['nama_angkatan']);
        }

        if ($query_array['nama_semester'] != '') {
            $this->db->where('m_semester.nama_semester', $query_array['nama_semester']);
        }
        
        if ($query_array['active'] != '') {
            $this->db->where('t_dosen_ajar.active', $query_array['active']);
        }

        return $this->db->count_all_results();
    }

    function set_default() {
        $fields = $this->db->list_fields('t_dosen_ajar');
        foreach ($fields as $field) {
            $data[$field] = '';
        }
        return $data;
    }
    
    function get_kelompok(){
        $data = array();
        $this->db->select('a.id, b.nama_kelompok_mata_kuliah');
        $this->db->from('t_plot_mata_kuliah as a');
        $this->db->join('m_kelompok_matakuliah as b','a.kelompok_mata_kuliah_id = b.id','left');
        $this->db->order_by('b.nama_kelompok_mata_kuliah', 'asc');
        $Q = $this->db->get();
        foreach ($Q->result_array() as $row) $data[] = $row;
        return $data;
    }
    
    function get_dosen($id=null){
        $this->db->select('a.dosen_id, b.nama_dosen');
        $this->db->from('t_dosen_ajar_detil as a');
        $this->db->join('m_dosen as b', 'a.dosen_id = b.id', 'left');
        if ($id) $this->db->where('a.dosen_ajar_id', $id);
                 $this->db->where('a.active', 1);     
        $Q = $this->db->get();
        foreach ($Q->result_array() as $row) $data[] = $row;
        return @$data;
    }
    
    function get_dosen_update($dosen_ajar_id, $dosen_id){
        $this->db->select('a.id');
        $this->db->from('t_dosen_ajar_detil as a');
        $this->db->where('a.dosen_ajar_id',$dosen_ajar_id);
        $this->db->where('a.dosen_id', $dosen_id);
        $Q = $this->db->get();
        foreach ($Q->result_array() as $row) return $row['id'];
    }
    
    function get_update($id, $data){
        $this->db->where('dosen_ajar_id', $id);
        $this->db->update('t_dosen_ajar_detil', $data);
    }
}

