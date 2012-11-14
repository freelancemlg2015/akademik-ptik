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
		
		//$dosen_ajar_id = $this->input->post('dosen_ajar_id');
		//echo 'dosen_ajar_id:'.$dosen_ajar_id;
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
					'semester_id'	=> $this->input->post('semester_id'),
					'angkatan_id'	=> $this->input->post('angkatan_id'),
					'tahun_akademik_id' => $this->input->post('angkatan_id'),
					'tgl_kalender_mulai ' => $this->input->post('tgl_mulai'),
					'tgl_kalender_akhir' => $this->input->post('tgl_akhir'),
					'created_on'   => date($this->config->item('log_date_format')),
					'created_by'   => logged_info()->on
				);
			        
/*				  echo '<pre>';
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
		//$data['action_url'] = $transaction_url . $id . '/' . __FUNCTION__;
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
		if($this->input->post('program_studi_id')<=0) {$is_valid=0;}
		
		if($this->input->post('semester_id')<=0) {$is_valid=0;}
		//if($this->input->post('mata_kuliah_id')<=0) {$is_valid=0;}
		//if($this->input->post('tahun_akademik_id')<=0) {$is_valid=0;}
		if($this->input->post('tgl_lahir')=='') {$is_valid=0;}
		
		if($this->input->post('nama_ruang_id')<=0) {$is_valid=0;}
		if($this->input->post('jenis_waktu')<=0) {$is_valid=0;}
		
		$mata_kuliah_id=(int)$this->input->post('mata_kuliah_id');
		$kegiatan_id=$this->input->post('kegiatan_id');
		//echo $mata_kuliah_id;
		if(($mata_kuliah_id==0) && ($kegiatan_id==0)) {$is_valid=0;}
		if($kegiatan_id>0) $mata_kuliah_id = 0;
		//if($is_valid==0){
        if ($this->form_validation->run('plot_semester_update') === FALSE) {
            //don't do anything
        } else {
			if($is_valid==0){
			} else {
				$jenis_waktu_id = $this->input->post('jenis_waktu');
				$this->crud->use_table('m_jam_pelajaran');
				$criteria = array(
					'id' => $jenis_waktu_id
				);
				//public function retrieve($criteria = '', $fields = '*', $limit = 0, $offset = 0, $order = '') {
				foreach ($this->crud->retrieve($criteria)->result() as $row) {
					$jam_mulai = $row->jam_normal_mulai;
					$jam_selesai = $row->jam_normal_akhir;
				}
				
				$this->crud->use_table('t_plot_semester');
				$criteria = array(
					'id' => $id
				);
				if($kegiatan_id>0) $mata_kuliah_id = 0;
				$hari_ids = $this->input->post('tgl_lahir');
				$hari_id = date("w",strtotime($hari_ids."w"));
				
				//$data['angkatan_options']=$angkatan_data;
				$this->crud->use_table('t_plot_semester');
				$data_in = array(
					'program_studi_id'=> $this->input->post('program_studi_id'),
					'semester_id'	=> $this->input->post('semester_id'),
					'angkatan_id'	=> $this->input->post('angkatan_id'),
					'metode_ajar_id'=> $this->input->post('metode_ajar_id'),
					'tanggal'		=> $this->input->post('tgl_lahir'),
					'minggu_ke'		=> $this->input->post('minggu_ke'),
					'pertemuan_ke'	=> $this->input->post('pertemuan_ke'),
					'pertemuan_dari'=> $this->input->post('pertemuan_dari'),
					'mata_kuliah_id'=> $mata_kuliah_id,
					'kegiatan_id'	=> $kegiatan_id,
					'nama_ruang_id'	=> $this->input->post('nama_ruang_id'),
					'jenis_waktu'  	=> $this->input->post('jenis_waktu'),
					'hari_id'      	=> $hari_id,
					'jam_mulai'     => $jam_mulai,
					'jam_selesai'   => $jam_selesai,
					'modified_on'   => date($this->config->item('log_date_format')),
					'modified_by'   => logged_info()->on
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
		$data['program_studi']=$this->input->post('program_studi_id');
		$data['kegiatan_id']=$this->input->post('kegiatan_id');
		$data['metode_ajar_id']=$this->input->post('metode_ajar_id');
		$data['tahun_akademik_id']=$this->input->post('tahun_akademik_id');
		$data['semester_id']=$this->input->post('semester_id');
		
		$data['minggu_ke']=$this->input->post('minggu_ke');
		$data['tgl_lahir']=$this->input->post('tgl_lahir');
		$data['pertemuan_ke']=$this->input->post('pertemuan_ke');
		$data['pertemuan_dari']=$this->input->post('pertemuan_dari');
		
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
		
        $this->crud->use_table('m_kegiatan');
		$order_bys = array( "nama_kegiatan"=>"asc");
		$kegiatan_data = array();
		$kegiatan_data[0] = '';
		foreach ($this->crud->retrieve('','*',0,0,$order_bys)->result() as $row) {
			$kegiatan_data[$row->id] = $row->nama_kegiatan;
		}
        $data['kegiatan_options'] = $kegiatan_data;
		$minggu_ke_options = array();
		$minggu_ke_options[0] = '';
		for ($i = 1; $i <= 5; $i++) {
			$minggu_ke_options[$i] = $this->ConvertRomawi($i);
		}
		$data['minggu_ke_options'] = $minggu_ke_options;
		
        $data['opt_angkatan_url'] = base_url() . 'transaction/select_data_form/getOptAngkatan';
		$data['opt_program_studi_url'] = base_url() . 'transaction/select_data_form/getOptProgramStudi';
        $data['opt_mata_kuliah_url'] =  base_url() . 'transaction/select_data_form/getOptMataKuliah';
        
        $this->crud->use_table('m_dosen');
        $data['nama_dosen_options'] = $this->crud->retrieve()->result();
        
        $this->crud->use_table('m_data_ruang');
        $data['ruang_pelajaran_options'] = $this->crud->retrieve()->result();
		
		$this->crud->use_table('m_jam_pelajaran');
        $data['jam_pelajaran_options'] = $this->crud->retrieve()->result();
		
		
		
		$data_program_studi = array();
		$angkatan_ids=$plot_semester_data->angkatan_id;
		$data['tgl_lahir']=$plot_semester_data->tanggal;
		//echo $angkatan_ids; return;
		$query = $this->db->query("select a.id, a.nama_program_studi, a.kode_program_studi from akademik_m_program_studi a where a.active ='1' and a.angkatan_id='$angkatan_ids';");
        foreach($query->result_array() as $row){
            if($plot_semester_data->program_studi_id==$row['id']) {
				$data_program_studi[$row['id']] = '<option selected value=\''.$row['id'].'\' >'.$row['kode_program_studi'].'-'.$row['nama_program_studi'].'</option>';
			} else {
				$data_program_studi[$row['id']] = '<option value=\''.$row['id'].'\' >'.$row['kode_program_studi'].'-'.$row['nama_program_studi'].'</option>';
			}
        }
		$data['data_program_studi']=$data_program_studi;
		$data['program_studi_ids']=$plot_semester_data->program_studi_id;
		
		$data_mata_kuliah = array();
        $query = $this->db->query("select a.id, a.kode_mata_kuliah, a.nama_mata_kuliah from akademik_m_mata_kuliah a where a.angkatan_id =$angkatan_ids and program_studi_id= $plot_semester_data->program_studi_id");
        foreach($query->result_array() as $row){
			if($plot_semester_data->mata_kuliah_id==$row['id']) {
				$data_mata_kuliah[$row['id']]= '<option selected value=\''.$row['id'].'\' >'.$row['kode_mata_kuliah'].'-'.$row['nama_mata_kuliah'].'</option>';
			} else {
				$data_mata_kuliah[$row['id']]= '<option value=\''.$row['id'].'\' >'.$row['kode_mata_kuliah'].'-'.$row['nama_mata_kuliah'].'</option>';
			}
        }
		$data['data_mata_kuliah']=$data_mata_kuliah;
		//print_r($data_program_studi); return;
		
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
