<?php

/*
 * Fachrul Rozi
 * Master Kurikulum : Tahun Akademik 
 * 6/9/2012
 */

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Tahun_akademik extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->helper(array('snippets_helper'));
        $this->load->model('crud_model', 'crud');
    }

    function log_date() {
        return date($this->config->item('log_date_format'));
    }

    function index($query_id = 0, $sort_by = 'id', $sort_order = 'desc', $offset = 0) {
        $this->tahun_akademik($query_id, $sort_by, $sort_order, $offset);
    }

    function tahun_akademik($query_id = 0, $sort_by = 'id', $sort_order = 'desc', $offset = 0) {
        $data_type = $this->input->post('data_type');
        $data['auth'] = $this->auth;
        // pagination
        $limit = 20;
        $this->load->library(array('form_validation', 'table', 'pagination'));
        $this->input->load_query($query_id);
        $query_array = array(
            'kode_tahun_ajar'  => $this->input->post('kode_tahun_ajar'),
            'tahun_ajar_mulai' => $this->input->post('tahun_ajar_mulai'),
            'tahun_ajar_akhir' => $this->input->post('tahun_ajar_akhir'),
            'tahun'            => $this->input->post('tahun'),
            'active' => 1
        );

        $this->load->model('tahun_akademik_model', 'tahun_akademik');
        $results = $this->tahun_akademik->search($query_array, $limit, $offset, $sort_by, $sort_order);
        //echo get_instance()->db->last_query();
        $data['results'] = $results['results'];
        $data['num_results'] = $results['num_rows'];

        // pagination
        $config = array();
        $config['base_url'] = site_url("master/tahun_akademik/$query_id/$sort_by/$sort_order");
        $config['total_rows'] = $data['num_results'];
        $config['per_page'] = $limit;
        $config['uri_segment'] = 6;
        $config['num_links'] = 6;

        $config = array_merge($config, default_pagination_btn());
        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();
        $data['sort_by'] = $sort_by;
        $data['sort_order'] = $sort_order;

        $data['page_title'] = 'Tahun Akademik';

        $data['tools'] = array(
            'master/tahun_akademik/create' => 'New'
        );

        $this->load->view('master/tahun_akademik', $data);
    }

    function search() {
        $query_array = array(
            'kode_tahun_ajar'  => $this->input->post('kode_tahun_ajar'),
            'tahun_ajar_mulai' => $this->input->post('tahun_ajar_mulai'),
            'tahun_ajar_akhir' => $this->input->post('tahun_ajar_akhir'),
            'tahun'            => $this->input->post('tahun'),
            'active'           => 1
        );
        $query_id = $this->input->save_query($query_array);
        redirect("master/tahun_akademik/view/$query_id");
    }

    function info() {
        $id = $this->uri->segment(3);
        $data['auth'] = $this->auth;
        $criteria = array(
            'm_tahun_akademik.id' => $id
        );
        $this->load->model('tahun_akademik_model', 'tahun_akademik');
        $result = $this->tahun_akademik->get_many('', $criteria)->row_array();
        //[debug]echo get_instance()->db->last_query();
        $result_keys = array_keys($result);
        foreach ($result_keys as $result_key) {
            $data[$result_key] = $result[$result_key];
        }

        $data['tools'] = array(
            'master/tahun_akademik' => 'Back',
            'master/tahun_akademik/' . $id . '/edit' => 'Edit',
            'master/tahun_akademik/' . $id . '/delete' => 'Delete'
        );
        $data['page_title'] = 'Detail Tahun Akademik';
        $this->load->view('master/tahun_akademik_info', $data);
    }

    function delete() {
        $id = $this->uri->segment(3);
        $this->crud->use_table('m_tahun_akademik');
        $criteria = array('id' => $id);
        $data_in = array(
            'active' => 0,
            'modified_on' => logged_info()->on,
            'modified_by' => logged_info()->by
        );
        $this->crud->update($criteria, $data_in);
        redirect('master/tahun_akademik');
    }

    function create() {
        $data['auth'] = $this->auth;
        $data['action_type'] = __FUNCTION__;
        $master_url = 'master/tahun_akademik/';

        $this->load->library(array('form_validation', 'table'));
        $this->load->helper(array('form', 'snippets'));
        $this->form_validation->set_error_delimiters('<span class="notice">', '</span>');
        if ($this->form_validation->run('tahun_akademik_create') === FALSE) {
            //don't do anything
        } else {
            $this->crud->use_table('m_tahun_akademik');
            $data_in = array(
                'kode_tahun_ajar' => $this->input->post('kode_tahun_ajar'),
                'tahun_ajar_mulai'=> $this->input->post('tahun_ajar_mulai'),
                'tahun_ajar_akhir'=> $this->input->post('tahun_ajar_akhir'),
                'tgl_mulai'       => $this->input->post('tgl_mulai'),
                'created_on'      => date($this->config->item('log_date_format')),
                'created_by'      => logged_info()->on
            );
            /*
              echo '<pre>';
              var_dump($data_in);
              echo '</pre>';
             */
            $created_id = $this->crud->create($data_in);
            redirect('master/tahun_akademik/' . $created_id . '/info');
        }
        $data['action_url'] = $master_url . __FUNCTION__;
        $data['page_title'] = 'Create Tahun Akademik';
        $data['tools'] = array(
            'master/tahun_akademik' => 'Back'
        );

        $this->load->model('tahun_akademik_model', 'tahun_akademik');
        $data = array_merge($data, $this->tahun_akademik->set_default()); //merge dengan arr data dengan default
        $this->load->view('master/tahun_akademik_form', $data);
    }

    function edit() {
        $data['auth'] = $this->auth;
        $data['action_type'] = __FUNCTION__;
        $master_url = 'master/tahun_akademik/';
        $id = $this->uri->segment(3);

        $this->load->library(array('form_validation', 'table'));
        $this->load->helper(array('form', 'snippets'));
        $this->form_validation->set_error_delimiters('<span class="notice">', '</span>');
        if ($this->form_validation->run('tahun_akademik_update') === FALSE) {
            //don't do anything
        } else {
            $this->crud->use_table('m_tahun_akademik');
            $criteria = array(
                'id' => $id
            );
            $data_in = array(
                'kode_tahun_ajar' => $this->input->post('kode_tahun_ajar'),
                'tahun_ajar_mulai'=> $this->input->post('tahun_ajar_mulai'),
                'tahun_ajar_akhir'=> $this->input->post('tahun_ajar_akhir'),
                'tgl_mulai'       => $this->input->post('tgl_mulai'),
                'modified_on'     => date($this->config->item('log_date_format')),
                'modified_by'     => logged_info()->on
            );
            /*
              echo '<pre>';
                var_dump($data_in);
              echo '</pre>';
            */
            $this->crud->update($criteria, $data_in);
            redirect('master/tahun_akademik/' . $id . '/info');
        }
        $data['action_url'] = $master_url . $id . '/' . __FUNCTION__;
        $data['page_title'] = 'Update Tahun Akademik';
        $data['tools'] = array(
            'master/tahun_akademik' => 'Back'
        );

        $this->crud->use_table('m_tahun_akademik');
        $tahun_akademik_data = $this->crud->retrieve(array('id' => $id))->row();
        
        $this->load->model('tahun_akademik_model', 'tahun_akademik');
        $data = array_merge($data, $this->tahun_akademik->set_default()); //merge dengan arr data dengan default
        $data = array_merge($data, (array) $tahun_akademik_data);
        $this->load->view('master/tahun_akademik_form', $data);
    }

    function unique_tahun_akademik($tahun_ajar) {
        $this->crud->use_table('m_tahun_akademik');
        $tahun_ajar = $this->crud->retrieve(array('tahun_ajar' => $nama_program_studi))->row();
        if (sizeof($tahun_ajar) > 0) {
            $this->form_validation->set_message(__FUNCTION__, 'Tahun Ajar sudah terdaftar'); //pakai function karena ini harus sama dengan nama function nya
            return FALSE;
        } else {
            return true;
        }
    }
    
    function suggestion() {
        $this->load->model('tahun_akademik_model');
        $tahun_ajar_mulai = $this->input->get('tahun_ajar_mulai');
        $terms = array(
            'tahun_ajar_mulai' => $tahun_ajar_mulai
        );
        $this->tahun_akademik_model->suggestion($terms);
    }

}

?>
