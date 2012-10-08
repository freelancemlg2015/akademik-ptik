<?php

/*
 * Fachrul Rozi
 * Master Kurikulum : Program Studi 
 * 5/9/2012
 */

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Program_studi extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->helper(array('snippets_helper'));
        $this->load->model('crud_model', 'crud');
    }

    function log_date() {
        return date($this->config->item('log_date_format'));
    }

    function index($query_id = 0, $sort_by = 'id', $sort_order = 'desc', $offset = 0) {
        $this->program_studi($query_id, $sort_by, $sort_order, $offset);
    }

    function program_studi($query_id = 0, $sort_by = 'id', $sort_order = 'desc', $offset = 0) {
        $data_type = $this->input->post('data_type');
        $data['auth'] = $this->auth;
        // pagination
        $limit = 20;
        $this->load->library(array('form_validation', 'table', 'pagination'));
        $this->input->load_query($query_id);
        $query_array = array(
            'kode_program_studi' => $this->input->get('kode_program_studi'),
            'nama_program_studi' => $this->input->get('nama_program_studi'),
            'active' => 1
        );

        $this->load->model('program_studi_model', 'program_studi');
        $results = $this->program_studi->search($query_array, $limit, $offset, $sort_by, $sort_order);
        //echo get_instance()->db->last_query();
        $data['results'] = $results['results'];
        $data['num_results'] = $results['num_rows'];

        // pagination
        $config = array();
        $config['base_url'] = site_url("master/program_studi/$query_id/$sort_by/$sort_order");
        $config['total_rows'] = $data['num_results'];
        $config['per_page'] = $limit;
        $config['uri_segment'] = 6;
        $config['num_links'] = 6;

        $config = array_merge($config, default_pagination_btn());
        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();
        $data['sort_by'] = $sort_by;
        $data['sort_order'] = $sort_order;

        $data['page_title'] = 'Program Studi';

        $data['tools'] = array(
            'master/program_studi/create' => 'New'
        );

        $this->load->view('master/program_studi', $data);
    }

    function search() {
        $query_array = array(
            'kode_program_studi' => $this->input->post('kode_program_studi'),
            'nama_program_studi' => $this->input->post('nama_program_studi'),
            'active' => 1
        );
        $query_id = $this->input->save_query($query_array);
        redirect("master/program_studi/view/$query_id");
    }

    function info() {
        $id = $this->uri->segment(3);
        $data['auth'] = $this->auth;
        $criteria = array(
            'm_program_studi.id' => $id
        );
        $this->load->model('program_studi_model', 'program_studi');
        $result = $this->program_studi->get_many('', $criteria)->row_array();
        //[debug]echo get_instance()->db->last_query();
        $result_keys = array_keys($result);
        foreach ($result_keys as $result_key) {
            $data[$result_key] = $result[$result_key];
        }

        $data['tools'] = array(
            'master/program_studi' => 'Back',
            'master/program_studi/' . $id . '/edit' => 'Edit',
            'master/program_studi/' . $id . '/delete' => 'Delete'
        );
        $data['page_title'] = 'Detail Program Studi';
        $this->load->view('master/program_studi_info', $data);
    }

    function delete() {
        $id = $this->uri->segment(3);
        $this->crud->use_table('m_program_studi');
        $criteria = array('id' => $id);
        $data_in = array(
            'active' => 0,
            'modified_on' => logged_info()->on,
            'modified_by' => logged_info()->by
        );
        $this->crud->update($criteria, $data_in);
        redirect('master/program_studi');
    }

    function create() {
        $data['auth'] = $this->auth;
        $data['action_type'] = __FUNCTION__;
        $master_url = 'master/program_studi/';

        $this->load->library(array('form_validation', 'table'));
        $this->load->helper(array('form', 'snippets'));
        $this->form_validation->set_error_delimiters('<span class="notice">', '</span>');
        if ($this->form_validation->run('program_studi_create') === FALSE) {
            //don't do anything
        } else {
            $this->crud->use_table('m_program_studi');
            $data_in = array(
                'angkatan_id' => $this->input->post('angkatan_id'),
                'kode_program_studi' => $this->input->post('kode_program_studi'),
                'nama_program_studi' => $this->input->post('nama_program_studi'),
                'inisial' => $this->input->post('inisial'),
                'jenjang_studi_id' => $this->input->post('jenjang_studi_id'),
                'status_akreditasi' => $this->input->post('status_akreditasi'),
                'no_sk_terakhir' => $this->input->post('no_sk_terakhir'),
                'tgl_sk_terakhir' => $this->input->post('tgl_sk_terakhir'),
                'jml_sks' => $this->input->post('jml_sks'),
                'kode_status_program_studi' => $this->input->post('kode_status_program_studi'),
                'thn_semester_mulai' => $this->input->post('thn_semester_mulai'),
                'email' => $this->input->post('email'),
                'tgl_pendirian_program_studi' => $this->input->post('tgl_pendirian_program_studi'),
                'no_sk_akreditasi' => $this->input->post('no_sk_akreditasi'),
                'tgl_sk_akreditasi' => $this->input->post('tgl_sk_akreditasi'),
                'tgl_akhir_sk' => $this->input->post('tgl_akhir_sk'),
                'frekuensi_pemutahiran_kurikulum' => $this->input->post('frekuensi_pemutahiran_kurikulum'),
                'pelaksana_pemutahiran' => $this->input->post('pelaksana_pemutahiran'),
                'created_on' => date($this->config->item('log_date_format')),
                'created_by' => logged_info()->on
            );
            /*
              echo '<pre>';
              var_dump($data_in);
              echo '</pre>';
             */
            $created_id = $this->crud->create($data_in);
            redirect('master/program_studi/' . $created_id . '/info');
        }
        $data['action_url'] = $master_url . __FUNCTION__;
        $data['page_title'] = 'Create Program Studi';
        $data['tools'] = array(
            'master/program_studi' => 'Back'
        );

        $this->crud->use_table('m_angkatan');
        $data['angkatan_options'] = $this->crud->retrieve()->result();

        $this->crud->use_table('m_jenjang_studi');
        $data['jenjang_studi_options'] = $this->crud->retrieve()->result();

        $this->load->model('program_studi_model', 'program_studi');
        $data = array_merge($data, $this->program_studi->set_default()); //merge dengan arr data dengan default

        $this->load->view('master/program_studi_form', $data);
    }

    function edit() {
        $data['auth'] = $this->auth;
        $data['action_type'] = __FUNCTION__;
        $master_url = 'master/program_studi/';
        $id = $this->uri->segment(3);

        $this->load->library(array('form_validation', 'table'));
        $this->load->helper(array('form', 'snippets'));
        $this->form_validation->set_error_delimiters('<span class="notice">', '</span>');
        if ($this->form_validation->run('program_studi_update') === FALSE) {
            //don't do anything
        } else {
            $this->crud->use_table('m_program_studi');
            $criteria = array(
                'id' => $id
            );
            $data_in = array(
                'angkatan_id' => $this->input->post('angkatan_id'),
                'kode_program_studi' => $this->input->post('kode_program_studi'),
                'nama_program_studi' => $this->input->post('nama_program_studi'),
                'inisial' => $this->input->post('inisial'),
                'jenjang_studi_id' => $this->input->post('jenjang_studi_id'),
                'status_akreditasi' => $this->input->post('status_akreditasi'),
                'no_sk_terakhir' => $this->input->post('no_sk_terakhir'),
                'tgl_sk_terakhir' => $this->input->post('tgl_sk_terakhir'),
                'jml_sks' => $this->input->post('jml_sks'),
                'kode_status_program_studi' => $this->input->post('kode_status_program_studi'),
                'thn_semester_mulai' => $this->input->post('thn_semester_mulai'),
                'email' => $this->input->post('email'),
                'tgl_pendirian_program_studi' => $this->input->post('tgl_pendirian_program_studi'),
                'no_sk_akreditasi' => $this->input->post('no_sk_akreditasi'),
                'tgl_sk_akreditasi' => $this->input->post('tgl_sk_akreditasi'),
                'tgl_akhir_sk' => $this->input->post('tgl_akhir_sk'),
                'frekuensi_pemutahiran_kurikulum' => $this->input->post('frekuensi_pemutahiran_kurikulum'),
                'pelaksana_pemutahiran' => $this->input->post('pelaksana_pemutahiran'),
                'modified_on' => date($this->config->item('log_date_format')),
                'modified_by' => logged_info()->on
            );
            $this->crud->update($criteria, $data_in);
            redirect('master/program_studi/' . $id . '/info');
        }
        $data['action_url'] = $master_url . $id . '/' . __FUNCTION__;
        $data['page_title'] = 'Update Program Studi';
        $data['tools'] = array(
            'master/program_studi' => 'Back'
        );

        $this->crud->use_table('m_program_studi');
        $program_studi_data = $this->crud->retrieve(array('id' => $id))->row();

        $this->crud->use_table('m_angkatan');
        $data['angkatan_options'] = $this->crud->retrieve()->result();

        $this->crud->use_table('m_jenjang_studi');
        $data['jenjang_studi_options'] = $this->crud->retrieve()->result();

        $this->load->model('program_studi_model', 'program_studi');
        $data = array_merge($data, $this->program_studi->set_default()); //merge dengan arr data dengan default
        $data = array_merge($data, (array) $program_studi_data);
        $this->load->view('master/program_studi_form', $data);
    }

    function unique_program_studi($nama_program_studi) {
        $this->crud->use_table('m_program_studi');
        $program_studi = $this->crud->retrieve(array('program_studi' => $nama_program_studi))->row();
        if (sizeof($program_studi) > 0) {
            $this->form_validation->set_message(__FUNCTION__, 'Nama Program Studi sudah terdaftar'); //pakai function karena ini harus sama dengan nama function nya
            return FALSE;
        } else {
            return true;
        }
    }
    
   
}

?>
