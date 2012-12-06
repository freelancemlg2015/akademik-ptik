<?php

class Plot_dosen_penanggung_jawab_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function s_plot_dosen_penanggung_jawab() {
        return $this->db->select ('t_dosen_ajar.*,m_angkatan.nama_angkatan,m_tahun_akademik.tahun_ajar_mulai,
                                                 m_tahun_akademik.tahun_ajar_akhir,m_semester.nama_semester,
                                                 m_kelompok_matakuliah.nama_kelompok_mata_kuliah')
                        ->from('t_dosen_ajar')
                        ->join('m_angkatan', 'm_angkatan.id = t_dosen_ajar.angkatan_id', 'left')                                        
                        ->join('m_tahun_akademik', 'm_tahun_akademik.id = m_angkatan.tahun_akademik_id', 'left')
                        ->join('t_paket_mata_kuliah', 't_paket_mata_kuliah.id = t_dosen_ajar.paket_mata_kuliah_id', 'left')
                        ->join('t_plot_mata_kuliah', 't_plot_mata_kuliah.id = t_paket_mata_kuliah.plot_mata_kuliah_id', 'left')
                        ->join('m_semester', 'm_semester.id = t_plot_mata_kuliah.semester_id', 'left')
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
    
    function get_angkatan(){
        $sql = "SELECT a.`angkatan_id`, b.`tahun_akademik_id`, b.`nama_angkatan` 
                FROM akademik_view_paket_plot_mata_kuliah a 
                LEFT JOIN akademik_m_angkatan b ON a.`angkatan_id` = b.`id`
                LEFT JOIN akademik_m_tahun_akademik c ON b.`tahun_akademik_id` = c.`id`
                GROUP BY a.`angkatan_id`";
        $query = $this->db->query($sql);
        return $query->result_array();
    }
    
    function get_semester($angkatan_id=NULL){
        $sql = "SELECT a.`semester_id`, a.`nama_semester` 
                FROM akademik_view_paket_plot_mata_kuliah a
                WHERE a.`angkatan_id` = '$angkatan_id'
                GROUP BY a.`semester_id`";
        $query = $this->db->query($sql);
        return $query->result_array();
    }
    
    function get_program_studi($angkatan_id=NULL, $semester_id=NULL){
        $sql = "SELECT a.`angkatan_id`, a.`semester_id`, a.`program_studi_id`, a.`paket_mata_kuliah_id`, a.`nama_program_studi` 
                FROM akademik_view_paket_plot_mata_kuliah a
                WHERE a.`angkatan_id` = '$angkatan_id' 
                  AND a.`semester_id` = '$semester_id'
                GROUP BY a.`angkatan_id`,  a.`semester_id`, a.`program_studi_id`";
        $query = $this->db->query($sql); 
        return $query->result_array();
    }
    
    function get_mata_kuliah($angkatan_id=NULL, $semester_id=NULL, $program_studi_id=NULL){
        $sql = "SELECT a.`mata_kuliah_id`, a.`nama_mata_kuliah` 
                FROM akademik_view_paket_plot_mata_kuliah_detail a
                LEFT JOIN akademik_view_paket_plot_mata_kuliah b ON a.`plot_mata_kuliah_id` = b.`plot_mata_kuliah_id` 
                WHERE a.`angkatan_id` = '$angkatan_id' AND a.`semester_id` = '$semester_id' AND a.`program_studi_id` = '$program_studi_id' 
                GROUP BY a.`angkatan_id`, a.`semester_id`, a.`program_studi_id`, a.`mata_kuliah_id`";
        $query = $this->db->query($sql);
        return $query->result_array();
    }
    
    function delete_detail($id=null){
        $this->db->delete('t_dosen_ajar_detail', array('dosen_ajar_id' => $id));
    }
    
    function get_matakuliah_detil($id){
        $this->db->select('a.plot_mata_kuliah_id, b.nama_mata_kuliah');
        $this->db->from('t_plot_mata_kuliah_detail as a');
        $this->db->join('m_mata_kuliah as b','b.id = a.mata_kuliah_id','left');
        $this->db->where('a.id', $id);
        $this->db->where('b.active', 1);
        $Q = $this->db->get();
        foreach ($Q->result_array() as $row) $data[] = $row;     
        return @$data;
    }    
    
    function get_dosen_detil($id=null){
        $this->db->select('a.dosen_ajar_id, b.no_karpeg_dosen, b.no_dosen_fakultas, b.no_dosen_dikti, b.nama_dosen');
        $this->db->from('t_dosen_ajar_detail as a');
        $this->db->join('m_dosen as b','b.id = a.dosen_id','left');
        $this->db->where('a.dosen_ajar_id', $id);
        $this->db->where('a.active', 1);
        $Q = $this->db->get();
        foreach ($Q->result_array() as $row) $data[] = $row;
        return @$data;
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

