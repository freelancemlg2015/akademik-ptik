<?php

/*
 * Imam Syarifudin
 * Master Kurikulum : Ujian Skripsi
 * 5/9/2012
 */

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Ujian_skripsi extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->helper(array('snippets_helper'));
        $this->load->model('crud_model', 'crud');
    }

    function log_date() {
        return date($this->config->item('log_date_format'));
    }

    function index($query_id = 0, $sort_by = 'id', $sort_order = 'desc', $offset = 0) {
        $this->ujian_skripsi($query_id, $sort_by, $sort_order, $offset);
    }

    function ujian_skripsi($query_id = 0, $sort_by = 'id', $sort_order = 'desc', $offset = 0) {
        $data_type    = $this->input->post('data_type');
        $data['auth'] = $this->auth;
        // pagination
        $limit = 20;
        $this->load->library(array('form_validation', 'table', 'pagination'));
        $this->input->load_query($query_id);
        $query_array = array(
            'nama'          => $this->input->get('nama'),
            'judul_skripsi' => $this->input->get('judul_skripsi'),
            'active'        => 1
        );

        $this->load->model('ujian_skripsi_model', 'ujian_skripsi');
        $results = $this->ujian_skripsi->search($query_array, $limit, $offset, $sort_by, $sort_order);
        //echo get_instance()->db->last_query();
        $data['results']     = $results['results'];
        $data['num_results'] = $results['num_rows'];

        // pagination
        $config = array();
        $config['base_url']    = site_url("transaction/ujian_skripsi/$query_id/$sort_by/$sort_order");
        $config['total_rows']  = $data['num_results'];
        $config['per_page']    = $limit;
        $config['uri_segment'] = 6;
        $config['num_links']   = 6;

        $config = array_merge($config, default_pagination_btn());
        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();
        $data['sort_by']    = $sort_by;
        $data['sort_order'] = $sort_order;

        $data['page_title'] = 'Ujian Skripsi';

        $data['tools'] = array(
            'transaction/ujian_skripsi/create' => 'New'
        );

        $this->load->view('transaction/ujian_skripsi', $data);
    }

    function search() {
        $query_array = array(
            'nama'            => $this->input->post('nama'),
            'judul_skripsi'   => $this->input->post('judul_skripsi'),
            'active' => 1
        );
        $query_id = $this->input->save_query($query_array);
        redirect("transaction/ujian_skripsi/view/$query_id");
    }

    function info() {
        $id = $this->uri->segment(3);
        $data['auth'] = $this->auth;
        $criteria = array(
            't_ujian_skripsi.id' => $id
        );
        $this->load->model('ujian_skripsi_model', 'ujian_skripsi');
        $result = $this->ujian_skripsi->get_many('', $criteria)->row_array();
        //[debug]echo get_instance()->db->last_query();
        $result_keys = array_keys($result);
        foreach ($result_keys as $result_key) {
            $data[$result_key] = $result[$result_key];
        }

        $data['tools'] = array(
            'transaction/ujian_skripsi' => 'Back',
            'transaction/ujian_skripsi/' . $id . '/edit' => 'Edit',
            'transaction/ujian_skripsi/' . $id . '/delete' => 'Delete'
        );
        $data['page_title'] = 'Detail Ujian Skripsi';
        $this->load->view('transaction/ujian_skripsi_info', $data);
    }

    function delete() {
        $id = $this->uri->segment(3);
        $this->crud->use_table('t_ujian_skripsi');
        $criteria = array('id' => $id);
        $data_in = array(
            'active'      => 0,
            'modified_on' => logged_info()->on,
            'modified_by' => logged_info()->by
        );
        $this->crud->update($criteria, $data_in);
        redirect('transaction/ujian_skripsi');
    }

    function create() {
        $data['auth']        = $this->auth;
        $data['action_type'] = __FUNCTION__;
        $master_url          = 'transaction/ujian_skripsi/';

        $this->load->library(array('form_validation', 'table'));
        $this->load->helper(array('form', 'snippets'));
        $this->form_validation->set_error_delimiters('<span class="notice">', '</span>');
        if ($this->form_validation->run('ujian_skripsi_create') === FALSE) {
            //don't do anything
        } else {
            $this->crud->use_table('t_ujian_skripsi');
            $data_in = array(
                'pengajuan_skripsi_id' => $this->input->post('pengajuan_skripsi_id'),
                //'mahasiswa_id'         => $this->input->post('mahasiswa_id'),
                //'judul_skripsi'        => $this->input->post('judul_skripsi'),
                'tgl_ujian'            => $this->input->post('tgl_ujian'),
                'jam_mulai'            => $this->input->post('jam_mulai'),
                'jam_akhir'            => $this->input->post('jam_akhir'),
                'ketua_penguji_id'     => $this->input->post('ketua_penguji_id'),
                'anggota_penguji_1_id' => $this->input->post('anggota_penguji_1_id'),
                'anggota_penguji_2_id' => $this->input->post('anggota_penguji_2_id'),
                'sekretaris_penguji_id'=> $this->input->post('sekretaris_penguji_id'),
                'keterangan'           => $this->input->post('keterangan'),
                'created_on'           => date($this->config->item('log_date_format')),
                'created_by'           => logged_info()->on
            );
                                                    
            $created_id = $this->crud->create($data_in);
            redirect('transaction/ujian_skripsi/' . $created_id . '/info');
        }
        $data['action_url'] = $master_url . __FUNCTION__;
        $data['page_title'] = 'Create Ujian Skripsi';
        $data['tools']      = array(
            'transaction/ujian_skripsi' => 'Back'
        );
                                                  
        $this->crud->use_table('m_dosen');
        $data['dosen_options'] = $this->crud->retrieve()->result();
        
        $this->crud->use_table('t_pengajuan_skripsi');
        $data['t_pengajuan_skripsi_options'] = $this->crud->retrieve()->result();
                                                                                
        $this->load->model('ujian_skripsi_model');
        $data['m_angkatan_options'] = $this->ujian_skripsi_model->get_angkatan();
        
        $this->load->model('ujian_skripsi_model');
        $data['m_semester_options'] = $this->ujian_skripsi_model->get_semester(); 
       
        $data['pengajuan_semester'] = '';
        $data['program_data'] = '';
        $data['mahasiswa_data'] = '';
        $data['thn_akademik_id_attr'] = '';
        $data['pengajuan_skripsi_id_attr'] = '';
        $data['semester_id_attr'] = '';
        $data['program_studi_id_attr'] = '';
        $data['mahasiswa_id_attr'] = '';
         $data['judul_skripsi_diajukan'] = '';
                                                                     
        $this->load->model('ujian_skripsi_model', 'ujian_skripsi');
        $data = array_merge($data, $this->ujian_skripsi->set_default()); //merge dengan arr data dengan default
        $this->load->view('transaction/ujian_skripsi_form', $data);
    }

    function edit() {
        $data['auth']        = $this->auth;
        $data['action_type'] = __FUNCTION__;
        $master_url          = 'transaction/ujian_skripsi/';
        $id                  = $this->uri->segment(3);

        $this->load->library(array('form_validation', 'table'));
        $this->load->helper(array('form', 'snippets'));
        $this->form_validation->set_error_delimiters('<span class="notice">', '</span>');
        if ($this->form_validation->run('ujian_skripsi_update') === FALSE) {
            //don't do anything
        } else {
            $this->crud->use_table('t_ujian_skripsi');
            $criteria = array(
                'id' => $id
            );
            $data_in = array(
                'pengajuan_skripsi_id' => $this->input->post('pengajuan_skripsi_id'),
                //'mahasiswa_id'         => $this->input->post('mahasiswa_id'),
                //'judul_skripsi'        => $this->input->post('judul_skripsi'),
                'tgl_ujian'            => $this->input->post('tgl_ujian'),
                'jam_mulai'            => $this->input->post('jam_mulai'),
                'jam_akhir'            => $this->input->post('jam_akhir'),
                'ketua_penguji_id'     => $this->input->post('ketua_penguji_id'),
                'anggota_penguji_1_id' => $this->input->post('anggota_penguji_1_id'),
                'anggota_penguji_2_id' => $this->input->post('anggota_penguji_2_id'),
                'sekretaris_penguji_id'=> $this->input->post('sekretaris_penguji_id'),
                'keterangan'           => $this->input->post('keterangan'),
                'modified_on'         => date($this->config->item('log_date_format')),
                'modified_by'         => logged_info()->on
            );
            
            $this->crud->update($criteria, $data_in);
            redirect('transaction/ujian_skripsi/' . $id . '/info');
        }
        $data['action_url'] = $master_url . $id . '/' . __FUNCTION__;
        $data['page_title'] = 'Update Ujian Skripsi';
        $data['tools']      = array(
            'transaction/ujian_skripsi' => 'Back'
        );

        $this->crud->use_table('t_ujian_skripsi');
        $ujian_skripsi_data = $this->crud->retrieve(array('id' => $id))->row();
        
        $this->crud->use_table('m_dosen');
        $data['dosen_options'] = $this->crud->retrieve()->result();
        
        $this->crud->use_table('t_pengajuan_skripsi');
        $data['t_pengajuan_skripsi_options'] = $this->crud->retrieve()->result();
                                                                                
        $this->load->model('ujian_skripsi_model');
        $data['m_angkatan_options'] = $this->ujian_skripsi_model->get_angkatan();
                                                                                  
        $this->load->model('ujian_skripsi_model');
        $data['m_semester_options'] = $this->ujian_skripsi_model->get_semester();
        
        $this->load->model('ujian_skripsi_model', 'ujian_skripsi');
        $data = array_merge($data, $this->ujian_skripsi->set_default()); //merge dengan arr data dengan default
        $data = array_merge($data, (array) $ujian_skripsi_data);
        if(!(empty($id))){                                                                      
            $this->load->model('ujian_skripsi_model');
            $data['m_angkatan_options'] = $this->ujian_skripsi_model->get_angkatan();
            $pengajuan_skripsi_id = '';            
            foreach($data['m_angkatan_options'] as $row){
                $pengajuan_skripsi_id = $row['id']."-".$row['angkatan_id'];
            }
            $data['pengajuan_skripsi_id_attr'] = $pengajuan_skripsi_id;
                                              
            $thn_akademik_id_attr = '';
            foreach ($data['m_angkatan_options'] as $row) {
                $thn_akademik_id_attr = $row['tahun_ajar_mulai'].'-'.$row['tahun_ajar_akhir'];
            }                
            $data['thn_akademik_id_attr'] = $thn_akademik_id_attr;
                                                                                          
            $this->crud->use_table('t_pengajian_skripsi');
            $data['pengajuan'] = $this->crud->retrieve(array('id' => $data['pengajuan_skripsi_id']))->row();
            $this->load->model('ujian_skripsi_model');
            $data['semester'] = $this->ujian_skripsi_model->get_update_semester($data['pengajuan']->semester_id);
            $semester_data = '';
            if(!empty($data['semester'])){
                foreach($data['semester'] as $row){
                    $semester_data = $row['id'];                                    
                }    
            }
            $data['semester_id_attr'] = $semester_data;
            
            $this->crud->use_table('t_pengajian_skripsi');
            $data['pengajuan'] = $this->crud->retrieve(array('id' => $data['pengajuan_skripsi_id']))->row();
            $this->load->model('ujian_skripsi_model');
            $data['program_data'] = $this->ujian_skripsi_model->get_update_program_studi($data['pengajuan']->program_studi_id);
            $program_data_attr = '';
            if(!empty($data['program_data'])){
                foreach($data['program_data'] as $row){
                    $program_data_attr = $row['id'];    
                }    
            }
            $data['program_studi_id_attr'] = $program_data_attr;
            
            $this->crud->use_table('t_pengajian_skripsi');
            $data['pengajuan'] = $this->crud->retrieve(array('id' => $data['pengajuan_skripsi_id']))->row();
            $this->load->model('ujian_skripsi_model');
            $data['mahasiswa_data'] = $this->ujian_skripsi_model->get_update_mahasiswa($data['pengajuan']->rencana_mata_pelajaran_detail_id);
            $mahasiswa_id_data = '';  
            if(!empty($data['mahasiswa_data'])){
                foreach($data['mahasiswa_data'] as $row){
                    $mahasiswa_id_data = $row['id'];    
                }    
            } 
            $data['mahasiswa_id_attr'] = $mahasiswa_id_data;
            
            $this->crud->use_table('t_pengajian_skripsi');
            $data['pengajuan'] = $this->crud->retrieve(array('id' => $data['pengajuan_skripsi_id']))->row();
            $this->load->model('ujian_skripsi_model');
            $data['pengajuan_data'] = $this->ujian_skripsi_model->get_update_pengajuan($data['pengajuan']->id);
            $pengajuan_id_data = '';  
            if(!empty($data['pengajuan_data'])){
                foreach($data['pengajuan_data'] as $row){
                    $pengajuan_id_data = $row['judul_skripsi_diajukan'];    
                }    
            } 
            $data['judul_skripsi_diajukan'] = $pengajuan_id_data;   
        }
        $this->load->view('transaction/ujian_skripsi_form', $data);
    }

    function unique_judul_skripsi($judul_skripsi) {
        $this->crud->use_table('t_ujian_skripsi');
        $ujian_skripsi = $this->crud->retrieve(array('judul_skripsi' => $judul_skripsi))->row();
        if (sizeof($ujian_skripsi) > 0) {
            $this->form_validation->set_message(__FUNCTION__, 'judul skripsi sudah terdaftar'); //pakai function karena ini harus sama dengan nama function nya
            return FALSE;
        } else {
            return true;
        }
    }

    function suggestion() {
        $this->load->model('ujian_skripsi_model');
        $ujian_skripsi = $this->input->get('ujian_skripsi');
        $terms = array(
            'judul_skripsi' => $judul_skripsi
        );
        $this->ujian_skripsi_model->suggestion($terms);
    }
    
    function getOptTahunAkademik() {
        $angkatan_id= $this->input->post('angkatan_id');
        $sql = "SELECT a.id, b.nama_angkatan, c.tahun_ajar_mulai,c.tahun_ajar_akhir 
                FROM akademik_t_pengajuan_skripsi AS a
                LEFT JOIN akademik_m_angkatan AS b ON a.`angkatan_id` = b.`id`
                LEFT JOIN akademik_m_tahun_akademik AS c ON b.`tahun_akademik_id` = c.`id`
                WHERE a.`angkatan_id` = '$angkatan_id'
                GROUP BY a.angkatan_id";
        $query = $this->db->query($sql);
        //echo $this->db->last_query();     
        foreach($query->result_array() as $row){
            echo $row['tahun_ajar_mulai'].'-'.$row['tahun_ajar_akhir'];
        }
    }             
    
    function getOptSemester(){
        $this->load->model('ujian_skripsi_model');
        $angkatan_id = $this->input->post('angkatan_id');       
        $data['semester'] = $this->ujian_skripsi_model->get_semester($angkatan_id);
        echo '<option value="" ></option>';
        if(!empty($data['semester'])){
            foreach($data['semester'] as $row){
                echo '<option value=\''.$row['semester_id'].'\' >'.$row['nama_semester'].'</option>';
            }        
        }
    }      
    
    function getOptProgramStudi(){
        $this->load->model('ujian_skripsi_model');
        $angkatan_id = $this->input->post('angkatan_id'); 
        $semestr_id  = $this->input->post('span_semester');
        $data['program'] = $this->ujian_skripsi_model->get_program_studi($angkatan_id, $semestr_id); 
        echo '<option value="" ></option>';
        if(!empty($data['program'])){
            foreach($data['program'] as $row){
                echo '<option value=\''.$row['id'].'\' >'.$row['nama_program_studi'].'</option>';
            }    
        }
         
    }
    
    function getOptMahasiswa(){
        $this->load->model('ujian_skripsi_model');
        $angkatan_id  = $this->input->post('angkatan_id'); 
        $semestr_id   = $this->input->post('span_semester');
        $program_id   = $this->input->post('span_program_studi');
        $rencana_id   = $this->input->post('span_mahasiswa');
        $data['mahasiswa'] = $this->ujian_skripsi_model->get_mahasiswa($angkatan_id,$semestr_id,$program_id,$rencana_id); 
        echo '<option value="" ></option>';
        if(!empty($data['mahasiswa'])){
            foreach($data['mahasiswa'] as $row){
                echo '<option value=\''.$row['id'].'\' >'.$row['nama'].'</option>';
            }    
        }                             
    }    
    
    function getOptPengajuanSkripsi(){
        $this->load->model('ujian_skripsi_model');
        $angkatan_id  = $this->input->post('angkatan_id'); 
        $semestr_id   = $this->input->post('span_semester');
        $program_id   = $this->input->post('span_program_studi');
        $rencana_id   = $this->input->post('span_mahasiswa');
        $data['angkatan'] = $this->ujian_skripsi_model->get_pengajuan($angkatan_id,$semestr_id,$program_id,$rencana_id);
        if(!empty($data['angkatan'])){
            foreach($data['angkatan'] as $row){
                echo $row['judul_skripsi_diajukan'];
            }
        } 
    }

}

?>
