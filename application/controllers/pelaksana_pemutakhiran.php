<?php

/*
 * Imam Syarifudin
 * Master Kurikulum : Pelaksana Pemutahiran
 * 8/9/2012
 */

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Pelaksana_pemutakhiran extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->helper(array('snippets_helper'));
        $this->load->model('crud_model', 'crud');
    }

    function log_date() {
        return date($this->config->item('log_date_format'));
    }

    function index($query_id = 0, $sort_by = 'id', $sort_order = 'desc', $offset = 0) {
        $this->pelaksana_pemutakhiran($query_id, $sort_by, $sort_order, $offset);
    }

    function pelaksana_pemutakhiran($query_id = 0, $sort_by = 'id', $sort_order = 'desc', $offset = 0) {
        $data_type = $this->input->post('data_type');
        $data['auth'] = $this->auth;
        // pagination
        $limit = 20;
        $this->load->library(array('form_validation', 'table', 'pagination'));
        $this->input->load_query($query_id);
        $query_array = array(
            'pelaksana_pemutahiran' => $this->input->get('pelaksana_pemutahiran'),
            'active' => 1
        );

        $this->load->model('pelaksana_pemutakhiran_model', 'pelaksana_pemutakhiran');
        $results = $this->pelaksana_pemutakhiran->search($query_array, $limit, $offset, $sort_by, $sort_order);
        //echo get_instance()->db->last_query();
        $data['results'] = $results['results'];
        $data['num_results'] = $results['num_rows'];

        // pagination
        $config = array();
        $config['base_url'] = site_url("master/pelaksana_pemutakhiran/$query_id/$sort_by/$sort_order");
        $config['total_rows'] = $data['num_results'];
        $config['per_page'] = $limit;
        $config['uri_segment'] = 6;
        $config['num_links'] = 6;

        $config = array_merge($config, default_pagination_btn());
        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();
        $data['sort_by'] = $sort_by;
        $data['sort_order'] = $sort_order;

        $data['page_title'] = 'Pelaksana Pemutakhiran';

        $data['tools'] = array(
            'master/pelaksana_pemutakhiran/create' => 'New'
        );

        $this->load->view('master/pelaksana_pemutakhiran', $data);
    }

    function search() {
        $query_array = array(
            'pelaksana_pemutahiran' => $this->input->post('pelaksana_pemutahiran'),
            'active' => 1
        );
        $query_id = $this->input->save_query($query_array);
        redirect("master/pelaksana_pemutakhiran/view/$query_id");
    }

    function info() {
        $id = $this->uri->segment(3);
        $data['auth'] = $this->auth;
        $criteria = array(
            'm_pelaksana_pemutahiran.id' => $id
        );
        $this->load->model('pelaksana_pemutakhiran_model', 'pelaksana_pemutakhiran');
        $result = $this->pelaksana_pemutakhiran->get_many('', $criteria)->row_array();
        //[debug]echo get_instance()->db->last_query();
        $result_keys = array_keys($result);
        foreach ($result_keys as $result_key) {
            $data[$result_key] = $result[$result_key];
        }

        $data['tools'] = array(
            'master/pelaksana_pemutakhiran' => 'Back',
            'master/pelaksana_pemutakhiran/' . $id . '/edit' => 'Edit',
            'master/pelaksana_pemutakhiran/' . $id . '/delete' => 'Delete'
        );
        $data['page_title'] = 'Detail Pelaksana Pemutakhiran';
        $this->load->view('master/pelaksana_pemutakhiran_info', $data);
    }

    function delete() {
        $id = $this->uri->segment(3);
        $this->crud->use_table('m_pelaksana_pemutahiran');
        $criteria = array('id' => $id);
        $data_in = array(
            'active' => 0,
            'modified_on' => logged_info()->on,
            'modified_by' => logged_info()->by
        );
        $this->crud->update($criteria, $data_in);
        redirect('master/pelaksana_pemutakhiran');
    }

    function create() {
        $data['auth'] = $this->auth;
        $data['action_type'] = __FUNCTION__;
        $master_url = 'master/pelaksana_pemutakhiran/';

        $this->load->library(array('form_validation', 'table'));
        $this->load->helper(array('form', 'snippets'));
        $this->form_validation->set_error_delimiters('<span class="notice">', '</span>');
        if ($this->form_validation->run('pelaksana_pemutakhiran_create') === FALSE) {
            //don't do anything
        } else {
            $this->crud->use_table('m_pelaksana_pemutahiran');
            $data_in = array(
                'pelaksana_pemutahiran' => $this->input->post('pelaksana_pemutahiran'),
                'created_on' => date($this->config->item('log_date_format')),
                'created_by' => logged_info()->on
            );
            /*
              echo '<pre>';
              var_dump($data_in);
              echo '</pre>';
             */
            $created_id = $this->crud->create($data_in);
            redirect('master/pelaksana_pemutakhiran/' . $created_id . '/info');
        }
        $data['action_url'] = $master_url . __FUNCTION__;
        $data['page_title'] = 'Create Pelaksana Pemutakhiran';
        $data['tools'] = array(
            'master/pelaksana_pemutakhiran' => 'Back'
        );

        $this->load->model('pelaksana_pemutakhiran_model', 'pelaksana_pemutakhiran');
        $data = array_merge($data, $this->pelaksana_pemutakhiran->set_default()); //merge dengan arr data dengan default
        $this->load->view('master/pelaksana_pemutakhiran_form', $data);
    }

    function edit() {
        $data['auth'] = $this->auth;
        $data['action_type'] = __FUNCTION__;
        $master_url = 'master/pelaksana_pemutakhiran/';
        $id = $this->uri->segment(3);

        $this->load->library(array('form_validation', 'table'));
        $this->load->helper(array('form', 'snippets'));
        $this->form_validation->set_error_delimiters('<span class="notice">', '</span>');
        if ($this->form_validation->run('pelaksana_pemutakhiran_update') === FALSE) {
            //don't do anything
        } else {
            $this->crud->use_table('m_pelaksana_pemutahiran');
            $criteria = array(
                'id' => $id
            );
            $data_in = array(
                'pelaksana_pemutahiran' => $this->input->post('pelaksana_pemutahiran'),
                'modified_on' => date($this->config->item('log_date_format')),
                'modified_by' => logged_info()->on
            );
            $this->crud->update($criteria, $data_in);
            redirect('master/pelaksana_pemutakhiran/' . $id . '/info');
        }
        $data['action_url'] = $master_url . $id . '/' . __FUNCTION__;
        $data['page_title'] = 'Update Pelaksana Pemutakhiran';
        $data['tools'] = array(
            'master/pelaksana_pemutakhiran' => 'Back'
        );

        $this->crud->use_table('m_pelaksana_pemutahiran');
        $pelaksana_pemutakhiran_data = $this->crud->retrieve(array('id' => $id))->row();

        $this->load->model('pelaksana_pemutakhiran_model', 'pelaksana_pemutakhiran');
        $data = array_merge($data, $this->pelaksana_pemutakhiran->set_default()); //merge dengan arr data dengan default
        $data = array_merge($data, (array) $pelaksana_pemutakhiran_data);
        $this->load->view('master/pelaksana_pemutakhiran_form', $data);
    }

    function unique_pelaksana_pemutahiran($pelaksana_pemutahiran) {
        $this->crud->use_table('m_pelaksana_pemutahiran');
        $pelaksana_pemutakhiran = $this->crud->retrieve(array('pelaksana_pemutahiran' => $pelaksana_pemutahiran))->row();
        if (sizeof($pelaksana_pemutakhiran) > 0) {
            $this->form_validation->set_message(__FUNCTION__, 'Pelaksana Pemutakhiran sudah terdaftar'); //pakai function karena ini harus sama dengan nama function nya
            return FALSE;
        } else {
            return true;
        }
    }

}

?>
