<?php

/*
 * Imam Syarifudin
 * Master Kurikulum : AKTA MENGAJAR
 * 7/9/2012
 */

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Akta_mengajar extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->helper(array('snippets_helper'));
        $this->load->model('crud_model', 'crud');
    }

    function log_date() {
        return date($this->config->item('log_date_format'));
    }

    function index($query_id = 0, $sort_by = 'id', $sort_order = 'desc', $offset = 0) {
        $this->akta_mengajar($query_id, $sort_by, $sort_order, $offset);
    }

    function akta_mengajar($query_id = 0, $sort_by = 'id', $sort_order = 'desc', $offset = 0) {
        $data_type = $this->input->post('data_type');
        $data['auth'] = $this->auth;
        // pagination
        $limit = 20;
        $this->load->library(array('form_validation', 'table', 'pagination'));
        $this->input->load_query($query_id);
        $query_array = array(
            'kode_akta' => $this->input->get('kode_akta'),
            'nama_akta_mengajar' => $this->input->get('nama_akta_mengajar'),
            'active' => 1
        );

        $this->load->model('akta_mengajar_model', 'akta_mengajar');
        $results = $this->akta_mengajar->search($query_array, $limit, $offset, $sort_by, $sort_order);
        //echo get_instance()->db->last_query();
        $data['results'] = $results['results'];
        $data['num_results'] = $results['num_rows'];

        // pagination
        $config = array();
        $config['base_url'] = site_url("master/akta_mengajar/$query_id/$sort_by/$sort_order");
        $config['total_rows'] = $data['num_results'];
        $config['per_page'] = $limit;
        $config['uri_segment'] = 6;
        $config['num_links'] = 6;

        $config = array_merge($config, default_pagination_btn());
        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();
        $data['sort_by'] = $sort_by;
        $data['sort_order'] = $sort_order;

        $data['page_title'] = 'akta_mengajar';

        $data['tools'] = array(
            'master/akta_mengajar/create' => 'New'
        );

        $this->load->view('master/akta_mengajar', $data);
    }

    function search() {
        $query_array = array(
            'kode_akta' => $this->input->post('kode_akta'),
            'nama_akta_mengajar' => $this->input->post('nama_akta_mengajar'),
            'active' => 1
        );
        $query_id = $this->input->save_query($query_array);
        redirect("master/akta_mengajar/view/$query_id");
    }

    function info() {
        $id = $this->uri->segment(3);
        $data['auth'] = $this->auth;
        $criteria = array(
            'm_akta_mengajar.id' => $id
        );
        $this->load->model('akta_mengajar_model', 'akta_mengajar');
        $result = $this->akta_mengajar->get_many('', $criteria)->row_array();
        //[debug]echo get_instance()->db->last_query();
        $result_keys = array_keys($result);
        foreach ($result_keys as $result_key) {
            $data[$result_key] = $result[$result_key];
        }

        $data['tools'] = array(
            'master/akta_mengajar' => 'Back',
            'master/akta_mengajar/' . $id . '/edit' => 'Edit',
            'master/akta_mengajar/' . $id . '/delete' => 'Delete'
        );
        $data['page_title'] = 'Detail Akta Mengajar';
        $this->load->view('master/akta_mengajar_info', $data);
    }

    function delete() {
        $id = $this->uri->segment(3);
        $this->crud->use_table('m_akta_mengajar');
        $criteria = array('id' => $id);
        $data_in = array(
            'active' => 0,
            'modified_on' => logged_info()->on,
            'modified_by' => logged_info()->by
        );
        $this->crud->update($criteria, $data_in);
        redirect('master/akta_mengajar');
    }

    function create() {
        $data['auth'] = $this->auth;
        $data['action_type'] = __FUNCTION__;
        $master_url = 'master/akta_mengajar/';

        $this->load->library(array('form_validation', 'table'));
        $this->load->helper(array('form', 'snippets'));
        $this->form_validation->set_error_delimiters('<span class="notice">', '</span>');
        if ($this->form_validation->run('akta_mengajar_create') === FALSE) {
            //don't do anything
        } else {
            $this->crud->use_table('m_akta_mengajar');
            $data_in = array(
                'kode_akta' => $this->input->post('kode_akta'),
                'nama_akta_mengajar' => $this->input->post('nama_akta_mengajar'),
                'created_on' => date($this->config->item('log_date_format')),
                'created_by' => logged_info()->on
            );
            /*
              echo '<pre>';
              var_dump($data_in);
              echo '</pre>';
             */
            $created_id = $this->crud->create($data_in);
            redirect('master/akta_mengajar/' . $created_id . '/info');
        }
        $data['action_url'] = $master_url . __FUNCTION__;
        $data['page_title'] = 'Create Akta Mengajar';
        $data['tools'] = array(
            'master/akta_mengajar' => 'Back'
        );

        $this->load->model('akta_mengajar_model', 'akta_mengajar');
        $data = array_merge($data, $this->akta_mengajar->set_default()); //merge dengan arr data dengan default
        $this->load->view('master/akta_mengajar_form', $data);
    }

    function edit() {
        $data['auth'] = $this->auth;
        $data['action_type'] = __FUNCTION__;
        $master_url = 'master/akta_mengajar/';
        $id = $this->uri->segment(3);

        $this->load->library(array('form_validation', 'table'));
        $this->load->helper(array('form', 'snippets'));
        $this->form_validation->set_error_delimiters('<span class="notice">', '</span>');
        if ($this->form_validation->run('akta_mengajar_update') === FALSE) {
            //don't do anything
        } else {
            $this->crud->use_table('m_akta_mengajar');
            $criteria = array(
                'id' => $id
            );
            $data_in = array(
                'kode_akta' => $this->input->post('kode_akta'),
                'nama_akta_mengajar' => $this->input->post('nama_akta_mengajar'),
                'modified_on' => date($this->config->item('log_date_format')),
                'modified_by' => logged_info()->on
            );
            $this->crud->update($criteria, $data_in);
            redirect('master/akta_mengajar/' . $id . '/info');
        }
        $data['action_url'] = $master_url . $id . '/' . __FUNCTION__;
        $data['page_title'] = 'Update Akta Mengajar';
        $data['tools'] = array(
            'master/akta_mengajar' => 'Back'
        );

        $this->crud->use_table('m_akta_mengajar');
        $akta_mengajar_data = $this->crud->retrieve(array('id' => $id))->row();

        $this->load->model('akta_mengajar_model', 'akta_mengajar');
        $data = array_merge($data, $this->akta_mengajar->set_default()); //merge dengan arr data dengan default
        $data = array_merge($data, (array) $akta_mengajar_data);
        $this->load->view('master/akta_mengajar_form', $data);
    }

    function unique_kode_akta($kode_akta) {
        $this->crud->use_table('m_akta_mengajar');
        $akta_mengajar = $this->crud->retrieve(array('kode_akta' => $kode_akta))->row();
        if (sizeof($akta_mengajar) > 0) {
            $this->form_validation->set_message(__FUNCTION__, 'Kode Akta sudah terdaftar'); //pakai function karena ini harus sama dengan nama function nya
            return FALSE;
        } else {
            return true;
        }
    }

}

?>
