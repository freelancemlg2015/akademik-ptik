<?php

/*
 * Sofian
 * transaction Kurikulum : Plot Semester
 * 8/9/2012
 */

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Plot_semester extends CI_Controller {

	function __construct() {
        parent::__construct();
        $this->load->helper(array('snippets_helper'));
        $this->load->model('crud_model', 'crud');
    }

    function log_date() {
        return date($this->config->item('log_date_format'));
    }

    function index($query_id = 0, $sort_by = 'id', $sort_order = 'desc', $offset = 0) {
        $this->plot_semester($query_id, $sort_by, $sort_order, $offset);
    }

    function plot_semester($query_id = 0, $sort_by = 'id', $sort_order = 'desc', $offset = 0) {
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

        $this->load->model('plot_semester_model', 'plot_semester');
        $results = $this->plot_semester->search($query_array, $limit, $offset, $sort_by, $sort_order);
        //echo get_instance()->db->last_query();
        $data['results'] = $results['results'];
        $data['num_results'] = $results['num_rows'];

        // pagination
        $config = array();
        $config['base_url'] = site_url("transaction/plot_semester/$query_id/$sort_by/$sort_order");
        $config['total_rows'] = $data['num_results'];
        $config['per_page'] = $limit;
        $config['uri_segment'] = 6;
        $config['num_links'] = 6;

        $config = array_merge($config, default_pagination_btn());
        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();
        $data['sort_by'] = $sort_by;
        $data['sort_order'] = $sort_order;

        $data['page_title'] = 'Plot Semester';

        $data['tools'] = array(
            'transaction/plot_semester/create' => 'New'
        );

        $this->load->view('transaction/plot_semester', $data);
    }

    function search() {
        $query_array = array(
            'nama_dosen' => $this->input->post('nama_dosen'),
            'nama_ruang' => $this->input->post('nama_ruang'),
            'active' => 1
        );
        $query_id = $this->input->save_query($query_array);
        redirect("transaction/plot_semester/view/$query_id");
    }

    function info() {
        $id = $this->uri->segment(3);
        $data['auth'] = $this->auth;
        $criteria = array(
            't_plot_semester.id' => $id
        );
        $this->load->model('plot_semester_model', 'plot_semester');
        $result = $this->plot_semester->get_many('', $criteria)->row_array();
        //[debug]echo get_instance()->db->last_query();
        $result_keys = array_keys($result);
        foreach ($result_keys as $result_key) {
            $data[$result_key] = $result[$result_key];
        }

        $data['tools'] = array(
            'transaction/plot_semester' => 'Back',
            'transaction/plot_semester/' . $id . '/edit' => 'Edit',
            'transaction/plot_semester/' . $id . '/delete' => 'Delete'
        );
        $data['page_title'] = 'Detail Plot Semester';
        $this->load->view('transaction/plot_semester_info', $data);
    }

    function delete() {
        $id = $this->uri->segment(3);
        $this->crud->use_table('t_plot_semester');
        $criteria = array('id' => $id);
        $data_in = array(
            'active' => 0,
            'modified_on' => logged_info()->on,
            'modified_by' => logged_info()->by
        );
        $this->crud->update($criteria, $data_in);
        redirect('transaction/plot_semester');
    }
	
	function create() {
		$data['auth'] = $this->auth;
        $data['action_type'] = __FUNCTION__;
        $transaction_url = 'transaction/plot_semester/';
		$id = $this->uri->segment(3);
        $this->load->library(array('form_validation', 'table'));
        $this->load->helper(array('form', 'snippets'));
        $this->form_validation->set_error_delimiters('<span class="notice">', '</span>');
		
		$is_valid=1;
		if($this->input->post('angkatan_id')<=0) {$is_valid=0;}
		if($this->input->post('semester_id')<=0) {$is_valid=0;}
		if($this->input->post('tahun_akademik_id_attr')<=0) {$is_valid=0;}
		if($this->input->post('tgl_mulai')<=0) {$is_valid=0;}
		if($this->input->post('tgl_akhir')<=0) {$is_valid=0;}
        if ($this->form_validation->run('plot_semester_create') === FALSE) {
            //don't do anything
        } else {
			if($is_valid==0){
			} else {
				//$hari_ids = $this->input->post('tgl_mulai');
				//$hari_id = date("w",strtotime($hari_ids."w"));
				$this->crud->use_table('t_plot_semester');
				$data_in = array(
				    'angkatan_id'	=> $this->input->post('angkatan_id'),				
					'tahun_akademik_id' => $this->input->post('semester_id'),
					'semester_id'	=> $this->input->post('semester_id'),
					'tgl_kalender_mulai' => $this->input->post('tgl_mulai'),
					'tgl_kalender_akhir' => $this->input->post('tgl_akhir'),
					'created_on'   => date($this->config->item('log_date_format')),
					'created_by'   => logged_info()->on
				);
			        
/*			  echo '<pre>';
				  var_dump($data_in);
				  echo '</pre>';
				  return;*/
				
				$created_id = $this->crud->create($data_in);
				redirect('transaction/plot_semester/' . $created_id . '/info');
			}
        }
		
		$data['angkatan_id']=$this->input->post('angkatan_id');
		$data['semester_id']=$this->input->post('semester_id');
		$data['tahun_akademik_id']=$this->input->post('tahun_akademik_id');
    	$data['tgl_kalender_mulai']=$this->input->post('tgl_mulai');
		$data['tgl_kalender_akhir']=$this->input->post('tgl_akhir');
        $data['action_url'] = $transaction_url . __FUNCTION__;
        $data['page_title'] = 'Create Plot Semester';
        $data['tools'] = array('transaction/plot_semester' => 'Back');
		$data['tahun_akademik_id_attr'] = '';
		$angkatan_ids=$this->input->post('angkatan_id');
		
		$this->crud->use_table('m_angkatan');
		$angkatan_data = array();
		$angkatan_data[0] = '';
        foreach ($this->crud->retrieve()->result() as $row) {
			$angkatan_data[$row->id] = $row->nama_angkatan;
        }
		$data['angkatan_options']=$angkatan_data;
        
        $this->crud->use_table('m_tahun_akademik');
		$tahun_akademik_data = array();
		$tahun_akademik_data[0] = '';
        foreach ($this->crud->retrieve()->result() as $row) {
			$tahun_akademik_data[$row->id] = $row->tahun_ajar_mulai.'-'.$row->tahun_ajar_akhir;
		}
        $data['tahun_akademik_options'] = $tahun_akademik_data;

        $this->crud->use_table('m_semester');
		$semester_data = array();
		$semester_data[0] = '';
		foreach ($this->crud->retrieve()->result() as $row) {
			$semester_data[$row->id] = $row->nama_semester;
		}
        $data['semester_options'] = $semester_data;
			
        $data['opt_angkatan_url'] = base_url() . 'transaction/select_data_form/getOptAngkatan';
		$data['opt_program_studi_url'] = base_url() . 'transaction/select_data_form/getOptProgramStudi';
        $data['opt_mata_kuliah_url'] =  base_url() . 'transaction/select_data_form/getOptMataKuliah';
              
        $this->load->model('plot_semester_model', 'plot_semester');
        $data = array_merge($data, $this->plot_semester->set_default()); //merge dengan arr data dengan default
		$data['action_url'] = $transaction_url . '/' . __FUNCTION__;
        $this->load->view('transaction/plot_semester_form', $data);
    }

    function edit() {
        $data['auth'] = $this->auth;
        $data['action_type'] = __FUNCTION__;
        $transaction_url = 'transaction/plot_semester/';
        $id = $this->uri->segment(3);
		//echo '<pre>id:'.$id.'</pre>';

        $this->load->library(array('form_validation', 'table'));
        $this->load->helper(array('form', 'snippets'));
        $this->form_validation->set_error_delimiters('<span class="notice">', '</span>');
		$is_valid=1;
		if($this->input->post('angkatan_id')<=0) {$is_valid=0;}
		if($this->input->post('semester_id')<=0) {$is_valid=0;}
		if($this->input->post('tahun_akademik_id_attr')<=0) {$is_valid=0;}
		if($this->input->post('tgl_mulai')<=0) {$is_valid=0;}
		if($this->input->post('tgl_akhir')<=0) {$is_valid=0;}


		//if($is_valid==0){
        if ($this->form_validation->run('plot_semester_update') === FALSE) {
            //don't do anything
        } else {
			if($is_valid==0){
			} else {
				$this->crud->use_table('t_plot_semester');
				$criteria = array(
                    'id' => $id
                );
				$data_in = array(
				    'angkatan_id'	=> $this->input->post('angkatan_id'),				
					'tahun_akademik_id' => $this->input->post('semester_id'),
					'semester_id'	=> $this->input->post('semester_id'),
					'tgl_kalender_mulai' => $this->input->post('tgl_mulai'),
					'tgl_kalender_akhir' => $this->input->post('tgl_akhir'),
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
				redirect('transaction/plot_semester/' . $id . '/info');
			}
        }
		
		$data['angkatan_id']=$this->input->post('angkatan_id');
		$data['semester_id']=$this->input->post('semester_id');
		$data['tahun_akademik_id']=$this->input->post('tahun_akademik_id');
    	$data['tgl_kalender_mulai']=$this->input->post('tgl_mulai');
		$data['tgl_kalender_akhir']=$this->input->post('tgl_akhir');
        $data['action_url'] = $transaction_url . __FUNCTION__;
        $data['page_title'] = 'Update Jadwal Kuliah';
        $data['tools'] = array('transaction/plot_semester' => 'Back');
		
		$this->crud->use_table('m_angkatan');
		$angkatan_data = array();
        foreach ($this->crud->retrieve()->result() as $row) {
			$angkatan_data[$row->id] = $row->nama_angkatan;
        }
		$data['angkatan_options']=$angkatan_data;
        
        $this->crud->use_table('t_plot_semester');
		//echo $id; return;
        $plot_semester_data = $this->crud->retrieve(array('id' => $id))->row();
		
		$this->crud->use_table('m_tahun_akademik');
		$tahun_akademik_data = array();
		$criteria = array(
					'id' => $plot_semester_data->angkatan_id
				);
		$data['tahun_akademik_id_attr'] = '';
        foreach ($this->crud->retrieve($criteria)->result() as $row) {
			$data['tahun_akademik_id_attr'] =$row->tahun_ajar_mulai.'-'.$row->tahun_ajar_akhir;;
			$tahun_akademik_data[$row->id] = $row->tahun_ajar_mulai.'-'.$row->tahun_ajar_akhir;
		}
        $data['tahun_akademik_options'] = $tahun_akademik_data;
		
		$this->crud->use_table('m_semester');
		$semester_data = array();
		foreach ($this->crud->retrieve()->result() as $row) {
			$semester_data[$row->id] = $row->nama_semester;
		}
        $data['semester_options'] = $semester_data;
		
        $data['opt_angkatan_url'] = base_url() . 'transaction/select_data_form/getOptAngkatan';
		$data['opt_program_studi_url'] = base_url() . 'transaction/select_data_form/getOptProgramStudi';
        $data['opt_mata_kuliah_url'] =  base_url() . 'transaction/select_data_form/getOptMataKuliah';
     

		
        $this->load->model('plot_semester_model', 'plot_semester');
        $data = array_merge($data, $this->plot_semester->set_default()); //merge dengan arr data dengan default
        $data = array_merge($data, (array) $plot_semester_data);
		$data['action_url'] = $transaction_url . $id . '/' . __FUNCTION__;
		//print_r($plot_semester_data);
        $this->load->view('transaction/plot_semester_form', $data);
		//echo '<pre>'. $data['action_url'].'</pre>';
    }
	

}

?>
