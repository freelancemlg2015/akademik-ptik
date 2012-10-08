<?php

/*
 * Indah
 * Transaksi :  nilai fisik
 * 9/9/2012
 */

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Nilai_fisik extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->helper(array('snippets_helper'));
        $this->load->model('crud_model', 'crud');
    }

    function log_date() {
        return date($this->config->item('log_date_format'));
    }

    function index($query_id = 0, $sort_by = 'id', $sort_order = 'desc', $offset = 0) {
        $this->nilai_fisik($query_id, $sort_by, $sort_order, $offset);
    }

    function nilai_fisik($query_id = 0, $sort_by = 'id', $sort_order = 'desc', $offset = 0) {
        $data_type = $this->input->post('data_type');
        $data['auth'] = $this->auth;
        // pagination
        $limit = 20;
        $this->load->library(array('form_validation', 'table', 'pagination'));
        $this->input->load_query($query_id);
        $query_array = array(
            'nim' => $this->input->get('nim'),
            'nilai_fisik' => $this->input->get('nilai_fisik'),
            'active' => 1
        );

        $this->load->model('nilai_fisik_model', 'nilai_fisik');
        $results = $this->nilai_fisik->search($query_array, $limit, $offset, $sort_by, $sort_order);
        //echo get_instance()->db->last_query();
        $data['results'] = $results['results'];
        $data['num_results'] = $results['num_rows'];

        // pagination
        $config = array();
        $config['base_url'] = site_url("transaction/nilai_fisik/$query_id/$sort_by/$sort_order");
        $config['total_rows'] = $data['num_results'];
        $config['per_page'] = $limit;
        $config['uri_segment'] = 6;
        $config['num_links'] = 6;

        $config = array_merge($config, default_pagination_btn());
        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();
        $data['sort_by'] = $sort_by;
        $data['sort_order'] = $sort_order;

        $data['page_title'] = 'Nilai Fisik';

        $data['tools'] = array(
            'transaction/nilai_fisik/create' => 'New'
        );

        $this->load->view('transaction/nilai_fisik', $data);
    }

    function search() {
        $query_array = array(
            'nim' => $this->input->post('nim'),
            'nilai_fisik' => $this->input->post('nilai_fisik'),
            'active' => 1
        );
        $query_id = $this->input->save_query($query_array);
        redirect("transaction/nilai_fisik/view/$query_id");
    }

    function info() {
        $id = $this->uri->segment(3);
        $data['auth'] = $this->auth;
        $criteria = array(
            't_nilai_fisik.id' => $id
        );
        $this->load->model('nilai_fisik_model', 'nilai_fisik');
        $result = $this->nilai_fisik->get_many('', $criteria)->row_array();
        //[debug]echo get_instance()->db->last_query();
        $result_keys = array_keys($result);
        foreach ($result_keys as $result_key) {
            $data[$result_key] = $result[$result_key];
        }

        $data['tools'] = array(
            'transaction/nilai_fisik' => 'Back',
            'transaction/nilai_fisik/' . $id . '/edit' => 'Edit',
            'transaction/nilai_fisik/' . $id . '/delete' => 'Delete'
        );
        $data['page_title'] = 'Detail Nilai Fisik';
        $this->load->view('transaction/nilai_fisik_info', $data);
    }

    function delete() {
        $id = $this->uri->segment(3);
        $this->crud->use_table('t_nilai_fisik');
        $criteria = array('id' => $id);
        $data_in = array(
            'active' => 0,
            'modified_on' => logged_info()->on,
            'modified_by' => logged_info()->by
        );
        $this->crud->update($criteria, $data_in);
        redirect('transaction/nilai_fisik');
    }

    function create() {
        $data['auth'] = $this->auth;
        $data['action_type'] = __FUNCTION__;
        $master_url = 'transaction/nilai_fisik/';

        $this->load->library(array('form_validation', 'table'));
        $this->load->helper(array('form', 'snippets'));
        $this->form_validation->set_error_delimiters('<span class="notice">', '</span>');
        if ($this->form_validation->run('nilai_fisik_create') === FALSE) {
            //don't do anything
        } else {
            $this->crud->use_table('t_nilai_fisik');
            $data_in = array(
                'mahasiswa_id' => $this->input->post('mahasiswa_id'),
                'nilai_fisik' => $this->input->post('nilai_fisik'),
                'keterangan' => $this->input->post('keterangan'),
                'created_on' => date($this->config->item('log_date_format')),
                'created_by' => logged_info()->on
            );
            /*
              echo '<pre>';
              var_dump($data_in);
              echo '</pre>';
             */
            $created_id = $this->crud->create($data_in);
            redirect('transaction/nilai_fisik/' . $created_id . '/info');
        }
        $data['action_url'] = $master_url . __FUNCTION__;
        $data['page_title'] = 'Create Nilai Fisik';
        $data['tools'] = array(
            'transaction/nilai_fisik' => 'Back'
        );

        $this->load->model('nilai_fisik_model', 'nilai_fisik');
        $data = array_merge($data, $this->nilai_fisik->set_default()); //merge dengan arr data dengan default
        
        $data['nim'] = '';
        
        $this->load->view('transaction/nilai_fisik_form', $data);
    }

    function edit() {
        $data['auth'] = $this->auth;
        $data['action_type'] = __FUNCTION__;
        $master_url = 'transaction/nilai_fisik/';
        $id = $this->uri->segment(3);

        $this->load->library(array('form_validation', 'table'));
        $this->load->helper(array('form', 'snippets'));
        $this->form_validation->set_error_delimiters('<span class="notice">', '</span>');
        if ($this->form_validation->run('nilai_fisik_update') === FALSE) {
            //don't do anything
        } else {
            $this->crud->use_table('t_nilai_fisik');
            $criteria = array(
                'id' => $id
            );
            $data_in = array(
                'mahasiswa_id' => $this->input->post('mahasiswa_id'),
                'nilai_fisik' => $this->input->post('nilai_fisik'),
                'keterangan' => $this->input->post('keterangan'),
                'modified_on' => date($this->config->item('log_date_format')),
                'modified_by' => logged_info()->on
            );
            $this->crud->update($criteria, $data_in);
            redirect('transaction/nilai_fisik/' . $id . '/info');
        }
        $data['action_url'] = $master_url . $id . '/' . __FUNCTION__;
        $data['page_title'] = 'Update Nilai Fisik';
        $data['tools'] = array(
            'transaction/nilai_fisik' => 'Back'
        );

        $this->crud->use_table('t_nilai_fisik');
        $nilai_fisik_data = $this->crud->retrieve(array('id' => $id))->row();

        $this->load->model('nilai_fisik_model', 'nilai_fisik');
        $data = array_merge($data, $this->nilai_fisik->set_default()); //merge dengan arr data dengan default
        $data = array_merge($data, (array) $nilai_fisik_data);
        $this->load->view('transaction/nilai_fisik_form', $data);
    }

    function suggestion() {
        $this->load->model('mahasiswa_model');
        $nim = $this->input->get('nim');
        $terms = array(
            'nim' => $nim
        );
        $this->mahasiswa_model->suggestion($terms);
    }

}

?>
