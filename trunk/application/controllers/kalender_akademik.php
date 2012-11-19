<?php

/*
 * Sofian
 * transaction Kurikulum : Kalender Akademik
 * 8/9/2012
 */

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Kalender_akademik extends CI_Controller {

	function __construct() {
        parent::__construct();
        $this->load->helper(array('snippets_helper'));
        $this->load->model('crud_model', 'crud');
    }

    function log_date() {
        return date($this->config->item('log_date_format'));
    }

    function index($query_id = 0, $sort_by = 'id', $sort_order = 'desc', $offset = 0) {
        $this->kalender_akademik($query_id, $sort_by, $sort_order, $offset);
    }

    function kalender_akademik($query_id = 0, $sort_by = 'id', $sort_order = 'desc', $offset = 0) {
        $data_type = $this->input->post('data_type');
        $data['auth'] = $this->auth;
        // pagination
        $limit = 5;
        $this->load->library(array('form_validation', 'table', 'pagination'));
        $this->input->load_query($query_id);
        $query_array = array(
            'nama_dosen' => $this->input->get('nama_dosen'),
            'nama_ruang' => $this->input->get('nama_ruang'),
            'active' => 1
        );

        $this->load->model('kalender_akademik_model', 'kalender_akademik');
        $results = $this->kalender_akademik->search($query_array, $limit, $offset, $sort_by, $sort_order);
        //echo get_instance()->db->last_query();
        $data['results'] = $results['results'];
        $data['num_results'] = $results['num_rows'];

        // pagination
        $config = array();
        $config['base_url'] = site_url("transaction/kalender_akademik/$query_id/$sort_by/$sort_order");
        $config['total_rows'] = $data['num_results'];
        $config['per_page'] = $limit;
        $config['uri_segment'] = 6;
        $config['num_links'] = 6;

        $config = array_merge($config, default_pagination_btn());
        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();
        $data['sort_by'] = $sort_by;
        $data['sort_order'] = $sort_order;

        $data['page_title'] = 'Kalender Akademik';

        $data['tools'] = array(
            'transaction/kalender_akademik/create' => 'New'
        );

        $this->load->view('transaction/kalender_akademik', $data);
    }

    function search() {
        $query_array = array(
            'nama_dosen' => $this->input->post('nama_dosen'),
            'nama_ruang' => $this->input->post('nama_ruang'),
            'active' => 1
        );
        $query_id = $this->input->save_query($query_array);
        redirect("transaction/kalender_akademik/view/$query_id");
    }

    function info() {
        $id = $this->uri->segment(3);
        $data['auth'] = $this->auth;
        $criteria = array(
            't_kalender_akademik.id' => $id
        );
        $this->load->model('kalender_akademik_model', 'kalender_akademik');
        $result = $this->kalender_akademik->get_many('', $criteria)->row_array();
        //[debug]echo get_instance()->db->last_query();
        $result_keys = array_keys($result);
        foreach ($result_keys as $result_key) {
            $data[$result_key] = $result[$result_key];
        }

        $data['tools'] = array(
            'transaction/kalender_akademik' => 'Back',
            'transaction/kalender_akademik/' . $id . '/edit' => 'Edit',
            'transaction/kalender_akademik/' . $id . '/delete' => 'Delete'
        );
        $data['page_title'] = 'Detail Kalender Akademik';
        $this->load->view('transaction/kalender_akademik_info', $data);
    }

    function delete() {
        $id = $this->uri->segment(3);
        $this->crud->use_table('t_kalender_akademik');
        $criteria = array('id' => $id);
        $data_in = array(
            'active' => 0,
            'modified_on' => logged_info()->on,
            'modified_by' => logged_info()->by
        );
        $this->crud->update($criteria, $data_in);
        redirect('transaction/kalender_akademik');
    }
	
	function create() {
		$data['auth'] = $this->auth;
        $data['action_type'] = __FUNCTION__;
        $transaction_url = 'transaction/kalender_akademik/';
		$id = $this->uri->segment(3);
        $this->load->library(array('form_validation', 'table'));
        $this->load->helper(array('form', 'snippets'));
        $this->form_validation->set_error_delimiters('<span class="notice">', '</span>');

		$is_valid=1;
		if($this->input->post('angkatan_id')<=0) {$is_valid=0;}
//		if($this->input->post('semester_id')<=0) {$is_valid=0;}
//		if($this->input->post('tahun_akademik_id_attr')<=0) {$is_valid=0;}
		if($this->input->post('tgl_mulai')<=0) {$is_valid=0;}
		if($this->input->post('tgl_akhir')<=0) {$is_valid=0;}
        if ($this->form_validation->run('kalender_akademik_create') === TRUE) {
            //don't do anything
        } else {
			if($is_valid==0){
			} else {
				$this->crud->use_table('t_kalender_akademik');
				$data_in = array(
					'plot_semester_id'	=> $this->input->post('semester_id'),
					'tgl_mulai_kegiatan' => $this->input->post('tgl_mulai'),
					'tgl_akhir_kegiatan' => $this->input->post('tgl_akhir'),
					'nama_kegiatan' => $this->input->post('nama_kegiatan'),
					'created_on'   => date($this->config->item('log_date_format')),
					'created_by'   => logged_info()->on
				);
			        
/*				  echo '<pre>';
				  var_dump($data_in);
				  echo '</pre>';
				  return;*/
				
				$created_id = $this->crud->create($data_in);
				redirect('transaction/kalender_akademik/' . $created_id . '/info');
			}
        }
		
		$data['angkatan_id']=$this->input->post('angkatan_id');
		$data['semester_id']=$this->input->post('semester_id');
		$data['tahun_akademik_id']=$this->input->post('tahun_akademik_id');
    	$data['tgl_kalender_mulai']=$this->input->post('tgl_mulai');
		$data['tgl_kalender_akhir']=$this->input->post('tgl_akhir');
        $data['action_url'] = $transaction_url . __FUNCTION__;
        $data['page_title'] = 'Create Kalender Akademik';
        $data['tools'] = array('transaction/kalender_akademik' => 'Back');
		$data['tahun_akademik_id_attr'] = '';
		$angkatan_ids=$this->input->post('angkatan_id');
		
		$this->crud->use_table('m_angkatan');
		$angkatan_data = array();
		$angkatan_data[0] = '';
        foreach ($this->crud->retrieve()->result() as $row) {
			$angkatan_data[$row->id] = $row->nama_angkatan;
        }
		$data['angkatan_options']=$angkatan_data;
        
		$this->crud->use_table('t_plot_semester','m_semester');
		$semester_data = array();
		$semester_data[0] = '';
        foreach ($this->crud->retrieve()->result() as $row) {
			$semester_data[$row->id] = $row->semester_id;
        }
		$data['semester_options']=$semester_data;
		
        $this->crud->use_table('m_tahun_akademik');
		$tahun_akademik_data = array();
		$tahun_akademik_data[0] = '';
        foreach ($this->crud->retrieve()->result() as $row) {
			$tahun_akademik_data[$row->id] = $row->tahun_ajar_mulai.'-'.$row->tahun_ajar_akhir;
		}
        $data['tahun_akademik_options'] = $tahun_akademik_data;

			
        $data['opt_angkatan_url'] = base_url() . 'transaction/select_data_form/getOptAngkatan';
		$data['opt_program_studi_url'] = base_url() . 'transaction/select_data_form/getOptProgramStudi';
        $data['opt_mata_kuliah_url'] =  base_url() . 'transaction/select_data_form/getOptMataKuliah';
              
        $this->load->model('kalender_akademik_model', 'kalender_akademik');
        $data = array_merge($data, $this->kalender_akademik->set_default()); //merge dengan arr data dengan default
		//$data['action_url'] = $transaction_url . $id . '/' . __FUNCTION__;
		$data['action_url'] = $transaction_url . '/' . __FUNCTION__;
        $this->load->view('transaction/kalender_akademik_form', $data);
    }

    function edit() {
        $data['auth'] = $this->auth;
        $data['action_type'] = __FUNCTION__;
        $transaction_url = 'transaction/kalender_akademik/';
        $id = $this->uri->segment(3);
		//echo '<pre>id:'.$id.'</pre>';

        $this->load->library(array('form_validation', 'table'));
        $this->load->helper(array('form', 'snippets'));
        $this->form_validation->set_error_delimiters('<span class="notice">', '</span>');
		$is_valid=1;
		if($this->input->post('angkatan_id')<=0) {$is_valid=0;}
		if($this->input->post('program_studi_id')<=0) {$is_valid=0;}
		if($this->input->post('semester_id')<=0) {$is_valid=0;}
		if($this->input->post('tgl_lahir')=='') {$is_valid=0;}	
		if($this->input->post('nama_ruang_id')<=0) {$is_valid=0;}
		if($this->input->post('jenis_waktu')<=0) {$is_valid=0;}
		
        if ($this->form_validation->run('kalender_akademik_update') === FALSE) {
            //don't do anything
        } else {
			if($is_valid==0){
			} else {
			
				$this->crud->use_table('t_kalender_akademik');
				$criteria = array(
					'id' => $id
				);
			
				//$data['angkatan_options']=$angkatan_data;
				$this->crud->use_table('t_kalender_akademik');
				$data_in = array(
					'plot_semester_id'	=> $this->input->post('semester_id'),
					'tgl_mulai_kegiatan' => $this->input->post('tgl_mulai'),
					'tgl_akhir_kegiatan' => $this->input->post('tgl_akhir'),
					'nama_kegiatan' => $this->input->post('nama_kegiatan'),
					'created_on'   => date($this->config->item('log_date_format')),
					'created_by'   => logged_info()->on
				);
				/*       
				  echo '<pre>';
				  var_dump($data_in);
				  echo '</pre>';
				  return;
				 */
				$this->crud->update($criteria, $data_in);
				redirect('transaction/kalender_akademik/' . $id . '/info');
			}
        }
		
		$data['angkatan_id']=$this->input->post('angkatan_id');
		$data['program_studi']=$this->input->post('program_studi_id');
		$data['kegiatan_id']=$this->input->post('kegiatan_id');
		$data['metode_ajar_id']=$this->input->post('metode_ajar_id');
		$data['tahun_akademik_id']=$this->input->post('tahun_akademik_id');
		$data['semester_id']=$this->input->post('semester_id');
	
        $data['action_url'] = $transaction_url . __FUNCTION__;
        $data['page_title'] = 'Update Jadwal Kuliah';
        $data['tools'] = array('transaction/kalender_akademik' => 'Back');
		
		$this->crud->use_table('m_angkatan');
		$angkatan_data = array();
        foreach ($this->crud->retrieve()->result() as $row) {
			$angkatan_data[$row->id] = $row->nama_angkatan;
        }
		$data['angkatan_options']=$angkatan_data;
        
        $this->crud->use_table('t_kalender_akademik');
		//echo $id; return;
        $kalender_akademik_data = $this->crud->retrieve(array('id' => $id))->row();
		
//		$this->crud->use_table('m_tahun_akademik');
//		$tahun_akademik_data = array();
//		$criteria = array(
//					'id' => $kalender_akademik_data->angkatan_id
//				);
//		$data['tahun_akademik_id_attr'] = '';
//        foreach ($this->crud->retrieve($criteria)->result() as $row) {
//			$data['tahun_akademik_id_attr'] =$row->tahun_ajar_mulai.'-'.$row->tahun_ajar_akhir;;
//			$tahun_akademik_data[$row->id] = $row->tahun_ajar_mulai.'-'.$row->tahun_ajar_akhir;
//		}
//        $data['tahun_akademik_options'] = $tahun_akademik_data;
		
        
		$this->crud->use_table('m_metode_ajar');
		$metode_ajar_data = array();
        foreach ($this->crud->retrieve()->result() as $row) {
			$metode_ajar_data[$row->id] = $row->metode_ajar;
		}
        $data['metode_ajar_options'] = $metode_ajar_data;
		
		$this->crud->use_table('m_semester');
		$semester_data = array();
		foreach ($this->crud->retrieve()->result() as $row) {
			$semester_data[$row->id] = $row->nama_semester;
		}
        $data['semester_options'] = $semester_data;
		
		
        $data['opt_angkatan_url'] = base_url() . 'transaction/select_data_form/getOptAngkatan';
		$data['opt_program_studi_url'] = base_url() . 'transaction/select_data_form/getOptProgramStudi';
        $data['opt_mata_kuliah_url'] =  base_url() . 'transaction/select_data_form/getOptMataKuliah';
        
        $this->crud->use_table('m_dosen');
        $data['nama_dosen_options'] = $this->crud->retrieve()->result();
        
        $this->crud->use_table('m_data_ruang');
        $data['ruang_pelajaran_options'] = $this->crud->retrieve()->result();
		
		$this->crud->use_table('m_jam_pelajaran');
        $data['jam_pelajaran_options'] = $this->crud->retrieve()->result();

		
        $this->load->model('kalender_akademik_model', 'kalender_akademik');
        $data = array_merge($data, $this->kalender_akademik->set_default()); //merge dengan arr data dengan default
        $data = array_merge($data, (array) $kalender_akademik_data);
		$data['action_url'] = $transaction_url . $id . '/' . __FUNCTION__;
		//print_r($kalender_akademik_data);
        $this->load->view('transaction/kalender_akademik_form', $data);
		//echo '<pre>'. $data['action_url'].'</pre>';
    }
	

}

?>
