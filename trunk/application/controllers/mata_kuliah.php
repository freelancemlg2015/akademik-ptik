<?php

/*
 * Fachrul Rozi
 * Master Kurikulum : Mata Kuliah 
 * 6/9/2012
 */

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Mata_kuliah extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->helper(array('snippets_helper'));
        $this->load->model('crud_model', 'crud');
    }

    function log_date() {
        return date($this->config->item('log_date_format'));
    }

    function index($query_id = 0, $sort_by = 'id', $sort_order = 'desc', $offset = 0) {
        $this->mata_kuliah($query_id, $sort_by, $sort_order, $offset);
    }

    function mata_kuliah($query_id = 0, $sort_by = 'id', $sort_order = 'desc', $offset = 0) {
        $data_type = $this->input->post('data_type');
        $data['auth'] = $this->auth;
        // pagination
        $limit = 20;
        $this->load->library(array('form_validation', 'table', 'pagination'));
        $this->input->load_query($query_id);
        $query_array = array(
            'kode_mata_kuliah' => $this->input->get('kode_mata_kuliah'),
            'nama_mata_kuliah' => $this->input->get('nama_mata_kuliah'),
            'active' => 1
        );

        $this->load->model('mata_kuliah_model', 'mata_kuliah');
        $results = $this->mata_kuliah->search($query_array, $limit, $offset, $sort_by, $sort_order);
        //echo get_instance()->db->last_query();
        $data['results'] = $results['results'];
        $data['num_results'] = $results['num_rows'];

        // pagination
        $config = array();
        $config['base_url'] = site_url("master/mata_kuliah/$query_id/$sort_by/$sort_order");
        $config['total_rows'] = $data['num_results'];
        $config['per_page'] = $limit;
        $config['uri_segment'] = 6;
        $config['num_links'] = 6;

        $config = array_merge($config, default_pagination_btn());
        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();
        $data['sort_by'] = $sort_by;
        $data['sort_order'] = $sort_order;

        $data['page_title'] = 'Mata Kuliah';

        $data['tools'] = array(
            'master/mata_kuliah/create' => 'New'
        );

        $this->load->view('master/mata_kuliah', $data);
    }

    function search() {
        $query_array = array(
            'kode_mata_kuliah' => $this->input->post('kode_mata_kuliah'),
            'nama_mata_kuliah' => $this->input->post('nama_mata_kuliah'),
            'active' => 1
        );
        $query_id = $this->input->save_query($query_array);
        redirect("master/mata_kuliah/view/$query_id");
    }

    function info() {
        $id = $this->uri->segment(3);
        $data['auth'] = $this->auth;
        $criteria = array(
            'm_mata_kuliah.id' => $id
        );
        $this->load->model('mata_kuliah_model', 'mata_kuliah');
        $result = $this->mata_kuliah->get_many('', $criteria)->row_array();
        //[debug]echo get_instance()->db->last_query();
        $result_keys = array_keys($result);
        foreach ($result_keys as $result_key) {
            $data[$result_key] = $result[$result_key];
        }

        $data['tools'] = array(
            'master/mata_kuliah' => 'Back',
            'master/mata_kuliah/' . $id . '/edit' => 'Edit',
            'master/mata_kuliah/' . $id . '/delete' => 'Delete'
        );
        $data['page_title'] = 'Detail Mata Kuliah';
        $this->load->view('master/mata_kuliah_info', $data);
    }

    function delete() {
        $id = $this->uri->segment(3);
        $this->crud->use_table('m_mata_kuliah');
        $criteria = array('id' => $id);
        $data_in = array(
            'active' => 0,
            'modified_on' => logged_info()->on,
            'modified_by' => logged_info()->by
        );
        $this->crud->update($criteria, $data_in);
        redirect('master/mata_kuliah');
    }

    function create() {
        $data['auth'] = $this->auth;
        $data['action_type'] = __FUNCTION__;
        $master_url = 'master/mata_kuliah/';

        $this->load->library(array('form_validation', 'table'));
        $this->load->helper(array('form', 'snippets'));
        $this->form_validation->set_error_delimiters('<span class="notice">', '</span>');
        if ($this->form_validation->run('mata_kuliah_create') === FALSE) {
            //don't do anything
        } else {
            $this->crud->use_table('m_mata_kuliah');
            $data_in = array(
                'angkatan_id' => $this->input->post('angkatan_id'),
                'program_studi_id' => $this->input->post('program_studi_id'),
                'jenjang_studi_id' => $this->input->post('jenjang_studi_id'),
                'tahun_akademik_id' => $this->input->post('tahun_ajar_id'),
                'kode_mata_kuliah' => $this->input->post('kode_mata_kuliah'),
                'nama_mata_kuliah' => $this->input->post('nama_mata_kuliah'),
                'english' => $this->input->post('english'),
                'sks_mata_kuliah' => $this->input->post('sks_mata_kuliah'),
                'sks_tatap_muka' => $this->input->post('sks_tatap_muka'),
                'sks_praktikum' => $this->input->post('sks_praktikum'),
                'nama_laboratorium' => $this->input->post('nama_laboratorium'),
                'sks_praktek_lapangan' => $this->input->post('sks_praktek_lapangan'),
                'semester' => $this->input->post('semester'),
                'kelompok_mata_kuliah_id' => $this->input->post('kelompok_mata_kuliah_id'),
                'jenis_kurikulum' => $this->input->post('jenis_kurikulum'),
                'jenis_mata_kuliah' => $this->input->post('jenis_mata_kuliah'),
                'jenjang_program_studi_pengampu' => $this->input->post('jenjang_program_studi_pengampu'),
                'program_studi_pengampu' => $this->input->post('program_studi_pengampu'),
                'status_mata_kuliah_id' => $this->input->post('status_mata_kuliah_id'),
                'mata_kuliah_syarat_tempuh' => $this->input->post('mata_kuliah_syarat_tempuh'),
                'mata_kuliah_syarat_lulus' => $this->input->post('mata_kuliah_syarat_lulus'),
                'silabus' => $this->input->post('silabus'),
                'created_on' => date($this->config->item('log_date_format')),
                'created_by' => logged_info()->on
            );
            /*
              echo '<pre>';
              var_dump($data_in);
              echo '</pre>';
             */
            $created_id = $this->crud->create($data_in);
            redirect('master/mata_kuliah/' . $created_id . '/info');
        }
        $data['action_url'] = $master_url . __FUNCTION__;
        $data['page_title'] = 'Create Mata Kuliah';
        $data['tools'] = array(
            'master/mata_kuliah' => 'Back'
        );

        $this->crud->use_table('m_angkatan');
        $data['angkatan_options'] = $this->crud->retrieve()->result();

        $this->crud->use_table('m_jenjang_studi');
        $data['jenjang_studi_options'] = $this->crud->retrieve()->result();

        $this->crud->use_table('m_kelompok_mata_kuliah');
        $data['kelompok_mata_kuliah_options'] = $this->crud->retrieve()->result();

        $this->crud->use_table('m_program_studi');
        $data['program_studi_options'] = $this->crud->retrieve()->result();

        $this->crud->use_table('m_tahun_akademik');
        $data['tahun_akademik_options'] = $this->crud->retrieve()->result();

        $this->crud->use_table('m_status_mata_kuliah');
        $data['status_mata_kuliah_options'] = $this->crud->retrieve()->result();

        $this->load->model('mata_kuliah_model', 'mata_kuliah');
        $data = array_merge($data, $this->mata_kuliah->set_default()); //merge dengan arr data dengan default
        $this->load->view('master/mata_kuliah_form', $data);
    }

    function edit() {
        $data['auth'] = $this->auth;
        $data['action_type'] = __FUNCTION__;
        $master_url = 'master/mata_kuliah/';
        $id = $this->uri->segment(3);

        $this->load->library(array('form_validation', 'table'));
        $this->load->helper(array('form', 'snippets'));
        $this->form_validation->set_error_delimiters('<span class="notice">', '</span>');
        if ($this->form_validation->run('mata_kuliah_update') === FALSE) {
            //don't do anything
        } else {
            $this->crud->use_table('m_mata_kuliah');
            $criteria = array(
                'id' => $id
            );
            $data_in = array(
                'angkatan_id' => $this->input->post('angkatan_id'),
                'program_studi_id' => $this->input->post('program_studi_id'),
                'jenjang_studi_id' => $this->input->post('jenjang_studi_id'),
                'tahun_akademik_id' => $this->input->post('tahun_ajar_id'),
                'kode_mata_kuliah' => $this->input->post('kode_mata_kuliah'),
                'nama_mata_kuliah' => $this->input->post('nama_mata_kuliah'),
                'english' => $this->input->post('english'),
                'sks_mata_kuliah' => $this->input->post('sks_mata_kuliah'),
                'sks_tatap_muka' => $this->input->post('sks_tatap_muka'),
                'sks_praktikum' => $this->input->post('sks_praktikum'),
                'nama_laboratorium' => $this->input->post('nama_laboratorium'),
                'sks_praktek_lapangan' => $this->input->post('sks_praktek_lapangan'),
                'semester' => $this->input->post('semester'),
                'kelompok_mata_kuliah_id' => $this->input->post('kelompok_mata_kuliah_id'),
                'jenis_kurikulum' => $this->input->post('jenis_kurikulum'),
                'jenis_mata_kuliah' => $this->input->post('jenis_mata_kuliah'),
                'jenjang_program_studi_pengampu' => $this->input->post('jenjang_program_studi_pengampu'),
                'program_studi_pengampu' => $this->input->post('program_studi_pengampu'),
                'status_mata_kuliah_id' => $this->input->post('status_mata_kuliah_id'),
                'mata_kuliah_syarat_tempuh' => $this->input->post('mata_kuliah_syarat_tempuh'),
                'mata_kuliah_syarat_lulus' => $this->input->post('mata_kuliah_syarat_lulus'),
                'silabus' => $this->input->post('silabus'),
                'modified_on' => date($this->config->item('log_date_format')),
                'modified_by' => logged_info()->on
            );
            $this->crud->update($criteria, $data_in);
            redirect('master/mata_kuliah/' . $id . '/info');
        }
        $data['action_url'] = $master_url . $id . '/' . __FUNCTION__;
        $data['page_title'] = 'Update Mata Kuliah';
        $data['tools'] = array(
            'master/mata_kuliah' => 'Back'
        );

        $this->crud->use_table('m_mata_kuliah');
        $mata_kuliah_data = $this->crud->retrieve(array('id' => $id))->row();

        $this->crud->use_table('m_angkatan');
        $data['angkatan_options'] = $this->crud->retrieve()->result();

        $this->crud->use_table('m_jenjang_studi');
        $data['jenjang_studi_options'] = $this->crud->retrieve()->result();

        $this->crud->use_table('m_kelompok_mata_kuliah');
        $data['kelompok_mata_kuliah_options'] = $this->crud->retrieve()->result();

        $this->crud->use_table('m_program_studi');
        $data['program_studi_options'] = $this->crud->retrieve()->result();

        $this->crud->use_table('m_tahun_akademik');
        $data['tahun_akademik_options'] = $this->crud->retrieve()->result();

        $this->crud->use_table('m_status_mata_kuliah');
        $data['status_mata_kuliah_options'] = $this->crud->retrieve()->result();

        $this->load->model('mata_kuliah_model', 'mata_kuliah');
        $data = array_merge($data, $this->mata_kuliah->set_default()); //merge dengan arr data dengan default
        $data = array_merge($data, (array) $mata_kuliah_data);
        $this->load->view('master/mata_kuliah_form', $data);
    }

    function unique_nama_mata_kuliah($nama_mata_kuliah) {
        $this->crud->use_table('m_mata_kuliah');
        $mata_kuliah = $this->crud->retrieve(array('nama_mata_kuliah' => $nama_mata_kuliah))->row();
        if (sizeof($mata_kuliah) > 0) {
            $this->form_validation->set_message(__FUNCTION__, 'Nama Mata Kuliah sudah terdaftar'); //pakai function karena ini harus sama dengan nama function nya
            return FALSE;
        } else {
            return true;
        }
    }
    
    function suggestion() {
        $this->load->model('mata_kuliah_model');
        $nama_mata_kuliah = $this->input->get('nama_mata_kuliah');
        $terms = array(
            'nama_mata_kuliah' => $nama_mata_kuliah
        );
        $this->mata_kuliah_model->suggestion($terms);
    }

}

?>
