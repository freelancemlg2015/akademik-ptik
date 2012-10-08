<?php

/*
 * Fachrul Rozi
 * Master Kurikulum : Angkatan
 * 5/9/2012
 */

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Angkatan extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->helper(array('snippets_helper'));
        $this->load->model('crud_model', 'crud');
    }

    function log_date() {
        return date($this->config->item('log_date_format'));
    }

    function index($query_id = 0, $sort_by = 'id', $sort_order = 'desc', $offset = 0) {
        $this->angkatan($query_id, $sort_by, $sort_order, $offset);
    }

    function angkatan($query_id = 0, $sort_by = 'id', $sort_order = 'desc', $offset = 0) {
        $data_type = $this->input->post('data_type');
        $data['auth'] = $this->auth;
        // pagination
        $limit = 20;
        $this->load->library(array('form_validation', 'table', 'pagination'));
        $this->input->load_query($query_id);
        $query_array = array(
            'kode_angkatan' => $this->input->get('kode_angkatan'),
            'nama_angkatan' => $this->input->get('nama_angkatan'),
            'active' => 1
        );

        $this->load->model('angkatan_model', 'angkatan');
        $results = $this->angkatan->search($query_array, $limit, $offset, $sort_by, $sort_order);
        //echo get_instance()->db->last_query();
        $data['results'] = $results['results'];
        $data['num_results'] = $results['num_rows'];

        // pagination
        $config = array();
        $config['base_url'] = site_url("master/angkatan/$query_id/$sort_by/$sort_order");
        $config['total_rows'] = $data['num_results'];
        $config['per_page'] = $limit;
        $config['uri_segment'] = 6;
        $config['num_links'] = 6;

        $config = array_merge($config, default_pagination_btn());
        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();
        $data['sort_by'] = $sort_by;
        $data['sort_order'] = $sort_order;

        $data['page_title'] = 'Angkatan';

        $data['tools'] = array(
            'master/angkatan/create' => 'New'
        );

        $this->load->view('master/angkatan', $data);
    }

    function search() {
        $query_array = array(
            'kode_angkatan' => $this->input->post('kode_angkatan'),
            'nama_angkatan' => $this->input->post('nama_angkatan'),
            'active' => 1
        );
        $query_id = $this->input->save_query($query_array);
        redirect("master/angkatan/view/$query_id");
    }

    function info() {
        $id = $this->uri->segment(3);
        $data['auth'] = $this->auth;
        $criteria = array(
            'm_angkatan.id' => $id
        );
        $this->load->model('angkatan_model', 'angkatan');
        $result = $this->angkatan->get_many('', $criteria)->row_array();
        //[debug]echo get_instance()->db->last_query();
        $result_keys = array_keys($result);
        foreach ($result_keys as $result_key) {
            $data[$result_key] = $result[$result_key];
        }

        $data['tools'] = array(
            'master/angkatan' => 'Back',
            'master/angkatan/' . $id . '/edit' => 'Edit',
            'master/angkatan/' . $id . '/delete' => 'Delete'
        );
        $data['page_title'] = 'Detail Angkatan';
        $this->load->view('master/angkatan_info', $data);
    }

    function delete() {
        $id = $this->uri->segment(3);
        $this->crud->use_table('m_angkatan');
        $criteria = array('id' => $id);
        $data_in = array(
            'active' => 0,
            'modified_on' => logged_info()->on,
            'modified_by' => logged_info()->by
        );
        $this->crud->update($criteria, $data_in);
        redirect('master/angkatan');
    }

    function create() {
        $data['auth'] = $this->auth;
        $data['action_type'] = __FUNCTION__;
        $master_url = 'master/angkatan/';

        $this->load->library(array('form_validation', 'table'));
        $this->load->helper(array('form', 'snippets'));
        $this->form_validation->set_error_delimiters('<span class="notice">', '</span>');
        if ($this->form_validation->run('angkatan_create') === FALSE) {
            //don't do anything
        } else {
            $this->crud->use_table('m_angkatan');
            $data_in = array(
                'kode_angkatan' => $this->input->post('kode_angkatan'),
                'nama_angkatan' => $this->input->post('nama_angkatan'),
                'created_on' => date($this->config->item('log_date_format')),
                'created_by' => logged_info()->on
            );
            /*
              echo '<pre>';
              var_dump($data_in);
              echo '</pre>';
             */
            $created_id = $this->crud->create($data_in);
            redirect('master/angkatan/' . $created_id . '/info');
        }
        $data['action_url'] = $master_url . __FUNCTION__;
        $data['page_title'] = 'Create Angkatan';
        $data['tools'] = array(
            'master/angkatan' => 'Back'
        );

        $this->load->model('angkatan_model', 'angkatan');
        $data = array_merge($data, $this->angkatan->set_default()); //merge dengan arr data dengan default
        $this->load->view('master/angkatan_form', $data);
    }

    function edit() {
        $data['auth'] = $this->auth;
        $data['action_type'] = __FUNCTION__;
        $master_url = 'master/angkatan/';
        $id = $this->uri->segment(3);

        $this->load->library(array('form_validation', 'table'));
        $this->load->helper(array('form', 'snippets'));
        $this->form_validation->set_error_delimiters('<span class="notice">', '</span>');
        if ($this->form_validation->run('angkatan_update') === FALSE) {
            //don't do anything
        } else {
            $this->crud->use_table('m_angkatan');
            $criteria = array(
                'id' => $id
            );
            $data_in = array(
                'kode_angkatan' => $this->input->post('kode_angkatan'),
                'nama_angkatan' => $this->input->post('nama_angkatan'),
                'modified_on' => date($this->config->item('log_date_format')),
                'modified_by' => logged_info()->on
            );
            $this->crud->update($criteria, $data_in);
            redirect('master/angkatan/' . $id . '/info');
        }
        $data['action_url'] = $master_url . $id . '/' . __FUNCTION__;
        $data['page_title'] = 'Update Angkatan';
        $data['tools'] = array(
            'master/angkatan' => 'Back'
        );

        $this->crud->use_table('m_angkatan');
        $angkatan_data = $this->crud->retrieve(array('id' => $id))->row();

        $this->load->model('angkatan_model', 'angkatan');
        $data = array_merge($data, $this->angkatan->set_default()); //merge dengan arr data dengan default
        $data = array_merge($data, (array) $angkatan_data);
        $this->load->view('master/angkatan_form', $data);
    }

    function unique_nama_angkatan($nama_angkatan) {
        $this->crud->use_table('m_angkatan');
        $angkatan = $this->crud->retrieve(array('nama_angkatan' => $nama_angkatan))->row();
        if (sizeof($angkatan) > 0) {
            $this->form_validation->set_message(__FUNCTION__, 'Nama Angkatan sudah terdaftar'); //pakai function karena ini harus sama dengan nama function nya
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
