<?php

class Plot_dosen_penanggung_jawab_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function s_plot_dosen_penanggung_jawab() {
        return $this->db->select ('t_dosen_ajar.*,m_angkatan.nama_angkatan,m_tahun_akademik.tahun_ajar_mulai,
                                                 m_tahun_akademik.tahun_ajar_akhir,m_semester.nama_semester,
                                                 m_program_studi.nama_program_studi')
                        ->from('t_dosen_ajar')
                        ->join('m_angkatan', 'm_angkatan.id = t_dosen_ajar.angkatan_id', 'left')                                        
                        ->join('m_tahun_akademik', 'm_tahun_akademik.id = m_angkatan.tahun_akademik_id', 'left')
                        ->join('t_paket_mata_kuliah', 't_paket_mata_kuliah.id = t_dosen_ajar.paket_mata_kuliah_id', 'left')
                        ->join('t_plot_mata_kuliah', 't_plot_mata_kuliah.id = t_paket_mata_kuliah.plot_mata_kuliah_id', 'left')
                        ->join('m_semester', 'm_semester.id = t_plot_mata_kuliah.semester_id', 'left')
                        ->join('m_program_studi', 'm_program_studi.id = t_paket_mata_kuliah.program_studi_id', 'left');                                 
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
        $sql = "select b.angkatan_id, b.`nama_angkatan`, c.tahun_akademik_id from `akademik_t_paket_mata_kuliah` a
                left join akademik_view_paket_plot_mata_kuliah b on a.id = b.`paket_mata_kuliah_id`
                left join akademik_m_angkatan c on b.angkatan_id = c.id
                left join akademik_m_tahun_akademik d on c.tahun_akademik_id = d.id
                where a.`active` = '1'
                group by a.`angkatan_id`";
        $query = $this->db->query($sql);
        return $query->result_array();
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
        $sql = "SELECT a.`semester_id`, a.`nama_semester` 
                FROM akademik_view_paket_plot_mata_kuliah a
                WHERE a.`paket_mata_kuliah_id` = '$id'
                GROUP BY a.`semester_id`";
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
                from `akademik_t_paket_mata_kuliah_detail` a
                left join akademik_t_paket_mata_kuliah b on a.`paket_mata_kuliah_id` = b.`id`
                left join akademik_m_program_studi c on b.`program_studi_id` = c.`id`
                left join `akademik_t_plot_mata_kuliah` d on a.`plot_mata_kuliah_id` = d.`id`
                where a.`paket_mata_kuliah_id` = '$id'
                group by d.`angkatan_id`, d.`semester_id`, b.`program_studi_id`";
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
        echo $this->db->last_query();      
        return $query->result_array();
    }
    
    function get_update_mata_kuliah($id=NULL){
        $sql = "select a.`paket_mata_kuliah_id`, b.`mata_kuliah_id`, c.nama_mata_kuliah from akademik_t_paket_mata_kuliah_detail a
                left join akademik_t_plot_mata_kuliah_detail b on a.`plot_mata_kuliah_id` = b.`plot_mata_kuliah_id`
                left join akademik_m_mata_kuliah c on b.`mata_kuliah_id` = c.id
                where b.active = '1'
                  and a.`paket_mata_kuliah_id` = '$id'";
        $query = $this->db->query($sql);    
        return $query->result_array();
    }
    
    function get_update_dosen($id=NULL){
        $sql = "select a.`dosen_ajar_id`, a.`dosen_id`, b.nama_dosen from `akademik_t_dosen_ajar_detail` a
                left join akademik_m_dosen b on a.`dosen_id` = b.`id`
                where a.`dosen_ajar_id` = '$id'";
        $query = $this->db->query($sql);
        return $query->result_array();
    }
    
    function delete_detail($id=null){
        $this->db->delete('t_dosen_ajar_detail', array('dosen_ajar_id' => $id));
    }
    
    function get_matakuliah_info($id=NULL){
        $sql = "select a.`mata_kuliah_id`, b.`nama_mata_kuliah`
                from akademik_t_dosen_ajar a
                left join `akademik_m_mata_kuliah` b on a.`mata_kuliah_id` = b.id
                where a.`id` = '$id'";
        $query = $this->db->query($sql);
        return $query->result_array();
    }    
    
    function get_dosen_info($id=null){
        $this->db->select('a.dosen_ajar_id, b.no_karpeg_dosen, b.no_dosen_fakultas, b.no_dosen_dikti, b.nama_dosen');
        $this->db->from('t_dosen_ajar_detail as a');
        $this->db->join('m_dosen as b','b.id = a.dosen_id','left');
        $this->db->where('a.dosen_ajar_id', $id);
        $this->db->where('a.active', 1);
        $Q = $this->db->get();
        foreach ($Q->result_array() as $row) $data[] = $row;
        return @$data;
    }
}

