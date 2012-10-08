<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Auth {

    public function __construct() {
        $this->_assign_libraries();
    }

    public function _assign_libraries() {
        $CI = & get_instance();

        $this->input = $CI->input;
        $this->load = $CI->load;
        $this->config = $CI->config;
        $this->lang = $CI->lang;

        $CI->load->library('session');
        $this->session = $CI->session;

        $CI->load->library('encrypt');
        $this->encrypt = $CI->encrypt;

        $this->load->database();
        $this->db = $CI->db;

        //load model
        $this->load->model(array('capability_model', 'user_model', 'role_model','crud'));
        $this->capability_model = $CI->capability_model;
        $this->user_model = $CI->user_model;
        $this->role_model = $CI->role_model;
        $this->crud = $CI->crud;

        return;
    }

    function has_capability($capability) {
        $capability = $this->capability_model->get_capability('', array('capability' => $capability))->row_array();
        if (count($capability) > 0) {
            $capability_id = $capability['id'];
            $session = $this->session->userdata('logged_in');
            
            $role = $this->role_model->get_roles('', array('id' => $session['role']))->row_array();
            return in_array($capability_id, explode(',', $role['capabilities_id'])) ? TRUE : FALSE;
        } else {
            return FALSE;
        }
    }
    
    function has_role($nip) {// lom selesai
        $this->crud->use_table('m_role');
        $role = $this->crud->retrieve(array('active'=>1,'role' => $role),'role')->row();
        if (sizeof($role) > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    function logged_in() {
        $session = $this->session->userdata('logged_in');
        return $session['username'];
    }
    
    function my_role() {
        $session = $this->session->userdata('logged_in');
        $role = array();
        $role['id'] = $session['role'];
        $this->crud->use_table('m_roles');
        $row = $this->crud->retrieve(array('id' => $session['role'] ))->row();
        $role['name'] = $row->role;
        return $role;
    }

    /**
     * Auth::login()
     *
     * Process a login
     */
    function login() {
        //This method will have the credentials validation
        $this->load->library('form_validation');

        $this->form_validation->set_rules('username', 'Username', 'trim|required|xss_clean');
        $this->form_validation->set_rules('pass', 'Password', 'trim|required|xss_clean|callback_verify');
        $this->form_validation->set_error_delimiters('<span class="notice">', '</span>');
        if ($this->form_validation->run() == FALSE) {
            $this->load->library(array('table'));
            $this->load->helper(array('snippets'));
            //Field validation failed.  User redirected to login page
            // Redirect
            if ($this->session->userdata('logged_in'))
                redirect('home');
            else
                $this->load->view('login');
        } else {
            //Go to private area
            redirect('home');
        }
    }

    function verify($pass) {
        //Field validation succeeded.  Validate against database
        $username = $this->input->post('username');

        //query the database
        $result = $this->user_model->login($username, $pass);
        if ($result) {
            $sess_arr = array();
            foreach ($result as $row) {
                $sess_arr = array(
                    'username' => $row->username,
                    'role' => $row->role
                );
                $this->session->set_userdata('logged_in', $sess_arr);
            }
            return TRUE;
        } else {
            $this->form_validation->set_message('verify', 'Invalid NIP or password'); //'verify' adalah callback error pada saat pengecekan
            return FALSE;
        }
    }

    /**
     * Auth::logout()
     *
     * Logs out, destroys session, etc
     */
    function logout() {
        $this->session->unset_userdata('logged_in');
        $logout = $this->session->sess_destroy();
        if (!isset($logout)) {
            redirect(base_url());
        }
    }

    function capabilities($type = NULL) {
        $data_type = $this->input->post('data_type');
        $data['action_type'] = $type;
        $master_url = 'admin/capabilities/';
        $session = $this->session->userdata('logged_in');
        $data['username'] = $session['username'];


        switch ($type) {
            case 'create':
                $this->load->library(array('form_validation', 'table'));
                $this->load->helper(array('form', 'snippets'));

                $config = array(
                    array(
                        'field' => 'capability',
                        'label' => 'capability',
                        'rules' => 'trim|required|is_unique[m_capabilities.capability]'
                    )
                );
                $this->form_validation->set_rules($config);
                $this->form_validation->set_error_delimiters('<span class="notice">', '</span>');
                if ($this->form_validation->run() === FALSE) {
                    //don't do anything
                } else {
                    $this->_create_capability();
                }
                $data['action_url'] = $master_url . $type;
                $data['page_title'] = 'Create Capability';
                $data['tools'] = array(
                    'admin/capabilities' => '&laquo; Back'
                );
                $data = array_merge($data, $this->capability_model->set_default()); //merge dengan arr data dengan default
                $this->load->view('admin/capability_form', $data);
                break;
            case 'update':
                $this->load->library(array('form_validation', 'table')); //, 'session'));
                $this->load->helper(array('form', 'snippets'));
                $id = $this->uri->segment(4);
                $term = array(
                    'id' => $id
                );
                $config = array(
                    array(
                        'field' => 'capability',
                        'label' => 'capability',
                        'rules' => 'trim|required'
                    )
                );
                $this->form_validation->set_rules($config);
                $this->form_validation->set_error_delimiters('<span class="notice">', '</span>');
                if ($this->form_validation->run() === FALSE) {
                    //don't do anything
                } else {
                    $this->_update_capability($id);
                }

                $data['page_title'] = 'Update Capability';
                $data['action_type'] = $type;
                $data['tools'] = array(
                    'admin/capabilities' => '&laquo; Back'
                );
                $data['action_url'] = $master_url . $type . '/' . $id;
                $result = $this->capability_model->get_capability('', $term)->row_array();
                $result_keys = array_keys($result);
                foreach ($result_keys as $result_key) {
                    $data[$result_key] = $result[$result_key];
                }
                $this->load->view('admin/capability_form', $data);
                break;
            case 'delete':
                $this->load->helper(array('form'));
                break;
            default:
                $data['results'] = $this->capability_model->get_capability();
                $data['page_title'] = 'Suku Capability';
                $data['tools'] = array(
                    'admin/capabilities/create' => 'Create new'
                );
                $this->load->view('admin/capabilities', $data);
                break;
        }
    }

    function _create_capability() {
        $data = array();
        $this->load->model('capability_model');
        $data['capability'] = $this->input->post('capability');
        $data['description'] = $this->input->post('description');

        $this->capability_model->create_capability($data);
        redirect('admin/capabilities');
    }

    function _update_capability($id) {
        $data = array();
        $this->load->model('capability_model');
        $data['id'] = $id;
        $data['capability'] = $this->input->post('capability');
        $data['description'] = $this->input->post('description');
        $this->capability_model->update_capability($data);
        redirect('admin/capabilities');
    }

    function roles($type = NULL) {
        $data_type = $this->input->post('data_type');
        $data['action_type'] = $type;

        $session = $this->session->userdata('logged_in');
        $data['username'] = $session['username'];

        $master_url = 'admin/roles/';

        switch ($type) {
            case 'create':
                $this->load->library(array('form_validation', 'table')); //, 'session'));
                $this->load->helper(array('form', 'snippets'));

                $config = array(
                    array(
                        'field' => 'role',
                        'label' => 'Role',
                        'rules' => 'trim|required|is_unique[m_roles.role]'
                    ),
                    array(
                        'field' => 'description',
                        'label' => 'Description',
                        'rules' => 'trim|required'
                    )
                );
                $this->form_validation->set_rules($config);
                $this->form_validation->set_error_delimiters('<span class="notice">', '</span>');
                if ($this->form_validation->run() === FALSE) {
                    //don't do anything
                } else {
                    $this->_create_role();
                }

                $data['page_title'] = 'Create role';
                $data['action_url'] = $master_url . $type;
                $data['capabilities_option'] = $this->capability_model->get_capability();
                $this->load->model('role_model');
                $data = array_merge($data, $this->role_model->set_default()); //merge dengan arr data dengan default

                $this->load->view('admin/role_form', $data);
                break;

            case 'update':


                $this->load->library(array('form_validation', 'table')); //, 'session'));
                $this->load->helper(array('form', 'snippets'));
                $id = $this->uri->segment(4);
                $term = array(
                    'm_roles.id' => $id
                );
                $config = array(
                    array(
                        'field' => 'role',
                        'label' => 'Role',
                        'rules' => 'trim|required'
                    ),
                    array(
                        'field' => 'description',
                        'label' => 'Description',
                        'rules' => 'trim|required'
                    )
                );
                $this->form_validation->set_rules($config);
                $this->form_validation->set_error_delimiters('<span class="notice">', '</span>');
                if ($this->form_validation->run() === FALSE) {
                    //don't do anything
                } else {
                    $this->_update_role($id);
                }

                $data['action_url'] = $master_url . $type . '/' . $id;
                $data['page_title'] = 'Update role';

                $this->load->model(array('role_model', 'capability_model'));
                $result = $this->role_model->get_roles('', $term)->row_array();
                $result_keys = array_keys($result);
                foreach ($result_keys as $result_key) {
                    $data[$result_key] = $result[$result_key];
                }
                $data['capabilities_option'] = $this->capability_model->get_capability();

                $data['tools'] = array(
                    'admin/roles' => 'Back'
                );


                $this->load->view('admin/role_form', $data);
                break;

            case 'delete':
                $this->load->helper(array('form'));
                break;
            default:
                $this->load->model('role_model');
                $data['results'] = $this->role_model->get_roles();
                $data['page_title'] = 'Roles';
                $data['tools'] = array(
                    'admin/roles/create' => 'Create new'
                );
                $this->load->view('admin/roles', $data);
                break;
        }
    }

    function _create_role() {
        $data = array();
        // Assign the query data
        $data['role'] = $this->input->post('role');
        $data['description'] = $this->input->post('description');
        $data['capabilities_id'] = implode(',', $this->input->post('capability'));
        $this->load->model('role_model');

        $capability_id = $this->role_model->create_role($data);
        redirect('admin/roles');
    }

    function _update_role($id) {
        $data = array();
        $this->load->model('role_model');
        $data['id'] = $id;
        $data['role'] = $this->input->post('role');
        $data['description'] = $this->input->post('description');
        $data['capabilities_id'] = implode(',', $this->input->post('capability'));
        $this->role_model->update_role($data);
        redirect('admin/roles');
    }

    /**
     * Bitauth::_assign_libraries()
     *
     * Grab everything from the CI superobject that we need
     */
}