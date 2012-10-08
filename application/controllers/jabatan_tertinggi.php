<?php

/*
 * Imam Syarifudin
 * Master Tugas Imam : Ruang Pelajaran
 * 8/9/2012
 */

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Jabatan_tertinggi extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->helper(array('snippets_helper'));
        $this->load->model('crud_model', 'crud');
    }

    function log_date() {
        return date($this->config->item('log_date_format'));
    }

    function index($query_id = 0, $sort_by = 'id', $sort_order = 'desc', $offset = 0) {
        $this->jabatan_tertinggi($query_id, $sort_by, $sort_order, $offset);
    }

    function jabatan_tertinggi($query_id = 0, $sort_by = 'id', $sort_order = 'desc', $offset = 0) {
        $data_type = $this->input->post('data_type');
        $data['auth'] = $this->auth;
        // pagination
        $limit = 20;
        $this->load->library(array('form_validation', 'table', 'pagination'));
        $this->input->load_query($query_id);
        $query_array = array(
            'kode_jabatan_tertinggi' => $this->input->get('jabatan_tertinggi'),
            'jabatan_tertinggi' => $this->input->get('jabatan_tertinggi'),
            'active' => 1
        );

        $this->load->model('jabatan_tertinggi_model', 'jabatan_tertinggi');
        $results = $this->jabatan_tertinggi->search($query_array, $limit, $offset, $sort_by, $sort_order);
        //echo get_instance()->db->last_query();
        $data['results'] = $results['results'];
        $data['num_results'] = $results['num_rows'];

        // pagination
        $config = array();
        $config['base_url'] = site_url("master/jabatan_tertinggi/$query_id/$sort_by/$sort_order");
        $config['total_rows'] = $data['num_results'];
        $config['per_page'] = $limit;
        $config['uri_segment'] = 6;
        $config['num_links'] = 6;

        $config = array_merge($config, default_pagination_btn());
        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();
        $data['sort_by'] = $sort_by;
        $data['sort_order'] = $sort_order;

        $data['page_title'] = 'Jabatan Tertinggi';

        $data['tools'] = array(
            'master/jabatan_tertinggi/create' => 'New'
        );

        $this->load->view('master/jabatan_tertinggi', $data);
    }

    function search() {
        $query_array = array(
            'kode_jabatan_tertinggi' => $this->input->post('kode_jabatan_tertinggi'),
            'jabatan_tertinggi' => $this->input->post('jabatan_tertinggi'),
            'active' => 1
        );
        $query_id = $this->input->save_query($query_array);
        redirect("master/jabatan_tertinggi/view/$query_id");
    }

    function info() {
        $id = $this->uri->segment(3);
        $data['auth'] = $this->auth;
        $criteria = array(
            'm_jabatan_tertinggi.id' => $id
        );
        $this->load->model('jabatan_tertinggi_model', 'jabatan_tertinggi');
        $result = $this->jabatan_tertinggi->get_many('', $criteria)->row_array();
        //[debug]echo get_instance()->db->last_query();
        $result_keys = array_keys($result);
        foreach ($result_keys as $result_key) {
            $data[$result_key] = $result[$result_key];
        }

        $data['tools'] = array(
            'master/jabatan_tertinggi' => 'Back',
            'master/jabatan_tertinggi/' . $id . '/edit' => 'Edit',
            'master/jabatan_tertinggi/' . $id . '/delete' => 'Delete'
        );
        $data['page_title'] = 'Detail Jabatan Tertinggi';
        $this->load->view('master/jabatan_tertinggi_info', $data);
    }

    function delete() {
        $id = $this->uri->segment(3);
        $this->crud->use_table('m_jabatan_tertinggi');
        $criteria = array('id' => $id);
        $data_in = array(
            'active' => 0,
            'modified_on' => logged_info()->on,
            'modified_by' => logged_info()->by
        );
        $this->crud->update($criteria, $data_in);
        redirect('master/jabatan_tertinggi');
    }

    function create() {
        $data['auth'] = $this->auth;
        $data['action_type'] = __FUNCTION__;
        $master_url = 'master/jabatan_tertinggi/';

        $this->load->library(array('form_validation', 'table'));
        $this->load->helper(array('form', 'snippets'));
        $this->form_validation->set_error_delimiters('<span class="notice">', '</span>');
        if ($this->form_validation->run('jabatan_tertinggi_create') === FALSE) {
            //don't do anything
        } else {
            $this->crud->use_table('m_jabatan_tertinggi');
            $data_in = array(
                'status_akreditasi_id' => $this->input->post('status_akreditasi_id'),
                'kode_jabatan_tertinggi' => $this->input->post('jabatan_tertinggi'),
                'jabatan_tertinggi' => $this->input->post('jabatan_tertinggi'),
                'created_on' => date($this->config->item('log_date_format')),
                'created_by' => logged_info()->on
            );
            /*
              echo '<pre>';
              var_dump($data_in);
              echo '</pre>';
             */
            $created_id = $this->crud->create($data_in);
            redirect('master/jabatan_tertinggi/' . $created_id . '/info');
        }
        $data['action_url'] = $master_url . __FUNCTION__;
        $data['page_title'] = 'Create Jabatan Tertinggi';
        $data['tools'] = array(
            'master/jabatan_tertinggi' => 'Back'
        );

        $this->crud->use_table('m_status_akreditasi');
        $data['status_akreditasi_options'] = $this->crud->retrieve()->result();

        $this->load->model('jabatan_tertinggi_model', 'jabatan_tertinggi');
        $data = array_merge($data, $this->jabatan_tertinggi->set_default()); //merge dengan arr data dengan default
        $this->load->view('master/jabatan_tertinggi_form', $data);
    }

    function edit() {
        $data['auth'] = $this->auth;
        $data['action_type'] = __FUNCTION__;
        $master_url = 'master/jabatan_tertinggi/';
        $id = $this->uri->segment(3);

        $this->load->library(array('form_validation', 'table'));
        $this->load->helper(array('form', 'snippets'));
        $this->form_validation->set_error_delimiters('<span class="notice">', '</span>');
        if ($this->form_validation->run('jabatan_tertinggi_update') === FALSE) {
            //don't do anything
        } else {
            $this->crud->use_table('m_jabatan_tertinggi');
            $criteria = array(
                'id' => $id
            );
            $data_in = array(
                'status_akreditasi_id' => $this->input->post('status_akreditasi_id'),
                'kode_jabatan_tertinggi' => $this->input->post('kode_jabatan_tertinggi'),
                'jabatan_tertinggi' => $this->input->post('jabatan_tertinggi'),
                'modified_on' => date($this->config->item('log_date_format')),
                'modified_by' => logged_info()->on
            );
            $this->crud->update($criteria, $data_in);
            redirect('master/jabatan_tertinggi/' . $id . '/info');
        }
        $data['action_url'] = $master_url . $id . '/' . __FUNCTION__;
        $data['page_title'] = 'Update Jabatan Tertinggi';
        $data['tools'] = array(
            'master/jabatan_tertinggi' => 'Back'
        );

        $this->crud->use_table('m_jabatan_tertinggi');
        $jabatan_tertinggi_data = $this->crud->retrieve(array('id' => $id))->row();

        $this->crud->use_table('m_status_akreditasi');
        $data['status_akreditasi_options'] = $this->crud->retrieve()->result();

        $this->load->model('jabatan_tertinggi_model', 'jabatan_tertinggi');
        $data = array_merge($data, $this->jabatan_tertinggi->set_default()); //merge dengan arr data dengan default
        $data = array_merge($data, (array) $jabatan_tertinggi_data);
        $this->load->view('master/jabatan_tertinggi_form', $data);
    }

    function unique_kode_jabatan_tertinggi($kode_jabatan_tertinggi) {
        $this->crud->use_table('m_jabatan_tertinggi');
        $jabatan_tertinggi = $this->crud->retrieve(array('kode_jabatan_tertinggi' => $kode_jabatan_tertinggi))->row();
        if (sizeof($jabatan_tertinggi) > 0) {
            $this->form_validation->set_message(__FUNCTION__, 'Kode Jabatan Tertinggi sudah terdaftar'); //pakai function karena ini harus sama dengan nama function nya
            return FALSE;
        } else {
            return true;
        }
    }

}

?>
