<?php

/*
 * Imam Syarifudin
 * Master Kurikulum : BOBOT NILAI
 * 7/9/2012
 */

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Bobot_nilai extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->helper(array('snippets_helper'));
        $this->load->model('crud_model', 'crud');
    }

    function log_date() {
        return date($this->config->item('log_date_format'));
    }

    function index($query_id = 0, $sort_by = 'id', $sort_order = 'desc', $offset = 0) {
        $this->bobot_nilai($query_id, $sort_by, $sort_order, $offset);
    }

    function bobot_nilai($query_id = 0, $sort_by = 'id', $sort_order = 'desc', $offset = 0) {
        $data_type = $this->input->post('data_type');
        $data['auth'] = $this->auth;
        // pagination
        $limit = 20;
        $this->load->library(array('form_validation', 'table', 'pagination'));
        $this->input->load_query($query_id);
        $query_array = array(
            'kode_bobot_nilai' => $this->input->get('kode_bobot_nilai'),
            'keterangan_nilai' => $this->input->get('keterangan_nilai'),
            'active' => 1
        );

        $this->load->model('bobot_nilai_model', 'bobot_nilai');
        $results = $this->bobot_nilai->search($query_array, $limit, $offset, $sort_by, $sort_order);
        //echo get_instance()->db->last_query();
        $data['results'] = $results['results'];
        $data['num_results'] = $results['num_rows'];

        // pagination
        $config = array();
        $config['base_url'] = site_url("master/bobot_nilai/$query_id/$sort_by/$sort_order");
        $config['total_rows'] = $data['num_results'];
        $config['per_page'] = $limit;
        $config['uri_segment'] = 6;
        $config['num_links'] = 6;

        $config = array_merge($config, default_pagination_btn());
        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();
        $data['sort_by'] = $sort_by;
        $data['sort_order'] = $sort_order;

        $data['page_title'] = 'Bobot Nilai';

        $data['tools'] = array(
            'master/bobot_nilai/create' => 'New'
        );

        $this->load->view('master/bobot_nilai', $data);
    }

    function search() {
        $query_array = array(
            'kode_bobot_nilai' => $this->input->post('kode_bobot_nilai'),
            'keterangan_nilai' => $this->input->post('keterangan_nilai'),
            'active' => 1
        );
        $query_id = $this->input->save_query($query_array);
        redirect("master/bobot_nilai/view/$query_id");
    }

    function info() {
        $id = $this->uri->segment(3);
        $data['auth'] = $this->auth;
        $criteria = array(
            'm_bobot_nilai.id' => $id
        );
        $this->load->model('bobot_nilai_model', 'bobot_nilai');
        $result = $this->bobot_nilai->get_many('', $criteria)->row_array();
        //[debug]echo get_instance()->db->last_query();
        $result_keys = array_keys($result);
        foreach ($result_keys as $result_key) {
            $data[$result_key] = $result[$result_key];
        }

        $data['tools'] = array(
            'master/bobot_nilai' => 'Back',
            'master/bobot_nilai/' . $id . '/edit' => 'Edit',
            'master/bobot_nilai/' . $id . '/delete' => 'Delete'
        );
        $data['page_title'] = 'Detail Bobot Nilai';
        $this->load->view('master/bobot_nilai_info', $data);
    }

    function delete() {
        $id = $this->uri->segment(3);
        $this->crud->use_table('m_bobot_nilai');
        $criteria = array('id' => $id);
        $data_in = array(
            'active' => 0,
            'modified_on' => logged_info()->on,
            'modified_by' => logged_info()->by
        );
        $this->crud->update($criteria, $data_in);
        redirect('master/bobot_nilai');
    }

    function create() {
        $data['auth'] = $this->auth;
        $data['action_type'] = __FUNCTION__;
        $master_url = 'master/bobot_nilai/';

        $this->load->library(array('form_validation', 'table'));
        $this->load->helper(array('form', 'snippets'));
        $this->form_validation->set_error_delimiters('<span class="notice">', '</span>');
        if ($this->form_validation->run('bobot_nilai_create') === FALSE) {
            //don't do anything
        } else {
            $this->crud->use_table('m_bobot_nilai');
            $data_in = array(
                'kode_bobot_nilai' => $this->input->post('kode_bobot_nilai'),
                'keterangan_nilai' => $this->input->post('keterangan_nilai'),
                'created_on' => date($this->config->item('log_date_format')),
                'created_by' => logged_info()->on
            );
            /*
              echo '<pre>';
              var_dump($data_in);
              echo '</pre>';
             */
            $created_id = $this->crud->create($data_in);
            redirect('master/bobot_nilai/' . $created_id . '/info');
        }
        $data['action_url'] = $master_url . __FUNCTION__;
        $data['page_title'] = 'Create Bobot Nilai';
        $data['tools'] = array(
            'master/bobot_nilai' => 'Back'
        );

        $this->load->model('bobot_nilai_model', 'bobot_nilai');
        $data = array_merge($data, $this->bobot_nilai->set_default()); //merge dengan arr data dengan default
        $this->load->view('master/bobot_nilai_form', $data);
    }

    function edit() {
        $data['auth'] = $this->auth;
        $data['action_type'] = __FUNCTION__;
        $master_url = 'master/bobot_nilai/';
        $id = $this->uri->segment(3);

        $this->load->library(array('form_validation', 'table'));
        $this->load->helper(array('form', 'snippets'));
        $this->form_validation->set_error_delimiters('<span class="notice">', '</span>');
        if ($this->form_validation->run('bobot_nilai_update') === FALSE) {
            //don't do anything
        } else {
            $this->crud->use_table('m_bobot_nilai');
            $criteria = array(
                'id' => $id
            );
            $data_in = array(
                'kode_bobot_nilai' => $this->input->post('kode_bobot_nilai'),
                'keterangan_nilai' => $this->input->post('keterangan_nilai'),
                'modified_on' => date($this->config->item('log_date_format')),
                'modified_by' => logged_info()->on
            );
            $this->crud->update($criteria, $data_in);
            redirect('master/bobot_nilai/' . $id . '/info');
        }
        $data['action_url'] = $master_url . $id . '/' . __FUNCTION__;
        $data['page_title'] = 'Update Bobot Nilai';
        $data['tools'] = array(
            'master/bobot_nilai' => 'Back'
        );

        $this->crud->use_table('m_bobot_nilai');
        $bobot_nilai_data = $this->crud->retrieve(array('id' => $id))->row();

        $this->load->model('bobot_nilai_model', 'bobot_nilai');
        $data = array_merge($data, $this->bobot_nilai->set_default()); //merge dengan arr data dengan default
        $data = array_merge($data, (array) $bobot_nilai_data);
        $this->load->view('master/bobot_nilai_form', $data);
    }

    function unique_kode_bobot_nilai($kode_bobot_nilai) {
        $this->crud->use_table('m_bobot_nilai');
        $bobot_nilai = $this->crud->retrieve(array('kode_bobot_nilai' => $kode_bobot_nilai))->row();
        if (sizeof($bobot_nilai) > 0) {
            $this->form_validation->set_message(__FUNCTION__, 'Kode Bobot Nilai sudah terdaftar'); //pakai function karena ini harus sama dengan nama function nya
            return FALSE;
        } else {
            return true;
        }
    }

}

?>
