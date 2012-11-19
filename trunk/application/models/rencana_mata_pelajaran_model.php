<?php

class Rencana_mata_pelajaran_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function s_rencana_mata_pelajaran() {
        return $this->db->select('t_rencana_mata_pelajaran_pokok.*,m_angkatan.nama_angkatan,m_tahun_akademik.tahun_ajar_mulai,m_tahun_akademik.tahun_ajar_akhir,
                                                        m_program_studi.nama_program_studi,m_semester.nama_semester,m_mata_kuliah.nama_mata_kuliah')
                        ->from('t_rencana_mata_pelajaran_pokok')
                        ->join('m_angkatan', 'm_angkatan.id   = t_rencana_mata_pelajaran_pokok.angkatan_id', 'left')
                        ->join('m_tahun_akademik', 'm_tahun_akademik.id = m_angkatan.tahun_akademik_id', 'left')
                        ->join('t_paket_mata_kuliah', 't_paket_mata_kuliah.id = t_rencana_mata_pelajaran_pokok.paket_mata_kuliah_id', 'left')
                        ->join('m_program_studi', 'm_program_studi.id = t_paket_mata_kuliah.program_studi_id', 'left')
                        ->join('t_plot_mata_kuliah', 't_plot_mata_kuliah.id = t_paket_mata_kuliah.plot_mata_kuliah_id', 'left')
                        ->join('t_plot_mata_kuliah_detail', 't_plot_mata_kuliah_detail.plot_mata_kuliah_id = t_plot_mata_kuliah.id', 'left')
                        ->join('m_mata_kuliah', 'm_mata_kuliah.id = t_plot_mata_kuliah_detail.mata_kuliah_id', 'left')
                        ->join('m_semester', 'm_semester.id = t_plot_mata_kuliah.semester_id', 'left');
    }

    function get_many($data_type = NULL, $term = array(), $limit = NULL, $offset = NULL) {
        $this->s_rencana_mata_pelajaran();
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
                $options[$row->id] = $row->nama_paket;
            }
            echo json_encode($options);
        } else {
            return $query;
        }
    }

    function search($query_array, $limit, $offset, $sort_by, $sort_order) {
        $sort_order = ($sort_order == 'desc') ? 'desc' : 'asc';
        $sort_by = 'id';

        $this->s_rencana_mata_pelajaran()
                ->limit($limit, $offset)
                ->order_by($sort_by, $sort_order);

        if ($query_array['nama_angkatan'] != '') {
            $this->db->like('m_angkatan.nama_angkatan', $query_array['nama_angkatan']);
        }

        if ($query_array['nama_semester'] != '') {
            $this->db->like('m_semester.nama_semester', $query_array['nama_semester']);
        }
        
        if ($query_array['active'] != '') {
            $this->db->where('t_rencana_mata_pelajaran_pokok.active', $query_array['active']);
        }

        if (isset($query_array['tgl_ujian_start']) && $query_array['tgl_ujian_start'] != 0 && isset($query_array['tgl_ujian_akhir']) && $query_array['tgl_ujian_akhir'] != 0) {
            $date = new DateTime();
            $format = 'Y-m-j';
            $tgl_start_ujian = $query_array['tgl_ujian_start'];
            $tgl_akhir_ujian = $query_array['tgl_ujian_akhir'];
            $this->db->where("(( akademik_t_ujian_skripsi.tgl_ujian >= '" . $tgl_start_ujian . "' AND akademik_t_ujian_skripsi.tgl_ujian <='" . $tgl_akhir_ujian . "'))");
        }

        $q = $this->db->get();
        //debug echo $this->db->last_query();
        $ret['results'] = $q;
        $ret['num_rows'] = $this->count_rencana_mata_pelajaran($query_array);
        return $ret;
    }

    function count_rencana_mata_pelajaran($query_array) {

        $this->s_rencana_mata_pelajaran();

        if ($query_array['nama_angkatan'] != '') {
            $this->db->like('m_angkatan.nama_angkatan', $query_array['nama_angkatan']);
        }
        
        if ($query_array['nama_semester'] != '') {
            $this->db->like('m_semester.nama_semester', $query_array['nama_semester']);
        }
        
        if ($query_array['active'] != '') {
            $this->db->where('t_rencana_mata_pelajaran_pokok.active', $query_array['active']);
        }
        
        if (isset($query_array['tgl_ujian_start']) && $query_array['tgl_ujian_start'] != 0 && isset($query_array['tgl_ujian_akhir']) && $query_array['tgl_ujian_akhir'] != 0) {
            $date = new DateTime();
            $format = 'Y-m-j';
            $tgl_start_ujian = $query_array['tgl_ujian_start'];
            $tgl_akhir_ujian = $query_array['tgl_ujian_akhir'];
            $this->db->where("(( akademik_t_ujian_skripsi.tgl_ujian >= '" . $tgl_start_ujian . "' AND akademik_t_ujian_skripsi.tgl_ujian <='" . $tgl_akhir_ujian . "'))");
        }

        return $this->db->count_all_results();
    }

    function set_default() {
        $fields = $this->db->list_fields('t_rencana_mata_pelajaran_pokok');
        foreach ($fields as $field) {
            $data[$field] = '';
        }
        return $data;
    }
    
    function get_rencana_pelajaran_detil($id=null){
       $this->db->select('a.mahasiswa_id');
       $this->db->from('t_rencana_mata_pelajaran_pokok_detail as a');
       if ($id) $this->db->where('a.rencana_mata_pelajaran_id', $id);
                 $this->db->where('active', 1);
        $Q = $this->db->get();
        foreach ($Q->result_array() as $row) $data[] = $row['mahasiswa_id'];
        return @$data;
    }
    
    function get_detail(){
        $this->db->select('a.id, a.nim, a.nama');
        $this->db->from('m_mahasiswa as a');
        $this->db->where('a.active', 1);     
        $Q = $this->db->get();
        foreach ($Q->result_array() as $row) $data[] = $row;
        return @$data;
    }     
    
    function get_mahasiswa_detil($id=null){
        $this->db->select('a.rencana_mata_pelajaran_id, b.nim, b.nama');
        $this->db->from('t_rencana_mata_pelajaran_pokok_detail as a');
        $this->db->join('m_mahasiswa as b','b.id = a.mahasiswa_id','left');
        $this->db->where('a.rencana_mata_pelajaran_id', $id);
        $this->db->where('a.active', 1);
        $Q = $this->db->get();
        foreach ($Q->result_array() as $row) $data[] = $row;
        return @$data;
    }
    
    function get_rencana_pelajaran_update($rencana_mata_pelajaran_id, $mahasiswa_id){
        $this->db->select('a.id');
        $this->db->from('t_rencana_mata_pelajaran_pokok_detail as a');
        $this->db->where('a.rencana_mata_pelajaran_id',$rencana_mata_pelajaran_id);
        $this->db->where('a.mahasiswa_id', $mahasiswa_id);
        $Q = $this->db->get();
        foreach ($Q->result_array() as $row) return $row['id'];
    }
    
    function get_update($id, $data){
        $this->db->where('rencana_mata_pelajaran_id', $id);
        $this->db->update('t_rencana_mata_pelajaran_pokok_detail', $data);
    }
    
    function get_kelompok(){
        $data = array();
        $this->db->select('');
        $this->db->from('t_paket_mata_kuliah');
        $this->db->join('t_plot_mata_kuliah', 't_plot_mata_kuliah.id = t_paket_mata_kuliah.plot_mata_kuliah_id', 'left');
        $this->db->join('m_semester', 'm_semester.id = t_plot_mata_kuliah.semester_id', 'left');
        $Q = $this->db->get();
        foreach ($Q->result_array() as $row) $data[] = $row;
        return $data;
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
    
    function get_plot_matakuliah($id=NULL){                                                
        $this->db->select('t_paket_mata_kuliah.plot_mata_kuliah_id,t_plot_mata_kuliah.semester_id,t_paket_mata_kuliah.program_studi_id,m_semester.nama_semester,m_program_studi.nama_program_studi');
        $this->db->from('t_paket_mata_kuliah');
        $this->db->join('t_plot_mata_kuliah', 't_paket_mata_kuliah.plot_mata_kuliah_id = t_plot_mata_kuliah.id', 'left');
        $this->db->join('m_semester', 't_plot_mata_kuliah.semester_id = m_semester.id', 'left');
        $this->db->join('m_program_studi', 't_paket_mata_kuliah.program_studi_id = m_program_studi.id', 'left');
        $this->db->where('t_plot_mata_kuliah.semester_id',$id);
        $this->db->where('t_plot_mata_kuliah.active', 1);
        $Q = $this->db->get();
        foreach ($Q->result_array() as $row) $data[] = $row;
        return @$data;
    }
    
    function get_plot_matakuliah_detil($id=NULL){                                                                                   
        $this->db->select('t_paket_mata_kuliah.plot_mata_kuliah_id,t_plot_mata_kuliah.semester_id, t_paket_mata_kuliah.program_studi_id,
                           m_semester.nama_semester, m_program_studi.nama_program_studi, m_mata_kuliah.nama_mata_kuliah');
        $this->db->from('t_paket_mata_kuliah');
        $this->db->join('t_plot_mata_kuliah_detail', 't_plot_mata_kuliah_detail.plot_mata_kuliah_id = t_paket_mata_kuliah.plot_mata_kuliah_id', 'left');
        $this->db->join('m_mata_kuliah', 'm_mata_kuliah.id = t_plot_mata_kuliah_detail.mata_kuliah_id', 'left');
        $this->db->join('t_plot_mata_kuliah', 't_plot_mata_kuliah.id = t_paket_mata_kuliah.plot_mata_kuliah_id', 'left');
        $this->db->join('m_semester', 'm_semester.id = t_plot_mata_kuliah.semester_id', 'left');
        $this->db->join('m_program_studi', 'm_program_studi.id = t_paket_mata_kuliah.program_studi_id', 'left');                
        $this->db->where('t_plot_mata_kuliah.semester_id', $id);
        $this->db->where('t_plot_mata_kuliah.active', 1);
        $this->db->group_by('m_mata_kuliah.nama_mata_kuliah');      
        $this->db->order_by('m_mata_kuliah.nama_mata_kuliah', 'asc');
        $Q = $this->db->get();
        foreach ($Q->result_array() as $row) $data[] = $row;
        return @$data;
    }    
}

