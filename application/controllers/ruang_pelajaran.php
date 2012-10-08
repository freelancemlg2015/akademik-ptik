<?php

/*
 * Imam Syarifudin
 * Master Perkuliahan : Ruang Pelajaran
 * 8/9/2012
 */

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Ruang_pelajaran extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->helper(array('snippets_helper'));
        $this->load->model('crud_model', 'crud');
    }

    function log_date() {
        return date($this->config->item('log_date_format'));
    }

    function index($query_id = 0, $sort_by = 'id', $sort_order = 'desc', $offset = 0) {
        $this->ruang_pelajaran($query_id, $sort_by, $sort_order, $offset);
    }

    function ruang_pelajaran($query_id = 0, $sort_by = 'id', $sort_order = 'desc', $offset = 0) {
        $data_type = $this->input->post('data_type');
        $data['auth'] = $this->auth;
        // pagination
        $limit = 20;
        $this->load->library(array('form_validation', 'table', 'pagination'));
        $this->input->load_query($query_id);
        $query_array = array(
            'kode_ruang' => $this->input->get('kode_ruang'),
            'nama_ruang' => $this->input->get('nama_ruang'),
            'active' => 1
        );

        $this->load->model('ruang_pelajaran_model', 'ruang_pelajaran');
        $results = $this->ruang_pelajaran->search($query_array, $limit, $offset, $sort_by, $sort_order);
        //echo get_instance()->db->last_query();
        $data['results'] = $results['results'];
        $data['num_results'] = $results['num_rows'];

        // pagination
        $config = array();
        $config['base_url'] = site_url("master/ruang_pelajaran/$query_id/$sort_by/$sort_order");
        $config['total_rows'] = $data['num_results'];
        $config['per_page'] = $limit;
        $config['uri_segment'] = 6;
        $config['num_links'] = 6;

        $config = array_merge($config, default_pagination_btn());
        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();
        $data['sort_by'] = $sort_by;
        $data['sort_order'] = $sort_order;

        $data['page_title'] = 'Ruang Pelajaran';

        $data['tools'] = array(
            'master/ruang_pelajaran/create' => 'New'
        );

        $this->load->view('master/ruang_pelajaran', $data);
    }

    function search() {
        $query_array = array(
            'kode_ruang' => $this->input->post('kode_ruang'),
            'nama_ruang' => $this->input->post('nama_ruang'),
            'active' => 1
        );
        $query_id = $this->input->save_query($query_array);
        redirect("master/ruang_pelajaran/view/$query_id");
    }

    function info() {
        $id = $this->uri->segment(3);
        $data['auth'] = $this->auth;
        $criteria = array(
            'm_data_ruang.id' => $id
        );
        $this->load->model('ruang_pelajaran_model', 'ruang_pelajaran');
        $result = $this->ruang_pelajaran->get_many('', $criteria)->row_array();
        //[debug]echo get_instance()->db->last_query();
        $result_keys = array_keys($result);
        foreach ($result_keys as $result_key) {
            $data[$result_key] = $result[$result_key];
        }

        $data['tools'] = array(
            'master/ruang_pelajaran' => 'Back',
            'master/ruang_pelajaran/' . $id . '/edit' => 'Edit',
            'master/ruang_pelajaran/' . $id . '/delete' => 'Delete'
        );
        $data['page_title'] = 'Detail Ruang Pelajaran';
        $this->load->view('master/ruang_pelajaran_info', $data);
    }

    function delete() {
        $id = $this->uri->segment(3);
        $this->crud->use_table('m_data_ruang');
        $criteria = array('id' => $id);
        $data_in = array(
            'active' => 0,
            'modified_on' => logged_info()->on,
            'modified_by' => logged_info()->by
        );
        $this->crud->update($criteria, $data_in);
        redirect('master/ruang_pelajaran');
    }

    function create() {
        $data['auth'] = $this->auth;
        $data['action_type'] = __FUNCTION__;
        $master_url = 'master/ruang_pelajaran/';

        $this->load->library(array('form_validation', 'table'));
        $this->load->helper(array('form', 'snippets'));
        $this->form_validation->set_error_delimiters('<span class="notice">', '</span>');
        if ($this->form_validation->run('ruang_pelajaran_create') === FALSE) {
            //don't do anything
        } else {
            $this->crud->use_table('m_data_ruang');
            $data_in = array(
                'jenis_ruang_id' => $this->input->post('jenis_ruang_id'),
                'kode_ruang' => $this->input->post('kode_ruang'),
                'nama_ruang' => $this->input->post('nama_ruang'),
                'kapasitas_ruang' => $this->input->post('kapasitas_ruang'),
                'created_on' => date($this->config->item('log_date_format')),
                'created_by' => logged_info()->on
            );
            /*
              echo '<pre>';
              var_dump($data_in);
              echo '</pre>';
             */
            $created_id = $this->crud->create($data_in);
            redirect('master/ruang_pelajaran/' . $created_id . '/info');
        }
        $data['action_url'] = $master_url . __FUNCTION__;
        $data['page_title'] = 'Create Ruang Pelajaran';
        $data['tools'] = array(
            'master/ruang_pelajaran' => 'Back'
        );

        $this->crud->use_table('m_jenis_ruang');
        $data['jenis_ruang_options'] = $this->crud->retrieve()->result();

        $this->load->model('ruang_pelajaran_model', 'ruang_pelajaran');
        $data = array_merge($data, $this->ruang_pelajaran->set_default()); //merge dengan arr data dengan default
        $this->load->view('master/ruang_pelajaran_form', $data);
    }

    function edit() {
        $data['auth'] = $this->auth;
        $data['action_type'] = __FUNCTION__;
        $master_url = 'master/ruang_pelajaran/';
        $id = $this->uri->segment(3);

        $this->load->library(array('form_validation', 'table'));
        $this->load->helper(array('form', 'snippets'));
        $this->form_validation->set_error_delimiters('<span class="notice">', '</span>');
        if ($this->form_validation->run('ruang_pelajaran_update') === FALSE) {
            //don't do anything
        } else {
            $this->crud->use_table('m_data_ruang');
            $criteria = array(
                'id' => $id
            );
            $data_in = array(
                'jenis_ruang_id' => $this->input->post('jenis_ruang_id'),
                'kode_ruang' => $this->input->post('kode_ruang'),
                'nama_ruang' => $this->input->post('nama_ruang'),
                'kapasitas_ruang' => $this->input->post('kapasitas_ruang'),
                'modified_on' => date($this->config->item('log_date_format')),
                'modified_by' => logged_info()->on
            );
            $this->crud->update($criteria, $data_in);
            redirect('master/ruang_pelajaran/' . $id . '/info');
        }
        $data['action_url'] = $master_url . $id . '/' . __FUNCTION__;
        $data['page_title'] = 'Update Ruang Pelajaran';
        $data['tools'] = array(
            'master/ruang_pelajaran' => 'Back'
        );

        $this->crud->use_table('m_data_ruang');
        $ruang_pelajaran_data = $this->crud->retrieve(array('id' => $id))->row();

        $this->crud->use_table('m_jenis_ruang');
        $data['jenis_ruang_options'] = $this->crud->retrieve()->result();

        $this->load->model('ruang_pelajaran_model', 'ruang_pelajaran');
        $data = array_merge($data, $this->ruang_pelajaran->set_default()); //merge dengan arr data dengan default
        $data = array_merge($data, (array) $ruang_pelajaran_data);
        $this->load->view('master/ruang_pelajaran_form', $data);
    }

    function unique_kode_ruang($kode_ruang) {
        $this->crud->use_table('m_data_ruang');
        $ruang_pelajaran = $this->crud->retrieve(array('kode_ruang' => $kode_ruang))->row();
        if (sizeof($ruang_pelajaran) > 0) {
            $this->form_validation->set_message(__FUNCTION__, 'Kode Ruang sudah terdaftar'); //pakai function karena ini harus sama dengan nama function nya
            return FALSE;
        } else {
            return true;
        }
    }
    
    function suggestion() {
        $this->load->model('ruang_pelajaran_model');
        $nama_ruang = $this->input->get('nama_ruang');
        $terms = array(
            'nama_ruang' => $nama_ruang
        );
        $this->ruang_pelajaran_model->suggestion($terms);
    }
}

?>
