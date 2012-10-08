<?php

/*
 * Fachrul Rozi
 * Master Informasi : KATEGORY BERITA
 * 5/9/2012
 */

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Kategori_berita extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->helper(array('snippets_helper'));
        $this->load->model('crud_model', 'crud');
    }

    function log_date() {
        return date($this->config->item('log_date_format'));
    }

    function index($query_id = 0, $sort_by = 'id', $sort_order = 'desc', $offset = 0) {
        $this->kategori_berita($query_id, $sort_by, $sort_order, $offset);
    }

    function kategori_berita($query_id = 0, $sort_by = 'id', $sort_order = 'desc', $offset = 0) {
        $data_type = $this->input->post('data_type');
        $data['auth'] = $this->auth;
        // pagination
        $limit = 20;
        $this->load->library(array('form_validation', 'table', 'pagination'));
        $this->input->load_query($query_id);
        $query_array = array(
            'kategori_berita' => $this->input->get('kategori_berita'),
            'active' => 1
        );

        $this->load->model('kategori_berita_model', 'kategori_berita');
        $results = $this->kategori_berita->search($query_array, $limit, $offset, $sort_by, $sort_order);
        //echo get_instance()->db->last_query();
        $data['results'] = $results['results'];
        $data['num_results'] = $results['num_rows'];

        // pagination
        $config = array();
        $config['base_url'] = site_url("master/kategori_berita/$query_id/$sort_by/$sort_order");
        $config['total_rows'] = $data['num_results'];
        $config['per_page'] = $limit;
        $config['uri_segment'] = 6;
        $config['num_links'] = 6;

        $config = array_merge($config, default_pagination_btn());
        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();
        $data['sort_by'] = $sort_by;
        $data['sort_order'] = $sort_order;

        $data['page_title'] = 'Kategori Berita';

        $data['tools'] = array(
            'master/kategori_berita/create' => 'New'
        );

        $this->load->view('master/kategori_berita', $data);
    }

    function search() {
        $query_array = array(
            'kategori_berita' => $this->input->post('kategori_berita'),
            'active' => 1
        );
        $query_id = $this->input->save_query($query_array);
        redirect("master/kategori_berita/view/$query_id");
    }

    function info() {
        $id = $this->uri->segment(3);
        $data['auth'] = $this->auth;
        $criteria = array(
            'm_kategori_berita.id' => $id
        );
        $this->load->model('kategori_berita_model', 'kategori_berita');
        $result = $this->kategori_berita->get_many('', $criteria)->row_array();
        //[debug]echo get_instance()->db->last_query();
        $result_keys = array_keys($result);
        foreach ($result_keys as $result_key) {
            $data[$result_key] = $result[$result_key];
        }

        $data['tools'] = array(
            'master/kategori_berita' => 'Back',
            'master/kategori_berita/' . $id . '/edit' => 'Edit',
            'master/kategori_berita/' . $id . '/delete' => 'Delete'
        );
        $data['page_title'] = 'Detail Kategori Berita';
        $this->load->view('master/kategori_berita_info', $data);
    }

    function delete() {
        $id = $this->uri->segment(3);
        $this->crud->use_table('m_kategori_berita');
        $criteria = array('id' => $id);
        $data_in = array(
            'active' => 0,
            'modified_on' => logged_info()->on,
            'modified_by' => logged_info()->by
        );
        $this->crud->update($criteria, $data_in);
        redirect('master/kategori_berita');
    }

    function create() {
        $data['auth'] = $this->auth;
        $data['action_type'] = __FUNCTION__;
        $master_url = 'master/kategori_berita/';

        $this->load->library(array('form_validation', 'table'));
        $this->load->helper(array('form', 'snippets'));
        $this->form_validation->set_error_delimiters('<span class="notice">', '</span>');
        if ($this->form_validation->run('kategori_berita_create') === FALSE) {
            //don't do anything
        } else {
            $this->crud->use_table('m_kategori_berita');
            $data_in = array(
                'kategori_berita' => $this->input->post('kategori_berita'),
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
            redirect('master/kategori_berita/' . $created_id . '/info');
        }
        $data['action_url'] = $master_url . __FUNCTION__;
        $data['page_title'] = 'Create Kategori Berita';
        $data['tools'] = array(
            'master/kategori_berita' => 'Back'
        );

        $this->load->model('kategori_berita_model', 'kategori_berita');
        $data = array_merge($data, $this->kategori_berita->set_default()); //merge dengan arr data dengan default
        $this->load->view('master/kategori_berita_form', $data);
    }

    function edit() {
        $data['auth'] = $this->auth;
        $data['action_type'] = __FUNCTION__;
        $master_url = 'master/kategori_berita/';
        $id = $this->uri->segment(3);

        $this->load->library(array('form_validation', 'table'));
        $this->load->helper(array('form', 'snippets'));
        $this->form_validation->set_error_delimiters('<span class="notice">', '</span>');
        if ($this->form_validation->run('kategori_berita_update') === FALSE) {
            //don't do anything
        } else {
            $this->crud->use_table('m_kategori_berita');
            $criteria = array(
                'id' => $id
            );
            $data_in = array(
                'kategori_berita' => $this->input->post('kategori_berita'),
                'keterangan' => $this->input->post('keterangan'),
                'modified_on' => date($this->config->item('log_date_format')),
                'modified_by' => logged_info()->on
            );
            $this->crud->update($criteria, $data_in);
            redirect('master/kategori_berita/' . $id . '/info');
        }
        $data['action_url'] = $master_url . $id . '/' . __FUNCTION__;
        $data['page_title'] = 'Update Kategori Berita';
        $data['tools'] = array(
            'master/kategori_berita' => 'Back'
        );

        $this->crud->use_table('m_kategori_berita');
        $kategori_berita_data = $this->crud->retrieve(array('id' => $id))->row();

        $this->load->model('kategori_berita_model', 'kategori_berita');
        $data = array_merge($data, $this->kategori_berita->set_default()); //merge dengan arr data dengan default
        $data = array_merge($data, (array) $kategori_berita_data);
        $this->load->view('master/kategori_berita_form', $data);
    }

    function unique_kategori_berita($kategori_berita) {
        $this->crud->use_table('m_kategori_berita');
        $kategori_berita = $this->crud->retrieve(array('kategori_berita' => $kategori_berita))->row();
        if (sizeof($kategori_berita) > 0) {
            $this->form_validation->set_message(__FUNCTION__, 'Kategori Berita sudah terdaftar'); //pakai function karena ini harus sama dengan nama function nya
            return FALSE;
        } else {
            return true;
        }
    }

    function suggestion() {
        $this->load->model('kategori_berita_model');
        $kategori_berita = $this->input->get('kategori_berita');
        $terms = array(
            'kategori_berita' => $kategori_berita
        );
        $this->kategori_berita_model->suggestion($terms);
    }

}

?>
