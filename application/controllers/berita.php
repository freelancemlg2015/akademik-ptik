<?php

/*
 * Fachrul Rozi
 * Master Informasi : Berita
 * 5/9/2012
 */

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Berita extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->helper(array('snippets_helper'));
        $this->load->model('crud_model', 'crud');
    }

    function log_date() {
        return date($this->config->item('log_date_format'));
    }

    function index($query_id = 0, $sort_by = 'id', $sort_order = 'desc', $offset = 0) {
        $this->berita($query_id, $sort_by, $sort_order, $offset);
    }

    function berita($query_id = 0, $sort_by = 'id', $sort_order = 'desc', $offset = 0) {
        $data_type = $this->input->post('data_type');
        $data['auth'] = $this->auth;
        // pagination
        $limit = 20;
        $this->load->library(array('form_validation', 'table', 'pagination'));
        $this->input->load_query($query_id);
        $query_array = array(
            'kategori_berita' => $this->input->get('kategori_berita'),
            'judul_berita' => $this->input->get('judul_berita'),
            'active' => 1
        );

        $this->load->model('berita_model', 'berita');
        $results = $this->berita->search($query_array, $limit, $offset, $sort_by, $sort_order);
        //echo get_instance()->db->last_query();
        $data['results'] = $results['results'];
        $data['num_results'] = $results['num_rows'];

        // pagination
        $config = array();
        $config['base_url'] = site_url("master/berita/$query_id/$sort_by/$sort_order");
        $config['total_rows'] = $data['num_results'];
        $config['per_page'] = $limit;
        $config['uri_segment'] = 6;
        $config['num_links'] = 6;

        $config = array_merge($config, default_pagination_btn());
        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();
        $data['sort_by'] = $sort_by;
        $data['sort_order'] = $sort_order;

        $data['page_title'] = 'Berita';

        $data['tools'] = array(
            'master/berita/create' => 'New'
        );

        $this->load->view('master/berita', $data);
    }

    function search() {
        $query_array = array(
            'kategori_berita' => $this->input->post('kategori_berita'),
            'judul_berita' => $this->input->post('judul_berita'),
            'active' => 1
        );
        $query_id = $this->input->save_query($query_array);
        redirect("master/berita/view/$query_id");
    }

    function info() {
        $id = $this->uri->segment(3);
        $data['auth'] = $this->auth;
        $criteria = array(
            'm_berita.id' => $id
        );
        $this->load->model('berita_model', 'berita');
        $result = $this->berita->get_many('', $criteria)->row_array();
        //[debug]echo get_instance()->db->last_query();
        $result_keys = array_keys($result);
        foreach ($result_keys as $result_key) {
            $data[$result_key] = $result[$result_key];
        }

        $data['tools'] = array(
            'master/berita' => 'Back',
            'master/berita/' . $id . '/edit' => 'Edit',
            'master/berita/' . $id . '/delete' => 'Delete'
        );
        $data['page_title'] = 'Detail Berita';
        $this->load->view('master/berita_info', $data);
    }

    function delete() {
        $id = $this->uri->segment(3);
        $this->crud->use_table('m_berita');
        $criteria = array('id' => $id);
        $data_in = array(
            'active' => 0,
            'modified_on' => logged_info()->on,
            'modified_by' => logged_info()->by
        );
        $this->crud->update($criteria, $data_in);
        redirect('master/berita');
    }

    function create() {
        $data['auth']        = $this->auth;
        $data['action_type'] = __FUNCTION__;
        $master_url          = 'master/berita/';

        $this->load->library(array('form_validation', 'table'));
        $this->load->helper(array('form', 'snippets'));
        $this->form_validation->set_error_delimiters('<span class="notice">', '</span>');
        if ($this->form_validation->run('berita_create') === FALSE) {
            //don't do anything
        } else {
            $img = $this->do_upload();
            if(empty($img)){
                $this->crud->use_table('m_berita');
                $data_in = array(
                    'kategori_berita_id' => $this->input->post('kategori_berita_id'),
                    'judul_berita'       => $this->input->post('judul_berita'),
                    'konten_berita'      => $this->input->post('konten_berita'),
                    'created_on'         => date($this->config->item('log_date_format')),
                    'created_by'         => logged_info()->on
                );
            }else{
                $data = $this->upload->data();
                $this->crud->use_table('m_berita');
                $data_in = array(
                    'kategori_berita_id' => $this->input->post('kategori_berita_id'),
                    'judul_berita'       => $this->input->post('judul_berita'),
                    'konten_berita'      => $this->input->post('konten_berita'),
                    'foto_berita'        => $img,
                    'created_on'         => date($this->config->item('log_date_format')),
                    'created_by'         => logged_info()->on
                );
            }
            
            /*
              echo '<pre>';
              var_dump($data_in);
              echo '</pre>';
             */
            $created_id = $this->crud->create($data_in);
            redirect('master/berita/' . $created_id . '/info');
        }
        $data['action_url'] = $master_url . __FUNCTION__;
        $data['page_title'] = 'Create Berita';
        $data['tools']      = array(
            'master/berita' => 'Back'
        );
        
        $this->crud->use_table('m_kategori_berita');
        $data['kategori_berita_options'] = $this->crud->retrieve()->result();

        $this->load->model('berita_model', 'berita');
        $data = array_merge($data, $this->berita->set_default()); //merge dengan arr data dengan default
        $this->load->view('master/berita_form', $data);
    }

    function edit() {
        $data['auth']        = $this->auth;
        $data['action_type'] = __FUNCTION__;
        $master_url          = 'master/berita/';
        $id                  = $this->uri->segment(3);

        $this->load->library(array('form_validation', 'table'));
        $this->load->helper(array('form', 'snippets'));
        $this->form_validation->set_error_delimiters('<span class="notice">', '</span>');
        if ($this->form_validation->run('berita_update') === FALSE) {
            //don't do anything
        } else {
            $img = $this->do_upload();
            if(empty($img)){
                $this->crud->use_table('m_berita');
                $criteria = array(
                    'id' => $id
                );
                $data_in = array(
                    'kategori_berita_id' => $this->input->post('kategori_berita_id'),
                    'judul_berita'       => $this->input->post('judul_berita'),
                    'konten_berita'      => $this->input->post('konten_berita'),
                    'modified_on'        => date($this->config->item('log_date_format')),
                    'modified_by'        => logged_info()->on
                );
            }else{
                $this->crud->use_table('m_berita');
                $criteria = array(
                    'id' => $id
                );
                $data_in = array(
                'kategori_berita_id' => $this->input->post('kategori_berita_id'),
                'judul_berita'       => $this->input->post('judul_berita'),
                'konten_berita'      => $this->input->post('konten_berita'),
                'foto_berita'        => $img,
                'modified_on'        => date($this->config->item('log_date_format')),
                'modified_by'        => logged_info()->on
                );
            }
            
            $this->crud->update($criteria, $data_in);
            redirect('master/berita/' . $id . '/info');
        }
        $data['action_url'] = $master_url . $id . '/' . __FUNCTION__;
        $data['page_title'] = 'Update Berita';
        $data['tools'] = array(
            'master/berita' => 'Back'
        );

        $this->crud->use_table('m_berita');
        $berita_data = $this->crud->retrieve(array('id' => $id))->row();
        
        $this->crud->use_table('m_kategori_berita');
        $data['kategori_berita_options'] = $this->crud->retrieve()->result();
        
        $this->load->model('berita_model', 'berita');
        $data = array_merge($data, $this->berita->set_default()); //merge dengan arr data dengan default
        $data = array_merge($data, (array) $berita_data);
        $this->load->view('master/berita_form', $data);
    }

    function unique_judul_berita($judul_berita) {
        $this->crud->use_table('m_berita');
        $berita = $this->crud->retrieve(array('judul_berita' => $judul_berita))->row();
        if (sizeof($berita) > 0) {
            $this->form_validation->set_message(__FUNCTION__, 'Nama Berita sudah terdaftar'); //pakai function karena ini harus sama dengan nama function nya
            return FALSE;
        } else {
            return true;
        }
    }
    
    function do_upload() {
        $config['upload_path'] = "./assets/berita/images/";
        $config['allowed_types'] = 'gif|jpg|png|jpeg';
        $config['max_size'] = '2000';
        $config['max_width'] = '2000';
        $config['max_height'] = '2000';
        $config['encrypt_name'] = TRUE;

        $this->load->library('upload', $config);

        if ($this->upload->do_upload("foto_berita")) {
            $data = $this->upload->data();
            //print_r($data);
            /* PATH */
            $source = "./assets/berita/images/" . $data['file_name'];
            $destination_thumb = "./assets/berita/thumbs/";
            $destination_medium = "./assets/berita/medium/";

            // Permission Configuration
            chmod($source, 0777);

            /* Resizing Processing */
            // Configuration Of Image Manipulation :: Static
            $this->load->library('image_lib');
            $img['image_library'] = 'GD2';
            $img['create_thumb'] = TRUE;
            $img['maintain_ratio'] = TRUE;

            /// Limit Width Resize
            $limit_medium = 460;
            $limit_thumb = 90;

            // Size Image Limit was using (LIMIT TOP)
            $limit_use = $data['image_width'] > $data['image_height'] ? $data['image_width'] : $data['image_height'];

            // Percentase Resize
            if ($limit_use > $limit_medium || $limit_use > $limit_thumb) {
                $percent_medium = $limit_medium / $limit_use;
                $percent_thumb = $limit_thumb / $limit_use;
            }

            //// Making THUMBNAIL ///////
            $img['width'] = $limit_use > $limit_thumb ? $data['image_width'] * $percent_thumb : $data['image_width'];
            $img['height'] = $limit_use > $limit_thumb ? $data['image_height'] * $percent_thumb : $data['image_height'];

            // Configuration Of Image Manipulation :: Dynamic
            $img['thumb_marker'] = '_thumb';
            $img['quality'] = '100%';
            $img['source_image'] = $source;
            $img['new_image'] = $destination_thumb;

            // Do Resizing
            $this->image_lib->initialize($img);
            $this->image_lib->resize();
            $this->image_lib->clear();

            ////// Making MEDIUM /////////////
            $img['width'] = $limit_use > $limit_medium ? $data['image_width'] * $percent_medium : $data['image_width'];
            $img['height'] = $limit_use > $limit_medium ? $data['image_height'] * $percent_medium : $data['image_height'];

            // Configuration Of Image Manipulation :: Dynamic
            $img['thumb_marker'] = '_medium';
            $img['quality'] = '100%';
            $img['source_image'] = $source;
            $img['new_image'] = $destination_medium;

            // Do Resizing
            $this->image_lib->initialize($img);
            $this->image_lib->resize();
            $this->image_lib->clear();
            return $data['file_name'];
        } else {
            $data = $this->upload->data();
            //print_r($data);
            //echo $this->upload->display_errors();
        }
    }
}

?>
