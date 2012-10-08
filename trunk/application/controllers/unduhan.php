<?php

/*
 * Fachrul Rozi
 * Master Informasi : Unduhan
 * 5/9/2012
 */

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Unduhan extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->helper(array('snippets_helper'));
        $this->load->model('crud_model', 'crud');
    }

    function log_date() {
        return date($this->config->item('log_date_format'));
    }

    function index($query_id = 0, $sort_by = 'id', $sort_order = 'desc', $offset = 0) {
        $this->unduhan($query_id, $sort_by, $sort_order, $offset);
    }

    function unduhan($query_id = 0, $sort_by = 'id', $sort_order = 'desc', $offset = 0) {
        $data_type = $this->input->post('data_type');
        $data['auth'] = $this->auth;
        // pagination
        $limit = 20;
        $this->load->library(array('form_validation', 'table', 'pagination'));
        $this->input->load_query($query_id);
        $query_array = array(
            'kategori_unduhan' => $this->input->get('kategori_unduhan'),
            'nama_unduhan' => $this->input->get('nama_unduhan'),
            'active' => 1
        );

        $this->load->model('unduhan_model', 'unduhan');
        $results = $this->unduhan->search($query_array, $limit, $offset, $sort_by, $sort_order);
        //echo get_instance()->db->last_query();
        $data['results'] = $results['results'];
        $data['num_results'] = $results['num_rows'];

        // pagination
        $config = array();
        $config['base_url'] = site_url("master/unduhan/$query_id/$sort_by/$sort_order");
        $config['total_rows'] = $data['num_results'];
        $config['per_page'] = $limit;
        $config['uri_segment'] = 6;
        $config['num_links'] = 6;

        $config = array_merge($config, default_pagination_btn());
        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();
        $data['sort_by'] = $sort_by;
        $data['sort_order'] = $sort_order;

        $data['page_title'] = 'Unduhan';

        $data['tools'] = array(
            'master/unduhan/create' => 'New'
        );

        $this->load->view('master/unduhan', $data);
    }

    function search() {
        $query_array = array(
            'kategori_unduhan' => $this->input->post('kategori_unduhan'),
            'nama_unduhan' => $this->input->post('nama_unduhan'),
            'active' => 1
        );
        $query_id = $this->input->save_query($query_array);
        redirect("master/unduhan/view/$query_id");
    }

    function info() {
        $id = $this->uri->segment(3);
        $data['auth'] = $this->auth;
        $criteria = array(
            'm_unduhan.id' => $id
        );
        $this->load->model('unduhan_model', 'unduhan');
        $result = $this->unduhan->get_many('', $criteria)->row_array();
        //[debug]echo get_instance()->db->last_query();
        $result_keys = array_keys($result);
        foreach ($result_keys as $result_key) {
            $data[$result_key] = $result[$result_key];
        }

        $data['tools'] = array(
            'master/unduhan' => 'Back',
            'master/unduhan/' . $id . '/edit' => 'Edit',
            'master/unduhan/' . $id . '/delete' => 'Delete'
        );
        $data['page_title'] = 'Detail Unduhan';
        $this->load->view('master/unduhan_info', $data);
    }

    function delete() {
        $id = $this->uri->segment(3);
        $this->crud->use_table('m_unduhan');
        $criteria = array('id' => $id);
        $data_in = array(
            'active' => 0,
            'modified_on' => logged_info()->on,
            'modified_by' => logged_info()->by
        );
        $this->crud->update($criteria, $data_in);
        redirect('master/unduhan');
    }

    function create() {
        $data['auth'] = $this->auth;
        $data['action_type'] = __FUNCTION__;
        $master_url = 'master/unduhan/';

        $this->load->library(array('form_validation', 'table'));
        $this->load->helper(array('form', 'snippets'));
        $this->form_validation->set_error_delimiters('<span class="notice">', '</span>');
        if ($this->form_validation->run('unduhan_create') === FALSE) {
            //don't do anything
        } else {
            $this->crud->use_table('m_unduhan');
            $data_in = array(
                'kategori_unduhan_id' => $this->input->post('kategori_unduhan_id'),
                'nama_unduhan' => $this->input->post('nama_unduhan'),
                'keterangan' => $this->input->post('keterangan'),
                'created_on' => date($this->config->item('log_date_format')),
                'created_by' => logged_info()->on
            );
            /*
              echo '<pre>';
              var_dump($data_in);
              echo '</pre>';
             */
            $created_id = $this->crud->create($data_in);
            redirect('master/unduhan/' . $created_id . '/info');
        }
        $data['action_url'] = $master_url . __FUNCTION__;
        $data['page_title'] = 'Create Unduhan';
        $data['tools'] = array(
            'master/unduhan' => 'Back'
        );
        
        $this->crud->use_table('m_kategori_unduhan');
        $data['kategori_unduhan_options'] = $this->crud->retrieve()->result();

        $this->load->model('unduhan_model', 'unduhan');
        $data = array_merge($data, $this->unduhan->set_default()); //merge dengan arr data dengan default
        $this->load->view('master/unduhan_form', $data);
    }

    function edit() {
        $data['auth'] = $this->auth;
        $data['action_type'] = __FUNCTION__;
        $master_url = 'master/unduhan/';
        $id = $this->uri->segment(3);

        $this->load->library(array('form_validation', 'table'));
        $this->load->helper(array('form', 'snippets'));
        $this->form_validation->set_error_delimiters('<span class="notice">', '</span>');
        if ($this->form_validation->run('unduhan_update') === FALSE) {
            //don't do anything
        } else {
            $this->crud->use_table('m_unduhan');
            $criteria = array(
                'id' => $id
            );
            $data_in = array(
                'kategori_unduhan_id' => $this->input->post('kategori_unduhan_id'),
                'nama_unduhan' => $this->input->post('nama_unduhan'),
                'keterangan' => $this->input->post('keterangan'),
                'modified_on' => date($this->config->item('log_date_format')),
                'modified_by' => logged_info()->on
            );
            $this->crud->update($criteria, $data_in);
            redirect('master/unduhan/' . $id . '/info');
        }
        $data['action_url'] = $master_url . $id . '/' . __FUNCTION__;
        $data['page_title'] = 'Update Unduhan';
        $data['tools'] = array(
            'master/unduhan' => 'Back'
        );

        $this->crud->use_table('m_unduhan');
        $unduhan_data = $this->crud->retrieve(array('id' => $id))->row();
        
        $this->crud->use_table('m_kategori_unduhan');
        $data['kategori_unduhan_options'] = $this->crud->retrieve()->result();

        $this->load->model('unduhan_model', 'unduhan');
        $data = array_merge($data, $this->unduhan->set_default()); //merge dengan arr data dengan default
        $data = array_merge($data, (array) $unduhan_data);
        $this->load->view('master/unduhan_form', $data);
    }

    function unique_nama_unduhan($nama_unduhan) {
        $this->crud->use_table('m_unduhan');
        $unduhan = $this->crud->retrieve(array('nama_unduhan' => $nama_unduhan))->row();
        if (sizeof($unduhan) > 0) {
            $this->form_validation->set_message(__FUNCTION__, 'Nama Unduhan sudah terdaftar'); //pakai function karena ini harus sama dengan nama function nya
            return FALSE;
        } else {
            return true;
        }
    }

    function suggestion() {
        $this->load->model('angkatan_model');
        $nama_angkatan = $this->input->get('nama_angkatan');
        $terms = array(
            'nama_angkatan' => $nama_angkatan
        );
        $this->angkatan_model->suggestion($terms);
    }

}

?>
