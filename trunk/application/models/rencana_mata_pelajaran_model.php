<?php

class Rencana_mata_pelajaran_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function s_rencana_mata_pelajaran() {
        return $this->db->select('t_rencana_mata_pelajaran_pokok.*,m_angkatan.nama_angkatan, m_tahun_akademik.tahun_ajar_mulai, m_tahun_akademik.tahun_ajar_akhir,
                                  m_semester.nama_semester, m_program_studi.nama_program_studi')
                        ->from('t_rencana_mata_pelajaran_pokok')
                        ->join('t_paket_mata_kuliah', 't_paket_mata_kuliah.id = t_rencana_mata_pelajaran_pokok.paket_mata_kuliah_id', 'left')
                        ->join('m_program_studi', 't_paket_mata_kuliah.program_studi_id = m_program_studi.id', 'left')
                        ->join('t_plot_mata_kuliah', 't_plot_mata_kuliah.id = t_paket_mata_kuliah.plot_mata_kuliah_id', 'left')
                        ->join('m_angkatan', 't_plot_mata_kuliah.angkatan_id = m_angkatan.id', 'left')
                        ->join('m_tahun_akademik', 'm_angkatan.tahun_akademik_id = m_tahun_akademik.id', 'left')
                        ->join('m_semester', 't_plot_mata_kuliah.semester_id = m_semester.id', 'left');
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
    
    function get_angkatan(){
        $sql = "SELECT a.`angkatan_id`, c.`tahun_akademik_id`, a.`nama_angkatan`
                FROM akademik_view_paket_plot_mata_kuliah a
                LEFT JOIN akademik_t_paket_mata_kuliah b on a.`paket_mata_kuliah_id` = b.`id`
                LEFT JOIN akademik_m_angkatan c ON a.`angkatan_id` = c.`id`
                LEFT JOIN akademik_m_tahun_akademik d ON c.`tahun_akademik_id` = d.`id`
                WHERE b.`active` = '1'
                GROUP BY a.`angkatan_id`";
        $query = $this->db->query($sql);
        return $query->result_array();
    }
    
    function get_semester($angkatan_id=NULL){
        $sql = "SELECT a.`semester_id`, a.`nama_semester`
                FROM akademik_view_paket_plot_mata_kuliah a
                LEFT JOIN akademik_t_paket_mata_kuliah b on a.`paket_mata_kuliah_id` = b.`id`
                WHERE a.`angkatan_id` = '$angkatan_id'
                GROUP BY a.`semester_id`";
        $query = $this->db->query($sql);
        return $query->result_array();
    }
    
    function get_update_semester($id=NULL){
        $sql = "select a.`id`, c.semester_id, d.`nama_semester`  from akademik_t_rencana_mata_pelajaran_pokok a
                left join akademik_t_paket_mata_kuliah b on a.`paket_mata_kuliah_id` = b.`id`
                left join `akademik_t_plot_mata_kuliah` c on b.`plot_mata_kuliah_id` = c.`id`
                left join akademik_m_semester d on c.`semester_id` = d.`id`
                where a.`id` = '$id'";
        $query = $this->db->query($sql);
        return $query->result_array();
    }
    
    function get_program_studi($angkatan_id=NULL, $semester_id=NULL){
        $sql = "select a.`paket_mata_kuliah_id`, b.`program_studi_id`, c.`nama_program_studi`
                from `akademik_t_paket_mata_kuliah_detail` a
                left join akademik_t_paket_mata_kuliah b on a.`paket_mata_kuliah_id` = b.`id`
                left join akademik_m_program_studi c on b.`program_studi_id` = c.`id`
                left join `akademik_t_plot_mata_kuliah` d on a.`plot_mata_kuliah_id` = d.`id`
                where d.`angkatan_id` = '$angkatan_id'
                  and d.`semester_id` = '$semester_id'
                  and a.`active` = '1'
                group by d.`angkatan_id`, d.`semester_id`, b.`program_studi_id`";
        $query = $this->db->query($sql);
        return $query->result_array();
    }
    
    function get_update_program_studi($id=NULL){
        $sql = "select a.`paket_mata_kuliah_id`, b.`program_studi_id`, c.`nama_program_studi`
                from akademik_t_rencana_mata_pelajaran_pokok a
                left join `akademik_t_paket_mata_kuliah` b on a.`paket_mata_kuliah_id` = b.`id`
                left join `akademik_m_program_studi` c on b.`program_studi_id` = c.`id`
                where a.`id` = '$id'";
        $query = $this->db->query($sql);    
        return $query->result_array();
    }
    
    function get_mata_kuliah($angkatan_id=NULL, $semester_id=NULL, $program_studi_id=NULL){
        $sql = "SELECT c.`paket_mata_kuliah_id`,a.`mata_kuliah_id`, a.`nama_mata_kuliah`
                FROM akademik_view_paket_plot_mata_kuliah_detail a
                LEFT JOIN akademik_view_paket_plot_mata_kuliah b ON a.`plot_mata_kuliah_id` = b.`plot_mata_kuliah_id`
                LEFT JOIN akademik_t_paket_mata_kuliah_detail c on a.`plot_mata_kuliah_id` = c.`plot_mata_kuliah_id`
                LEFT JOIN akademik_t_paket_mata_kuliah d on c.paket_mata_kuliah_id = d.`id`
                WHERE c.active = '1'
                AND a.`angkatan_id` = '$angkatan_id'
                AND a.`semester_id` = '$semester_id'
                AND c.`paket_mata_kuliah_id` = '$program_studi_id'
                group by a.`mata_kuliah_id`";
        $query = $this->db->query($sql);      
        return $query->result_array();
    }
    
    function get_update_mata_kuliah($id=NULL){
        $sql = "select a.`paket_mata_kuliah_id`, b.`mata_kuliah_id`, c.nama_mata_kuliah 
                from akademik_t_paket_mata_kuliah_detail a
                left join akademik_t_plot_mata_kuliah_detail b on a.`plot_mata_kuliah_id` = b.`plot_mata_kuliah_id`
                left join akademik_m_mata_kuliah c on b.`mata_kuliah_id` = c.id
                where b.active = '1'
                  and a.`paket_mata_kuliah_id` = '$id'";
        $query = $this->db->query($sql);
        echo $this->db->last_query();    
        return $query->result_array();
    }
    
    function get_mahasiswa($angkatan_id=NULL){
        $sql = "select a.id, a.nim, a.`nama` 
                from akademik_m_mahasiswa a
                left join akademik_view_paket_plot_mata_kuliah b on a.`angkatan_id` = b.`angkatan_id`
                where a.`active` = '1'
                  and b.angkatan_id = '$angkatan_id'        
                group by a.nama
                order by a.nama asc";
        $query = $this->db->query($sql); 
        return $query->result_array();        
    }
    
    function get_edit_mahasiswa(){
        $sql = "select a.id, a.nim, a.`nama` 
                from akademik_m_mahasiswa a
                left join akademik_view_paket_plot_mata_kuliah b on a.`angkatan_id` = b.`angkatan_id`
                where a.`active` = '1'                      
                group by a.nama
                order by a.nama asc";
        $query = $this->db->query($sql);
        return $query->result_array();
    }                    
    
    function get_update_mahasiswa($id=null){
        $this->db->select('a.mahasiswa_id');
        $this->db->from('akademik_t_rencana_mata_pelajaran_pokok_detail as a');
        if ($id) $this->db->where('a.rencana_mata_pelajaran_id', $id);
                 $this->db->where('a.active', 1);
        $Q = $this->db->get();
        foreach ($Q->result_array() as $row) $data[] = $row['mahasiswa_id'];  
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
    
    function get_mata_kuliah_info(){
        $sql = "SELECT a.`mata_kuliah_id`, a.`nama_mata_kuliah` 
                FROM akademik_view_paket_plot_mata_kuliah_detail a
                LEFT JOIN akademik_view_paket_plot_mata_kuliah b ON a.`plot_mata_kuliah_id` = b.`plot_mata_kuliah_id` 
                WHERE a.`angkatan_id` = '$angkatan_id' AND a.`semester_id` = '$semester_id' AND a.`program_studi_id` = '$program_studi_id' 
                GROUP BY a.`angkatan_id`, a.`semester_id`, a.`program_studi_id`, a.`mata_kuliah_id`";
        $query = $this->db->query($sql);
        return $query->result_array();
    }
    
    function delete_detail($id=null){
        $this->db->delete('t_rencana_mata_pelajaran_pokok_detail', array('rencana_mata_pelajaran_id' => $id));
    }
    
    function get_matakuliah_info($id=NULL){
        $sql = "select a.`mata_kuliah_id`, b.`nama_mata_kuliah` from akademik_t_rencana_mata_pelajaran_pokok a
                left join akademik_m_mata_kuliah b on a.`mata_kuliah_id` = b.`id`
                where a.`id` = '$id'";
        $query = $this->db->query($sql);
        return $query->result_array();
    }
    
    function get_mahawasiswa_info($id=NULL){
        $sql = "select a.rencana_mata_pelajaran_id, b.`nim`, b.`nama`
                from akademik_t_rencana_mata_pelajaran_pokok_detail a
                left join akademik_m_mahasiswa b on a.`mahasiswa_id` = b.`id`
                left join akademik_t_rencana_mata_pelajaran_pokok c on a.`rencana_mata_pelajaran_id` = c.`id`
                where a.`rencana_mata_pelajaran_id` = '$id'";
        $query = $this->db->query($sql);
        return $query->result_array();
    }
}

