<?php

class Pengajuan_skripsi_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function s_pengajuan_skripsi() {
        return $this->db->select('t_pengajuan_skripsi.*,m_angkatan.nama_angkatan,m_tahun_akademik.tahun_ajar_mulai,m_tahun_akademik.tahun_ajar_akhir,m_semester.nama_semester,
                                  m_program_studi.nama_program_studi, m_mahasiswa.nim, m_mahasiswa.nama,t_pengajuan_skripsi_detail.judul_skripsi_diajukan')
                        ->from('t_pengajuan_skripsi')
                        ->join('m_angkatan', 'm_angkatan.id = t_pengajuan_skripsi.angkatan_id', 'left')
                        ->join('m_tahun_akademik', 'm_tahun_akademik.id = m_angkatan.tahun_akademik_id', 'left')
                        ->join('m_semester', 'm_semester.id = t_pengajuan_skripsi.semester_id', 'left')
                        ->join('m_program_studi', 'm_program_studi.id = t_pengajuan_skripsi.program_studi_id', 'left')
                        ->join('m_dosen', 'm_dosen.id = t_pengajuan_skripsi.dosen_pembimbing_1_id', 'left')
                        ->join('m_dosen as a', 'a.id = t_pengajuan_skripsi.dosen_pembimbing_1_id', 'left')                          
                        ->join('t_pengajuan_skripsi_detail', 't_pengajuan_skripsi_detail.pengajuan_skripsi_id = t_pengajuan_skripsi.id', 'left')
                        ->join('t_rencana_mata_pelajaran_pokok_detail', 't_rencana_mata_pelajaran_pokok_detail.id = t_pengajuan_skripsi.rencana_mata_pelajaran_detail_id', 'left')
                        ->join('m_mahasiswa', 'm_mahasiswa.id = t_rencana_mata_pelajaran_pokok_detail.mahasiswa_id', 'left');
    }

    function get_many($data_type = NULL, $term = array(), $limit = NULL, $offset = NULL) {
        $this->s_pengajuan_skripsi();
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

        $this->s_pengajuan_skripsi()
                ->limit($limit, $offset)
                ->order_by($sort_by, $sort_order);

        if ($query_array['nim'] != '') {
            $this->db->like('m_mahasiswa.nim', $query_array['nim']);
        }
        
        if ($query_array['nama'] != '') {
            $this->db->like('m_mahasiswa.nama', $query_array['nama']);
        }
        
        if ($query_array['active'] != '') {
            $this->db->where('t_pengajuan_skripsi.active', $query_array['active']);
        }

        $q = $this->db->get();
        //debug echo $this->db->last_query();
        $ret['results'] = $q;
        $ret['num_rows'] = $this->count_pengajuan_skripsi($query_array);
        return $ret;
    }

    function count_pengajuan_skripsi($query_array) {

        $this->s_pengajuan_skripsi();

        if ($query_array['nim'] != '') {
            $this->db->like('m_mahasiswa.nim', $query_array['nim']);
        }
        
        if ($query_array['nama'] != '') {
            $this->db->like('m_mahasiswa.nama', $query_array['nama']);
        }

        if ($query_array['active'] != '') {
            $this->db->where('t_pengajuan_skripsi.active', $query_array['active']);
        }

        return $this->db->count_all_results();
    }

    function set_default() {
        $fields = $this->db->list_fields('t_pengajuan_skripsi');
        foreach ($fields as $field) {
            $data[$field] = '';
        }
        return $data;
    }
    
    function get_angkatan(){
        $sql = "select b.angkatan_id, c.`tahun_akademik_id`, b.`nama_angkatan` 
                from `akademik_t_rencana_mata_pelajaran_pokok` a
                left join akademik_view_paket_plot_mata_kuliah b ON a.`paket_mata_kuliah_id` = b.`paket_mata_kuliah_id`
                left join akademik_m_angkatan c on b.`angkatan_id` = c.id
                left join akademik_m_tahun_akademik d on c.`tahun_akademik_id` = d.id
                where a.`active` = '1'
                group by a.`angkatan_id`";
        $query = $this->db->query($sql);
        return $query->result_array();        
    }
      
    function get_tahun_angkatan($id=NULL){
        $this->db->distinct();
        $this->db->select('m_angkatan.*,m_angkatan.tahun_akademik_id, m_tahun_akademik.tahun_ajar_mulai, m_tahun_akademik.tahun_ajar_akhir');
        $this->db->from('m_angkatan');
        $this->db->join('m_tahun_akademik','m_tahun_akademik.id = m_angkatan.tahun_akademik_id','left');
        $this->db->where('m_angkatan.tahun_akademik_id', $id);
        $this->db->where('m_angkatan.active', 1);
        $Q = $this->db->get();
        foreach ($Q->result_array() as $row) $data[] = $row;
        //echo $this->db->last_query();
        return @$data;
    }
    
    function get_semester($angkatan_id=NULL){
        $sql = "select b.`semester_id`, b.`nama_semester`
                from `akademik_t_rencana_mata_pelajaran_pokok` a
                left join akademik_view_paket_plot_mata_kuliah b ON a.`paket_mata_kuliah_id` = b.`paket_mata_kuliah_id`
                where a.`active` = '1'
                  and b.`angkatan_id` = '$angkatan_id'
                group by b.angkatan_id, b.semester_id";
        $query = $this->db->query($sql);      
        return $query->result_array();
    }
    
    function get_program_studi($angkatan_id=NULL, $semester_id=NULL){
        $sql = "select b.`program_studi_id`, b.`nama_program_studi`
                from akademik_t_rencana_mata_pelajaran_pokok a
                left join akademik_view_paket_plot_mata_kuliah b on a.`paket_mata_kuliah_id` = b.`paket_mata_kuliah_id`
                where a.`active` = '1'
                  and b.angkatan_id = '2'
                  and b.semester_id = '3'
                GROUP BY b.`angkatan_id`, b.`semester_id`, b.`program_studi_id`";
        $query = $this->db->query($sql);
        return $query->result_array();
    }
    
    function get_mahasiswa($id=NULL){
        $this->db->select('a.id, a.rencana_mata_pelajaran_detail_id, c.nama');
        $this->db->from('t_pengajuan_skripsi as a');
        $this->db->join('t_rencana_mata_pelajaran_pokok_detail as b', 'a.rencana_mata_pelajaran_detail_id = b.id', 'left');
        $this->db->join('m_mahasiswa as c', 'b.mahasiswa_id = c.id', 'left');
        $this->db->where('a.id',$id);
        $Q = $this->db->get();
        foreach ($Q->result_array() as $row) $data[] = $row;
        return @$data;
    }
    
    function get_mahasiswa_change($angkatan_id=NULL, $semester_id=NULL, $program_studi_id=NULL){
        $sql = "select a.`id`, a.`rencana_mata_pelajaran_id`, a.`mahasiswa_id`, c.`nama` 
                from `akademik_t_rencana_mata_pelajaran_pokok_detail` a
                left join `akademik_t_rencana_mata_pelajaran_pokok` b on a.`rencana_mata_pelajaran_id` = b.`id`
                left join `akademik_m_mahasiswa` c on a.`mahasiswa_id` = c.`id`
                left join akademik_view_paket_plot_mata_kuliah d on b.`paket_mata_kuliah_id` = d.`paket_mata_kuliah_id`
                WHERE a.`active` = '1'
                  and d.`angkatan_id` = '$angkatan_id'
                  and d.`semester_id` = '$semester_id'
                  and d.`program_studi_id` = '$program_studi_id'";
        $query = $this->db->query($sql);  
        return $query->result_array();
    }
    
    function dosen_info($id=NULL){
        $this->db->select('a.id, a.dosen_pembimbing_1_id, a.dosen_pembimbing_2_id, b.nama_dosen as nama_dosen_1, c.nama_dosen as nama_dosen_2');
        $this->db->from('t_pengajuan_skripsi as a');
        $this->db->join('m_dosen as b', 'a.dosen_pembimbing_1_id = b.id', 'left');
        $this->db->join('m_dosen as c', 'a.dosen_pembimbing_2_id = c.id', 'left');
        $this->db->where('a.id', $id);
        $Q = $this->db->get();
        foreach ($Q->result_array() as $row) $data[] = $row;
        return @$data;        
    }            
    
    function detail_info($id=NULL){
        $this->db->select('a.judul_skripsi_diajukan');
        $this->db->from('t_pengajuan_skripsi_detail as a');
        $this->db->join('t_pengajuan_skripsi as b', 'a.pengajuan_skripsi_id = b.id', 'left');
        $this->db->where('a.pengajuan_skripsi_id', $id);
        $Q = $this->db->get();
        foreach ($Q->result_array() as $row) $data[] = $row;
        return @$data;     
    }
    
    function pengajuan_detail_checked($id=NULL){
        $this->db->select('a.pengajua_skripsi_id');
        $this->db->from('t_pengajuan_skripsi_detail as a');
        $this->db->join('t_pengajuan_skripsi as b');
        $this->db->where('a.pengajuan_skripsi_id', $id);
        $Q = $this->db->get();
        foreach($Q->result_array() as $row) $data[] = $row['pengajuan_skripsi_id'];
        return @$data;        
    } 
}

