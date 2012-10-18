<?php

/*
 * Fachrul Rozi
 * transaction Kurikulum : Jadwal Kuliah
 * 8/9/2012
 */

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Jadwal_kuliah extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->helper(array('snippets_helper'));
        $this->load->model('crud_model', 'crud');
    }

    function log_date() {
        return date($this->config->item('log_date_format'));
    }

    function index($query_id = 0, $sort_by = 'id', $sort_order = 'desc', $offset = 0) {
        $this->jadwal_kuliah($query_id, $sort_by, $sort_order, $offset);
    }

    function jadwal_kuliah($query_id = 0, $sort_by = 'id', $sort_order = 'desc', $offset = 0) {
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

        $this->load->model('jadwal_kuliah_model', 'jadwal_kuliah');
        $results = $this->jadwal_kuliah->search($query_array, $limit, $offset, $sort_by, $sort_order);
        //echo get_instance()->db->last_query();
        $data['results'] = $results['results'];
        $data['num_results'] = $results['num_rows'];

        // pagination
        $config = array();
        $config['base_url'] = site_url("transaction/jadwal_kuliah/$query_id/$sort_by/$sort_order");
        $config['total_rows'] = $data['num_results'];
        $config['per_page'] = $limit;
        $config['uri_segment'] = 6;
        $config['num_links'] = 6;

        $config = array_merge($config, default_pagination_btn());
        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();
        $data['sort_by'] = $sort_by;
        $data['sort_order'] = $sort_order;

        $data['page_title'] = 'Jadwal Kuliah';

        $data['tools'] = array(
            'transaction/jadwal_kuliah/create' => 'New'
        );

        $this->load->view('transaction/jadwal_kuliah', $data);
    }

    function search() {
        $query_array = array(
            'nama_dosen' => $this->input->post('nama_dosen'),
            'nama_ruang' => $this->input->post('nama_ruang'),
            'active' => 1
        );
        $query_id = $this->input->save_query($query_array);
        redirect("transaction/jadwal_kuliah/view/$query_id");
    }

    function info() {
        $id = $this->uri->segment(3);
        $data['auth'] = $this->auth;
        $criteria = array(
            't_jadwal_kuliah.id' => $id
        );
        $this->load->model('jadwal_kuliah_model', 'jadwal_kuliah');
        $result = $this->jadwal_kuliah->get_many('', $criteria)->row_array();
        //[debug]echo get_instance()->db->last_query();
        $result_keys = array_keys($result);
        foreach ($result_keys as $result_key) {
            $data[$result_key] = $result[$result_key];
        }

        $data['tools'] = array(
            'transaction/jadwal_kuliah' => 'Back',
            'transaction/jadwal_kuliah/' . $id . '/edit' => 'Edit',
            'transaction/jadwal_kuliah/' . $id . '/delete' => 'Delete'
        );
        $data['page_title'] = 'Detail Jadwal Kuliah';
        $this->load->view('transaction/jadwal_kuliah_info', $data);
    }

    function delete() {
        $id = $this->uri->segment(3);
        $this->crud->use_table('t_jadwal_kuliah');
        $criteria = array('id' => $id);
        $data_in = array(
            'active' => 0,
            'modified_on' => logged_info()->on,
            'modified_by' => logged_info()->by
        );
        $this->crud->update($criteria, $data_in);
        redirect('transaction/jadwal_kuliah');
    }
	
	function create() {
        $data['auth'] = $this->auth;
        $data['action_type'] = __FUNCTION__;
        $transaction_url = 'transaction/jadwal_kuliah/';

        $this->load->library(array('form_validation', 'table'));
        $this->load->helper(array('form', 'snippets'));
        $this->form_validation->set_error_delimiters('<span class="notice">', '</span>');
		
		//$dosen_ajar_id = $this->input->post('dosen_ajar_id');
		//echo 'dosen_ajar_id:'.$dosen_ajar_id;
		$is_valid=1;
		if($this->input->post('angkatan_id')<=0) {$is_valid=0;}
		if($this->input->post('program_studi')<=0) {$is_valid=0;}
		
		if($this->input->post('semester_id')<=0) {$is_valid=0;}
		//if($this->input->post('mata_kuliah')<=0) {$is_valid=0;}
		if($this->input->post('tahun_akademik_id')<=0) {$is_valid=0;}
		if($this->input->post('tgl_lahir')=='') {$is_valid=0;}
		
		if($this->input->post('nama_ruang_id')<=0) {$is_valid=0;}
		if($this->input->post('jenis_waktu')<=0) {$is_valid=0;}
		$mata_kuliah_id=(int)$this->input->post('mata_kuliah');
		$kegiatan_id=$this->input->post('kegiatan_id');
		//echo $mata_kuliah_id;
		if(($mata_kuliah_id==0) && ($kegiatan_id==0)) {$is_valid=0;}
		if($kegiatan_id>0) $mata_kuliah_id = 0;
		//if($is_valid==0){
        if ($this->form_validation->run('jadwal_kuliah_create') === FALSE) {
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
				$hari_ids = $this->input->post('tgl_lahir');
				$hari_id = date("w",strtotime($hari_ids."w"));
				$this->crud->use_table('t_jadwal_kuliah');
				$data_in = array(
					'program_studi_id'=> $this->input->post('program_studi'),
					'semester_id'	=> $this->input->post('semester_id'),
					'angkatan_id'	=> $this->input->post('angkatan_id'),
					'metode_ajar_id'=> $this->input->post('metode_ajar_id'),
					'tanggal'		=> $this->input->post('tgl_lahir'),
					'mata_kuliah_id'=> $mata_kuliah_id,
					'kegiatan_id'	=> $kegiatan_id,
					'nama_ruang_id'	=> $this->input->post('nama_ruang_id'),
					'jenis_waktu'  	=> $this->input->post('jenis_waktu'),
					'hari_id'      	=> $hari_id,
					'jam_mulai'     => $jam_mulai,
					'jam_selesai'   => $jam_selesai,
					'created_on'   => date($this->config->item('log_date_format')),
					'created_by'   => logged_info()->on
				);
			   /*       
				  echo '<pre>';
				  var_dump($data_in);
				  echo '</pre>';
				  return;
				 */
				$created_id = $this->crud->create($data_in);
				redirect('transaction/jadwal_kuliah/' . $created_id . '/info');
			}
        }
		$data['tgl_lahir']=$this->input->post('tgl_lahir');
		$data['angkatan_id']=$this->input->post('angkatan_id');
		$data['program_studi']=$this->input->post('program_studi');
		$data['kegiatan_id']=$this->input->post('kegiatan_id');
		$data['metode_ajar_id']=$this->input->post('metode_ajar_id');
		$data['tahun_akademik_id']=$this->input->post('tahun_akademik_id');
		$data['semester_id']=$this->input->post('semester_id');
        $data['action_url'] = $transaction_url . __FUNCTION__;
        $data['page_title'] = 'Create Jadwal Kuliah';
        $data['tools'] = array('transaction/jadwal_kuliah' => 'Back');
		$angkatan_ids=$this->input->post('angkatan_id');
		if($angkatan_ids>0)
		{
			$data_program_studi=array();
			$query = $this->db->query("select a.id, a.nama_program_studi, a.kode_program_studi from akademik_m_program_studi a where a.active ='1' and a.angkatan_id='$angkatan_ids';");
			foreach($query->result_array() as $row){
				if($this->input->post('program_studi')==$row['id']) {
					$data_program_studi[$row['id']] = '<option selected value=\''.$row['id'].'\' >'.$row['kode_program_studi'].'-'.$row['nama_program_studi'].'</option>';
				} else {
					$data_program_studi[$row['id']] = '<option value=\''.$row['id'].'\' >'.$row['kode_program_studi'].'-'.$row['nama_program_studi'].'</option>';
				}
			}
			$data['data_program_studi']=$data_program_studi;
			//$data['program_studi_ids']=$jadwal_kuliah_data->program_studi_id;
		} else {
			$data['data_program_studi']=array();
		}
		$mata_kuliahs=$this->input->post('mata_kuliah');
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
        foreach ($this->crud->retrieve()->result() as $row) {
			$angkatan_data[$row->id] = $row->nama_angkatan;
        }
		$data['angkatan_options']=$angkatan_data;
        
        $this->crud->use_table('m_tahun_akademik');
		$tahun_akademik_data = array();
        foreach ($this->crud->retrieve()->result() as $row) {
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
		
        $data['opt_program_studi_url'] = base_url() . 'transaction/jadwal_kuliah/getOptProgramStudi';//jadwal_kuliah
        $data['opt_mata_kuliah_url'] =  base_url() . 'transaction/jadwal_kuliah/getOptMataKuliah';//nilai_akademik
        
        $this->crud->use_table('m_dosen');
        $data['nama_dosen_options'] = $this->crud->retrieve()->result();
        
        $this->crud->use_table('m_data_ruang');
        $data['ruang_pelajaran_options'] = $this->crud->retrieve()->result();
		
		$this->crud->use_table('m_jam_pelajaran');
        $data['jam_pelajaran_options'] = $this->crud->retrieve()->result();
        
        $this->load->model('jadwal_kuliah_model', 'jadwal_kuliah');
        $data = array_merge($data, $this->jadwal_kuliah->set_default()); //merge dengan arr data dengan default
		//$data['action_url'] = $transaction_url . $id . '/' . __FUNCTION__;
		$data['action_url'] = $transaction_url . '/' . __FUNCTION__;
        $this->load->view('transaction/jadwal_kuliah_form', $data);
    }

    function edit() {
        $data['auth'] = $this->auth;
        $data['action_type'] = __FUNCTION__;
        $transaction_url = 'transaction/jadwal_kuliah/';
        $id = $this->uri->segment(3);
		//echo '<pre>id:'.$id.'</pre>';

        $this->load->library(array('form_validation', 'table'));
        $this->load->helper(array('form', 'snippets'));
        $this->form_validation->set_error_delimiters('<span class="notice">', '</span>');
		$is_valid=1;
		if($this->input->post('angkatan_id')<=0) {$is_valid=0;}
		if($this->input->post('program_studi')<=0) {$is_valid=0;}
		
		if($this->input->post('semester_id')<=0) {$is_valid=0;}
		//if($this->input->post('mata_kuliah')<=0) {$is_valid=0;}
		if($this->input->post('tahun_akademik_id')<=0) {$is_valid=0;}
		if($this->input->post('tgl_lahir')=='') {$is_valid=0;}
		
		if($this->input->post('nama_ruang_id')<=0) {$is_valid=0;}
		if($this->input->post('jenis_waktu')<=0) {$is_valid=0;}
		
		$mata_kuliah_id=(int)$this->input->post('mata_kuliah');
		$kegiatan_id=$this->input->post('kegiatan_id');
		//echo $mata_kuliah_id;
		if(($mata_kuliah_id==0) && ($kegiatan_id==0)) {$is_valid=0;}
		if($kegiatan_id>0) $mata_kuliah_id = 0;
		//if($is_valid==0){
        if ($this->form_validation->run('jadwal_kuliah_create') === FALSE) {
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
				
				$this->crud->use_table('t_jadwal_kuliah');
				$criteria = array(
					'id' => $id
				);
				if($kegiatan_id>0) $mata_kuliah_id = 0;
				$hari_ids = $this->input->post('tgl_lahir');
				$hari_id = date("w",strtotime($hari_ids."w"));
				
				$data['angkatan_options']=$angkatan_data;
				$this->crud->use_table('t_jadwal_kuliah');
				$data_in = array(
					'program_studi_id'=> $this->input->post('program_studi'),
					'semester_id'	=> $this->input->post('semester_id'),
					'angkatan_id'	=> $this->input->post('angkatan_id'),
					'metode_ajar_id'=> $this->input->post('metode_ajar_id'),
					'tanggal'		=> $this->input->post('tgl_lahir'),
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
				redirect('transaction/jadwal_kuliah/' . $id . '/info');
			}
        }
		$data['tgl_lahir']=$this->input->post('tgl_lahir');
		$data['angkatan_id']=$this->input->post('angkatan_id');
		$data['program_studi']=$this->input->post('program_studi');
		$data['kegiatan_id']=$this->input->post('kegiatan_id');
		$data['metode_ajar_id']=$this->input->post('metode_ajar_id');
		$data['tahun_akademik_id']=$this->input->post('tahun_akademik_id');
		$data['semester_id']=$this->input->post('semester_id');
		
        $data['action_url'] = $transaction_url . __FUNCTION__;
        $data['page_title'] = 'Update Jadwal Kuliah';
        $data['tools'] = array('transaction/jadwal_kuliah' => 'Back');
		
		$this->crud->use_table('m_angkatan');
		$angkatan_data = array();
        foreach ($this->crud->retrieve()->result() as $row) {
			$angkatan_data[$row->id] = $row->nama_angkatan;
        }
		$data['angkatan_options']=$angkatan_data;
        
        $this->crud->use_table('m_tahun_akademik');
		$tahun_akademik_data = array();
        foreach ($this->crud->retrieve()->result() as $row) {
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
		
        $data['opt_program_studi_url'] 	=  base_url() . 'transaction/jadwal_kuliah/getOptProgramStudi';//jadwal_kuliah
        $data['opt_mata_kuliah_url'] 	=  base_url() . 'transaction/jadwal_kuliah/getOptMataKuliah';//nilai_akademik
        
        $this->crud->use_table('m_dosen');
        $data['nama_dosen_options'] = $this->crud->retrieve()->result();
        
        $this->crud->use_table('m_data_ruang');
        $data['ruang_pelajaran_options'] = $this->crud->retrieve()->result();
		
		$this->crud->use_table('m_jam_pelajaran');
        $data['jam_pelajaran_options'] = $this->crud->retrieve()->result();
		
		$this->crud->use_table('t_jadwal_kuliah');
		//echo $id; return;
        $jadwal_kuliah_data = $this->crud->retrieve(array('id' => $id))->row();
		
		$data_program_studi = array();
		$angkatan_ids=$jadwal_kuliah_data->angkatan_id;
		$data['tgl_lahir']=$jadwal_kuliah_data->tanggal;
		//echo $angkatan_ids; return;
		$query = $this->db->query("select a.id, a.nama_program_studi, a.kode_program_studi from akademik_m_program_studi a where a.active ='1' and a.angkatan_id='$angkatan_ids';");
        foreach($query->result_array() as $row){
            if($jadwal_kuliah_data->program_studi_id==$row['id']) {
				$data_program_studi[$row['id']] = '<option selected value=\''.$row['id'].'\' >'.$row['kode_program_studi'].'-'.$row['nama_program_studi'].'</option>';
			} else {
				$data_program_studi[$row['id']] = '<option value=\''.$row['id'].'\' >'.$row['kode_program_studi'].'-'.$row['nama_program_studi'].'</option>';
			}
        }
		$data['data_program_studi']=$data_program_studi;
		$data['program_studi_ids']=$jadwal_kuliah_data->program_studi_id;
		
		$data_mata_kuliah = array();
        $query = $this->db->query("select a.id, a.kode_mata_kuliah, a.nama_mata_kuliah from akademik_m_mata_kuliah a where a.angkatan_id =$angkatan_ids and program_studi_id= $jadwal_kuliah_data->program_studi_id");
        foreach($query->result_array() as $row){
			if($jadwal_kuliah_data->mata_kuliah_id==$row['id']) {
				$data_mata_kuliah[$row['id']]= '<option selected value=\''.$row['id'].'\' >'.$row['kode_mata_kuliah'].'-'.$row['nama_mata_kuliah'].'</option>';
			} else {
				$data_mata_kuliah[$row['id']]= '<option value=\''.$row['id'].'\' >'.$row['kode_mata_kuliah'].'-'.$row['nama_mata_kuliah'].'</option>';
			}
        }
		$data['data_mata_kuliah']=$data_mata_kuliah;
		//print_r($data_program_studi); return;
		
        $this->load->model('jadwal_kuliah_model', 'jadwal_kuliah');
        $data = array_merge($data, $this->jadwal_kuliah->set_default()); //merge dengan arr data dengan default
        $data = array_merge($data, (array) $jadwal_kuliah_data);
		$data['action_url'] = $transaction_url . $id . '/' . __FUNCTION__;
		//print_r($jadwal_kuliah_data);
        $this->load->view('transaction/jadwal_kuliah_form', $data);
		//echo '<pre>'. $data['action_url'].'</pre>';
    }
	
	function getOptProgramStudi() {
        $tahun_akademik_id = $this->input->post('tahun_akademik_id');
        $angkatan_id= $this->input->post('angkatan_id');
		$sql = "select a.id, a.nama_program_studi, a.kode_program_studi from akademik_m_program_studi a ".
				"where a.active ='1' and a.angkatan_id='$angkatan_id'";
        $query = $this->db->query($sql);
//        echo  $this->db->last_query();
        echo '<option value=\'\' > pilih</option>';
        foreach($query->result_array() as $row){
            echo '<option value=\''.$row['id'].'\' >'.$row['kode_program_studi'].'-'.$row['nama_program_studi'].'</option>';
        }
    }
	
	function getOptMataKuliah(){
        $tahun_akademik_id = $this->input->post('tahun_akademik_id');
        $angkatan_id= $this->input->post('angkatan_id');
        $program_studi_id = $this->input->post('program_studi_id');
		$sql = "select a.id, a.kode_mata_kuliah, a.nama_mata_kuliah from akademik_m_mata_kuliah a ".
				"where a.angkatan_id=$angkatan_id and program_studi_id= $program_studi_id";
        $query = $this->db->query($sql);
        echo '<option value=\'\' > pilih</option>';
        foreach($query->result_array() as $row){
            echo '<option value=\''.$row['id'].'\' >'.$row['kode_mata_kuliah'].'-'.$row['nama_mata_kuliah'].'</option>';
        }
    }
}

?>
