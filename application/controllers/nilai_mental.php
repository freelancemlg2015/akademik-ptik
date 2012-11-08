<?php

/*
 * Indah
 * Transaksi :  nilai Mental
 * 9/9/2012
 */

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Nilai_mental extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->helper(array('snippets_helper'));
        $this->load->model('crud_model', 'crud');
    }

    function log_date() {
        return date($this->config->item('log_date_format'));
    }

    function index($query_id = 0, $sort_by = 'id', $sort_order = 'desc', $offset = 0) {
        $this->nilai_mental($query_id, $sort_by, $sort_order, $offset);
    }

    function nilai_mental($query_id = 0, $sort_by = 'id', $sort_order = 'desc', $offset = 0) {
        $data_type = $this->input->post('data_type');
        $data['auth'] = $this->auth;
        // pagination
        $limit = 20;
        $this->load->library(array('form_validation', 'table', 'pagination'));
        $this->input->load_query($query_id);
        $query_array = array(
            'nim' => $this->input->get('nim'),
            'nilai_mental' => $this->input->get('nilai_mental'),
            'active' => 1
        );

        $this->load->model('nilai_mental_model', 'nilai_mental');
        $results = $this->nilai_mental->search($query_array, $limit, $offset, $sort_by, $sort_order);
        //echo get_instance()->db->last_query();
        $data['results'] = $results['results'];
        $data['num_results'] = $results['num_rows'];

        // pagination
        $config = array();
        $config['base_url'] = site_url("transaction/nilai_mental/$query_id/$sort_by/$sort_order");
        $config['total_rows'] = $data['num_results'];
        $config['per_page'] = $limit;
        $config['uri_segment'] = 6;
        $config['num_links'] = 6;

        $config = array_merge($config, default_pagination_btn());
        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();
        $data['sort_by'] = $sort_by;
        $data['sort_order'] = $sort_order;

        $data['page_title'] = 'Nilai Mental';

        $data['tools'] = array(
            'transaction/nilai_mental/create' => 'New'
        );
		
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
        $this->load->model('nilai_fisik_model', 'nilai_fisik');
        $data = array_merge($data, $this->nilai_fisik->set_default()); //merge dengan arr data dengan default
        $data['opt_tahun_akademik'] = $opt_tahun_akademik;
		$data['opt_program_studi_url'] = base_url() . 'transaction/nilai_akademik/getOptProgramStudi';
		$data['Mahasiswa_list_url'] =  base_url() . 'transaction/nilai_mental/getMahasiswa';
		$data['submit_url'] =  base_url() . 'transaction/nilai_mental/submit_nilai';

        $this->load->view('transaction/nilai_mental', $data);
    }

    function search() {
        $query_array = array(
            'mahasiswa_id' => $this->input->post('mahasiswa_id'),
            'nilai_mental' => $this->input->post('nilai_mental'),
            'active' => 1
        );
        $query_id = $this->input->save_query($query_array);
        redirect("transaction/nilai_mental/view/$query_id");
    }

    function info() {
        $id = $this->uri->segment(3);
        $data['auth'] = $this->auth;
        $criteria = array(
            't_nilai_mental.id' => $id
        );
        $this->load->model('nilai_mental_model', 'nilai_mental');
        $result = $this->nilai_mental->get_many('', $criteria)->row_array();
        //[debug]echo get_instance()->db->last_query();
        $result_keys = array_keys($result);
        foreach ($result_keys as $result_key) {
            $data[$result_key] = $result[$result_key];
        }

        $data['tools'] = array(
            'transaction/nilai_mental' => 'Back',
            'transaction/nilai_mental/' . $id . '/edit' => 'Edit',
            'transaction/nilai_mental/' . $id . '/delete' => 'Delete'
        );
        $data['page_title'] = 'Detail nilai_mental';
        $this->load->view('transaction/nilai_mental_info', $data);
    }

    function delete() {
        $id = $this->uri->segment(3);
        $this->crud->use_table('t_nilai_mental');
        $criteria = array('id' => $id);
        $data_in = array(
            'active' => 0,
            'modified_on' => logged_info()->on,
            'modified_by' => logged_info()->by
        );
        $this->crud->update($criteria, $data_in);
        redirect('transaction/nilai_mental');
    }

    function create() {
        $data['auth'] = $this->auth;
        $data['action_type'] = __FUNCTION__;
        $master_url = 'transaction/nilai_mental/';

        $this->load->library(array('form_validation', 'table'));
        $this->load->helper(array('form', 'snippets'));
        $this->form_validation->set_error_delimiters('<span class="notice">', '</span>');
        if ($this->form_validation->run('nilai_mental_create') === FALSE) {
            //don't do anything
        } else {
            $this->crud->use_table('t_nilai_mental');
            $data_in = array(
                'mahasiswa_id' => $this->input->post('mahasiswa_id'),
                'nilai_mental' => $this->input->post('nilai_mental'),
                'keterangan' => $this->input->post('keterangan'),
                'created_on' => date($this->config->item('log_date_format')),
                'created_by' => logged_info()->on
            );
            /*
              echo '<pre>';
              var_dump($data_in);
              echo '</pre>';
             */
            $created_id = $this->crud->create($data_in);
            redirect('transaction/nilai_mental/' . $created_id . '/info');
        }
        $data['action_url'] = $master_url . __FUNCTION__;
        $data['page_title'] = 'Create Nilai Mental';
        $data['tools'] = array(
            'transaction/nilai_mental' => 'Back'
        );

        $this->load->model('nilai_mental_model', 'nilai_mental');
        $data = array_merge($data, $this->nilai_mental->set_default()); //merge dengan arr data dengan default
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
        $this->load->model('nilai_fisik_model', 'nilai_fisik');
        $data = array_merge($data, $this->nilai_fisik->set_default()); //merge dengan arr data dengan default
        $data['opt_tahun_akademik'] = $opt_tahun_akademik;
		$data['opt_program_studi_url'] = base_url() . 'transaction/nilai_akademik/getOptProgramStudi';
		$data['Mahasiswa_list_url'] =  base_url() . 'transaction/nilai_mental/getMahasiswa';
		$data['submit_url'] =  base_url() . 'transaction/nilai_mental/submit_nilai';
        $data['nim']              = '';
        
        $this->load->view('transaction/nilai_mental_form', $data);
    }
	
	function getMahasiswa(){
		$angkatan_id= $this->input->post('angkatan_id');
        $program_studi_id = $this->input->post('program_studi_id');
        $tahun_akademik_id = $this->input->post('tahun_akademik_id');
		$semester = $this->input->post('semester');
		$mode = $this->input->post('mode');
		if($mode=='') $mode ='edit';
		$query = $this->db->query("select a.id, a.nim, a.nama, a.angkatan_id , a.program_studi_id, b.nilai_mental , b.id as nilai_id 
			from akademik_m_mahasiswa a left join akademik_t_nilai_mental b on a.id = b.mahasiswa_id and b.semester = $semester
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
				echo "<td>&nbsp;<input type='text' style='width:30px' name='nilai_mental_".$row['id']."' value='".$row['nilai_mental']."' /></td>";
            }else if($mode=='view'){
				echo "<td>&nbsp;".$row['nilai_mental']."</td>";
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
		$query = $this->db->query("select a.id, a.nim, a.nama, a.angkatan_id , a.program_studi_id, b.nilai_mental,  b.id as nilai_id 
			from akademik_m_mahasiswa a
			left join akademik_t_nilai_mental b on a.id = b.mahasiswa_id and b.semester = $semester
			where a.angkatan_id = $angkatan_id and a.program_studi_id = $program_studi_id");
		foreach($query->result_array() as $row){
			$nilai = $this->input->post('nilai_mental_'.$row['id']);
			if($nilai !=''){
				if($row['nilai_id']==""){
					$parm = array('mahasiswa_id'=>$row['id'], 'semester'=>$semester,'nilai_mental'=>$nilai);
					$this->db->insert('akademik_t_nilai_mental',$parm);
				}else{
					$this->db->where('id',$row['nilai_id']);
					$parm = array('nilai_fisik'=>$nilai);
					$this->db->update('akademik_t_nilai_mental',$parm);
					
				}
				echo $this->db->last_query();
			}
		}
	}

    function edit() {
        $data['auth'] = $this->auth;
        $data['action_type'] = __FUNCTION__;
        $master_url = 'transaction/nilai_mental/';
        $id = $this->uri->segment(3);

        $this->load->library(array('form_validation', 'table'));
        $this->load->helper(array('form', 'snippets'));
        $this->form_validation->set_error_delimiters('<span class="notice">', '</span>');
        if ($this->form_validation->run('nilai_mental_update') === FALSE) {
            //don't do anything
        } else {
            $this->crud->use_table('t_nilai_mental');
            $criteria = array(
                'id' => $id
            );
            $data_in = array(
                'mahasiswa_id' => $this->input->post('mahasiswa_id'),
                'nilai_mental' => $this->input->post('nilai_mental'),
                'modified_on' => date($this->config->item('log_date_format')),
                'modified_by' => logged_info()->on
            );
            $this->crud->update($criteria, $data_in);
            redirect('transaction/nilai_mental/' . $id . '/info');
        }
        $data['action_url'] = $master_url . $id . '/' . __FUNCTION__;
        $data['page_title'] = 'Update Nilai Mental';
        $data['tools'] = array(
            'transaction/nilai_mental' => 'Back'
        );

        $this->crud->use_table('t_nilai_mental');
        $nilai_mental_data = $this->crud->retrieve(array('id' => $id))->row();

        $this->load->model('nilai_mental_model', 'nilai_mental');
        $data = array_merge($data, $this->nilai_mental->set_default()); //merge dengan arr data dengan default
        $data = array_merge($data, (array) $nilai_mental_data);
        $this->load->view('transaction/nilai_mental_form', $data);
    }

    function unique_nilai_mental($nilai_mental) {
        $this->crud->use_table('t_nilai_mental');
        $nilai_mental = $this->crud->retrieve(array('nilai_mental' => $nilai_mental))->row();
        if (sizeof($nilai_mental) > 0) {
            $this->form_validation->set_message(__FUNCTION__, 'Nilai Mental sudah terdaftar'); //pakai function karena ini harus sama dengan nama function nya
            return FALSE;
        } else {
            return true;
        }
    }

}

?>
