<?php

/*
 * Imam Syarifudin
 * Transaction Kurikulum : Kalender Akademik
 * 5/9/2012
 */

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Kalender_akademik extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->helper(array('snippets_helper'));
        $this->load->model('crud_model', 'crud');
    }

    function log_date() {
        return date($this->config->item('log_date_format'));
    }

    function index($query_id = 0, $sort_by = 'id', $sort_order = 'desc', $offset = 0) {
        $this->kalender_akademik($query_id, $sort_by, $sort_order, $offset);
    }

    function kalender_akademik($query_id = 0, $sort_by = 'id', $sort_order = 'desc', $offset = 0) {
        $data_type    = $this->input->post('data_type');
        $data['auth'] = $this->auth;
        // pagination
        $limit = 20;
        $this->load->library(array('form_validation', 'table', 'pagination'));
        $this->input->load_query($query_id);
        $query_array = array(
            'nama_angkatan'  => $this->input->get('nama_angkatan'),
            'nama_kegiatan'          => $this->input->get('nama_kegiatan'),
            'active'         => 1
        );

        $this->load->model('kalender_akademik_model', 'kalender_akademik');
        $results = $this->kalender_akademik->search($query_array, $limit, $offset, $sort_by, $sort_order);
        //echo get_instance()->db->last_query();
        $data['results']     = $results['results'];
        $data['num_results'] = $results['num_rows'];

        // pagination
        $config = array();
        $config['base_url']    = site_url("transaction/kalender_akademik/$query_id/$sort_by/$sort_order");
        $config['total_rows']  = $data['num_results'];
        $config['per_page']    = $limit;
        $config['uri_segment'] = 6;
        $config['num_links']   = 6;

        $config = array_merge($config, default_pagination_btn());
        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();
        $data['sort_by']    = $sort_by;
        $data['sort_order'] = $sort_order;

        $data['page_title'] = 'Kalender Akademik';

        $data['tools'] = array(
            'transaction/kalender_akademik/create' => 'New'
        );

        $this->load->view('transaction/kalender_akademik', $data);
    }

    function search() {
        $query_array = array(
            'nama_angkatan'  => $this->input->post('nama_angkatan'),
            'nama_kegiatan'  => $this->input->post('nama_kegiatan'),
            'active' => 1
        );
        $query_id = $this->input->save_query($query_array);
        redirect("transaction/kalender_akademik/view/$query_id");
    }

    function info() {
        $id = $this->uri->segment(3);
        $data['auth'] = $this->auth;
        $criteria = array(
            't_kalender_akademik.id' => $id
        );
        $this->load->model('kalender_akademik_model', 'kalender_akademik');
        $result = $this->kalender_akademik->get_many('', $criteria)->row_array();
        //[debug]echo get_instance()->db->last_query();
        $result_keys = array_keys($result);
        foreach ($result_keys as $result_key) {
            $data[$result_key] = $result[$result_key];
        }

        $data['tools'] = array(
            'transaction/kalender_akademik' => 'Back',
            'transaction/kalender_akademik/' . $id . '/edit' => 'Edit',
            'transaction/kalender_akademik/' . $id . '/delete' => 'Delete'
        );
        $data['page_title'] = 'Detail Kalender Akademik';
        $this->load->view('transaction/kalender_akademik_info', $data);
    }

    function delete() {
        $id = $this->uri->segment(3);
        $this->crud->use_table('t_kalender_akademik');
        $criteria = array('id' => $id);
        $data_in = array(
            'active'      => 0,
            'modified_on' => logged_info()->on,
            'modified_by' => logged_info()->by
        );
        $this->crud->update($criteria, $data_in);
        redirect('transaction/kalender_akademik');
    }

    function create() {
        $data['auth']        = $this->auth;
        $data['action_type'] = __FUNCTION__;
        $master_url          = 'transaction/kalender_akademik/';

        $this->load->library(array('form_validation', 'table'));
        $this->load->helper(array('form', 'snippets'));
        $this->form_validation->set_error_delimiters('<span class="notice">', '</span>');
        if ($this->form_validation->run('kalender_akademik_create') === FALSE) {
            //don't do anything
        } else {
            $this->crud->use_table('t_kalender_akademik');
            $data_in = array(
                'angkatan_id'        => $this->input->post('angkatan_id'),
                'tahun_akademik_id'  => $this->input->post('tahun_akademik_id'),
                'semester_id'        => $this->input->post('semester_id'),
                'tgl_kalender_mulai' => $this->input->post('tgl_kalender_mulai'),
                'tgl_kalender_akhir' => $this->input->post('tgl_kalender_akhir'),
                'tgl_mulai_kegiatan' => $this->input->post('tgl_mulai_kegiatan'),
                'tgl_akhir_kegiatan' => $this->input->post('tgl_akhir_kegiatan'),
                'nama_kegiatan'      => $this->input->post('nama_kegiatan'),
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
            redirect('transaction/kalender_akademik/' . $created_id . '/info');
        }
        $data['action_url'] = $master_url . __FUNCTION__;
        $data['page_title'] = 'Create Kalender Akademik';
        $data['tools']      = array(
            'transaction/kalender_akademik' => 'Back'
        );
        
        $this->crud->use_table('m_angkatan');
        $data['angkatan_options'] = $this->crud->retrieve()->result();
        
        $this->crud->use_table('m_tahun_akademik');
        $data['tahun_akademik_options'] = $this->crud->retrieve()->result();

        $this->crud->use_table('m_semester');
        $data['semester_options'] = $this->crud->retrieve()->result();
        
        $this->load->model('kalender_akademik_model', 'kalender_akademik');
        $data = array_merge($data, $this->kalender_akademik->set_default()); //merge dengan arr data dengan default
        
        $this->load->view('transaction/kalender_akademik_form', $data);
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
        $master_url          = 'transaction/kalender_akademik/';
        $id                  = $this->uri->segment(3);

        $this->load->library(array('form_validation', 'table'));
        $this->load->helper(array('form', 'snippets'));
        $this->form_validation->set_error_delimiters('<span class="notice">', '</span>');
        if ($this->form_validation->run('kalender_akademik_update') === FALSE) {
            //don't do anything
        } else {
            $this->crud->use_table('t_kalender_akademik');
            $criteria = array(
                'id' => $id
            );
            $data_in = array(
                'angkatan_id'        => $this->input->post('angkatan_id'),
                'tahun_akademik_id'  => $this->input->post('tahun_akademik_id'),
                'semester_id'        => $this->input->post('semester_id'),
                'tgl_kalender_mulai' => $this->input->post('tgl_kalender_mulai'),
                'tgl_kalender_akhir' => $this->input->post('tgl_kalender_akhir'),
                'tgl_mulai_kegiatan' => $this->input->post('tgl_mulai_kegiatan'),
                'tgl_akhir_kegiatan' => $this->input->post('tgl_akhir_kegiatan'),
                'nama_kegiatan'      => $this->input->post('nama_kegiatan'),
                'keterangan'         => $this->input->post('keterangan'),
                'modified_on'        => date($this->config->item('log_date_format')),
                'modified_by'        => logged_info()->on
            );
            
            $this->crud->update($criteria, $data_in);
            redirect('transaction/kalender_akademik/' . $id . '/info');
        }
        $data['action_url'] = $master_url . $id . '/' . __FUNCTION__;
        $data['page_title'] = 'Update Kalender Akademik';
        $data['tools']      = array(
            'transaction/kalender_akademik' => 'Back'
        );
        
        $this->crud->use_table('t_kalender_akademik');
        $kalender_akademik_data = $this->crud->retrieve(array('id' => $id))->row();
        
        $this->crud->use_table('m_angkatan');
        $data['angkatan_options'] = $this->crud->retrieve()->result();
        
        $this->crud->use_table('m_tahun_akademik');
        $data['tahun_akademik_options'] = $this->crud->retrieve()->result();

        $this->crud->use_table('m_semester');
        $data['semester_options'] = $this->crud->retrieve()->result();
                
        $this->load->model('kalender_akademik_model', 'kalender_akademik');
        $data = array_merge($data, $this->kalender_akademik->set_default()); //merge dengan arr data dengan default
        $data = array_merge($data, (array) $kalender_akademik_data);
        $this->load->view('transaction/kalender_akademik_form', $data);
    }

    function unique_nama_kegiatan($nama_kegiatan) {
        $this->crud->use_table('t_kalender_akademik');
        $kalender_akademik = $this->crud->retrieve(array('nama_kegiatan' => $nama_kegiatan))->row();
        if (sizeof($kalender_akademik) > 0) {
            $this->form_validation->set_message(__FUNCTION__, 'Nama Kegiatan sudah terdaftar'); //pakai function karena ini harus sama dengan nama function nya
            return FALSE;
        } else {
            return true;
        }
    }
}

?>
