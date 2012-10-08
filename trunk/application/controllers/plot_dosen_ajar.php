<?php

/*
 * Imam Syarifudin
 * Transaction Jadwal Perkuliahan : Plot Dosen Ajar
 * 5/9/2012
 */

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Plot_dosen_ajar extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->helper(array('snippets_helper'));
        $this->load->model('crud_model', 'crud');
    }

    function log_date() {
        return date($this->config->item('log_date_format'));
    }

    function index($query_id = 0, $sort_by = 'id', $sort_order = 'desc', $offset = 0) {
        $this->plot_dosen_ajar($query_id, $sort_by, $sort_order, $offset);
    }

    function plot_dosen_ajar($query_id = 0, $sort_by = 'id', $sort_order = 'desc', $offset = 0) {
        $data_type    = $this->input->post('data_type');
        $data['auth'] = $this->auth;
        // pagination
        $limit = 20;
        $this->load->library(array('form_validation', 'table', 'pagination'));
        $this->input->load_query($query_id);
        $query_array = array(
            'nama_angkatan'  => $this->input->get('nama_angkatan'),
            'tahun_ajar'     => $this->input->get('tahun_ajar'),
            'active'         => 1
        );

        $this->load->model('plot_dosen_ajar_model', 'plot_dosen_ajar');
        $results = $this->plot_dosen_ajar->search($query_array, $limit, $offset, $sort_by, $sort_order);
        //echo get_instance()->db->last_query();
        $data['results']     = $results['results'];
        $data['num_results'] = $results['num_rows'];

        // pagination
        $config = array();
        $config['base_url']    = site_url("transaction/plot_dosen_ajar/$query_id/$sort_by/$sort_order");
        $config['total_rows']  = $data['num_results'];
        $config['per_page']    = $limit;
        $config['uri_segment'] = 6;
        $config['num_links']   = 6;

        $config = array_merge($config, default_pagination_btn());
        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();
        $data['sort_by']    = $sort_by;
        $data['sort_order'] = $sort_order;

        $data['page_title'] = 'Plot Dosen Ajar';

        $data['tools'] = array(
            'transaction/plot_dosen_ajar/create' => 'New'
        );

        $this->load->view('transaction/plot_dosen_ajar', $data);
    }

    function search() {
        $query_array = array(
            'nama_angkatan'  => $this->input->get('nama_angkatan'),
            'tahun_ajar'     => $this->input->get('tahun_ajar'),
            'active' => 1
        );
        $query_id = $this->input->save_query($query_array);
        redirect("transaction/plot_dosen_ajar/view/$query_id");
    }

    function info() {
        $id = $this->uri->segment(3);
        $data['auth'] = $this->auth;
        $criteria = array(
            't_dosen_ajar.id' => $id
        );
        $this->load->model('plot_dosen_ajar_model', 'plot_dosen_ajar');
        $result = $this->plot_dosen_ajar->get_many('', $criteria)->row_array();
        //[debug]echo get_instance()->db->last_query();
        $result_keys = array_keys($result);
        foreach ($result_keys as $result_key) {
            $data[$result_key] = $result[$result_key];
        }

        $data['tools'] = array(
            'transaction/plot_dosen_ajar' => 'Back',
            'transaction/plot_dosen_ajar/' . $id . '/edit' => 'Edit',
            'transaction/plot_dosen_ajar/' . $id . '/delete' => 'Delete'
        );
        $data['page_title'] = 'Detail Plot Dosen';
        $this->load->view('transaction/plot_dosen_ajar_info', $data);
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
        redirect('transaction/plot_dosen_ajar');
    }

    function create() {
        $data['auth']        = $this->auth;
        $data['action_type'] = __FUNCTION__;
        $master_url          = 'transaction/plot_dosen_ajar/';

        $this->load->library(array('form_validation', 'table'));
        $this->load->helper(array('form', 'snippets'));
        $this->form_validation->set_error_delimiters('<span class="notice">', '</span>');
        if ($this->form_validation->run('plot_dosen_ajar_create') === FALSE) {
            //don't do anything
        } else {
            $this->crud->use_table('t_dosen_ajar');
            $data_in = array(
                'angkatan_id'        => $this->input->post('angkatan_id'),
                'tahun_akademik_id'  => $this->input->post('tahun_akademik_id'),
                'semester_id'        => $this->input->post('semester_id'),
                'mata_kuliah_id'     => $this->input->post('mata_kuliah_id'),
                'dosen_id'           => $this->input->post('dosen_id'),
                'mahasiswa_id'       => $this->input->post('mahasiswa_id'),
                'keterangan'         => $this->input->post('keterangan'),
                'created_on'         => date($this->config->item('log_date_format')),
                'created_by'         => logged_info()->on
            );
            /*
              echo '<pre>';
              var_dump($data_in);
              echo '</pre>';
             */
            $created_id = $this->crud->create($data_in);
            redirect('transaction/plot_dosen_ajar/' . $created_id . '/info');
        }
        $data['action_url'] = $master_url . __FUNCTION__;
        $data['page_title'] = 'Create Plot Dosen Ajar';
        $data['tools']      = array(
            'transaction/plot_dosen_ajar' => 'Back'
        );
        
        $data['nama_angkatan']   = '';
        $data['tahun_ajar_mulai']      = '';
        $data['nama_semester']   = '';
        $data['nama_mata_kuliah']= '';
        $data['nama_dosen']      = '';
        $data['nama']  = '';
        
        $this->crud->use_table('m_semester');
        $data['semester_options'] = $this->crud->retrieve()->result();

        $this->load->model('plot_dosen_ajar_model', 'plot_dosen_ajar');
        $data = array_merge($data, $this->plot_dosen_ajar->set_default()); //merge dengan arr data dengan default
        
        $this->load->view('transaction/plot_dosen_ajar', $data);
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
        $master_url          = 'transaction/plot_dosen_ajar/';
        $id                  = $this->uri->segment(3);

        $this->load->library(array('form_validation', 'table'));
        $this->load->helper(array('form', 'snippets'));
        $this->form_validation->set_error_delimiters('<span class="notice">', '</span>');
        if ($this->form_validation->run('plot_dosen_ajar_update') === FALSE) {
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
                'dosen_id'           => $this->input->post('dosen_id'),
                'mahasiswa_id'       => $this->input->post('mahasiswa_id'),
                'keterangan'         => $this->input->post('keterangan'),
                'modified_on'        => date($this->config->item('log_date_format')),
                'modified_by'        => logged_info()->on
            );
            
            $this->crud->update($criteria, $data_in);
            redirect('transaction/plot_dosen_ajar/' . $id . '/info');
        }
        $data['action_url'] = $master_url . $id . '/' . __FUNCTION__;
        $data['page_title'] = 'Update Plot Dosen Ajar';
        $data['tools']      = array(
            'transaction/plot_dosen_ajar' => 'Back'
        );
        
        $data['nama_angkatan'] = '';
        $data['tahun_ajar']    = '';
        
        $this->crud->use_table('t_dosen_ajar');
        $plot_dosen_ajar_data = $this->crud->retrieve(array('id' => $id))->row();
        
        $this->crud->use_table('m_semester');
        $data['semester_options'] = $this->crud->retrieve()->result();
        
        $this->load->model('plot_dosen_ajar_model', 'plot_dosen_ajar');
        $data = array_merge($data, $this->plot_dosen_ajar->set_default()); //merge dengan arr data dengan default
        $data = array_merge($data, (array) $plot_dosen_ajar_data);
        $this->load->view('transaction/plot_dosen_ajar_form', $data);
    }

}

?>
