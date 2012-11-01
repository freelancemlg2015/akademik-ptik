<?php

class Plot_mata_kuliah_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function s_plot_mata_kuliah() {
        return $this->db->select('t_plot_mata_kuliah.*,m_angkatan.nama_angkatan,m_tahun_akademik.tahun_ajar_mulai,
                                                 m_tahun_akademik.tahun_ajar_akhir,m_semester.nama_semester,m_kelompok_matakuliah.nama_kelompok_mata_kuliah')
                        ->from('t_plot_mata_kuliah')
                        ->join('m_angkatan', 'm_angkatan.id = t_plot_mata_kuliah.angkatan_id', 'left')
                        ->join('m_tahun_akademik', 'm_tahun_akademik.id = m_angkatan.tahun_akademik_id', 'left')
                        ->join('m_semester', 'm_semester.id = t_plot_mata_kuliah.semester_id', 'left')
                        ->join('m_kelompok_matakuliah', 'm_kelompok_matakuliah.id = t_plot_mata_kuliah.kelompok_mata_kuliah_id', 'left');
    }

    function get_many($data_type = NULL, $term = array(), $limit = NULL, $offset = NULL) {
        $this->s_plot_mata_kuliah();
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

        $this->s_plot_mata_kuliah()
                ->limit($limit, $offset)
                ->order_by($sort_by, $sort_order);

        if ($query_array['nama_angkatan'] != '') {
            $this->db->like('m_angkatan.nama_angkatan', $query_array['nama_angkatan']);
        }
        
        if ($query_array['nama_semester'] != '') {
            $this->db->like('m_semester.nama_semester', $query_array['nama_semester']);
        }
        
        if ($query_array['active'] != '') {
            $this->db->where('t_plot_mata_kuliah.active', $query_array['active']);
        }

        $q = $this->db->get();
        //debug echo $this->db->last_query();
        $ret['results'] = $q;
        $ret['num_rows'] = $this->count_plot_mata_kuliah($query_array);
        return $ret;
    }

    function count_plot_mata_kuliah($query_array) {

        $this->s_plot_mata_kuliah();

        if ($query_array['nama_angkatan'] != '') {
            $this->db->like('m_angkatan.nama_angkatan', $query_array['nama_angkatan']);
        }
        
        if ($query_array['nama_semester'] != '') {
            $this->db->like('m_semester.nama_semester', $query_array['nama_semester']);
        }

        if ($query_array['active'] != '') {
            $this->db->where('t_plot_mata_kuliah.active', $query_array['active']);
        }

        return $this->db->count_all_results();
    }

    function set_default() {
        $fields = $this->db->list_fields('t_plot_mata_kuliah');
        foreach ($fields as $field) {
            $data[$field] = '';
        }
        return $data;
    }
         
    function get_matakuliah_detil($id=null){
        $this->db->select('a.mata_kuliah_id');
        $this->db->from('t_plot_mata_kuliah_detil as a');
        if ($id) $this->db->where('a.plot_mata_kuliah_id', $id);
                 $this->db->where('a.active', 1);
        $Q = $this->db->get();
        foreach ($Q->result_array() as $row) $data[] = $row;
        return @$data;
    }
         
    function get_matakuliah($id=null){
        $this->db->select('a.mata_kuliah_id, b.kode_mata_kuliah, b.nama_mata_kuliah');
        $this->db->from('t_plot_mata_kuliah_detil as a');
        $this->db->join('m_mata_kuliah as b','b.id = a.mata_kuliah_id','left');
        if ($id) $this->db->where('a.plot_mata_kuliah_id', $id);
                 $this->db->where('a.active', 1);
        $Q = $this->db->get();
        foreach ($Q->result_array() as $row) $data[] = $row;
        return @$data;
    }
    
//    function get_update($id, $data){
//        $this->db->where('detil_id', $id);
//        $this->db->update('t_plot_mata_kuliah_detil', $data);
//    }
    
    function get_matakuliah_update($plot_mata_kuliah_id, $mata_kuliah_id){
        $this->db->select('a.id');
        $this->db->from('t_plot_mata_kuliah_detil as a');
        $this->db->where('a.plot_mata_kuliah_id',$plot_mata_kuliah_id);
        $this->db->where('a.mata_kuliah_id', $mata_kuliah_id);
        $Q = $this->db->get();
        foreach ($Q->result_array() as $row) return $row['id'];
    }
    
    function get_update($id, $data){
        $this->db->where('plot_mata_kuliah_id', $id);
        $this->db->update('t_plot_mata_kuliah_detil', $data);
    }
    
    function get_tahun_angkatan($id=NULL){
        $this->db->select('m_angkatan.*,m_angkatan.tahun_akademik_id, m_tahun_akademik.tahun_ajar_mulai, m_tahun_akademik.tahun_ajar_akhir');
        $this->db->from('m_angkatan');
        $this->db->join('m_tahun_akademik','m_tahun_akademik.id = m_angkatan.tahun_akademik_id','left');
        if ($id) $this->db->where('m_angkatan.tahun_akademik_id', $id);
                 $this->db->where('m_angkatan.active', 1);
        $Q = $this->db->get();
        foreach ($Q->result_array() as $row) $data[] = $row;
        return @$data;
    }
    
}

