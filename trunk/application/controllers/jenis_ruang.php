<?php

/*
 * Imam Syarifudin
 * Master Perkuliahan : Jenis Ruang
 * 5/9/2012
 */

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Jenis_ruang extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->helper(array('snippets_helper'));
        $this->load->model('crud_model', 'crud');
    }

    function log_date() {
        return date($this->config->item('log_date_format'));
    }

    function index($query_id = 0, $sort_by = 'id', $sort_order = 'desc', $offset = 0) {
        $this->jenis_ruang($query_id, $sort_by, $sort_order, $offset);
    }

    function jenis_ruang($query_id = 0, $sort_by = 'id', $sort_order = 'desc', $offset = 0) {
        $data_type = $this->input->post('data_type');
        $data['auth'] = $this->auth;
        // pagination
        $limit = 20;
        $this->load->library(array('form_validation', 'table', 'pagination'));
        $this->input->load_query($query_id);
        $query_array = array(
            'jenis_ruang' => $this->input->get('jenis_ruang'),
            'active' => 1
        );

        $this->load->model('jenis_ruang_model', 'jenis_ruang');
        $results = $this->jenis_ruang->search($query_array, $limit, $offset, $sort_by, $sort_order);
        //echo get_instance()->db->last_query();
        $data['results'] = $results['results'];
        $data['num_results'] = $results['num_rows'];

        // pagination
        $config = array();
        $config['base_url'] = site_url("master/jenis_ruang/$query_id/$sort_by/$sort_order");
        $config['total_rows'] = $data['num_results'];
        $config['per_page'] = $limit;
        $config['uri_segment'] = 6;
        $config['num_links'] = 6;

        $config = array_merge($config, default_pagination_btn());
        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();
        $data['sort_by'] = $sort_by;
        $data['sort_order'] = $sort_order;

        $data['page_title'] = 'Jenis Ruang';

        $data['tools'] = array(
            'master/jenis_ruang/create' => 'New'
        );

        $this->load->view('master/jenis_ruang', $data);
    }

    function search() {
        $query_array = array(
            'jenis_ruang' => $this->input->post('jenis_ruang'),
            'active' => 1
        );
        $query_id = $this->input->save_query($query_array);
        redirect("master/jenis_ruang/view/$query_id");
    }

    function info() {
        $id = $this->uri->segment(3);
        $data['auth'] = $this->auth;
        $criteria = array(
            'm_jenis_ruang.id' => $id
        );
        $this->load->model('jenis_ruang_model', 'jenis_ruang');
        $result = $this->jenis_ruang->get_many('', $criteria)->row_array();
        //[debug]echo get_instance()->db->last_query();
        $result_keys = array_keys($result);
        foreach ($result_keys as $result_key) {
            $data[$result_key] = $result[$result_key];
        }

        $data['tools'] = array(
            'master/jenis_ruang' => 'Back',
            'master/jenis_ruang/' . $id . '/edit' => 'Edit',
            'master/jenis_ruang/' . $id . '/delete' => 'Delete'
        );
        $data['page_title'] = 'Detail Jenis Ruang';
        $this->load->view('master/jenis_ruang_info', $data);
    }

    function delete() {
        $id = $this->uri->segment(3);
        $this->crud->use_table('m_jenis_ruang');
        $criteria = array('id' => $id);
        $data_in = array(
            'active' => 0,
            'modified_on' => logged_info()->on,
            'modified_by' => logged_info()->by
        );
        $this->crud->update($criteria, $data_in);
        redirect('master/jenis_ruang');
    }

    function create() {
        $data['auth'] = $this->auth;
        $data['action_type'] = __FUNCTION__;
        $master_url = 'master/jenis_ruang/';

        $this->load->library(array('form_validation', 'table'));
        $this->load->helper(array('form', 'snippets'));
        $this->form_validation->set_error_delimiters('<span class="notice">', '</span>');
        if ($this->form_validation->run('jenis_ruang_create') === FALSE) {
            //don't do anything
        } else {
            $this->crud->use_table('m_jenis_ruang');
            $data_in = array(
                'jenis_ruang' => $this->input->post('jenis_ruang'),
                'created_on' => date($this->config->item('log_date_format')),
                'created_by' => logged_info()->on
            );
            /*
              echo '<pre>';
              var_dump($data_in);
              echo '</pre>';
             */
            $created_id = $this->crud->create($data_in);
            redirect('master/jenis_ruang/' . $created_id . '/info');
        }
        $data['action_url'] = $master_url . __FUNCTION__;
        $data['page_title'] = 'Create Jenis Ruang';
        $data['tools'] = array(
            'master/jenis_ruang' => 'Back'
        );

        $this->load->model('jenis_ruang_model', 'jenis_ruang');
        $data = array_merge($data, $this->jenis_ruang->set_default()); //merge dengan arr data dengan default
        $this->load->view('master/jenis_ruang_form', $data);
    }

    function edit() {
        $data['auth'] = $this->auth;
        $data['action_type'] = __FUNCTION__;
        $master_url = 'master/jenis_ruang/';
        $id = $this->uri->segment(3);

        $this->load->library(array('form_validation', 'table'));
        $this->load->helper(array('form', 'snippets'));
        $this->form_validation->set_error_delimiters('<span class="notice">', '</span>');
        if ($this->form_validation->run('jenis_ruang_update') === FALSE) {
            //don't do anything
        } else {
            $this->crud->use_table('m_jenis_ruang');
            $criteria = array(
                'id' => $id
            );
            $data_in = array(
                'jenis_ruang' => $this->input->post('jenis_ruang'),
                'modified_on' => date($this->config->item('log_date_format')),
                'modified_by' => logged_info()->on
            );
            $this->crud->update($criteria, $data_in);
            redirect('master/jenis_ruang/' . $id . '/info');
        }
        $data['action_url'] = $master_url . $id . '/' . __FUNCTION__;
        $data['page_title'] = 'Update Jenis Ruang';
        $data['tools'] = array(
            'master/jenis_ruang' => 'Back'
        );

        $this->crud->use_table('m_jenis_ruang');
        $jenis_ruang_data = $this->crud->retrieve(array('id' => $id))->row();

        $this->load->model('jenis_ruang_model', 'jenis_ruang');
        $data = array_merge($data, $this->jenis_ruang->set_default()); //merge dengan arr data dengan default
        $data = array_merge($data, (array) $jenis_ruang_data);
        $this->load->view('master/jenis_ruang_form', $data);
    }

    function unique_jenis_ruang($jenis_ruang) {
        $this->crud->use_table('m_jenis_ruang');
        $jenis_ruang = $this->crud->retrieve(array('jenis_ruang' => $jenis_ruang))->row();
        if (sizeof($jenis_ruang) > 0) {
            $this->form_validation->set_message(__FUNCTION__, 'Jenis ruang sudah terdaftar'); //pakai function karena ini harus sama dengan nama function nya
            return FALSE;
        } else {
            return true;
        }
    }

}

?>
