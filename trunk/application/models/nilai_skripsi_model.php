<?php

class Nilai_skripsi_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function s_nilai_skripsi() {
        return $this->db->select('t_nilai_skripsi.*,m_dosen.nama_dosen as nama_ketua_penguji, a.nama_dosen as nama_anggota_satu, b.nama_dosen as nama_anggota_dua,
                                  c.nama_dosen as nama_sekretaris, m_mahasiswa.nama, m_mahasiswa.nim, m_angkatan.nama_angkatan, m_tahun_akademik.tahun_ajar_mulai, m_tahun_akademik.tahun_ajar_akhir, m_semester.nama_semester,
                                  m_program_studi.nama_program_studi,t_pengajuan_skripsi_detail.judul_skripsi_diajukan,t_ujian_skripsi.tgl_ujian,t_ujian_skripsi.jam_mulai, t_ujian_skripsi.jam_akhir ')
                        ->from('t_nilai_skripsi')
                        ->join('t_ujian_skripsi', 't_ujian_skripsi.id = t_nilai_skripsi.ujian_skripsi_id', 'left')                                                                                        
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
        $this->s_nilai_skripsi();
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

        $this->s_nilai_skripsi()
                ->limit($limit, $offset)
                ->order_by($sort_by, $sort_order);

        if ($query_array['nama_angkatan'] != '') {
            $this->db->like('m_angkatan.nama_angkatan', $query_array['nama_angkatan']);
        }
        
        if ($query_array['nama'] != '') {
            $this->db->like('m_mahasiswa.nama', $query_array['nama']);
        }

        if ($query_array['active'] != '') {
            $this->db->where('t_nilai_skripsi.active', $query_array['active']);
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
        $ret['num_rows'] = $this->count_nilai_skripsi($query_array);
        return $ret;
    }

    function count_nilai_skripsi($query_array) {

        $this->s_nilai_skripsi();
        
        if ($query_array['nama_angkatan'] != '') {
            $this->db->like('m_angkatan.nama_angkatan', $query_array['nama_angkatan']);
        }
        
        if ($query_array['nama'] != '') {
            $this->db->like('m_mahasiswa.nama', $query_array['nama']);
        }
        
        if ($query_array['active'] != '') {
            $this->db->where('t_nilai_skripsi.active', $query_array['active']);
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
        $fields = $this->db->list_fields('t_nilai_skripsi');
        foreach ($fields as $field) {
            $data[$field] = '';
        }
        return $data;
    }
    
    function get_angkatan(){
        $sql ="SELECT a.`id`, b.`angkatan_id`, c.`nama_angkatan`
               FROM akademik_t_ujian_skripsi a
               LEFT JOIN akademik_t_pengajuan_skripsi b on a.`pengajuan_skripsi_id` = b.`id`
               LEFT JOIN akademik_m_angkatan c on b.`angkatan_id` = c.`id`
               left join akademik_m_tahun_akademik d on c.`tahun_akademik_id` = d.`id`
               where a.active = '1'
               GROUP BY b.`angkatan_id`";
        $Q = $this->db->query($sql);
        foreach($Q->result_array() as $row) $data[] = $row;
        return @$data;
    }          
    
    function get_semester($id=NULL){
        $sql ="select a.`id`, a.`pengajuan_skripsi_id`, b.`semester_id`, c.`nama_semester`
               from akademik_t_ujian_skripsi a
               left join akademik_t_pengajuan_skripsi b on a.`pengajuan_skripsi_id` = b.id
               left join akademik_m_semester c on b.`semester_id` = c.id
               where a.active = '1' 
                 and b.angkatan_id= '$id'";
        $Q = $this->db->query($sql); 
        foreach($Q->result_array() as $row) $data[] = $row;
        return @$data;
    }
    
    function get_update_semester($id=NULL){
        $sql ="select a.`id`, a.`pengajuan_skripsi_id`, b.`semester_id`, c.`nama_semester`
               from akademik_t_ujian_skripsi a
               left join akademik_t_pengajuan_skripsi b on a.`pengajuan_skripsi_id` = b.id
               left join akademik_m_semester c on b.`semester_id` = c.id
               where a.active = '1' 
                 and b.angkatan_id= '$id'";
        $Q = $this->db->query($sql);
        foreach($Q->result_array() as $row) $data[] = $row;
        return @$data;
    }
    
    function get_program_studi($id=NULL, $semester_ids=NULL){
        $sql ="select a.`id`, a.`pengajuan_skripsi_id`, b.`program_studi_id`, c.`nama_program_studi`
               from akademik_t_ujian_skripsi a
               left join akademik_t_pengajuan_skripsi b on a.`pengajuan_skripsi_id` = b.id
               left join `akademik_m_program_studi` c on b.`program_studi_id` = c.id
               where a.active = '1'
                 and b.angkatan_id = '$id'
                 and b.semester_id = '$semester_ids'";
        $Q = $this->db->query($sql);    
        foreach($Q->result_array() as $row) $data[] = $row;
        return @$data;
    }
    
    function get_update_program_studi($id=NULL){
        $sql ="SELECT a.id, a.`pengajuan_skripsi_id`, b.`semester_id`, e.`nama_semester`, f.nama_program_studi FROM akademik_t_ujian_skripsi a
               LEFT JOIN akademik_t_pengajuan_skripsi b ON a.`pengajuan_skripsi_id` = b.`id`
               LEFT JOIN akademik_m_angkatan c ON b.`angkatan_id` = c.`id`
               LEFT JOIN akademik_m_tahun_akademik d ON c.`tahun_akademik_id` = d.`id`
               LEFT JOIN akademik_m_semester e ON b.`semester_id` = e.`id`
               LEFT JOIN akademik_m_program_studi f ON b.`program_studi_id` = f.`id`
               WHERE f.active = '1'
                 AND b.program_studi_id = '$id'            
               GROUP BY f.nama_program_studi ORDER BY f.nama_program_studi ASC";
        $Q = $this->db->query($sql);                                                                                         
        foreach($Q->result_array() as $row) $data[] = $row;
        return @$data;
    }
    
    function get_mahasiswa($id=NULL, $semester_ids=NULL, $program_ids=NULL){
        $sql ="select a.id, a.pengajuan_skripsi_id, b.`rencana_mata_pelajaran_detail_id`, c.`mahasiswa_id`, d.`nama`
               from akademik_t_ujian_skripsi a
               left join akademik_t_pengajuan_skripsi b on a.`pengajuan_skripsi_id` = b.id
               left join `akademik_t_rencana_mata_pelajaran_pokok_detail` c on b.`rencana_mata_pelajaran_detail_id` = c.`id`
               left join akademik_m_mahasiswa d on c.`mahasiswa_id` = d.`id`
               where a.`active` = '1'
                  and b.`angkatan_id` = '$id'
                  and b.`semester_id` = '$semester_ids'
                  and b.program_studi_id = '$program_ids'";
        $Q = $this->db->query($sql);                             
        foreach($Q->result_array() as $row) $data[] = $row;
        return @$data;
    }
    
    function get_update_mahasiswa($id=NULL){
        $sql ="SELECT a.id, a.`angkatan_id`, a.`semester_id`, a.`program_studi_id`, a.`rencana_mata_pelajaran_detail_id`, c.`nama` 
                FROM akademik_t_pengajuan_skripsi a 
                LEFT JOIN akademik_t_rencana_mata_pelajaran_pokok_detail b ON a.`rencana_mata_pelajaran_detail_id` = b.id
                LEFT JOIN akademik_m_mahasiswa c ON b.`mahasiswa_id` = c.`id`
                LEFT JOIN akademik_m_angkatan d ON a.`angkatan_id` = d.`id`
                LEFT JOIN akademik_m_tahun_akademik e ON d.`tahun_akademik_id` = e.`id`
                LEFT JOIN akademik_m_semester f ON a.`semester_id` = f.`id`
                LEFT JOIN akademik_m_program_studi g ON a.`program_studi_id` = g.`id`
                WHERE c.active = '1' 
                  AND a.id = '$id'";
        $Q = $this->db->query($sql);
        foreach($Q->result_array() as $row) $data[] = $row; 
        return @$data;
    }
    
    function get_pengajuan($id=NULL, $semester_ids=NULL, $program_ids=NULL, $rencana_ids=NULL){
        $sql ="select a.id, a.pengajuan_skripsi_id, b.`rencana_mata_pelajaran_detail_id`, c.`judul_skripsi_diajukan`
               from akademik_t_ujian_skripsi a
               left join akademik_t_pengajuan_skripsi b on a.`pengajuan_skripsi_id` = b.`id`
               left join akademik_t_pengajuan_skripsi_detail c on c.`pengajuan_skripsi_id` = a.`pengajuan_skripsi_id`
               where a.`active` = '1'
                  and b.angkatan_id = '$id'
                  and b.semester_id = '$semester_ids'
                  and b.`program_studi_id` = '$program_ids'
                  and a.`id` = '$rencana_ids'";
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
    
    function get_tanggal($id=NULL, $semester_ids=NULL, $program_ids=NULL, $rencana_ids=NULL){
        $sql = "select a.`id`, a.`pengajuan_skripsi_id`, a.`tgl_ujian`
                from akademik_t_ujian_skripsi a
                left join akademik_t_pengajuan_skripsi b on a.`pengajuan_skripsi_id` = b.id
                left join akademik_t_pengajuan_skripsi_detail c on a.`pengajuan_skripsi_id` = c.`pengajuan_skripsi_id`
                where a.active = '1'
                  and b.angkatan_id = '$id'
                  and b.`semester_id` = '$semester_ids'
                  and b.`program_studi_id` = '$program_ids'
                  and a.`id` = '$rencana_ids'";  
        $query = $this->db->query($sql);  
        return $query->result_array();
    }
    
    function get_update_tanggal($id=NULL){
        $sql = "select a.`id`, a.`pengajuan_skripsi_id`, a.`tgl_ujian`
                from akademik_t_ujian_skripsi a
                left join akademik_t_pengajuan_skripsi b on a.`pengajuan_skripsi_id` = b.id
                left join akademik_t_pengajuan_skripsi_detail c on a.`pengajuan_skripsi_id` = c.`pengajuan_skripsi_id`
                where a.active = '1'
                  and a.id = '$id'";  
        $query = $this->db->query($sql);  
        return $query->result_array();
    }
    
    function get_jam_mulai($id=NULL, $semester_ids=NULL, $program_ids=NULL, $rencana_ids=NULL){
        $sql = "select a.`id`, a.`pengajuan_skripsi_id`, a.`jam_mulai`
                from akademik_t_ujian_skripsi a
                left join akademik_t_pengajuan_skripsi b on a.`pengajuan_skripsi_id` = b.id
                left join akademik_t_pengajuan_skripsi_detail c on a.`pengajuan_skripsi_id` = c.`pengajuan_skripsi_id`
                where a.active = '1'
                  and b.angkatan_id = '$id=NULL'
                  and b.`semester_id` = '$semester_ids'
                  and b.`program_studi_id` = '$program_ids'
                  and b.`id` = '$rencana_ids'";  
        $query = $this->db->query($sql);
        return $query->result_array();
    }
    
    function get_update_jam_mulai($id=NULL){
        $sql = "select a.`id`, a.`pengajuan_skripsi_id`, a.`jam_mulai`
                from akademik_t_ujian_skripsi a
                left join akademik_t_pengajuan_skripsi b on a.`pengajuan_skripsi_id` = b.id
                left join akademik_t_pengajuan_skripsi_detail c on a.`pengajuan_skripsi_id` = c.`pengajuan_skripsi_id`
                where a.active = '1'
                  and a.id = '$id=NULL'";  
        $query = $this->db->query($sql);
        return $query->result_array();
    }
    
    function get_jam_akhir($id=NULL, $semester_ids=NULL, $program_ids=NULL, $rencana_ids=NULL){
        $sql = "select a.`id`, a.`pengajuan_skripsi_id`, a.`jam_akhir`
                from akademik_t_ujian_skripsi a
                left join akademik_t_pengajuan_skripsi b on a.`pengajuan_skripsi_id` = b.id
                left join akademik_t_pengajuan_skripsi_detail c on a.`pengajuan_skripsi_id` = c.`pengajuan_skripsi_id`
                where a.active = '1'
                  and b.angkatan_id = '$id'
                  and b.`semester_id` = '$semester_ids'
                  and b.`program_studi_id` = '$program_ids'
                  and b.`id` = '$rencana_ids'";  
        $query = $this->db->query($sql);
        return $query->result_array();
    }
    
    function get_update_jam_akhir($id=NULL){
        $sql = "select a.`id`, a.`pengajuan_skripsi_id`, a.`jam_akhir`
                from akademik_t_ujian_skripsi a
                left join akademik_t_pengajuan_skripsi b on a.`pengajuan_skripsi_id` = b.id
                left join akademik_t_pengajuan_skripsi_detail c on a.`pengajuan_skripsi_id` = c.`pengajuan_skripsi_id`
                where a.active = '1'
                  and a.id = '$id'";  
        $query = $this->db->query($sql);
        return $query->result_array();
    }
    
    function get_ketua_penguji($id=NULL, $semester_ids=NULL, $program_ids=NULL, $rencana_ids=NULL){
        $sql = "select a.`id`, a.`pengajuan_skripsi_id`, a.`ketua_penguji_id`, d.`nama_dosen`
                from akademik_t_ujian_skripsi a
                left join akademik_t_pengajuan_skripsi b on a.`pengajuan_skripsi_id` = b.id
                left join akademik_t_pengajuan_skripsi_detail c on a.`pengajuan_skripsi_id` = c.`pengajuan_skripsi_id`
                left join `akademik_m_dosen` d on a.`ketua_penguji_id` = d.`id`
                where a.active = '1'
                  and b.angkatan_id = '$id'
                  and b.`semester_id` = '$semester_ids'
                  and b.`program_studi_id` = '$program_ids'
                  and a.`id` = '$rencana_ids'";
        $query = $this->db->query($sql);
        return $query->result_array();    
    }
    
    function get_update_ketua_penguji($id=NULL){
        $sql = "select a.`id`, a.`pengajuan_skripsi_id`, a.`ketua_penguji_id`, d.`nama_dosen`
                from akademik_t_ujian_skripsi a
                left join akademik_t_pengajuan_skripsi b on a.`pengajuan_skripsi_id` = b.id
                left join akademik_t_pengajuan_skripsi_detail c on a.`pengajuan_skripsi_id` = c.`pengajuan_skripsi_id`
                left join `akademik_m_dosen` d on a.`ketua_penguji_id` = d.`id`
                where a.active = '1'
                  and a.id = '$id'";
        $query = $this->db->query($sql); 
        return $query->result_array();    
    }
    
    function get_anggota_penguji_stu($id=NULL, $semester_ids=NULL, $program_ids=NULL){
        $sql = "select a.`id`, a.`pengajuan_skripsi_id`, a.`anggota_penguji_1_id`, d.`nama_dosen`
                from akademik_t_ujian_skripsi a
                left join akademik_t_pengajuan_skripsi b on a.`pengajuan_skripsi_id` = b.id
                left join akademik_t_pengajuan_skripsi_detail c on a.`pengajuan_skripsi_id` = c.`pengajuan_skripsi_id`
                left join `akademik_m_dosen` d on a.`anggota_penguji_1_id` = d.`id`
                where a.active = '1'
                  and b.angkatan_id = '$id'
                  and b.`semester_id` = '$semester_ids'
                  and b.`program_studi_id` = '$program_ids'"; 
        $query = $this->db->query($sql);
        return $query->result_array();    
    }
    
    function get_update_anggota_penguji_stu($id=NULL, $semester_ids=NULL, $program_ids=NULL){
        $sql = "select a.`id`, a.`pengajuan_skripsi_id`, a.`anggota_penguji_1_id`, d.`nama_dosen`
                from akademik_t_ujian_skripsi a
                left join akademik_t_pengajuan_skripsi b on a.`pengajuan_skripsi_id` = b.id
                left join akademik_t_pengajuan_skripsi_detail c on a.`pengajuan_skripsi_id` = c.`pengajuan_skripsi_id`
                left join `akademik_m_dosen` d on a.`anggota_penguji_1_id` = d.`id`
                where a.active = '1'
                  and a.id = '$id'"; 
        $query = $this->db->query($sql);
        return $query->result_array();    
    }
    
    function get_anggota_penguji_dwa($id=NULL, $semester_ids=NULL, $program_ids=NULL){
        $sql = "select a.`id`, a.`pengajuan_skripsi_id`, a.`anggota_penguji_2_id`, d.`nama_dosen`
                from akademik_t_ujian_skripsi a
                left join akademik_t_pengajuan_skripsi b on a.`pengajuan_skripsi_id` = b.id
                left join akademik_t_pengajuan_skripsi_detail c on a.`pengajuan_skripsi_id` = c.`pengajuan_skripsi_id`
                left join `akademik_m_dosen` d on a.`anggota_penguji_2_id` = d.`id`
                where a.active = '1'
                  and b.angkatan_id = '$id'
                  and b.`semester_id` = '$semester_ids'
                  and b.`program_studi_id` = '$program_ids'";
        $query = $this->db->query($sql);
        return $query->result_array();    
    }
    
    function get_update_anggota_penguji_dwa($id=NULL){
        $sql = "select a.`id`, a.`pengajuan_skripsi_id`, a.`anggota_penguji_2_id`, d.`nama_dosen`
                from akademik_t_ujian_skripsi a
                left join akademik_t_pengajuan_skripsi b on a.`pengajuan_skripsi_id` = b.id
                left join akademik_t_pengajuan_skripsi_detail c on a.`pengajuan_skripsi_id` = c.`pengajuan_skripsi_id`
                left join `akademik_m_dosen` d on a.`anggota_penguji_2_id` = d.`id`
                where a.active = '1'
                  and a.id = '$id'";
        $query = $this->db->query($sql);
        return $query->result_array();    
    }
    
    function get_sekretaris_penguji($id=NULL, $semester_ids=NULL, $program_ids=NULL){
        $sql = "select a.`id`, a.`pengajuan_skripsi_id`, a.`sekretaris_penguji_id`, d.`nama_dosen`
                from akademik_t_ujian_skripsi a
                left join akademik_t_pengajuan_skripsi b on a.`pengajuan_skripsi_id` = b.id
                left join akademik_t_pengajuan_skripsi_detail c on a.`pengajuan_skripsi_id` = c.`pengajuan_skripsi_id`
                left join `akademik_m_dosen` d on a.`sekretaris_penguji_id` = d.`id`
                where a.active = '1'
                  and b.angkatan_id = '$id'
                  and b.`semester_id` = '$semester_ids'
                  and b.`program_studi_id` = '$program_ids'";
        $query = $this->db->query($sql);
        return $query->result_array();    
    }
    
    function get_update_sekretaris_penguji($id=NULL){
        $sql = "select a.`id`, a.`pengajuan_skripsi_id`, a.`sekretaris_penguji_id`, d.`nama_dosen`
                from akademik_t_ujian_skripsi a
                left join akademik_t_pengajuan_skripsi b on a.`pengajuan_skripsi_id` = b.id
                left join akademik_t_pengajuan_skripsi_detail c on a.`pengajuan_skripsi_id` = c.`pengajuan_skripsi_id`
                left join `akademik_m_dosen` d on a.`sekretaris_penguji_id` = d.`id`
                where a.active = '1'
                  and a.id = '$id'";
        $query = $this->db->query($sql);
        return $query->result_array();    
    }

}

