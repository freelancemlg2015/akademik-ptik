<?php

/*
 * Imam Syarifudin
 * Master Tugas Imam : Semester Mulai Aktivitas
 * 8/9/2012
 */

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Semester_mulai_aktivitas extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->helper(array('snippets_helper'));
        $this->load->model('crud_model', 'crud');
    }

    function log_date() {
        return date($this->config->item('log_date_format'));
    }

    function index($query_id = 0, $sort_by = 'id', $sort_order = 'desc', $offset = 0) {
        $this->semester_mulai_aktivitas($query_id, $sort_by, $sort_order, $offset);
    }

    function semester_mulai_aktivitas($query_id = 0, $sort_by = 'id', $sort_order = 'desc', $offset = 0) {
        $data_type = $this->input->post('data_type');
        $data['auth'] = $this->auth;
        // pagination
        $limit = 20;
        $this->load->library(array('form_validation', 'table', 'pagination'));
        $this->input->load_query($query_id);
        $query_array = array(
            'semester_mulai_aktivitas' => $this->input->get('semester_mulai_aktivitas'),
            'active' => 1
        );

        $this->load->model('semester_mulai_aktivitas_model', 'semester_mulai_aktivitas');
        $results = $this->semester_mulai_aktivitas->search($query_array, $limit, $offset, $sort_by, $sort_order);
        //echo get_instance()->db->last_query();
        $data['results'] = $results['results'];
        $data['num_results'] = $results['num_rows'];

        // pagination
        $config = array();
        $config['base_url'] = site_url("master/semester_mulai_aktivitas/$query_id/$sort_by/$sort_order");
        $config['total_rows'] = $data['num_results'];
        $config['per_page'] = $limit;
        $config['uri_segment'] = 6;
        $config['num_links'] = 6;

        $config = array_merge($config, default_pagination_btn());
        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();
        $data['sort_by'] = $sort_by;
        $data['sort_order'] = $sort_order;

        $data['page_title'] = 'Semester Mulai Aktivitas';

        $data['tools'] = array(
            'master/semester_mulai_aktivitas/create' => 'New'
        );

        $this->load->view('master/semester_mulai_aktivitas', $data);
    }

    function search() {
        $query_array = array(
            'semester_mulai_aktivitas' => $this->input->post('semester_mulai_aktivitas'),
            'active' => 1
        );
        $query_id = $this->input->save_query($query_array);
        redirect("master/semester_mulai_aktivitas/view/$query_id");
    }

    function info() {
        $id = $this->uri->segment(3);
        $data['auth'] = $this->auth;
        $criteria = array(
            'm_semester_mulai_aktivitas.id' => $id
        );
        $this->load->model('semester_mulai_aktivitas_model', 'semester_mulai_aktivitas');
        $result = $this->semester_mulai_aktivitas->get_many('', $criteria)->row_array();
        //[debug]echo get_instance()->db->last_query();
        $result_keys = array_keys($result);
        foreach ($result_keys as $result_key) {
            $data[$result_key] = $result[$result_key];
        }

        $data['tools'] = array(
            'master/semester_mulai_aktivitas' => 'Back',
            'master/semester_mulai_aktivitas/' . $id . '/edit' => 'Edit',
            'master/semester_mulai_aktivitas/' . $id . '/delete' => 'Delete'
        );
        $data['page_title'] = 'Detail Semester Mulai Aktivitas';
        $this->load->view('master/semester_mulai_aktivitas_info', $data);
    }

    function delete() {
        $id = $this->uri->segment(3);
        $this->crud->use_table('m_semester_mulai_aktivitas');
        $criteria = array('id' => $id);
        $data_in = array(
            'active' => 0,
            'modified_on' => logged_info()->on,
            'modified_by' => logged_info()->by
        );
        $this->crud->update($criteria, $data_in);
        redirect('master/semester_mulai_aktivitas');
    }

    function create() {
        $data['auth'] = $this->auth;
        $data['action_type'] = __FUNCTION__;
        $master_url = 'master/semester_mulai_aktivitas/';

        $this->load->library(array('form_validation', 'table'));
        $this->load->helper(array('form', 'snippets'));
        $this->form_validation->set_error_delimiters('<span class="notice">', '</span>');
        if ($this->form_validation->run('semester_mulai_aktivitas_create') === FALSE) {
            //don't do anything
        } else {
            $this->crud->use_table('m_semester_mulai_aktivitas');
            $data_in = array(
                'semester_mulai_aktivitas' => $this->input->post('semester_mulai_aktivitas'),
                'created_on' => date($this->config->item('log_date_format')),
                'created_by' => logged_info()->on
            );
            /*
              echo '<pre>';
              var_dump($data_in);
              echo '</pre>';
             */
            $created_id = $this->crud->create($data_in);
            redirect('master/semester_mulai_aktivitas/' . $created_id . '/info');
        }
        $data['action_url'] = $master_url . __FUNCTION__;
        $data['page_title'] = 'Create Semester Mulai Aktivitas';
        $data['tools'] = array(
            'master/semester_mulai_aktivitas' => 'Back'
        );

        $this->load->model('semester_mulai_aktivitas_model', 'semester_mulai_aktivitas');
        $data = array_merge($data, $this->semester_mulai_aktivitas->set_default()); //merge dengan arr data dengan default
        $this->load->view('master/semester_mulai_aktivitas_form', $data);
    }

    function edit() {
        $data['auth'] = $this->auth;
        $data['action_type'] = __FUNCTION__;
        $master_url = 'master/semester_mulai_aktivitas/';
        $id = $this->uri->segment(3);

        $this->load->library(array('form_validation', 'table'));
        $this->load->helper(array('form', 'snippets'));
        $this->form_validation->set_error_delimiters('<span class="notice">', '</span>');
        if ($this->form_validation->run('semester_mulai_aktivitas_update') === FALSE) {
            //don't do anything
        } else {
            $this->crud->use_table('m_semester_mulai_aktivitas');
            $criteria = array(
                'id' => $id
            );
            $data_in = array(
                'semester_mulai_aktivitas' => $this->input->post('semester_mulai_aktivitas'),
                'modified_on' => date($this->config->item('log_date_format')),
                'modified_by' => logged_info()->on
            );
            $this->crud->update($criteria, $data_in);
            redirect('master/semester_mulai_aktivitas/' . $id . '/info');
        }
        $data['action_url'] = $master_url . $id . '/' . __FUNCTION__;
        $data['page_title'] = 'Update Semester Mulai Aktivitas';
        $data['tools'] = array(
            'master/semester_mulai_aktivitas' => 'Back'
        );

        $this->crud->use_table('m_semester_mulai_aktivitas');
        $semester_mulai_aktivitas_data = $this->crud->retrieve(array('id' => $id))->row();

        $this->load->model('semester_mulai_aktivitas_model', 'semester_mulai_aktivitas');
        $data = array_merge($data, $this->semester_mulai_aktivitas->set_default()); //merge dengan arr data dengan default
        $data = array_merge($data, (array) $semester_mulai_aktivitas_data);
        $this->load->view('master/semester_mulai_aktivitas_form', $data);
    }

    function unique_semester_mulai_aktivitas($semester_mulai_aktivitas) {
        $this->crud->use_table('m_semester_mulai_aktivitas');
        $semester_mulai_aktivitas = $this->crud->retrieve(array('semester_mulai_aktivitas' => $semester_mulai_aktivitas))->row();
        if (sizeof($semester_mulai_aktivitas) > 0) {
            $this->form_validation->set_message(__FUNCTION__, 'Semester Mulai Aktivitas sudah terdaftar'); //pakai function karena ini harus sama dengan nama function nya
            return FALSE;
        } else {
            return true;
        }
    }

}

?>
