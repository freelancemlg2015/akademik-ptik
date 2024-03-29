<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Select_data_form extends CI_Controller {

    function __construct() {
		parent::__construct();
        $this->load->helper(array('snippets_helper'));
        //$this->load->model('crud_model', 'crud');
		$this->load->model('select_data_form_model', 'select_data_form');
    }
	
	function index($query_id = 0, $sort_by = 'id', $sort_order = 'desc', $offset = 0) {
        $this->select_data_form($query_id, $sort_by, $sort_order, $offset);
    }

    function select_data_form($query_id = 0, $sort_by = 'id', $sort_order = 'desc', $offset = 0) {
        exit('No direct script access allowed');
    }

	function getOptAngkatan() {
        $angkatan_id= $this->input->post('angkatan_id');
		$data_results = $this->select_data_form->getOptAngkatan($angkatan_id);
		/*
		$sql = "select a.tahun_ajar_mulai, a.tahun_ajar_akhir from akademik_m_tahun_akademik a ".
				" left join akademik_m_angkatan b on b.tahun_akademik_id=a.id ".
				"where a.active ='1' and b.id='$angkatan_id'";
        $query = $this->db->query($sql);
		*/
		//echo  '<pre>'.$this->db->last_query().'</pre><br>';
        foreach($data_results->result_array() as $row){
            echo $row['tahun_ajar_mulai'].'-'.$row['tahun_ajar_akhir'];
        }
    }
	
	function getOptSemester() {
        $angkatan_id= $this->input->post('angkatan_id');		
		$data_results = $this->select_data_form->getOptSemester($angkatan_id);
		/*
		$sql = "select b.semester_id, b.nama_semester
				from akademik_view_paket_plot_mata_kuliah b
				where b.angkatan_id=$angkatan_id
				group by semester_id";
        $query = $this->db->query($sql);
		*/
        //echo  '<pre>'.$this->db->last_query().'</pre><br>';
        echo '<option value=\'0\'></option>';
        foreach($data_results->result_array() as $row){
			echo '<option value=\''.$row['semester_id'].'\' >'.$row['nama_semester'].'</option>';
        }
    }
	
	function getOptProgramStudi() {
        $angkatan_id= $this->input->post('angkatan_id');
		$semester_id= $this->input->post('semester_id');
		$data_results = $this->select_data_form->getOptProgramStudi($angkatan_id, $semester_id);
		/*
		$sql = "select b.program_studi_id, b.nama_program_studi
				from akademik_view_paket_plot_mata_kuliah b
				where b.angkatan_id=$angkatan_id and b.semester_id=$semester_id
				group by program_studi_id";
        $query = $this->db->query($sql);
		*/
        //echo  '<pre>'.$this->db->last_query().'</pre><br>';
        echo '<option value=\'0\'></option>';
        foreach($data_results->result_array() as $row){
            echo '<option value=\''.$row['program_studi_id'].'\' >'.$row['nama_program_studi'].'</option>';
        }
    }
	
	function getOptMataKuliah() {
        //$tahun_akademik_id = $this->input->post('tahun_akademik_id');
        $angkatan_id= $this->input->post('angkatan_id');
        $program_studi_id = $this->input->post('program_studi_id');
		$semester_id=$this->input->post('semester_id');
		$jenis_nilai=(int)$this->input->post('jenis_nilai');
		$data_results = $this->select_data_form->getOptMataKuliah($angkatan_id, $semester_id, $program_studi_id, $jenis_nilai);
		/*
		$sql = "select b.mata_kuliah_id, b.nama_mata_kuliah
				from akademik_view_paket_plot_mata_kuliah_detail b
				where b.angkatan_id=$angkatan_id and b.semester_id=$semester_id and b.program_studi_id=$program_studi_id
				group by mata_kuliah_id";//group by d.id
		$query = $this->db->query($sql);
		//echo '<pre>'.$this->db->last_query().'</pre>'; //return;
		*/
        echo '<option value=\'0\'></option>';
        foreach($data_results->result_array() as $row){
            echo '<option value=\''.$row['mata_kuliah_id'].'\' >'.$row['nama_mata_kuliah'].'</option>';
        }
    }
	
	function getOptDataJadwal() {
        //$tahun_akademik_id = $this->input->post('tahun_akademik_id');
        $angkatan_id= $this->input->post('angkatan_id');
        $program_studi_id = $this->input->post('program_studi_id');
		$mata_kuliah_id=$this->input->post('mata_kuliah_id');
		$semester_id=$this->input->post('semester_id');
		/*
		$sql = "select a.id, a.pertemuan_ke, a.pertemuan_dari, a.tanggal from akademik_t_jadwal_kuliah a ".
				"where a.angkatan_id=$angkatan_id and a.program_studi_id= $program_studi_id
				and a.mata_kuliah_id=$mata_kuliah_id and a.semester_id=$semester_id ";
        $query = $this->db->query($sql);
		*/
		$data_results = $this->select_data_form->getOptDataJadwal($angkatan_id, $semester_id, $program_studi_id, $mata_kuliah_id);
        echo '<option value=\'\' > pilih</option>';
        foreach($data_results->result_array() as $row){
            echo '<option value=\''.$row['id'].'\' >'.$row['pertemuan_ke'].'-'.$row['pertemuan_dari'].' ('.$row['tanggal'].')'.'</option>';
        }
    }
	
	function getOptDataMahasiswaForm() {
		
		$angkatan_id= $this->input->post('angkatan_id');
		$jadwal_kuliah_id=$this->input->post('pertemuan_id');
		$program_studi_id=$this->input->post('program_studi_id');
		$mata_kuliah_id=$this->input->post('mata_kuliah_id');
		$semester_id=$this->input->post('semester_id');
		$mode = $this->input->post('mode');
		if($mode=='') $mode ='edit';
		$data_results = $this->select_data_form->getOptDataMahasiswaForm($angkatan_id, $semester_id, $program_studi_id, $mata_kuliah_id, $jadwal_kuliah_id);
		/*
		$query = $this->db->query("select m.rencana_mata_pelajaran_id, m.mahasiswa_id, s.nim, s.nama as nama_mhs, j.id as jadwal_kuliah_id,
				j.pertemuan_ke, m.rencana_mata_pelajaran_pokok_id, 
				k.absensi as ket_absensi, a.absensi_id, a.mahasiswa_id as akademik_t_absensi_mhs_id
				from akademik_view_paket_plot_mata_kuliah_mahasiswa m
				left join akademik_m_mahasiswa s on m.mahasiswa_id = s.id
				left join akademik_t_jadwal_kuliah j on j.id=$jadwal_kuliah_id
				left join akademik_t_absensi_mhs a on j.id = a.jadwal_kuliah_id  and a.mahasiswa_id = m.mahasiswa_id
				left join akademik_m_absensi k on a.absensi_id = k.id
				where m.angkatan_id = $angkatan_id and m.program_studi_id=$program_studi_id
				and m.semester_id = $semester_id and m.mata_kuliah_id = $mata_kuliah_id");
		*/
		//echo '<pre>'.$this->db->last_query().'</pre>'; //return;
		$no = 1;
		if($data_results->num_rows()<1){
			echo "<tr>";
            echo "<td colspan='4'>Tidak ada mahasiswa yang mengambil mata kuliah ini</td>";
			echo "</tr>";
		} else {
			if($mode=='edit'){ 
			$this->crud->use_table('m_absensi');
			$order_bys = array( "absensi"=>"asc");
			$status_hadir_options=array();
			$data_tbl_absen = $this->crud->retrieve('','*',0,0,$order_bys)->result();
			foreach ($data_tbl_absen as $row) {
				$status_hadir_options[$row->id] = $row->absensi;
			}
			}
			foreach($data_results->result_array() as $row){
				echo "<tr>";
				echo "<td>$no</td>";
				echo "<td>&nbsp;".$row['nim']."</td>";
				echo "<td>&nbsp;".$row['nama_mhs']."</td>";
				$nilai_hadir = 0;
				if($row['jadwal_kuliah_id'] !='') $nilai_hadir=$row['absensi_id'];
				if($mode=='edit'){ 
					echo '<td>'.form_dropdown('nilai_nts_'.$row['rencana_mata_pelajaran_pokok_id'], $status_hadir_options, set_value('nilai_nts_'.$row['rencana_mata_pelajaran_pokok_id'], $nilai_hadir), 'id="nilai_nts_'.$row['rencana_mata_pelajaran_pokok_id'].'" class="input-medium" prevData-selected="' . set_value('nilai_nts_'.$row['rencana_mata_pelajaran_pokok_id'].'', $nilai_hadir) . '"')
					.'</td>';
				}else if($mode=='view'){
					$nilai_hadir='';
					if($row['rencana_mata_pelajaran_pokok_id']>0) $nilai_hadir=$row['ket_absensi'];
					echo "<td>&nbsp;".$nilai_hadir."</td>";
				}
				
				echo "</tr>";
				$no++;
				//echo $row['mahasiswa_id'];
			}
			if($mode!='view'){ 
				echo '<tr id="btn-save"><td colspan="4" class="form-actions well">&nbsp;<button class="btn btn-small btn-primary" type="submit">Simpan</button></td></tr>';
			}
        }
	}

	function getOptDataDosenForm() {
		$angkatan_id= $this->input->post('angkatan_id');
		//$tahun_akademik_id = $this->input->post('tahun_akademik_id');
		$jadwal_kuliah_id=$this->input->post('pertemuan_id');
		$program_studi_id=$this->input->post('program_studi_id');
		$mata_kuliah_id=$this->input->post('mata_kuliah_id');
		$semester_id=$this->input->post('semester_id');
		$mode = $this->input->post('mode');
		if($mode=='') $mode ='edit';
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
		$data_results = $this->select_data_form->getOptDataDosenForm($angkatan_id, $semester_id, $program_studi_id, $mata_kuliah_id, $jadwal_kuliah_id);
		//echo '<pre>'.$this->db->last_query().'</pre>'; //return;
		$no = 1;
        //for($i = 0; $i<10; $i++){
		if($data_results->num_rows()<1){
			echo "<tr>";
            echo "<td colspan='4'>Tidak ada jadwal mata kuliah ini</td>";
			echo "</tr>";
		} else {
			if($mode=='edit'){ 
				$this->crud->use_table('m_absensi');
				$order_bys = array( "absensi"=>"asc");
				$status_hadir_options=array();
				$data_tbl_absen = $this->crud->retrieve('','*',0,0,$order_bys)->result();
				foreach ($data_tbl_absen as $row) {
					$status_hadir_options[$row->id] = $row->absensi;
				}
			}
			foreach($data_results->result_array() as $row){
				echo "<tr>";
				echo "<td>$no</td>";
				echo "<td>&nbsp;".$row['nim']."</td>";
				echo "<td>&nbsp;".$row['nama_mhs']."</td>";
				$nilai_hadir = 0;
				if($row['jadwal_kuliah_id'] !='') $nilai_hadir=$row['absensi_id'];
				if($mode=='edit'){ 
					echo '<td>'.form_dropdown('nilai_nts_'.$row['rencana_mata_pelajaran_pokok_id'], $status_hadir_options, set_value('nilai_nts_'.$row['rencana_mata_pelajaran_pokok_id'], $nilai_hadir), 'id="nilai_nts_'.$row['rencana_mata_pelajaran_pokok_id'].'" class="input-medium" prevData-selected="' . set_value('nilai_nts_'.$row['rencana_mata_pelajaran_pokok_id'].'', $nilai_hadir) . '"')
					.'</td>';
				}else if($mode=='view'){
					$nilai_hadir='';
					if($row['rencana_mata_pelajaran_pokok_id']>0) $nilai_hadir=$row['ket_absensi'];
					echo "<td>&nbsp;".$nilai_hadir."</td>";
				}
				echo "</tr>";
				$no++;
				//echo $row['mahasiswa_id'];
			}
			if($mode!='view'){ 
				echo '<tr id="btn-save"><td colspan="4" class="form-actions well">&nbsp;<button class="btn btn-small btn-primary" type="submit">Simpan</button></td></tr>';
			}
        }
	}
	
	function getOptDataJadwalUjian() {
        //$tahun_akademik_id = $this->input->post('tahun_akademik_id');
        $angkatan_id= $this->input->post('angkatan_id');
        $program_studi_id = $this->input->post('program_studi_id');
		$mata_kuliah_id=$this->input->post('mata_kuliah_id');
		$semester_id=$this->input->post('semester_id');
		
		$sql = 'select a.id, a.tanggal, b.kode_ujian as jenis_ujian_id from akademik_t_jadwal_ujian a '.
				'left join akademik_m_jenis_ujian b on b.id=a.jenis_ujian_id '.
				"where a.angkatan_id=$angkatan_id and a.program_studi_id= $program_studi_id
				and a.mata_kuliah_id=$mata_kuliah_id and a.semester_id=$semester_id ".
				'order by a.tanggal asc';
        $query = $this->db->query($sql);
        echo '<option value=\'\' > pilih</option>';
        foreach($query->result_array() as $row){
            echo '<option value=\''.$row['id'].'\' >'.$row['jenis_ujian_id'].' ('.$row['tanggal'].')'.'</option>';
        }
    }
	
	
	function getOptDataNilaiMahasiswaAkademik() {
		$angkatan_id= $this->input->post('angkatan_id');
		$program_studi_id=$this->input->post('program_studi_id');
		$mata_kuliah_id=$this->input->post('mata_kuliah_id');
		$semester_id=$this->input->post('semester_id');
		$mode = $this->input->post('mode');
		if($mode=='') $mode ='edit';
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
				//echo '<pre>'.$this->db->last_query().'</pre>'; //return;
		$no = 1;
        //for($i = 0; $i<10; $i++){
		if($query->num_rows()<1){
			echo "<tr>";
            echo "<td colspan='4'>Tidak ada mahasiswa yang mengambil mata kuliah ini</td>";
			echo "</tr>";
		} else {
			/*
			foreach($query->result_array() as $row){
				$nilai_nts = $this->input->post('nilai_nts_'.$row['rencana_mata_pelajaran_pokok_id']);
				$parm = array();
				if($nilai_nts !='') $parm['nilai_nts'] = $nilai_nts;
			}
			*/
			foreach($query->result_array() as $row){
				//$row['rencana_mata_pelajaran_pokok_id'] = $no;
				//$row['nilai_akhir'] = '10';
				//$row['nilai_akhir_huruf'] = 'A';
				echo "<tr id='".$row['nilai_kuliah_id']."'>";
				echo "<td>$no</td>";
				echo "<td>&nbsp;".$row['nim']."</td>";
				echo "<td>&nbsp;".$row['nama_mhs']."</td>";
				$nilai_hadir = 0;
				//if($row['nilai_kuliah_id'] !='') $nilai_hadir=$row['absensi_id'];
				if($mode=='edit'){ 
					echo "<td>&nbsp;<input type='text' style='width:30px' autocomplete='off' name='nilai_nts_".$row['rencana_mata_pelajaran_pokok_dtl_id']."' value='".$row['nilai_nts']."' />";
					echo "<td>&nbsp;<input type='text' style='width:30px' autocomplete='off' name='nilai_tgs_".$row['rencana_mata_pelajaran_pokok_dtl_id']."' value='".$row['nilai_tgs']."' />";
					echo "<td>&nbsp;<input type='text' style='width:30px' autocomplete='off' name='nilai_nas_".$row['rencana_mata_pelajaran_pokok_dtl_id']."' value='".$row['nilai_nas']."' />";
					echo "<td>&nbsp;<input type='text' style='width:30px' autocomplete='off' name='nilai_prb_".$row['rencana_mata_pelajaran_pokok_dtl_id']."' value='".$row['nilai_prb']."' />";
					echo "</td>";
				} else {
					$nilai_akhir=0;
					$nilai_akhir=$row['nilai_akhir'];
					if($nilai_akhir==0){
						$str_nilai = '&nbsp;';
					}elseif($nilai_akhir > 90){
						$str_nilai = 'A';
					}elseif($nilai_akhir > 80 && $nilai_akhir <= 90 ){
						$str_nilai = 'B+';
					}elseif($nilai_akhir > 75 && $nilai_akhir <= 80 ){
						$str_nilai = 'B';
					}elseif($nilai_akhir > 70 && $nilai_akhir <= 75 ){
						$str_nilai = 'B-';
					}elseif($nilai_akhir > 60 && $nilai_akhir <= 70 ){
						$str_nilai = 'C+';
					}else{
						$str_nilai= 'E';
					}
					//$nilai_akhirs=$this->NilaiHuruf($nilai_akhir);
					echo "<td>&nbsp;".$row['nilai_nts']."</td>";
					echo "<td>&nbsp;".$row['nilai_tgs']."</td>";
					echo "<td>&nbsp;".$row['nilai_nas']."</td>";
					echo "<td>&nbsp;".$row['nilai_prb']."</td>";
					echo "<td>&nbsp;".$nilai_akhir."</td>";
					echo "<td>&nbsp;".$str_nilai."</td>";
				}
				echo "</tr>";
				$no++;
				//echo $row['mahasiswa_id'];
			}
			if($mode!='view'){ 
				echo '<tr id="btn-save"><td colspan="7" class="form-actions well">&nbsp;<button class="btn btn-small btn-primary" type="submit">Simpan</button></td></tr>';
			}
        }
	}
	
	function NilaiHuruf($nilai){
		$str_nilai = '';
		//if($nilai='') { $str_nilai= '&nbsp;' } else {$str_nilai= 'E';}
			/*} elseif($nilai>90) {$str_nilai= 'A';
			} elseif($nilai>80) {$str_nilai= 'B+';
			} elseif($nilai>75) {$str_nilai= 'B';
			} elseif($nilai>70) {$str_nilai= 'B-';
			} elseif($nilai>60) {$str_nilai= 'C+';
			} elseif($nilai>55) {$str_nilai= 'C';
			} elseif($nilai>50) {$str_nilai= 'C-';
			} elseif($nilai>40) {$str_nilai= 'D';*/
		if($nilai=0){
			$str_nilai = '&nbsp;';
		}elseif($nilai >= 90 && $nilai <= 81){
			$str_nilai = 'A';
		/*}elseif($n >= 101 && $n <= 999){
			$i = $n % 100;
			$hasil = $iromawi[$n-$i] . Romawi($n % 100);*/
		}else{
			$str_nilai= 'E';
		}
		return $str_nilai;
	}
	
	function getOptDataNilaiMahasiswaKode() {
		$angkatan_id= $this->input->post('angkatan_id');
		$program_studi_id=$this->input->post('program_studi_id');
		$mata_kuliah_id=$this->input->post('mata_kuliah_id');
		$semester_id=$this->input->post('semester_id');
		$mode = $this->input->post('mode');
		if($mode=='') $mode ='edit';
		$query = $this->db->query("select m.id as rencana_mata_pelajaran_pokok_id, d.mahasiswa_id, s.nim, s.nama as nama_mhs,
				d.id as rencana_mata_pelajaran_pokok_dtl_id, c.sks_mata_kuliah,
                a.id as nilai_kuliah_id, a.nilai_mental
				from akademik_t_rencana_mata_pelajaran_pokok m					
				left join akademik_t_rencana_mata_pelajaran_pokok_detil d on m.id = d.rencana_mata_pelajaran_id and d.active=1
				left join akademik_m_mahasiswa s on  d.mahasiswa_id = s.id
				left join akademik_m_mata_kuliah c on m.mata_kuliah_id = c.id
				left join akademik_t_nilai_mental a on m.id = a.rencana_mata_pelajaran_pokok_id and a.mahasiswa_id = s.id
				where m.angkatan_id = $angkatan_id and m.program_studi_id=$program_studi_id  
				and m.semester_id = $semester_id and m.mata_kuliah_id = $mata_kuliah_id");
				//echo '<pre>'.$this->db->last_query().'</pre>'; //return;
		$no = 1;
        //for($i = 0; $i<10; $i++){
		if($query->num_rows()<1){
			echo "<tr>";
            echo "<td colspan='4'>Tidak ada mahasiswa yang mengambil mata kuliah ini</td>";
			echo "</tr>";
		} else {
			foreach($query->result_array() as $row){
				//$row['rencana_mata_pelajaran_pokok_id'] = $no;
				//$row['nilai_akhir'] = '10';
				//$row['nilai_akhir_huruf'] = 'A';
				echo "<tr id='".$row['nilai_kuliah_id']."'>";
				echo "<td>$no</td>";
				echo "<td>&nbsp;".$row['nim']."</td>";
				echo "<td>&nbsp;".$row['nama_mhs']."</td>";
				$nilai_hadir = 0;
				//if($row['nilai_kuliah_id'] !='') $nilai_hadir=$row['absensi_id'];
				if($mode=='edit'){ 
					echo "<td>&nbsp;<input type='text' style='width:30px' autocomplete='off' name='nilai_mental_".$row['rencana_mata_pelajaran_pokok_dtl_id']."' value='".$row['nilai_mental']."' />";
				} else {
					echo "<td>&nbsp;".$row['nilai_mental']."</td>";
				}
				echo "</tr>";
				$no++;
				//echo $row['mahasiswa_id'];
			}
			if($mode!='view'){ 
				echo '<tr id="btn-save">
				<td colspan="7" class="form-actions well">
				&nbsp;<button class="btn btn-small btn-primary" type="button" onclick="auto_generate_kode_ujian_mahasiswa()">Auto</button>
				&nbsp;<button class="btn btn-small btn-primary" type="submit">Simpan</button></td></tr>';
			}
        }
	}
	
	function auto_generate_kode_ujian_mahasiswa() {
		$angkatan_id= $this->input->post('angkatan_id');
		$program_studi_id=$this->input->post('program_studi_id');
		$mata_kuliah_id=$this->input->post('mata_kuliah_id');
		$semester_id=$this->input->post('semester_id');
		$mode = $this->input->post('mode');
		if($mode=='') $mode ='edit';
		$query = $this->db->query("select m.id as rencana_mata_pelajaran_pokok_id, d.mahasiswa_id, s.nim, s.nama as nama_mhs,
				d.id as rencana_mata_pelajaran_pokok_dtl_id, c.sks_mata_kuliah, d.kode_ujian_mahasiswa
				from akademik_t_rencana_mata_pelajaran_pokok m					
				left join akademik_t_rencana_mata_pelajaran_pokok_detil d on m.id = d.rencana_mata_pelajaran_id and d.active=1
				left join akademik_m_mahasiswa s on  d.mahasiswa_id = s.id
				left join akademik_m_mata_kuliah c on m.mata_kuliah_id = c.id
				where m.angkatan_id = $angkatan_id and m.program_studi_id=$program_studi_id  
				and m.semester_id = $semester_id and m.mata_kuliah_id = $mata_kuliah_id");
				//echo '<pre>'.$this->db->last_query().'</pre>'; //return;
		$no = 1;
        //for($i = 0; $i<10; $i++){
		if($query->num_rows()<1){
			echo "<tr>";
            echo "<td colspan='4'>Tidak ada mahasiswa yang mengambil mata kuliah ini</td>";
			echo "</tr>";
		} else {
			$arr_kode_ujian_mahasiswa = array();
			foreach($query->result_array() as $row){
				$mahasiswa_no_ujian=$row['kode_ujian_mahasiswa'];
				if($mahasiswa_no_ujian<=0) {
					$mahasiswa_no_ujian = $this->get_kode_ujian_mahasiswa($arr_kode_ujian_mahasiswa);
				}
				$arr_kode_ujian_mahasiswa[] = $mahasiswa_no_ujian;
				echo "<tr>";
				echo "<td>$no</td>";
				echo "<td>&nbsp;".$row['nim']."</td>";
				echo "<td>&nbsp;".$row['nama_mhs']."</td>";
				if($mode=='edit'){ 
					echo "<td>&nbsp;<input type='text' style='width:30px' readonly autocomplete='off' name='kode_ujian_mahasiswa_".$row['rencana_mata_pelajaran_pokok_dtl_id']."' value='".$mahasiswa_no_ujian."' />";
				} else {
					echo "<td>&nbsp;".$row['kode_ujian_mahasiswa']."</td>";
				}
				echo "</tr>";
				$no++;
			}
			//print_r(array_count_values($arr_kode_ujian_mahasiswa));
			if($mode!='view'){ 
				//&nbsp;<button class="btn btn-small btn-primary" type="button" onclick="auto_generate_kode_ujian_mahasiswa()">Auto</button>
				echo '<tr id="btn-save">
				<td colspan="7" class="form-actions well">
				
				&nbsp;<button class="btn btn-small btn-primary" type="submit">Simpan</button></td></tr>';
			}
        }
	}
	
	function get_kode_ujian_mahasiswa($arr_kode_ujian_mahasiswa)
	{
		$status = FALSE;
		$nilai = 0;
		do {
			$nilai = rand(1, 1000);
			$arr_new = $arr_kode_ujian_mahasiswa;
			$arr_new [] = $nilai;
			if(count(array_unique($arr_new))<count($arr_new))
			{
				$status = FALSE;
			} else {
				$status = TRUE; break;
			}
		} while ($status);
		return $nilai;
	}
	
	function getOptDataNilaiMahasiswaFisik() {
		$angkatan_id= $this->input->post('angkatan_id');
		$program_studi_id=$this->input->post('program_studi_id');
		$mata_kuliah_id=$this->input->post('mata_kuliah_id');
		$semester_id=$this->input->post('semester_id');
		$mode = $this->input->post('mode');
		if($mode=='') $mode ='edit';
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
				//echo '<pre>'.$this->db->last_query().'</pre>'; //return;
		$no = 1;
        //for($i = 0; $i<10; $i++){
		if($query->num_rows()<1){
			echo "<tr>";
            echo "<td colspan='4'>Tidak ada mahasiswa yang mengambil mata kuliah ini</td>";
			echo "</tr>";
		} else {
			foreach($query->result_array() as $row){
				//$row['rencana_mata_pelajaran_pokok_id'] = $no;
				//$row['nilai_akhir'] = '10';
				//$row['nilai_akhir_huruf'] = 'A';
				echo "<tr id='".$row['nilai_kuliah_id']."'>";
				echo "<td>$no</td>";
				echo "<td>&nbsp;".$row['nim']."</td>";
				echo "<td>&nbsp;".$row['nama_mhs']."</td>";
				$nilai_hadir = 0;
				//if($row['nilai_kuliah_id'] !='') $nilai_hadir=$row['absensi_id'];
				if($mode=='edit'){ 
					echo "<td>&nbsp;<input type='text' style='width:30px' autocomplete='off' name='nilai_fisik_".$row['rencana_mata_pelajaran_pokok_dtl_id']."' value='".$row['nilai_fisik']."' />";
				} else {
					echo "<td>&nbsp;".$row['nilai_fisik']."</td>";
				}
				echo "</tr>";
				$no++;
				//echo $row['mahasiswa_id'];
			}
			if($mode!='view'){ 
				echo '<tr id="btn-save"><td colspan="7" class="form-actions well">&nbsp;<button class="btn btn-small btn-primary" type="submit">Simpan</button></td></tr>';
			}
        }
	}
	
	function getOptDataNilaiMahasiswaMental() {
		$angkatan_id= $this->input->post('angkatan_id');
		$program_studi_id=$this->input->post('program_studi_id');
		$mata_kuliah_id=$this->input->post('mata_kuliah_id');
		$semester_id=$this->input->post('semester_id');
		$mode = $this->input->post('mode');
		if($mode=='') $mode ='edit';
		$query = $this->db->query("select m.id as rencana_mata_pelajaran_pokok_id, d.mahasiswa_id, s.nim, s.nama as nama_mhs,
				d.id as rencana_mata_pelajaran_pokok_dtl_id, c.sks_mata_kuliah,
                a.id as nilai_kuliah_id, a.nilai_mental
				from akademik_t_rencana_mata_pelajaran_pokok m					
				left join akademik_t_rencana_mata_pelajaran_pokok_detil d on m.id = d.rencana_mata_pelajaran_id and d.active=1
				left join akademik_m_mahasiswa s on  d.mahasiswa_id = s.id
				left join akademik_m_mata_kuliah c on m.mata_kuliah_id = c.id
				left join akademik_t_nilai_mental a on m.id = a.rencana_mata_pelajaran_pokok_id and a.mahasiswa_id = s.id
				where m.angkatan_id = $angkatan_id and m.program_studi_id=$program_studi_id  
				and m.semester_id = $semester_id and m.mata_kuliah_id = $mata_kuliah_id");
				//echo '<pre>'.$this->db->last_query().'</pre>'; //return;
		$no = 1;
        //for($i = 0; $i<10; $i++){
		if($query->num_rows()<1){
			echo "<tr>";
            echo "<td colspan='4'>Tidak ada mahasiswa yang mengambil mata kuliah ini</td>";
			echo "</tr>";
		} else {
			foreach($query->result_array() as $row){
				//$row['rencana_mata_pelajaran_pokok_id'] = $no;
				//$row['nilai_akhir'] = '10';
				//$row['nilai_akhir_huruf'] = 'A';
				echo "<tr id='".$row['nilai_kuliah_id']."'>";
				echo "<td>$no</td>";
				echo "<td>&nbsp;".$row['nim']."</td>";
				echo "<td>&nbsp;".$row['nama_mhs']."</td>";
				$nilai_hadir = 0;
				//if($row['nilai_kuliah_id'] !='') $nilai_hadir=$row['absensi_id'];
				if($mode=='edit'){ 
					echo "<td>&nbsp;<input type='text' style='width:30px' autocomplete='off' name='nilai_mental_".$row['rencana_mata_pelajaran_pokok_dtl_id']."' value='".$row['nilai_mental']."' />";
				} else {
					echo "<td>&nbsp;".$row['nilai_mental']."</td>";
				}
				echo "</tr>";
				$no++;
				//echo $row['mahasiswa_id'];
			}
			if($mode!='view'){ 
				echo '<tr id="btn-save"><td colspan="7" class="form-actions well">&nbsp;<button class="btn btn-small btn-primary" type="submit">Simpan</button></td></tr>';
			}
        }
	}
		
	
	
	function getOptDataMahasiswaUjian() {
		$angkatan_id= $this->input->post('angkatan_id');
		//$tahun_akademik_id = $this->input->post('tahun_akademik_id');
		$jadwal_kuliah_id=$this->input->post('pertemuan_id');
		$program_studi_id=$this->input->post('program_studi_id');
		$mata_kuliah_id=$this->input->post('mata_kuliah_id');
		$semester_id=$this->input->post('semester_id');
		$mode = $this->input->post('mode');
		if($mode=='') $mode ='edit';
		
		$data_results = $this->select_data_form->getOptDataMahasiswaUjian($angkatan_id, $semester_id, $program_studi_id, $mata_kuliah_id, $jadwal_kuliah_id);
		/*
		//getOptDataMahasiswaUjian($angkatan_id=null, $semester_id=null, $program_studi_id=null, $mata_kuliah_id=null, $jadwal_kuliah_id=null) {
		$query = $this->db->query("select m.id, d.mahasiswa_id, s.nim, s.nama as nama_mhs, j.id as jadwal_kuliah_id,
				d.id as rencana_mata_pelajaran_pokok_id, k.absensi as ket_absensi, a.absensi_id, d.kode_ujian_mahasiswa
				from akademik_t_rencana_mata_pelajaran_pokok m					
				left join akademik_t_rencana_mata_pelajaran_pokok_detil d on m.id = d.rencana_mata_pelajaran_id and d.active=1
				left join akademik_m_mahasiswa s on d.mahasiswa_id = s.id
				left join akademik_t_jadwal_ujian j on j.id=$jadwal_kuliah_id
				left join akademik_t_absensi_ujian_mhs a on j.id = a.jadwal_ujian_id  and a.mahasiswa_id = d.mahasiswa_id
				left join akademik_m_absensi k on a.absensi_id = k.id
				where m.angkatan_id = $angkatan_id and m.program_studi_id=$program_studi_id 
				and m.semester_id = $semester_id and m.mata_kuliah_id = $mata_kuliah_id");
		//echo '<pre>'.$this->db->last_query().'</pre>'; return;
		*/
		$no = 1;
        //for($i = 0; $i<10; $i++){
		if($data_results->num_rows()<1){
			echo "<tr>";
            echo "<td colspan='4'>Tidak ada mahasiswa yang mengambil mata kuliah ini</td>";
			echo "</tr>";
		} else {
			if($mode=='edit'){ 
				$this->crud->use_table('m_absensi');
				$order_bys = array( "absensi"=>"asc");
				$status_hadir_options=array();
				$data_tbl_absen = $this->crud->retrieve('','*',0,0,$order_bys)->result();
				foreach ($data_tbl_absen as $row) {
					$status_hadir_options[$row->id] = $row->absensi;
				}
			}
			foreach($data_results->result_array() as $row){
				echo "<tr>";
				echo "<td>$no</td>";
				echo "<td>&nbsp;".$row['nim']."</td>";
				echo "<td>&nbsp;".$row['kode_ujian_mahasiswa']."</td>";
				echo "<td>&nbsp;".$row['nama_mhs']."</td>";
				$nilai_hadir = 0;
				if($row['jadwal_kuliah_id'] !='') $nilai_hadir=$row['absensi_id'];
				if($mode=='edit'){ 
					echo '<td>'.form_dropdown('nilai_nts_'.$row['rencana_mata_pelajaran_pokok_id'], $status_hadir_options, set_value('nilai_nts_'.$row['rencana_mata_pelajaran_pokok_id'], $nilai_hadir), 'id="nilai_nts_'.$row['rencana_mata_pelajaran_pokok_id'].'" class="input-medium" prevData-selected="' . set_value('nilai_nts_'.$row['rencana_mata_pelajaran_pokok_id'].'', $nilai_hadir) . '"')
					.'</td>';
				}else if($mode=='view'){
					$nilai_hadir='';
					if($row['rencana_mata_pelajaran_pokok_id']>0) $nilai_hadir=$row['ket_absensi'];
					echo "<td>&nbsp;".$nilai_hadir."</td>";
				}else if($mode=='cetak'){
					$nilai_hadir='';
					if($row['rencana_mata_pelajaran_pokok_id']>0) $nilai_hadir=$row['ket_absensi'];
					echo "<td>&nbsp;".$nilai_hadir."</td>";
				}
				
				echo "</tr>";
				$no++;
				//echo $row['mahasiswa_id'];
			}
			if($mode=='edit'){ 
				echo '<tr id="btn-save"><td colspan="5" class="form-actions well">&nbsp;<button class="btn btn-small btn-primary" type="submit">Simpan</button></td></tr>';
			} else if($mode=='cetak'){
				echo '<tr id="btn-save"><td colspan="5" class="form-actions well">&nbsp;<button class="btn btn-info" type="submit">Cetak</button></td></tr>';
			}
        }
	}

	function getOptDataDosenUjian() {
		$angkatan_id= $this->input->post('angkatan_id');
		//$tahun_akademik_id = $this->input->post('tahun_akademik_id');
		$jadwal_kuliah_id=$this->input->post('pertemuan_id');
		$program_studi_id=$this->input->post('program_studi_id');
		$mata_kuliah_id=$this->input->post('mata_kuliah_id');
		$semester_id=$this->input->post('semester_id');
		$mode = $this->input->post('mode');
		if($mode=='') $mode ='edit';
		$query = $this->db->query("select  a.id as row_pos_id, m.id as jadwal_kuliah_id, 1 as type_pengawas, 
					d.id as row_pos, d.dosen_id as pengawas_id, ds.no_karpeg_dosen as nomor, ds.nama_dosen as nama,
					k.absensi as ket_absensi, a.absensi_id
					from akademik_t_jadwal_ujian m
					left join akademik_t_jadwal_ujian_pengawas_dosen_detil d on m.id = d.jadwal_ujian_id and d.active=1 
					left join akademik_m_dosen ds on d.dosen_id = ds.id  
					left join akademik_t_absensi_pengawas_ujian_dosen a on d.jadwal_ujian_id=a.jadwal_ujian_id and d.dosen_id=a.dosen_id  and d.active=1 
					left join akademik_m_absensi k on a.absensi_id = k.id
					where m.angkatan_id = $angkatan_id and m.program_studi_id=$program_studi_id 
					and m.semester_id = $semester_id and m.mata_kuliah_id = $mata_kuliah_id
					and m.id=$jadwal_kuliah_id
				union all	
				select  a.id as row_pos_id, m.id as jadwal_kuliah_id, 2 as type_pengawas, 
					d.id as row_pos, d.pegawai_id as pengawas_id, ds.no_karpeg_pegawai as nomor, ds.nama_pegawai as nama,
					k.absensi as ket_absensi, a.absensi_id
					from akademik_t_jadwal_ujian m
					left join akademik_t_jadwal_ujian_pengawas_pegawai_detil d on m.id = d.jadwal_ujian_id and d.active=1 
					left join akademik_m_pegawai ds on d.pegawai_id = ds.id
					left join akademik_t_absensi_pengawas_ujian_pegawai a on d.jadwal_ujian_id=a.jadwal_ujian_id and d.pegawai_id=a.pegawai_id and d.active=1 
					left join akademik_m_absensi k on a.absensi_id = k.id
					where m.angkatan_id = $angkatan_id and m.program_studi_id=$program_studi_id 
					and m.semester_id = $semester_id and m.mata_kuliah_id = $mata_kuliah_id
					and m.id=$jadwal_kuliah_id
				order by type_pengawas, row_pos");
		//echo '<pre>'.$this->db->last_query().'</pre>'; return;
		$no = 1;
        //for($i = 0; $i<10; $i++){
		if($query->num_rows()<1){
			echo "<tr>";
            echo "<td colspan='4'>Tidak ada mahasiswa yang mengambil mata kuliah ini</td>";
			echo "</tr>";
		} else {
			if($mode=='edit'){ 
			$this->crud->use_table('m_absensi');
			$order_bys = array( "absensi"=>"asc");
			$status_hadir_options=array();
			$data_tbl_absen = $this->crud->retrieve('','*',0,0,$order_bys)->result();
			foreach ($data_tbl_absen as $row) {
				$status_hadir_options[$row->id] = $row->absensi;
			}
			}
			foreach($query->result_array() as $row){
				echo "<tr>";
				echo "<td>$no</td>";
				echo "<td>&nbsp;".$row['nomor']."</td>";
				if($row['type_pengawas']==1) {
					echo "<td>&nbsp;<b>".$row['nama']."</b></td>"; 
				} else {
					echo "<td>&nbsp;".$row['nama']."</td>"; 
				}
				$nilai_hadir = 0;
				if($row['jadwal_kuliah_id'] !='') $nilai_hadir=$row['absensi_id'];
				if($mode=='edit'){ 
					echo '<td>'.form_dropdown('nilai_nts_'.$row['row_pos'], $status_hadir_options, set_value('nilai_nts_'.$row['row_pos'], $nilai_hadir), 'id="nilai_nts_'.$row['row_pos'].'" class="input-medium" prevData-selected="' . set_value('nilai_nts_'.$row['row_pos'].'', $nilai_hadir) . '"')
					.'<input type="hidden" id="pengawas_type_'.$row['row_pos'].'" name="pengawas_type_'.$row['row_pos'].'"value="'.$row['type_pengawas'].'">'
					.'</td>';
				}else if($mode=='view'){
					$nilai_hadir='';
					if($row['row_pos_id']>0) $nilai_hadir=$row['ket_absensi'];
					echo "<td>&nbsp;".$nilai_hadir."</td>";
				}
				
				echo "</tr>";
				$no++;
				//echo $row['mahasiswa_id'];
			}
			if($mode!='view'){ 
				echo '<tr id="btn-save"><td colspan="4" class="form-actions well">&nbsp;<button class="btn btn-small btn-primary" type="submit">Simpan</button></td></tr>';
			}
        }
	}
	
	/*
	function getDataJadwalInduk() {
        //$tahun_akademik_id = $this->input->post('tahun_akademik_id');
        $angkatan_id= $this->input->post('angkatan_id');
        $program_studi_id = $this->input->post('program_studi_id');
		$mata_kuliah_id=$this->input->post('mata_kuliah_id');
		$semester_id=$this->input->post('semester_id');
		$data_results = $this->select_data_form->getDataJadwalInduk($angkatan_id, $semester_id, $program_studi_id, $mata_kuliah_id);
        $no = 1;
        //for($i = 0; $i<10; $i++){
		if($query->num_rows()<1){
			echo "<tr>";
            echo "<td colspan='4'>Tidak ada mahasiswa yang mengambil mata kuliah ini</td>";
			echo "</tr>";
		} else {
			echo '<tr'>;
			echo '</tr>';
        }
    }
	*/
	
}
?>
