<?php

/*
 * Fachrul Rozi
 * transaction Kurikulum : Jadwal Kuliah
 * 8/9/2012
 */

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Jadwal_kuliah extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->helper(array('snippets_helper'));
        $this->load->model('crud_model', 'crud');
    }

    function log_date() {
        return date($this->config->item('log_date_format'));
    }

    function index($query_id = 0, $sort_by = 'id', $sort_order = 'desc', $offset = 0) {
        $this->jadwal_kuliah($query_id, $sort_by, $sort_order, $offset);
    }

    function jadwal_kuliah($query_id = 0, $sort_by = 'id', $sort_order = 'desc', $offset = 0) {
        $data_type = $this->input->post('data_type');
        $data['auth'] = $this->auth;
        // pagination
        $limit = 20;
        $this->load->library(array('form_validation', 'table', 'pagination'));
        $this->input->load_query($query_id);
        $query_array = array(
            'nama_dosen' => $this->input->get('nama_dosen'),
            'nama_ruang' => $this->input->get('nama_ruang'),
            'active' => 1
        );

        $this->load->model('jadwal_kuliah_model', 'jadwal_kuliah');
        $results = $this->jadwal_kuliah->search($query_array, $limit, $offset, $sort_by, $sort_order);
        //echo get_instance()->db->last_query();
        $data['results'] = $results['results'];
        $data['num_results'] = $results['num_rows'];

        // pagination
        $config = array();
        $config['base_url'] = site_url("transaction/jadwal_kuliah/$query_id/$sort_by/$sort_order");
        $config['total_rows'] = $data['num_results'];
        $config['per_page'] = $limit;
        $config['uri_segment'] = 6;
        $config['num_links'] = 6;

        $config = array_merge($config, default_pagination_btn());
        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();
        $data['sort_by'] = $sort_by;
        $data['sort_order'] = $sort_order;

        $data['page_title'] = 'Jadwal Kuliah';

        $data['tools'] = array(
            'transaction/jadwal_kuliah/create' => 'New'
        );

        $this->load->view('transaction/jadwal_kuliah', $data);
    }

    function search() {
        $query_array = array(
            'nama_dosen' => $this->input->post('nama_dosen'),
            'nama_ruang' => $this->input->post('nama_ruang'),
            'active' => 1
        );
        $query_id = $this->input->save_query($query_array);
        redirect("transaction/jadwal_kuliah/view/$query_id");
    }

    function info() {
        $id = $this->uri->segment(3);
        $data['auth'] = $this->auth;
        $criteria = array(
            't_jadwal_kuliah.id' => $id
        );
        $this->load->model('jadwal_kuliah_model', 'jadwal_kuliah');
        $result = $this->jadwal_kuliah->get_many('', $criteria)->row_array();
        //[debug]echo get_instance()->db->last_query();
        $result_keys = array_keys($result);
        foreach ($result_keys as $result_key) {
            $data[$result_key] = $result[$result_key];
        }

        $data['tools'] = array(
            'transaction/jadwal_kuliah' => 'Back',
            'transaction/jadwal_kuliah/' . $id . '/edit' => 'Edit',
            'transaction/jadwal_kuliah/' . $id . '/delete' => 'Delete'
        );
        $data['page_title'] = 'Detail Jadwal Kuliah';
        $this->load->view('transaction/jadwal_kuliah_info', $data);
    }

    function delete() {
        $id = $this->uri->segment(3);
        $this->crud->use_table('t_jadwal_kuliah');
        $criteria = array('id' => $id);
        $data_in = array(
            'active' => 0,
            'modified_on' => logged_info()->on,
            'modified_by' => logged_info()->by
        );
        $this->crud->update($criteria, $data_in);
        redirect('transaction/jadwal_kuliah');
    }

    function create() {
        $data['auth'] = $this->auth;
        $data['action_type'] = __FUNCTION__;
        $transaction_url = 'transaction/jadwal_kuliah/';

        $this->load->library(array('form_validation', 'table'));
        $this->load->helper(array('form', 'snippets'));
        $this->form_validation->set_error_delimiters('<span class="notice">', '</span>');
        if ($this->form_validation->run('jadwal_kuliah_create') === FALSE) {
            //don't do anything
        } else {
            $this->crud->use_table('t_jadwal_kuliah');
            $data_in = array(
                'dosen_ajar_id'=> $this->input->post('dosen_ajar_id'),
                'nama_ruang_id'=> $this->input->post('nama_ruang_id'),
                'jenis_waktu'  => $this->input->post('jenis_waktu'),
                'tanggal'      => $this->input->post('tanggal'),
                'jam'          => $this->input->post('jam'),
                'keterangan'   => $this->input->post('keterangan'),
                'created_on'   => date($this->config->item('log_date_format')),
                'created_by'   => logged_info()->on
            );
            /*        
              echo '<pre>';
              var_dump($data_in);
              echo '</pre>';
             */
            $created_id = $this->crud->create($data_in);
            redirect('transaction/jadwal_kuliah/' . $created_id . '/info');
        }
        $data['action_url'] = $transaction_url . __FUNCTION__;
        $data['page_title'] = 'Create Jadwal Kuliah';
        $data['tools'] = array(
            'transaction/jadwal_kuliah' => 'Back'
        );
        
        $data['nama_dosen'] = '';
        
        $this->crud->use_table('m_data_ruang');
        $data['ruang_pelajaran_options'] = $this->crud->retrieve()->result();
        
        $this->load->model('jadwal_kuliah_model', 'jadwal_kuliah');
        $data = array_merge($data, $this->jadwal_kuliah->set_default()); //merge dengan arr data dengan default
        
        $this->load->view('transaction/jadwal_kuliah_form', $data);
    }

    function edit() {
        $data['auth'] = $this->auth;
        $data['action_type'] = __FUNCTION__;
        $transaction_url = 'transaction/jadwal_kuliah/';
        $id = $this->uri->segment(3);

        $this->load->library(array('form_validation', 'table'));
        $this->load->helper(array('form', 'snippets'));
        $this->form_validation->set_error_delimiters('<span class="notice">', '</span>');
        if ($this->form_validation->run('jadwal_kuliah_update') === FALSE) {
            //don't do anything
        } else {
            $this->crud->use_table('t_jadwal_kuliah');
            $criteria = array(
                'id' => $id
            );
            $data_in = array(
                'dosen_ajar_id'=> $this->input->post('dosen_ajar_id'),
                'nama_ruang_id'=> $this->input->post('nama_ruang_id'),
                'jenis_waktu'  => $this->input->post('jenis_waktu'),
                'tanggal'      => $this->input->post('tanggal'),
                'jam'          => $this->input->post('jam'),
                'keterangan'   => $this->input->post('keterangan'),
                'modified_on'  => date($this->config->item('log_date_format')),
                'modified_by'  => logged_info()->on
            );
            
            //print_r($data_in);
            $this->crud->update($criteria, $data_in);
            redirect('transaction/jadwal_kuliah/' . $id . '/info');
        }
        $data['action_url'] = $transaction_url . $id . '/' . __FUNCTION__;
        $data['page_title'] = 'Update Jadwal Kuliah';
        $data['tools'] = array(
            'transaction/jadwal_kuliah' => 'Back'
        );
        
        $data['nama_dosen'] = '';
        
        $this->crud->use_table('t_jadwal_kuliah');
        $jadwal_kuliah_data = $this->crud->retrieve(array('id' => $id))->row();
        
        $this->crud->use_table('m_data_ruang');
        $data['ruang_pelajaran_options'] = $this->crud->retrieve()->result();

        $this->load->model('jadwal_kuliah_model', 'jadwal_kuliah');
        $data = array_merge($data, $this->jadwal_kuliah->set_default()); //merge dengan arr data dengan default
        $data = array_merge($data, (array) $jadwal_kuliah_data);
        $this->load->view('transaction/jadwal_kuliah_form', $data);
    }

   

}

?>
