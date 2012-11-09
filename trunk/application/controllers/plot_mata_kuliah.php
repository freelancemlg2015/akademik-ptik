<?php

/*
 * Imam Syarifudin
 * Transaction Kurikulum : Plot Mata Kuliah
 * 5/9/2012
 */

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Plot_mata_kuliah extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->helper(array('snippets_helper'));
        $this->load->model('crud_model', 'crud');
    }

    function log_date() {
        return date($this->config->item('log_date_format'));
    }

    function index($query_id = 0, $sort_by = 'id', $sort_order = 'desc', $offset = 0) {
        $this->plot_mata_kuliah($query_id, $sort_by, $sort_order, $offset);
    }

    function plot_mata_kuliah($query_id = 0, $sort_by = 'id', $sort_order = 'desc', $offset = 0) {
        $data_type    = $this->input->post('data_type');
        $data['auth'] = $this->auth;
        // pagination
        $limit = 20;
        $this->load->library(array('form_validation', 'table', 'pagination'));
        $this->input->load_query($query_id);
        $query_array = array(
            'nama_angkatan'  => $this->input->get('nama_angkatan'),
            'nama_semester'  => $this->input->get('nama_semester'),
            'active'         => 1
        );

        $this->load->model('plot_mata_kuliah_model', 'plot_mata_kuliah');
        $results = $this->plot_mata_kuliah->search($query_array, $limit, $offset, $sort_by, $sort_order);
        //echo get_instance()->db->last_query();
        $data['results']     = $results['results'];
        $data['num_results'] = $results['num_rows'];

        // pagination
        $config = array();
        $config['base_url']    = site_url("transaction/plot_mata_kuliah/$query_id/$sort_by/$sort_order");
        $config['total_rows']  = $data['num_results'];
        $config['per_page']    = $limit;
        $config['uri_segment'] = 6;
        $config['num_links']   = 6;

        $config = array_merge($config, default_pagination_btn());
        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();
        $data['sort_by']    = $sort_by;
        $data['sort_order'] = $sort_order;

        $data['page_title'] = 'Plot Mata Kuliah';

        $data['tools'] = array(
            'transaction/plot_mata_kuliah/create' => 'New'
        );

        $this->load->view('transaction/plot_mata_kuliah', $data);
    }

    function search() {
        $query_array = array(
            'nama_angkatan'  => $this->input->post('nama_angkatan'),
            'nama_semester'  => $this->input->post('nama_semester'),
            'active' => 1
        );
        $query_id = $this->input->save_query($query_array);
        redirect("transaction/plot_mata_kuliah/view/$query_id");
    }

    function info() {
        $id = $this->uri->segment(3);
        $data['auth'] = $this->auth;
        $criteria = array(
            't_plot_mata_kuliah.id' => $id
        );
        $this->load->model('plot_mata_kuliah_model', 'plot_mata_kuliah');
        $result = $this->plot_mata_kuliah->get_many('', $criteria)->row_array();
        //[debug]echo get_instance()->db->last_query();
        $result_keys = array_keys($result);
        foreach ($result_keys as $result_key) {
            $data[$result_key] = $result[$result_key];
        }
        
        $this->load->model('plot_mata_kuliah_model');
        $data['matakuliah_options_edit'] = $this->plot_mata_kuliah_model->get_matakuliah($id);
                                                          
        $data['tools'] = array(
            'transaction/plot_mata_kuliah' => 'Back',
            'transaction/plot_mata_kuliah/' . $id . '/edit' => 'Edit',
            'transaction/plot_mata_kuliah/' . $id . '/delete' => 'Delete'
        );
        $data['page_title'] = 'Detail Plot Mata Kuliah';
        $this->load->view('transaction/plot_mata_kuliah_info', $data);
    }

    function delete() {
        $id = $this->uri->segment(3);
        $this->crud->use_table('t_plot_mata_kuliah');
        $criteria = array('id' => $id);
        $data_in = array(
            'active'      => 0,
            'modified_on' => logged_info()->on,
            'modified_by' => logged_info()->by
        );
        $this->crud->update($criteria, $data_in);
        redirect('transaction/plot_mata_kuliah');
    }

    function create() {
        $data['auth'] = $this->auth;
        $data['action_type'] = __FUNCTION__;
        $transaction_url = 'transaction/plot_mata_kuliah/';
        $id                  = $this->uri->segment(3);
        
        $this->load->library(array('form_validation', 'table', 'pagination'));         
        $this->load->helper(array('form', 'snippets'));
        $this->form_validation->set_error_delimiters('<span class="notice">', '</span>');
        if ($this->form_validation->run('plot_mata_kuliah_create') === FALSE) {
            //don't do anything
        } else {
            $this->crud->use_table('t_plot_mata_kuliah');
            $data_in = array(
                'angkatan_id'             => $this->input->post('angkatan_id'),
                'semester_id'             => $this->input->post('semester_id'),
                'kelompok_mata_kuliah_id' => $this->input->post('kelompok_mata_kuliah_id'),
                'keterangan'              => $this->input->post('keterangan'),
                'created_on'              => date($this->config->item('log_date_format')),
                'created_by'              => logged_info()->on
            );
            /*        
              echo '<pre>';
              var_dump($data_in);
              echo '</pre>';
             */
            $created_id = $this->crud->create($data_in);
            
            $mata_kuliah = $this->input->post('mata_kuliah_id');
            if($created_id && is_array($mata_kuliah)){
                $this->crud->use_table('t_plot_mata_kuliah_detail');
                for($i=0; $i< count($mata_kuliah); $i++){
                    $data_in = array(
                        'plot_mata_kuliah_id' => $created_id,
                        'mata_kuliah_id'      => $mata_kuliah[$i],
                        'created_on'          => date($this->config->item('log_date_format')),
                        'created_by'          => logged_info()->on
                    );
                    $this->crud->create($data_in);
                }
            }
            redirect('transaction/plot_mata_kuliah/' . $created_id . '/info');
        }
        $data['action_url'] = $transaction_url . __FUNCTION__;
        $data['page_title'] = 'Create Plot Mata Kuliah';
        $data['tools'] = array(
            'transaction/plot_mata_kuliah' => 'Back'
        );
                                               
        $this->crud->use_table('m_angkatan');
        $data['angkatan_options'] = $this->crud->retrieve()->result();      
                                               
        $this->crud->use_table('m_tahun_akademik');
        $data['tahun_akademik_options'] = $this->crud->retrieve()->result();      

        $this->crud->use_table('m_semester');
        $data['semester_options'] = $this->crud->retrieve()->result();
        
        $this->crud->use_table('m_kelompok_matakuliah');
        $data['kelompok_matakuliah_options'] = $this->crud->retrieve()->result();
        
        $this->crud->use_table('m_mata_kuliah');
        $data['mata_kuliah_options'] = $this->crud->retrieve()->result();
        
        $this->crud->use_table('t_plot_mata_kuliah_detail');
        $data['plot_mata_kuliah_detil_options'] = $this->crud->retrieve()->result();
        
        $this->load->model('plot_mata_kuliah_model');
        $data['get_matakuliah_detil_options'] = $this->plot_mata_kuliah_model->get_detail();
        
        $data['detail_options'] = '';
        $data['thn_akademik_id_attr'] = '';
        $this->crud->use_table('m_angkatan');
        $data['m_angkatan'] = $this->crud->retrieve()->result();
        $this->load->model('paket_matakuliah_model');
        $data['m_tahun_akademik'] = $this->paket_matakuliah_model->get_tahun_angkatan();
                    
        $this->load->model('plot_mata_kuliah_model', 'plot_mata_kuliah');
        $data = array_merge($data, $this->plot_mata_kuliah->set_default()); //merge dengan arr data dengan default
        $this->load->view('transaction/plot_mata_kuliah_form', $data);
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
        $transaction_url          = 'transaction/plot_mata_kuliah/';
        $id                  = $this->uri->segment(3);
        
        $this->load->library(array('form_validation', 'table'));
        $this->load->helper(array('form', 'snippets'));
        $this->form_validation->set_error_delimiters('<span class="notice">', '</span>');
        if ($this->form_validation->run('plot_mata_kuliah_update') === FALSE) {
            //don't do anything
        } else {
            $this->crud->use_table('t_plot_mata_kuliah');
            $criteria = array(
                'id' => $id
            );
            $data_in = array(
                'angkatan_id'             => $this->input->post('angkatan_id'),
                'semester_id'             => $this->input->post('semester_id'),
                'kelompok_mata_kuliah_id' => $this->input->post('kelompok_mata_kuliah_id'),
                'keterangan'              => $this->input->post('keterangan'),
                'modified_on'             => date($this->config->item('log_date_format')),
                'modified_by'             => logged_info()->on
            );
            
            $this->crud->update($criteria, $data_in);

            $mata_kuliah = $this->input->post('mata_kuliah_id');
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
            } 
                        
            redirect('transaction/plot_mata_kuliah/' . $id . '/info');
        }
        $data['action_url'] = $transaction_url . $id . '/' . __FUNCTION__;
        $data['page_title'] = 'Update Plot Dosen Ajar';
        $data['tools']      = array(
            'transaction/plot_mata_kuliah' => 'Back'
        );
        
        $this->crud->use_table('t_plot_mata_kuliah');
        $plot_mata_kuliah_data = $this->crud->retrieve(array('id' => $id))->row();
        
        $this->crud->use_table('m_tahun_akademik');
        $tahun_akademik_data = array();
        $criteria = array(
            'id' => $plot_mata_kuliah_data->angkatan_id
        );
        $data['thn_akademik_id_attr'] = '';
        foreach ($this->crud->retrieve($criteria)->result() as $row) {
                $data['thn_akademik_id_attr'] =$row->tahun_ajar_mulai.'-'.$row->tahun_ajar_akhir;
                $tahun_akademik_data[$row->id] = $row->tahun_ajar_mulai.'-'.$row->tahun_ajar_akhir;
        }
        $data['tahun_akademik_options'] = $tahun_akademik_data;
        
        $this->crud->use_table('m_angkatan');
        $data['angkatan_options'] = $this->crud->retrieve()->result();
                                                                              
        $this->crud->use_table('m_semester');
        $data['semester_options'] = $this->crud->retrieve()->result();
        
        $this->crud->use_table('m_kelompok_matakuliah');
        $data['kelompok_matakuliah_options'] = $this->crud->retrieve()->result();
        
        $this->crud->use_table('m_mata_kuliah');
        $data['mata_kuliah_options'] = $this->crud->retrieve()->result();
                
        $this->load->model('plot_mata_kuliah_model');
        $data['detail_options'] = $this->plot_mata_kuliah_model->get_matakuliah_detil($id);
                
        $this->load->model('plot_mata_kuliah_model');
        $data['get_matakuliah_detil_options'] = $this->plot_mata_kuliah_model->get_detail();    
                
        $this->load->model('plot_mata_kuliah_model');
        $data['tahun_options'] = $this->plot_mata_kuliah_model->get_tahun_angkatan($id);    
        
        $this->crud->use_table('t_plot_mata_kuliah_detail');
        $plot_mata_kuliah_detil_data = $this->crud->retrieve(array('plot_mata_kuliah_id' => $id))->row();
        
        $this->load->model('plot_mata_kuliah_model', 'plot_mata_kuliah');
        $data = array_merge($data, $this->plot_mata_kuliah->set_default()); //merge dengan arr data dengan default        
        $data = array_merge($data, (array) $plot_mata_kuliah_data);
        if (!(empty($id))){
            $this->crud->use_table('m_angkatan');
            $data['m_angkatan'] = $this->crud->retrieve(array('id' => $data['angkatan_id']))->row();
            $this->load->model('paket_matakuliah_model');
            $data['m_tahun_akademik'] = $this->paket_matakuliah_model->get_tahun_angkatan($data['m_angkatan']->tahun_akademik_id);
            
            $thn_akademik_id_attr = '';
            foreach ($data['m_tahun_akademik'] as $row) {
                $thn_akademik_id_attr = $row['tahun_ajar_mulai'].'-'.$row['tahun_ajar_akhir'];
            }                
            $data['thn_akademik_id_attr'] = $thn_akademik_id_attr;
           
        }
        $this->load->view('transaction/plot_mata_kuliah_form', $data);
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
}

?>
