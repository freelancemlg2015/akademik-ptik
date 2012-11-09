<?php

/*
 * Imam Syarifudin
 * Transaction Jadwal Perkuliahan : Plot Dosen Ajar
 * 5/9/2012
 */

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Plot_dosen_penanggung_jawab extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->helper(array('snippets_helper'));
        $this->load->model('crud_model', 'crud');
    }

    function log_date() {
        return date($this->config->item('log_date_format'));
    }

    function index($query_id = 0, $sort_by = 'id', $sort_order = 'desc', $offset = 0) {
        $this->plot_dosen_penanggung_jawab($query_id, $sort_by, $sort_order, $offset);
    }

    function plot_dosen_penanggung_jawab($query_id = 0, $sort_by = 'id', $sort_order = 'desc', $offset = 0) {
        $data_type    = $this->input->post('data_type');
        $data['auth'] = $this->auth;
        // pagination
        $limit = 20;
        $this->load->library(array('form_validation', 'table', 'pagination'));
        $this->input->load_query($query_id);
        $query_array = array(
            'nama_angkatan'  => $this->input->get('nama_angkatan'),
            'nama_semester'     => $this->input->get('nama_semester'),
            'active'         => 1
        );

        $this->load->model('plot_dosen_penanggung_jawab_model', 'plot_dosen_penanggung_jawab');
        $results = $this->plot_dosen_penanggung_jawab->search($query_array, $limit, $offset, $sort_by, $sort_order);
        //echo get_instance()->db->last_query();
        $data['results']     = $results['results'];
        $data['num_results'] = $results['num_rows'];

        // pagination
        $config = array();
        $config['base_url']    = site_url("transaction/plot_dosen_penanggung_jawab/$query_id/$sort_by/$sort_order");
        $config['total_rows']  = $data['num_results'];
        $config['per_page']    = $limit;
        $config['uri_segment'] = 6;
        $config['num_links']   = 6;

        $config = array_merge($config, default_pagination_btn());
        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();
        $data['sort_by']    = $sort_by;
        $data['sort_order'] = $sort_order;

        $data['page_title'] = 'Plot Dosen Penanggung Jawab';

        $data['tools'] = array(
            'transaction/plot_dosen_penanggung_jawab/create' => 'New'
        );

        $this->load->view('transaction/plot_dosen_penanggung_jawab', $data);
    }

    function search() {
        $query_array = array(
            'nama_angkatan'  => $this->input->post('nama_angkatan'),
            'nama_semester'     => $this->input->post('nama_semester'),
            'active' => 1
        );
        $query_id = $this->input->save_query($query_array);
        redirect("transaction/plot_dosen_penanggung_jawab/view/$query_id");
    }

    function info() {
        $id = $this->uri->segment(3);
        $data['auth'] = $this->auth;
        $criteria = array(
            't_dosen_ajar.id' => $id
        );
        $this->load->model('plot_dosen_penanggung_jawab_model', 'plot_dosen_penanggung_jawab');
        $result = $this->plot_dosen_penanggung_jawab->get_many('', $criteria)->row_array();
        //[debug]echo get_instance()->db->last_query();
        $result_keys = array_keys($result);
        foreach ($result_keys as $result_key) {
            $data[$result_key] = $result[$result_key];
        }
        
        $this->load->model('plot_dosen_penanggung_jawab_model');
        $data['plot_detil_options'] = $this->plot_dosen_penanggung_jawab_model->get_matakuliah_detil($id);
        
        $this->load->model('plot_dosen_penanggung_jawab_model');
        $data['dosen_detil_options'] = $this->plot_dosen_penanggung_jawab_model->get_dosen_detil($id);
        
        $data['tools'] = array(
            'transaction/plot_dosen_penanggung_jawab' => 'Back',
            'transaction/plot_dosen_penanggung_jawab/' . $id . '/edit' => 'Edit',
            'transaction/plot_dosen_penanggung_jawab/' . $id . '/delete' => 'Delete'
        );
        $data['page_title'] = 'Detail Plot Dosen Penanggung Jawab';
        $this->load->view('transaction/plot_dosen_penanggung_jawab_info', $data);
    }

    function delete() {
        $id = $this->uri->segment(3);
        $this->crud->use_table('t_dosen_ajar');
        $criteria = array('id' => $id);
        $data_in = array(
            'active'      => 0,
            'modified_on' => logged_info()->on,
            'modified_by' => logged_info()->by
        );
        $this->crud->update($criteria, $data_in);
        redirect('transaction/plot_dosen_penanggung_jawab');
    }
    
    function create() {
        $data['auth'] = $this->auth;
        $data['action_type'] = __FUNCTION__;
        $transaction_url = 'transaction/plot_dosen_penanggung_jawab/';

        $this->load->library(array('form_validation', 'table'));
        $this->load->helper(array('form', 'snippets'));
        $this->form_validation->set_error_delimiters('<span class="notice">', '</span>');
        if ($this->form_validation->run('plot_dosen_penanggung_jawab_create') === FALSE) {
            //don't do anything
        } else {
            $this->crud->use_table('t_dosen_ajar');
            $data_in = array(
                'angkatan_id'        => $this->input->post('angkatan_id'),
                'tahun_akademik_id'  => $this->input->post('tahun_akademik_id'),
                'semester_id'        => $this->input->post('semester_id'),
                'mata_kuliah_id'     => $this->input->post('mata_kuliah_id'),
                'paket_mata_kuliah_id'=> $this->input->post('paket_mata_kuliah_id'),
                //'dosen_id'           => $this->input->post('dosen_id'),
                'created_on'              => date($this->config->item('log_date_format')),
                'created_by'              => logged_info()->on
            ); 
            
            $created_id = $this->crud->create($data_in);
            $dosen = $this->input->post('dosen_id');
            //print_r($_POST);
            if($created_id && is_array($dosen)){
                $this->crud->use_table('t_dosen_ajar_detail');
                for($i=0; $i< count($dosen); $i++){
                    $data_in = array(
                        'dosen_ajar_id' => $created_id,
                        'dosen_id' => $dosen[$i]
                    );
                    //var_dump($data_in);exit();
                    $this->crud->create($data_in);
                }
            }
            redirect('transaction/plot_dosen_penanggung_jawab/' . $created_id . '/info');
        }
        
        $data['action_url'] = $transaction_url . __FUNCTION__;
        $data['page_title'] = 'Create Plot Dosen Penanggung Jawab';
        $data['tools'] = array(
            'transaction/plot_dosen_penanggung_jawab' => 'Back'
        );
        
        $this->crud->use_table('m_angkatan');
        $data['angkatan_options'] = $this->crud->retrieve()->result();

        $this->load->model('plot_dosen_penanggung_jawab_model');
        $data['plot_mata_kuliah_options'] = $this->plot_dosen_penanggung_jawab_model->get_kelompok();
        
        $this->crud->use_table('m_kelompok_matakuliah');
        $data['kelompok_matakuliah_options'] = $this->crud->retrieve()->result();

        $this->crud->use_table('m_dosen');
        $data['dosen_options'] = $this->crud->retrieve()->result();
                        
        $this->crud->use_table('t_dosen_ajar_detail');
        $data['dosen_ajar_detil_options'] = $this->crud->retrieve()->result();
        
        $data['dosen_options_edit'] = '';
        $data['thn_akademik_id_attr'] = '';
        
        $this->load->model('plot_dosen_penanggung_jawab_model', 'plot_dosen_penanggung_jawab');
        $data = array_merge($data, $this->plot_dosen_penanggung_jawab->set_default()); //merge dengan arr data dengan default
        
        $this->load->view('transaction/plot_dosen_penanggung_jawab_form', $data);
    }

//1. Model
//2. Controller
//3. View
//4. Form Validation
//5. Routes
//6. Menus

    function edit() {
        $data['auth']        = $this->auth;
        $data['action_type'] = __FUNCTION__;
        $transaction_url          = 'transaction/plot_dosen_penanggung_jawab/';
        $id                  = $this->uri->segment(3);

        $this->load->library(array('form_validation', 'table'));
        $this->load->helper(array('form', 'snippets'));
        $this->form_validation->set_error_delimiters('<span class="notice">', '</span>');
        if ($this->form_validation->run('plot_dosen_penanggung_jawab_update') === FALSE) {
            //don't do anything
        } else {
            $this->crud->use_table('t_dosen_ajar');
            $criteria = array(
                'id' => $id
            );
            $data_in = array(
                'angkatan_id'        => $this->input->post('angkatan_id'),
                'tahun_akademik_id'  => $this->input->post('tahun_akademik_id'),
                'semester_id'        => $this->input->post('semester_id'),
                'mata_kuliah_id'     => $this->input->post('mata_kuliah_id'),
                'paket_mata_kuliah_id'=> $this->input->post('paket_mata_kuliah_id'),
                //'dosen_id'           => $this->input->post('dosen_id'),
                'modified_on'        => date($this->config->item('log_date_format')),
                'modified_by'        => logged_info()->on
            );
            
            //$this->crud->update($criteria, $data_in);
            $this->crud->update($criteria, $data_in);
            
            $dosen = $this->input->post('dosen_id');
            if(is_array($dosen)){
                $this->crud->use_table('t_dosen_ajar_detail');
                
                $this->load->model('plot_dosen_penanggung_jawab_model');
                $this->plot_dosen_penanggung_jawab_model->get_update($id, array('active' => 0));
                
                for($i=0; $i< count($dosen); $i++){
                    $this->load->model('plot_dosen_penanggung_jawab_model');
                    $paket_id = $this->plot_dosen_penanggung_jawab_model->get_dosen_update($id, $dosen[$i]); 
                    if($paket_id == 1){
                        $data_in = array(
                            'dosen_ajar_id' => $id,
                            'dosen_id'      => $dosen[$i],
                            'modified_on'   => date($this->config->item('log_date_format')),
                            'modified_by'   => logged_info()->on,
                            'active'        => 1  
                        );
                        $this->plot_dosen_penanggung_jawab_model->get_update($id, $data_in );
                    }else{
                        $data_in = array(
                            'dosen_ajar_id' => $id,
                            'dosen_id'      => $dosen[$i],
                            'modified_on'   => date($this->config->item('log_date_format')),
                            'modified_by'   => logged_info()->on,
                            'active'        => 1   
                        );
                        $this->crud->create($data_in);                
                    }    
                }
            }
            redirect('transaction/plot_dosen_penanggung_jawab/' . $id . '/info');
        }
        $data['action_url'] = $transaction_url . $id . '/' . __FUNCTION__;
        $data['page_title'] = 'Update Plot Dosen Ajar';
        $data['tools']      = array(
            'transaction/plot_dosen_penanggung_jawab' => 'Back'
        );
        
        $this->crud->use_table('t_dosen_ajar');
        $plot_dosen_penanggung_jawab_data = $this->crud->retrieve(array('id' => $id))->row();
        
        $this->crud->use_table('m_angkatan');
        $data['angkatan_options'] = $this->crud->retrieve()->result();

        $this->load->model('plot_dosen_penanggung_jawab_model');
        $data['plot_mata_kuliah_options'] = $this->plot_dosen_penanggung_jawab_model->get_kelompok();
        
        $this->crud->use_table('m_kelompok_matakuliah');
        $data['kelompok_matakuliah_options'] = $this->crud->retrieve()->result();

        $this->crud->use_table('m_dosen');
        $data['dosen_options'] = $this->crud->retrieve()->result();
        
        $this->crud->use_table('t_dosen_ajar_detail');
        $data['dosen_ajar_detil_options'] = $this->crud->retrieve()->result();
        
        $this->load->model('plot_dosen_penanggung_jawab_model');
        $data['dosen_options_edit'] = $this->plot_dosen_penanggung_jawab_model->get_dosen($id);
        
        $this->load->model('plot_dosen_penanggung_jawab_model', 'plot_dosen_penanggung_jawab');
        $data = array_merge($data, $this->plot_dosen_penanggung_jawab->set_default()); //merge dengan arr data dengan default
        $data = array_merge($data, (array) $plot_dosen_penanggung_jawab_data);
        if (!(empty($id))){
            $this->crud->use_table('m_angkatan');
            $data['m_angkatan'] = $this->crud->retrieve(array('id' => $data['angkatan_id']))->row();
            $this->load->model('plot_dosen_penanggung_jawab_model');
            $data['m_tahun_akademik'] = $this->plot_dosen_penanggung_jawab_model->get_tahun_angkatan($data['m_angkatan']->tahun_akademik_id);
            
            $thn_akademik_id_attr = '';
            foreach ($data['m_tahun_akademik'] as $row) {
                $thn_akademik_id_attr = $row['tahun_ajar_mulai'].'-'.$row['tahun_ajar_akhir'];
            }                
            $data['thn_akademik_id_attr'] = $thn_akademik_id_attr;
        }
        $this->load->view('transaction/plot_dosen_penanggung_jawab_form', $data);
    }
    
    /*function getOptTahunAkademik(){
        $this->load->model('plot_dosen_penanggung_jawab_model');
        $angkatan_id= $this->input->post('angkatan_id');
        $data = $this->plot_dosen_penanggung_jawab_model->get_tahun_angkatan($angkatan_id);
        echo '<option value="" ></option>';
        foreach($data as $row){
            echo '<option value=\''.$row['id'].'\' >'.$row['tahun_ajar_mulai'].'-'.$row['tahun_ajar_akhir'].'</option>';
        } 
    }*/
    
    function getOptTahunAkademik() {
        $angkatan_id= $this->input->post('angkatan_id');
        $sql = "select distinct a.tahun_ajar_mulai, a.tahun_ajar_akhir from akademik_m_tahun_akademik a ".
                " left join akademik_m_angkatan b on b.tahun_akademik_id=a.id ".
                "where a.active ='1' and b.tahun_akademik_id='$angkatan_id'";
        $query = $this->db->query($sql);
        foreach($query->result_array() as $row){
            echo $row['tahun_ajar_mulai'].'-'.$row['tahun_ajar_akhir'];
        }
    }
    
    function getOptPlotmatakuliah(){
        $this->load->model('plot_dosen_penanggung_jawab_model');
        $kelompok_mata_kuliah_id= $this->input->post('plot_mata_kuliah_id');
        $data = $this->plot_dosen_penanggung_jawab_model->get_plot_matakuliah($kelompok_mata_kuliah_id);
        //var_dump($data);
        echo '<option value="" ></option>';
        foreach($data as $row){
            echo '<option value=\''.$row['plot_mata_kuliah_id'].'\' >'.$row['nama_kelompok_mata_kuliah'].'</option>';
        } 
    }
    
    function getOptPlotmatakuliahDetil(){
        $this->load->model('plot_dosen_penanggung_jawab_model');
        $plot_mata_kuliah_id = $this->input->post('plot_mata_kuliah_id');
        $data = $this->plot_dosen_penanggung_jawab_model->get_plot_matakuliah_detil($plot_mata_kuliah_id);
        echo '<option value="" ></option>';
        foreach($data as $row){
            echo '<option value=\''.$row['plot_mata_kuliah_id'].'\' >'.$row['nama_mata_kuliah'].'</option>';
        } 
    }
}

?>
