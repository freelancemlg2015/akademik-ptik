<?php

/*
 * Imam Syarifudin
 * Master Tugas Imam : Konsentrasi Studi
 * 5/9/2012
 */

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Konsentrasi_studi extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->helper(array('snippets_helper'));
        $this->load->model('crud_model', 'crud');
    }

    function log_date() {
        return date($this->config->item('log_date_format'));
    }

    function index($query_id = 0, $sort_by = 'id', $sort_order = 'desc', $offset = 0) {
        $this->konsentrasi_studi($query_id, $sort_by, $sort_order, $offset);
    }

    function konsentrasi_studi($query_id = 0, $sort_by = 'id', $sort_order = 'desc', $offset = 0) {
        $data_type = $this->input->post('data_type');
        $data['auth'] = $this->auth;
        // pagination
        $limit = 20;
        $this->load->library(array('form_validation', 'table', 'pagination'));
        $this->input->load_query($query_id);
        $query_array = array(
            'kode_konsentrasi_studi' => $this->input->get('kode_konsentrasi_studi'),
            'nama_konsentrasi_studi' => $this->input->get('nama_konsentrasi_studi'),
            'active' => 1
        );

        $this->load->model('konsentrasi_studi_model', 'konsentrasi_studi');
        $results = $this->konsentrasi_studi->search($query_array, $limit, $offset, $sort_by, $sort_order);
        //echo get_instance()->db->last_query();
        $data['results'] = $results['results'];
        $data['num_results'] = $results['num_rows'];

        // pagination
        $config = array();
        $config['base_url'] = site_url("master/konsentrasi_studi/$query_id/$sort_by/$sort_order");
        $config['total_rows'] = $data['num_results'];
        $config['per_page'] = $limit;
        $config['uri_segment'] = 6;
        $config['num_links'] = 6;

        $config = array_merge($config, default_pagination_btn());
        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();
        $data['sort_by'] = $sort_by;
        $data['sort_order'] = $sort_order;

        $data['page_title'] = 'Konsentrasi Studi';

        $data['tools'] = array(
            'master/konsentrasi_studi/create' => 'New'
        );

        $this->load->view('master/konsentrasi_studi', $data);
    }

    function search() {
        $query_array = array(
            'kode_konsentrasi_studi' => $this->input->post('kode_konsentrasi_studi'),
            'nama_konsentrasi_studi' => $this->input->post('nama_konsentrasi_studi'),
            'active' => 1
        );
        $query_id = $this->input->save_query($query_array);
        redirect("master/konsentrasi_studi/view/$query_id");
    }

    function info() {
        $id = $this->uri->segment(3);
        $data['auth'] = $this->auth;
        $criteria = array(
            'm_konsentrasi_studi.id' => $id
        );
        $this->load->model('konsentrasi_studi_model', 'konsentrasi_studi');
        $result = $this->konsentrasi_studi->get_many('', $criteria)->row_array();
        //[debug]echo get_instance()->db->last_query();
        $result_keys = array_keys($result);
        foreach ($result_keys as $result_key) {
            $data[$result_key] = $result[$result_key];
        }

        $data['tools'] = array(
            'master/konsentrasi_studi' => 'Back',
            'master/konsentrasi_studi/' . $id . '/edit' => 'Edit',
            'master/angkakonsentrasi_studitan/' . $id . '/delete' => 'Delete'
        );
        $data['page_title'] = 'Detail Konsentrasi Studi';
        $this->load->view('master/konsentrasi_studi_info', $data);
    }

    function delete() {
        $id = $this->uri->segment(3);
        $this->crud->use_table('m_konsentrasi_studi');
        $criteria = array('id' => $id);
        $data_in = array(
            'active' => 0,
            'modified_on' => logged_info()->on,
            'modified_by' => logged_info()->by
        );
        $this->crud->update($criteria, $data_in);
        redirect('master/konsentrasi_studi');
    }

    function create() {
        $data['auth'] = $this->auth;
        $data['action_type'] = __FUNCTION__;
        $master_url = 'master/konsentrasi_studi/';

        $this->load->library(array('form_validation', 'table'));
        $this->load->helper(array('form', 'snippets'));
        $this->form_validation->set_error_delimiters('<span class="notice">', '</span>');
        if ($this->form_validation->run('konsentrasi_studi_create') === FALSE) {
            //don't do anything
        } else {
            $this->crud->use_table('m_konsentrasi_studi');
            $data_in = array(
                'kode_konsentrasi_studi' => $this->input->post('kode_konsentrasi_studi'),
                'nama_konsentrasi_studi' => $this->input->post('nama_konsentrasi_studi'),
                'created_on' => date($this->config->item('log_date_format')),
                'created_by' => logged_info()->on
            );
            /*
              echo '<pre>';
              var_dump($data_in);
              echo '</pre>';
             */
            $created_id = $this->crud->create($data_in);
            redirect('master/konsentrasi_studi/' . $created_id . '/info');
        }
        $data['action_url'] = $master_url . __FUNCTION__;
        $data['page_title'] = 'Create Konsentrasi Studi';
        $data['tools'] = array(
            'master/konsentrasi_studi' => 'Back'
        );

        $this->load->model('konsentrasi_studi_model', 'konsentrasi_studi');
        $data = array_merge($data, $this->konsentrasi_studi->set_default()); //merge dengan arr data dengan default
        $this->load->view('master/konsentrasi_studi_form', $data);
    }

    function edit() {
        $data['auth'] = $this->auth;
        $data['action_type'] = __FUNCTION__;
        $master_url = 'master/konsentrasi_studi/';
        $id = $this->uri->segment(3);

        $this->load->library(array('form_validation', 'table'));
        $this->load->helper(array('form', 'snippets'));
        $this->form_validation->set_error_delimiters('<span class="notice">', '</span>');
        if ($this->form_validation->run('konsentrasi_studi_update') === FALSE) {
            //don't do anything
        } else {
            $this->crud->use_table('m_konsentrasi_studi');
            $criteria = array(
                'id' => $id
            );
            $data_in = array(
                'kode_konsentrasi_studi' => $this->input->post('kode_konsentrasi_studi'),
                'nama_konsentrasi_studi' => $this->input->post('nama_konsentrasi_studi'),
                'modified_on' => date($this->config->item('log_date_format')),
                'modified_by' => logged_info()->on
            );
            $this->crud->update($criteria, $data_in);
            redirect('master/konsentrasi_studi/' . $id . '/info');
        }
        $data['action_url'] = $master_url . $id . '/' . __FUNCTION__;
        $data['page_title'] = 'Update Konsentrasi Studi';
        $data['tools'] = array(
            'master/konsentrasi_studi' => 'Back'
        );

        $this->crud->use_table('m_konsentrasi_studi');
        $angkatan_data = $this->crud->retrieve(array('id' => $id))->row();

        $this->load->model('konsentrasi_studi_model', 'konsentrasi_studi');
        $data = array_merge($data, $this->konsentrasi_studi->set_default()); //merge dengan arr data dengan default
        $data = array_merge($data, (array) $angkatan_data);
        $this->load->view('master/konsentrasi_studi_form', $data);
    }

    function unique_kode_konsentrasi_studi($kode_konsentrasi_studi) {
        $this->crud->use_table('m_konsentrasi_studi');
        $konsentrasi_studi = $this->crud->retrieve(array('kode_konsentrasi_studi' => $kode_konsentrasi_studi))->row();
        if (sizeof($konsentrasi_studi) > 0) {
            $this->form_validation->set_message(__FUNCTION__, 'Kode Konsentrasi Studi sudah terdaftar'); //pakai function karena ini harus sama dengan nama function nya
            return FALSE;
        } else {
            return true;
        }
    }

}

?>
