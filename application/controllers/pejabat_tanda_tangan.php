<?php

/*
 * Fachrul Rozi
 * Master Lain lain : Pejabat Tanda Tangan
 * 5/9/2012
 */

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Pejabat_tanda_tangan extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->helper(array('snippets_helper'));
        $this->load->model('crud_model', 'crud');
    }

    function log_date() {
        return date($this->config->item('log_date_format'));
    }

    function index($query_id = 0, $sort_by = 'id', $sort_order = 'desc', $offset = 0) {
        $this->pejabat_tanda_tangan($query_id, $sort_by, $sort_order, $offset);
    }

    function pejabat_tanda_tangan($query_id = 0, $sort_by = 'id', $sort_order = 'desc', $offset = 0) {
        $data_type = $this->input->post('data_type');
        $data['auth'] = $this->auth;
        // pagination
        $limit = 20;
        $this->load->library(array('form_validation', 'table', 'pagination'));
        $this->input->load_query($query_id);
        $query_array = array(
            'nama_jenis_pejabat' => $this->input->get('nama_jenis_pejabat'),
            'nama_pejabat' => $this->input->get('nama_pejabat'),
            'active' => 1
        );

        $this->load->model('pejabat_tanda_tangan_model', 'pejabat_tanda_tangan');
        $results = $this->pejabat_tanda_tangan->search($query_array, $limit, $offset, $sort_by, $sort_order);
        //echo get_instance()->db->last_query();
        $data['results'] = $results['results'];
        $data['num_results'] = $results['num_rows'];

        // pagination
        $config = array();
        $config['base_url'] = site_url("master/pejabat_tanda_tangan/$query_id/$sort_by/$sort_order");
        $config['total_rows'] = $data['num_results'];
        $config['per_page'] = $limit;
        $config['uri_segment'] = 6;
        $config['num_links'] = 6;

        $config = array_merge($config, default_pagination_btn());
        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();
        $data['sort_by'] = $sort_by;
        $data['sort_order'] = $sort_order;

        $data['page_title'] = 'Pejabat Tanda Tangan';

        $data['tools'] = array(
            'master/pejabat_tanda_tangan/create' => 'New'
        );

        $this->load->view('master/pejabat_tanda_tangan', $data);
    }

    function search() {
        $query_array = array(
            'nama_jenis_pejabat' => $this->input->post('nama_jenis_pejabat'),
            'nama_pejabat' => $this->input->post('nama_pejabat'),
            'active' => 1
        );
        $query_id = $this->input->save_query($query_array);
        redirect("master/pejabat_tanda_tangan/view/$query_id");
    }

    function info() {
        $id = $this->uri->segment(3);
        $data['auth'] = $this->auth;
        $criteria = array(
            'm_pejabat_tanda_tangan.id' => $id
        );
        $this->load->model('pejabat_tanda_tangan_model', 'pejabat_tanda_tangan');
        $result = $this->pejabat_tanda_tangan->get_many('', $criteria)->row_array();
        //[debug]echo get_instance()->db->last_query();
        $result_keys = array_keys($result);
        foreach ($result_keys as $result_key) {
            $data[$result_key] = $result[$result_key];
        }

        $data['tools'] = array(
            'master/pejabat_tanda_tangan' => 'Back',
            'master/pejabat_tanda_tangan/' . $id . '/edit' => 'Edit',
            'master/pejabat_tanda_tangan/' . $id . '/delete' => 'Delete'
        );
        $data['page_title'] = 'Detail Pejabat Tanda Tangan';
        $this->load->view('master/pejabat_tanda_tangan_info', $data);
    }

    function delete() {
        $id = $this->uri->segment(3);
        $this->crud->use_table('m_pejabat_tanda_tangan');
        $criteria = array('id' => $id);
        $data_in = array(
            'active' => 0,
            'modified_on' => logged_info()->on,
            'modified_by' => logged_info()->by
        );
        $this->crud->update($criteria, $data_in);
        redirect('master/pejabat_tanda_tangan');
    }

    function create() {
        $data['auth'] = $this->auth;
        $data['action_type'] = __FUNCTION__;
        $master_url = 'master/pejabat_tanda_tangan/';

        $this->load->library(array('form_validation', 'table'));
        $this->load->helper(array('form', 'snippets'));
        $this->form_validation->set_error_delimiters('<span class="notice">', '</span>');
        if ($this->form_validation->run('pejabat_tanda_tangan_create') === FALSE) {
            //don't do anything
        } else {
            $this->crud->use_table('m_pejabat_tanda_tangan');
            $data_in = array(
                'sub_direktorat_id' => $this->input->post('sub_direktorat_id'),
                'kategori_pejabat_id' => $this->input->post('kategori_pejabat_id'),
                'kop' => $this->input->post('kop'),
                'nama_pejabat' => $this->input->post('nama_pejabat'),
                'tanggal_tanda_tangan' => $this->input->post('tanggal_tanda_tangan'),
                'created_on' => date($this->config->item('log_date_format')),
                'created_by' => logged_info()->on
            );
            /*
              echo '<pre>';
              var_dump($data_in);
              echo '</pre>';
             */
            $created_id = $this->crud->create($data_in);
            redirect('master/pejabat_tanda_tangan/' . $created_id . '/info');
        }
        $data['action_url'] = $master_url . __FUNCTION__;
        $data['page_title'] = 'Create Pejabat Tanda Tangan';
        $data['tools'] = array(
            'master/pejabat_tanda_tangan' => 'Back'
        );
        
        $this->crud->use_table('m_subdirektorat');
        $data['subdirektorat_options'] = $this->crud->retrieve()->result();
        
        $this->crud->use_table('m_kategori_pejabat');
        $data['kategori_pejabat_options'] = $this->crud->retrieve()->result();

        $this->load->model('pejabat_tanda_tangan_model', 'pejabat_tanda_tangan');
        $data = array_merge($data, $this->pejabat_tanda_tangan->set_default()); //merge dengan arr data dengan default
        $this->load->view('master/pejabat_tanda_tangan_form', $data);
    }

    function edit() {
        $data['auth'] = $this->auth;
        $data['action_type'] = __FUNCTION__;
        $master_url = 'master/pejabat_tanda_tangan/';
        $id = $this->uri->segment(3);

        $this->load->library(array('form_validation', 'table'));
        $this->load->helper(array('form', 'snippets'));
        $this->form_validation->set_error_delimiters('<span class="notice">', '</span>');
        if ($this->form_validation->run('pejabat_tanda_tangan_update') === FALSE) {
            //don't do anything
        } else {
            $this->crud->use_table('m_pejabat_tanda_tangan');
            $criteria = array(
                'id' => $id
            );
            $data_in = array(
                'sub_direktorat_id' => $this->input->post('sub_direktorat_id'),
                'kategori_pejabat_id' => $this->input->post('kategori_pejabat_id'),
                'kop' => $this->input->post('kop'),
                'nama_pejabat' => $this->input->post('nama_pejabat'),
                'tanggal_tanda_tangan' => $this->input->post('tanggal_tanda_tangan'),
                'modified_on' => date($this->config->item('log_date_format')),
                'modified_by' => logged_info()->on
            );
            $this->crud->update($criteria, $data_in);
            redirect('master/pejabat_tanda_tangan/' . $id . '/info');
        }
        $data['action_url'] = $master_url . $id . '/' . __FUNCTION__;
        $data['page_title'] = 'Update Pejabat Tanda Tangan';
        $data['tools'] = array(
            'master/pejabat_tanda_tangan' => 'Back'
        );

        $this->crud->use_table('m_pejabat_tanda_tangan');
        $pejabat_tanda_tangan_data = $this->crud->retrieve(array('id' => $id))->row();
        
        $this->crud->use_table('m_subdirektorat');
        $data['subdirektorat_options'] = $this->crud->retrieve()->result();
        
        $this->crud->use_table('m_kategori_pejabat');
        $data['kategori_pejabat_options'] = $this->crud->retrieve()->result();
        
        $this->load->model('pejabat_tanda_tangan_model', 'pejabat_tanda_tangan');
        $data = array_merge($data, $this->pejabat_tanda_tangan->set_default()); //merge dengan arr data dengan default
        $data = array_merge($data, (array) $pejabat_tanda_tangan_data);
        $this->load->view('master/pejabat_tanda_tangan_form', $data);
    }

    function unique_nama_pejaba($nama_pejabat) {
        $this->crud->use_table('m_pejabat_tanda_tangan');
        $pejabat_tanda_tangan = $this->crud->retrieve(array('nama_pejabat' => $nama_pejabat))->row();
        if (sizeof($pejabat_tanda_tangan) > 0) {
            $this->form_validation->set_message(__FUNCTION__, 'Nama Pejabat sudah terdaftar'); //pakai function karena ini harus sama dengan nama function nya
            return FALSE;
        } else {
            return true;
        }
    }
}

?>
