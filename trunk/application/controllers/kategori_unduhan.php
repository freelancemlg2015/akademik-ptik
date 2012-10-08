<?php

/*
 * Fachrul Rozi
 * Master Lain lain : Kategori Unduhan
 * 6/9/2012
 */

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Kategori_unduhan extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->helper(array('snippets_helper'));
        $this->load->model('crud_model', 'crud');
    }

    function log_date() {
        return date($this->config->item('log_date_format'));
    }

    function index($query_id = 0, $sort_by = 'id', $sort_order = 'desc', $offset = 0) {
        $this->kategori_unduhan($query_id, $sort_by, $sort_order, $offset);
    }

    function kategori_unduhan($query_id = 0, $sort_by = 'id', $sort_order = 'desc', $offset = 0) {
        $data_type = $this->input->post('data_type');
        $data['auth'] = $this->auth;
        // pagination
        $limit = 20;
        $this->load->library(array('form_validation', 'table', 'pagination'));
        $this->input->load_query($query_id);
        $query_array = array(
            'kategori_unduhan' => $this->input->get('kategori_unduhan'),
            'active' => 1
        );

        $this->load->model('kategori_unduhan_model', 'kategori_unduhan');
        $results = $this->kategori_unduhan->search($query_array, $limit, $offset, $sort_by, $sort_order);
        //echo get_instance()->db->last_query();
        $data['results'] = $results['results'];
        $data['num_results'] = $results['num_rows'];

        // pagination
        $config = array();
        $config['base_url'] = site_url("master/kategori_unduhan/$query_id/$sort_by/$sort_order");
        $config['total_rows'] = $data['num_results'];
        $config['per_page'] = $limit;
        $config['uri_segment'] = 6;
        $config['num_links'] = 6;

        $config = array_merge($config, default_pagination_btn());
        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();
        $data['sort_by'] = $sort_by;
        $data['sort_order'] = $sort_order;

        $data['page_title'] = 'Kategori Unduhan';

        $data['tools'] = array(
            'master/kategori_unduhan/create' => 'New'
        );

        $this->load->view('master/kategori_unduhan', $data);
    }

    function search() {
        $query_array = array(
            'kategori_unduhan' => $this->input->post('kategori_unduhan'),
            'active' => 1
        );
        $query_id = $this->input->save_query($query_array);
        redirect("master/kategori_unduhan/view/$query_id");
    }

    function info() {
        $id = $this->uri->segment(3);
        $data['auth'] = $this->auth;
        $criteria = array(
            'm_kategori_unduhan.id' => $id
        );
        $this->load->model('kategori_unduhan_model', 'kategori_unduhan');
        $result = $this->kategori_unduhan->get_many('', $criteria)->row_array();
        //[debug]echo get_instance()->db->last_query();
        $result_keys = array_keys($result);
        foreach ($result_keys as $result_key) {
            $data[$result_key] = $result[$result_key];
        }

        $data['tools'] = array(
            'master/kategori_unduhan' => 'Back',
            'master/kategori_unduhan/' . $id . '/edit' => 'Edit',
            'master/kategori_unduhan/' . $id . '/delete' => 'Delete'
        );
        $data['page_title'] = 'Detail Kategori Unduhan';
        $this->load->view('master/kategori_unduhan_info', $data);
    }

    function delete() {
        $id = $this->uri->segment(3);
        $this->crud->use_table('m_kategori_unduhan');
        $criteria = array('id' => $id);
        $data_in = array(
            'active' => 0,
            'modified_on' => logged_info()->on,
            'modified_by' => logged_info()->by
        );
        $this->crud->update($criteria, $data_in);
        redirect('master/kategori_unduhan');
    }

    function create() {
        $data['auth'] = $this->auth;
        $data['action_type'] = __FUNCTION__;
        $master_url = 'master/kategori_unduhan/';

        $this->load->library(array('form_validation', 'table'));
        $this->load->helper(array('form', 'snippets'));
        $this->form_validation->set_error_delimiters('<span class="notice">', '</span>');
        if ($this->form_validation->run('kategori_unduhan_create') === FALSE) {
            //don't do anything
        } else {
            $this->crud->use_table('m_kategori_unduhan');
            $data_in = array(
                'kategori_unduhan' => $this->input->post('kategori_unduhan'),
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
            redirect('master/kategori_unduhan/' . $created_id . '/info');
        }
        $data['action_url'] = $master_url . __FUNCTION__;
        $data['page_title'] = 'Create Kategori Unduhan';
        $data['tools'] = array(
            'master/kategori_unduhan' => 'Back'
        );

        $this->load->model('kategori_unduhan_model', 'kategori_unduhan');
        $data = array_merge($data, $this->kategori_unduhan->set_default()); //merge dengan arr data dengan default
        $this->load->view('master/kategori_unduhan_form', $data);
    }

    function edit() {
        $data['auth'] = $this->auth;
        $data['action_type'] = __FUNCTION__;
        $master_url = 'master/kategori_unduhan/';
        $id = $this->uri->segment(3);

        $this->load->library(array('form_validation', 'table'));
        $this->load->helper(array('form', 'snippets'));
        $this->form_validation->set_error_delimiters('<span class="notice">', '</span>');
        if ($this->form_validation->run('kategori_unduhan_update') === FALSE) {
            //don't do anything
        } else {
            $this->crud->use_table('m_kategori_unduhan');
            $criteria = array(
                'id' => $id
            );
            $data_in = array(
                'kategori_unduhan' => $this->input->post('kategori_unduhan'),
                'keterangan' => $this->input->post('keterangan'),
                'modified_on' => date($this->config->item('log_date_format')),
                'modified_by' => logged_info()->on
            );
            $this->crud->update($criteria, $data_in);
            redirect('master/kategori_unduhan/' . $id . '/info');
        }
        $data['action_url'] = $master_url . $id . '/' . __FUNCTION__;
        $data['page_title'] = 'Update Kategori Unduhan';
        $data['tools'] = array(
            'master/kategori_unduhan' => 'Back'
        );

        $this->crud->use_table('m_kategori_unduhan');
        $kategori_unduhan_data = $this->crud->retrieve(array('id' => $id))->row();

        $this->load->model('kategori_unduhan_model', 'kategori_unduhan');
        $data = array_merge($data, $this->kategori_unduhan->set_default()); //merge dengan arr data dengan default
        $data = array_merge($data, (array) $kategori_unduhan_data);
        $this->load->view('master/kategori_unduhan_form', $data);
    }

    function unique_kategori_unduhan($kategori_unduhan) {
        $this->crud->use_table('m_kategori_unduhan');
        $kategori_unduhan = $this->crud->retrieve(array('kategori_unduhan' => $kategori_unduhan))->row();
        if (sizeof($kategori_unduhan) > 0) {
            $this->form_validation->set_message(__FUNCTION__, 'Kategori Unduhan Kuliah sudah terdaftar'); //pakai function karena ini harus sama dengan nama function nya
            return FALSE;
        } else {
            return true;
        }
    }

}

?>
