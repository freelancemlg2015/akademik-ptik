<?php

/*
 * Imam Syarifudin
 * Master Kurikulum : Ujian Skripsi
 * 5/9/2012
 */

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Ujian_skripsi extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->helper(array('snippets_helper'));
        $this->load->model('crud_model', 'crud');
    }

    function log_date() {
        return date($this->config->item('log_date_format'));
    }

    function index($query_id = 0, $sort_by = 'id', $sort_order = 'desc', $offset = 0) {
        $this->ujian_skripsi($query_id, $sort_by, $sort_order, $offset);
    }

    function ujian_skripsi($query_id = 0, $sort_by = 'id', $sort_order = 'desc', $offset = 0) {
        $data_type    = $this->input->post('data_type');
        $data['auth'] = $this->auth;
        // pagination
        $limit = 20;
        $this->load->library(array('form_validation', 'table', 'pagination'));
        $this->input->load_query($query_id);
        $query_array = array(
            'nim'           => $this->input->get('nim'),
            'judul_skripsi' => $this->input->get('judul_skripsi'),
            'active'        => 1
        );

        $this->load->model('ujian_skripsi_model', 'ujian_skripsi');
        $results = $this->ujian_skripsi->search($query_array, $limit, $offset, $sort_by, $sort_order);
        //echo get_instance()->db->last_query();
        $data['results']     = $results['results'];
        $data['num_results'] = $results['num_rows'];

        // pagination
        $config = array();
        $config['base_url']    = site_url("transaction/ujian_skripsi/$query_id/$sort_by/$sort_order");
        $config['total_rows']  = $data['num_results'];
        $config['per_page']    = $limit;
        $config['uri_segment'] = 6;
        $config['num_links']   = 6;

        $config = array_merge($config, default_pagination_btn());
        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();
        $data['sort_by']    = $sort_by;
        $data['sort_order'] = $sort_order;

        $data['page_title'] = 'Ujian Skripsi';

        $data['tools'] = array(
            'transaction/ujian_skripsi/create' => 'New'
        );

        $this->load->view('transaction/ujian_skripsi', $data);
    }

    function search() {
        $query_array = array(
            'nim'             => $this->input->post('nim'),
            'judul_skripsi'   => $this->input->post('judul_skripsi'),
            'tgl_ujian_start' => $this->input->post('tgl_ujian_start'),
            'tgl_ujian_akhir' => $this->input->post('tgl_ujian_akhir'),
            'active' => 1
        );
        $query_id = $this->input->save_query($query_array);
        redirect("transaction/ujian_skripsi/view/$query_id");
    }

    function info() {
        $id = $this->uri->segment(3);
        $data['auth'] = $this->auth;
        $criteria = array(
            't_ujian_skripsi.id' => $id
        );
        $this->load->model('ujian_skripsi_model', 'ujian_skripsi');
        $result = $this->ujian_skripsi->get_many('', $criteria)->row_array();
        //[debug]echo get_instance()->db->last_query();
        $result_keys = array_keys($result);
        foreach ($result_keys as $result_key) {
            $data[$result_key] = $result[$result_key];
        }

        $data['tools'] = array(
            'transaction/ujian_skripsi' => 'Back',
            'transaction/ujian_skripsi/' . $id . '/edit' => 'Edit',
            'transaction/ujian_skripsi/' . $id . '/delete' => 'Delete'
        );
        $data['page_title'] = 'Detail Ujian Skripsi';
        $this->load->view('transaction/ujian_skripsi_info', $data);
    }

    function delete() {
        $id = $this->uri->segment(3);
        $this->crud->use_table('t_ujian_skripsi');
        $criteria = array('id' => $id);
        $data_in = array(
            'active'      => 0,
            'modified_on' => logged_info()->on,
            'modified_by' => logged_info()->by
        );
        $this->crud->update($criteria, $data_in);
        redirect('transaction/ujian_skripsi');
    }

    function create() {
        $data['auth']        = $this->auth;
        $data['action_type'] = __FUNCTION__;
        $master_url          = 'transaction/ujian_skripsi/';

        $this->load->library(array('form_validation', 'table'));
        $this->load->helper(array('form', 'snippets'));
        $this->form_validation->set_error_delimiters('<span class="notice">', '</span>');
        if ($this->form_validation->run('ujian_skripsi_create') === FALSE) {
            //don't do anything
        } else {
            $this->crud->use_table('t_ujian_skripsi');
            $data_in = array(
                'nim'             => $this->input->post('nim'),
                'judul_skripsi'   => $this->input->post('judul_skripsi'),
                'tgl_ujian_start' => $this->input->post('tgl_ujian_start'),
                'tgl_ujian_akhir' => $this->input->post('tgl_ujian_akhir'),
                'created_on'      => date($this->config->item('log_date_format')),
                'created_by'      => logged_info()->on
            );
            /*
              echo '<pre>';
              var_dump($data_in);
              echo '</pre>';
             */
            $created_id = $this->crud->create($data_in);
            redirect('transaction/ujian_skripsi/' . $created_id . '/info');
        }
        $data['action_url'] = $master_url . __FUNCTION__;
        $data['page_title'] = 'Create Ujian Skripsi';
        $data['tools']      = array(
            'transaction/ujian_skripsi' => 'Back'
        );

        $this->load->model('ujian_skripsi_model', 'ujian_skripsi');
        $data = array_merge($data, $this->ujian_skripsi->set_default()); //merge dengan arr data dengan default
        
        $data['nim'] = ''; 
        
        $this->load->view('transaction/ujian_skripsi_form', $data);
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
        $master_url          = 'transaction/ujian_skripsi/';
        $id                  = $this->uri->segment(3);

        $this->load->library(array('form_validation', 'table'));
        $this->load->helper(array('form', 'snippets'));
        $this->form_validation->set_error_delimiters('<span class="notice">', '</span>');
        if ($this->form_validation->run('ujian_skripsi_update') === FALSE) {
            //don't do anything
        } else {
            $this->crud->use_table('t_ujian_skripsi');
            $criteria = array(
                'id' => $id
            );
            $data_in = array(
                'nim'             => $this->input->post('nim'),
                'judul_skripsi'   => $this->input->post('judul_skripsi'),
                'tgl_ujian_start' => $this->input->post('tgl_ujian_start'),
                'tgl_ujian_akhir' => $this->input->post('tgl_ujian_akhir'),
                'modified_on'     => date($this->config->item('log_date_format')),
                'modified_by'     => logged_info()->on
            );
            $this->crud->update($criteria, $data_in);
            redirect('transaction/ujian_skripsi/' . $id . '/info');
        }
        $data['action_url'] = $master_url . $id . '/' . __FUNCTION__;
        $data['page_title'] = 'Update Ujian Skripsi';
        $data['tools']      = array(
            'transaction/ujian_skripsi' => 'Back'
        );

        $this->crud->use_table('t_ujian_skripsi');
        $angkatan_data = $this->crud->retrieve(array('id' => $id))->row();

        $this->load->model('ujian_skripsi_model', 'ujian_skripsi');
        $data = array_merge($data, $this->angkatan->set_default()); //merge dengan arr data dengan default
        $data = array_merge($data, (array) $angkatan_data);
        $this->load->view('transaction/ujian_skripsi_form', $data);
    }

    function unique_judul_skripsi($judul_skripsi) {
        $this->crud->use_table('t_ujian_skripsi');
        $ujian_skripsi = $this->crud->retrieve(array('judul_skripsi' => $judul_skripsi))->row();
        if (sizeof($ujian_skripsi) > 0) {
            $this->form_validation->set_message(__FUNCTION__, 'judul skripsi sudah terdaftar'); //pakai function karena ini harus sama dengan nama function nya
            return FALSE;
        } else {
            return true;
        }
    }

    function suggestion() {
        $this->load->model('ujian_skripsi_model');
        $ujian_skripsi = $this->input->get('ujian_skripsi');
        $terms = array(
            'judul_skripsi' => $judul_skripsi
        );
        $this->ujian_skripsi_model->suggestion($terms);
    }

}

?>
