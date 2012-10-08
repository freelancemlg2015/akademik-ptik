<?php

/*
 * Imam Syarifudin
 * Transaction Kurikulum : Paket Matakuliah
 * 5/9/2012
 */

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Paket_matakuliah extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->helper(array('snippets_helper'));
        $this->load->model('crud_model', 'crud');
    }

    function log_date() {
        return date($this->config->item('log_date_format'));
    }

    function index($query_id = 0, $sort_by = 'id', $sort_order = 'desc', $offset = 0) {
        $this->paket_matakuliah($query_id, $sort_by, $sort_order, $offset);
    }

    function paket_matakuliah($query_id = 0, $sort_by = 'id', $sort_order = 'desc', $offset = 0) {
        $data_type    = $this->input->post('data_type');
        $data['auth'] = $this->auth;
        // pagination
        $limit = 20;
        $this->load->library(array('form_validation', 'table', 'pagination'));
        $this->input->load_query($query_id);
        $query_array = array(
            'nama_angkatan'    => $this->input->get('nama_angkatan'),
            'tahun_ajar'       => $this->input->get('tahun_ajar'),
            'nama_semester'    => $this->input->get('nama_semester'),
            'nama_paket'       => $this->input->get('nama_paket'),
            'nama_mata_kuliah' => $this->input->get('nama_mata_kuliah'),
            'active'         => 1
        );

        $this->load->model('paket_matakuliah_model', 'paket_matakuliah');
        $results = $this->paket_matakuliah->search($query_array, $limit, $offset, $sort_by, $sort_order);
        //echo get_instance()->db->last_query();
        $data['results']     = $results['results'];
        $data['num_results'] = $results['num_rows'];

        // pagination
        $config = array();
        $config['base_url']    = site_url("transaction/paket_matakuliah/$query_id/$sort_by/$sort_order");
        $config['total_rows']  = $data['num_results'];
        $config['per_page']    = $limit;
        $config['uri_segment'] = 6;
        $config['num_links']   = 6;

        $config = array_merge($config, default_pagination_btn());
        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();
        $data['sort_by']    = $sort_by;
        $data['sort_order'] = $sort_order;

        $data['page_title'] = 'Paket Matakuliah';

        $data['tools'] = array(
            'transaction/paket_matakuliah/create' => 'New'
        );

        $this->load->view('transaction/paket_matakuliah', $data);
    }

    function search() {
        $query_array = array(
            'nama_angkatan'    => $this->input->get('nama_angkatan'),
            'tahun_ajar'       => $this->input->get('tahun_ajar'),
            'nama_semester'    => $this->input->get('nama_semester'),
            'nama_paket'       => $this->input->get('nama_kegiatan'),
            'nama_mata_kuliah' => $this->input->get('nama_mata_kuliah'),
            'active'         => 1
        );
        $query_id = $this->input->save_query($query_array);
        redirect("transaction/paket_matakuliah/view/$query_id");
    }

    function info() {
        $id = $this->uri->segment(3);
        $data['auth'] = $this->auth;
        $criteria = array(
            't_paket_mata_kuliah.id' => $id
        );
        $this->load->model('paket_matakuliah_model', 'paket_matakuliah');
        $result = $this->paket_matakuliah->get_many('', $criteria)->row_array();
        //[debug]echo get_instance()->db->last_query();
        $result_keys = array_keys($result);
        foreach ($result_keys as $result_key) {
            $data[$result_key] = $result[$result_key];
        }

        $data['tools'] = array(
            'transaction/paket_matakuliah' => 'Back',
            'transaction/paket_matakuliah/' . $id . '/edit' => 'Edit',
            'transaction/paket_matakuliah/' . $id . '/delete' => 'Delete'
        );
        $data['page_title'] = 'Detail Paket Matakuliah';
        $this->load->view('transaction/paket_matakuliah_info', $data);
    }

    function delete() {
        $id = $this->uri->segment(3);
        $this->crud->use_table('t_paket_mata_kuliah');
        $criteria = array('id' => $id);
        $data_in = array(
            'active'      => 0,
            'modified_on' => logged_info()->on,
            'modified_by' => logged_info()->by
        );
        $this->crud->update($criteria, $data_in);
        redirect('transaction/paket_matakuliah');
    }

    function create() {
        $data['auth']        = $this->auth;
        $data['action_type'] = __FUNCTION__;
        $master_url          = 'transaction/paket_matakuliah/';

        $this->load->library(array('form_validation', 'table'));
        $this->load->helper(array('form', 'snippets'));
        $this->form_validation->set_error_delimiters('<span class="notice">', '</span>');
        if ($this->form_validation->run('paket_matakuliah_create') === FALSE) {
            //don't do anything
        } else {
            $this->crud->use_table('t_paket_mata_kuliah');
            $data_in = array(
                'angkatan_id'        => $this->input->post('angkatan_id'),
                'tahun_akademik_id'  => $this->input->post('tahun_akademik_id'),
                'semester_id'        => $this->input->post('semester_id'),
                'nama_paket'         => $this->input->post('nama_paket'),
                'mata_kuliah_id'     => $this->input->post('mata_kuliah_id'),
                'keterangan'         => $this->input->post('keterangan'),
                'created_on'         => date($this->config->item('log_date_format')),
                'created_by'         => logged_info()->on
            );
            /*
              echo '<pre>';
              var_dump($data_in);
              echo '</pre>';
             */
            $created_id = $this->crud->create($data_in);
            redirect('transaction/paket_matakuliah/' . $created_id . '/info');
        }
        $data['action_url'] = $master_url . __FUNCTION__;
        $data['page_title'] = 'Create Paket Matakuliah';
        $data['tools']      = array(
            'transaction/paket_matakuliah' => 'Back'
        );
        
        $data['nama_angkatan']    = '';
        $data['tahun_ajar']       = '';
        $data['nama_mata_kuliah'] = '';
        
        $this->crud->use_table('m_semester');
        $data['semester_options'] = $this->crud->retrieve()->result();

        $this->load->model('paket_matakuliah_model', 'paket_matakuliah');
        $data = array_merge($data, $this->paket_matakuliah->set_default()); //merge dengan arr data dengan default
        
        $this->load->view('transaction/paket_matakuliah_form', $data);
    }

//1. Model
//2. Controller
//3. View
//4. Form Validation
//5. Routes
//6. Menus

    function edit() {
        $data['auth']        = $this->auth;
        $data['action_type'] = __FUNCTION__;
        $master_url          = 'transaction/paket_matakuliah/';
        $id                  = $this->uri->segment(3);

        $this->load->library(array('form_validation', 'table'));
        $this->load->helper(array('form', 'snippets'));
        $this->form_validation->set_error_delimiters('<span class="notice">', '</span>');
        if ($this->form_validation->run('paket_matakuliah_update') === FALSE) {
            //don't do anything
        } else {
            $this->crud->use_table('t_paket_matakuliah');
            $criteria = array(
                'id' => $id
            );
            $data_in = array(
                'angkatan_id'        => $this->input->post('angkatan_id'),
                'tahun_akademik_id'  => $this->input->post('tahun_akademik_id'),
                'semester_id'        => $this->input->post('semester_id'),
                'nama_paket'         => $this->input->post('nama_paket'),
                'mata_kuliah_id'     => $this->input->post('mata_kuliah_id'),
                'keterangan'         => $this->input->post('keterangan'),
                'modified_on'     => date($this->config->item('log_date_format')),
                'modified_by'     => logged_info()->on
            );
            
            $this->crud->update($criteria, $data_in);
            redirect('transaction/paket_matakuliah/' . $id . '/info');
        }
        $data['action_url'] = $master_url . $id . '/' . __FUNCTION__;
        $data['page_title'] = 'Update Paket Matakuliah';
        $data['tools']      = array(
            'transaction/paket_matakuliah' => 'Back'
        );
        
        $data['nama_angkatan']    = '';
        $data['tahun_ajar']       = '';
        $data['nama_mata_kuliah'] = '';
        
        $this->crud->use_table('t_paket_mata_kuliah');
        $paket_matakuliah_data = $this->crud->retrieve(array('id' => $id))->row();
        
        $this->crud->use_table('m_semester');
        $data['semester_options'] = $this->crud->retrieve()->result();
        
        $this->load->model('paket_matakuliah_model', 'paket_matakuliah');
        $data = array_merge($data, $this->paket_matakuliah->set_default()); //merge dengan arr data dengan default
        $data = array_merge($data, (array) $paket_matakuliah_data);
        $this->load->view('transaction/paket_matakuliah_form', $data);
    }

    function unique_nama_paket($nama_paket) {
        $this->crud->use_table('t_paket_mata_kuliah');
        $paket_matakuliah = $this->crud->retrieve(array('nama_paket' => $nama_paket))->row();
        if (sizeof($paket_matakuliah) > 0) {
            $this->form_validation->set_message(__FUNCTION__, 'Nama Paket sudah terdaftar'); //pakai function karena ini harus sama dengan nama function nya
            return FALSE;
        } else {
            return true;
        }
    }
}

?>
