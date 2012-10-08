<?php

/*
 * Imam Syarifudin
 * Master Tugas Imam : Data Mahasiswa
 * 9/9/2012
 */

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Mahasiswa extends CI_Controller {
    
    function __construct() {
        parent::__construct();
        $this->load->helper(array('snippets_helper'));
        $this->load->model('crud_model', 'crud');
    }
    
    function log_date() {
        return date($this->config->item('log_date_format'));
    }

    function index($query_id = 0, $sort_by = 'id', $sort_order = 'desc', $offset = 0) {
        $this->mahasiswa($query_id, $sort_by, $sort_order, $offset);
    }

    function mahasiswa($query_id = 0, $sort_by = 'id', $sort_order = 'desc', $offset = 0) {
        $data_type = $this->input->post('data_type');
        $data['auth'] = $this->auth;
        // pagination
        $limit = 20;
        $this->load->library(array('form_validation', 'table', 'pagination'));
        $this->input->load_query($query_id);
        $query_array = array(
            'nim' => $this->input->get('nim'),
            'nama' => $this->input->get('nama'),
            'active' => 1
        );

        $this->load->model('mahasiswa_model', 'mahasiswa');
        $results = $this->mahasiswa->search($query_array, $limit, $offset, $sort_by, $sort_order);
        //echo get_instance()->db->last_query();
        $data['results'] = $results['results'];
        $data['num_results'] = $results['num_rows'];

        // pagination
        $config = array();
        $config['base_url'] = site_url("master/mahasiswa/$query_id/$sort_by/$sort_order");
        $config['total_rows'] = $data['num_results'];
        $config['per_page'] = $limit;
        $config['uri_segment'] = 6;
        $config['num_links'] = 6;

        $config = array_merge($config, default_pagination_btn());
        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();
        $data['sort_by'] = $sort_by;
        $data['sort_order'] = $sort_order;

        $data['page_title'] = 'Mahasiswa';

        $data['tools'] = array(
            'master/mahasiswa/create' => 'New'
        );

        $this->load->view('master/mahasiswa', $data);
    }

    function search() {
        $query_array = array(
            'nim' => $this->input->post('nim'),
            'nama' => $this->input->post('nama'),
            'active' => 1
        );
        $query_id = $this->input->save_query($query_array);
        redirect("master/mahasiswa/view/$query_id");
    }

    function info() {
        $id = $this->uri->segment(3);
        $data['auth'] = $this->auth;
        $criteria = array(
            'm_mahasiswa.id' => $id
        );
        $this->load->model('mahasiswa_model', 'mahasiswa');
        $result = $this->mahasiswa->get_many('', $criteria)->row_array();
        //[debug]echo get_instance()->db->last_query();
        $result_keys = array_keys($result);
        foreach ($result_keys as $result_key) {
            $data[$result_key] = $result[$result_key];
        }

        $data['tools'] = array(
            'master/mahasiswa' => 'Back',
            'master/mahasiswa/' . $id . '/edit' => 'Edit',
            'master/mahasiswa/' . $id . '/delete' => 'Delete'
        );
        $data['page_title'] = 'Detail Mahasiswa';
        $this->load->view('master/mahasiswa_info', $data);
    }

    function delete() {
        $id = $this->uri->segment(3);
        $this->crud->use_table('m_mahasiswa');
        $criteria = array('id' => $id);
        $data_in = array(
            'active' => 0,
            'modified_on' => logged_info()->on,
            'modified_by' => logged_info()->by
        );
        $this->crud->update($criteria, $data_in);
        redirect('master/mahasiswa');
    }

    function create() {
        $data['auth'] = $this->auth;
        $data['action_type'] = __FUNCTION__;
        $master_url = 'master/mahasiswa/';
 
        $this->load->library(array('form_validation', 'table'));
        $this->load->helper(array('form', 'snippets'));
        $this->form_validation->set_error_delimiters('<span class="notice">', '</span>');
        
        if ($this->form_validation->run('mahasiswa_create') === FALSE) {
            //don't do anything
        } else {
            $this->do_upload();
            $data     = $this->upload->data();
            $this->crud->use_table('m_mahasiswa');
            $data_in = array(
                'nim' => $this->input->post('nim'),
                'nama' => $this->input->post('nama'),
                'angkatan_id' => $this->input->post('angkatan_id'),
                'program_studi_id' => $this->input->post('program_studi_id'),
                'jenjang_studi_id' => $this->input->post('jenjang_studi_id'),
                'kons_studi_id' => $this->input->post('kons_studi_id'),
                'tempat_lahir' => $this->input->post('tempat_lahir'),
                'tgl_lahir' => $this->input->post('tgl_lahir'),
                'jenis_kelamin_id' => $this->input->post('jenis_kelamin_id'),
                'agama_id' => $this->input->post('agama_id'),
                'status_aktifitas_mhs' => $this->input->post('status_aktifitas_mhs'),
                'jml_sks_diakui' => $this->input->post('jml_sks_diakui'),
                'perguruan_tinggi_sebelumnya' => $this->input->post('perguruan_tinggi_sebelumnya'),
                'jurusan_sebelumnya' => $this->input->post('jurusan_sebelumnya'),
                'judicium' => $this->input->post('judicium'),
                'penasehat_akademik_id' => $this->input->post('penasehat_akademik_id'),
                'propinsi_asal_slta' => $this->input->post('propinsi_asal_slta'),
                'kota_asal_slta' => $this->input->post('kota_asal_slta'),
                'nama_slta' => $this->input->post('nama_slta'),
                'jurusan_slta' => $this->input->post('jurusan_slta'),
                'alamat' => $this->input->post('alamat'),
                'telepon' => $this->input->post('telepon'),
                'hobby' => $this->input->post('hobby'),
                'foto_mahasiswa' => $data['file_name'],
                'jabatan_akhir_id' => $this->input->post('jabatan_akhir_id'),
                'satuan_asal_id' => $this->input->post('satuan_asal_id'),
                'pangkat_id' => $this->input->post('pangkat_id'),
                'nrp' => $this->input->post('nrp'),
                'dik_abri' => $this->input->post('dik_abri'),
                'thn_dik_abri' => $this->input->post('thn_dik_abri'),
                'nama_ayah' => $this->input->post('nama_ayah'),
                'pekerjaan_ayah' => $this->input->post('pekerjaan_ayah'),
                'tgl_lahir_ayah' => $this->input->post('tgl_lahir_ayah'),
                'agama_ayah_id' => $this->input->post('agama_ayah_id'),
                'pendidikan_ayah' => $this->input->post('pendidikan_ayah'),
                'alamat_ayah' => $this->input->post('alamat_ayah'),
                'no_telepon' => $this->input->post('no_telepon'),
                'nama_wali' => $this->input->post('nama_wali'),
                'pekerjaan_wali' => $this->input->post('pekerjaan_wali'),
                'tgl_lahir_wali' => $this->input->post('tgl_lahir_wali'),
                'agama_wali_id' => $this->input->post('agama_wali_id'),
                'pendidikan_wali' => $this->input->post('pendidikan_wali'),
                'alamat_wali' => $this->input->post('alamat_wali'),
                'created_on' => date($this->config->item('log_date_format')),
                'created_by' => logged_info()->on
            );
            /*
              echo '<pre>';
              var_dump($data_in);
              echo '</pre>';
             */
            
            $created_id = $this->crud->create($data_in);
            redirect('master/mahasiswa/' . $created_id . '/info');
        }
        $data['action_url'] = $master_url . __FUNCTION__;
        $data['page_title'] = 'Create Mahasiswa';
        $data['tools'] = array(
            'master/mahasiswa' => 'Back'
        );

        $this->crud->use_table('m_angkatan');
        $data['angkatan_options'] = $this->crud->retrieve()->result();

        $this->crud->use_table('m_program_studi');
        $data['program_studi_options'] = $this->crud->retrieve()->result();
        
        $this->crud->use_table('m_jenjang_studi');
        $data['jenjang_studi_options'] = $this->crud->retrieve()->result();
        
        $this->crud->use_table('m_konsentrasi_studi');
        $data['konsentrasi_studi_options'] = $this->crud->retrieve()->result();
        
        $this->crud->use_table('m_jenis_kelamin');
        $data['jenis_kelamin_options'] = $this->crud->retrieve()->result();

        $this->crud->use_table('m_agama');
        $data['agama_options'] = $this->crud->retrieve()->result();

        $this->crud->use_table('m_status_dosen_penasehat');
        $data['status_dosen_penasehat_options'] = $this->crud->retrieve()->result();
        
        $this->crud->use_table('m_jabatan_tertinggi');
        $data['jabatan_tertinggi_options'] = $this->crud->retrieve()->result();
        
        $this->crud->use_table('m_kesatuan_asal');
        $data['kesatuan_asal_options'] = $this->crud->retrieve()->result();

        $this->crud->use_table('m_pangkat');
        $data['pangkat_options'] = $this->crud->retrieve()->result();
        
        $this->load->model('mahasiswa_model', 'mahasiswa');
        $data = array_merge($data, $this->mahasiswa->set_default()); //merge dengan arr data dengan default
        $this->load->view('master/mahasiswa_form', $data);
    }

    function edit() {
        $data['auth'] = $this->auth;
        $data['action_type'] = __FUNCTION__;
        $master_url = 'master/mahasiswa/';
        $id = $this->uri->segment(3);

        $this->load->library(array('form_validation', 'table'));
        $this->load->helper(array('form', 'snippets'));
        $this->form_validation->set_error_delimiters('<span class="notice">', '</span>');
        if ($this->form_validation->run('mahasiswa_update') === FALSE) {
            //don't do anything
        } else {
            $img = $this->do_upload();
            if(empty($img)){
                $this->crud->use_table('m_mahasiswa');
                $criteria = array(
                    'id' => $id
                );
                $data_in = array(
                    'nim' => $this->input->post('nim'),
                    'nama' => $this->input->post('nama'),
                    'angkatan_id' => $this->input->post('angkatan_id'),
                    'program_studi_id' => $this->input->post('program_studi_id'),
                    'jenjang_studi_id' => $this->input->post('jenjang_studi_id'),
                    'kons_studi_id' => $this->input->post('kons_studi_id'),
                    'tempat_lahir' => $this->input->post('tempat_lahir'),
                    'tgl_lahir' => $this->input->post('tgl_lahir'),
                    'jenis_kelamin_id' => $this->input->post('jenis_kelamin_id'),
                    'agama_id' => $this->input->post('agama_id'),
                    'status_aktifitas_mhs' => $this->input->post('status_aktifitas_mhs'),
                    'jml_sks_diakui' => $this->input->post('jml_sks_diakui'),
                    'perguruan_tinggi_sebelumnya' => $this->input->post('perguruan_tinggi_sebelumnya'),
                    'jurusan_sebelumnya' => $this->input->post('jurusan_sebelumnya'),
                    'judicium' => $this->input->post('judicium'),
                    'penasehat_akademik_id' => $this->input->post('penasehat_akademik_id'),
                    'propinsi_asal_slta' => $this->input->post('propinsi_asal_slta'),
                    'kota_asal_slta' => $this->input->post('kota_asal_slta'),
                    'nama_slta' => $this->input->post('nama_slta'),
                    'jurusan_slta' => $this->input->post('jurusan_slta'),
                    'alamat' => $this->input->post('alamat'),
                    'telepon' => $this->input->post('telepon'),
                    'hobby' => $this->input->post('hobby'),
                    'jabatan_akhir_id' => $this->input->post('jabatan_akhir_id'),
                    'satuan_asal_id' => $this->input->post('satuan_asal_id'),
                    'pangkat_id' => $this->input->post('pangkat_id'),
                    'nrp' => $this->input->post('nrp'),
                    'dik_abri' => $this->input->post('dik_abri'),
                    'thn_dik_abri' => $this->input->post('thn_dik_abri'),
                    'nama_ayah' => $this->input->post('nama_ayah'),
                    'pekerjaan_ayah' => $this->input->post('pekerjaan_ayah'),
                    'tgl_lahir_ayah' => $this->input->post('tgl_lahir_ayah'),
                    'agama_ayah_id' => $this->input->post('agama_ayah_id'),
                    'pendidikan_ayah' => $this->input->post('pendidikan_ayah'),
                    'alamat_ayah' => $this->input->post('alamat_ayah'),
                    'no_telepon' => $this->input->post('no_telepon'),
                    'nama_wali' => $this->input->post('nama_wali'),
                    'pekerjaan_wali' => $this->input->post('pekerjaan_wali'),
                    'tgl_lahir_wali' => $this->input->post('tgl_lahir_wali'),
                    'agama_wali_id' => $this->input->post('agama_wali_id'),
                    'pendidikan_wali' => $this->input->post('pendidikan_wali'),
                    'alamat_wali' => $this->input->post('alamat_wali'),
                    'created_on' => date($this->config->item('log_date_format')),
                    'created_by' => logged_info()->on
                );
            }else{
                $this->crud->use_table('m_mahasiswa');
                $criteria = array(
                    'id' => $id
                );
                $data_in = array(
                    'nim' => $this->input->post('nim'),
                    'nama' => $this->input->post('nama'),
                    'angkatan_id' => $this->input->post('angkatan_id'),
                    'program_studi_id' => $this->input->post('program_studi_id'),
                    'jenjang_studi_id' => $this->input->post('jenjang_studi_id'),
                    'kons_studi_id' => $this->input->post('kons_studi_id'),
                    'tempat_lahir' => $this->input->post('tempat_lahir'),
                    'tgl_lahir' => $this->input->post('tgl_lahir'),
                    'jenis_kelamin_id' => $this->input->post('jenis_kelamin_id'),
                    'agama_id' => $this->input->post('agama_id'),
                    'status_aktifitas_mhs' => $this->input->post('status_aktifitas_mhs'),
                    'jml_sks_diakui' => $this->input->post('jml_sks_diakui'),
                    'perguruan_tinggi_sebelumnya' => $this->input->post('perguruan_tinggi_sebelumnya'),
                    'jurusan_sebelumnya' => $this->input->post('jurusan_sebelumnya'),
                    'judicium' => $this->input->post('judicium'),
                    'penasehat_akademik_id' => $this->input->post('penasehat_akademik_id'),
                    'propinsi_asal_slta' => $this->input->post('propinsi_asal_slta'),
                    'kota_asal_slta' => $this->input->post('kota_asal_slta'),
                    'nama_slta' => $this->input->post('nama_slta'),
                    'jurusan_slta' => $this->input->post('jurusan_slta'),
                    'alamat' => $this->input->post('alamat'),
                    'telepon' => $this->input->post('telepon'),
                    'hobby' => $this->input->post('hobby'),
                    'foto_mahasiswa' => $img,
                    'jabatan_akhir_id' => $this->input->post('jabatan_akhir_id'),
                    'satuan_asal_id' => $this->input->post('satuan_asal_id'),
                    'pangkat_id' => $this->input->post('pangkat_id'),
                    'nrp' => $this->input->post('nrp'),
                    'dik_abri' => $this->input->post('dik_abri'),
                    'thn_dik_abri' => $this->input->post('thn_dik_abri'),
                    'nama_ayah' => $this->input->post('nama_ayah'),
                    'pekerjaan_ayah' => $this->input->post('pekerjaan_ayah'),
                    'tgl_lahir_ayah' => $this->input->post('tgl_lahir_ayah'),
                    'agama_ayah_id' => $this->input->post('agama_ayah_id'),
                    'pendidikan_ayah' => $this->input->post('pendidikan_ayah'),
                    'alamat_ayah' => $this->input->post('alamat_ayah'),
                    'no_telepon' => $this->input->post('no_telepon'),
                    'nama_wali' => $this->input->post('nama_wali'),
                    'pekerjaan_wali' => $this->input->post('pekerjaan_wali'),
                    'tgl_lahir_wali' => $this->input->post('tgl_lahir_wali'),
                    'agama_wali_id' => $this->input->post('agama_wali_id'),
                    'pendidikan_wali' => $this->input->post('pendidikan_wali'),
                    'alamat_wali' => $this->input->post('alamat_wali'),
                    'created_on' => date($this->config->item('log_date_format')),
                    'created_by' => logged_info()->on
                );
            }
            
            $this->crud->update($criteria, $data_in);
            redirect('master/mahasiswa/' . $id . '/info');
        }
        $data['action_url'] = $master_url . $id . '/' . __FUNCTION__;
        $data['page_title'] = 'Update Mahasiswa';
        $data['tools'] = array(
            'master/mahasiswa' => 'Back'
        );

        $this->crud->use_table('m_mahasiswa');
        $mahasiswa_data = $this->crud->retrieve(array('id' => $id))->row();

        $this->crud->use_table('m_angkatan');
        $data['angkatan_options'] = $this->crud->retrieve()->result();

        $this->crud->use_table('m_program_studi');
        $data['program_studi_options'] = $this->crud->retrieve()->result();
        
        $this->crud->use_table('m_jenjang_studi');
        $data['jenjang_studi_options'] = $this->crud->retrieve()->result();
        
        $this->crud->use_table('m_konsentrasi_studi');
        $data['konsentrasi_studi_options'] = $this->crud->retrieve()->result();
        
        $this->crud->use_table('m_jenis_kelamin');
        $data['jenis_kelamin_options'] = $this->crud->retrieve()->result();

        $this->crud->use_table('m_agama');
        $data['agama_options'] = $this->crud->retrieve()->result();

        $this->crud->use_table('m_status_dosen_penasehat');
        $data['status_dosen_penasehat_options'] = $this->crud->retrieve()->result();
        
        $this->crud->use_table('m_jabatan_tertinggi');
        $data['jabatan_tertinggi_options'] = $this->crud->retrieve()->result();
        
        $this->crud->use_table('m_kesatuan_asal');
        $data['kesatuan_asal_options'] = $this->crud->retrieve()->result();

        $this->crud->use_table('m_pangkat');
        $data['pangkat_options'] = $this->crud->retrieve()->result();

        $this->load->model('mahasiswa_model', 'mahasiswa');
        $data = array_merge($data, $this->mahasiswa->set_default()); //merge dengan arr data dengan default
        $data = array_merge($data, (array) $mahasiswa_data);
        $this->load->view('master/mahasiswa_form', $data);
    }

    function unique_nim($nim) {
        $this->crud->use_table('m_mahasiswa');
        $mahasiswa = $this->crud->retrieve(array('nim' => $nim))->row();
        if (sizeof($mahasiswa) > 0) {
            $this->form_validation->set_message(__FUNCTION__, 'Nim Mahasiswa sudah terdaftar'); //pakai function karena ini harus sama dengan nama function nya
            return FALSE;
        } else {
            return true;
        }
    }
    
    function do_upload()
    {
        $config['upload_path']	= "./assets/mahasiswa/images/";
        $config['allowed_types']= 'gif|jpg|png|jpeg';
        $config['max_size']     = '2000';
        $config['max_width']    = '2000';
        $config['max_height']   = '2000';
        $config['encrypt_name']    = TRUE;
        
        $this->load->library('upload', $config);
        
        if ($this->upload->do_upload("foto_mahasiswa")) {
            $data	 	= $this->upload->data();
            //print_r($data);
            /* PATH */
            $source             = "./assets/mahasiswa/images/".$data['file_name'] ;
            $destination_thumb	= "./assets/mahasiswa/thumbs/" ;
            $destination_medium	= "./assets/mahasiswa/medium/" ;
 
            // Permission Configuration
            chmod($source, 0777) ;
 
            /* Resizing Processing */
	    // Configuration Of Image Manipulation :: Static
	    $this->load->library('image_lib') ;
	    $img['image_library'] = 'GD2';
	    $img['create_thumb']  = TRUE;
	    $img['maintain_ratio']= TRUE;
 
            /// Limit Width Resize
            $limit_medium   = 460;
            $limit_thumb    = 90 ;
 
            // Size Image Limit was using (LIMIT TOP)
            $limit_use  = $data['image_width'] > $data['image_height'] ? $data['image_width'] : $data['image_height'] ;
 
            // Percentase Resize
            if ($limit_use > $limit_medium || $limit_use > $limit_thumb) {
                $percent_medium = $limit_medium/$limit_use ;
                $percent_thumb  = $limit_thumb/$limit_use ;
            }
 
            //// Making THUMBNAIL ///////
	    $img['width']  = $limit_use > $limit_thumb ?  $data['image_width'] * $percent_thumb : $data['image_width'] ;
            $img['height'] = $limit_use > $limit_thumb ?  $data['image_height'] * $percent_thumb : $data['image_height'] ;
 
            // Configuration Of Image Manipulation :: Dynamic
            $img['thumb_marker'] = '_thumb';
            $img['quality']      = '100%' ;
            $img['source_image'] = $source ;
            $img['new_image']    = $destination_thumb ;
 
            // Do Resizing
            $this->image_lib->initialize($img);
            $this->image_lib->resize();
            $this->image_lib->clear() ;
 
            ////// Making MEDIUM /////////////
            $img['width']   = $limit_use > $limit_medium ?  $data['image_width'] * $percent_medium : $data['image_width'] ;
            $img['height']  = $limit_use > $limit_medium ?  $data['image_height'] * $percent_medium : $data['image_height'] ;
 
            // Configuration Of Image Manipulation :: Dynamic
            $img['thumb_marker'] = '_medium';
            $img['quality']      = '100%' ;
            $img['source_image'] = $source ;
            $img['new_image']    = $destination_medium ;
 
            // Do Resizing
            $this->image_lib->initialize($img);
            $this->image_lib->resize();
            $this->image_lib->clear() ;
            return $data['file_name'] ;
        }
         else 
        {
             $data = $this->upload->data();
             //print_r($data);
            //echo $this->upload->display_errors();
        }
    }
}

?>
