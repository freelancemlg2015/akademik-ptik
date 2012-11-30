<?php

class Ujian_skripsi_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function s_ujian_skripsi() {
        return $this->db->select('t_ujian_skripsi.*,m_dosen.nama_dosen as nama_ketua_penguji, a.nama_dosen as nama_anggota_satu, b.nama_dosen as nama_anggota_dua,
                                  c.nama_dosen as nama_sekretaris, m_mahasiswa.nama, m_angkatan.nama_angkatan, m_tahun_akademik.tahun_ajar_mulai, m_tahun_akademik.tahun_ajar_akhir, m_semester.nama_semester,
                                  m_program_studi.nama_program_studi,t_pengajuan_skripsi_detail.judul_skripsi_diajukan')
                        ->from('t_ujian_skripsi')                                                                                        
                        ->join('t_pengajuan_skripsi', 't_pengajuan_skripsi.id = t_ujian_skripsi.pengajuan_skripsi_id', 'left')
                        ->join('t_pengajuan_skripsi_detail', 't_pengajuan_skripsi_detail.pengajuan_skripsi_id = t_pengajuan_skripsi.id', 'left')
                        ->join('m_angkatan', 'm_angkatan.id = t_pengajuan_skripsi.angkatan_id', 'left')
                        ->join('m_tahun_akademik', 'm_tahun_akademik.id = m_angkatan.tahun_akademik_id', 'left')
                        ->join('m_semester', 'm_semester.id = t_pengajuan_skripsi.semester_id', 'left')
                        ->join('m_program_studi', 'm_program_studi.id = t_pengajuan_skripsi.program_studi_id', 'left')
                        ->join('t_rencana_mata_pelajaran_pokok_detail', 't_rencana_mata_pelajaran_pokok_detail.id = t_pengajuan_skripsi.rencana_mata_pelajaran_detail_id', 'left')
                        ->join('m_mahasiswa', 'm_mahasiswa.id = t_rencana_mata_pelajaran_pokok_detail.mahasiswa_id', 'left')
                        ->join('m_dosen', 'm_dosen.id = t_ujian_skripsi.ketua_penguji_id', 'left')
                        ->join('m_dosen as a', 'a.id = t_ujian_skripsi.anggota_penguji_1_id', 'left')
                        ->join('m_dosen as b', 'b.id = t_ujian_skripsi.anggota_penguji_2_id', 'left')
                        ->join('m_dosen as c', 'c.id = t_ujian_skripsi.sekretaris_penguji_id', 'left');
    }

    function get_many($data_type = NULL, $term = array(), $limit = NULL, $offset = NULL) {
        $this->s_ujian_skripsi();
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
                $options[$row->id] = $row->judul_skripsi_diajukan;
            }
            echo json_encode($options);
        } else {
            return $query;
        }
    }

    function search($query_array, $limit, $offset, $sort_by, $sort_order) {
        $sort_order = ($sort_order == 'desc') ? 'desc' : 'asc';
        $sort_by = 'id';

        $this->s_ujian_skripsi()
                ->limit($limit, $offset)
                ->order_by($sort_by, $sort_order);

        if ($query_array['nama'] != '') {
            $this->db->like('m_mahasiswa.nama', $query_array['nama']);
        }
        
        //if ($query_array['judul_skripsi_diajukan'] != '') {
//            $this->db->where('c.judul_skripsi_diajukan', $query_array['judul_skripsi_diajukan']);
//        }

        if ($query_array['active'] != '') {
            $this->db->where('t_ujian_skripsi.active', $query_array['active']);
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
        $ret['num_rows'] = $this->count_ujian_skripsi($query_array);
        return $ret;
    }

    function count_ujian_skripsi($query_array) {

        $this->s_ujian_skripsi();
        
        if ($query_array['nama'] != '') {
            $this->db->like('m_mahasiswa.nama', $query_array['nama']);
        }
        
        //if ($query_array['judul_skripsi_diajukan'] != '') {
//            $this->db->where('c.judul_skripsi_diajukan', $query_array['judul_skripsi_diajukan']);
//        }
        
        if ($query_array['active'] != '') {
            $this->db->where('t_ujian_skripsi.active', $query_array['active']);
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
        $fields = $this->db->list_fields('t_ujian_skripsi');
        foreach ($fields as $field) {
            $data[$field] = '';
        }
        return $data;
    }
    
    function get_angkatan(){
        $sql ="SELECT a.id, a.`angkatan_id`, b.`nama_angkatan`, c.tahun_ajar_mulai, c.tahun_ajar_akhir 
               FROM akademik_t_pengajuan_skripsi AS a
               LEFT JOIN akademik_m_angkatan AS b ON a.`angkatan_id` = b.id
               LEFT JOIN akademik_m_tahun_akademik  AS c ON b.`tahun_akademik_id` = c.id
               GROUP BY a.`angkatan_id`";
        $Q = $this->db->query($sql);
        foreach($Q->result_array() as $row) $data[] = $row;
        return @$data;
    }          
    
    function get_semester($id=NULL){
        $sql ="SELECT a.id, a.semester_id, a.angkatan_id, b.`nama_semester` FROM akademik_t_pengajuan_skripsi AS a
             LEFT JOIN akademik_m_semester AS b ON a.`semester_id` = b.`id`
             LEFT JOIN akademik_m_angkatan AS c ON a.`angkatan_id` = c.`id`
             LEFT JOIN akademik_m_tahun_akademik AS d ON c.`tahun_akademik_id` = d.`id`
             WHERE b.active = '1'           
                   AND a.angkatan_id = '$id'       
             GROUP BY a.`semester_id`";
        $Q = $this->db->query($sql);
        foreach($Q->result_array() as $row) $data[] = $row;
        return @$data;
    }
    
    function get_update_semester($id=NULL){
        $sql ="SELECT a.id, a.semester_id, a.angkatan_id, b.`nama_semester` FROM akademik_t_pengajuan_skripsi AS a
             LEFT JOIN akademik_m_semester AS b ON a.`semester_id` = b.`id`
             LEFT JOIN akademik_m_angkatan AS c ON a.`angkatan_id` = c.`id`
             LEFT JOIN akademik_m_tahun_akademik AS d ON c.`tahun_akademik_id` = d.`id`
             WHERE b.active = '1'           
                   AND a.id = '$id'
             GROUP BY a.`semester_id`";
        $Q = $this->db->query($sql); 
        foreach($Q->result_array() as $row) $data[] = $row;
        return @$data;
    }
    
    function get_program_studi($id=NULL, $semester_ids=NULL){
        $sql ="SELECT a.id, a.semester_id, a.angkatan_id, a.program_studi_id, b.nama_angkatan, d.nama_semester, e.nama_program_studi FROM akademik_t_pengajuan_skripsi AS a 
               LEFT JOIN akademik_m_angkatan AS b ON a.`angkatan_id` = b.`id`
               LEFT JOIN akademik_m_tahun_akademik AS c ON b.`tahun_akademik_id` = c.`id`
               LEFT JOIN akademik_m_semester AS d ON a.`semester_id` = d.`id`
               LEFT JOIN akademik_m_program_studi AS e ON a.`program_studi_id` = e.`id`
               WHERE e.active = '1'
                     AND a.angkatan_id = '$id' 
                     AND a.semester_id = '$semester_ids'
               GROUP BY e.nama_program_studi ORDER BY e.nama_program_studi ASC";
        $Q = $this->db->query($sql);    
        foreach($Q->result_array() as $row) $data[] = $row;
        return @$data;
    }
    
    function get_update_program_studi($id=NULL){
        $sql ="SELECT a.id, a.semester_id, a.angkatan_id, a.program_studi_id, b.nama_angkatan, d.nama_semester, e.nama_program_studi FROM akademik_t_pengajuan_skripsi AS a 
               LEFT JOIN akademik_m_angkatan AS b ON a.`angkatan_id` = b.`id`
               LEFT JOIN akademik_m_tahun_akademik AS c ON b.`tahun_akademik_id` = c.`id`
               LEFT JOIN akademik_m_semester AS d ON a.`semester_id` = d.`id`
               LEFT JOIN akademik_m_program_studi AS e ON a.`program_studi_id` = e.`id`
               WHERE e.active = '1'
                     AND a.id = '$id'            
               GROUP BY e.nama_program_studi ORDER BY e.nama_program_studi ASC";
        $Q = $this->db->query($sql);
        foreach($Q->result_array() as $row) $data[] = $row;
        return @$data;
    }
    
    function get_mahasiswa($id=NULL, $semester_ids=NULL, $program_ids=NULL){
        $sql ="SELECT `akademik_t_pengajuan_skripsi`.`id`, `akademik_t_pengajuan_skripsi`.`angkatan_id`, `akademik_t_pengajuan_skripsi`.`rencana_mata_pelajaran_detail_id`, `akademik_m_mahasiswa`.`nama`
               FROM (`akademik_t_pengajuan_skripsi`)
               LEFT JOIN `akademik_t_rencana_mata_pelajaran_pokok_detail` ON `akademik_t_rencana_mata_pelajaran_pokok_detail`.`id` = `akademik_t_pengajuan_skripsi`.`rencana_mata_pelajaran_detail_id`
               LEFT JOIN `akademik_m_mahasiswa` ON `akademik_m_mahasiswa`.`id` = `akademik_t_rencana_mata_pelajaran_pokok_detail`.`mahasiswa_id`
               LEFT JOIN `akademik_m_angkatan` ON `akademik_m_angkatan`.`id` = `akademik_m_mahasiswa`.`angkatan_id`
               LEFT JOIN `akademik_m_tahun_akademik` ON `akademik_m_tahun_akademik`.`id` = `akademik_m_angkatan`.`tahun_akademik_id`
               LEFT JOIN akademik_m_semester ON akademik_m_semester.id = akademik_t_pengajuan_skripsi.`semester_id`
               LEFT JOIN akademik_m_program_studi ON akademik_m_program_studi.id = akademik_t_pengajuan_skripsi.`program_studi_id`
               WHERE akademik_t_rencana_mata_pelajaran_pokok_detail.active = '1' 
                    AND `akademik_t_pengajuan_skripsi`.`angkatan_id` = '$id' 
                    AND akademik_t_pengajuan_skripsi.`semester_id` = '$semester_ids' 
                    AND akademik_t_pengajuan_skripsi.`program_studi_id` = '$program_ids'";
        $Q = $this->db->query($sql);                             
        foreach($Q->result_array() as $row) $data[] = $row; 
        return @$data;
    }
    
    function get_update_mahasiswa($id=NULL){
        $sql ="SELECT `akademik_t_pengajuan_skripsi`.`id`, `akademik_t_pengajuan_skripsi`.`angkatan_id`, `akademik_t_pengajuan_skripsi`.`rencana_mata_pelajaran_detail_id`, `akademik_m_mahasiswa`.`nama`
               FROM (`akademik_t_pengajuan_skripsi`)
               LEFT JOIN `akademik_t_rencana_mata_pelajaran_pokok_detail` ON `akademik_t_rencana_mata_pelajaran_pokok_detail`.`id` = `akademik_t_pengajuan_skripsi`.`rencana_mata_pelajaran_detail_id`
               LEFT JOIN `akademik_m_mahasiswa` ON `akademik_m_mahasiswa`.`id` = `akademik_t_rencana_mata_pelajaran_pokok_detail`.`mahasiswa_id`
               LEFT JOIN `akademik_m_angkatan` ON `akademik_m_angkatan`.`id` = `akademik_m_mahasiswa`.`angkatan_id`
               LEFT JOIN `akademik_m_tahun_akademik` ON `akademik_m_tahun_akademik`.`id` = `akademik_m_angkatan`.`tahun_akademik_id`
               LEFT JOIN akademik_m_semester ON akademik_m_semester.id = akademik_t_pengajuan_skripsi.`semester_id`
               LEFT JOIN akademik_m_program_studi ON akademik_m_program_studi.id = akademik_t_pengajuan_skripsi.`program_studi_id`
               WHERE akademik_t_rencana_mata_pelajaran_pokok_detail.active = '1' 
                    AND `akademik_t_pengajuan_skripsi`.`id` = '$id'";
        $Q = $this->db->query($sql);
        foreach($Q->result_array() as $row) $data[] = $row; 
        return @$data;
    }
    
    function get_pengajuan($id=NULL, $semester_ids=NULL, $program_ids=NULL, $rencana_ids=NULL){
        $sql ="SELECT a.`id`, a.`pengajuan_skripsi_id`, a.`judul_skripsi_diajukan` FROM akademik_t_pengajuan_skripsi_detail AS a
               LEFT JOIN akademik_t_pengajuan_skripsi AS b ON a.`pengajuan_skripsi_id` = b.`id`
               LEFT JOIN akademik_m_angkatan AS c ON b.`angkatan_id` = c.`id`
               LEFT JOIN akademik_m_tahun_akademik AS d ON c.`tahun_akademik_id` = d.`id`
               LEFT JOIN akademik_m_semester AS e ON b.`semester_id` = e.`id`
               LEFT JOIN akademik_m_program_studi AS f ON b.`program_studi_id` = f.`id`
               LEFT JOIN akademik_t_rencana_mata_pelajaran_pokok_detail AS g ON b.`rencana_mata_pelajaran_detail_id` = g.`id`
               LEFT JOIN akademik_m_mahasiswa AS h ON g.`mahasiswa_id` = h.`id`
               WHERE a.`active` = '1'            
                     AND b.`angkatan_id` = '$id'
                     AND b.`semester_id` = '$semester_ids'
                     AND b.`program_studi_id` = '$program_ids'    
                     AND b.`id` = '$rencana_ids'";
        $Q = $this->db->query($sql); 
        foreach($Q->result_array() as $row) $data[] = $row; 
        return @$data;
    }
    
    function get_update_pengajuan($id=NULL){
        $sql ="SELECT a.`id`, a.`pengajuan_skripsi_id`, a.`judul_skripsi_diajukan` FROM akademik_t_pengajuan_skripsi_detail AS a
               LEFT JOIN akademik_t_pengajuan_skripsi AS b ON a.`pengajuan_skripsi_id` = b.`id`
               LEFT JOIN akademik_m_angkatan AS c ON b.`angkatan_id` = c.`id`
               LEFT JOIN akademik_m_tahun_akademik AS d ON c.`tahun_akademik_id` = d.`id`
               LEFT JOIN akademik_m_semester AS e ON b.`semester_id` = e.`id`
               LEFT JOIN akademik_m_program_studi AS f ON b.`program_studi_id` = f.`id`
               LEFT JOIN akademik_t_rencana_mata_pelajaran_pokok_detail AS g ON b.`rencana_mata_pelajaran_detail_id` = g.`id`
               LEFT JOIN akademik_m_mahasiswa AS h ON g.`mahasiswa_id` = h.`id`
               WHERE a.`active` = '1'            
                     AND a.`id` = '$id'";
        $Q = $this->db->query($sql);
        foreach($Q->result_array() as $row) $data[] = $row; 
        return @$data;
    }

}

