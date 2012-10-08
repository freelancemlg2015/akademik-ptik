<?php

/*
 * Imam Syarifudin
 * Master Tugas Imam : Data Dosen
 * 9/9/2012
 */

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Dosen extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->helper(array('snippets_helper'));
        $this->load->model('crud_model', 'crud');
    }

    function log_date() {
        return date($this->config->item('log_date_format'));
    }

    function index($query_id = 0, $sort_by = 'id', $sort_order = 'desc', $offset = 0) {
        $this->dosen($query_id, $sort_by, $sort_order, $offset);
    }

    function dosen($query_id = 0, $sort_by = 'id', $sort_order = 'desc', $offset = 0) {
        $data_type = $this->input->post('data_type');
        $data['auth'] = $this->auth;
        // pagination
        $limit = 20;
        $this->load->library(array('form_validation', 'table', 'pagination'));
        $this->input->load_query($query_id);
        $query_array = array(
            'no_karpeg_dosen' => $this->input->get('no_karpeg_dosen'),
            'nama_dosen' => $this->input->get('nama_dosen'),
            'active' => 1
        );

        $this->load->model('dosen_model', 'dosen');
        $results = $this->dosen->search($query_array, $limit, $offset, $sort_by, $sort_order);
        //echo get_instance()->db->last_query();
        $data['results'] = $results['results'];
        $data['num_results'] = $results['num_rows'];

        // pagination
        $config = array();
        $config['base_url'] = site_url("master/dosen/$query_id/$sort_by/$sort_order");
        $config['total_rows'] = $data['num_results'];
        $config['per_page'] = $limit;
        $config['uri_segment'] = 6;
        $config['num_links'] = 6;

        $config = array_merge($config, default_pagination_btn());
        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();
        $data['sort_by'] = $sort_by;
        $data['sort_order'] = $sort_order;

        $data['page_title'] = 'Dosen';

        $data['tools'] = array(
            'master/dosen/create' => 'New'
        );

        $this->load->view('master/dosen', $data);
    }

    function search() {
        $query_array = array(
            'no_karpeg_dosen' => $this->input->post('no_karpeg_dosen'),
            'nama_dosen' => $this->input->post('nama_dosen'),
            'active' => 1
        );
        $query_id = $this->input->save_query($query_array);
        redirect("master/dosen/view/$query_id");
    }

    function info() {
        $id = $this->uri->segment(3);
        $data['auth'] = $this->auth;
        $criteria = array(
            'm_dosen.id' => $id
        );
        $this->load->model('dosen_model', 'dosen');
        $result = $this->dosen->get_many('', $criteria)->row_array();
        //[debug]echo get_instance()->db->last_query();
        $result_keys = array_keys($result);
        foreach ($result_keys as $result_key) {
            $data[$result_key] = $result[$result_key];
        }

        $data['tools'] = array(
            'master/dosen' => 'Back',
            'master/dosen/' . $id . '/edit' => 'Edit',
            'master/dosen/' . $id . '/delete' => 'Delete'
        );
        $data['page_title'] = 'Detail Dosen';
        $this->load->view('master/dosen_info', $data);
    }

    function delete() {
        $id = $this->uri->segment(3);
        $this->crud->use_table('m_dosen');
        $criteria = array('id' => $id);
        $data_in = array(
            'active' => 0,
            'modified_on' => logged_info()->on,
            'modified_by' => logged_info()->by
        );
        $this->crud->update($criteria, $data_in);
        redirect('master/dosen');
    }

    function create() {
        $data['auth'] = $this->auth;
        $data['action_type'] = __FUNCTION__;
        $master_url = 'master/dosen/';

        $this->load->library(array('form_validation', 'table'));
        $this->load->helper(array('form', 'snippets'));
        $this->form_validation->set_error_delimiters('<span class="notice">', '</span>');

        if ($this->form_validation->run('dosen_create') === FALSE) {
            //don't do anything
        } else {
            $this->do_upload();
            $data = $this->upload->data();
            $this->crud->use_table('m_dosen');
            $data_in = array(
                'angkatan_id' => $this->input->post('angkatan_id'),
                'program_studi_id' => $this->input->post('program_studi_id'),
                'jenjang_studi_id' => $this->input->post('jenjang_studi_id'),
                'no_karpeg_dosen' => $this->input->post('no_karpeg_dosen'),
                'no_dosen_fakultas' => $this->input->post('no_dosen_fakultas'),
                'no_dosen_dikti' => $this->input->post('no_dosen_dikti'),
                'nama_dosen' => $this->input->post('nama_dosen'),
                'gelar_depan' => $this->input->post('gelar_depan'),
                'gelar_belakang' => $this->input->post('gelar_belakang'),
                'tempat_lahir' => $this->input->post('tempat_lahir'),
                'tgl_lahir' => $this->input->post('tgl_lahir'),
                'jenis_kelamin_id' => $this->input->post('jenis_kelamin_id'),
                'agama_id' => $this->input->post('agama_id'),
                'jabatan_akademik_id' => $this->input->post('jabatan_akademik_id'),
                'jabatan_tertinggi_id' => $this->input->post('jabatan_tertinggi_id'),
                'status_kerja_dosen_id' => $this->input->post('status_kerja_dosen_id'),
                'status_aktivitas_dosen_id' => $this->input->post('status_aktivitas_dosen_id'),
                'semester_mulai_aktivitas_id' => $this->input->post('semester_mulai_aktivitas_id'),
                'akta_mengajar_id' => $this->input->post('akta_mengajar_id'),
                'surat_ijin_mengajar_id' => $this->input->post('surat_ijin_mengajar_id'),
                'nip_pns' => $this->input->post('nip_pns'),
                'instansi_induk_dosen' => $this->input->post('instansi_induk_dosen'),
                'golongan_id' => $this->input->post('golongan_id'),
                'tmt_golongan' => $this->input->post('tmt_golongan'),
                'jabatan_struktural' => $this->input->post('jabatan_struktural'),
                'tmt_jabatan' => $this->input->post('tmt_jabatan'),
                'alamat' => $this->input->post('alamat'),
                'no_telp' => $this->input->post('no_telp'),
                'no_hp' => $this->input->post('no_hp'),
                'tgl_mulai_masuk' => $this->input->post('tgl_mulai_masuk'),
                'tgl_keluar' => $this->input->post('tgl_keluar'),
                'email' => $this->input->post('email'),
                'foto_dosen' => $data['file_name'],
                'created_on' => date($this->config->item('log_date_format')),
                'created_by' => logged_info()->on
            );
            /*
              echo '<pre>';
              var_dump($data_in);
              echo '</pre>';
             */

            $created_id = $this->crud->create($data_in);
            redirect('master/dosen/' . $created_id . '/info');
        }
        $data['action_url'] = $master_url . __FUNCTION__;
        $data['page_title'] = 'Create Dosen';
        $data['tools'] = array(
            'master/dosen' => 'Back'
        );

        $this->crud->use_table('m_angkatan');
        $data['angkatan_options'] = $this->crud->retrieve()->result();

        $this->crud->use_table('m_program_studi');
        $data['program_studi_options'] = $this->crud->retrieve()->result();

        $this->crud->use_table('m_jenjang_studi');
        $data['jenjang_studi_options'] = $this->crud->retrieve()->result();

        $this->crud->use_table('m_jenis_kelamin');
        $data['jenis_kelamin_options'] = $this->crud->retrieve()->result();

        $this->crud->use_table('m_agama');
        $data['agama_options'] = $this->crud->retrieve()->result();

        $this->crud->use_table('m_jabatan_akademik');
        $data['jabatan_akademik_options'] = $this->crud->retrieve()->result();

        $this->crud->use_table('m_jabatan_tertinggi');
        $data['jabatan_tertinggi_options'] = $this->crud->retrieve()->result();

        $this->crud->use_table('m_status_kerja_dosen');
        $data['status_kerja_dosen_options'] = $this->crud->retrieve()->result();

        $this->crud->use_table('m_status_aktivitas_dosen');
        $data['status_aktivitas_dosen_options'] = $this->crud->retrieve()->result();

        $this->crud->use_table('m_semester_mulai_aktivitas');
        $data['semester_mulai_aktivitas_options'] = $this->crud->retrieve()->result();

        $this->crud->use_table('m_akta_mengajar');
        $data['akta_mengajar_options'] = $this->crud->retrieve()->result();

        $this->crud->use_table('m_surat_ijin_mengajar');
        $data['surat_ijin_mengajar_options'] = $this->crud->retrieve()->result();

        $this->crud->use_table('m_golongan');
        $data['golongan_options'] = $this->crud->retrieve()->result();

        $this->load->model('dosen_model', 'dosen');
        $data = array_merge($data, $this->dosen->set_default()); //merge dengan arr data dengan default
        $this->load->view('master/dosen_form', $data);
    }

    function edit() {
        $data['auth'] = $this->auth;
        $data['action_type'] = __FUNCTION__;
        $master_url = 'master/dosen/';
        $id = $this->uri->segment(3);

        $this->load->library(array('form_validation', 'table'));
        $this->load->helper(array('form', 'snippets'));
        $this->form_validation->set_error_delimiters('<span class="notice">', '</span>');
        if ($this->form_validation->run('dosen_update') === FALSE) {
            //don't do anything
        } else {
            $img = $this->do_upload();
            //print_r($img);die();
            if (empty($img)) {
                $this->crud->use_table('m_dosen');
                $criteria = array(
                    'id' => $id
                );
                $data_in = array(
                    'angkatan_id' => $this->input->post('angkatan_id'),
                    'program_studi_id' => $this->input->post('program_studi_id'),
                    'jenjang_studi_id' => $this->input->post('jenjang_studi_id'),
                    'no_karpeg_dosen' => $this->input->post('no_karpeg_dosen'),
                    'no_dosen_fakultas' => $this->input->post('no_dosen_fakultas'),
                    'no_dosen_dikti' => $this->input->post('no_dosen_dikti'),
                    'nama_dosen' => $this->input->post('nama_dosen'),
                    'gelar_depan' => $this->input->post('gelar_depan'),
                    'gelar_belakang' => $this->input->post('gelar_belakang'),
                    'tempat_lahir' => $this->input->post('tempat_lahir'),
                    'tgl_lahir' => $this->input->post('tgl_lahir'),
                    'jenis_kelamin_id' => $this->input->post('jenis_kelamin_id'),
                    'agama_id' => $this->input->post('agama_id'),
                    'jabatan_akademik_id' => $this->input->post('jabatan_akademik_id'),
                    'jabatan_tertinggi_id' => $this->input->post('jabatan_tertinggi_id'),
                    'status_kerja_dosen_id' => $this->input->post('status_kerja_dosen_id'),
                    'status_aktivitas_dosen_id' => $this->input->post('status_aktivitas_dosen_id'),
                    'semester_mulai_aktivitas_id' => $this->input->post('semester_mulai_aktivitas_id'),
                    'akta_mengajar_id' => $this->input->post('akta_mengajar_id'),
                    'surat_ijin_mengajar_id' => $this->input->post('surat_ijin_mengajar_id'),
                    'nip_pns' => $this->input->post('nip_pns'),
                    'instansi_induk_dosen' => $this->input->post('instansi_induk_dosen'),
                    'golongan_id' => $this->input->post('golongan_id'),
                    'tmt_golongan' => $this->input->post('tmt_golongan'),
                    'jabatan_struktural' => $this->input->post('jabatan_struktural'),
                    'tmt_jabatan' => $this->input->post('tmt_jabatan'),
                    'alamat' => $this->input->post('alamat'),
                    'no_telp' => $this->input->post('no_telp'),
                    'no_hp' => $this->input->post('no_hp'),
                    'tgl_mulai_masuk' => $this->input->post('tgl_mulai_masuk'),
                    'tgl_keluar' => $this->input->post('tgl_keluar'),
                    'email' => $this->input->post('email'),
                    'modified_on' => date($this->config->item('log_date_format')),
                    'modified_by' => logged_info()->on
                );
            } else {
                $this->crud->use_table('m_dosen');
                $criteria = array(
                    'id' => $id
                );
                $data_in = array(
                    'angkatan_id' => $this->input->post('angkatan_id'),
                    'program_studi_id' => $this->input->post('program_studi_id'),
                    'jenjang_studi_id' => $this->input->post('jenjang_studi_id'),
                    'no_karpeg_dosen' => $this->input->post('no_karpeg_dosen'),
                    'no_dosen_fakultas' => $this->input->post('no_dosen_fakultas'),
                    'no_dosen_dikti' => $this->input->post('no_dosen_dikti'),
                    'nama_dosen' => $this->input->post('nama_dosen'),
                    'gelar_depan' => $this->input->post('gelar_depan'),
                    'gelar_belakang' => $this->input->post('gelar_belakang'),
                    'tempat_lahir' => $this->input->post('tempat_lahir'),
                    'tgl_lahir' => $this->input->post('tgl_lahir'),
                    'jenis_kelamin_id' => $this->input->post('jenis_kelamin_id'),
                    'agama_id' => $this->input->post('agama_id'),
                    'jabatan_akademik_id' => $this->input->post('jabatan_akademik_id'),
                    'jabatan_tertinggi_id' => $this->input->post('jabatan_tertinggi_id'),
                    'status_kerja_dosen_id' => $this->input->post('status_kerja_dosen_id'),
                    'status_aktivitas_dosen_id' => $this->input->post('status_aktivitas_dosen_id'),
                    'semester_mulai_aktivitas_id' => $this->input->post('semester_mulai_aktivitas_id'),
                    'akta_mengajar_id' => $this->input->post('akta_mengajar_id'),
                    'surat_ijin_mengajar_id' => $this->input->post('surat_ijin_mengajar_id'),
                    'nip_pns' => $this->input->post('nip_pns'),
                    'instansi_induk_dosen' => $this->input->post('instansi_induk_dosen'),
                    'golongan_id' => $this->input->post('golongan_id'),
                    'tmt_golongan' => $this->input->post('tmt_golongan'),
                    'jabatan_struktural' => $this->input->post('jabatan_struktural'),
                    'tmt_jabatan' => $this->input->post('tmt_jabatan'),
                    'alamat' => $this->input->post('alamat'),
                    'no_telp' => $this->input->post('no_telp'),
                    'no_hp' => $this->input->post('no_hp'),
                    'tgl_mulai_masuk' => $this->input->post('tgl_mulai_masuk'),
                    'tgl_keluar' => $this->input->post('tgl_keluar'),
                    'email' => $this->input->post('email'),
                    'foto_dosen' => $img,
                    'modified_on' => date($this->config->item('log_date_format')),
                    'modified_by' => logged_info()->on
                );
                //$path_parts      = pathinfo('/assets/dosen/thumbs/'.$img);
                //$image_filename  = $path_parts['filename'];
                //$image_extension = $path_parts['extension'];
                //@unlink(APPPATH."/assets/dosen/images/".$img);
                //print_r(APPPATH."assets/dosen/images/".$img);die();
            }

            $this->crud->update($criteria, $data_in);
            redirect('master/dosen/' . $id . '/info');
        }
        $data['action_url'] = $master_url . $id . '/' . __FUNCTION__;
        $data['page_title'] = 'Update Dosen';
        $data['tools'] = array(
            'master/dosen' => 'Back'
        );

        $this->crud->use_table('m_dosen');
        $dosen_data = $this->crud->retrieve(array('id' => $id))->row();

        $this->crud->use_table('m_angkatan');
        $data['angkatan_options'] = $this->crud->retrieve()->result();

        $this->crud->use_table('m_program_studi');
        $data['program_studi_options'] = $this->crud->retrieve()->result();

        $this->crud->use_table('m_jenjang_studi');
        $data['jenjang_studi_options'] = $this->crud->retrieve()->result();

        $this->crud->use_table('m_jenis_kelamin');
        $data['jenis_kelamin_options'] = $this->crud->retrieve()->result();

        $this->crud->use_table('m_agama');
        $data['agama_options'] = $this->crud->retrieve()->result();

        $this->crud->use_table('m_jabatan_akademik');
        $data['jabatan_akademik_options'] = $this->crud->retrieve()->result();

        $this->crud->use_table('m_jabatan_tertinggi');
        $data['jabatan_tertinggi_options'] = $this->crud->retrieve()->result();

        $this->crud->use_table('m_status_kerja_dosen');
        $data['status_kerja_dosen_options'] = $this->crud->retrieve()->result();

        $this->crud->use_table('m_status_aktivitas_dosen');
        $data['status_aktivitas_dosen_options'] = $this->crud->retrieve()->result();

        $this->crud->use_table('m_semester_mulai_aktivitas');
        $data['semester_mulai_aktivitas_options'] = $this->crud->retrieve()->result();

        $this->crud->use_table('m_akta_mengajar');
        $data['akta_mengajar_options'] = $this->crud->retrieve()->result();

        $this->crud->use_table('m_surat_ijin_mengajar');
        $data['surat_ijin_mengajar_options'] = $this->crud->retrieve()->result();

        $this->crud->use_table('m_golongan');
        $data['golongan_options'] = $this->crud->retrieve()->result();

        $this->load->model('dosen_model', 'dosen');
        $data = array_merge($data, $this->dosen->set_default()); //merge dengan arr data dengan default
        $data = array_merge($data, (array) $dosen_data);
        $this->load->view('master/dosen_form', $data);
    }

    function unique_dosen($nama_dosen) {
        $this->crud->use_table('m_dosen');
        $dosen = $this->crud->retrieve(array('dosen' => $nama_dosen))->row();
        if (sizeof($dosen) > 0) {
            $this->form_validation->set_message(__FUNCTION__, 'Nama Dosen sudah terdaftar'); //pakai function karena ini harus sama dengan nama function nya
            return FALSE;
        } else {
            return true;
        }
    }

    function do_upload() {
        $config['upload_path'] = "./assets/dosen/images/";
        $config['allowed_types'] = 'gif|jpg|png|jpeg';
        $config['max_size'] = '2000';
        $config['max_width'] = '2000';
        $config['max_height'] = '2000';
        $config['encrypt_name'] = TRUE;

        $this->load->library('upload', $config);

        if ($this->upload->do_upload("foto_dosen")) {
            $data = $this->upload->data();
            //print_r($data);
            /* PATH */
            $source = "./assets/dosen/images/" . $data['file_name'];
            $destination_thumb = "./assets/dosen/thumbs/";
            $destination_medium = "./assets/dosen/medium/";

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
        $this->load->model('dosen_model');
        $nama_dosen = $this->input->get('nama_dosen');
        $terms = array(
            'nama_dosen' => $nama_dosen
        );
        $this->dosen_model->suggestion($terms);
    }

}

?>
