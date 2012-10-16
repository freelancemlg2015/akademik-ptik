<?php

/*
 * Imam Syarifudin
 * Transaction Kurikulum : Paket Matakuliah
 * 5/9/2012
 */

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Paket_matakuliah extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->helper(array('snippets_helper'));
        $this->load->model('crud_model', 'crud');
    }

    function log_date() {
        return date($this->config->item('log_date_format'));
    }

    function index($query_id = 0, $sort_by = 'id', $sort_order = 'desc', $offset = 0) {
        $this->paket_matakuliah($query_id, $sort_by, $sort_order, $offset);
    }

    function paket_matakuliah($query_id = 0, $sort_by = 'id', $sort_order = 'desc', $offset = 0) {
        $data_type    = $this->input->post('data_type');
        $data['auth'] = $this->auth;
        // pagination
        $limit = 20;
        $this->load->library(array('form_validation', 'table', 'pagination'));
        $this->input->load_query($query_id);
        $query_array = array(
            'nama_angkatan'    => $this->input->get('nama_angkatan'),
            'nama_semester'    => $this->input->get('nama_semester'),
            'active'           => 1
        );

        $this->load->model('paket_matakuliah_model', 'paket_matakuliah');
        $results = $this->paket_matakuliah->search($query_array, $limit, $offset, $sort_by, $sort_order);
        //echo get_instance()->db->last_query();
        $data['results']     = $results['results'];
        $data['num_results'] = $results['num_rows'];

        // pagination
        $config = array();
        $config['base_url']    = site_url("transaction/paket_matakuliah/$query_id/$sort_by/$sort_order");
        $config['total_rows']  = $data['num_results'];
        $config['per_page']    = $limit;
        $config['uri_segment'] = 6;
        $config['num_links']   = 6;

        $config = array_merge($config, default_pagination_btn());
        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();
        $data['sort_by']    = $sort_by;
        $data['sort_order'] = $sort_order;

        $data['page_title'] = 'Paket Matakuliah';

        $data['tools'] = array(
            'transaction/paket_matakuliah/create' => 'New'
        );

        $this->load->view('transaction/paket_matakuliah', $data);
    }

    function search() {
        $query_array = array(
            'nama_angkatan'    => $this->input->post('nama_angkatan'),
            'nama_semester'    => $this->input->post('nama_semester'),
            'active'         => 1
        );
        $query_id = $this->input->save_query($query_array);
        redirect("transaction/paket_matakuliah/view/$query_id");
    }

    function info() {
        $id = $this->uri->segment(3);
        $data['auth'] = $this->auth;
        $criteria = array(
            't_paket_mata_kuliah.id' => $id
        );
        $this->load->model('paket_matakuliah_model', 'paket_matakuliah');
        $result = $this->paket_matakuliah->get_many('', $criteria)->row_array();
        //[debug]echo get_instance()->db->last_query();
        $result_keys = array_keys($result);
        foreach ($result_keys as $result_key) {
            $data[$result_key] = $result[$result_key];
        }

        $data['tools'] = array(
            'transaction/paket_matakuliah' => 'Back',
            'transaction/paket_matakuliah/' . $id . '/edit' => 'Edit',
            'transaction/paket_matakuliah/' . $id . '/delete' => 'Delete'
        );
        $data['page_title'] = 'Detail Paket Matakuliah';
        $this->load->view('transaction/paket_matakuliah_info', $data);
    }

    function delete() {
        $id = $this->uri->segment(3);
        $this->crud->use_table('t_paket_mata_kuliah');
        $criteria = array('id' => $id);
        $data_in = array(
            'active'      => 0,
            'modified_on' => logged_info()->on,
            'modified_by' => logged_info()->by
        );
        $this->crud->update($criteria, $data_in);
        redirect('transaction/paket_matakuliah');
    }

    function create() {
        $data['auth'] = $this->auth;
        $data['action_type'] = __FUNCTION__;
        $transaction_url = 'transaction/paket_matakuliah/';

        $this->load->library(array('form_validation', 'table'));
        $this->load->helper(array('form', 'snippets'));
        $this->form_validation->set_error_delimiters('<span class="notice">', '</span>');
        if ($this->form_validation->run('paket_matakuliah_create') === FALSE) {
            //don't do anything
        } else {
            $this->crud->use_table('t_paket_mata_kuliah');
            $data_in = array(
                'angkatan_id'             => $this->input->post('angkatan_id'),
                'tahun_akademik_id'       => $this->input->post('tahun_akademik_id'),
                'semester_id'             => $this->input->post('semester_id'),
                'program_studi_id'        => $this->input->post('program_studi_id'),
                'kelompok_mata_kuliah_id' => implode(",",$this->input->post('kelompok_mata_kuliah_id'),
                'plot_mata_kuliah_id'     => $this->input->post('plot_mata_kuliah_id'),
                'created_on'              => date($this->config->item('log_date_format')),
                'created_by'              => logged_info()->on
            ); 
            
//              echo '<pre>';
//              var_dump($data_in);
//              echo '</pre>';
             
            $created_id = $this->crud->create($data_in);
            redirect('transaction/paket_matakuliah/' . $created_id . '/info');
        }
        $data['action_url'] = $transaction_url . __FUNCTION__;
        $data['page_title'] = 'Create Paket Mata Kuliah';
        $data['tools'] = array(
            'transaction/paket_matakuliah' => 'Back'
        );
        
        $this->crud->use_table('m_angkatan');
        $data['angkatan_options'] = $this->crud->retrieve()->result();
        
        $this->crud->use_table('m_tahun_akademik');
        $data['tahun_akademik_options'] = $this->crud->retrieve()->result();
        
        $this->crud->use_table('m_semester');
        $data['semester_options'] = $this->crud->retrieve()->result();
        
        $this->crud->use_table('m_program_studi');
        $data['program_studi_options'] = $this->crud->retrieve()->result();
        
        $this->crud->use_table('m_kelompok_matakuliah');
        $data['kelompok_matakuliah_options'] = $this->crud->retrieve()->result();
        
        $this->crud->use_table('t_plot_mata_kuliah');
        $data['plot_mata_kuliah_options'] = $this->crud->retrieve()->result();
        
        $this->load->model('paket_matakuliah_model', 'paket_matakuliah');
        $data = array_merge($data, $this->paket_matakuliah->set_default()); //merge dengan arr data dengan default
        
        $this->load->view('transaction/paket_matakuliah_form', $data);
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
        $master_url          = 'transaction/paket_matakuliah/';
        $id                  = $this->uri->segment(3);

        $this->load->library(array('form_validation', 'table'));
        $this->load->helper(array('form', 'snippets'));
        $this->form_validation->set_error_delimiters('<span class="notice">', '</span>');
        if ($this->form_validation->run('paket_matakuliah_update') === FALSE) {
            //don't do anything
        } else {
            $this->crud->use_table('t_paket_mata_kuliah');
            $criteria = array(
                'id' => $id
            );
            $data_in = array(
                'angkatan_id'             => $this->input->post('angkatan_id'),
                'tahun_akademik_id'       => $this->input->post('tahun_akademik_id'),
                'semester_id'             => $this->input->post('semester_id'),
                'program_studi_id'        => $this->input->post('program_studi_id'),
                'kelompok_mata_kuliah_id' => $this->input->post('kelompok_mata_kuliah_id'),
                'plot_mata_kuliah_id'     => $this->input->post('plot_mata_kuliah_id'),
                'keterangan'              => $this->input->post('keterangan'),
                'modified_on'             => date($this->config->item('log_date_format')),
                'modified_by'             => logged_info()->on
            );
            
//              echo '<pre>';
//              var_dump($data_in);
//              echo '</pre>';
            
            $this->crud->update($criteria, $data_in);
            redirect('transaction/paket_matakuliah/' . $id . '/info');
        }
        $data['action_url'] = $master_url . $id . '/' . __FUNCTION__;
        $data['page_title'] = 'Update Paket Matakuliah';
        $data['tools']      = array(
            'transaction/paket_matakuliah' => 'Back'
        );
        
        $this->crud->use_table('t_paket_mata_kuliah');
        $paket_matakuliah_data = $this->crud->retrieve(array('id' => $id))->row();
        
        $this->crud->use_table('m_angkatan');
        $data['angkatan_options'] = $this->crud->retrieve()->result();
        
        $this->crud->use_table('m_tahun_akademik');
        $data['tahun_akademik_options'] = $this->crud->retrieve()->result();
        
        $this->crud->use_table('m_semester');
        $data['semester_options'] = $this->crud->retrieve()->result();
        
        $this->crud->use_table('m_program_studi');
        $data['program_studi_options'] = $this->crud->retrieve()->result();
        
        $this->crud->use_table('m_kelompok_matakuliah');
        $data['kelompok_matakuliah_options'] = $this->crud->retrieve()->result();
        
        $this->crud->use_table('t_plot_mata_kuliah');
        $data['plot_mata_kuliah_options'] = $this->crud->retrieve()->result();
        
        $this->load->model('paket_matakuliah_model', 'paket_matakuliah');
        $data = array_merge($data, $this->paket_matakuliah->set_default()); //merge dengan arr data dengan default
        $data = array_merge($data, (array) $paket_matakuliah_data);
        $this->load->view('transaction/paket_matakuliah_form', $data);
    }
}

?>
