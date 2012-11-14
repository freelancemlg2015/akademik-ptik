<?php

/*
 * Fachrul Rozi
 * transaction Kurikulum : Jadwal Kuliah
 * 8/9/2012
 */

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Jadwal_kuliah_induk extends CI_Controller {

	function __construct() {
        parent::__construct();
        $this->load->helper(array('snippets_helper'));
        $this->load->model('crud_model', 'crud');
    }

    function log_date() {
        return date($this->config->item('log_date_format'));
    }

    function index($query_id = 0, $sort_by = 'id', $sort_order = 'desc', $offset = 0) {
        $this->jadwal_kuliah_induk($query_id, $sort_by, $sort_order, $offset);
    }

    function jadwal_kuliah_induk($query_id = 0, $sort_by = 'id', $sort_order = 'desc', $offset = 0) {
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

        $this->load->model('jadwal_kuliah_induk_model', 'jadwal_kuliah_induk');
        $results = $this->jadwal_kuliah_induk->search($query_array, $limit, $offset, $sort_by, $sort_order);
        //echo get_instance()->db->last_query();
        $data['results'] = $results['results'];
        $data['num_results'] = $results['num_rows'];

        // pagination
        $config = array();
        $config['base_url'] = site_url("transaction/jadwal_kuliah_induk/$query_id/$sort_by/$sort_order");
        $config['total_rows'] = $data['num_results'];
        $config['per_page'] = $limit;
        $config['uri_segment'] = 6;
        $config['num_links'] = 6;

        $config = array_merge($config, default_pagination_btn());
        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();
        $data['sort_by'] = $sort_by;
        $data['sort_order'] = $sort_order;

        $data['page_title'] = 'Jadwal Kuliah Induk';

        $data['tools'] = array(
            'transaction/jadwal_kuliah_induk/create' => 'New'
        );

        $this->load->view('transaction/jadwal_kuliah_induk', $data);
    }

    function search() {
        $query_array = array(
            'nama_dosen' => $this->input->post('nama_dosen'),
            'nama_ruang' => $this->input->post('nama_ruang'),
            'active' => 1
        );
        $query_id = $this->input->save_query($query_array);
        redirect("transaction/jadwal_kuliah_induk/view/$query_id");
    }

    function info() {
        $id = $this->uri->segment(3);
        $data['auth'] = $this->auth;
        $criteria = array(
            't_jadwal_kuliah_induk.id' => $id
        );
        $this->load->model('jadwal_kuliah_induk_model', 'jadwal_kuliah_induk');
        $result = $this->jadwal_kuliah_induk->get_many('', $criteria)->row_array();
        //echo get_instance()->db->last_query();
        $result_keys = array_keys($result);
        foreach ($result_keys as $result_key) {
            $data[$result_key] = $result[$result_key];
        }

        $data['tools'] = array(
            'transaction/jadwal_kuliah_induk' => 'Back',
            'transaction/jadwal_kuliah_induk/' . $id . '/edit' => 'Edit',
            'transaction/jadwal_kuliah_induk/' . $id . '/delete' => 'Delete'
        );
        $data['page_title'] = 'Detail Jadwal Kuliah Induk';
        $this->load->view('transaction/jadwal_kuliah_induk_info', $data);
    }
	function infos() {
        $id = $this->uri->segment(4);
        $data['auth'] = $this->auth;
        $criteria = array(
            't_jadwal_kuliah_induk.id' => $id
        );
		//echo 'masuk infos:::'.$id; return;
        $this->load->model('jadwal_kuliah_induk_model', 'jadwal_kuliah_induk');
        $result = $this->jadwal_kuliah_induk->get_many('', $criteria)->row_array();
		//print_r($result);
        //[debug]echo get_instance()->db->last_query();
        $result_keys = array_keys($result);
        foreach ($result_keys as $result_key) {
            $data[$result_key] = $result[$result_key];
        }
        $data['tools'] = array(
            'transaction/jadwal_kuliah_induk' => 'Back',
            'transaction/jadwal_kuliah_induk/' . $id . '/edit' => 'Edit',
            'transaction/jadwal_kuliah_induk/' . $id . '/delete' => 'Delete'
        );
        $data['page_title'] = 'Detail Jadwal Kuliah Induk';
        //$this->load->view('transaction/jadwal_kuliah_info', $data);
		$this->load->view('transaction/jadwal_kuliah_induk_info', $data);
    }

    function delete() {
        $id = $this->uri->segment(3);
        $this->crud->use_table('t_jadwal_kuliah_induk');
        $criteria = array('id' => $id);
        $data_in = array(
            'active' => 0,
            'modified_on' => logged_info()->on,
            'modified_by' => logged_info()->by
        );
        $this->crud->update($criteria, $data_in);
        redirect('transaction/jadwal_kuliah_induk');
    }
	
	function create() {
		$data['auth'] = $this->auth;
        $data['action_type'] = __FUNCTION__;
        $transaction_url = 'transaction/jadwal_kuliah_induk/';

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

		/*
		if($this->input->post('hari_id')<=0) {$is_valid=0;}
		if($this->input->post('pelaksanaan_kuliah')=='') {$is_valid=0;}
		if($this->input->post('jenis_waktu')<=0) {$is_valid=0;}
		*/
		$dosen_ajar_id = 0;
		$this->crud->use_table('t_dosen_ajar');
		$criteria = array(
			'angkatan_id' => $this->input->post('angkatan_id'),
			'semester_id' => $this->input->post('semester_id'),
			'mata_kuliah_id' => $this->input->post('mata_kuliah_id')
		);
		foreach ($this->crud->retrieve($criteria)->result() as $row) {
			$dosen_ajar_id = $row->id;
		}
		if((int)$dosen_ajar_id<=0) {$is_valid=0;}
		//echo get_instance()->db->last_query();
		//echo '$dosen_ajar_id'.$dosen_ajar_id; //return; exit;
		//echo '$is_valid'.$is_valid; return; exit;
				  
        if ($this->form_validation->run('jadwal_kuliah_induk_create') === FALSE) {
            //don't do anything
        } else {
			if($is_valid==0){
			} else {
				//$jenis_waktu_id = $this->input->post('jenis_waktu');
				$this->crud->use_table('t_jadwal_kuliah_induk');
				$data_in = array(
					'dosen_ajar_id' => $dosen_ajar_id,
					'program_studi_id'=> $this->input->post('program_studi_id'),
					'keterangan'	=> $this->input->post('keterangan'),
					'created_on'   => date($this->config->item('log_date_format')),
					'created_by'   => logged_info()->on
				);
				$created_id = $this->crud->create($data_in);
				$hari_id = $this->input->post('hari_id');
				$jenis_waktu = $this->input->post('jenis_waktu');
				$pelaksanaan_kuliah = $this->input->post('pelaksanaan_kuliah');
				$sql = 'delete from akademik_t_jadwal_kuliah_induk_detil where jadwal_kuliah_induk_id ='.$created_id;
				$query = $this->db->query($sql);
				if(is_array($hari_id)){
					$this->crud->use_table('t_jadwal_kuliah_induk_detil');
					for($i=0; $i< count($hari_id); $i++){
						if($hari_id[$i]>0) {
							$data_in = array(
								'jadwal_kuliah_induk_id' => $created_id,
								'hari_id'	=> $hari_id[$i],
								'jenis_waktu'	=>  $jenis_waktu[$i],
								'pelaksanaan_kuliah'	=>  $pelaksanaan_kuliah[$i],
								'created_on'   => date($this->config->item('log_date_format')),
								'created_by'   => logged_info()->on
							);
							$created_id_dtl = $this->crud->create($data_in);
						}
					}
				}
			   /*      
				  echo '<pre>';
				  var_dump($data_in);
				  echo '</pre>';
				  return; exit;
				*/
				
				redirect('transaction/jadwal_kuliah_induk/' . $created_id . '/info');
				//redirect('transaction/jadwal_kuliah_induk/');
			}
        }
		
		$data['angkatan_id']=$this->input->post('angkatan_id');
		$data['program_studi']=$this->input->post('program_studi_id');
		$data['semester_id']=$this->input->post('semester_id');
		$data['keterangan']=$this->input->post('keterangan');
		
		$data['hari_id']=$this->input->post('hari_id');
		$data['pelaksanaan_kuliah']=$this->input->post('pelaksanaan_kuliah');
		$data['jenis_waktu']=$this->input->post('jenis_waktu');		
		
        $data['action_url'] = $transaction_url . __FUNCTION__;
        $data['page_title'] = 'Create Jadwal Kuliah Induk';
        $data['tools'] = array('transaction/jadwal_kuliah_induk' => 'Back');
		$data['tahun_akademik_id_attr'] = '';
		$angkatan_ids=$this->input->post('angkatan_id');
		
		if($angkatan_ids>0)
		{
			$data_program_studi=array();
			$query = $this->db->query("select a.id, a.nama_program_studi, a.kode_program_studi from akademik_m_program_studi a where a.active ='1' and a.angkatan_id='$angkatan_ids';");
			foreach($query->result_array() as $row){
				if($angkatan_ids==$row['id']) {
					$data_program_studi[$row['id']] = '<option selected value=\''.$row['id'].'\' >'.$row['kode_program_studi'].'-'.$row['nama_program_studi'].'</option>';
				} else {
					$data_program_studi[$row['id']] = '<option value=\''.$row['id'].'\' >'.$row['kode_program_studi'].'-'.$row['nama_program_studi'].'</option>';
				}
			}
			$data['data_program_studi']=$data_program_studi;
			//$data['program_studi_ids']=$jadwal_kuliah_induk_data->program_studi_id;
		} else {
			$data['data_program_studi']=array();
		}
		$mata_kuliahs=$this->input->post('mata_kuliah_id');
		if($mata_kuliahs>0)
		{
			$data_mata_kuliah = array();
			$query = $this->db->query("select a.id, a.kode_mata_kuliah, a.nama_mata_kuliah from akademik_m_mata_kuliah a where a.angkatan_id =$angkatan_ids and program_studi_id= ".$data['program_studi']);
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
        
        $this->crud->use_table('m_hari');
        $data['hari_options'] = $this->crud->retrieve()->result();
		
		$this->crud->use_table('m_jam_pelajaran');
        $data['jam_pelajaran_options'] = $this->crud->retrieve()->result();
		$data['data_jadwal_induk_options_edit'] = '';
        
        $this->load->model('jadwal_kuliah_induk_model', 'jadwal_kuliah_induk');
        $data = array_merge($data, $this->jadwal_kuliah_induk->set_default()); //merge dengan arr data dengan default
		//$data['action_url'] = $transaction_url . $id . '/' . __FUNCTION__;
		$data['action_url'] = $transaction_url . '/' . __FUNCTION__;
        $this->load->view('transaction/jadwal_kuliah_induk_form', $data);
    }

    function edit() {
        $data['auth'] = $this->auth;
        $data['action_type'] = __FUNCTION__;
        $transaction_url = 'transaction/jadwal_kuliah_induk/';
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

		/*
		if($this->input->post('hari_id')<=0) {$is_valid=0;}
		if($this->input->post('pelaksanaan_kuliah')=='') {$is_valid=0;}
		if($this->input->post('jenis_waktu')<=0) {$is_valid=0;}
		*/
		$dosen_ajar_id = 0;
		$this->crud->use_table('t_dosen_ajar');
		$criteria = array(
			'angkatan_id' => $this->input->post('angkatan_id'),
			'semester_id' => $this->input->post('semester_id'),
			'mata_kuliah_id' => $this->input->post('mata_kuliah_id')
		);
		foreach ($this->crud->retrieve($criteria)->result() as $row) {
			$dosen_ajar_id = $row->id;
		}
		//echo 'dosen_ajar_id:::'.$dosen_ajar_id;
		if((int)$dosen_ajar_id<=0) {$is_valid=0;}
		
        if ($this->form_validation->run('jadwal_kuliah_induk_update') === FALSE) {
            //don't do anything
        } else {
			if($is_valid==0){
			} else {
				$this->crud->use_table('t_jadwal_kuliah_induk');
				$criteria = array(
					'id' => $id
				);
				$data_in = array(
					'dosen_ajar_id' => $dosen_ajar_id,
					'program_studi_id'=> $this->input->post('program_studi_id'),
					'keterangan'	=> $this->input->post('keterangan'),
					'modified_on'   => date($this->config->item('log_date_format')),
					'modified_by'   => logged_info()->on
				);
				$this->crud->update($criteria, $data_in);
				$hari_id = $this->input->post('hari_id');
				$jenis_waktu = $this->input->post('jenis_waktu');
				$pelaksanaan_kuliah = $this->input->post('pelaksanaan_kuliah');
				$sql = 'delete from akademik_t_jadwal_kuliah_induk_detil where jadwal_kuliah_induk_id ='.$id;
				$query = $this->db->query($sql);
				if(is_array($hari_id)){
					$this->crud->use_table('t_jadwal_kuliah_induk_detil');
					for($i=0; $i< count($hari_id); $i++){
						if($hari_id[$i]>0) {
							$data_in = array(
								'jadwal_kuliah_induk_id' => $id,
								'hari_id'	=> $hari_id[$i],
								'jenis_waktu'	=>  $jenis_waktu[$i],
								'pelaksanaan_kuliah'	=>  $pelaksanaan_kuliah[$i],
								'created_on'   => date($this->config->item('log_date_format')),
								'created_by'   => logged_info()->on
							);
							$created_id_dtl = $this->crud->create($data_in);
						}
					}
				}
				/*       
				  echo '<pre>';
				  var_dump($data_in);
				  echo '</pre>';
				  return;
				 */
				
				redirect('transaction/jadwal_kuliah_induk/' . $id . '/info');
			}
        }
		
		$data['hari_id']=$this->input->post('hari_id');
		$data['pelaksanaan_kuliah']=$this->input->post('pelaksanaan_kuliah');
		$data['jenis_waktu']=$this->input->post('jenis_waktu');
		
		$this->crud->use_table('t_jadwal_kuliah_induk');
		//echo $id; return;
        $jadwal_kuliah_induk_data = $this->crud->retrieve(array('id' => $id))->row();
		//print_r($jadwal_kuliah_induk_data); return;
		
        $data['action_url'] = $transaction_url . __FUNCTION__;
        $data['page_title'] = 'Update Jadwal Kuliah Induk';
        $data['tools'] = array('transaction/jadwal_kuliah_induk' => 'Back');
		
		//$this->crud->use_table('t_jadwal_kuliah_induk');
		//$id_row = $this->crud->retrieve(array('id' => $id))->row();
		$sql = 'select angkatan_id, semester_id, tahun_akademik_id, mata_kuliah_id from akademik_t_dosen_ajar where id='.$jadwal_kuliah_induk_data->dosen_ajar_id;
		$query = $this->db->query($sql);
		foreach($query->result_array() as $row){
            $jadwal_kuliah_induk_data_angkatan_id = $row['angkatan_id'];
			$jadwal_kuliah_induk_data_semester_id = $row['semester_id'];
			$jadwal_kuliah_induk_data_mata_kuliah_id = $row['mata_kuliah_id'];
        }
		$angkatan_ids=$jadwal_kuliah_induk_data_angkatan_id;
		
		$data['angkatan_id']=$jadwal_kuliah_induk_data_angkatan_id;
		$data['semester_id']=$jadwal_kuliah_induk_data_semester_id;
		$data['program_studi']=$jadwal_kuliah_induk_data->program_studi_id;
		$data['mata_kuliah_id']=$jadwal_kuliah_induk_data_mata_kuliah_id;
		//echo  '<pre>'.$this->db->last_query().'</pre><br>'; return;
		//echo  '<pre>'.$angkatan_ids.'</pre><br>'; return;
		
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
				"where a.active ='1' and b.id=".$jadwal_kuliah_induk_data_angkatan_id;
        $query = $this->db->query($sql);
		//echo $sql; return;
		//echo  '<pre>'.$this->db->last_query().'</pre><br>'; return;
        foreach($query->result_array() as $row){
            $tahun_akademik_datas = $row['tahun_ajar_mulai'].'-'.$row['tahun_ajar_akhir'];
        }
		$data['tahun_akademik_id_attr'] = $tahun_akademik_datas;
		
		
		$this->crud->use_table('m_semester');
		$semester_data = array();
		foreach ($this->crud->retrieve()->result() as $row) {
			$semester_data[$row->id] = $row->nama_semester;
		}
        $data['semester_options'] = $semester_data;
		
        $data['opt_angkatan_url'] = base_url() . 'transaction/select_data_form/getOptAngkatan';
		$data['opt_program_studi_url'] = base_url() . 'transaction/select_data_form/getOptProgramStudi';
        $data['opt_mata_kuliah_url'] =  base_url() . 'transaction/select_data_form/getOptMataKuliah';
        		
		$this->crud->use_table('m_hari');
        $data['hari_options'] = $this->crud->retrieve()->result();
		
		$this->crud->use_table('m_jam_pelajaran');
        $data['jam_pelajaran_options'] = $this->crud->retrieve()->result();
		$data_program_studi = array();
		
		$query = $this->db->query("select a.id, a.nama_program_studi, a.kode_program_studi from akademik_m_program_studi a where a.active ='1' and a.angkatan_id='$jadwal_kuliah_induk_data_angkatan_id';");
        foreach($query->result_array() as $row){
            if($jadwal_kuliah_induk_data->program_studi_id==$row['id']) {
				$data_program_studi[$row['id']] = '<option selected value=\''.$row['id'].'\' >'.$row['kode_program_studi'].'-'.$row['nama_program_studi'].'</option>';
			} else {
				$data_program_studi[$row['id']] = '<option value=\''.$row['id'].'\' >'.$row['kode_program_studi'].'-'.$row['nama_program_studi'].'</option>';
			}
        }
		//echo  '<pre>'.$this->db->last_query().'</pre><br>'; return;
		$data['data_program_studi']=$data_program_studi;
		$data['program_studi_ids']=$jadwal_kuliah_induk_data->program_studi_id;
		$data['keterangan_options']=$jadwal_kuliah_induk_data->keterangan;
		
		$this->crud->use_table('t_jadwal_kuliah_induk_detil');
		$criteria = array(
			'jadwal_kuliah_induk_id' => $id
		);
		$order_arr = array(
			'id' => 'asc'
		);
		//public function retrieve($criteria = '', $fields = '*', $limit = 0, $offset = 0, $order = '') {
        $data['data_jadwal_induk_options_edit'] = $this->crud->retrieve($criteria,'*',0,0,$order_arr)->result();
		//print_r($data['data_jadwal_induk_options_edit']);
		
		$data_mata_kuliah = array();
		$sql = "select d.id, d.kode_mata_kuliah, d.nama_mata_kuliah
				from akademik_t_rencana_mata_pelajaran_pokok a
				left join akademik_m_mata_kuliah d on a.mata_kuliah_id = d.id
				where a.angkatan_id = $angkatan_ids and a.program_studi_id=$jadwal_kuliah_induk_data->program_studi_id
					and a.semester_id = $jadwal_kuliah_induk_data_semester_id
					group by d.id";
        $query = $this->db->query($sql);
		//$query = $this->db->query("select a.id, a.kode_mata_kuliah, a.nama_mata_kuliah from akademik_m_mata_kuliah a where a.angkatan_id =$angkatan_ids and program_studi_id= $jadwal_kuliah_induk_data->program_studi_id");
		//echo  '<pre>'.$this->db->last_query().'</pre><br>'; return;
        foreach($query->result_array() as $row){
			if($jadwal_kuliah_induk_data_mata_kuliah_id==$row['id']) {
				$data_mata_kuliah[$row['id']]= '<option selected value=\''.$row['id'].'\' >'.$row['kode_mata_kuliah'].'-'.$row['nama_mata_kuliah'].'</option>';
			} else {
				$data_mata_kuliah[$row['id']]= '<option value=\''.$row['id'].'\' >'.$row['kode_mata_kuliah'].'-'.$row['nama_mata_kuliah'].'</option>';
			}
        }
		$data['data_mata_kuliah']=$data_mata_kuliah;
		
		//$data['data_jadwal_induk_options_edit'] = array(1);//$this->jadwal_ujian->get_dosen_ujian(1);
		//print_r($data['data_jadwal_induk_options_edit']); return;
		
        $this->load->model('jadwal_kuliah_induk_model', 'jadwal_kuliah_induk');
        $data = array_merge($data, $this->jadwal_kuliah_induk->set_default()); //merge dengan arr data dengan default
        $data = array_merge($data, (array) $jadwal_kuliah_induk_data);
		$data['action_url'] = $transaction_url . $id . '/' . __FUNCTION__;
		//print_r($jadwal_kuliah_induk_data);
        $this->load->view('transaction/jadwal_kuliah_induk_form', $data);
		//echo '<pre>'. $data['action_url'].'</pre>';
    }
}

?>
