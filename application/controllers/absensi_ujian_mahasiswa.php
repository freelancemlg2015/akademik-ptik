<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Absensi_ujian_mahasiswa extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->helper(array('snippets_helper'));
        $this->load->model('crud_model', 'crud');
    }

    function log_date() {
        return date($this->config->item('log_date_format'));
    }

    function index($query_id = 0, $sort_by = 'id', $sort_order = 'desc', $offset = 0) {
        $this->absensi_ujian_mahasiswa($query_id, $sort_by, $sort_order, $offset);
    }

    function absensi_ujian_mahasiswa($query_id = 0, $sort_by = 'id', $sort_order = 'desc', $offset = 0) {
        $data_type = $this->input->post('data_type');
        $data['auth'] = $this->auth;
		$data['tahun_akademik_id_attr'] = '';
        $data['page_title'] = 'Absensi Ujian Mahasiswa';

        $data['tools'] = array(
            'transaction/absensi_ujian_mahasiswa/create' => 'New'
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
			//$data['program_studi_ids']=$absensi_ujian_mahasiswa_data->program_studi_id;
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
		
		$this->crud->use_table('m_tahun_akademik');
		$tahun_akademik_data = array();
		$tahun_akademik_data[0] ="";
        foreach ($this->crud->retrieve()->result() as $row) {
			$tahun_akademik_data[$row->id] = $row->tahun_ajar_mulai.'-'.$row->tahun_ajar_akhir;
		}
        $data['tahun_akademik_options'] = $tahun_akademik_data;
        
		//$this->crud->use_table('m_semester');
		$semester_data = array();
		$semester_data[0] = '';
        $data['semester_options'] = $semester_data;
		
		
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
		$data['opt_data_mahasiswa_url'] = base_url() . 'transaction/select_data_form/getOptDataMahasiswaUjian';
		$data['opt_data_jadwal_url'] = base_url() . 'transaction/select_data_form/getOptDataJadwalUjian';
		$data['opt_semester_url'] = base_url() . 'transaction/select_data_form/getOptSemester';

        $this->load->view('transaction/absensi_ujian_mahasiswa', $data);
    }

    function search() {
        $query_array = array(
            'nama_dosen' => $this->input->post('nama_dosen'),
            'nama_ruang' => $this->input->post('nama_ruang'),
            'active' => 1
        );
        $query_id = $this->input->save_query($query_array);
        redirect("transaction/absensi_ujian_mahasiswa/view/$query_id");
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
            'transaction/absensi_ujian_mahasiswa' => 'Back',
            'transaction/absensi_ujian_mahasiswa/' . $id . '/edit' => 'Edit',
            'transaction/absensi_ujian_mahasiswa/' . $id . '/delete' => 'Delete'
        );
        $data['page_title'] = 'Detail Absensi Mahasiswa';
        $this->load->view('transaction/absensi_ujian_mahasiswa_info', $data);
    }

    function delete() {
        $id = $this->uri->segment(3);
        $this->crud->use_table('t_absensi_mhs');
        $criteria = array('id' => $id);
        $data_in = array(
            'active' => 0,
            'modified_on' => logged_info()->on,
            'modified_by' => logged_info()->by
        );
        $this->crud->update($criteria, $data_in);
        redirect('transaction/absensi_ujian_mahasiswa');
    }
	
	function create() {
        //echo '<pre>'; print_r($_POST); echo '</pre>';  return;
		$data['auth'] = $this->auth;
		$data['tahun_akademik_id_attr'] = '';
        $data['action_type'] = __FUNCTION__;
        $transaction_url = 'transaction/absensi_ujian_mahasiswa/';

        $this->load->library(array('form_validation', 'table'));
        $this->load->helper(array('form', 'snippets'));
        $this->form_validation->set_error_delimiters('<span class="notice">', '</span>');
		
		
		//$dosen_ajar_id = $this->input->post('dosen_ajar_id');
		//echo 'dosen_ajar_id:'.$dosen_ajar_id;
		$is_valid=1;
		if($this->input->post('angkatan_id')<=0) {$is_valid=0;}
        if ($this->form_validation->run('absensi_ujian_mahasiswa_create') === FALSE) {
            //don't do anything
			//echo '<p>ga valid</p>';
        } else {
			if($is_valid==0){
			} else {
				
				$angkatan_id= $this->input->post('angkatan_id');
				//$tahun_akademik_id = $this->input->post('tahun_akademik_id');
				$jadwal_kuliah_id=$this->input->post('pertemuan_id');
				$program_studi_id=$this->input->post('program_studi_id');
				$mata_kuliah_id=$this->input->post('mata_kuliah_id');
				$semester_id=$this->input->post('semester_id');
				$query = $this->db->query("select a.id as akademik_t_absensi_mhs_id, d.mahasiswa_id, s.nim, s.nama as nama_mhs, j.id as jadwal_kuliah_id,
				d.id as rencana_mata_pelajaran_pokok_id, k.absensi as ket_absensi, a.absensi_id
				from akademik_t_rencana_mata_pelajaran_pokok m					
				left join akademik_t_rencana_mata_pelajaran_pokok_detil d on m.id = d.rencana_mata_pelajaran_id and d.active=1
				left join akademik_m_mahasiswa s on d.mahasiswa_id = s.id
				left join akademik_t_jadwal_ujian j on j.id=$jadwal_kuliah_id
				left join akademik_t_absensi_ujian_mhs a on j.id = a.jadwal_ujian_id  and a.mahasiswa_id = d.mahasiswa_id
				left join akademik_m_absensi k on a.absensi_id = k.id
				where m.angkatan_id = $angkatan_id and m.program_studi_id=$program_studi_id 
				and m.semester_id = $semester_id and m.mata_kuliah_id = $mata_kuliah_id");
				//echo '<pre>'.$this->db->last_query().'</pre>'; return;
				foreach($query->result_array() as $row){
					$absensi_id = $this->input->post('nilai_nts_'.$row['rencana_mata_pelajaran_pokok_id']);
					$parm = array();
					if($absensi_id !='') $parm['absensi_id'] = $absensi_id;
					//echo '<pre>'; print_r($parm['absensi_id']); echo '</pre>';
					if(count($parm)>0){
						if($row['akademik_t_absensi_mhs_id']==''){
							//$parm['rencana_mata_pelajaran_pokok_id'] = $row['rencana_mata_pelajaran_pokok_id'];
							$parm['jadwal_ujian_id'] =  $jadwal_kuliah_id;
							//$parm['pertemuan'] =  $jadwal_kuliah_id;
							$parm['mahasiswa_id'] = $row['mahasiswa_id'];
							$this->db->insert('akademik_t_absensi_ujian_mhs',$parm);
						}else{
							$this->db->where('id',$row['akademik_t_absensi_mhs_id']);
							$parm['absensi_id'] = $absensi_id;
							$this->db->update('akademik_t_absensi_ujian_mhs',$parm);
						}
						//echo '<pre>'; print_r($parm); echo '</pre>'; return;
					}
				}
				//echo '<pre>'; print_r($parm); echo '</pre>'; return;
				redirect('transaction/absensi_ujian_mahasiswa/');//return
				/*
				$hari_ids = $this->input->post('tgl_lahir');
				$hari_id = date("w",strtotime($hari_ids."w"));
				$this->crud->use_table('t_absensi_ujian_mahasiswa');
				$data_in = array(
					'program_studi_id'=> $this->input->post('program_studi'),
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
				redirect('transaction/absensi_ujian_mahasiswa/' . $created_id . '/info');
				*/
			}
        }
		$data['tgl_lahir']=$this->input->post('tgl_lahir');
		$data['angkatan_id']=(int)$this->input->post('angkatan_id');
		$data['program_studi']=(int)$this->input->post('program_studi');
		$data['jenis_ujian_id']=$this->input->post('jenis_ujian_id');
		$data['tahun_akademik_id']=$this->input->post('tahun_akademik_id');
		$data['semester_id']=$this->input->post('semester_id');
        $data['action_url'] = $transaction_url . __FUNCTION__;
        $data['page_title'] = 'Create Absensi Ujian Mahasiswa';
        $data['tools'] = array('transaction/absensi_ujian_mahasiswa' => 'Back');
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
			//$data['program_studi_ids']=$absensi_ujian_mahasiswa_data->program_studi_id;
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
        
        $this->crud->use_table('m_tahun_akademik');
		$tahun_akademik_data = array();
		$tahun_akademik_data[0] ="";
        foreach ($this->crud->retrieve()->result() as $row) {
			$tahun_akademik_data[$row->id] = $row->tahun_ajar_mulai.'-'.$row->tahun_ajar_akhir;
		}
        $data['tahun_akademik_options'] = $tahun_akademik_data;
        
		//$this->crud->use_table('m_semester');
		$semester_data = array();
		$semester_data[0] = '';
        $data['semester_options'] = $semester_data;
		//$data['semester_options'] = '';
		
		
		$this->crud->use_table('m_jenis_ujian');
		$order_bys = array( "kode_ujian"=>"asc");
		$kegiatan_data = array();
		$kegiatan_data[0] = '';
        $data['kegiatan_options'] = $kegiatan_data;
		
        $data['opt_angkatan_url'] = base_url() . 'transaction/select_data_form/getOptAngkatan';
		$data['opt_program_studi_url'] = base_url() . 'transaction/select_data_form/getOptProgramStudi';
        $data['opt_mata_kuliah_url'] =  base_url() . 'transaction/select_data_form/getOptMataKuliah';
		$data['opt_data_mahasiswa_url'] = base_url() . 'transaction/select_data_form/getOptDataMahasiswaUjian';
		$data['opt_data_jadwal_url'] = base_url() . 'transaction/select_data_form/getOptDataJadwalUjian';
		$data['opt_semester_url'] = base_url() . 'transaction/select_data_form/getOptSemester';
		
        //$this->crud->use_table('m_data_ruang');
        //$data['ruang_pelajaran_options'] = $this->crud->retrieve()->result();
        
		//$this->load->model('absensi_ujian_mahasiswa_model', 'absensi_ujian_mahasiswa');
        //$data = array_merge($data, $this->absensi_ujian_mahasiswa->set_default()); //merge dengan arr data dengan default
		//$data['action_url'] = $transaction_url . $id . '/' . __FUNCTION__;
		$data['action_url'] = $transaction_url . '/' . __FUNCTION__;
		//echo 'reneh1'; return;
        $this->load->view('transaction/absensi_ujian_mahasiswa_form', $data);
		
    }

}
?>
