<?php

/*
 * Imam Syarifudin
 * Master Status Perkuliahan : Status Aktivitas Dosen
 * 7/9/2012
 */

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Status_aktivitas_dosen extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->helper(array('snippets_helper'));
        $this->load->model('crud_model', 'crud');
    }

    function log_date() {
        return date($this->config->item('log_date_format'));
    }

    function index($query_id = 0, $sort_by = 'id', $sort_order = 'desc', $offset = 0) {
        $this->status_aktivitas_dosen($query_id, $sort_by, $sort_order, $offset);
    }

    function status_aktivitas_dosen($query_id = 0, $sort_by = 'id', $sort_order = 'desc', $offset = 0) {
        $data_type = $this->input->post('data_type');
        $data['auth'] = $this->auth;
        // pagination
        $limit = 20;
        $this->load->library(array('form_validation', 'table', 'pagination'));
        $this->input->load_query($query_id);
        $query_array = array(
            'kode_status_aktivitas' => $this->input->get('kode_status_aktivitas'),
            'status_aktivitas_dosen' => $this->input->get('status_aktivitas_dosen'),
            'active' => 1
        );

        $this->load->model('status_aktivitas_dosen_model', 'status_aktivitas_dosen');
        $results = $this->status_aktivitas_dosen->search($query_array, $limit, $offset, $sort_by, $sort_order);
        //echo get_instance()->db->last_query();
        $data['results'] = $results['results'];
        $data['num_results'] = $results['num_rows'];

        // pagination
        $config = array();
        $config['base_url'] = site_url("master/status_aktivitas_dosen/$query_id/$sort_by/$sort_order");
        $config['total_rows'] = $data['num_results'];
        $config['per_page'] = $limit;
        $config['uri_segment'] = 6;
        $config['num_links'] = 6;

        $config = array_merge($config, default_pagination_btn());
        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();
        $data['sort_by'] = $sort_by;
        $data['sort_order'] = $sort_order;

        $data['page_title'] = 'Status Aktivitas Dosen';

        $data['tools'] = array(
            'master/status_aktivitas_dosen/create' => 'New'
        );

        $this->load->view('master/status_aktivitas_dosen', $data);
    }

    function search() {
        $query_array = array(
            'kode_status_aktivitas' => $this->input->post('kode_status_aktivitas'),
            'status_aktivitas_dosen' => $this->input->post('status_aktivitas_dosen'),
            'active' => 1
        );
        $query_id = $this->input->save_query($query_array);
        redirect("master/status_aktivitas_dosen/view/$query_id");
    }

    function info() {
        $id = $this->uri->segment(3);
        $data['auth'] = $this->auth;
        $criteria = array(
            'm_status_aktivitas_dosen.id' => $id
        );
        $this->load->model('status_aktivitas_dosen_model', 'status_aktivitas_dosen');
        $result = $this->status_aktivitas_dosen->get_many('', $criteria)->row_array();
        //[debug]echo get_instance()->db->last_query();
        $result_keys = array_keys($result);
        foreach ($result_keys as $result_key) {
            $data[$result_key] = $result[$result_key];
        }

        $data['tools'] = array(
            'master/status_aktivitas_dosen' => 'Back',
            'master/status_aktivitas_dosen/' . $id . '/edit' => 'Edit',
            'master/status_aktivitas_dosen/' . $id . '/delete' => 'Delete'
        );
        $data['page_title'] = 'Detail Status Aktivitas Dosen';
        $this->load->view('master/status_aktivitas_dosen_info', $data);
    }

    function delete() {
        $id = $this->uri->segment(3);
        $this->crud->use_table('m_status_aktivitas_dosen');
        $criteria = array('id' => $id);
        $data_in = array(
            'active' => 0,
            'modified_on' => logged_info()->on,
            'modified_by' => logged_info()->by
        );
        $this->crud->update($criteria, $data_in);
        redirect('master/status_aktivitas_dosen');
    }

    function create() {
        $data['auth'] = $this->auth;
        $data['action_type'] = __FUNCTION__;
        $master_url = 'master/status_aktivitas_dosen/';

        $this->load->library(array('form_validation', 'table'));
        $this->load->helper(array('form', 'snippets'));
        $this->form_validation->set_error_delimiters('<span class="notice">', '</span>');
        if ($this->form_validation->run('status_aktivitas_dosen_create') === FALSE) {
            //don't do anything
        } else {
            $this->crud->use_table('m_status_aktivitas_dosen');
            $data_in = array(
                'kode_status_aktivitas' => $this->input->post('kode_status_aktivitas'),
                'status_aktivitas_dosen' => $this->input->post('status_aktivitas_dosen'),
                'created_on' => date($this->config->item('log_date_format')),
                'created_by' => logged_info()->on
            );
            /*
              echo '<pre>';
              var_dump($data_in);
              echo '</pre>';
             */
            $created_id = $this->crud->create($data_in);
            redirect('master/status_aktivitas_dosen/' . $created_id . '/info');
        }
        $data['action_url'] = $master_url . __FUNCTION__;
        $data['page_title'] = 'Create Status Aktivitas Dosen';
        $data['tools'] = array(
            'master/status_aktivitas_dosen' => 'Back'
        );

        $this->load->model('status_aktivitas_dosen_model', 'status_aktivitas_dosen');
        $data = array_merge($data, $this->status_aktivitas_dosen->set_default()); //merge dengan arr data dengan default
        $this->load->view('master/status_aktivitas_dosen_form', $data);
    }

    function edit() {
        $data['auth'] = $this->auth;
        $data['action_type'] = __FUNCTION__;
        $master_url = 'master/status_aktivitas_dosen/';
        $id = $this->uri->segment(3);

        $this->load->library(array('form_validation', 'table'));
        $this->load->helper(array('form', 'snippets'));
        $this->form_validation->set_error_delimiters('<span class="notice">', '</span>');
        if ($this->form_validation->run('status_aktivitas_dosen_update') === FALSE) {
            //don't do anything
        } else {
            $this->crud->use_table('m_status_aktivitas_dosen');
            $criteria = array(
                'id' => $id
            );
            $data_in = array(
                'kode_status_aktivitas' => $this->input->post('kode_status_aktivitas'),
                'status_aktivitas_dosen' => $this->input->post('status_aktivitas_dosen'),
                'modified_on' => date($this->config->item('log_date_format')),
                'modified_by' => logged_info()->on
            );
            $this->crud->update($criteria, $data_in);
            redirect('master/status_aktivitas_dosen/' . $id . '/info');
        }
        $data['action_url'] = $master_url . $id . '/' . __FUNCTION__;
        $data['page_title'] = 'Update Status Aktivitas Dosen';
        $data['tools'] = array(
            'master/status_aktivitas_dosen' => 'Back'
        );

        $this->crud->use_table('m_status_aktivitas_dosen');
        $status_aktivitas_dosen_data = $this->crud->retrieve(array('id' => $id))->row();

        $this->load->model('status_aktivitas_dosen_model', 'status_aktivitas_dosen');
        $data = array_merge($data, $this->status_aktivitas_dosen->set_default()); //merge dengan arr data dengan default
        $data = array_merge($data, (array) $status_aktivitas_dosen_data);
        $this->load->view('master/status_aktivitas_dosen_form', $data);
    }

    function unique_kode_status_aktivitas($kode_status_aktivitas) {
        $this->crud->use_table('m_status_aktivitas_dosen');
        $status_aktivitas_dosen = $this->crud->retrieve(array('kode_status_aktivitas' => $kode_status_aktivitas))->row();
        if (sizeof($status_aktivitas_dosen) > 0) {
            $this->form_validation->set_message(__FUNCTION__, 'Kode Status Aktivitas sudah terdaftar'); //pakai function karena ini harus sama dengan nama function nya
            return FALSE;
        } else {
            return true;
        }
    }

}

?>
