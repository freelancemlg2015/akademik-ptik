<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Absensi_dosen extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->helper(array('snippets_helper'));
        $this->load->model('crud_model', 'crud');
    }

    function log_date() {
        return date($this->config->item('log_date_format'));
    }

    function index($query_id = 0, $sort_by = 'id', $sort_order = 'desc', $offset = 0) {
        $this->absensi_dosen($query_id, $sort_by, $sort_order, $offset);
    }

    function absensi_dosen($query_id = 0, $sort_by = 'id', $sort_order = 'desc', $offset = 0) {
        $data_type = $this->input->post('data_type');
        $data['auth'] = $this->auth;

        $data['page_title'] = 'Absensi Dosen';

        $data['tools'] = array(
            'transaction/absensi_dosen/create' => 'New'
        );
		
		$angkatan_ids=(int)$this->input->post('angkatan_id');
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
			//$data['program_studi_ids']=$absensi_dosen_data->program_studi_id;
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
		$angkatan_data[0] = '';
        foreach ($this->crud->retrieve()->result() as $row) {
			$angkatan_data[$row->id] = $row->nama_angkatan;
        }
		$data['angkatan_options']=$angkatan_data;
        $data['tahun_akademik_id_attr'] = ''; $data['tahun_akademik_options'] = '';
		$tahun_akademik_datas='';
		$sql = "select a.tahun_ajar_mulai, a.tahun_ajar_akhir from akademik_m_tahun_akademik a ".
				" left join akademik_m_angkatan b on b.tahun_akademik_id=a.id ".
				"where a.active ='1' and b.id=".$angkatan_ids;
        $query = $this->db->query($sql);
		//echo $sql; return;
		//echo  '<pre>'.$this->db->last_query().'</pre><br>'; return;
        foreach($query->result_array() as $row){
            $tahun_akademik_datas = $row['tahun_ajar_mulai'].'-'.$row['tahun_ajar_akhir'];
        }
		$data['tahun_akademik_id_attr'] = $tahun_akademik_datas;
        
		//$this->crud->use_table('m_semester');
		$semester_data = array();
		$semester_data[0] = '';
		/*
		foreach ($this->crud->retrieve()->result() as $row) {
			$semester_data[$row->id] = $row->nama_semester;
		}
		*/
        $data['semester_options'] = $semester_data;
		//$data['semester_options'] = '';
		
		$data['angkatan_id']=(int)$this->input->post('angkatan_id');
		$data['program_studi']=(int)$this->input->post('program_studi');
		$data['jenis_ujian_id']=$this->input->post('jenis_ujian_id');
		$data['tahun_akademik_id']=$this->input->post('tahun_akademik_id');
		$data['jam_normal_mulai']=$this->input->post('jam_normal_mulai');
		$data['jam_normal_akhir']=$this->input->post('jam_normal_akhir');
		$data['semester_id']=$this->input->post('semester_id');
		
		$data['opt_angkatan_url'] = base_url() . 'transaction/select_data_form/getOptAngkatan';
		$data['opt_program_studi_url'] = base_url() . 'transaction/select_data_form/getOptProgramStudi';
        $data['opt_mata_kuliah_url'] =  base_url() . 'transaction/select_data_form/getOptMataKuliah';
		$data['opt_data_mahasiswa_url'] = base_url() . 'transaction/select_data_form/getOptDataDosenForm';
		$data['opt_data_jadwal_url'] = base_url() . 'transaction/select_data_form/getOptDataJadwal';
		$data['opt_semester_url'] = base_url() . 'transaction/select_data_form/getOptSemester';
		$data['action_url'] = '';

        $this->load->view('transaction/absensi_dosen', $data);
    }

	function create() {
        //echo '<pre>'; print_r($_POST); echo '</pre>'; 
		$data['auth'] = $this->auth;
        $data['action_type'] = __FUNCTION__;
        $transaction_url = 'transaction/absensi_dosen/';

        $this->load->library(array('form_validation', 'table'));
        $this->load->helper(array('form', 'snippets'));
        $this->form_validation->set_error_delimiters('<span class="notice">', '</span>');
		
		//$dosen_ajar_id = $this->input->post('dosen_ajar_id');
		//echo 'dosen_ajar_id:'.$dosen_ajar_id;
		$is_valid=1;
		if($this->input->post('angkatan_id')<=0) {$is_valid=0;}
		/*
		if($this->input->post('program_studi')<=0) {$is_valid=0;}
		if($this->input->post('semester_id')<=0) {$is_valid=0;}
		if($this->input->post('mata_kuliah')<=0) {$is_valid=0;}
		if($this->input->post('tahun_akademik_id')<=0) {$is_valid=0;}
		if($this->input->post('tgl_lahir')=='') {$is_valid=0;}
		
		if($this->input->post('nama_ruang_id')<=0) {$is_valid=0;}
		if($this->input->post('jenis_ujian_id')<=0) {$is_valid=0;}
		
		if($this->input->post('jam_normal_mulai')=='') {$is_valid=0;}
		if($this->input->post('jam_normal_akhir')=='') {$is_valid=0;}
		
		$mata_kuliah_id=(int)$this->input->post('mata_kuliah');
		if($mata_kuliah_id==0) {$is_valid=0;}
		$jenis_ujian_id=$this->input->post('jenis_ujian_id');
		*/
        if ($this->form_validation->run('absensi_dosen_create') === FALSE) {
            //don't do anything
			//echo '<p>ga valid</p>';
        } else {
			if($is_valid==0){
			} else {
				
				$angkatan_id= $this->input->post('angkatan_id');
				$jadwal_kuliah_id=$this->input->post('pertemuan_id');
				$program_studi_id=$this->input->post('program_studi_id');
				$mata_kuliah_id=$this->input->post('mata_kuliah_id');
				$semester_id=$this->input->post('semester_id');
				$this->load->model('select_data_form_model', 'select_data_form');
				$data_results = $this->select_data_form->getOptDataDosenForm($angkatan_id, $semester_id, $program_studi_id, $mata_kuliah_id, $jadwal_kuliah_id);
				/*
				$query = $this->db->query("select a.id as akademik_t_absensi_mhs_id, d.dosen_id, s.no_karpeg_dosen as nim, s.nama_dosen as nama_mhs,
					j.id as jadwal_kuliah_id, d.dosen_ajar_id, 
					j.pertemuan_ke, d.id as rencana_mata_pelajaran_pokok_id,
					k.absensi as ket_absensi, a.absensi_id
					from akademik_t_dosen_ajar m					
					left join akademik_t_dosen_ajar_detil d on m.id=d.dosen_ajar_id and d.active=1
					left join akademik_m_dosen s on d.dosen_id = s.id
					left join akademik_t_jadwal_kuliah j on j.id=$jadwal_kuliah_id
					left join akademik_t_absensi_dosen a on j.id = a.jadwal_kuliah_id and a.dosen_id=d.dosen_id and a.dosen_ajar_id = d.dosen_ajar_id
					left join akademik_m_absensi k on a.absensi_id = k.id
					where m.angkatan_id = $angkatan_id and m.semester_id=$semester_id and m.mata_kuliah_id=$mata_kuliah_id");
				*/
				//echo '<pre>'.$this->db->last_query().'</pre>'; return;
				foreach($data_results->result_array() as $row){
					$absensi_id = $this->input->post('nilai_nts_'.$row['rencana_mata_pelajaran_pokok_id']);
					$parm = array();
					if($absensi_id !='') $parm['absensi_id'] = $absensi_id;
					//echo '<pre>'; print_r($parm['absensi_id']); echo '</pre>'; return;
					if(count($parm)>0){
						if($row['akademik_t_absensi_mhs_id']==''){
							$parm['dosen_ajar_id'] = $row['dosen_ajar_id'];
							$parm['jadwal_kuliah_id'] =  $jadwal_kuliah_id;
							$parm['dosen_id'] = $row['dosen_id'];
							$this->db->insert('akademik_t_absensi_dosen',$parm);
						}else{
							$this->db->where('id',$row['akademik_t_absensi_mhs_id']);
							$parm['absensi_id'] = $absensi_id;
							$this->db->update('akademik_t_absensi_dosen',$parm);
						}
						//echo '<pre>'; print_r($parm); echo '</pre>'; return;
					}
				}
				//echo '<pre>'; print_r($parm); echo '</pre>'; return;
				redirect('transaction/absensi_dosen/');//return
			}
        }
		$data['tgl_lahir']=$this->input->post('tgl_lahir');
		$data['angkatan_id']=(int)$this->input->post('angkatan_id');
		$data['program_studi']=(int)$this->input->post('program_studi');
		$data['jenis_ujian_id']=$this->input->post('jenis_ujian_id');
		$data['tahun_akademik_id']=$this->input->post('tahun_akademik_id');
		$data['jam_normal_mulai']=$this->input->post('jam_normal_mulai');
		$data['jam_normal_akhir']=$this->input->post('jam_normal_akhir');
		$data['semester_id']=$this->input->post('semester_id');
        $data['action_url'] = $transaction_url . __FUNCTION__;
        $data['page_title'] = 'Create Absensi Dosen';
        $data['tools'] = array('transaction/absensi_dosen' => 'Back');
		$angkatan_ids=(int)$this->input->post('angkatan_id');
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
			//$data['program_studi_ids']=$absensi_dosen_data->program_studi_id;
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
		$angkatan_data[0] = '';
        foreach ($this->crud->retrieve()->result() as $row) {
			$angkatan_data[$row->id] = $row->nama_angkatan;
        }
		$data['angkatan_options']=$angkatan_data;
        $data['tahun_akademik_id_attr'] = ''; $data['tahun_akademik_options'] = '';
		$tahun_akademik_datas='';
		$sql = "select a.tahun_ajar_mulai, a.tahun_ajar_akhir from akademik_m_tahun_akademik a ".
				" left join akademik_m_angkatan b on b.tahun_akademik_id=a.id ".
				"where a.active ='1' and b.id=".$angkatan_ids;
        $query = $this->db->query($sql);
		//echo $sql; return;
		//echo  '<pre>'.$this->db->last_query().'</pre><br>'; return;
        foreach($query->result_array() as $row){
            $tahun_akademik_datas = $row['tahun_ajar_mulai'].'-'.$row['tahun_ajar_akhir'];
        }
		$data['tahun_akademik_id_attr'] = $tahun_akademik_datas;
        
		//$this->crud->use_table('m_semester');
		$semester_data = array();
		$semester_data[0] = '';
		/*
		foreach ($this->crud->retrieve()->result() as $row) {
			$semester_data[$row->id] = $row->nama_semester;
		}
		*/
        $data['semester_options'] = $semester_data;
		//$data['semester_options'] = '';
		
		$data['opt_angkatan_url'] = base_url() . 'transaction/select_data_form/getOptAngkatan';
		$data['opt_program_studi_url'] = base_url() . 'transaction/select_data_form/getOptProgramStudi';
        $data['opt_mata_kuliah_url'] =  base_url() . 'transaction/select_data_form/getOptMataKuliah';
		$data['opt_data_mahasiswa_url'] = base_url() . 'transaction/select_data_form/getOptDataDosenForm';
		$data['opt_data_jadwal_url'] = base_url() . 'transaction/select_data_form/getOptDataJadwal';
		$data['opt_semester_url'] = base_url() . 'transaction/select_data_form/getOptSemester';
		$data['action_url'] = '';
        
        $this->load->model('absensi_dosen_model', 'absensi_dosen');
        $data = array_merge($data, $this->absensi_dosen->set_default()); //merge dengan arr data dengan default
		//$data['action_url'] = $transaction_url . $id . '/' . __FUNCTION__;
		$data['action_url'] = $transaction_url . '/' . __FUNCTION__;
        $this->load->view('transaction/absensi_dosen_form', $data);
    }

}
?>
