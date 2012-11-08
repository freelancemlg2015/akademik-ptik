<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Select_data_form extends CI_Controller {

    function __construct() {
		parent::__construct();
        $this->load->helper(array('snippets_helper'));
        $this->load->model('crud_model', 'crud');
    }
	
	function index($query_id = 0, $sort_by = 'id', $sort_order = 'desc', $offset = 0) {
        $this->select_data_form($query_id, $sort_by, $sort_order, $offset);
    }

    function select_data_form($query_id = 0, $sort_by = 'id', $sort_order = 'desc', $offset = 0) {
        exit('No direct script access allowed');
    }

	function getOptAngkatan() {
        $angkatan_id= $this->input->post('angkatan_id');
		$sql = "select a.tahun_ajar_mulai, a.tahun_ajar_akhir from akademik_m_tahun_akademik a ".
				" left join akademik_m_angkatan b on b.tahun_akademik_id=a.id ".
				"where a.active ='1' and b.id='$angkatan_id'";
        $query = $this->db->query($sql);
		//echo  '<pre>'.$this->db->last_query().'</pre><br>';
        foreach($query->result_array() as $row){
            echo $row['tahun_ajar_mulai'].'-'.$row['tahun_ajar_akhir'];
        }
    }
	
	function getOptProgramStudi() {
        $angkatan_id= $this->input->post('angkatan_id');
		$sql = "select a.id, a.nama_program_studi, a.kode_program_studi from akademik_m_program_studi a ".
				"where a.active ='1' and a.angkatan_id='$angkatan_id'";
        $query = $this->db->query($sql);
        //echo  '<pre>'.$this->db->last_query().'</pre><br>';
        echo '<option value=\'0\'></option>';
        foreach($query->result_array() as $row){
            echo '<option value=\''.$row['id'].'\' >'.$row['kode_program_studi'].'-'.$row['nama_program_studi'].'</option>';
        }
    }
	
	function getOptMataKuliah() {
        //$tahun_akademik_id = $this->input->post('tahun_akademik_id');
        $angkatan_id= $this->input->post('angkatan_id');
        $program_studi_id = $this->input->post('program_studi_id');
		$semester_id=$this->input->post('semester_id');
		/*
		$sql = "select a.id, a.kode_mata_kuliah, a.nama_mata_kuliah from akademik_m_mata_kuliah a ".
				"where a.angkatan_id=$angkatan_id and program_studi_id= $program_studi_id";
        */
		$sql = ("select d.id, d.kode_mata_kuliah, d.nama_mata_kuliah
				from akademik_t_rencana_mata_pelajaran_pokok a
				left join akademik_m_mata_kuliah d on a.mata_kuliah_id = d.id
				where a.angkatan_id = $angkatan_id and a.program_studi_id=$program_studi_id 
					and a.semester_id = $semester_id 
					group by d.id
					");//group by d.id
		$query = $this->db->query($sql);
		//echo '<pre>'.$this->db->last_query().'</pre>'; //return;
        echo '<option value=\'0\'></option>';
        foreach($query->result_array() as $row){
            echo '<option value=\''.$row['id'].'\' >'.$row['kode_mata_kuliah'].'-'.$row['nama_mata_kuliah'].'</option>';
        }
    }
	
	function getOptDataJadwal() {
        //$tahun_akademik_id = $this->input->post('tahun_akademik_id');
        $angkatan_id= $this->input->post('angkatan_id');
        $program_studi_id = $this->input->post('program_studi_id');
		$mata_kuliah_id=$this->input->post('mata_kuliah_id');
		$semester_id=$this->input->post('semester_id');
		
		$sql = "select a.id, a.pertemuan_ke, a.pertemuan_dari, a.tanggal from akademik_t_jadwal_kuliah a ".
				"where a.angkatan_id=$angkatan_id and a.program_studi_id= $program_studi_id
				and a.mata_kuliah_id=$mata_kuliah_id and a.semester_id=$semester_id ";
        $query = $this->db->query($sql);
        echo '<option value=\'\' > pilih</option>';
        foreach($query->result_array() as $row){
            echo '<option value=\''.$row['id'].'\' >'.$row['pertemuan_ke'].'-'.$row['pertemuan_dari'].' ('.$row['tanggal'].')'.'</option>';
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
	
	function getOptDataSubForm() {
		
		$angkatan_id= $this->input->post('angkatan_id');
		//$tahun_akademik_id = $this->input->post('tahun_akademik_id');
		$jadwal_kuliah_id=$this->input->post('pertemuan_id');
		$program_studi_id=$this->input->post('program_studi_id');
		$mata_kuliah_id=$this->input->post('mata_kuliah_id');
		$semester_id=$this->input->post('semester_id');
		
		/*
		$jadwal_kuliah_id=10; $program_studi_id = 1; $mata_kuliah_id  = 8;
		$angkatan_id= 2; $program_studi_id = 1; $mata_kuliah_id  = 8; $tahun_akademik_id = 1;
		*/
		$mode = $this->input->post('mode');
		if($mode=='') $mode ='edit';
		/*
        $query = $this->db->query("select a.id as rencana_mata_pelajaran_pokok_id, g.mahasiswa_id,b.id as akademik_t_absensi_mhs_id , 
				c.nama as nama_mhs, c.nim, a.mata_kuliah_id, b.absensi_id, e.id as jadwal_kuliah_id,  f.absensi as ket_absensi
				from akademik_t_rencana_mata_pelajaran_pokok a
				left join akademik_t_rencana_mata_pelajaran_pokok_detil g on a.id = g.rencana_mata_pelajaran_id
				left join akademik_m_mata_kuliah d on a.mata_kuliah_id = d.id 
				left join akademik_t_jadwal_kuliah e on e.id=$jadwal_kuliah_id and e.mata_kuliah_id = $mata_kuliah_id
				left join akademik_t_absensi_mhs b on e.id = b.jadwal_kuliah_id 
				left join akademik_m_absensi f on b.absensi_id = f.id
				left join akademik_m_mahasiswa c on g.mahasiswa_id = c.id
				where a.angkatan_id = $angkatan_id and a.program_studi_id=$program_studi_id 
					and a.semester_id = $semester_id and a.mata_kuliah_id = $mata_kuliah_id
					 group by g.mahasiswa_id
					");
					*/
		$query = $this->db->query("select m.id, d.mahasiswa_id, s.nim, s.nama as nama_mhs, j.id as jadwal_kuliah_id,
j.pertemuan_ke, d.id as rencana_mata_pelajaran_pokok_id, k.absensi as ket_absensi, a.absensi_id
from akademik_t_rencana_mata_pelajaran_pokok m					
left join akademik_t_rencana_mata_pelajaran_pokok_detil d on m.id = d.rencana_mata_pelajaran_id and d.active=1
left join akademik_m_mahasiswa s on d.mahasiswa_id = s.id
left join akademik_t_jadwal_kuliah j on j.id=$jadwal_kuliah_id
left join akademik_t_absensi_mhs a on j.id = a.jadwal_kuliah_id  and a.mahasiswa_id = d.mahasiswa_id
left join akademik_m_absensi k on a.absensi_id = k.id
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
				//$row['rencana_mata_pelajaran_pokok_id'] = $no;
				//$row['nilai_akhir'] = '10';
				//$row['nilai_akhir_huruf'] = 'A';
				echo "<tr>";
				echo "<td>$no</td>";
				echo "<td>&nbsp;".$row['nim']."</td>";
				echo "<td>&nbsp;".$row['nama_mhs']."</td>";
				$nilai_hadir = 0;
				if($row['jadwal_kuliah_id'] !='') $nilai_hadir=$row['absensi_id'];
				if($mode=='edit'){ 
					//<?= form_dropdown('pertemuan_id', $kegiatan_options, set_value('pertemuan_id', $jenis_ujian_id), 'onchange="get_data_mahasiswa()" id="pertemuan_id" class="input-medium" prevData-selected="' . set_value('jenis_ujian_id', $jenis_ujian_id) . '"') . '&nbsp;&nbsp;'; 
					//echo "<td>&nbsp;<input type='text' style='width:30px' name='nilai_nts_".$row['rencana_mata_pelajaran_pokok_id']."' value='".$row['nilai_nts']."' /></td>";
					//echo '<td>&nbsp;'.form_dropdown('nilai_nts_'.$row['rencana_mata_pelajaran_pokok_id'], $status_hadir_options, set_value('nilai_nts_'.$row['rencana_mata_pelajaran_pokok_id'], $row['absensi_id']), 'id="nilai_nts_'.$row['rencana_mata_pelajaran_pokok_id'].'" class="input-medium" prevData-selected="' . set_value('nilai_nts_'.$row['rencana_mata_pelajaran_pokok_id'].'', $row['absensi_id']) . '"')
					echo '<td>&nbsp;'.form_dropdown('nilai_nts_'.$row['rencana_mata_pelajaran_pokok_id'], $status_hadir_options, set_value('nilai_nts_'.$row['rencana_mata_pelajaran_pokok_id'], $nilai_hadir), 'id="nilai_nts_'.$row['rencana_mata_pelajaran_pokok_id'].'" class="input-medium" prevData-selected="' . set_value('nilai_nts_'.$row['rencana_mata_pelajaran_pokok_id'].'', $nilai_hadir) . '"')
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
				//echo '<pre>'.$this->db->last_query().'</pre>'; //return;
		$no = 1;
        //for($i = 0; $i<10; $i++){
		if($query->num_rows()<1){
			echo "<tr>";
            echo "<td colspan='4'>Tidak ada jadwal mata kuliah ini</td>";
			echo "</tr>";
		} else {
			/*
			foreach($query->result_array() as $row){
				$nilai_nts = $this->input->post('nilai_nts_'.$row['rencana_mata_pelajaran_pokok_id']);
				$parm = array();
				if($nilai_nts !='') $parm['nilai_nts'] = $nilai_nts;
			}
			*/
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
				//$row['rencana_mata_pelajaran_pokok_id'] = $no;
				//$row['nilai_akhir'] = '10';
				//$row['nilai_akhir_huruf'] = 'A';
				echo "<tr>";
				echo "<td>$no</td>";
				echo "<td>&nbsp;".$row['nim']."</td>";
				echo "<td>&nbsp;".$row['nama_mhs']."</td>";
				$nilai_hadir = 0;
				if($row['jadwal_kuliah_id'] !='') $nilai_hadir=$row['absensi_id'];
				if($mode=='edit'){ 
					//<?= form_dropdown('pertemuan_id', $kegiatan_options, set_value('pertemuan_id', $jenis_ujian_id), 'onchange="get_data_mahasiswa()" id="pertemuan_id" class="input-medium" prevData-selected="' . set_value('jenis_ujian_id', $jenis_ujian_id) . '"') . '&nbsp;&nbsp;'; 
					//echo "<td>&nbsp;<input type='text' style='width:30px' name='nilai_nts_".$row['rencana_mata_pelajaran_pokok_id']."' value='".$row['nilai_nts']."' /></td>";
					//echo '<td>&nbsp;'.form_dropdown('nilai_nts_'.$row['rencana_mata_pelajaran_pokok_id'], $status_hadir_options, set_value('nilai_nts_'.$row['rencana_mata_pelajaran_pokok_id'], $row['absensi_id']), 'id="nilai_nts_'.$row['rencana_mata_pelajaran_pokok_id'].'" class="input-medium" prevData-selected="' . set_value('nilai_nts_'.$row['rencana_mata_pelajaran_pokok_id'].'', $row['absensi_id']) . '"')
					echo '<td>&nbsp;'.form_dropdown('nilai_nts_'.$row['rencana_mata_pelajaran_pokok_id'], $status_hadir_options, set_value('nilai_nts_'.$row['rencana_mata_pelajaran_pokok_id'], $nilai_hadir), 'id="nilai_nts_'.$row['rencana_mata_pelajaran_pokok_id'].'" class="input-medium" prevData-selected="' . set_value('nilai_nts_'.$row['rencana_mata_pelajaran_pokok_id'].'', $nilai_hadir) . '"')
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
	
	function getOptDataMahasiswaUjian() {
		$angkatan_id= $this->input->post('angkatan_id');
		//$tahun_akademik_id = $this->input->post('tahun_akademik_id');
		$jadwal_kuliah_id=$this->input->post('pertemuan_id');
		$program_studi_id=$this->input->post('program_studi_id');
		$mata_kuliah_id=$this->input->post('mata_kuliah_id');
		$semester_id=$this->input->post('semester_id');
		$mode = $this->input->post('mode');
		if($mode=='') $mode ='edit';
		$query = $this->db->query("select m.id, d.mahasiswa_id, s.nim, s.nama as nama_mhs, j.id as jadwal_kuliah_id,
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
					left join akademik_t_absensi_ujian_dosen a on d.jadwal_ujian_id=a.jadwal_ujian_id and d.dosen_id=a.dosen_id  and d.active=1 
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
	
}
?>
