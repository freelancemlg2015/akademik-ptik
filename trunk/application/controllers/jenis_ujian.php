<?php

/*
 * Imam Syarifudin
 * Master Tugas Imam : Jenis Ujian
 * 7/9/2012
 */

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Jenis_ujian extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->helper(array('snippets_helper'));
        $this->load->model('crud_model', 'crud');
    }

    function log_date() {
        return date($this->config->item('log_date_format'));
    }

    function index($query_id = 0, $sort_by = 'id', $sort_order = 'desc', $offset = 0) {
        $this->jenis_ujian($query_id, $sort_by, $sort_order, $offset);
    }

    function jenis_ujian($query_id = 0, $sort_by = 'id', $sort_order = 'desc', $offset = 0) {
        $data_type = $this->input->post('data_type');
        $data['auth'] = $this->auth;
        // pagination
        $limit = 20;
        $this->load->library(array('form_validation', 'table', 'pagination'));
        $this->input->load_query($query_id);
        $query_array = array(
            'kode_ujian' => $this->input->get('kode_ujian'),
            'jenis_ujian' => $this->input->get('jenis_ujian'),
            'active' => 1
        );

        $this->load->model('jenis_ujian_model', 'jenis_ujian');
        $results = $this->jenis_ujian->search($query_array, $limit, $offset, $sort_by, $sort_order);
        //echo get_instance()->db->last_query();
        $data['results'] = $results['results'];
        $data['num_results'] = $results['num_rows'];

        // pagination
        $config = array();
        $config['base_url'] = site_url("master/jenis_ujian/$query_id/$sort_by/$sort_order");
        $config['total_rows'] = $data['num_results'];
        $config['per_page'] = $limit;
        $config['uri_segment'] = 6;
        $config['num_links'] = 6;

        $config = array_merge($config, default_pagination_btn());
        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();
        $data['sort_by'] = $sort_by;
        $data['sort_order'] = $sort_order;

        $data['page_title'] = 'Jenis Ujian';

        $data['tools'] = array(
            'master/jenis_ujian/create' => 'New'
        );

        $this->load->view('master/jenis_ujian', $data);
    }

    function search() {
        $query_array = array(
            'kode_ujian' => $this->input->post('kode_ujian'),
            'jenis_ujian' => $this->input->post('jenis_ujian'),
            'active' => 1
        );
        $query_id = $this->input->save_query($query_array);
        redirect("master/jenis_ujian/view/$query_id");
    }

    function info() {
        $id = $this->uri->segment(3);
        $data['auth'] = $this->auth;
        $criteria = array(
            'm_jenis_ujian.id' => $id
        );
        $this->load->model('jenis_ujian_model', 'jenis_ujian');
        $result = $this->jenis_ujian->get_many('', $criteria)->row_array();
        //[debug]echo get_instance()->db->last_query();
        $result_keys = array_keys($result);
        foreach ($result_keys as $result_key) {
            $data[$result_key] = $result[$result_key];
        }

        $data['tools'] = array(
            'master/jenis_ujian' => 'Back',
            'master/jenis_ujian/' . $id . '/edit' => 'Edit',
            'master/jenis_ujian/' . $id . '/delete' => 'Delete'
        );
        $data['page_title'] = 'Detail Jenis Ujian';
        $this->load->view('master/jenis_ujian_info', $data);
    }

    function delete() {
        $id = $this->uri->segment(3);
        $this->crud->use_table('m_jenis_ujian');
        $criteria = array('id' => $id);
        $data_in = array(
            'active' => 0,
            'modified_on' => logged_info()->on,
            'modified_by' => logged_info()->by
        );
        $this->crud->update($criteria, $data_in);
        redirect('master/jenis_ujian');
    }

    function create() {
        $data['auth'] = $this->auth;
        $data['action_type'] = __FUNCTION__;
        $master_url = 'master/jenis_ujian/';

        $this->load->library(array('form_validation', 'table'));
        $this->load->helper(array('form', 'snippets'));
        $this->form_validation->set_error_delimiters('<span class="notice">', '</span>');
        if ($this->form_validation->run('jenis_ujian_create') === FALSE) {
            //don't do anything
        } else {
            $this->crud->use_table('m_jenis_ujian');
            $data_in = array(
                'kode_ujian' => $this->input->post('kode_ujian'),
                'jenis_ujian' => $this->input->post('jenis_ujian'),
                'created_on' => date($this->config->item('log_date_format')),
                'created_by' => logged_info()->on
            );
            /*
              echo '<pre>';
              var_dump($data_in);
              echo '</pre>';
             */
            $created_id = $this->crud->create($data_in);
            redirect('master/jenis_ujian/' . $created_id . '/info');
        }
        $data['action_url'] = $master_url . __FUNCTION__;
        $data['page_title'] = 'Create Jenis Ujian';
        $data['tools'] = array(
            'master/jenis_ujian' => 'Back'
        );

        $this->load->model('jenis_ujian_model', 'jenis_ujian');
        $data = array_merge($data, $this->jenis_ujian->set_default()); //merge dengan arr data dengan default
        $this->load->view('master/jenis_ujian_form', $data);
    }

    function edit() {
        $data['auth'] = $this->auth;
        $data['action_type'] = __FUNCTION__;
        $master_url = 'master/jenis_ujian/';
        $id = $this->uri->segment(3);

        $this->load->library(array('form_validation', 'table'));
        $this->load->helper(array('form', 'snippets'));
        $this->form_validation->set_error_delimiters('<span class="notice">', '</span>');
        if ($this->form_validation->run('jenis_ujian_update') === FALSE) {
            //don't do anything
        } else {
            $this->crud->use_table('m_jenis_ujian');
            $criteria = array(
                'id' => $id
            );
            $data_in = array(
                'kode_ujian' => $this->input->post('kode_ujian'),
                'jenis_ujian' => $this->input->post('jenis_ujian'),
                'modified_on' => date($this->config->item('log_date_format')),
                'modified_by' => logged_info()->on
            );
            $this->crud->update($criteria, $data_in);
            redirect('master/jenis_ujian/' . $id . '/info');
        }
        $data['action_url'] = $master_url . $id . '/' . __FUNCTION__;
        $data['page_title'] = 'Update Jenis Ujian';
        $data['tools'] = array(
            'master/jenis_ujian' => 'Back'
        );

        $this->crud->use_table('m_jenis_ujian');
        $jenis_ujian_data = $this->crud->retrieve(array('id' => $id))->row();

        $this->load->model('jenis_ujian_model', 'jenis_ujian');
        $data = array_merge($data, $this->akta_mengajar->set_default()); //merge dengan arr data dengan default
        $data = array_merge($data, (array) $jenis_ujian_data);
        $this->load->view('master/jenis_ujian_form', $data);
    }

    function unique_kode_ujian($kode_ujian) {
        $this->crud->use_table('m_kode_ujian');
        $jenis_ujian = $this->crud->retrieve(array('kode_ujian' => $kode_ujian))->row();
        if (sizeof($jenis_ujian) > 0) {
            $this->form_validation->set_message(__FUNCTION__, 'Kode Akta sudah terdaftar'); //pakai function karena ini harus sama dengan nama function nya
            return FALSE;
        } else {
            return true;
        }
    }

}

?>
