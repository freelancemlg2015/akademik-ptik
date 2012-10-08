<?php

/*
 * Imam Syarifudin
 * Master Tugas Imam : Jenis Kelamin
 * 5/9/2012
 */

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Jenis_kelamin extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->helper(array('snippets_helper'));
        $this->load->model('crud_model', 'crud');
    }

    function log_date() {
        return date($this->config->item('log_date_format'));
    }

    function index($query_id = 0, $sort_by = 'id', $sort_order = 'desc', $offset = 0) {
        $this->jenis_kelamin($query_id, $sort_by, $sort_order, $offset);
    }

    function jenis_kelamin($query_id = 0, $sort_by = 'id', $sort_order = 'desc', $offset = 0) {
        $data_type = $this->input->post('data_type');
        $data['auth'] = $this->auth;
        // pagination
        $limit = 20;
        $this->load->library(array('form_validation', 'table', 'pagination'));
        $this->input->load_query($query_id);
        $query_array = array(
            'jenis_kelamin' => $this->input->get('jenis_kelamin'),
            'active' => 1
        );

        $this->load->model('jenis_kelamin_model', 'jenis_kelamin');
        $results = $this->jenis_kelamin->search($query_array, $limit, $offset, $sort_by, $sort_order);
        //echo get_instance()->db->last_query();
        $data['results'] = $results['results'];
        $data['num_results'] = $results['num_rows'];

        // pagination
        $config = array();
        $config['base_url'] = site_url("master/jenis_kelamin/$query_id/$sort_by/$sort_order");
        $config['total_rows'] = $data['num_results'];
        $config['per_page'] = $limit;
        $config['uri_segment'] = 6;
        $config['num_links'] = 6;

        $config = array_merge($config, default_pagination_btn());
        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();
        $data['sort_by'] = $sort_by;
        $data['sort_order'] = $sort_order;

        $data['page_title'] = 'Jenis Kelamin';

        $data['tools'] = array(
            'master/jenis_kelamin/create' => 'New'
        );

        $this->load->view('master/jenis_kelamin', $data);
    }

    function search() {
        $query_array = array(
            'jenis_kelamin' => $this->input->post('jenis_kelamin'),
            'active' => 1
        );
        $query_id = $this->input->save_query($query_array);
        redirect("master/jenis_kelamin/view/$query_id");
    }

    function info() {
        $id = $this->uri->segment(3);
        $data['auth'] = $this->auth;
        $criteria = array(
            'm_jenis_kelamin.id' => $id
        );
        $this->load->model('jenis_kelamin_model', 'jenis_kelamin');
        $result = $this->jenis_kelamin->get_many('', $criteria)->row_array();
        //[debug]echo get_instance()->db->last_query();
        $result_keys = array_keys($result);
        foreach ($result_keys as $result_key) {
            $data[$result_key] = $result[$result_key];
        }

        $data['tools'] = array(
            'master/jenis_kelamin' => 'Back',
            'master/jenis_kelamin/' . $id . '/edit' => 'Edit',
            'master/jenis_kelamin/' . $id . '/delete' => 'Delete'
        );
        $data['page_title'] = 'Detail Jenis Kelamin';
        $this->load->view('master/jenis_kelamin_info', $data);
    }

    function delete() {
        $id = $this->uri->segment(3);
        $this->crud->use_table('m_jenis_kelamin');
        $criteria = array('id' => $id);
        $data_in = array(
            'active' => 0,
            'modified_on' => logged_info()->on,
            'modified_by' => logged_info()->by
        );
        $this->crud->update($criteria, $data_in);
        redirect('master/jenis_kelamin');
    }

    function create() {
        $data['auth'] = $this->auth;
        $data['action_type'] = __FUNCTION__;
        $master_url = 'master/jenis_kelamin/';

        $this->load->library(array('form_validation', 'table'));
        $this->load->helper(array('form', 'snippets'));
        $this->form_validation->set_error_delimiters('<span class="notice">', '</span>');
        if ($this->form_validation->run('jenis_kelamin_create') === FALSE) {
            //don't do anything
        } else {
            $this->crud->use_table('m_jenis_kelamin');
            $data_in = array(
                'jenis_kelamin' => $this->input->post('jenis_kelamin'),
                'created_on' => date($this->config->item('log_date_format')),
                'created_by' => logged_info()->on
            );
            /*
              echo '<pre>';
              var_dump($data_in);
              echo '</pre>';
             */
            $created_id = $this->crud->create($data_in);
            redirect('master/jenis_kelamin/' . $created_id . '/info');
        }
        $data['action_url'] = $master_url . __FUNCTION__;
        $data['page_title'] = 'Create Jenis Kelamin';
        $data['tools'] = array(
            'master/jenis_kelamin' => 'Back'
        );

        $this->load->model('jenis_kelamin_model', 'jenis_kelamin');
        $data = array_merge($data, $this->jenis_kelamin->set_default()); //merge dengan arr data dengan default
        $this->load->view('master/jenis_kelamin_form', $data);
    }

    function edit() {
        $data['auth'] = $this->auth;
        $data['action_type'] = __FUNCTION__;
        $master_url = 'master/jenis_kelamin/';
        $id = $this->uri->segment(3);

        $this->load->library(array('form_validation', 'table'));
        $this->load->helper(array('form', 'snippets'));
        $this->form_validation->set_error_delimiters('<span class="notice">', '</span>');
        if ($this->form_validation->run('jenis_kelamin_update') === FALSE) {
            //don't do anything
        } else {
            $this->crud->use_table('m_jenis_kelamin');
            $criteria = array(
                'id' => $id
            );
            $data_in = array(
                'jenis_kelamin' => $this->input->post('jenis_kelamin'),
                'modified_on' => date($this->config->item('log_date_format')),
                'modified_by' => logged_info()->on
            );
            $this->crud->update($criteria, $data_in);
            redirect('master/jenis_kelamin/' . $id . '/info');
        }
        $data['action_url'] = $master_url . $id . '/' . __FUNCTION__;
        $data['page_title'] = 'Update Jenis Kelamin';
        $data['tools'] = array(
            'master/jenis_kelamin' => 'Back'
        );

        $this->crud->use_table('m_jenis_kelamin');
        $jenis_kelamin_data = $this->crud->retrieve(array('id' => $id))->row();

        $this->load->model('jenis_kelamin_model', 'jenis_kelamin');
        $data = array_merge($data, $this->jenis_kelamin->set_default()); //merge dengan arr data dengan default
        $data = array_merge($data, (array) $jenis_kelamin_data);
        $this->load->view('master/jenis_kelamin_form', $data);
    }

    function unique_jenis_kelamin($jenis_kelamin) {
        $this->crud->use_table('m_jenis_kelamin');
        $angkatan = $this->crud->retrieve(array('jenis_kelamin' => $jenis_kelamin))->row();
        if (sizeof($angkatan) > 0) {
            $this->form_validation->set_message(__FUNCTION__, 'Jenis Kelamin sudah terdaftar'); //pakai function karena ini harus sama dengan nama function nya
            return FALSE;
        } else {
            return true;
        }
    }

}

?>
