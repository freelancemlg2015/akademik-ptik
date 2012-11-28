<?php

/*
 * Indah
 * Transaksi :  nilai fisik
 * 9/9/2012
 */

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Nilai_fisik extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->helper(array('snippets_helper'));
        $this->load->model('crud_model', 'crud');
    }

    function log_date() {
        return date($this->config->item('log_date_format'));
    }

    function index($query_id = 0, $sort_by = 'id', $sort_order = 'desc', $offset = 0) {
        $this->nilai_fisik($query_id, $sort_by, $sort_order, $offset);
    }

    function nilai_fisik($query_id = 0, $sort_by = 'id', $sort_order = 'desc', $offset = 0) {
        $data_type = $this->input->post('data_type');
        $data['auth'] = $this->auth;
        // pagination
        $limit = 20;
        $this->load->library(array('form_validation', 'table', 'pagination'));
        $this->input->load_query($query_id);
        $query_array = array(
            'nim' => $this->input->get('nim'),
            'nilai_fisik' => $this->input->get('nilai_fisik'),
            'active' => 1
        );

        $this->load->model('nilai_fisik_model', 'nilai_fisik');
        $results = $this->nilai_fisik->search($query_array, $limit, $offset, $sort_by, $sort_order);
        //echo get_instance()->db->last_query();
        $data['results'] = $results['results'];
        $data['num_results'] = $results['num_rows'];

        // pagination
        $config = array();
        $config['base_url'] = site_url("transaction/nilai_fisik/$query_id/$sort_by/$sort_order");
        $config['total_rows'] = $data['num_results'];
        $config['per_page'] = $limit;
        $config['uri_segment'] = 6;
        $config['num_links'] = 6;

        $config = array_merge($config, default_pagination_btn());
        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();
        $data['sort_by'] = $sort_by;
        $data['sort_order'] = $sort_order;

        $data['page_title'] = 'Nilai Fisik';
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
		$data['opt_data_mahasiswa_url'] = base_url() . 'transaction/select_data_form/getOptDataNilaiMahasiswaFisik';

        $data['tools'] = array(
            'transaction/nilai_fisik/create' => 'New'
        );

        $this->load->view('transaction/nilai_fisik', $data);
    }

    function search() {
        $query_array = array(
            'nim' => $this->input->post('nim'),
            'nilai_fisik' => $this->input->post('nilai_fisik'),
            'active' => 1
        );
        $query_id = $this->input->save_query($query_array);
        redirect("transaction/nilai_fisik/view/$query_id");
    }

    function info() {
        $id = $this->uri->segment(3);
        $data['auth'] = $this->auth;
        $criteria = array(
            't_nilai_fisik.id' => $id
        );
        $this->load->model('nilai_fisik_model', 'nilai_fisik');
        $result = $this->nilai_fisik->get_many('', $criteria)->row_array();
        //[debug]echo get_instance()->db->last_query();
        $result_keys = array_keys($result);
        foreach ($result_keys as $result_key) {
            $data[$result_key] = $result[$result_key];
        }

        $data['tools'] = array(
            'transaction/nilai_fisik' => 'Back',
            'transaction/nilai_fisik/' . $id . '/edit' => 'Edit',
            'transaction/nilai_fisik/' . $id . '/delete' => 'Delete'
        );
        $data['page_title'] = 'Detail Nilai Fisik';
        $this->load->view('transaction/nilai_fisik_info', $data);
    }

    function delete() {
        $id = $this->uri->segment(3);
        $this->crud->use_table('t_nilai_fisik');
        $criteria = array('id' => $id);
        $data_in = array(
            'active' => 0,
            'modified_on' => logged_info()->on,
            'modified_by' => logged_info()->by
        );
        $this->crud->update($criteria, $data_in);
        redirect('transaction/nilai_fisik');
    }

    function create() {
        $data['auth'] = $this->auth;
        $data['action_type'] = __FUNCTION__;
        $master_url = 'transaction/nilai_fisik/';

        $this->load->library(array('form_validation', 'table'));
        $this->load->helper(array('form', 'snippets'));
        $this->form_validation->set_error_delimiters('<span class="notice">', '</span>');
		$is_valid=1;
		//echo $is_valid; return; exit;
		/*
		if($this->input->post('angkatan_id')<=0) {$is_valid=0;}
		//if($this->input->post('tahun_akademik_id_attr')=='') {$is_valid=0;}
		if($this->input->post('semester_id')<=0) {$is_valid=0;}
		if($this->input->post('program_studi')<=0) {$is_valid=0;}
		$mata_kuliah_id=(int)$this->input->post('mata_kuliah_id');
		if($mata_kuliah_id==0) {$is_valid=0;}
		*/
        if ($this->form_validation->run('nilai_fisik_create') === FALSE) {
            //don't do anything
        } else {
			if($is_valid==0){
			} else {
				$angkatan_id= $this->input->post('angkatan_id');
				$program_studi_id=$this->input->post('program_studi_id');
				$semester_id=$this->input->post('semester_id');
				$mata_kuliah_id=$this->input->post('mata_kuliah_id');
				$query = $this->db->query("select m.id as rencana_mata_pelajaran_pokok_id, d.mahasiswa_id, s.nim, s.nama as nama_mhs,
				d.id as rencana_mata_pelajaran_pokok_dtl_id, c.sks_mata_kuliah,
                a.id as nilai_kuliah_id, a.nilai_fisik
				from akademik_t_rencana_mata_pelajaran_pokok m					
				left join akademik_t_rencana_mata_pelajaran_pokok_detil d on m.id = d.rencana_mata_pelajaran_id and d.active=1
				left join akademik_m_mahasiswa s on  d.mahasiswa_id = s.id
				left join akademik_m_mata_kuliah c on m.mata_kuliah_id = c.id
				left join akademik_t_nilai_fisik a on m.id = a.rencana_mata_pelajaran_pokok_id and a.mahasiswa_id = s.id
				where m.angkatan_id = $angkatan_id and m.program_studi_id=$program_studi_id  
				and m.semester_id = $semester_id and m.mata_kuliah_id = $mata_kuliah_id");
				//echo '<pre>'.$this->db->last_query().'</pre>'; return;
				foreach($query->result_array() as $row){
					$nilai_fisik = $this->input->post('nilai_fisik_'.$row['rencana_mata_pelajaran_pokok_dtl_id']);
					$parm = array();
					$parm['nilai_fisik'] =  $nilai_fisik;
					if(count($parm)>0){
						if($row['nilai_kuliah_id']==''){
							$parm['mahasiswa_id'] = $row['mahasiswa_id'];
							$parm['rencana_mata_pelajaran_pokok_id'] = $row['rencana_mata_pelajaran_pokok_id'];
							$parm['created_on'] = date($this->config->item('log_date_format'));
							$parm['created_by'] = logged_info()->on;
							$this->db->insert('akademik_t_nilai_fisik',$parm);
						}else{
							$this->db->where('id',$row['nilai_kuliah_id']);
							$parm['modified_on'] = date($this->config->item('log_date_format'));
							$parm['modified_by'] = logged_info()->on;
							$this->db->update('akademik_t_nilai_fisik',$parm);
						}
						//echo '<pre>'; print_r($parm); echo '</pre>'; return;
					}
				}
				redirect('transaction/nilai_fisik/');
			}
        }
        $data['action_url'] = $master_url . __FUNCTION__;
        $data['page_title'] = 'Create Nilai Fisik';
        $data['tools'] = array(
            'transaction/nilai_fisik' => 'Back'
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
		$data['opt_data_mahasiswa_url'] = base_url() . 'transaction/select_data_form/getOptDataNilaiMahasiswaFisik';
        
        $this->load->view('transaction/nilai_fisik_form', $data);
    }
	
	function getMahasiswa(){
		$angkatan_id= $this->input->post('angkatan_id');
        $program_studi_id = $this->input->post('program_studi_id');
        $tahun_akademik_id = $this->input->post('tahun_akademik_id');
		$semester = $this->input->post('semester');
		$mode = $this->input->post('mode');
		if($mode=='') $mode ='edit';
		$query = $this->db->query("select a.id, a.nim, a.nama, a.angkatan_id , a.program_studi_id, b.nilai_fisik
			from akademik_m_mahasiswa a
			left join akademik_t_nilai_fisik b on a.id = b.mahasiswa_id and b.semester = $semester
			where a.angkatan_id = $angkatan_id and a.program_studi_id = $program_studi_id"); 
		//echo $this->db->last_query();
		$no =1;
		if($query->num_rows()<1){
			echo "<tr>";
            echo "<td colspan='4'>Tidak ada mahasiswa</td>";
			echo "</tr>";
		}else foreach($query->result_array() as $row){
			echo "<tr>";
            echo "<td>$no</td>";
            echo "<td>&nbsp;".$row['nim']."</td>";
            echo "<td>&nbsp;".$row['nama']."</td>";
			if($mode=='edit'){ 
				echo "<td>&nbsp;<input type='text' style='width:30px' name='nilai_fisik_".$row['id']."' value='".$row['nilai_fisik']."' /></td>";
            }else if($mode=='view'){
				echo "<td>&nbsp;".$row['nilai_fisik']."</td>";
			}
            echo "</tr>";
            $no++;
		}
	}
	
	function submit_nilai(){
		$angkatan_id= $this->input->post('angkatan_ids');
        $program_studi_id = $this->input->post('program_studi_ids');
        $tahun_akademik_id = $this->input->post('tahun_akademik_ids');
		$semester = $this->input->post('semester_ids');
		$query = $this->db->query("select a.id, a.nim, a.nama, a.angkatan_id , a.program_studi_id, b.nilai_fisik,  b.id as nilai_id 
			from akademik_m_mahasiswa a
			left join akademik_t_nilai_fisik b on a.id = b.mahasiswa_id and b.semester = $semester
			where a.angkatan_id = $angkatan_id and a.program_studi_id = $program_studi_id");
		foreach($query->result_array() as $row){
			$nilai = $this->input->post('nilai_fisik_'.$row['id']);
			if($nilai !=''){
				if($row['nilai_id']==""){
					$parm = array('mahasiswa_id'=>$row['id'], 'semester'=>$semester,'nilai_fisik'=>$nilai);
					$this->db->insert('akademik_t_nilai_fisik',$parm);
				}else{
					$this->db->where('id',$row['nilai_id']);
					$parm = array('nilai_fisik'=>$nilai);
					$this->db->update('akademik_t_nilai_fisik',$parm);
					
				}
				echo $this->db->last_query();
			}
		}
	}

    function edit() {
        $data['auth'] = $this->auth;
        $data['action_type'] = __FUNCTION__;
        $master_url = 'transaction/nilai_fisik/';
        $id = $this->uri->segment(3);

        $this->load->library(array('form_validation', 'table'));
        $this->load->helper(array('form', 'snippets'));
        $this->form_validation->set_error_delimiters('<span class="notice">', '</span>');
        if ($this->form_validation->run('nilai_fisik_update') === FALSE) {
            //don't do anything
        } else {
            $this->crud->use_table('t_nilai_fisik');
            $criteria = array(
                'id' => $id
            );
            $data_in = array(
                'mahasiswa_id' => $this->input->post('mahasiswa_id'),
                'nilai_fisik' => $this->input->post('nilai_fisik'),
                'keterangan' => $this->input->post('keterangan'),
                'modified_on' => date($this->config->item('log_date_format')),
                'modified_by' => logged_info()->on
            );
            $this->crud->update($criteria, $data_in);
            redirect('transaction/nilai_fisik/' . $id . '/info');
        }
        $data['action_url'] = $master_url . $id . '/' . __FUNCTION__;
        $data['page_title'] = 'Update Nilai Fisik';
        $data['tools'] = array(
            'transaction/nilai_fisik' => 'Back'
        );

        $this->crud->use_table('t_nilai_fisik');
        $nilai_fisik_data = $this->crud->retrieve(array('id' => $id))->row();

        $this->load->model('nilai_fisik_model', 'nilai_fisik');
        $data = array_merge($data, $this->nilai_fisik->set_default()); //merge dengan arr data dengan default
        $data = array_merge($data, (array) $nilai_fisik_data);
        $this->load->view('transaction/nilai_fisik_form', $data);
    }

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
