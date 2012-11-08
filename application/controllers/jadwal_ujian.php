<?php

/*
 * Fachrul Rozi
 * transaction Kurikulum : Jadwal Ujian
 * 8/9/2012
 */

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Jadwal_ujian extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->helper(array('snippets_helper'));
        $this->load->model('crud_model', 'crud');
    }

    function log_date() {
        return date($this->config->item('log_date_format'));
    }

    function index($query_id = 0, $sort_by = 'id', $sort_order = 'desc', $offset = 0) {
        $this->jadwal_ujian($query_id, $sort_by, $sort_order, $offset);
    }

    function jadwal_ujian($query_id = 0, $sort_by = 'id', $sort_order = 'desc', $offset = 0) {
        $data_type = $this->input->post('data_type');
        $data['auth'] = $this->auth;
        // pagination
        $limit = 20;
        $this->load->library(array('form_validation', 'table', 'pagination'));
        $this->input->load_query($query_id);
        $query_array = array(
            'nama_dosen' => $this->input->get('nama_dosen'),
            'nama_ruang' => $this->input->get('nama_ruang'),
            'active' => 1
        );
        $this->load->model('jadwal_ujian_model', 'jadwal_ujian');
        $results = $this->jadwal_ujian->search($query_array, $limit, $offset, $sort_by, $sort_order);
        //echo get_instance()->db->last_query();
        $data['results'] = $results['results'];
        $data['num_results'] = $results['num_rows'];

        // pagination
        $config = array();
        $config['base_url'] = site_url("transaction/jadwal_ujian/$query_id/$sort_by/$sort_order");
        $config['total_rows'] = $data['num_results'];
        $config['per_page'] = $limit;
        $config['uri_segment'] = 6;
        $config['num_links'] = 6;

        $config = array_merge($config, default_pagination_btn());
        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();
        $data['sort_by'] = $sort_by;
        $data['sort_order'] = $sort_order;

        $data['page_title'] = 'Jadwal Ujian';

        $data['tools'] = array(
            'transaction/jadwal_ujian/create' => 'New'
        );

        $this->load->view('transaction/jadwal_ujian', $data);
    }

    function search() {
        $query_array = array(
            'nama_dosen' => $this->input->post('nama_dosen'),
            'nama_ruang' => $this->input->post('nama_ruang'),
            'active' => 1
        );
        $query_id = $this->input->save_query($query_array);
        redirect("transaction/jadwal_ujian/view/$query_id");
    }

    function info() {
        $id = $this->uri->segment(3);
        $data['auth'] = $this->auth;
        $criteria = array(
            't_jadwal_ujian.id' => $id
        );
        $this->load->model('jadwal_ujian_model', 'jadwal_ujian');
        $result = $this->jadwal_ujian->get_many('', $criteria)->row_array();
        //[debug]echo get_instance()->db->last_query();
        $result_keys = array_keys($result);
        foreach ($result_keys as $result_key) {
            $data[$result_key] = $result[$result_key];
        }

        $data['tools'] = array(
            'transaction/jadwal_ujian' => 'Back',
            'transaction/jadwal_ujian/' . $id . '/edit' => 'Edit',
            'transaction/jadwal_ujian/' . $id . '/delete' => 'Delete'
        );
        $data['page_title'] = 'Detail Jadwal Ujian';
        $this->load->view('transaction/jadwal_ujian_info', $data);
    }

    function delete() {
        $id = $this->uri->segment(3);
        $this->crud->use_table('t_jadwal_ujian');
        $criteria = array('id' => $id);
        $data_in = array(
            'active' => 0,
            'modified_on' => logged_info()->on,
            'modified_by' => logged_info()->by
        );
        $this->crud->update($criteria, $data_in);
		
		$this->crud->use_table('akademik_t_jadwal_ujian_pengawas_dosen_detil');
        $criteria = array('jadwal_ujian_id' => $id);
        $this->crud->update($criteria, $data_in);
		$this->crud->use_table('akademik_t_jadwal_ujian_pengawas_pegawai_detil');
        $criteria = array('jadwal_ujian_id' => $id);
        $this->crud->update($criteria, $data_in);
        redirect('transaction/jadwal_ujian');
    }
	
	function create() {
        $data['auth'] = $this->auth;
        $data['action_type'] = __FUNCTION__;
        $transaction_url = 'transaction/jadwal_ujian/';

        $this->load->library(array('form_validation', 'table'));
        $this->load->helper(array('form', 'snippets'));
        $this->form_validation->set_error_delimiters('<span class="notice">', '</span>');
		
		//$dosen_ajar_id = $this->input->post('dosen_ajar_id');
		//echo 'dosen_ajar_id:'.$dosen_ajar_id;
		$is_valid=1;
		if($this->input->post('angkatan_id')<=0) {$is_valid=0;}
		if($this->input->post('program_studi_id')<=0) {$is_valid=0;}
		
		if($this->input->post('semester_id')<=0) {$is_valid=0;}
		if($this->input->post('mata_kuliah_id')<=0) {$is_valid=0;}
		//if($this->input->post('tahun_akademik_id')<=0) {$is_valid=0;}
		if($this->input->post('tgl_lahir')=='') {$is_valid=0;}
		
		if($this->input->post('nama_ruang_id')<=0) {$is_valid=0;}
		if($this->input->post('jenis_ujian_id')<=0) {$is_valid=0;}
		
		if($this->input->post('jam_normal_mulai')=='') {$is_valid=0;}
		if($this->input->post('jam_normal_akhir')=='') {$is_valid=0;}
		
		$mata_kuliah_id=(int)$this->input->post('mata_kuliah_id');
		if($mata_kuliah_id==0) {$is_valid=0;}
		$jenis_ujian_id=$this->input->post('jenis_ujian_id');
        if ($this->form_validation->run('jadwal_ujian_create') === FALSE) {
            //don't do anything
        } else {
			if($is_valid==0){
			} else {
				$hari_ids = $this->input->post('tgl_lahir');
				$hari_id = date("w",strtotime($hari_ids."w"));
				$this->crud->use_table('t_jadwal_ujian');
				$data_in = array(
					'program_studi_id'=> $this->input->post('program_studi_id'),
					'semester_id'	=> $this->input->post('semester_id'),
					'angkatan_id'	=> $this->input->post('angkatan_id'),
					'mata_kuliah_id'=> $mata_kuliah_id,
					'jenis_ujian_id'=> $this->input->post('jenis_ujian_id'),
					'tanggal'		=> $this->input->post('tgl_lahir'),
					'waktu_mulai' 	=> $this->input->post('jam_normal_mulai'),
					'waktu_selesai' => $this->input->post('jam_normal_akhir'),
					'nama_ruang_id'	=> $this->input->post('nama_ruang_id'),
					'hari_id'      	=> $hari_id,
					'created_on'   => date($this->config->item('log_date_format')),
					'created_by'   => logged_info()->on
				);
				$created_id = $this->crud->create($data_in);
				$id = $created_id;
				
				$dosen = $this->input->post('dosen_id');
				$pegawai = $this->input->post('pegawai_id');
				/*
				$sql = 'delete from akademik_t_jadwal_ujian_pengawas_dosen_detil where jadwal_ujian_id ='.$id;
				$query = $this->db->query($sql);
				$sql = 'delete from akademik_t_jadwal_ujian_pengawas_pegawai_detil where jadwal_ujian_id ='.$id;
				$query = $this->db->query($sql);
				*/
				if(is_array($dosen)){
					$this->crud->use_table('akademik_t_jadwal_ujian_pengawas_dosen_detil');
					for($i=0; $i< count($dosen); $i++){
						if($dosen[$i]>0) {
							$data_in = array(
								'jadwal_ujian_id' => $id,
								'dosen_id'      => $dosen[$i],
								'created_on'   => date($this->config->item('log_date_format')),
								'created_by'   => logged_info()->on,
								'active'        => 1   
							);
							$this->crud->create($data_in);
						}
					}
				}
				if(is_array($pegawai)){
					$this->crud->use_table('akademik_t_jadwal_ujian_pengawas_pegawai_detil');
					for($i=0; $i< count($pegawai); $i++){
						if($pegawai[$i]>0) {
							$data_in = array(
								'jadwal_ujian_id' => $id,
								'pegawai_id'      => $pegawai[$i],
								'created_on'   => date($this->config->item('log_date_format')),
								'created_by'   => logged_info()->on,
								'active'        => 1   
							);
							$this->crud->create($data_in);
						}
					}
				}
			   /*       
				  echo '<pre>';
				  var_dump($data_in);
				  echo '</pre>';
				  return;
				 */
				
				redirect('transaction/jadwal_ujian/' . $created_id . '/info');
			}
        }
		$data['tgl_lahir']=$this->input->post('tgl_lahir');
		$data['angkatan_id']=$this->input->post('angkatan_id');
		$data['program_studi']=(int)$this->input->post('program_studi_id');
		$data['jenis_ujian_id']=$this->input->post('jenis_ujian_id');
		//$data['tahun_akademik_id']=$this->input->post('tahun_akademik_id');
		$data['jam_normal_mulai']=$this->input->post('jam_normal_mulai');
		$data['jam_normal_akhir']=$this->input->post('jam_normal_akhir');
		$data['semester_id']=$this->input->post('semester_id');
        $data['action_url'] = $transaction_url . __FUNCTION__;
        $data['page_title'] = 'Create Jadwal Ujian';
        $data['tools'] = array('transaction/jadwal_ujian' => 'Back');
		$data['tahun_akademik_id_attr'] = '';
		$angkatan_ids=$this->input->post('angkatan_id');
		$program_studi_ids=$this->input->post('program_studi_id');
		$semester_ids=$this->input->post('semester_id');
		if($angkatan_ids>0)
		{
			$data_program_studi=array();
			$query = $this->db->query("select a.id, a.nama_program_studi, a.kode_program_studi from akademik_m_program_studi a where a.active ='1' and a.angkatan_id='$angkatan_ids';");
			foreach($query->result_array() as $row){
				if($this->input->post('program_studi_id')==$row['id']) {
					$data_program_studi[$row['id']] = '<option selected value=\''.$row['id'].'\' >'.$row['kode_program_studi'].'-'.$row['nama_program_studi'].'</option>';
				} else {
					$data_program_studi[$row['id']] = '<option value=\''.$row['id'].'\' >'.$row['kode_program_studi'].'-'.$row['nama_program_studi'].'</option>';
				}
			}
			$data['data_program_studi']=$data_program_studi;
			//$data['program_studi_ids']=$jadwal_ujian_data->program_studi_id;
		} else {
			$data['data_program_studi']=array();
		}
		$mata_kuliahs=$this->input->post('mata_kuliah_id');
		if($mata_kuliahs>0)
		{
			$data_mata_kuliah = array();
			$sql = "select d.id, d.kode_mata_kuliah, d.nama_mata_kuliah
				from akademik_t_rencana_mata_pelajaran_pokok a
				left join akademik_m_mata_kuliah d on a.mata_kuliah_id = d.id
				where a.angkatan_id = $angkatan_ids and a.program_studi_id=$program_studi_ids
					and a.semester_id = $semester_ids
					group by d.id";
			//$query = $this->db->query("select a.id, a.kode_mata_kuliah, a.nama_mata_kuliah from akademik_m_mata_kuliah a where a.angkatan_id =$angkatan_ids and program_studi_id= ".$data['program_studi']);
			$query = $this->db->query($sql);
			foreach($query->result_array() as $row){
				if($mata_kuliahs==$row['id']) {
					$data_mata_kuliah[$row['id']]= '<option selected value=\''.$row['id'].'\' >'.$row['kode_mata_kuliah'].'-'.$row['nama_mata_kuliah'].'</option>';
				} else {
					$data_mata_kuliah[$row['id']]= '<option value=\''.$row['id'].'\' >'.$row['kode_mata_kuliah'].'-'.$row['nama_mata_kuliah'].'</option>';
				}
			}
			$data['data_mata_kuliah']=$data_mata_kuliah;
		} else {
			$data['data_mata_kuliah'] = array();
			$data['program_studi_ids']=0;
		}
		$this->crud->use_table('m_angkatan');
		$angkatan_data = array();
		$angkatan_data[0] = '';
        foreach ($this->crud->retrieve()->result() as $row) {
			$angkatan_data[$row->id] = $row->nama_angkatan;
        }
		$data['angkatan_options']=$angkatan_data;
        
        $this->crud->use_table('m_tahun_akademik');
		$tahun_akademik_data = array();
		$tahun_akademik_data[0] ='';
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
		
		$this->crud->use_table('m_jenis_ujian');
		$order_bys = array( "kode_ujian"=>"asc");
		$kegiatan_data = array();
		$kegiatan_data[0] = '';
		foreach ($this->crud->retrieve('','*',0,0,$order_bys)->result() as $row) {
			$kegiatan_data[$row->id] = $row->kode_ujian;
		}
        $data['kegiatan_options'] = $kegiatan_data;
		
        $data['opt_angkatan_url'] = base_url() . 'transaction/select_data_form/getOptAngkatan';
		$data['opt_program_studi_url'] = base_url() . 'transaction/select_data_form/getOptProgramStudi';
        $data['opt_mata_kuliah_url'] =  base_url() . 'transaction/select_data_form/getOptMataKuliah';
        
        $this->crud->use_table('m_data_ruang');
        $data['ruang_pelajaran_options'] = $this->crud->retrieve()->result();
		
		$this->crud->use_table('m_dosen');
        $data['dosen_options'] = $this->crud->retrieve()->result();
		$this->crud->use_table('m_pegawai');
        $data['pegawai_options'] = $this->crud->retrieve()->result();
		
		$data['dosen_options_edit'] = '';
		$data['pegawai_options_edit'] = '';
        
        $this->load->model('jadwal_ujian_model', 'jadwal_ujian');
        $data = array_merge($data, $this->jadwal_ujian->set_default()); //merge dengan arr data dengan default
		//$data['action_url'] = $transaction_url . $id . '/' . __FUNCTION__;
		$data['action_url'] = $transaction_url . '/' . __FUNCTION__;
        $this->load->view('transaction/jadwal_ujian_form', $data);
    }

    function edit() {
        $data['auth'] = $this->auth;
        $data['action_type'] = __FUNCTION__;
        $transaction_url = 'transaction/jadwal_ujian/';
        $id = $this->uri->segment(3);
		//echo '<pre>id:'.$id.'</pre>';

        $this->load->library(array('form_validation', 'table'));
        $this->load->helper(array('form', 'snippets'));
        $this->form_validation->set_error_delimiters('<span class="notice">', '</span>');
		$is_valid=1;
		if($this->input->post('angkatan_id')<=0) {$is_valid=0;}
		if($this->input->post('program_studi_id')<=0) {$is_valid=0;}
		
		if($this->input->post('semester_id')<=0) {$is_valid=0;}
		if($this->input->post('mata_kuliah_id')<=0) {$is_valid=0;}
		//if($this->input->post('tahun_akademik_id')<=0) {$is_valid=0;}
		if($this->input->post('tgl_lahir')=='') {$is_valid=0;}
		
		if($this->input->post('nama_ruang_id')<=0) {$is_valid=0;}
		if($this->input->post('jenis_ujian_id')<=0) {$is_valid=0;}
		
		if($this->input->post('jam_normal_mulai')=='') {$is_valid=0;}
		if($this->input->post('jam_normal_akhir')=='') {$is_valid=0;}
		
		$mata_kuliah_id=(int)$this->input->post('mata_kuliah_id');
		if($mata_kuliah_id==0) {$is_valid=0;}
		$jenis_ujian_id=$this->input->post('jenis_ujian_id');
        if ($this->form_validation->run('jadwal_ujian_create') === FALSE) {
            //don't do anything
        } else {
			if($is_valid==0){
			} else {
				//print_r($_POST); return; exit;
				$this->crud->use_table('t_jadwal_ujian');
				$criteria = array(
					'id' => $id
				);
				$hari_ids = $this->input->post('tgl_lahir');
				$hari_id = date("w",strtotime($hari_ids."w"));
				$this->crud->use_table('t_jadwal_ujian');
				$data_in = array(
					'program_studi_id'=> $this->input->post('program_studi_id'),
					'semester_id'	=> $this->input->post('semester_id'),
					'angkatan_id'	=> $this->input->post('angkatan_id'),
					'mata_kuliah_id'=> $mata_kuliah_id,
					'jenis_ujian_id'=> $this->input->post('jenis_ujian_id'),
					'tanggal'		=> $this->input->post('tgl_lahir'),
					'waktu_mulai' 	=> $this->input->post('jam_normal_mulai'),
					'waktu_selesai' => $this->input->post('jam_normal_akhir'),
					'nama_ruang_id'	=> $this->input->post('nama_ruang_id'),
					'hari_id'      	=> $hari_id,
					'modified_on'   => date($this->config->item('log_date_format')),
					'modified_by'   => logged_info()->on
				);
				$this->crud->update($criteria, $data_in);
				
				$dosen = $this->input->post('dosen_id');
				$pegawai = $this->input->post('pegawai_id');
				$sql = 'delete from akademik_t_jadwal_ujian_pengawas_dosen_detil where jadwal_ujian_id ='.$id;
				$query = $this->db->query($sql);
				$sql = 'delete from akademik_t_jadwal_ujian_pengawas_pegawai_detil where jadwal_ujian_id ='.$id;
				$query = $this->db->query($sql);
				if(is_array($dosen)){
					$this->crud->use_table('akademik_t_jadwal_ujian_pengawas_dosen_detil');
					for($i=0; $i< count($dosen); $i++){
						if($dosen[$i]>0) {
							$data_in = array(
								'jadwal_ujian_id' => $id,
								'dosen_id'      => $dosen[$i],
								'created_on'   => date($this->config->item('log_date_format')),
								'created_by'   => logged_info()->on,
								'active'        => 1   
							);
							$this->crud->create($data_in);
						}
					}
				}
				if(is_array($pegawai)){
					$this->crud->use_table('akademik_t_jadwal_ujian_pengawas_pegawai_detil');
					for($i=0; $i< count($pegawai); $i++){
						if($pegawai[$i]>0) {
							$data_in = array(
								'jadwal_ujian_id' => $id,
								'pegawai_id'      => $pegawai[$i],
								'created_on'   => date($this->config->item('log_date_format')),
								'created_by'   => logged_info()->on,
								'active'        => 1   
							);
							$this->crud->create($data_in);
						}
					}
				}
				/*       
				  echo '<pre>';
				  var_dump($data_in);
				  echo '</pre>';
				  return;
				 */
				
				redirect('transaction/jadwal_ujian/' . $id . '/info');
			}
        }
		$data['tgl_lahir']=$this->input->post('tgl_lahir');
		$data['angkatan_id']=$this->input->post('angkatan_id');
		$data['program_studi']=$this->input->post('program_studi_id');
		$data['jenis_ujian_id']=$this->input->post('jenis_ujian_id');
		//$data['tahun_akademik_id']=$this->input->post('tahun_akademik_id');
		$data['jam_normal_mulai']=$this->input->post('jam_normal_mulai');
		$data['jam_normal_akhir']=$this->input->post('jam_normal_akhir');
		$data['semester_id']=$this->input->post('semester_id');
        $data['action_url'] = $transaction_url . __FUNCTION__;
        $data['page_title'] = 'Update Jadwal Ujian';
        $data['tools'] = array('transaction/jadwal_ujian' => 'Back');
		
		$this->crud->use_table('t_jadwal_ujian');
		//echo $id; return;
        $jadwal_ujian_data = $this->crud->retrieve(array('id' => $id))->row();
		
		$this->crud->use_table('m_angkatan');
		$angkatan_data = array();
        foreach ($this->crud->retrieve()->result() as $row) {
			$angkatan_data[$row->id] = $row->nama_angkatan;
        }
		$data['angkatan_options']=$angkatan_data;
		$data['tahun_akademik_id_attr'] = ''; $data['tahun_akademik_options'] = '';
		$tahun_akademik_datas='';
		$sql = "select a.tahun_ajar_mulai, a.tahun_ajar_akhir from akademik_m_tahun_akademik a ".
				" left join akademik_m_angkatan b on b.tahun_akademik_id=a.id ".
				"where a.active ='1' and b.id=".$jadwal_ujian_data->angkatan_id;
        $query = $this->db->query($sql);
		//echo  '<pre>'.$this->db->last_query().'</pre><br>';
        foreach($query->result_array() as $row){
            $tahun_akademik_datas = $row['tahun_ajar_mulai'].'-'.$row['tahun_ajar_akhir'];
        }
		$data['tahun_akademik_id_attr'] = $tahun_akademik_datas;
        
		$this->crud->use_table('m_jenis_ujian');
		$order_bys = array( "kode_ujian"=>"asc");
		$kegiatan_data = array();
		$kegiatan_data[0] = '';
		foreach ($this->crud->retrieve('','*',0,0,$order_bys)->result() as $row) {
			$kegiatan_data[$row->id] = $row->kode_ujian;
		}
        $data['kegiatan_options'] = $kegiatan_data;
		
		$this->crud->use_table('m_semester');
		$semester_data = array();
		foreach ($this->crud->retrieve()->result() as $row) {
			$semester_data[$row->id] = $row->nama_semester;
		}
        $data['semester_options'] = $semester_data;
		
		$this->crud->use_table('m_dosen');
        $data['dosen_options'] = $this->crud->retrieve()->result();
		$this->crud->use_table('m_pegawai');
        $data['pegawai_options'] = $this->crud->retrieve()->result();
		
        $this->load->model('jadwal_ujian_model', 'jadwal_ujian');
		$data['dosen_options_edit'] = $this->jadwal_ujian->get_dosen_ujian($id);
		$data['pegawai_options_edit'] = $this->jadwal_ujian->get_pegawai_ujian($id);
		
        $data['opt_angkatan_url'] = base_url() . 'transaction/select_data_form/getOptAngkatan';
		$data['opt_program_studi_url'] = base_url() . 'transaction/select_data_form/getOptProgramStudi';
        $data['opt_mata_kuliah_url'] =  base_url() . 'transaction/select_data_form/getOptMataKuliah';
        
        //$this->crud->use_table('m_dosen');
        //$data['nama_dosen_options'] = $this->crud->retrieve()->result();
        
        $this->crud->use_table('m_data_ruang');
        $data['ruang_pelajaran_options'] = $this->crud->retrieve()->result();
		
		
		
		$data_program_studi = array();
		$angkatan_ids=$jadwal_ujian_data->angkatan_id;
		$program_studi_ids=$jadwal_ujian_data->program_studi_id;
		$semester_ids=$jadwal_ujian_data->semester_id;
		$data['tgl_lahir']=$jadwal_ujian_data->tanggal;
		//echo $angkatan_ids; return;
		$query = $this->db->query("select a.id, a.nama_program_studi, a.kode_program_studi from akademik_m_program_studi a where a.active ='1' and a.angkatan_id='$angkatan_ids';");
        foreach($query->result_array() as $row){
            if($jadwal_ujian_data->program_studi_id==$row['id']) {
				$data_program_studi[$row['id']] = '<option selected value=\''.$row['id'].'\' >'.$row['kode_program_studi'].'-'.$row['nama_program_studi'].'</option>';
			} else {
				$data_program_studi[$row['id']] = '<option value=\''.$row['id'].'\' >'.$row['kode_program_studi'].'-'.$row['nama_program_studi'].'</option>';
			}
        }
		$data['data_program_studi']=$data_program_studi;
		$data['program_studi_ids']=$jadwal_ujian_data->program_studi_id;
		
		$data_mata_kuliah = array();
		$sql = "select d.id, d.kode_mata_kuliah, d.nama_mata_kuliah
				from akademik_t_rencana_mata_pelajaran_pokok a
				left join akademik_m_mata_kuliah d on a.mata_kuliah_id = d.id
				where a.angkatan_id = $angkatan_ids and a.program_studi_id=$program_studi_ids
					and a.semester_id = $semester_ids
					group by d.id";
		//$query = $this->db->query("select a.id, a.kode_mata_kuliah, a.nama_mata_kuliah from akademik_m_mata_kuliah a where a.angkatan_id =$angkatan_ids and program_studi_id= ".$data['program_studi']);
		$query = $this->db->query($sql);
        foreach($query->result_array() as $row){
			if($jadwal_ujian_data->mata_kuliah_id==$row['id']) {
				$data_mata_kuliah[$row['id']]= '<option selected value=\''.$row['id'].'\' >'.$row['kode_mata_kuliah'].'-'.$row['nama_mata_kuliah'].'</option>';
			} else {
				$data_mata_kuliah[$row['id']]= '<option value=\''.$row['id'].'\' >'.$row['kode_mata_kuliah'].'-'.$row['nama_mata_kuliah'].'</option>';
			}
        }
		$data['data_mata_kuliah']=$data_mata_kuliah;
		//print_r($data_program_studi); return;
		
        $this->load->model('jadwal_ujian_model', 'jadwal_ujian');
        $data = array_merge($data, $this->jadwal_ujian->set_default()); //merge dengan arr data dengan default
        $data = array_merge($data, (array) $jadwal_ujian_data);
		$data['action_url'] = $transaction_url . $id . '/' . __FUNCTION__;
		//print_r($jadwal_ujian_data);
        $this->load->view('transaction/jadwal_ujian_form', $data);
		//echo '<pre>'. $data['action_url'].'</pre>';
    }
}

?>