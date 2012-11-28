<?php
/*
 * Imam
 * Transaksi :  Nilai Akademik
 * 9/9/2012
 */

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Nilai_akademik extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->helper(array('snippets_helper'));
        $this->load->model('crud_model', 'crud');
    }

    function log_date() {
        return date($this->config->item('log_date_format'));
    }

    function index($query_id = 0, $sort_by = 'id', $sort_order = 'desc', $offset = 0) {

        $this->nilai_akademik($query_id, $sort_by, $sort_order, $offset);
    }

    function nilai_akademik($query_id = 0, $sort_by = 'id', $sort_order = 'desc', $offset = 0) {
        $data_type = $this->input->post('data_type');
        $data['auth'] = $this->auth;
        // pagination
        $limit = 20;
        $this->load->library(array('form_validation', 'table', 'pagination'));
        $this->input->load_query($query_id);
        $query_array = array(
            'nim' => $this->input->get('nim'),
            'nama_mata_kuliah' => $this->input->get('nama_mata_kuliah'),
            'active' => 1
        );

        $this->load->model('nilai_akademik_model', 'nilai_akademik');
        $results = $this->nilai_akademik->search($query_array, $limit, $offset, $sort_by, $sort_order);
        //echo get_instance()->db->last_query();
        $data['results'] = $results['results'];
        $data['num_results'] = $results['num_rows'];

        // pagination
        $config = array();
        $config['base_url'] = site_url("transaction/nilai_akademik/$query_id/$sort_by/$sort_order");
        $config['total_rows'] = $data['num_results'];
        $config['per_page'] = $limit;
        $config['uri_segment'] = 6;
        $config['num_links'] = 6;

        $config = array_merge($config, default_pagination_btn());
        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();
        $data['sort_by'] = $sort_by;
        $data['sort_order'] = $sort_order;

        $data['page_title'] = 'Nilai Akademik';
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
			//$data['program_studi_ids']=$absensi_mahasiswa_data->program_studi_id;
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
        
		$this->crud->use_table('m_semester');
		$semester_data = array();
		$semester_data[0] = '';
		foreach ($this->crud->retrieve()->result() as $row) {
			$semester_data[$row->id] = $row->nama_semester;
		}
        $data['semester_options'] = $semester_data;
		
		
		$data['angkatan_id']=(int)$this->input->post('angkatan_id');
		$data['program_studi']=(int)$this->input->post('program_studi');
		$data['semester_id']=$this->input->post('semester_id');
		
		$data['opt_angkatan_url'] = base_url() . 'transaction/select_data_form/getOptAngkatan';
		$data['opt_program_studi_url'] = base_url() . 'transaction/select_data_form/getOptProgramStudi';
        $data['opt_mata_kuliah_url'] =  base_url() . 'transaction/select_data_form/getOptMataKuliah';
		$data['opt_data_mahasiswa_url'] = base_url() . 'transaction/select_data_form/getOptDataNilaiMahasiswaAkademik';
		$data['tools'] = array(
            'transaction/nilai_akademik/create' => 'New'
        );
        $this->load->view('transaction/nilai_akademik', $data);
    }

    function search() {
        $query_array = array(
            'nilai_nts' => $this->input->get('nilai_nts'),
            'nilai_tgs' => $this->input->get('nilai_tgs'),
            'nilai_nas' => $this->input->get('nilai_nas'),
            'nilai_prb' => $this->input->get('nilai_prb'),
            'active' => 1
        );
        $query_id = $this->input->save_query($query_array);
        redirect("transaction/nilai_akademik/view/$query_id");
    }

    function info() {
        $id = $this->uri->segment(3);
        $data['auth'] = $this->auth;
        $criteria = array(
            't_nilai_akademik.id' => $id
        );
        $this->load->model('nilai_akademik_model', 'nilai_akademik');
        $result = $this->nilai_akademik->get_many('', $criteria)->row_array();
        //[debug]echo get_instance()->db->last_query();
        $result_keys = array_keys($result);
        foreach ($result_keys as $result_key) {
            $data[$result_key] = $result[$result_key];
        }

        $data['tools'] = array(
            'transaction/nilai_akademik' => 'Back',
            'transaction/nilai_akademik/' . $id . '/edit' => 'Edit',
            'transaction/nilai_akademik/' . $id . '/delete' => 'Delete'
        );
        $data['page_title'] = 'Detail Nilai Akademik';
        $this->load->view('transaction/nilai_akademik_info', $data);
    }

    function delete() {
        $id = $this->uri->segment(3);
        $this->crud->use_table('t_nilai_akademik');
        $criteria = array('id' => $id);
        $data_in = array(
            'active' => 0,
            'modified_on' => logged_info()->on,
            'modified_by' => logged_info()->by
        );
        $this->crud->update($criteria, $data_in);
        redirect('transaction/nilai_akademik');
    }

    function create() {
        $data['auth'] = $this->auth;
        $data['action_type'] = __FUNCTION__;
        $transaction_url = 'transaction/nilai_akademik/';

        $this->load->library(array('form_validation', 'table'));
        $this->load->helper(array('form', 'snippets'));
        $this->form_validation->set_error_delimiters('<span class="notice">', '</span>');
		
		$is_valid=1;
		/*
		if($this->input->post('angkatan_id')<=0) {$is_valid=0;}
		//if($this->input->post('tahun_akademik_id_attr')=='') {$is_valid=0;}
		if($this->input->post('semester_id')<=0) {$is_valid=0;}
		if($this->input->post('program_studi')<=0) {$is_valid=0;}
		$mata_kuliah_id=(int)$this->input->post('mata_kuliah_id');
		if($mata_kuliah_id==0) {$is_valid=0;}
		*/
        if ($this->form_validation->run('nilai_akademik_create') === FALSE) {
            //don't do anything
			//echo '<p>ga valid</p>';
        } else {
			if($is_valid==0){
			} else {
				$angkatan_id= $this->input->post('angkatan_id');
				$program_studi_id=$this->input->post('program_studi_id');
				$mata_kuliah_id=$this->input->post('mata_kuliah_id');
				$semester_id=$this->input->post('semester_id');
				$query = $this->db->query("select m.id as rencana_mata_pelajaran_pokok_id, d.mahasiswa_id, s.nim, s.nama as nama_mhs,
				d.id as rencana_mata_pelajaran_pokok_dtl_id, c.sks_mata_kuliah,
                a.id as nilai_kuliah_id, a.nilai_nts, a.nilai_tgs, a.nilai_nas, a.nilai_prb, a.nilai_akhir
				from akademik_t_rencana_mata_pelajaran_pokok m					
				left join akademik_t_rencana_mata_pelajaran_pokok_detil d on m.id = d.rencana_mata_pelajaran_id and d.active=1
				left join akademik_m_mahasiswa s on  d.mahasiswa_id = s.id
				left join akademik_m_mata_kuliah c on m.mata_kuliah_id = c.id
				left join akademik_t_nilai_akademik a on m.id = a.rencana_mata_pelajaran_pokok_id and a.mahasiswa_id = s.id
				where m.angkatan_id = $angkatan_id and m.program_studi_id=$program_studi_id  
				and m.semester_id = $semester_id and m.mata_kuliah_id = $mata_kuliah_id");
				//echo '<pre>'.$this->db->last_query().'</pre>'; return;
				foreach($query->result_array() as $row){
					$nilai_nts = $this->input->post('nilai_nts_'.$row['rencana_mata_pelajaran_pokok_dtl_id']);
					$nilai_tgs = $this->input->post('nilai_tgs_'.$row['rencana_mata_pelajaran_pokok_dtl_id']);
					$nilai_nas = $this->input->post('nilai_nas_'.$row['rencana_mata_pelajaran_pokok_dtl_id']);
					$nilai_prb = $this->input->post('nilai_prb_'.$row['rencana_mata_pelajaran_pokok_dtl_id']);
					$parm = array();
					//if($absensi_id !='') $parm['absensi_id'] = $absensi_id;
					//echo '<pre>'; print_r($parm['absensi_id']); echo '</pre>';
					
					$parm['nilai_nts'] =  $nilai_nts;
					$parm['nilai_tgs'] =  $nilai_tgs;
					$parm['nilai_nas'] =  $nilai_nas;
					$parm['nilai_prb'] =  $nilai_prb;
					$parm['nilai_akhir'] = NULL;
					
					if($row['sks_mata_kuliah']==1){
						if($nilai_tgs =='')  $parm['nilai_akhir'] =$parm['nilai_nas'];
						else $parm['nilai_akhir'] =(($parm['nilai_nts'] * 4) + ($parm['nilai_nas'] * 6))/10;
					}else {
						if($nilai_tgs =='')  $parm['nilai_akhir'] =(($parm['nilai_nts']*4) + ($parm['nilai_nas']*6))/10;
						else $parm['nilai_akhir'] =(($parm['nilai_nts'] * 3) + ($parm['nilai_tgs'] * 2)+ ($parm['nilai_nas'] * 5))/10;
					}
					if($nilai_nas=='') $parm['nilai_akhir'] = NULL;
					//print_r($parm); return; exit;
					if(count($parm)>0){
						if($row['nilai_kuliah_id']==''){
							$parm['mahasiswa_id'] = $row['mahasiswa_id'];
							$parm['rencana_mata_pelajaran_pokok_id'] = $row['rencana_mata_pelajaran_pokok_id'];
							$parm['mata_kuliah_id'] = $mata_kuliah_id;
							$parm['created_on'] = date($this->config->item('log_date_format'));
							$parm['created_by'] = logged_info()->on;
							$this->db->insert('akademik_t_nilai_akademik',$parm);
						}else{
							$this->db->where('id',$row['nilai_kuliah_id']);
							$parm['modified_on'] = date($this->config->item('log_date_format'));
							$parm['modified_by'] = logged_info()->on;
							$this->db->update('akademik_t_nilai_akademik',$parm);
						}
						//echo '<pre>'; print_r($parm); echo '</pre>'; return;
					}
				}
				redirect('transaction/nilai_akademik/');
			}
        }
        $data['action_url'] = $transaction_url . __FUNCTION__;
        $data['page_title'] = 'Create Nilai Akademik';
        $data['tools'] = array(
            'transaction/nilai_akademik' => 'Back'
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
			//$data['program_studi_ids']=$absensi_mahasiswa_data->program_studi_id;
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
        
		$this->crud->use_table('m_semester');
		$semester_data = array();
		$semester_data[0] = '';
		foreach ($this->crud->retrieve()->result() as $row) {
			$semester_data[$row->id] = $row->nama_semester;
		}
        $data['semester_options'] = $semester_data;
		
		
		$data['angkatan_id']=(int)$this->input->post('angkatan_id');
		$data['program_studi']=(int)$this->input->post('program_studi');
		$data['tahun_akademik_id']=$this->input->post('tahun_akademik_id');
		$data['semester_id']=$this->input->post('semester_id');
		
		$data['opt_angkatan_url'] = base_url() . 'transaction/select_data_form/getOptAngkatan';
		$data['opt_program_studi_url'] = base_url() . 'transaction/select_data_form/getOptProgramStudi';
        $data['opt_mata_kuliah_url'] =  base_url() . 'transaction/select_data_form/getOptMataKuliah';
		$data['opt_data_mahasiswa_url'] = base_url() . 'transaction/select_data_form/getOptDataNilaiMahasiswaAkademik';
		
        $this->load->model('nilai_akademik_model', 'nilai_akademik');
        $data = array_merge($data, $this->nilai_akademik->set_default()); //merge dengan arr data dengan default
		/*
        $query = $this->db->query('SELECT a.id, a.kode_angkatan, a.nama_angkatan FROM akademik_m_angkatan a');
        $angkatans = array(''=>'pilih');
        foreach ($query->result_array() as $row) {
            $angkatans[$row['id']] = $row['kode_angkatan'] . '-' . $row['nama_angkatan'];
        }
        $query = $this->db->query('SELECT a.id, a.tahun_ajar_mulai, a.tahun_ajar_akhir FROM akademik_m_tahun_akademik a WHERE a.active =\'1\';');
        $opt_tahun_akademik = array(''=>'pilih');
        foreach ($query->result_array() as $row) {
            $opt_tahun_akademik[$row['id']] = $row['tahun_ajar_mulai'].' - '.$row['tahun_ajar_akhir'] ;
        }

        $data['angkatans'] = $angkatans;
        $data['opt_tahun_akademik'] = $opt_tahun_akademik;
        
        $data['opt_semester'] = array(''=>'pilih', '1' => 'Semester 1', '2' => 'Semester 1', '2' => 'Semester 2', '3' => 'Semester 3');
        $data['opt_program_studi_url'] = base_url() . 'transaction/nilai_akademik/getOptProgramStudi';
        $data['opt_mata_kuliah_url'] =  base_url() . 'transaction/nilai_akademik/getOptMataKuliah';
        $data['Mahasiswa_list_url'] =  base_url() . 'transaction/nilai_akademik/getMahasiswa';
		$data['submit_url'] =  base_url() . 'transaction/nilai_akademik/submit_nilai';
		*/
        $this->load->view('transaction/nilai_akademik_form', $data);
    }
    
    function submit_nilai(){
		$angkatan_id= $this->input->post('angkatan_ids');
        $program_studi_id = $this->input->post('program_studi_ids');
        $mata_kuliah_id  = $this->input->post('mata_kuliah_ids');
        $tahun_akademik_id = $this->input->post('tahun_akademik_ids');
		$query = $this->db->query("select a.id as rencana_mata_pelajaran_pokok_id, a.mahasiswa_id,b.id as akademik_t_nilai_akademik_id , c.nama as nama_mhs, c.nim, a.mata_kuliah_id, b.nilai_nts, b.nilai_tgs, b.nilai_nas, b.nilai_prb, b.nilai_prb, b.nilai_akhir , d.sks_mata_kuliah
            from akademik_t_rencana_mata_pelajaran_pokok a
            left join akademik_t_nilai_akademik b on a.id = b.rencana_mata_pelajaran_pokok_id
            left join akademik_m_mahasiswa c on a.mahasiswa_id = c.id 
			left join akademik_m_mata_kuliah d on a.mata_kuliah_id = d.id 
			where a.angkatan_id = $angkatan_id and a.program_studi_id and a.mata_kuliah_id = $mata_kuliah_id and a.tahun_akademik_id = $tahun_akademik_id");
		echo $this->db->last_query();
		if($query->num_rows()<1){
			
		}else foreach($query->result_array() as $row){
			$nilai_nts = $this->input->post('nilai_nts_'.$row['rencana_mata_pelajaran_pokok_id']);
			$nilai_tgs = $this->input->post('nilai_tgs_'.$row['rencana_mata_pelajaran_pokok_id']);
			$nilai_nas = $this->input->post('nilai_nas_'.$row['rencana_mata_pelajaran_pokok_id']);
			$nilai_prb = $this->input->post('nilai_prb_'.$row['rencana_mata_pelajaran_pokok_id']);
			$parm = array();
			if($nilai_nts !='') $parm['nilai_nts'] = $nilai_nts;
			else $parm['nilai_nts'] =  NULL;
			if($nilai_tgs !='')$parm['nilai_tgs'] = $nilai_tgs;
			else $parm['nilai_tgs'] = NULL;
			if($nilai_nas!='') $parm['nilai_nas'] = $nilai_nas;
			else  $parm['nilai_nas'] = NULL;
			if($nilai_prb!='') $parm['nilai_prb'] = $nilai_prb;
			else $parm['nilai_prb'] = NULL;
			if(count($parm)>0){
				if($row['sks_mata_kuliah']==1){
					if($nilai_tgs =='')  $parm['nilai_akhir'] =$parm['nilai_nas'];
					else $parm['nilai_akhir'] =(($parm['nilai_nts'] * 4) + ($parm['nilai_nas'] * 6))/10;
				}else {
					if($nilai_tgs =='')  $parm['nilai_akhir'] =(($parm['nilai_nts']*4) + ($parm['nilai_nas']*6))/10;
					else $parm['nilai_akhir'] =(($parm['nilai_nts'] * 3) + ($parm['nilai_tgs'] * 2)+ ($parm['nilai_nas'] * 5))/10;
				}
				if($nilai_nas=='') $parm['nilai_akhir'] = NULL;
				if($row['akademik_t_nilai_akademik_id']==''){
					$parm['rencana_mata_pelajaran_pokok_id'] = $row['rencana_mata_pelajaran_pokok_id'];
					$parm['mahasiswa_id'] = $row['mahasiswa_id'];
					$parm['mata_kuliah_id'] = $row['mata_kuliah_id'];
					$this->db->insert('akademik_t_nilai_akademik',$parm);
				}else{
					$this->db->where('id',$row['akademik_t_nilai_akademik_id']);
					$this->db->update('akademik_t_nilai_akademik',$parm);
				}
				//echo $this->db->last_query();
			}
		}
	}

    function edit() {
        $data['auth'] = $this->auth;
        $data['action_type'] = __FUNCTION__;
        $master_url = 'transaction/nilai_akademik/';
        $id = $this->uri->segment(3);

        $this->load->library(array('form_validation', 'table'));
        $this->load->helper(array('form', 'snippets'));
        $this->form_validation->set_error_delimiters('<span class="notice">', '</span>');
        if ($this->form_validation->run('nilai_akademik_update') === FALSE) {
            //don't do anything
        } else {
            $this->crud->use_table('t_nilai_akademik');
            $criteria = array(
                'id' => $id
            );
            $data_in = array(
                'mahasiswa_id' => $this->input->post('mahasiswa_id'),
                'mata_kuliah_id' => $this->input->post('mata_kuliah_id'),
                'nilai_nts' => $this->input->post('nilai_nts'),
                'nilai_tgs' => $this->input->post('nilai_tgs'),
                'nilai_nas' => $this->input->post('nilai_nas'),
                'nilai_prb' => $this->input->post('nilai_prb'),
                'nilai_akhir' => $this->input->post('nilai_akhir'),
                'modified_on' => date($this->config->item('log_date_format')),
                'modified_by' => logged_info()->on
            );
            $this->crud->update($criteria, $data_in);
            redirect('transaction/nilai_akademik/' . $id . '/info');
        }
        $data['action_url'] = $master_url . $id . '/' . __FUNCTION__;
        $data['page_title'] = 'Update Nilai Akademik';
        $data['tools'] = array(
            'transaction/nilai_akademik' => 'Back'
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
			//$data['program_studi_ids']=$absensi_mahasiswa_data->program_studi_id;
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
        
		$this->crud->use_table('m_semester');
		$semester_data = array();
		$semester_data[0] = '';
		foreach ($this->crud->retrieve()->result() as $row) {
			$semester_data[$row->id] = $row->nama_semester;
		}
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
		$data['opt_data_mahasiswa_url'] = base_url() . 'transaction/select_data_form/getOptDataNilaiMahasiswaAkademik';

        $this->crud->use_table('t_nilai_akademik');
        $nilai_akademik_data = $this->crud->retrieve(array('id' => $id))->row();

        $this->load->model('nilai_akademik_model', 'nilai_akademik');
        $data = array_merge($data, $this->nilai_akademik->set_default()); //merge dengan arr data dengan default
        $data = array_merge($data, (array) nilai_akademik);
        $this->load->view('transaction/nilai_akademik_form', $data);
    }
	/*
	function NilaiHuruf($nilai =''){
		if($nilai='') return '&nbsp;';
		if($nilai>90) return 'A';
		if($nilai>80) return 'B+';
		if($nilai>75) return 'B';
		if($nilai>70) return 'B-';
		if($nilai>60) return 'C+';
		if($nilai>55) return 'C';
		if($nilai>50) return 'C-';
		if($nilai>40) return 'D';
		return 'E';
	}
	*/

    function suggestion() {
        $this->load->model('mahasiswa_model');
        $nim = $this->input->get('nim');
        $terms = array(
            'nim' => $nim
        );
        $this->mahasiswa_model->suggestion($terms);
    }

}

?>
