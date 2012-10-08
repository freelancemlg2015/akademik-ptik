<?php

/*
 * Imam Syarifudin
 * Master Tugas Imam : Kesatuan Asal
 * 5/9/2012
 */

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Kesatuan_asal extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->helper(array('snippets_helper'));
        $this->load->model('crud_model', 'crud');
    }

    function log_date() {
        return date($this->config->item('log_date_format'));
    }

    function index($query_id = 0, $sort_by = 'id', $sort_order = 'desc', $offset = 0) {
        $this->kesatuan_asal($query_id, $sort_by, $sort_order, $offset);
    }

    function kesatuan_asal($query_id = 0, $sort_by = 'id', $sort_order = 'desc', $offset = 0) {
        $data_type = $this->input->post('data_type');
        $data['auth'] = $this->auth;
        // pagination
        $limit = 20;
        $this->load->library(array('form_validation', 'table', 'pagination'));
        $this->input->load_query($query_id);
        $query_array = array(
            'kode_kesatuan_asal' => $this->input->get('kode_kesatuan_asal'),
            'nama_kesatuan_asal' => $this->input->get('nama_kesatuan_asal'),
            'active' => 1
        );

        $this->load->model('kesatuan_asal_model', 'kesatuan_asal');
        $results = $this->kesatuan_asal->search($query_array, $limit, $offset, $sort_by, $sort_order);
        //echo get_instance()->db->last_query();
        $data['results'] = $results['results'];
        $data['num_results'] = $results['num_rows'];

        // pagination
        $config = array();
        $config['base_url'] = site_url("master/kesatuan_asal/$query_id/$sort_by/$sort_order");
        $config['total_rows'] = $data['num_results'];
        $config['per_page'] = $limit;
        $config['uri_segment'] = 6;
        $config['num_links'] = 6;

        $config = array_merge($config, default_pagination_btn());
        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();
        $data['sort_by'] = $sort_by;
        $data['sort_order'] = $sort_order;

        $data['page_title'] = 'Kesatuan Asal';

        $data['tools'] = array(
            'master/kesatuan_asal/create' => 'New'
        );

        $this->load->view('master/kesatuan_asal', $data);
    }

    function search() {
        $query_array = array(
            'kode_kesatuan_asal' => $this->input->post('kode_kesatuan_asal'),
            'nama_kesatuan_asal' => $this->input->post('nama_kesatuan_asal'),
            'active' => 1
        );
        $query_id = $this->input->save_query($query_array);
        redirect("master/kesatuan_asal/view/$query_id");
    }

    function info() {
        $id = $this->uri->segment(3);
        $data['auth'] = $this->auth;
        $criteria = array(
            'm_kesatuan_asal.id' => $id
        );
        $this->load->model('kesatuan_asal_model', 'kesatuan_asal');
        $result = $this->kesatuan_asal->get_many('', $criteria)->row_array();
        //[debug]echo get_instance()->db->last_query();
        $result_keys = array_keys($result);
        foreach ($result_keys as $result_key) {
            $data[$result_key] = $result[$result_key];
        }

        $data['tools'] = array(
            'master/kesatuan_asal' => 'Back',
            'master/kesatuan_asal/' . $id . '/edit' => 'Edit',
            'master/kesatuan_asal/' . $id . '/delete' => 'Delete'
        );
        $data['page_title'] = 'Detail Kesatuan Asal';
        $this->load->view('master/kesatuan_asal_info', $data);
    }

    function delete() {
        $id = $this->uri->segment(3);
        $this->crud->use_table('m_kesatuan_asal');
        $criteria = array('id' => $id);
        $data_in = array(
            'active' => 0,
            'modified_on' => logged_info()->on,
            'modified_by' => logged_info()->by
        );
        $this->crud->update($criteria, $data_in);
        redirect('master/kesatuan_asal');
    }

    function create() {
        $data['auth'] = $this->auth;
        $data['action_type'] = __FUNCTION__;
        $master_url = 'master/kesatuan_asal/';

        $this->load->library(array('form_validation', 'table'));
        $this->load->helper(array('form', 'snippets'));
        $this->form_validation->set_error_delimiters('<span class="notice">', '</span>');
        if ($this->form_validation->run('kesatuan_asal_create') === FALSE) {
            //don't do anything
        } else {
            $this->crud->use_table('m_kesatuan_asal');
            $data_in = array(
                'kode_kesatuan_asal' => $this->input->post('kode_kesatuan_asal'),
                'nama_kesatuan_asal' => $this->input->post('nama_kesatuan_asal'),
                'created_on' => date($this->config->item('log_date_format')),
                'created_by' => logged_info()->on
            );
            /*
              echo '<pre>';
              var_dump($data_in);
              echo '</pre>';
             */
            $created_id = $this->crud->create($data_in);
            redirect('master/kesatuan_asal/' . $created_id . '/info');
        }
        $data['action_url'] = $master_url . __FUNCTION__;
        $data['page_title'] = 'Create Kesatuan Asal';
        $data['tools'] = array(
            'master/kesatuan_asal' => 'Back'
        );

        $this->load->model('kesatuan_asal_model', 'kesatuan_asal');
        $data = array_merge($data, $this->kesatuan_asal->set_default()); //merge dengan arr data dengan default
        $this->load->view('master/kesatuan_asal_form', $data);
    }

    function edit() {
        $data['auth'] = $this->auth;
        $data['action_type'] = __FUNCTION__;
        $master_url = 'master/kesatuan_asal/';
        $id = $this->uri->segment(3);

        $this->load->library(array('form_validation', 'table'));
        $this->load->helper(array('form', 'snippets'));
        $this->form_validation->set_error_delimiters('<span class="notice">', '</span>');
        if ($this->form_validation->run('kesatuan_asal_update') === FALSE) {
            //don't do anything
        } else {
            $this->crud->use_table('m_kesatuan_asal');
            $criteria = array(
                'id' => $id
            );
            $data_in = array(
                'kode_kesatuan_asal' => $this->input->post('kode_kesatuan_asal'),
                'nama_kesatuan_asal' => $this->input->post('nama_kesatuan_asal'),
                'modified_on' => date($this->config->item('log_date_format')),
                'modified_by' => logged_info()->on
            );
            $this->crud->update($criteria, $data_in);
            redirect('master/kesatuan_asal/' . $id . '/info');
        }
        $data['action_url'] = $master_url . $id . '/' . __FUNCTION__;
        $data['page_title'] = 'Update Kesatuan Asal';
        $data['tools'] = array(
            'master/kesatuan_asal' => 'Back'
        );

        $this->crud->use_table('m_kesatuan_asal');
        $kesatuan_asal_data = $this->crud->retrieve(array('id' => $id))->row();

        $this->load->model('kesatuan_asal_model', 'kesatuan_asal');
        $data = array_merge($data, $this->kesatuan_asal->set_default()); //merge dengan arr data dengan default
        $data = array_merge($data, (array) $kesatuan_asal_data);
        $this->load->view('master/kesatuan_asal_form', $data);
    }

    function unique_kode_kesatuan_asal($kode_kesatuan_asal) {
        $this->crud->use_table('m_kesatuan_asal');
        $kesatuan_asal = $this->crud->retrieve(array('kode_kesatuan_asal' => $kode_kesatuan_asal))->row();
        if (sizeof($kesatuan_asal) > 0) {
            $this->form_validation->set_message(__FUNCTION__, 'Kode Kesatuan Asal sudah terdaftar'); //pakai function karena ini harus sama dengan nama function nya
            return FALSE;
        } else {
            return true;
        }
    }

}

?>
