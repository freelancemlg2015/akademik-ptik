<?php

/*
 * Fachrul Rozi
 * Master Direktorat : Sub Direktorat
 * 8/9/2012
 */

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Subdirektorat extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->helper(array('snippets_helper'));
        $this->load->model('crud_model', 'crud');
    }

    function log_date() {
        return date($this->config->item('log_date_format'));
    }

    function index($query_id = 0, $sort_by = 'id', $sort_order = 'desc', $offset = 0) {
        $this->subdirektorat($query_id, $sort_by, $sort_order, $offset);
    }

    function subdirektorat($query_id = 0, $sort_by = 'id', $sort_order = 'desc', $offset = 0) {
        $data_type = $this->input->post('data_type');
        $data['auth'] = $this->auth;
        // pagination
        $limit = 20;
        $this->load->library(array('form_validation', 'table', 'pagination'));
        $this->input->load_query($query_id);
        $query_array = array(
            'nama_direktorat'    => $this->input->get('nama_direktorat'),
            'nama_subdirektorat' => $this->input->get('nama_subdirektorat'),
            'active' => 1
        );

        $this->load->model('subdirektorat_model', 'subdirektorat');
        $results = $this->subdirektorat->search($query_array, $limit, $offset, $sort_by, $sort_order);
        //echo get_instance()->db->last_query();
        $data['results']     = $results['results'];
        $data['num_results'] = $results['num_rows'];

        // pagination
        $config = array();
        $config['base_url']   = site_url("master/subdirektorat/$query_id/$sort_by/$sort_order");
        $config['total_rows'] = $data['num_results'];
        $config['per_page']   = $limit;
        $config['uri_segment']= 6;
        $config['num_links']  = 6;

        $config = array_merge($config, default_pagination_btn());
        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();
        $data['sort_by']    = $sort_by;
        $data['sort_order'] = $sort_order;

        $data['page_title'] = 'Sub Direktorat';

        $data['tools'] = array(
            'master/subdirektorat/create' => 'New'
        );

        $this->load->view('master/subdirektorat', $data);
    }

    function search() {
        $query_array = array(
            'nama_direktorat' => $this->input->post('nama_direktorat'),
            'nama_subdirektorat'      => $this->input->post('nama_subdirektorat'),
            'active'          => 1
        );
        $query_id = $this->input->save_query($query_array);
        redirect("master/subdirektorat/view/$query_id");
    }

    function info() {
        $id = $this->uri->segment(3);
        $data['auth'] = $this->auth;
        $criteria = array(
            'm_subdirektorat.id' => $id
        );
        $this->load->model('subdirektorat_model', 'subdirektorat');
        $result = $this->subdirektorat->get_many('', $criteria)->row_array();
        //[debug]echo get_instance()->db->last_query();
        $result_keys = array_keys($result);
        foreach ($result_keys as $result_key) {
            $data[$result_key] = $result[$result_key];
        }

        $data['tools'] = array(
            'master/subdirektorat' => 'Back',
            'master/subdirektorat/' . $id . '/edit' => 'Edit',
            'master/subdirektorat/' . $id . '/delete' => 'Delete'
        );
        $data['page_title'] = 'Detail Sub Direktorat';
        $this->load->view('master/subdirektorat_info', $data);
    }

    function delete() {
        $id = $this->uri->segment(3);
        $this->crud->use_table('m_subdirektorat');
        $criteria = array('id' => $id);
        $data_in = array(
            'active' => 0,
            'modified_on' => logged_info()->on,
            'modified_by' => logged_info()->by
        );
        $this->crud->update($criteria, $data_in);
        redirect('master/subdirektorat');
    }

    function create() {
        $data['auth'] = $this->auth;
        $data['action_type'] = __FUNCTION__;
        $master_url = 'master/subdirektorat/';

        $this->load->library(array('form_validation', 'table'));
        $this->load->helper(array('form', 'snippets'));
        $this->form_validation->set_error_delimiters('<span class="notice">', '</span>');
        if ($this->form_validation->run('subdirektorat_create') === FALSE) {
            //don't do anything
        } else {
            $this->crud->use_table('m_subdirektorat');
            $data_in = array(
                'direktorat_id'     => $this->input->post('direktorat_id'),
                'nama_subdirektorat'=> $this->input->post('nama_subdirektorat'),
                'keterangan'        => $this->input->post('keterangan'),
                'created_on'        => date($this->config->item('log_date_format')),
                'created_by'        => logged_info()->on
            );
            /*        
              echo '<pre>';
              var_dump($data_in);
              echo '</pre>';
             */
            $created_id = $this->crud->create($data_in);
            redirect('master/subdirektorat/' . $created_id . '/info');
        }
        $data['action_url'] = $master_url . __FUNCTION__;
        $data['page_title'] = 'Create Sub Direktorat';
        $data['tools'] = array(
            'master/subdirektorat' => 'Back'
        );
        
        $this->crud->use_table('m_direktorat');
        $data['direktorat_options'] = $this->crud->retrieve()->result();
        
        $this->load->model('subdirektorat_model', 'subdirektorat');
        $data = array_merge($data, $this->subdirektorat->set_default()); //merge dengan arr data dengan default
        
        $this->load->view('master/subdirektorat_form', $data);
    }

    function edit() {
        $data['auth'] = $this->auth;
        $data['action_type'] = __FUNCTION__;
        $master_url = 'master/subdirektorat/';
        $id = $this->uri->segment(3);

        $this->load->library(array('form_validation', 'table'));
        $this->load->helper(array('form', 'snippets'));
        $this->form_validation->set_error_delimiters('<span class="notice">', '</span>');
        if ($this->form_validation->run('subdirektorat_update') === FALSE) {
            //don't do anything
        } else {
            $this->crud->use_table('m_subdirektorat');
            $criteria = array(
                'id' => $id
            );
            $data_in = array(
                'direktorat_id'     => $this->input->post('direktorat_id'),
                'nama_subdirektorat'=> $this->input->post('nama_subdirektorat'),
                'keterangan'        => $this->input->post('keterangan'),
                'modified_on'       => date($this->config->item('log_date_format')),
                'modified_by'       => logged_info()->on
            );
            
            //print_r($data_in);
            $this->crud->update($criteria, $data_in);
            redirect('master/subdirektorat/' . $id . '/info');
        }
        $data['action_url'] = $master_url . $id . '/' . __FUNCTION__;
        $data['page_title'] = 'Update Jadwal Kuliah';
        $data['tools'] = array(
            'master/subdirektorat' => 'Back'
        );
        
        $this->crud->use_table('m_subdirektorat');
        $subdirektorat_data = $this->crud->retrieve(array('id' => $id))->row();
        
        $this->crud->use_table('m_direktorat');
        $data['direktorat_options'] = $this->crud->retrieve()->result();
       
        $this->load->model('subdirektorat_model', 'subdirektorat');
        $data = array_merge($data, $this->subdirektorat->set_default()); //merge dengan arr data dengan default
        $data = array_merge($data, (array) $subdirektorat_data);
        $this->load->view('master/subdirektorat_form', $data);
    }
    
    function unique_nama_subdirektorat($nama_subdirektorat) {
        $this->crud->use_table('m_subdirektorat');
        $subdirektorat = $this->crud->retrieve(array('nama_subdirektorat' => $nama_subdirektorat))->row();
        if (sizeof($subdirektorat) > 0) {
            $this->form_validation->set_message(__FUNCTION__, 'Nama Subirektorat sudah terdaftar'); //pakai function karena ini harus sama dengan nama function nya
            return FALSE;
        } else {
            return true;
        }
    }
}

?>
