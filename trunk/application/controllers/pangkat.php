<?php

/*
 * Imam Syarifudin
 * Master Tugas Imam : Pangkat
 * 5/9/2012
 */

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Pangkat extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->helper(array('snippets_helper'));
        $this->load->model('crud_model', 'crud');
    }

    function log_date() {
        return date($this->config->item('log_date_format'));
    }

    function index($query_id = 0, $sort_by = 'id', $sort_order = 'desc', $offset = 0) {
        $this->pangkat($query_id, $sort_by, $sort_order, $offset);
    }

    function pangkat($query_id = 0, $sort_by = 'id', $sort_order = 'desc', $offset = 0) {
        $data_type = $this->input->post('data_type');
        $data['auth'] = $this->auth;
        // pagination
        $limit = 20;
        $this->load->library(array('form_validation', 'table', 'pagination'));
        $this->input->load_query($query_id);
        $query_array = array(
            'kode_pangkat' => $this->input->get('kode_pangkat'),
            'nama_pangkat' => $this->input->get('nama_pangkat'),
            'active' => 1
        );

        $this->load->model('pangkat_model', 'pangkat');
        $results = $this->pangkat->search($query_array, $limit, $offset, $sort_by, $sort_order);
        //echo get_instance()->db->last_query();
        $data['results'] = $results['results'];
        $data['num_results'] = $results['num_rows'];

        // pagination
        $config = array();
        $config['base_url'] = site_url("master/pangkat/$query_id/$sort_by/$sort_order");
        $config['total_rows'] = $data['num_results'];
        $config['per_page'] = $limit;
        $config['uri_segment'] = 6;
        $config['num_links'] = 6;

        $config = array_merge($config, default_pagination_btn());
        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();
        $data['sort_by'] = $sort_by;
        $data['sort_order'] = $sort_order;

        $data['page_title'] = 'Pangkat';

        $data['tools'] = array(
            'master/pangkat/create' => 'New'
        );

        $this->load->view('master/pangkat', $data);
    }

    function search() {
        $query_array = array(
            'kode_pangkat' => $this->input->post('kode_pangkat'),
            'nama_pangkat' => $this->input->post('nama_pangkat'),
            'active' => 1
        );
        $query_id = $this->input->save_query($query_array);
        redirect("master/pangkat/view/$query_id");
    }

    function info() {
        $id = $this->uri->segment(3);
        $data['auth'] = $this->auth;
        $criteria = array(
            'm_pangkat.id' => $id
        );
        $this->load->model('pangkat_model', 'pangkat');
        $result = $this->pangkat->get_many('', $criteria)->row_array();
        //[debug]echo get_instance()->db->last_query();
        $result_keys = array_keys($result);
        foreach ($result_keys as $result_key) {
            $data[$result_key] = $result[$result_key];
        }

        $data['tools'] = array(
            'master/pangkat' => 'Back',
            'master/pangkat/' . $id . '/edit' => 'Edit',
            'master/pangkat/' . $id . '/delete' => 'Delete'
        );
        $data['page_title'] = 'Detail Pangkat';
        $this->load->view('master/pangkat_info', $data);
    }

    function delete() {
        $id = $this->uri->segment(3);
        $this->crud->use_table('m_pangkat');
        $criteria = array('id' => $id);
        $data_in = array(
            'active' => 0,
            'modified_on' => logged_info()->on,
            'modified_by' => logged_info()->by
        );
        $this->crud->update($criteria, $data_in);
        redirect('master/pangkat');
    }

    function create() {
        $data['auth'] = $this->auth;
        $data['action_type'] = __FUNCTION__;
        $master_url = 'master/pangkat/';

        $this->load->library(array('form_validation', 'table'));
        $this->load->helper(array('form', 'snippets'));
        $this->form_validation->set_error_delimiters('<span class="notice">', '</span>');
        if ($this->form_validation->run('pangkat_create') === FALSE) {
            //don't do anything
        } else {
            $this->crud->use_table('m_pangkat');
            $data_in = array(
                'kode_pangkat' => $this->input->post('kode_pangkat'),
                'nama_pangkat' => $this->input->post('nama_pangkat'),
                'created_on' => date($this->config->item('log_date_format')),
                'created_by' => logged_info()->on
            );
            /*
              echo '<pre>';
              var_dump($data_in);
              echo '</pre>';
             */
            $created_id = $this->crud->create($data_in);
            redirect('master/pangkat/' . $created_id . '/info');
        }
        $data['action_url'] = $master_url . __FUNCTION__;
        $data['page_title'] = 'Create Pangkat';
        $data['tools'] = array(
            'master/pangkat' => 'Back'
        );

        $this->load->model('pangkat_model', 'pangkat');
        $data = array_merge($data, $this->pangkat->set_default()); //merge dengan arr data dengan default
        $this->load->view('master/pangkat_form', $data);
    }

    function edit() {
        $data['auth'] = $this->auth;
        $data['action_type'] = __FUNCTION__;
        $master_url = 'master/pangkat/';
        $id = $this->uri->segment(3);

        $this->load->library(array('form_validation', 'table'));
        $this->load->helper(array('form', 'snippets'));
        $this->form_validation->set_error_delimiters('<span class="notice">', '</span>');
        if ($this->form_validation->run('pangkat_update') === FALSE) {
            //don't do anything
        } else {
            $this->crud->use_table('m_pangkat');
            $criteria = array(
                'id' => $id
            );
            $data_in = array(
                'kode_pangkat' => $this->input->post('kode_pangkat'),
                'nama_pangkat' => $this->input->post('nama_pangkat'),
                'modified_on' => date($this->config->item('log_date_format')),
                'modified_by' => logged_info()->on
            );
            $this->crud->update($criteria, $data_in);
            redirect('master/pangkat/' . $id . '/info');
        }
        $data['action_url'] = $master_url . $id . '/' . __FUNCTION__;
        $data['page_title'] = 'Update Pangkat';
        $data['tools'] = array(
            'master/pangkat' => 'Back'
        );

        $this->crud->use_table('m_pangkat');
        $angkatan_data = $this->crud->retrieve(array('id' => $id))->row();

        $this->load->model('pangkat_model', 'pangkat');
        $data = array_merge($data, $this->pangkat->set_default()); //merge dengan arr data dengan default
        $data = array_merge($data, (array) $angkatan_data);
        $this->load->view('master/pangkat_form', $data);
    }

    function unique_kode_pangkat($kode_pangkat) {
        $this->crud->use_table('m_pangkat');
        $pangkat = $this->crud->retrieve(array('kode_pangkat' => $kode_pangkat))->row();
        if (sizeof($pangkat) > 0) {
            $this->form_validation->set_message(__FUNCTION__, 'Kode Pangkat sudah terdaftar'); //pakai function karena ini harus sama dengan nama function nya
            return FALSE;
        } else {
            return true;
        }
    }
    
    function suggestion() {
        $this->load->model('pangkat_model');
        $kode_pangkat = $this->input->get('kode_pangkat');
        $terms = array(
            'kode_pangkat' => $kode_pangkat
        );
        $this->pangkat_model->suggestion($terms);
    }

}

?>
