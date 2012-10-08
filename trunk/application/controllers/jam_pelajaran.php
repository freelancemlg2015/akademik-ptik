<?php

/*
 * Imam Syarifudin
 * Master Perkuliahan : Jam Pelajaran
 * 5/9/2012
 */

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Jam_pelajaran extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->helper(array('snippets_helper'));
        $this->load->model('crud_model', 'crud');
    }

    function log_date() {
        return date($this->config->item('log_date_format'));
    }

    function index($query_id = 0, $sort_by = 'id', $sort_order = 'desc', $offset = 0) {
        $this->jam_pelajaran($query_id, $sort_by, $sort_order, $offset);
    }

    function jam_pelajaran($query_id = 0, $sort_by = 'id', $sort_order = 'desc', $offset = 0) {
        $data_type = $this->input->post('data_type');
        $data['auth'] = $this->auth;
        // pagination
        $limit = 20;
        $this->load->library(array('form_validation', 'table', 'pagination'));
        $this->input->load_query($query_id);
        $query_array = array(
            'kode_jam' => $this->input->get('kode_jam'),
            'jam_normal' => $this->input->get('jam_normal'),
            'jam_puasa' => $this->input->get('jam_puasa'),
            'active' => 1
        );

        $this->load->model('jam_pelajaran_model', 'jam_pelajaran');
        $results = $this->jam_pelajaran->search($query_array, $limit, $offset, $sort_by, $sort_order);
        //echo get_instance()->db->last_query();
        $data['results'] = $results['results'];
        $data['num_results'] = $results['num_rows'];

        // pagination
        $config = array();
        $config['base_url'] = site_url("master/jam_pelajaran/$query_id/$sort_by/$sort_order");
        $config['total_rows'] = $data['num_results'];
        $config['per_page'] = $limit;
        $config['uri_segment'] = 6;
        $config['num_links'] = 6;

        $config = array_merge($config, default_pagination_btn());
        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();
        $data['sort_by'] = $sort_by;
        $data['sort_order'] = $sort_order;

        $data['page_title'] = 'Jam Pelajaran';

        $data['tools'] = array(
            'master/jam_pelajaran/create' => 'New'
        );

        $this->load->view('master/jam_pelajaran', $data);
    }

    function search() {
        $query_array = array(
            'kode_jam' => $this->input->post('kode_jam'),
            'jam_normal' => $this->input->post('jam_normal'),
            'jam_puasa' => $this->input->post('jam_puasa'),
            'active' => 1
        );
        $query_id = $this->input->save_query($query_array);
        redirect("master/jam_pelajaran/view/$query_id");
    }

    function info() {
        $id = $this->uri->segment(3);
        $data['auth'] = $this->auth;
        $criteria = array(
            'm_jam_pelajaran.id' => $id
        );
        $this->load->model('jam_pelajaran_model', 'jam_pelajaran');
        $result = $this->jam_pelajaran->get_many('', $criteria)->row_array();
        //[debug]echo get_instance()->db->last_query();
        $result_keys = array_keys($result);
        foreach ($result_keys as $result_key) {
            $data[$result_key] = $result[$result_key];
        }

        $data['tools'] = array(
            'master/jam_pelajaran' => 'Back',
            'master/jam_pelajaran/' . $id . '/edit' => 'Edit',
            'master/jam_pelajaran/' . $id . '/delete' => 'Delete'
        );
        $data['page_title'] = 'Detail Jam Pelajaran';
        $this->load->view('master/jam_pelajaran_info', $data);
    }

    function delete() {
        $id = $this->uri->segment(3);
        $this->crud->use_table('m_jam_pelajaran');
        $criteria = array('id' => $id);
        $data_in = array(
            'active' => 0,
            'modified_on' => logged_info()->on,
            'modified_by' => logged_info()->by
        );
        $this->crud->update($criteria, $data_in);
        redirect('master/jam_pelajaran');
    }

    function create() {
        $data['auth'] = $this->auth;
        $data['action_type'] = __FUNCTION__;
        $master_url = 'master/jam_pelajaran/';

        $this->load->library(array('form_validation', 'table'));
        $this->load->helper(array('form', 'snippets'));
        $this->form_validation->set_error_delimiters('<span class="notice">', '</span>');
        if ($this->form_validation->run('jam_pelajaran_create') === FALSE) {
            //don't do anything
        } else {
            $this->crud->use_table('m_jam_pelajaran');
            $data_in = array(
                'kode_jam' => $this->input->post('kode_jam'),
                'jam_normal' => $this->input->post('jam_normal'),
                'jam_puasa' => $this->input->post('jam_puasa'),
                'created_on' => date($this->config->item('log_date_format')),
                'created_by' => logged_info()->on
            );
            /*
              echo '<pre>';
              var_dump($data_in);
              echo '</pre>';
             */
            $created_id = $this->crud->create($data_in);
            redirect('master/jam_pelajaran/' . $created_id . '/info');
        }
        $data['action_url'] = $master_url . __FUNCTION__;
        $data['page_title'] = 'Create Jam Pelajaran';
        $data['tools'] = array(
            'master/jam_pelajaran' => 'Back'
        );

        $this->load->model('jam_pelajaran_model', 'jam_pelajaran');
        $data = array_merge($data, $this->jam_pelajaran->set_default()); //merge dengan arr data dengan default
        $this->load->view('master/jam_pelajaran_form', $data);
    }

    function edit() {
        $data['auth'] = $this->auth;
        $data['action_type'] = __FUNCTION__;
        $master_url = 'master/jam_pelajaran/';
        $id = $this->uri->segment(3);

        $this->load->library(array('form_validation', 'table'));
        $this->load->helper(array('form', 'snippets'));
        $this->form_validation->set_error_delimiters('<span class="notice">', '</span>');
        if ($this->form_validation->run('jam_pelajaran_update') === FALSE) {
            //don't do anything
        } else {
            $this->crud->use_table('m_jam_pelajaran');
            $criteria = array(
                'id' => $id
            );
            $data_in = array(
                'kode_jam' => $this->input->post('kode_jam'),
                'jam_normal' => $this->input->post('jam_normal'),
                'jam_puasa' => $this->input->post('jam_puasa'),
                'modified_on' => date($this->config->item('log_date_format')),
                'modified_by' => logged_info()->on
            );
            $this->crud->update($criteria, $data_in);
            redirect('master/jam_pelajaran/' . $id . '/info');
        }
        $data['action_url'] = $master_url . $id . '/' . __FUNCTION__;
        $data['page_title'] = 'Update Jam Pelajaran';
        $data['tools'] = array(
            'master/jam_pelajaran' => 'Back'
        );

        $this->crud->use_table('m_jam_pelajaran');
        $jam_pelajaran_data = $this->crud->retrieve(array('id' => $id))->row();

        $this->load->model('jam_pelajaran_model', 'jam_pelajaran');
        $data = array_merge($data, $this->jam_pelajaran->set_default()); //merge dengan arr data dengan default
        $data = array_merge($data, (array) $jam_pelajaran_data);
        $this->load->view('master/jam_pelajaran_form', $data);
    }

    function unique_jode_jam($kode_jam) {
        $this->crud->use_table('m_jam_pelajaran');
        $jam_pelajaran = $this->crud->retrieve(array('kode_jam' => $kode_jam))->row();
        if (sizeof($jam_pelajaran) > 0) {
            $this->form_validation->set_message(__FUNCTION__, 'Kode Jam sudah terdaftar'); //pakai function karena ini harus sama dengan nama function nya
            return FALSE;
        } else {
            return true;
        }
    }

}

?>
