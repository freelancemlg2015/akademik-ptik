<?php

/*
 * Imam Syarifudin
 * Transaction Kurikulum : Plot Mata Kuliah
 * 5/9/2012
 */

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Pengajuan_skripsi extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->helper(array('snippets_helper'));
        $this->load->model('crud_model', 'crud');
    }

    function log_date() {
        return date($this->config->item('log_date_format'));
    }

    function index($query_id = 0, $sort_by = 'id', $sort_order = 'desc', $offset = 0) {
        $this->pengajuan_skripsi($query_id, $sort_by, $sort_order, $offset);
    }

    function pengajuan_skripsi($query_id = 0, $sort_by = 'id', $sort_order = 'desc', $offset = 0) {
        $data_type    = $this->input->post('data_type');
        $data['auth'] = $this->auth;
        // pagination
        $limit = 20;
        $this->load->library(array('form_validation', 'table', 'pagination'));
        $this->input->load_query($query_id);
        $query_array = array(
            'nim'  => $this->input->get('nim'),
            'nama'  => $this->input->get('nama'),
            'active'         => 1
        );

        $this->load->model('pengajuan_skripsi_model', 'pengajuan_skripsi');
        $results = $this->pengajuan_skripsi->search($query_array, $limit, $offset, $sort_by, $sort_order);
        //echo get_instance()->db->last_query();
        $data['results']     = $results['results'];
        $data['num_results'] = $results['num_rows'];

        // pagination
        $config = array();
        $config['base_url']    = site_url("transaction/pengajuan_skripsi/$query_id/$sort_by/$sort_order");
        $config['total_rows']  = $data['num_results'];
        $config['per_page']    = $limit;
        $config['uri_segment'] = 6;
        $config['num_links']   = 6;

        $config = array_merge($config, default_pagination_btn());
        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();
        $data['sort_by']    = $sort_by;
        $data['sort_order'] = $sort_order;

        $data['page_title'] = 'Pengajuan Skripsi';

        $data['tools'] = array(
            'transaction/pengajuan_skripsi/create' => 'New'
        );

        $this->load->view('transaction/pengajuan_skripsi', $data);
    }

    function search() {
        $query_array = array(
            'nim'  => $this->input->post('nim'),
            'nama'  => $this->input->post('nama'),
            'active' => 1
        );
        $query_id = $this->input->save_query($query_array);
        redirect("transaction/pengajuan_skripsi/view/$query_id");
    }

    function info() {
        $id = $this->uri->segment(3);
        $data['auth'] = $this->auth;
        $criteria = array(
            't_pengajuan_skripsi.id' => $id
        );
        $this->load->model('pengajuan_skripsi_model', 'pengajuan_skripsi');
        $result = $this->pengajuan_skripsi->get_many('', $criteria)->row_array();
        //[debug]echo get_instance()->db->last_query();
        $result_keys = array_keys($result);
        foreach ($result_keys as $result_key) {
            $data[$result_key] = $result[$result_key];
        }
        
        $this->load->model('pengajuan_skripsi_model');
        $data['dosen_data'] = $this->pengajuan_skripsi_model->dosen_info($id);
        
        $this->load->model('pengajuan_skripsi_model');
        $data['detail_data'] = $this->pengajuan_skripsi_model->detail_info($id);
                                                          
        $data['tools'] = array(
            'transaction/pengajuan_skripsi' => 'Back',
            'transaction/pengajuan_skripsi/' . $id . '/edit' => 'Edit',
            'transaction/pengajuan_skripsi/' . $id . '/delete' => 'Delete'
        );
        $data['page_title'] = 'Detail Pengajuan Skripsi';
        $this->load->view('transaction/pengajuan_skripsi_info', $data);
    }

    function delete() {
        $id = $this->uri->segment(3);
        $this->crud->use_table('t_pengajuan_skripsi');
        $criteria = array('id' => $id);
        $data_in = array(
            'active'      => 0,
            'modified_on' => logged_info()->on,
            'modified_by' => logged_info()->by
        );
        $this->crud->update($criteria, $data_in);
        redirect('transaction/pengajuan_skripsi');
    }

    function create() {
        $data['auth'] = $this->auth;
        $data['action_type'] = __FUNCTION__;
        $transaction_url = 'transaction/pengajuan_skripsi/';
        $id                  = $this->uri->segment(3);
        
        $this->load->library(array('form_validation', 'table', 'pagination'));         
        $this->load->helper(array('form', 'snippets'));
        $this->form_validation->set_error_delimiters('<span class="notice">', '</span>');
        if ($this->form_validation->run('pengajuan_skripsi_create') === FALSE) {
            //don't do anything
        } else {
            $this->crud->use_table('t_pengajuan_skripsi');
            $data_in = array(
                'angkatan_id'                => $this->input->post('angkatan_id'),
                'semester_id'                => $this->input->post('semester_id'),
                'program_studi_id'           => $this->input->post('program_studi_id'),
                'mahasiswa_id'               => $this->input->post('span_mahasiswa'),
                'tgl_pengajuan'              => $this->input->post('tgl_pengajuan'),
                'jam'                        => $this->input->post('jam'),
                'dosen_pembimbing_1_id'      => $this->input->post('dosen_pembimbing_1_id'),
                'dosen_pembimbing_2_id'      => $this->input->post('dosen_pembimbing_2_id'),
                'status_approval'            => $this->input->post('status_approval'),
                'keterangan'                 => $this->input->post('keterangan'),
                'created_on'                 => date($this->config->item('log_date_format')),
                'created_by'                 => logged_info()->on
            );                                              
            $created_id = $this->crud->create($data_in);
            $judul = $this->input->post('judul_skripsi_diajukan');
            $this->crud->use_table('t_pengajuan_skripsi_detail');
            $data_in = array(
                'pengajuan_skripsi_id'   => $created_id,
                'judul_skripsi_diajukan' => $judul,
                'created_on'             => date($this->config->item('log_date_format')),
                'created_by'             => logged_info()->on
            );
             $this->crud->create($data_in);
                                                         
            redirect('transaction/pengajuan_skripsi/' . $created_id . '/info');
        }
        $data['action_url'] = $transaction_url . __FUNCTION__;
        $data['page_title'] = 'Create Pengajuan Skripsi';
        $data['tools'] = array(
            'transaction/pengajuan_skripsi' => 'Back'
        );
                                               
        $this->crud->use_table('m_angkatan');
        $data['angkatan_options'] = $this->crud->retrieve()->result();      
                                                                            
        $this->crud->use_table('m_semester');
        $data['semester_options'] = $this->crud->retrieve()->result();
        
        $this->crud->use_table('m_program_studi');
        $data['program_studi_options'] = $this->crud->retrieve()->result();
        
        $this->crud->use_table('m_dosen');
        $data['dosen_options'] = $this->crud->retrieve()->result();
                     
        $data['detail_options'] = '';
        $data['thn_akademik_id_attr'] = '';
        $this->crud->use_table('m_angkatan');
        $data['m_angkatan'] = $this->crud->retrieve()->result();
        $this->load->model('paket_matakuliah_model');
        $data['m_tahun_akademik'] = $this->paket_matakuliah_model->get_tahun_angkatan();
        
        $this->crud->use_table('t_pengajuan_skripsi_detail');
        $data['pengajuan_skripsi_detail'] = $this->crud->retrieve()->result();
        
        $this->load->model('pengajuan_skripsi_model');
        $data['mahasiswa_options'] = $this->pengajuan_skripsi_model->get_mahasiswa();
        
        $data['judul_skripsi_diajukan_attr']      = '';
        $data['judul_skripsi_diajukan_satu_attr'] = '';
        $data['judul_skripsi_diajukan_dua_attr']  = '';
        $data['mahasiswa_id_attr'] = '';
        
                     
        $this->load->model('pengajuan_skripsi_model', 'pengajuan_skripsi');
        $data = array_merge($data, $this->pengajuan_skripsi->set_default()); //merge dengan arr data dengan default
        $this->load->view('transaction/pengajuan_skripsi_form', $data);
    }
                
    function edit() {
        
        $data['auth']        = $this->auth;
        $data['action_type'] = __FUNCTION__;
        $transaction_url          = 'transaction/pengajuan_skripsi/';
        $id                  = $this->uri->segment(3);
        
        $this->load->library(array('form_validation', 'table'));
        $this->load->helper(array('form', 'snippets'));
        $this->form_validation->set_error_delimiters('<span class="notice">', '</span>');
        if ($this->form_validation->run('pengajuan_skripsi_update') === FALSE) {
            //don't do anything
        } else {
            $this->crud->use_table('t_pengajuan_skripsi');
            $criteria = array(
                'id' => $id
            );
            $data_in = array(
                'angkatan_id'                => $this->input->post('angkatan_id'),
                'semester_id'                => $this->input->post('semester_id'),
                'program_studi_id'           => $this->input->post('program_studi_id'),
                'mahasiswa_id'               => $this->input->post('span_mahasiswa'),
                'tgl_pengajuan'              => $this->input->post('tgl_pengajuan'),
                'jam'                        => $this->input->post('jam'),
                'dosen_pembimbing_1_id'      => $this->input->post('dosen_pembimbing_1_id'),
                'dosen_pembimbing_2_id'      => $this->input->post('dosen_pembimbing_2_id'),
                'status_approval'            => $this->input->post('status_approval'),
                'keterangan'                 => $this->input->post('keterangan'),
                'pengajuan_skripsi_detil_id' => $this->input->post('pengajuan_skripsi_detil_id'),
                'modified_on'                => date($this->config->item('log_date_format')),
                'modified_by'                => logged_info()->on
            );
            
            $this->crud->update($criteria, $data_in);
                                                                          
            $this->crud->use_table('t_pengajuan_skripsi_detail');   
                $data_in = array(
                    'pengajuan_skripsi_id'   => $id,
                    'judul_skripsi_diajukan' => $this->input->post('judul_skripsi_diajukan'),
                    'modified_on'            => date($this->config->item('log_date_format')),
                    'modified_by'            => logged_info()->on,
                );                                                  
                $this->crud->update($criteria, $data_in);

            /*$mata_kuliah = $this->input->post('mata_kuliah_id');
            if(is_array($mata_kuliah)){
                $this->crud->use_table('t_plot_mata_kuliah_detail');
                
                $this->load->model('plot_mata_kuliah_model');
                $this->plot_mata_kuliah_model->get_update($id, array('active' => 0));
                    
                for($i=0; $i< count($mata_kuliah); $i++){
                    $this->load->model('plot_mata_kuliah_model');
                    $paket_id = $this->plot_mata_kuliah_model->get_matakuliah_update($id, $mata_kuliah[$i]); 
                    if($paket_id == 1){
                        $data_in = array(
                            'plot_mata_kuliah_id'     => $id,
                            'mata_kuliah_id'          => $mata_kuliah[$i],
                            'modified_on'             => date($this->config->item('log_date_format')),
                            'modified_by'             => logged_info()->on,
                            'active'                  => 1   
                        );
                        $this->plot_mata_kuliah_model->get_update($id, $data_in );
                    }else{
                        $data_in = array(
                            'plot_mata_kuliah_id'     => $id,
                            'mata_kuliah_id'          => $mata_kuliah[$i],
                            'modified_on'             => date($this->config->item('log_date_format')),
                            'modified_by'             => logged_info()->on,
                            'active'                  => 1   
                        );
                        $this->crud->create($data_in);                
                    }    
                }
            }*/ 
            redirect('transaction/pengajuan_skripsi/' . $id . '/info');
        }
        $data['action_url'] = $transaction_url . $id . '/' . __FUNCTION__;
        $data['page_title'] = 'Update Pengajuan Skripsi';
        $data['tools']      = array(
            'transaction/pengajuan_skripsi' => 'Back'
        );
        
        $this->crud->use_table('t_pengajuan_skripsi');
        $pengajuan_skripsi_data = $this->crud->retrieve(array('id' => $id))->row();
        
        $this->crud->use_table('m_tahun_akademik');
        $tahun_akademik_data = array();
        $criteria = array(
            'id' => $pengajuan_skripsi_data->angkatan_id
        ); 
        $this->crud->use_table('m_angkatan');
        $data['angkatan_options'] = $this->crud->retrieve()->result();      
                                                                            
        $this->crud->use_table('m_semester');
        $data['semester_options'] = $this->crud->retrieve()->result();
        
        $this->crud->use_table('m_program_studi');
        $data['program_studi_options'] = $this->crud->retrieve()->result();
        
        $this->crud->use_table('m_dosen');
        $data['dosen_options'] = $this->crud->retrieve()->result();
        
        $this->crud->use_table('t_pengajuan_skripsi_detail');
        $data['pengajuan_skripsi_detail'] = $this->crud->retrieve()->result();
        $pengajuan_skripsi = '';
        foreach($data['pengajuan_skripsi_detail'] as $row){
            $pengajuan_skripsi = $row->judul_skripsi_diajukan;            
        }
        $data['judul_skripsi_diajukan_attr'] = $pengajuan_skripsi;
         
        $data['judul_skripsi_diajukan_satu_attr'] = '';
        $data['judul_skripsi_diajukan_dua_attr'] = '';
                                                                                      
        
        $this->load->model('pengajuan_skripsi_model', 'pengajuan_skripsi');
        $data = array_merge($data, $this->pengajuan_skripsi->set_default()); //merge dengan arr data dengan default        
        $data = array_merge($data, (array) $pengajuan_skripsi_data);
        if (!(empty($id))){
            $this->crud->use_table('m_angkatan');
            $data['m_angkatan'] = $this->crud->retrieve(array('id' => $data['angkatan_id']))->row();
            $this->load->model('pengajuan_skripsi_model');
            $data['m_tahun_akademik'] = $this->pengajuan_skripsi_model->get_tahun_angkatan($data['m_angkatan']->tahun_akademik_id);
            
            $thn_akademik_id_attr = '';
            foreach ($data['m_tahun_akademik'] as $row) {
                $thn_akademik_id_attr = $row['tahun_ajar_mulai'].'-'.$row['tahun_ajar_akhir'];
            }                
            $data['thn_akademik_id_attr'] = $thn_akademik_id_attr;
            
            $this->load->model('pengajuan_skripsi_model');
            $data['mahasiswa_data'] = $this->pengajuan_skripsi_model->get_mahasiswa($id);
            $mhs_data = '';
            foreach($data['mahasiswa_data'] as $row){
                $mhs_data['id'] = $row['mahasiswa_id'];
            }
            $data['mahasiswa_id_attr'] = $mhs_data;
            
//            $this->crud->use_table('m_angkatan');
//            $data['m_angkatan'] = $this->crud->retrieve(array('id' => $data['angkatan_id']))->row();
//            $this->load->model('pengajuan_skripsi_model');
//            $data['mahasiswa_data'] = $this->pengajuan_skripsi_model->get_mahasiswa_change($data['m_angkatan']->tahun_akademik_id);
//            var_dump($data['mahasiswa_data']);
            
            
           
                                                                                                                                    
        }
        $this->load->view('transaction/pengajuan_skripsi_form', $data);
    }
      
    function getOptTahunAkademik() {
        $angkatan_id= $this->input->post('angkatan_id');
        $sql = "select distinct a.tahun_ajar_mulai, a.tahun_ajar_akhir from akademik_m_tahun_akademik a ".
                " left join akademik_m_angkatan b on b.tahun_akademik_id=a.id ".
                "where a.active ='1' and b.tahun_akademik_id='$angkatan_id'";
        $query = $this->db->query($sql);
        //echo  '<pre>'.$this->db->last_query().'</pre><br>';
        foreach($query->result_array() as $row){
            echo $row['tahun_ajar_mulai'].'-'.$row['tahun_ajar_akhir'];
        }
    }
    
    function getOptMahasiswa(){
        $this->load->model('pengajuan_skripsi_model');
        $angkatan = $this->input->post('angkatan_id');
        $data['mahasiswa'] = $this->pengajuan_skripsi_model->get_mahasiswa_change($angkatan);
        echo '<option value="" ></option>';
        foreach($data['mahasiswa'] as $row){
            echo '<option value=\''.$row['mahasiswa_id'].'\' >'.$row['nama'].'</option>';
        } 
    }
}

?>
