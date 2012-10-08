<?php

/*
 * Imam Syarifudin
 * Master Tugas Imam : Semester
 * 8/9/2012
 */

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Semester extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->helper(array('snippets_helper'));
        $this->load->model('crud_model', 'crud');
    }

    function log_date() {
        return date($this->config->item('log_date_format'));
    }

    function index($query_id = 0, $sort_by = 'id', $sort_order = 'desc', $offset = 0) {
        $this->semester($query_id, $sort_by, $sort_order, $offset);
    }

    function semester($query_id = 0, $sort_by = 'id', $sort_order = 'desc', $offset = 0) {
        $data_type = $this->input->post('data_type');
        $data['auth'] = $this->auth;
        // pagination
        $limit = 20;
        $this->load->library(array('form_validation', 'table', 'pagination'));
        $this->input->load_query($query_id);
        $query_array = array(
            'kode_semester' => $this->input->get('kode_semester'),
            'nama_semester' => $this->input->get('nama_semester'),
            'active' => 1
        );

        $this->load->model('semester_model', 'semester');
        $results = $this->semester->search($query_array, $limit, $offset, $sort_by, $sort_order);
        //echo get_instance()->db->last_query();
        $data['results'] = $results['results'];
        $data['num_results'] = $results['num_rows'];

        // pagination
        $config = array();
        $config['base_url'] = site_url("master/semester/$query_id/$sort_by/$sort_order");
        $config['total_rows'] = $data['num_results'];
        $config['per_page'] = $limit;
        $config['uri_segment'] = 6;
        $config['num_links'] = 6;

        $config = array_merge($config, default_pagination_btn());
        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();
        $data['sort_by'] = $sort_by;
        $data['sort_order'] = $sort_order;

        $data['page_title'] = 'Semester';

        $data['tools'] = array(
            'master/semester/create' => 'New'
        );

        $this->load->view('master/semester', $data);
    }

    function search() {
        $query_array = array(
            'kode_semester' => $this->input->post('kode_semester'),
            'nama_semester' => $this->input->post('nama_semester'),
            'active' => 1
        );
        $query_id = $this->input->save_query($query_array);
        redirect("master/semester/view/$query_id");
    }

    function info() {
        $id = $this->uri->segment(3);
        $data['auth'] = $this->auth;
        $criteria = array(
            'm_semester.id' => $id
        );
        $this->load->model('semester_model', 'semester');
        $result = $this->semester->get_many('', $criteria)->row_array();
        //[debug]echo get_instance()->db->last_query();
        $result_keys = array_keys($result);
        foreach ($result_keys as $result_key) {
            $data[$result_key] = $result[$result_key];
        }

        $data['tools'] = array(
            'master/semester' => 'Back',
            'master/semester/' . $id . '/edit' => 'Edit',
            'master/semester/' . $id . '/delete' => 'Delete'
        );
        $data['page_title'] = 'Detail Semester';
        $this->load->view('master/semester_info', $data);
    }

    function delete() {
        $id = $this->uri->segment(3);
        $this->crud->use_table('m_semester');
        $criteria = array('id' => $id);
        $data_in = array(
            'active' => 0,
            'modified_on' => logged_info()->on,
            'modified_by' => logged_info()->by
        );
        $this->crud->update($criteria, $data_in);
        redirect('master/semester');
    }

    function create() {
        $data['auth'] = $this->auth;
        $data['action_type'] = __FUNCTION__;
        $master_url = 'master/semester/';

        $this->load->library(array('form_validation', 'table'));
        $this->load->helper(array('form', 'snippets'));
        $this->form_validation->set_error_delimiters('<span class="notice">', '</span>');
        if ($this->form_validation->run('semester_create') === FALSE) {
            //don't do anything
        } else {
            $this->crud->use_table('m_semester');
            $data_in = array(
                'kode_semester' => $this->input->post('kode_semester'),
                'nama_semester' => $this->input->post('nama_semester'),
                'created_on' => date($this->config->item('log_date_format')),
                'created_by' => logged_info()->on
            );
            /*
              echo '<pre>';
              var_dump($data_in);
              echo '</pre>';
             */
            $created_id = $this->crud->create($data_in);
            redirect('master/semester/' . $created_id . '/info');
        }
        $data['action_url'] = $master_url . __FUNCTION__;
        $data['page_title'] = 'Create Semester';
        $data['tools'] = array(
            'master/semester' => 'Back'
        );

        $this->load->model('semester_model', 'semester');
        $data = array_merge($data, $this->semester->set_default()); //merge dengan arr data dengan default
        $this->load->view('master/semester_form', $data);
    }

    function edit() {
        $data['auth'] = $this->auth;
        $data['action_type'] = __FUNCTION__;
        $master_url = 'master/semester/';
        $id = $this->uri->segment(3);

        $this->load->library(array('form_validation', 'table'));
        $this->load->helper(array('form', 'snippets'));
        $this->form_validation->set_error_delimiters('<span class="notice">', '</span>');
        if ($this->form_validation->run('semester_update') === FALSE) {
            //don't do anything
        } else {
            $this->crud->use_table('m_semester');
            $criteria = array(
                'id' => $id
            );
            $data_in = array(
                'kode_semester' => $this->input->post('kode_semester'),
                'nama_semester' => $this->input->post('nama_semester'),
                'modified_on' => date($this->config->item('log_date_format')),
                'modified_by' => logged_info()->on
            );
            $this->crud->update($criteria, $data_in);
            redirect('master/semester/' . $id . '/info');
        }
        $data['action_url'] = $master_url . $id . '/' . __FUNCTION__;
        $data['page_title'] = 'Update Semester';
        $data['tools'] = array(
            'master/semester' => 'Back'
        );

        $this->crud->use_table('m_semester');
        $angkatan_data = $this->crud->retrieve(array('id' => $id))->row();

        $this->load->model('semester_model', 'semester');
        $data = array_merge($data, $this->semester->set_default()); //merge dengan arr data dengan default
        $data = array_merge($data, (array) $angkatan_data);
        $this->load->view('master/semester_form', $data);
    }

    function unique_kode_semester($kode_semester) {
        $this->crud->use_table('m_semester');
        $semester = $this->crud->retrieve(array('kode_semester' => $kode_semester))->row();
        if (sizeof($semester) > 0) {
            $this->form_validation->set_message(__FUNCTION__, 'Kode Semester sudah terdaftar'); //pakai function karena ini harus sama dengan nama function nya
            return FALSE;
        } else {
            return true;
        }
    }
    
    function suggestion() {
        $this->load->model('semester_model');
        $nama_semester = $this->input->get('nama_semester');
        $terms = array(
            'nama_semester' => $nama_semester
        );
        $this->semester_model->suggestion($terms);
    }

}

?>
