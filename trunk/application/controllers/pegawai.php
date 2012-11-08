<?php

/*
 * Sofian
 * Master Tugas Imam : Data Pegawai
 * 07/11/2012
 */

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Pegawai extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->helper(array('snippets_helper'));
        $this->load->model('crud_model', 'crud');
    }

    function log_date() {
        return date($this->config->item('log_date_format'));
    }

    function index($query_id = 0, $sort_by = 'id', $sort_order = 'desc', $offset = 0) {
        $this->pegawai($query_id, $sort_by, $sort_order, $offset);
    }

    function pegawai($query_id = 0, $sort_by = 'id', $sort_order = 'desc', $offset = 0) {
        $data_type = $this->input->post('data_type');
        $data['auth'] = $this->auth;
        // pagination
        $limit = 20;
        $this->load->library(array('form_validation', 'table', 'pagination'));
        $this->input->load_query($query_id);
        $query_array = array(
            'no_karpeg_pegawai' => $this->input->get('no_karpeg_pegawai'),
            'nama_pegawai' => $this->input->get('nama_pegawai'),
            'active' => 1
        );

        $this->load->model('pegawai_model', 'pegawai');
        $results = $this->pegawai->search($query_array, $limit, $offset, $sort_by, $sort_order);
        //echo get_instance()->db->last_query();
        $data['results'] = $results['results'];
        $data['num_results'] = $results['num_rows'];

        // pagination
        $config = array();
        $config['base_url'] = site_url("master/pegawai/$query_id/$sort_by/$sort_order");
        $config['total_rows'] = $data['num_results'];
        $config['per_page'] = $limit;
        $config['uri_segment'] = 6;
        $config['num_links'] = 6;

        $config = array_merge($config, default_pagination_btn());
        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();
        $data['sort_by'] = $sort_by;
        $data['sort_order'] = $sort_order;

        $data['page_title'] = 'pegawai';

        $data['tools'] = array(
            'master/pegawai/create' => 'New'
        );

        $this->load->view('master/pegawai', $data);
    }

    function search() {
        $query_array = array(
            'no_karpeg_pegawai' => $this->input->post('no_karpeg_pegawai'),
            'nama_pegawai' => $this->input->post('nama_pegawai'),

            'active' => 1
        );
        $query_id = $this->input->save_query($query_array);
        redirect("master/pegawai/view/$query_id");
    }

    function info() {
        $id = $this->uri->segment(3);
        $data['auth'] = $this->auth;
        $criteria = array(
            'm_pegawai.id' => $id
        );
        $this->load->model('pegawai_model', 'pegawai');
        $result = $this->pegawai->get_many('', $criteria)->row_array();
        //[debug]echo get_instance()->db->last_query();
        $result_keys = array_keys($result);
        foreach ($result_keys as $result_key) {
            $data[$result_key] = $result[$result_key];
        }

        $data['tools'] = array(
            'master/pegawai' => 'Back',
            'master/pegawai/' . $id . '/edit' => 'Edit',
            'master/pegawai/' . $id . '/delete' => 'Delete'
        );
        $data['page_title'] = 'Detail pegawai';
        $this->load->view('master/pegawai_info', $data);
    }

    function delete() {
        $id = $this->uri->segment(3);
        $this->crud->use_table('m_pegawai');
        $criteria = array('id' => $id);
        $data_in = array(
            'active' => 0,
            'modified_on' => logged_info()->on,
            'modified_by' => logged_info()->by
        );
        $this->crud->update($criteria, $data_in);
        redirect('master/pegawai');
    }

    function create() {
        $data['auth'] = $this->auth;
        $data['action_type'] = __FUNCTION__;
        $master_url = 'master/pegawai/';

        $this->load->library(array('form_validation', 'table'));
        $this->load->helper(array('form', 'snippets'));
        $this->form_validation->set_error_delimiters('<span class="notice">', '</span>');

        if ($this->form_validation->run('pegawai_create') === FALSE) {
		
            //don't do anything
        } else {
            $this->do_upload();
            $data = $this->upload->data();
            $this->crud->use_table('m_pegawai');
            $data_in = array(
                'pangkat_id' => $this->input->post('pangkat_id'),   
                'no_karpeg_pegawai' => $this->input->post('no_karpeg_pegawai'),
                'nama_pegawai' => $this->input->post('nama_pegawai'),
                'gelar_depan' => $this->input->post('gelar_depan'),
                'gelar_belakang' => $this->input->post('gelar_belakang'),
                'tempat_lahir' => $this->input->post('tempat_lahir'),
                'tgl_lahir' => $this->input->post('tgl_lahir'),
                'jenis_kelamin_id' => $this->input->post('jenis_kelamin_id'),
                'agama_id' => $this->input->post('agama_id'),
                'jabatan_akademik_id' => $this->input->post('jabatan_akademik_id'),
                'jabatan_tertinggi_id' => $this->input->post('jabatan_tertinggi_id'),
                'nip_pns' => $this->input->post('nip_pns'),
                'jabatan_struktural' => $this->input->post('jabatan_struktural'),
                'alamat' => $this->input->post('alamat'),
                'no_telp' => $this->input->post('no_telp'),
                'no_hp' => $this->input->post('no_hp'),
                'tgl_mulai_masuk' => $this->input->post('tgl_mulai_masuk'),
                'email' => $this->input->post('email'),
                'foto_pegawai' => $data['file_name'],
                'created_on' => date($this->config->item('log_date_format')),
                'created_by' => logged_info()->on
            );
            
			 /*?>              
			  echo '<pre>';
              var_dump($data_in);
              echo '</pre>';<?php 
			  */
             

            $created_id = $this->crud->create($data_in);
            redirect('master/pegawai/' . $created_id . '/info');
        }
        $data['action_url'] = $master_url . __FUNCTION__;
        $data['page_title'] = 'Create pegawai';
        $data['tools'] = array(
            'master/pegawai' => 'Back'
        );

        $this->crud->use_table('m_jenis_kelamin');
        $data['jenis_kelamin_options'] = $this->crud->retrieve()->result();

        $this->crud->use_table('m_agama');
        $data['agama_options'] = $this->crud->retrieve()->result();

        $this->crud->use_table('m_jabatan_akademik');
        $data['jabatan_akademik_options'] = $this->crud->retrieve()->result();

        $this->crud->use_table('m_jabatan_tertinggi');
        $data['jabatan_tertinggi_options'] = $this->crud->retrieve()->result();
           
        $this->crud->use_table('m_pangkat');
        $data['pangkat_options'] = $this->crud->retrieve()->result();

        $this->load->model('pegawai_model', 'pegawai');
        $data = array_merge($data, $this->pegawai->set_default()); //merge dengan arr data dengan default
        $this->load->view('master/pegawai_form', $data);
    }

    function edit() {
        $data['auth'] = $this->auth;
        $data['action_type'] = __FUNCTION__;
        $master_url = 'master/pegawai/';
        $id = $this->uri->segment(3);

        $this->load->library(array('form_validation', 'table'));
        $this->load->helper(array('form', 'snippets'));
        $this->form_validation->set_error_delimiters('<span class="notice">', '</span>');
        if ($this->form_validation->run('pegawai_update') === FALSE) {
            //don't do anything
        } else {
            $img = $this->do_upload();
            //print_r($img);die();
            if (empty($img)) {
                $this->crud->use_table('m_pegawai');
                $criteria = array(
                    'id' => $id
                );
                $data_in = array(
					'pangkat_id' => $this->input->post('pangkat_id'),   
					'no_karpeg_pegawai' => $this->input->post('no_karpeg_pegawai'),
					'nama_pegawai' => $this->input->post('nama_pegawai'),
					'gelar_depan' => $this->input->post('gelar_depan'),
					'gelar_belakang' => $this->input->post('gelar_belakang'),
					'tempat_lahir' => $this->input->post('tempat_lahir'),
					'tgl_lahir' => $this->input->post('tgl_lahir'),
					'jenis_kelamin_id' => $this->input->post('jenis_kelamin_id'),
					'agama_id' => $this->input->post('agama_id'),
					'jabatan_akademik_id' => $this->input->post('jabatan_akademik_id'),
					'jabatan_tertinggi_id' => $this->input->post('jabatan_tertinggi_id'),
					'nip_pns' => $this->input->post('nip_pns'),
					'jabatan_struktural' => $this->input->post('jabatan_struktural'),
					'alamat' => $this->input->post('alamat'),
					'no_telp' => $this->input->post('no_telp'),
					'no_hp' => $this->input->post('no_hp'),
					'tgl_mulai_masuk' => $this->input->post('tgl_mulai_masuk'),
					'email' => $this->input->post('email'),
					'foto_pegawai' => $data['file_name'],
					'created_on' => date($this->config->item('log_date_format')),
					'created_by' => logged_info()->on
                );
            } else {
                $this->crud->use_table('m_pegawai');
                $criteria = array(
                    'id' => $id
                );
                $data_in = array(
					'pangkat_id' => $this->input->post('pangkat_id'),   
					'no_karpeg_pegawai' => $this->input->post('no_karpeg_pegawai'),
					'nama_pegawai' => $this->input->post('nama_pegawai'),
					'gelar_depan' => $this->input->post('gelar_depan'),
					'gelar_belakang' => $this->input->post('gelar_belakang'),
					'tempat_lahir' => $this->input->post('tempat_lahir'),
					'tgl_lahir' => $this->input->post('tgl_lahir'),
					'jenis_kelamin_id' => $this->input->post('jenis_kelamin_id'),
					'agama_id' => $this->input->post('agama_id'),
					'jabatan_akademik_id' => $this->input->post('jabatan_akademik_id'),
					'jabatan_tertinggi_id' => $this->input->post('jabatan_tertinggi_id'),
					'nip_pns' => $this->input->post('nip_pns'),
					'jabatan_struktural' => $this->input->post('jabatan_struktural'),
					'alamat' => $this->input->post('alamat'),
					'no_telp' => $this->input->post('no_telp'),
					'no_hp' => $this->input->post('no_hp'),
					'tgl_mulai_masuk' => $this->input->post('tgl_mulai_masuk'),
					'email' => $this->input->post('email'),
					'foto_pegawai' => $data['file_name'],
					'created_on' => date($this->config->item('log_date_format')),
					'created_by' => logged_info()->on
                );
                //$path_parts      = pathinfo('/assets/dosen/thumbs/'.$img);
                //$image_filename  = $path_parts['filename'];
                //$image_extension = $path_parts['extension'];
                //@unlink(APPPATH."/assets/dosen/images/".$img);
                //print_r(APPPATH."assets/dosen/images/".$img);die();
            }

            $this->crud->update($criteria, $data_in);
            redirect('master/pegawai/' . $id . '/info');
        }
        $data['action_url'] = $master_url . $id . '/' . __FUNCTION__;
        $data['page_title'] = 'Update pegawai';
        $data['tools'] = array(
            'master/pegawai' => 'Back'
        );

        $this->crud->use_table('m_pegawai');
        $pegawai_data = $this->crud->retrieve(array('id' => $id))->row();

        $this->crud->use_table('m_jenis_kelamin');
        $data['jenis_kelamin_options'] = $this->crud->retrieve()->result();

        $this->crud->use_table('m_agama');
        $data['agama_options'] = $this->crud->retrieve()->result();

        $this->crud->use_table('m_jabatan_akademik');
        $data['jabatan_akademik_options'] = $this->crud->retrieve()->result();

        $this->crud->use_table('m_jabatan_tertinggi');
        $data['jabatan_tertinggi_options'] = $this->crud->retrieve()->result();
        
        $this->crud->use_table('m_pangkat');
        $data['pangkat_options'] = $this->crud->retrieve()->result();

        $this->load->model('pegawai_model', 'pegawai');
        $data = array_merge($data, $this->pegawai->set_default()); //merge dengan arr data dengan default
        $data = array_merge($data, (array) $pegawai_data);
        $this->load->view('master/pegawai_form', $data);
    }

    function unique_pegawai($nama_pegawai) {
        $this->crud->use_table('m_pegawai');
        $pegawai = $this->crud->retrieve(array('pegawai' => $nama_pegawai))->row();
        if (sizeof($pegawai) > 0) {
            $this->form_validation->set_message(__FUNCTION__, 'Nama pegawai sudah terdaftar'); //pakai function karena ini harus sama dengan nama function nya
            return FALSE;
        } else {
            return true;
        }
    }

    function do_upload() {
        $config['upload_path'] = "./assets/pegawai/images/";
        $config['allowed_types'] = 'gif|jpg|png|jpeg';
        $config['max_size'] = '2000';
        $config['max_width'] = '2000';
        $config['max_height'] = '2000';
        $config['encrypt_name'] = TRUE;

        $this->load->library('upload', $config);

        if ($this->upload->do_upload("foto_pegawai")) {
            $data = $this->upload->data();
            //print_r($data);
            /* PATH */
            $source = "./assets/pegawai/images/" . $data['file_name'];
            $destination_thumb = "./assets/pegawai/thumbs/";
            $destination_medium = "./assets/pegawai/medium/";

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

    function suggestion() {
        $this->load->model('pegawai_model');
        $nama_pegawai = $this->input->get('nama_pegawai');
        $terms = array(
            'nama_pegawai' => $nama_pegawai
        );
        $this->pegawai_model->suggestion($terms);
    }

}

?>
