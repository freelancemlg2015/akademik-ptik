<?php

class Paket_matakuliah_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function s_paket_matakuliah() {
        return $this->db->select('t_paket_mata_kuliah.*,m_angkatan.nama_angkatan,m_tahun_akademik.tahun_ajar_mulai,m_tahun_akademik.tahun_ajar_akhir,
                                                        m_semester.nama_semester,m_program_studi.nama_program_studi')
                        ->from('t_paket_mata_kuliah')
                        ->join('m_angkatan', 'm_angkatan.id   = t_paket_mata_kuliah.angkatan_id', 'left')
                        ->join('m_tahun_akademik', 'm_tahun_akademik.id = m_angkatan.tahun_akademik_id', 'left')
                        ->join('t_plot_mata_kuliah', 't_plot_mata_kuliah.id = t_paket_mata_kuliah.plot_mata_kuliah_id', 'left')
                        ->join('m_semester', 'm_semester.id = t_plot_mata_kuliah.semester_id', 'left')
                        ->join('m_program_studi', 'm_program_studi.id = t_paket_mata_kuliah.program_studi_id', 'left');
    }

    function get_many($data_type = NULL, $term = array(), $limit = NULL, $offset = NULL) {
        $this->s_paket_matakuliah();
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

        $this->s_paket_matakuliah()
                ->limit($limit, $offset)
                ->order_by($sort_by, $sort_order);

        if ($query_array['nama_angkatan'] != '') {
            $this->db->like('m_angkatan.nama_angkatan', $query_array['nama_angkatan']);
        }

        if ($query_array['nama_semester'] != '') {
            $this->db->like('m_semester.nama_semester', $query_array['nama_semester']);
        }
        
        if ($query_array['active'] != '') {
            $this->db->where('t_paket_mata_kuliah.active', $query_array['active']);
        }

        /*if (isset($query_array['tgl_ujian_start']) && $query_array['tgl_ujian_start'] != 0 && isset($query_array['tgl_ujian_akhir']) && $query_array['tgl_ujian_akhir'] != 0) {
            $date = new DateTime();
            $format = 'Y-m-j';
            $tgl_start_ujian = $query_array['tgl_ujian_start'];
            $tgl_akhir_ujian = $query_array['tgl_ujian_akhir'];
            $this->db->where("(( akademik_t_ujian_skripsi.tgl_ujian >= '" . $tgl_start_ujian . "' AND akademik_t_ujian_skripsi.tgl_ujian <='" . $tgl_akhir_ujian . "'))");
        }*/

        $q = $this->db->get();
        //debug echo $this->db->last_query();
        $ret['results'] = $q;
        $ret['num_rows'] = $this->count_paket_matakuliah($query_array);
        return $ret;
    }

    function count_paket_matakuliah($query_array) {

        $this->s_paket_matakuliah();

        if ($query_array['nama_angkatan'] != '') {
            $this->db->like('m_angkatan.nama_angkatan', $query_array['nama_angkatan']);
        }
        
        if ($query_array['nama_semester'] != '') {
            $this->db->like('m_semester.nama_semester', $query_array['nama_semester']);
        }
        
        if ($query_array['active'] != '') {
            $this->db->where('t_paket_mata_kuliah.active', $query_array['active']);
        }
        
        /*if (isset($query_array['tgl_ujian_start']) && $query_array['tgl_ujian_start'] != 0 && isset($query_array['tgl_ujian_akhir']) && $query_array['tgl_ujian_akhir'] != 0) {
            $date = new DateTime();
            $format = 'Y-m-j';
            $tgl_start_ujian = $query_array['tgl_ujian_start'];
            $tgl_akhir_ujian = $query_array['tgl_ujian_akhir'];
            $this->db->where("(( akademik_t_ujian_skripsi.tgl_ujian >= '" . $tgl_start_ujian . "' AND akademik_t_ujian_skripsi.tgl_ujian <='" . $tgl_akhir_ujian . "'))");
        }*/

        return $this->db->count_all_results();
    }

    function set_default() {
        $fields = $this->db->list_fields('t_paket_mata_kuliah');
        foreach ($fields as $field) {
            $data[$field] = '';
        }
        return $data;
    }
    
    function get_angkatan(){
        $sql = "SELECT a.`angkatan_id`,
                       c.`tahun_akademik_id`,
                       a.`nama_angkatan`
                FROM akademik_view_paket_plot_mata_kuliah a
                LEFT JOIN `akademik_t_plot_mata_kuliah` b on a.`plot_mata_kuliah_id` = b.`id`
                LEFT JOIN akademik_m_angkatan c ON b.`angkatan_id` = c.`id`
                LEFT JOIN akademik_m_tahun_akademik d ON c.`tahun_akademik_id` = d.`id`
                WHERE b.`active` = '1'
                GROUP BY a.`angkatan_id`";
        $query = $this->db->query($sql);
        return $query->result_array();
    } 
    
    function get_semester($angkatan_id=NULL){  
        $sql = "SELECT CONCAT(a.`semester_id`,';', GROUP_CONCAT(a.`plot_mata_kuliah_id` ORDER BY a.`plot_mata_kuliah_id` ASC SEPARATOR '-')) AS group_id, a.`nama_semester`
                FROM akademik_view_paket_plot_mata_kuliah a
                LEFT JOIN akademik_t_plot_mata_kuliah b on a.`plot_mata_kuliah_id` = b.`id`
                WHERE b.active = '1'
                  AND a.`angkatan_id` = '$angkatan_id'
                GROUP BY a.`angkatan_id`,a.`semester_id`";
        $query = $this->db->query($sql); 
        return $query->result_array();
    }
    
    function get_update_semester($angkatan_id=NULL){  
        $sql = "SELECT CONCAT(a.`semester_id`,';', GROUP_CONCAT(a.`plot_mata_kuliah_id` ORDER BY a.`plot_mata_kuliah_id` ASC SEPARATOR '-')) AS group_id, a.`nama_semester` 
                FROM akademik_view_paket_plot_mata_kuliah a
                WHERE a.`semester_id` = '$angkatan_id' 
                GROUP BY a.`angkatan_id`, a.`semester_id`";
        $query = $this->db->query($sql);  
        return $query->result_array();
    }
    
    function get_kelompok_mata_kuliah($angkatan_id=NULL, $semester_id=NULL){
        $sql = "SELECT a.`id`, a.`kelompok_mata_kuliah_id`, c.`nama_kelompok_mata_kuliah`
                FROM akademik_t_plot_mata_kuliah a
                LEFT JOIN akademik_view_paket_plot_mata_kuliah b ON a.`id` = b.`plot_mata_kuliah_id`
                LEFT JOIN `akademik_m_kelompok_matakuliah` c ON a.`kelompok_mata_kuliah_id` = c.`id`
                WHERE a.active = '1'
                  AND b.`angkatan_id` = '$angkatan_id'
                  AND b.`semester_id` = '$semester_id'
                GROUP BY b.`angkatan_id`, b.`semester_id` , a.`kelompok_mata_kuliah_id`
                ORDER BY c.`nama_kelompok_mata_kuliah` ASC";
        $query = $this->db->query($sql);
        return $query->result_array();
    }
     
    function get_matakuliah_detil($id=null){
       $this->db->select('a.kelompok_mata_kuliah_id,b.kode_kelompok, b.nama_kelompok_mata_kuliah');
       $this->db->from('t_paket_mata_kuliah_detail as a');
       $this->db->join('m_kelompok_matakuliah as b', 'a.kelompok_mata_kuliah_id = b.id', 'left');
       if ($id) $this->db->where('a.paket_mata_kuliah_id', $id);
                 $this->db->where('a.active', 1);
        $Q = $this->db->get();
        foreach ($Q->result_array() as $row) $data[] = $row['kelompok_mata_kuliah_id'];
        return @$data;
    }
    
    function get_paket_matakuliah_detil($id=null){
        $this->db->select('a.paket_mata_kuliah_id, b.kode_kelompok, b.nama_kelompok_mata_kuliah');
        $this->db->from('t_paket_mata_kuliah_detail as a');
        $this->db->join('m_kelompok_matakuliah as b','b.id = a.kelompok_mata_kuliah_id','left');
        $this->db->where('a.paket_mata_kuliah_id', $id);
        $this->db->where('a.active',1);
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
    
    
    function get_plot_matakuliah($id=null){
        $this->db->select('t_plot_mata_kuliah.id, t_plot_mata_kuliah.semester_id, t_plot_mata_kuliah.kelompok_mata_kuliah_id, m_semester.nama_semester, m_kelompok_matakuliah.nama_kelompok_mata_kuliah');
        $this->db->from('t_plot_mata_kuliah');
        $this->db->join('m_semester','m_semester.id = t_plot_mata_kuliah.semester_id','left');
        $this->db->join('m_kelompok_matakuliah','m_kelompok_matakuliah.id = t_plot_mata_kuliah.kelompok_mata_kuliah_id','left');
        $this->db->where('t_plot_mata_kuliah.semester_id', $id);
        $this->db->where('t_plot_mata_kuliah.active', 1);
        $this->db->group_by('m_kelompok_matakuliah.nama_kelompok_mata_kuliah', 'asc');
        $this->db->order_by('m_kelompok_matakuliah.nama_kelompok_mata_kuliah', 'asc');
        $Q = $this->db->get();
        foreach ($Q->result_array() as $row) $data[] = $row;
        return @$data;
    }
     
    function delete_detail($id=null){
        $this->db->delete('t_paket_mata_kuliah_detail', array('paket_mata_kuliah_id' => $id));
    }
}

