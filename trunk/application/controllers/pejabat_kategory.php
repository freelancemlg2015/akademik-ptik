<?php

/*
 * Imam Syarifudin
 * Master Lain lain : PEJABAT KATEGORY
 * 7/9/2012
 */

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Pejabat_kategori extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->helper(array('snippets_helper'));
        $this->load->model('crud_model', 'crud');
    }

    function log_date() {
        return date($this->config->item('log_date_format'));
    }

    function index($query_id = 0, $sort_by = 'id', $sort_order = 'desc', $offset = 0) {
        $this->pejabat_kategory($query_id, $sort_by, $sort_order, $offset);
    }

    function pejabat_kategori($query_id = 0, $sort_by = 'id', $sort_order = 'desc', $offset = 0) {
        $data_type = $this->input->post('data_type');
        $data['auth'] = $this->auth;
        // pagination
        $limit = 20;
        $this->load->library(array('form_validation', 'table', 'pagination'));
        $this->input->load_query($query_id);
        $query_array = array(
            'nama_jenis_pejabat' => $this->input->get('nama_jenis_pejabat'),
            'active' => 1
        );

        $this->load->model('pejabat_kategori_model', 'pejabat_kategori');
        $results = $this->pejabat_kategori->search($query_array, $limit, $offset, $sort_by, $sort_order);
        //echo get_instance()->db->last_query();
        $data['results'] = $results['results'];
        $data['num_results'] = $results['num_rows'];

        // pagination
        $config = array();
        $config['base_url'] = site_url("master/pejabat_kategory/$query_id/$sort_by/$sort_order");
        $config['total_rows'] = $data['num_results'];
        $config['per_page'] = $limit;
        $config['uri_segment'] = 6;
        $config['num_links'] = 6;

        $config = array_merge($config, default_pagination_btn());
        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();
        $data['sort_by'] = $sort_by;
        $data['sort_order'] = $sort_order;

        $data['page_title'] = 'pejabat_kategori';

        $data['tools'] = array(
            'master/pejabat_kategori/create' => 'New'
        );

        $this->load->view('master/pejabat_kategori', $data);
    }

    function search() {
        $query_array = array(
            'nama_jenis_pejabat' => $this->input->post('nama_jenis_pejabat'),
            'active' => 1
        );
        $query_id = $this->input->save_query($query_array);
        redirect("master/pejabat_kategori/view/$query_id");
    }

    function info() {
        $id = $this->uri->segment(3);
        $data['auth'] = $this->auth;
        $criteria = array(
            'm_kategori_pejabat.id' => $id
        );
        $this->load->model('pejabat_kategori_model', 'pejabat_kategori');
        $result = $this->pejabat_kategori->get_many('', $criteria)->row_array();
        //[debug]echo get_instance()->db->last_query();
        $result_keys = array_keys($result);
        foreach ($result_keys as $result_key) {
            $data[$result_key] = $result[$result_key];
        }

        $data['tools'] = array(
            'master/pejabat_kategori' => 'Back',
            'master/pejabat_kategori/' . $id . '/edit' => 'Edit',
            'master/pejabat_kategori/' . $id . '/delete' => 'Delete'
        );
        $data['page_title'] = 'Detail Pejabat_kategori';
        $this->load->view('master/ppejabat_kategori_info', $data);
    }

    function delete() {
        $id = $this->uri->segment(3);
        $this->crud->use_table('m_kategori_pejabat');
        $criteria = array('id' => $id);
        $data_in = array(
            'active' => 0,
            'modified_on' => logged_info()->on,
            'modified_by' => logged_info()->by
        );
        $this->crud->update($criteria, $data_in);
        redirect('master/pejabat_kategori');
    }

    function create() {
        $data['auth'] = $this->auth;
        $data['action_type'] = __FUNCTION__;
        $master_url = 'master/pejabat_kategori/';

        $this->load->library(array('form_validation', 'table'));
        $this->load->helper(array('form', 'snippets'));
        $this->form_validation->set_error_delimiters('<span class="notice">', '</span>');
        if ($this->form_validation->run('pejabat_kategory_create') === FALSE) {
            //don't do anything
        } else {
            $this->crud->use_table('m_kategori_pejabat');
            $data_in = array(
                'nama_jenis_pejabat' => $this->input->post('nama_jenis_pejabat'),
                'created_on' => date($this->config->item('log_date_format')),
                'created_by' => logged_info()->on
            );
            /*
              echo '<pre>';
              var_dump($data_in);
              echo '</pre>';
             */
            $created_id = $this->crud->create($data_in);
            redirect('master/pejabat_kategori/' . $created_id . '/info');
        }
        $data['action_url'] = $master_url . __FUNCTION__;
        $data['page_title'] = 'Create Pejabat Kategori';
        $data['tools'] = array(
            'master/pejabat_kategori' => 'Back'
        );

        $this->load->model('pejabat_kategori_model', 'pejabat_kategori');
        $data = array_merge($data, $this->pejabat_kategori->set_default()); //merge dengan arr data dengan default
        $this->load->view('master/pejabat_kategori_form', $data);
    }

    function edit() {
        $data['auth'] = $this->auth;
        $data['action_type'] = __FUNCTION__;
        $master_url = 'master/pejabat_kategori/';
        $id = $this->uri->segment(3);

        $this->load->library(array('form_validation', 'table'));
        $this->load->helper(array('form', 'snippets'));
        $this->form_validation->set_error_delimiters('<span class="notice">', '</span>');
        if ($this->form_validation->run('pejabat_kategori_update') === FALSE) {
            //don't do anything
        } else {
            $this->crud->use_table('m_kategori_pejabat');
            $criteria = array(
                'id' => $id
            );
            $data_in = array(
                'nama_jenis_pejabat' => $this->input->post('nama_jenis_pejabat'),
                'keterangan' => $this->input->post('keterangan'),
                'modified_on' => date($this->config->item('log_date_format')),
                'modified_by' => logged_info()->on
            );
            $this->crud->update($criteria, $data_in);
            redirect('master/pajabat_kategori/' . $id . '/info');
        }
        $data['action_url'] = $master_url . $id . '/' . __FUNCTION__;
        $data['page_title'] = 'Update Akta Mengajar';
        $data['tools'] = array(
            'master/pajabat_kategori' => 'Back'
        );

        $this->crud->use_table('m_kategory_pejabat');
        $pejabat_kategori_data = $this->crud->retrieve(array('id' => $id))->row();

        $this->load->model('pejabat_kategori_model', 'pajabat_kategori');
        $data = array_merge($data, $this->pajabat_kategori->set_default()); //merge dengan arr data dengan default
        $data = array_merge($data, (array) $pajabat_kategori_data);
        $this->load->view('master/pajabat_kategori_form', $data);
    }

    function unique_nama_jenis_pejabat($nama_jenis_pejabat) {
        $this->crud->use_table('m_kategori_pejabat');
        $pejabat_kategori = $this->crud->retrieve(array('nama_jenis_pejabat' => $nama_jenis_pejabat))->row();
        if (sizeof($pejabat_kategori) > 0) {
            $this->form_validation->set_message(__FUNCTION__, 'Nama Jenis Pejabat sudah terdaftar'); //pakai function karena ini harus sama dengan nama function nya
            return FALSE;
        } else {
            return true;
        }
    }

}

?>
