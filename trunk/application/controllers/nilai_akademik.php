<?php

/*
 * Imam
 * Transaksi :  Nilai Akademik
 * 9/9/2012
 */

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Nilai_akademik extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->helper(array('snippets_helper'));
        $this->load->model('crud_model', 'crud');
    }

    function log_date() {
        return date($this->config->item('log_date_format'));
    }

    function index($query_id = 0, $sort_by = 'id', $sort_order = 'desc', $offset = 0) {
        $this->nilai_akademik($query_id, $sort_by, $sort_order, $offset);
    }

    function nilai_akademik($query_id = 0, $sort_by = 'id', $sort_order = 'desc', $offset = 0) {
        $data_type    = $this->input->post('data_type');
        $data['auth'] = $this->auth;
        // pagination
        $limit = 20;
        $this->load->library(array('form_validation', 'table', 'pagination'));
        $this->input->load_query($query_id);
        $query_array = array(
            'nim' => $this->input->get('nim'),
            'nama_mata_kuliah' => $this->input->get('nama_mata_kuliah'),
            'active' => 1
        );

        $this->load->model('nilai_akademik_model', 'nilai_akademik');
        $results = $this->nilai_akademik->search($query_array, $limit, $offset, $sort_by, $sort_order);
        //echo get_instance()->db->last_query();
        $data['results']     = $results['results'];
        $data['num_results'] = $results['num_rows'];

        // pagination
        $config = array();
        $config['base_url']    = site_url("transaction/nilai_akademik/$query_id/$sort_by/$sort_order");
        $config['total_rows']  = $data['num_results'];
        $config['per_page']    = $limit;
        $config['uri_segment'] = 6;
        $config['num_links']   = 6;

        $config = array_merge($config, default_pagination_btn());
        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();
        $data['sort_by']    = $sort_by;
        $data['sort_order'] = $sort_order;

        $data['page_title'] = 'Nilai Akademik';

        $data['tools'] = array(
            'transaction/nilai_akademik/create' => 'New'
        );

        $this->load->view('transaction/nilai_akademik', $data);
    }

    function search() {
        $query_array = array(
            'nilai_nts' => $this->input->get('nilai_nts'),
            'nilai_tgs' => $this->input->get('nilai_tgs'),
            'nilai_nas' => $this->input->get('nilai_nas'),
            'nilai_prb' => $this->input->get('nilai_prb'),
            'active' => 1
        );
        $query_id = $this->input->save_query($query_array);
        redirect("transaction/nilai_akademik/view/$query_id");
    }

    function info() {
        $id = $this->uri->segment(3);
        $data['auth'] = $this->auth;
        $criteria = array(
            't_nilai_akademik.id' => $id
        );
        $this->load->model('nilai_akademik_model', 'nilai_akademik');
        $result = $this->nilai_akademik->get_many('', $criteria)->row_array();
        //[debug]echo get_instance()->db->last_query();
        $result_keys = array_keys($result);
        foreach ($result_keys as $result_key) {
            $data[$result_key] = $result[$result_key];
        }

        $data['tools'] = array(
            'transaction/nilai_akademik' => 'Back',
            'transaction/nilai_akademik/' . $id . '/edit' => 'Edit',
            'transaction/nilai_akademik/' . $id . '/delete' => 'Delete'
        );
        $data['page_title'] = 'Detail Nilai Akademik';
        $this->load->view('transaction/nilai_akademik_info', $data);
    }

    function delete() {
        $id = $this->uri->segment(3);
        $this->crud->use_table('t_nilai_akademik');
        $criteria = array('id' => $id);
        $data_in = array(
            'active' => 0,
            'modified_on' => logged_info()->on,
            'modified_by' => logged_info()->by
        );
        $this->crud->update($criteria, $data_in);
        redirect('transaction/nilai_akademik');
    }

    function create() {
        $data['auth'] = $this->auth;
        $data['action_type'] = __FUNCTION__;
        $master_url = 'transaction/nilai_akademik/';

        $this->load->library(array('form_validation', 'table'));
        $this->load->helper(array('form', 'snippets'));
        $this->form_validation->set_error_delimiters('<span class="notice">', '</span>');
        if ($this->form_validation->run('nilai_akademik_create') === FALSE) {
            //don't do anything
        } else {
            $this->crud->use_table('t_nilai_akademik');
            $data_in = array(
                'mahasiswa_id'   => $this->input->post('mahasiswa_id'),
                'mata_kuliah_id' => $this->input->post('mata_kuliah_id'),
                'nilai_nts'      => $this->input->post('nilai_nts'),
                'nilai_tgs'      => $this->input->post('nilai_tgs'),
                'nilai_nas'      => $this->input->post('nilai_nas'),
                'nilai_prb'      => $this->input->post('nilai_prb'),
                'nilai_akhir'    => $this->input->post('nilai_akhir'),
                'created_on'     => date($this->config->item('log_date_format')),
                'created_by'     => logged_info()->on
            );
            /*
              echo '<pre>';
              var_dump($data_in);
              echo '</pre>';
             */
            $created_id = $this->crud->create($data_in);
            redirect('transaction/nilai_akademik/' . $created_id . '/info');
        }
        $data['action_url'] = $master_url . __FUNCTION__;
        $data['page_title'] = 'Create Nilai Akademik';
        $data['tools'] = array(
            'transaction/nilai_akademik' => 'Back'
        );

        $this->load->model('nilai_akademik_model', 'nilai_akademik');
        $data = array_merge($data, $this->nilai_akademik->set_default()); //merge dengan arr data dengan default
        
        $data['nim']              = '';
        $data['nama_mata_kuliah'] = '';
        
        $this->load->view('transaction/nilai_akademik_form', $data);
    }

    function edit() {
        $data['auth'] = $this->auth;
        $data['action_type'] = __FUNCTION__;
        $master_url = 'transaction/nilai_akademik/';
        $id = $this->uri->segment(3);

        $this->load->library(array('form_validation', 'table'));
        $this->load->helper(array('form', 'snippets'));
        $this->form_validation->set_error_delimiters('<span class="notice">', '</span>');
        if ($this->form_validation->run('nilai_akademik_update') === FALSE) {
            //don't do anything
        } else {
            $this->crud->use_table('t_nilai_akademik');
            $criteria = array(
                'id' => $id
            );
            $data_in = array(
                'mahasiswa_id'   => $this->input->post('mahasiswa_id'),
                'mata_kuliah_id' => $this->input->post('mata_kuliah_id'),
                'nilai_nts'      => $this->input->post('nilai_nts'),
                'nilai_tgs'      => $this->input->post('nilai_tgs'),
                'nilai_nas'      => $this->input->post('nilai_nas'),
                'nilai_prb'      => $this->input->post('nilai_prb'),
                'nilai_akhir'    => $this->input->post('nilai_akhir'),
                'modified_on'    => date($this->config->item('log_date_format')),
                'modified_by'    => logged_info()->on
            );
            $this->crud->update($criteria, $data_in);
            redirect('transaction/nilai_akademik/' . $id . '/info');
        }
        $data['action_url'] = $master_url . $id . '/' . __FUNCTION__;
        $data['page_title'] = 'Update Nilai Akademik';
        $data['tools']      = array(
            'transaction/nilai_akademik' => 'Back'
        );

        $this->crud->use_table('t_nilai_akademik');
        $nilai_akademik_data = $this->crud->retrieve(array('id' => $id))->row();

        $this->load->model('nilai_akademik_model', 'nilai_akademik');
        $data = array_merge($data, $this->nilai_akademik->set_default()); //merge dengan arr data dengan default
        $data = array_merge($data, (array) nilai_akademik);
        $this->load->view('transaction/nilai_akademik_form', $data);
    }

    function suggestion() {
        $this->load->model('mahasiswa_model');
        $nim   = $this->input->get('nim');
        $terms = array(
            'nim' => $nim
        );
        $this->mahasiswa_model->suggestion($terms);
    }

}

?>
