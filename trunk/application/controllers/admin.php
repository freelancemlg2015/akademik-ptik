<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Admin extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->helper(array('snippets_helper'));
        $this->load->model('crud_model', 'crud');
    }

    function index() {
        redirect('admin/users');
    }

    function test_auth() {
        $this->load->view('_shared/menus_test');
    }

    function log_date() {
        return date($this->config->item('log_date_format'));
    }

    function _default_pagination_btn() {
        $config['full_tag_open'] = '<ul>';
        $config['full_tag_close'] = '</ul>';

        $config['first_link'] = 'First';
        $config['first_tag_open'] = '<li class="first">';
        $config['first_tag_close'] = '</li>';

        $config['last_link'] = 'Last';
        $config['last_tag_open'] = '<li class="last">';
        $config['last_tag_close'] = '</li>';

        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';

        $config['next_link'] = 'Next &rarr;';
        $config['next_tag_open'] = '<li class="next">';
        $config['next_tag_close'] = '</li>';

        $config['prev_link'] = '&larr; Previous';
        $config['prev_tag_open'] = '<li class="prev">';
        $config['prev_tag_close'] = '</li>';

        $config['cur_tag_open'] = '<li class="active"><a href="#">';
        $config['cur_tag_close'] = '</a></li>';

        return $config;
    }

    /**
     *
     * @param type $type { create, update, delete }
     */
    function users($type = NULL, $query_id = 0, $sort_by = 'username', $sort_order = 'asc', $offset = 0) {

        $data_type = $this->input->post('data_type');
        $data['action_type'] = $type;
        $master_url = 'admin/users/';
        $data['auth'] = $this->auth;

        switch ($type) {
            case 'create':
                $this->load->library(array('form_validation', 'table'));
                $this->load->helper(array('form', 'snippets'));

                $config = array(
                    array(
                        'field' => 'username',
                        'label' => 'Username / NIP',
                        'rules' => 'trim|required|is_unique[m_users.username]'
                    ),
                    array(
                        'field' => 'pass',
                        'label' => 'Password',
                        'rules' => 'trim|required'
                    ),
                    array(
                        'field' => 'display_name',
                        'label' => 'Display name',
                        'rules' => 'trim|required'
                    ),
                    array(
                        'field' => 'fullname',
                        'label' => 'Fullname',
                        'rules' => 'trim|required'
                    ),
                    array(
                        'field' => 'email',
                        'label' => 'Email',
                        'rules' => 'trim|required'
                    ),
                    array(
                        'field' => 'telephone',
                        'label' => 'Telephone',
                        'rules' => 'trim|required'
                    ),
                    array(
                        'field' => 'role',
                        'label' => 'Role',
                        'rules' => 'trim|greater_than[0]'
                    )
                );
                $this->form_validation->set_rules($config);
                $this->form_validation->set_error_delimiters('<span class="notice">', '</span>');
                if ($this->form_validation->run() === FALSE) {
                    //don't do anything
                } else {
                    $this->_create_user();
                }

                $data['action_url'] = $master_url . $type;
                $data['page_title'] = 'New Admin';
                $data['tools'] = array(
                    'admin/users' => '&laquo; Back'
                );

                $this->load->model('role_model');
                $data['roles'] = $this->role_model->get_roles();
                $data['page_title'] = 'Create user';

                $data = array_merge($data, $this->user_model->set_default());

                $this->load->view('admin/user_form', $data);
                break;
            case 'update':
                $this->load->library(array('form_validation', 'table')); //, 'session'));
                $this->load->helper(array('form', 'snippets'));
                $this->load->model('user_model');
                $id = $this->uri->segment(4);

                $term = array(
                    'id' => $id
                );
                $config = array(
                    array(
                        'field' => 'username',
                        'label' => 'Username',
                        'rules' => 'trim|required'
                    ),
                    array(
                        'field' => 'display_name',
                        'label' => 'Display Name',
                        'rules' => 'trim|required'
                    ),
                    array(
                        'field' => 'fullname',
                        'label' => 'Fullname',
                        'rules' => 'trim|required'
                    ),
                    array(
                        'field' => 'email',
                        'label' => 'Email',
                        'rules' => 'trim|required'
                    ),
                    array(
                        'field' => 'telephone',
                        'label' => 'Telephone',
                        'rules' => 'trim|required'
                    ),
                    array(
                        'field' => 'role',
                        'label' => 'Role',
                        'rules' => 'trim|required'
                    )
                );
                $this->form_validation->set_rules($config);
                $this->form_validation->set_error_delimiters('<span class="notice">', '</span>');
                if ($this->form_validation->run() === FALSE) {
                    //don't do anything
                } else {
                    $this->_update_user($id);
                }

                $data['action_url'] = $master_url . $type . '/' . $id;
                $data['page_title'] = 'Update role';

                $this->load->model(array('user_model'));
                $result = $this->user_model->get_users('', $term)->row_array();
                $result_keys = array_keys($result);
                foreach ($result_keys as $result_key) {
                    $data[$result_key] = $result[$result_key];
                }


                $this->load->model('role_model');
                $data['roles'] = $this->role_model->get_roles();
                $data['tools'] = array(
                    'admin/users' => 'Back'
                );
                $this->load->view('admin/user_form', $data);
                break;
            case 'info':
                $this->load->library(array('form_validation', 'table')); //, 'session'));
                $this->load->helper(array('form', 'snippets'));
                $this->load->model('user_model');
                $id = $this->uri->segment(4);

                $term = array(
                    'id' => $id
                );

                $config = array(
                    array(
                        'field' => 'username',
                        'label' => 'Username',
                        'rules' => 'trim|required'
                    ),
                    array(
                        'field' => 'display_name',
                        'label' => 'Display Name',
                        'rules' => 'trim|required'
                    ),
                    array(
                        'field' => 'fullname',
                        'label' => 'Fullname',
                        'rules' => 'trim|required'
                    ),
                    array(
                        'field' => 'email',
                        'label' => 'Email',
                        'rules' => 'trim|required'
                    ),
                    array(
                        'field' => 'telephone',
                        'label' => 'Telephone',
                        'rules' => 'trim|required'
                    )
                );
                $this->form_validation->set_rules($config);
                $this->form_validation->set_error_delimiters('<span class="notice">', '</span>');
                if ($this->form_validation->run() === FALSE) {
                    //don't do anything
                } else {
                    $this->_update_user($id);
                }

                $data['action_url'] = $master_url . $type . '/' . $id;
                $data['page_title'] = 'Update role';

                $this->load->model(array('user_model'));
                $result = $this->user_model->get_users('', $term)->row_array();
                $result_keys = array_keys($result);
                foreach ($result_keys as $result_key) {
                    $data[$result_key] = $result[$result_key];
                }

                $this->load->model('role_model');
                $data['roles'] = $this->role_model->get_roles();
                $data['tools'] = array(
                    'admin/users' => 'Back'
                );
                $this->load->view('admin/user_form', $data);
                break;
            case 'delete':
                $this->load->helper(array('form'));
                break;
            case 'search' :
                $query_array = array(
                    'username' => $this->input->post('user')
                );

                $query_id = $this->input->save_query($query_array);

                redirect("admin/users/view/$query_id");
                break;
            default:
                // pagination
                $limit = 20;
                $this->load->library(array('form_validation', 'table', 'pagination'));
                $this->load->model(array('user_model'));
                $this->input->load_query($query_id);

                $query_array = array(
                    'username' => $this->input->get('username')
                );
                $results = $this->user_model->search($query_array, $limit, $offset, $sort_by, $sort_order);

                $data['results'] = $results['results'];
                $data['num_results'] = $results['num_rows'];

                $config = array();
                $config['base_url'] = site_url("admin/users/view/$query_id/$sort_by/$sort_order");
                $config['total_rows'] = $data['num_results'];
                $config['per_page'] = $limit;
                $config['uri_segment'] = 7;
                $config['num_links'] = 6;

                $config = array_merge($config, $this->_default_pagination_btn());
                $this->pagination->initialize($config);
                $data['pagination'] = $this->pagination->create_links();
                $data['sort_by'] = $sort_by;
                $data['sort_order'] = $sort_order;
                $data['page_title'] = 'User';
                $data['tools'] = array(
                    'admin/users/create' => 'New'
                );
                $this->load->view('admin/users', $data);

                break;
        }
    }

    function _create_user() {
        $data = array();
        $date = new DateTime();

        $session = $this->session->userdata('logged_in');
        // Assign the query data
        $this->load->helper(array('date'));
        $data['username'] = $this->input->post('username');
        $data['pass'] = $this->input->post('pass');
        $data['display_name'] = $this->input->post('display_name');
        $data['fullname'] = $this->input->post('fullname');
        $data['email'] = $this->input->post('email');
        $data['telephone'] = $this->input->post('telephone');
        $data['role'] = $this->input->post('role');
        $data['created_on'] = $date->format($this->config->item('log_date_format'));
        $data['created_by'] = $session['username'];

        $this->load->model('user_model');
        $this->user_model->create_user($data);
        redirect('admin/users');
    }

    function _update_user($id) {
        $data = array();
        $date = new DateTime();

        $session = $this->session->userdata('logged_in');
        // Assign the query data
        $this->load->helper(array('date'));
        $data['id'] = $id;
        $data['username'] = $this->input->post('username');
        $data['pass'] = $this->input->post('pass');
        $data['display_name'] = $this->input->post('display_name');
        $data['fullname'] = $this->input->post('fullname');
        $data['email'] = $this->input->post('email');
        $data['telephone'] = $this->input->post('telephone');
        $data['role'] = $this->input->post('role');
        $data['created_on'] = $date->format($this->config->item('log_date_format'));
        $data['created_by'] = $session['username'];

        $this->load->model('user_model');
        $this->user_model->update_user($data);
        redirect('admin/users');
    }

    function capabilities($type = NULL, $query_id = 0, $sort_by = '', $sort_order = 'asc', $offset = 0) {
        $data_type = $this->input->post('data_type');
        $data['action_type'] = $type;
        $master_url = 'admin/capabilities/';
        $data['auth'] = $this->auth;

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

                $this->load->model('capability_model');
                $data = array_merge($data, $this->capability_model->set_default()); //merge dengan arr data dengan default
                $this->load->view('admin/capability_form', $data);
                break;
            case 'info':
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
                $this->load->model('capability_model');
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
            case 'search' :
                $query_array = array(
                    'capability' => $this->input->post('capability')
                );

                $query_id = $this->input->save_query($query_array);

                redirect("admin/capabilities/view/$query_id");
                break;
            default:
                $limit = 20;
                $this->load->library(array('form_validation', 'table', 'pagination'));
                $this->load->model('capability_model');
                $this->input->load_query($query_id);

                $query_array = array(
                    'capability' => $this->input->get('capability')
                );

                $results = $this->capability_model->search($query_array, $limit, $offset, $sort_by, $sort_order);
                $data['results'] = $results['results'];
                $data['num_results'] = $results['num_rows'];

                $config = array();
                $config['base_url'] = site_url("admin/capabilities/view/$query_id/$sort_by/$sort_order");
                $config['total_rows'] = $data['num_results'];
                $config['per_page'] = $limit;
                $config['uri_segment'] = 7;
                $config['num_links'] = 6;

                $config = array_merge($config, $this->_default_pagination_btn());
                $this->pagination->initialize($config);
                $data['pagination'] = $this->pagination->create_links();
                $data['sort_by'] = $sort_by;
                $data['sort_order'] = $sort_order;
                $data['page_title'] = 'Capabilities';
                $data['tools'] = array(
                    'admin/capabilities/create' => 'New'
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

    function roles($type = NULL, $query_id = 0, $sort_by = '', $sort_order = 'asc', $offset = 0) {
        $data_type = $this->input->post('data_type');
        $data['action_type'] = $type;
        $master_url = 'admin/roles/';
        $data['auth'] = $this->auth;

        switch ($type) {
            case 'create':
                $this->load->library(array('form_validation', 'table')); //, 'session'));
                $this->load->helper(array('form', 'snippets'));

                $config = array(
                    array(
                        'field' => 'role',
                        'label' => 'Role',
                        'rules' => 'trim|required|is_unique[m_roles.role]'
                    )
                );

                $this->form_validation->set_rules($config);
                $this->form_validation->set_error_delimiters('<span class="notice">', '</span>');
                if ($this->form_validation->run() === FALSE) {
                    //don't do anything
                } else {
                    $this->_create_role();
                }
                $this->load->model('role_model');
                $data = array_merge($data, $this->role_model->set_default()); //merge dengan arr data dengan default

                $data['action_url'] = $master_url . $type;
                $data['page_title'] = 'Create Role';

                $this->load->model(array('role_model', 'capability_model'));

                $data['capabilities_option'] = $this->capability_model->get_capability();

                $this->load->view('admin/role_form', $data);
                break;

            case 'info':
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

                $result = $this->role_model->get_roles('', $term)->row_array();
                $result_keys = array_keys($result);
                foreach ($result_keys as $result_key) {
                    $data[$result_key] = $result[$result_key];
                }

                $data['roles_option'] = $this->role_model->get_roles();
                $data['capabilities_option'] = $this->capability_model->get_capability();

                $data['tools'] = array(
                    'admin/roles' => 'Back'
                );

                $this->load->view('admin/role_form', $data);
                break;
            case 'search' :
                $query_array = array(
                    'role' => $this->input->post('role')
                );

                $query_id = $this->input->save_query($query_array);

                redirect("admin/roles/view/$query_id");
                break;
            default:
                $limit = 20;
                $this->load->library(array('form_validation', 'table', 'pagination'));
                $this->load->model('role_model', 'capability_model');
                $this->input->load_query($query_id);

                $query_array = array(
                    'role' => $this->input->get('role')
                );

                $data['roles_option'] = $this->role_model->get_roles();
                $data['capabilities_option'] = $this->capability_model->get_capability();

                $results = $this->role_model->search($query_array, $limit, $offset, $sort_by, $sort_order);
                $data['results'] = $results['results'];
                $data['num_results'] = $results['num_rows'];

                $config = array();
                $config['base_url'] = site_url("admin/roles/view/$query_id/$sort_by/$sort_order");
                $config['total_rows'] = $data['num_results'];
                $config['per_page'] = $limit;
                $config['uri_segment'] = 7;
                $config['num_links'] = 6;

                $config = array_merge($config, $this->_default_pagination_btn());
                $this->pagination->initialize($config);
                $data['pagination'] = $this->pagination->create_links();
                $data['sort_by'] = $sort_by;
                $data['sort_order'] = $sort_order;
                $data['page_title'] = 'Roles';
                $data['tools'] = array(
                    'admin/roles/create' => 'New'
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

    function options($type = NULL, $query_id = 0, $sort_by = '', $sort_order = 'asc', $offset = 0) {
        $data_type = $this->input->post('data_type');
        $data['action_type'] = $type;
        $master_url = 'admin/options/';
        $data['auth'] = $this->auth;

        switch ($type) {
            case 'create':
                $this->load->library(array('form_validation', 'table')); //, 'session'));
                $this->load->helper(array('form', 'snippets'));

                $config = array(
                    array(
                        'field' => 'option',
                        'label' => 'option',
                        'rules' => 'trim|required|is_unique[m_options.option]'
                    ),
                    array(
                        'field' => 'option_value',
                        'label' => 'option_value',
                        'rules' => 'trim|required'
                    )
                );
                $this->form_validation->set_rules($config);
                $this->form_validation->set_error_delimiters('<span class="notice">', '</span>');
                if ($this->form_validation->run() === FALSE) {
                    //don't do anything
                } else {
                    $this->_create_option();
                }
                $this->load->model('option_model');
                $data = array_merge($data, $this->option_model->set_default()); //merge dengan arr data dengan default

                $data['action_url'] = $master_url . $type;
                $data['page_title'] = 'Create option';
                $this->load->view('admin/option_form', $data);
                break;
            case 'info':

                $this->load->library(array('form_validation', 'table')); //, 'session'));
                $this->load->helper(array('form', 'snippets'));
                $id = $this->uri->segment(4);
                $term = array(
                    'm_options.id' => $id
                );
                $config = array(
                    array(
                        'field' => 'option',
                        'label' => 'Option',
                        'rules' => 'trim|required'
                    ),
                    array(
                        'field' => 'option_value',
                        'label' => 'Option Value',
                        'rules' => 'trim|required'
                    )
                );
                $this->form_validation->set_rules($config);
                $this->form_validation->set_error_delimiters('<span class="notice">', '</span>');
                if ($this->form_validation->run() === FALSE) {
                    //don't do anything
                } else {
                    $this->_update_option($id);
                }

                $data['action_url'] = $master_url . $type . '/' . $id;
                $data['page_title'] = 'Update Option';

                $this->load->model(array('option_model'));
                $result = $this->option_model->get_options('', $term)->row_array();
                $result_keys = array_keys($result);
                foreach ($result_keys as $result_key) {
                    $data[$result_key] = $result[$result_key];
                }

                $data['tools'] = array(
                    'admin/options' => 'Back'
                );

                $this->load->view('admin/option_form', $data);

                break;
            case 'delete':
                $this->load->helper(array('form'));
                break;
            case 'search' :
                $query_array = array(
                    'option' => $this->input->post('option')
                );

                $query_id = $this->input->save_query($query_array);

                redirect("admin/options/view/$query_id");
                break;
            default:
                $limit = 20;
                $this->load->library(array('form_validation', 'table', 'pagination'));
                $this->load->model('option_model');
                $this->input->load_query($query_id);

                $query_array = array(
                    'option' => $this->input->get('option')
                );

                $results = $this->option_model->search($query_array, $limit, $offset, $sort_by, $sort_order);
                $data['results'] = $results['results'];
                $data['num_results'] = $results['num_rows'];

                $config = array();
                $config['base_url'] = site_url("admin/options/view/$query_id/$sort_by/$sort_order");
                $config['total_rows'] = $data['num_results'];
                $config['per_page'] = $limit;
                $config['uri_segment'] = 7;
                $config['num_links'] = 6;

                $config = array_merge($config, $this->_default_pagination_btn());
                $this->pagination->initialize($config);
                $data['pagination'] = $this->pagination->create_links();
                $data['sort_by'] = $sort_by;
                $data['sort_order'] = $sort_order;
                $data['page_title'] = 'Options';
                $data['tools'] = array(
                    'admin/options/create' => 'New'
                );

                $this->load->view('admin/options', $data);
                break;
        }
    }

    function _create_option() {
        $data = array();
        // Assign the query data

        $data['option'] = $this->input->post('option');
        $data['option_value'] = $this->input->post('option_value');
        $data['description'] = $this->input->post('description');
        $this->load->model('option_model');
        $id = $this->option_model->create_option($data);
        redirect('admin/options');
    }

    function _update_option($id) {
        $data = array();
        $this->load->model('option_model');
        $data['id'] = $id;
        $data['option'] = $this->input->post('option');
        $data['option_value'] = $this->input->post('option_value');
        $data['description'] = $this->input->post('description');

        $this->option_model->update_option($data);
        redirect('admin/options');
    }

}
