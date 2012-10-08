<?php

/*
 * Imam Syarifudin
 * Master Kurikulum : Frekuensi Pemutahiran
 * 8/9/2012
 */

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Frekuensi_pemutakhiran extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->helper(array('snippets_helper'));
        $this->load->model('crud_model', 'crud');
    }

    function log_date() {
        return date($this->config->item('log_date_format'));
    }

    function index($query_id = 0, $sort_by = 'id', $sort_order = 'desc', $offset = 0) {
        $this->frekuensi_pemutakhiran($query_id, $sort_by, $sort_order, $offset);
    }

    function frekuensi_pemutakhiran($query_id = 0, $sort_by = 'id', $sort_order = 'desc', $offset = 0) {
        $data_type = $this->input->post('data_type');
        $data['auth'] = $this->auth;
        // pagination
        $limit = 20;
        $this->load->library(array('form_validation', 'table', 'pagination'));
        $this->input->load_query($query_id);
        $query_array = array(
            'frekuensi_pemutahiran_kurikulum' => $this->input->get('frekuensi_pemutahiran_kurikulum'),
            'active' => 1
        );

        $this->load->model('frekuensi_pemutakhiran_model', 'frekuensi_pemutakhiran');
        $results = $this->frekuensi_pemutakhiran->search($query_array, $limit, $offset, $sort_by, $sort_order);
        //echo get_instance()->db->last_query();
        $data['results'] = $results['results'];
        $data['num_results'] = $results['num_rows'];

        // pagination
        $config = array();
        $config['base_url'] = site_url("master/frekuensi_pemutakhiran/$query_id/$sort_by/$sort_order");
        $config['total_rows'] = $data['num_results'];
        $config['per_page'] = $limit;
        $config['uri_segment'] = 6;
        $config['num_links'] = 6;

        $config = array_merge($config, default_pagination_btn());
        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();
        $data['sort_by'] = $sort_by;
        $data['sort_order'] = $sort_order;

        $data['page_title'] = 'Frekuensi Pemutakhiran';

        $data['tools'] = array(
            'master/frekuensi_pemutakhiran/create' => 'New'
        );

        $this->load->view('master/frekuensi_pemutakhiran', $data);
    }

    function search() {
        $query_array = array(
            'frekuensi_pemutakhiran_kurikulum' => $this->input->post('frekuensi_pemutahiran_kurikulum'),
            'active' => 1
        );
        $query_id = $this->input->save_query($query_array);
        redirect("master/frekuensi_pemutakhiran/view/$query_id");
    }

    function info() {
        $id = $this->uri->segment(3);
        $data['auth'] = $this->auth;
        $criteria = array(
            'm_frekuensi_pemutahiran.id' => $id
        );
        $this->load->model('frekuensi_pemutakhiran_model', 'frekuensi_pemutakhiran');
        $result = $this->frekuensi_pemutakhiran->get_many('', $criteria)->row_array();
        //[debug]echo get_instance()->db->last_query();
        $result_keys = array_keys($result);
        foreach ($result_keys as $result_key) {
            $data[$result_key] = $result[$result_key];
        }

        $data['tools'] = array(
            'master/frekuensi_pemutakhiran' => 'Back',
            'master/frekuensi_pemutakhiran/' . $id . '/edit' => 'Edit',
            'master/frekuensi_pemutakhiran/' . $id . '/delete' => 'Delete'
        );
        $data['page_title'] = 'Detail Frekuensi Pemutakhiran';
        $this->load->view('master/frekuensi_pemutakhiran_info', $data);
    }

    function delete() {
        $id = $this->uri->segment(3);
        $this->crud->use_table('m_frekuensi_pemutahiran');
        $criteria = array('id' => $id);
        $data_in = array(
            'active' => 0,
            'modified_on' => logged_info()->on,
            'modified_by' => logged_info()->by
        );
        $this->crud->update($criteria, $data_in);
        redirect('master/frekuensi_pemutakhiran');
    }

    function create() {
        $data['auth'] = $this->auth;
        $data['action_type'] = __FUNCTION__;
        $master_url = 'master/frekuensi_pemutakhiran/';

        $this->load->library(array('form_validation', 'table'));
        $this->load->helper(array('form', 'snippets'));
        $this->form_validation->set_error_delimiters('<span class="notice">', '</span>');
        if ($this->form_validation->run('frekuensi_pemutakhiran_create') === FALSE) {
            //don't do anything
        } else {
            $this->crud->use_table('m_frekuensi_pemutahiran');
            $data_in = array(
                'frekuensi_pemutahiran_kurikulum' => $this->input->post('frekuensi_pemutahiran_kurikulum'),
                'created_on' => date($this->config->item('log_date_format')),
                'created_by' => logged_info()->on
            );
            /*
              echo '<pre>';
              var_dump($data_in);
              echo '</pre>';
             */
            $created_id = $this->crud->create($data_in);
            redirect('master/frekuensi_pemutakhiran/' . $created_id . '/info');
        }
        $data['action_url'] = $master_url . __FUNCTION__;
        $data['page_title'] = 'Create Frekuensi Pemutakhiran';
        $data['tools'] = array(
            'master/frekuensi_pemutakhiran' => 'Back'
        );

        $this->load->model('frekuensi_pemutakhiran_model', 'frekuensi_pemutakhiran');
        $data = array_merge($data, $this->frekuensi_pemutakhiran->set_default()); //merge dengan arr data dengan default
        $this->load->view('master/frekuensi_pemutakhiran_form', $data);
    }

    function edit() {
        $data['auth'] = $this->auth;
        $data['action_type'] = __FUNCTION__;
        $master_url = 'master/frekuensi_pemutakhiran/';
        $id = $this->uri->segment(3);

        $this->load->library(array('form_validation', 'table'));
        $this->load->helper(array('form', 'snippets'));
        $this->form_validation->set_error_delimiters('<span class="notice">', '</span>');
        if ($this->form_validation->run('frekuensi_pemutakhiran_update') === FALSE) {
            //don't do anything
        } else {
            $this->crud->use_table('m_frekuensi_pemutahiran');
            $criteria = array(
                'id' => $id
            );
            $data_in = array(
                'frekuensi_pemutahiran_kurikulum' => $this->input->post('frekuensi_pemutahiran_kurikulum'),
                'modified_on' => date($this->config->item('log_date_format')),
                'modified_by' => logged_info()->on
            );
            $this->crud->update($criteria, $data_in);
            redirect('master/frekuensi_pemutakhiran/' . $id . '/info');
        }
        $data['action_url'] = $master_url . $id . '/' . __FUNCTION__;
        $data['page_title'] = 'Update Frekuensi Pemutakhiran';
        $data['tools'] = array(
            'master/frekuensi_pemutakhiran' => 'Back'
        );

        $this->crud->use_table('m_frekuensi_pemutahiran');
        $frekuensi_pemutakhiran_data = $this->crud->retrieve(array('id' => $id))->row();

        $this->load->model('frekuensi_pemutakhiran_model', 'frekuensi_pemutakhiran');
        $data = array_merge($data, $this->frekuensi_pemutakhiran->set_default()); //merge dengan arr data dengan default
        $data = array_merge($data, (array) $frekuensi_pemutakhiran_data);
        $this->load->view('master/frekuensi_pemutakhiran_form', $data);
    }

    function unique_frekuensi_pemutahiran_kurikulum($frekuensi_pemutahiran_kurikulum) {
        $this->crud->use_table('m_frekuensi_pemutahiran');
        $frekuensi_pemutakhiran = $this->crud->retrieve(array('frekuensi_pemutahiran_kurikulum' => $frekuensi_pemutahiran_kurikulum))->row();
        if (sizeof($frekuensi_pemutakhiran) > 0) {
            $this->form_validation->set_message(__FUNCTION__, 'Frekuensi Pemutakhiran sudah terdaftar'); //pakai function karena ini harus sama dengan nama function nya
            return FALSE;
        } else {
            return true;
        }
    }

}

?>
