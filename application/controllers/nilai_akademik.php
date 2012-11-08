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
		$data['opt_tahun_akademik'] = $opt_tahun_akademik;
		$data['opt_mata_kuliah_url'] =  base_url() . 'transaction/nilai_akademik/getOptMataKuliah';
        $data['Mahasiswa_list_url'] =  base_url() . 'transaction/nilai_akademik/getMahasiswa';
		$data['opt_program_studi_url'] = base_url() . 'transaction/nilai_akademik/getOptProgramStudi';

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
        $master_url = 'transaction/nilai_akademik/';


        $this->load->library(array('form_validation', 'table'));
        $this->load->helper(array('form', 'snippets'));
        $this->form_validation->set_error_delimiters('<span class="notice">', '</span>');
        if ($this->form_validation->run('nilai_akademik_create') === FALSE) {
            //don't do anything
        } else {
            $this->crud->use_table('t_nilai_akademik');
            $data_in = array(
                'mahasiswa_id' => $this->input->post('mahasiswa_id'),
                'mata_kuliah_id' => $this->input->post('mata_kuliah_id'),
                'nilai_nts' => $this->input->post('nilai_nts'),
                'nilai_tgs' => $this->input->post('nilai_tgs'),
                'nilai_nas' => $this->input->post('nilai_nas'),
                'nilai_prb' => $this->input->post('nilai_prb'),
                'nilai_akhir' => $this->input->post('nilai_akhir'),
                'created_on' => date($this->config->item('log_date_format')),
                'created_by' => logged_info()->on
            );
            /*
              echo '<pre>';
              var_dump($data_in);
              echo '</pre>';
             */
            $created_id = $this->crud->create($data_in);
            redirect('transaction/nilai_akademik/' . $created_id . '/info');
        }
        $data['action_url'] = $master_url . __FUNCTION__;
        $data['page_title'] = 'Create Nilai Akademik';
        $data['tools'] = array(
            'transaction/nilai_akademik' => 'Back'
        );

        $this->load->model('nilai_akademik_model', 'nilai_akademik');
        $data = array_merge($data, $this->nilai_akademik->set_default()); //merge dengan arr data dengan default

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

        $this->crud->use_table('t_nilai_akademik');
        $nilai_akademik_data = $this->crud->retrieve(array('id' => $id))->row();

        $this->load->model('nilai_akademik_model', 'nilai_akademik');
        $data = array_merge($data, $this->nilai_akademik->set_default()); //merge dengan arr data dengan default
        $data = array_merge($data, (array) nilai_akademik);
        $this->load->view('transaction/nilai_akademik_form', $data);
    }

    function getOptProgramStudi() {
        //echo 'getOptProgramStudi';
        $tahun_akademik_id = $this->input->post('tahun_akademik_id');
        $angkatan_id= $this->input->post('angkatan_id');
        $query = $this->db->query("select a.id, a.nama_program_studi, a.kode_program_studi from akademik_m_program_studi a where a.active ='1' and a.angkatan_id='$angkatan_id';");
//        echo  $this->db->last_query();
        echo '<option value=\'\' > pilih</option>';
        foreach($query->result_array() as $row){
            echo '<option value=\''.$row['id'].'\' >'.$row['kode_program_studi'].'-'.$row['nama_program_studi'].'</option>';
        }
    }
    
    function getMataKuliah(){
        $tahun_akademik_id = $this->input->post('tahun_akademik_id');
        $angkatan_id= $this->input->post('angkatan_id');
        $program_studi_id = $this->input->post('program_studi_id');
        $query = $this->db->query("select a.id, a.kode_mata_kuliah, a.nama_mata_kuliah from akademik_m_mata_kuliah a where a.angkatan_id =$angkatan_id and program_studi_id= $program_studi_id");
        echo '<option value=\'\' > pilih</option>';
        foreach($query->result_array() as $row){
            echo '<option value=\''.$row['id'].'\' >'.$row['kode_mata_kuliah'].'-'.$row['nama_mata_kuliah'].'</option>';
        }
    }
    
    function getMahasiswa(){
        $angkatan_id= $this->input->post('angkatan_id');
        $program_studi_id = $this->input->post('program_studi_id');
        $mata_kuliah_id  = $this->input->post('mata_kuliah_id');
        $tahun_akademik_id = $this->input->post('tahun_akademik_id');
		$mode = $this->input->post('mode');
		if($mode=='') $mode ='edit';
        $query = $this->db->query("select a.id as rencana_mata_pelajaran_pokok_id, a.mahasiswa_id, c.nama as nama_mhs, c.nim, a.mata_kuliah_id, b.nilai_nts, b.nilai_tgs, b.nilai_nas, b.nilai_prb, b.nilai_prb, b.nilai_akhir 
            from akademik_t_rencana_mata_pelajaran_pokok a
            left join akademik_t_nilai_akademik b on a.id = b.rencana_mata_pelajaran_pokok_id
            left join akademik_m_mahasiswa c on a.mahasiswa_id = c.id where a.angkatan_id = $angkatan_id and a.program_studi_id and a.mata_kuliah_id = $mata_kuliah_id and a.tahun_akademik_id = $tahun_akademik_id");
        $no = 1;
        //for($i = 0; $i<10; $i++){
		if($query->num_rows()<1){
			echo "<tr>";
            echo "<td colspan='9'>Tidak ada mahasiswa yang mengambil mata kuliah ini</td>";
			echo "</tr>";
		}else foreach($query->result_array() as $row){
            //$row['rencana_mata_pelajaran_pokok_id'] = $no;
            //$row['nilai_akhir'] = '10';
            //$row['nilai_akhir_huruf'] = 'A';
            echo "<tr>";
            echo "<td>$no</td>";
            echo "<td>&nbsp;".$row['nim']."</td>";
            echo "<td>&nbsp;".$row['nama_mhs']."</td>";
			if($mode=='edit'){ 
				echo "<td>&nbsp;<input type='text' style='width:30px' name='nilai_nts_".$row['rencana_mata_pelajaran_pokok_id']."' value='".$row['nilai_nts']."' /></td>";
				echo "<td>&nbsp;<input type='text' style='width:30px' name='nilai_tgs_".$row['rencana_mata_pelajaran_pokok_id']."' value='".$row['nilai_tgs']."' /></td>";
				echo "<td>&nbsp;<input type='text' style='width:30px' name='nilai_nas_".$row['rencana_mata_pelajaran_pokok_id']."' value='".$row['nilai_nas']."' /></td>";
				echo "<td>&nbsp;<input type='text' style='width:30px' name='nilai_prb_".$row['rencana_mata_pelajaran_pokok_id']."' value='".$row['nilai_prb']."' /></td>";
            }else if($mode=='view'){
				echo "<td>&nbsp;".$row['nilai_nts']."</td>";
				echo "<td>".$row['nilai_tgs']."</td>";
				echo "<td>&nbsp;".$row['nilai_nas']."</td>";
				echo "<td>".$row['nilai_prb']."</td>";
				echo "<td>".$row['nilai_akhir']."</td>";
				echo "<td>".$this->NilaiHuruf($row['nilai_akhir'])."</td>";
			}
			
            echo "</tr>";
            $no++;
            //echo $row['mahasiswa_id'];
        }
    }
	
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
