<?php

/*
 * Imam Syarifudin
 * Master Kurikulum : Jabatan Akademik
 * 8/9/2012
 */

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Jabatan_akademik extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->helper(array('snippets_helper'));
        $this->load->model('crud_model', 'crud');
    }

    function log_date() {
        return date($this->config->item('log_date_format'));
    }

    function index($query_id = 0, $sort_by = 'id', $sort_order = 'desc', $offset = 0) {
        $this->jabatan_akademik($query_id, $sort_by, $sort_order, $offset);
    }

    function jabatan_akademik($query_id = 0, $sort_by = 'id', $sort_order = 'desc', $offset = 0) {
        $data_type = $this->input->post('data_type');
        $data['auth'] = $this->auth;
        // pagination
        $limit = 20;
        $this->load->library(array('form_validation', 'table', 'pagination'));
        $this->input->load_query($query_id);
        $query_array = array(
            'kode_jabatan_akademik' => $this->input->get('kode_jabatan_akademik'),
            'nama_jabatan_akademik' => $this->input->get('nama_jabatan_akademik'),
            'active' => 1
        );

        $this->load->model('jabatan_akademik_model', 'jabatan_akademik');
        $results = $this->jabatan_akademik->search($query_array, $limit, $offset, $sort_by, $sort_order);
        //echo get_instance()->db->last_query();
        $data['results'] = $results['results'];
        $data['num_results'] = $results['num_rows'];

        // pagination
        $config = array();
        $config['base_url'] = site_url("master/jabatan_akademik/$query_id/$sort_by/$sort_order");
        $config['total_rows'] = $data['num_results'];
        $config['per_page'] = $limit;
        $config['uri_segment'] = 6;
        $config['num_links'] = 6;

        $config = array_merge($config, default_pagination_btn());
        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();
        $data['sort_by'] = $sort_by;
        $data['sort_order'] = $sort_order;

        $data['page_title'] = 'Jabatan Akademik';

        $data['tools'] = array(
            'master/jabatan_akademik/create' => 'New'
        );

        $this->load->view('master/jabatan_akademik', $data);
    }

    function search() {
        $query_array = array(
            'kode_jabatan_akademik' => $this->input->post('kode_jabatan_akademik'),
            'nama_jabatan_akademik' => $this->input->post('nama_jabatan_akademik'),
            'active' => 1
        );
        $query_id = $this->input->save_query($query_array);
        redirect("master/jabatan_akademik/view/$query_id");
    }

    function info() {
        $id = $this->uri->segment(3);
        $data['auth'] = $this->auth;
        $criteria = array(
            'm_jabatan_akademik.id' => $id
        );
        $this->load->model('jabatan_akademik_model', 'jabatan_akademik');
        $result = $this->jabatan_akademik->get_many('', $criteria)->row_array();
        //[debug]echo get_instance()->db->last_query();
        $result_keys = array_keys($result);
        foreach ($result_keys as $result_key) {
            $data[$result_key] = $result[$result_key];
        }

        $data['tools'] = array(
            'master/jabatan_akademik' => 'Back',
            'master/jabatan_akademik/' . $id . '/edit' => 'Edit',
            'master/jabatan_akademik/' . $id . '/delete' => 'Delete'
        );
        $data['page_title'] = 'Detail Jabatan Akademik';
        $this->load->view('master/jabatan_akademik_info', $data);
    }

    function delete() {
        $id = $this->uri->segment(3);
        $this->crud->use_table('m_jabatan_akademik');
        $criteria = array('id' => $id);
        $data_in = array(
            'active' => 0,
            'modified_on' => logged_info()->on,
            'modified_by' => logged_info()->by
        );
        $this->crud->update($criteria, $data_in);
        redirect('master/jabatan_akademik');
    }

    function create() {
        $data['auth'] = $this->auth;
        $data['action_type'] = __FUNCTION__;
        $master_url = 'master/jabatan_akademik/';

        $this->load->library(array('form_validation', 'table'));
        $this->load->helper(array('form', 'snippets'));
        $this->form_validation->set_error_delimiters('<span class="notice">', '</span>');
        if ($this->form_validation->run('jabatan_akademik_create') === FALSE) {
            //don't do anything
        } else {
            $this->crud->use_table('m_jabatan_akademik');
            $data_in = array(
                'kode_jabatan_akademik' => $this->input->post('kode_jabatan_akademik'),
                'nama_jabatan_akademik' => $this->input->post('nama_jabatan_akademik'),
                'created_on' => date($this->config->item('log_date_format')),
                'created_by' => logged_info()->on
            );
            /*
              echo '<pre>';
              var_dump($data_in);
              echo '</pre>';
             */
            $created_id = $this->crud->create($data_in);
            redirect('master/jabatan_akademik/' . $created_id . '/info');
        }
        $data['action_url'] = $master_url . __FUNCTION__;
        $data['page_title'] = 'Create Jabatan Akademik';
        $data['tools'] = array(
            'master/jabatan_akademik' => 'Back'
        );

        $this->load->model('jabatan_akademik_model', 'jabatan_akademik');
        $data = array_merge($data, $this->jabatan_akademik->set_default()); //merge dengan arr data dengan default
        $this->load->view('master/jabatan_akademik_form', $data);
    }

    function edit() {
        $data['auth'] = $this->auth;
        $data['action_type'] = __FUNCTION__;
        $master_url = 'master/jabatan_akademik/';
        $id = $this->uri->segment(3);

        $this->load->library(array('form_validation', 'table'));
        $this->load->helper(array('form', 'snippets'));
        $this->form_validation->set_error_delimiters('<span class="notice">', '</span>');
        if ($this->form_validation->run('jabatan_akademik_update') === FALSE) {
            //don't do anything
        } else {
            $this->crud->use_table('m_jabatan_akademik');
            $criteria = array(
                'id' => $id
            );
            $data_in = array(
                'kode_jabatan_akademik' => $this->input->post('kode_jabatan_akademik'),
                'nama_jabatan_akademik' => $this->input->post('nama_jabatan_akademik'),
                'modified_on' => date($this->config->item('log_date_format')),
                'modified_by' => logged_info()->on
            );
            $this->crud->update($criteria, $data_in);
            redirect('master/jabatan_akademik/' . $id . '/info');
        }
        $data['action_url'] = $master_url . $id . '/' . __FUNCTION__;
        $data['page_title'] = 'Update Jabatan Akademik';
        $data['tools'] = array(
            'master/jabatan_akademik' => 'Back'
        );

        $this->crud->use_table('m_jabatan_akademik');
        $jabatan_akademik_data = $this->crud->retrieve(array('id' => $id))->row();

        $this->load->model('jabatan_akademik_model', 'jabatan_akademik');
        $data = array_merge($data, $this->jabatan_akademik->set_default()); //merge dengan arr data dengan default
        $data = array_merge($data, (array) $jabatan_akademik_data);
        $this->load->view('master/jabatan_akademik_form', $data);
    }

    function unique_kode_jabatan_akademik($kode_jabatan_akademik) {
        $this->crud->use_table('m_jabatan_akademik');
        $jabatan_akademik = $this->crud->retrieve(array('kode_jabatan_akademik' => $kode_jabatan_akademik))->row();
        if (sizeof($jabatan_akademik) > 0) {
            $this->form_validation->set_message(__FUNCTION__, 'Kode Angkatan sudah terdaftar'); //pakai function karena ini harus sama dengan nama function nya
            return FALSE;
        } else {
            return true;
        }
    }

}

?>
