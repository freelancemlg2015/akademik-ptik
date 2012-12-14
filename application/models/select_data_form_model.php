<?php
class Select_data_form_model extends CI_Model {
    function __construct() {
        parent::__construct();
    }
	
	function getOptAngkatanCombo() {
		$sql = "select a.angkatan_id, a.nama_angkatan
				from akademik_view_paket_plot_mata_kuliah a
				group by a.angkatan_id";
        $query = $this->db->query($sql);
		return $query;
	}
	function getOptAngkatan($angkatan_id=null) {
		$sql = "select a.tahun_ajar_mulai, a.tahun_ajar_akhir from akademik_m_tahun_akademik a ".
				" left join akademik_m_angkatan b on b.tahun_akademik_id=a.id ".
				"where a.active ='1' and b.id='$angkatan_id'";
        $query = $this->db->query($sql);
		return $query;
	}
	function getOptSemester($angkatan_id=null) {
		$sql = "select b.semester_id, b.nama_semester
				from akademik_view_paket_plot_mata_kuliah b
				where b.angkatan_id=$angkatan_id
				group by semester_id";
        $query = $this->db->query($sql);
		return $query;
		/*
		$str_hasil='<option value=\'0\'></option>';
        foreach($query->result_array() as $row){
			$str_hasil.= '<option value=\''.$row['semester_id'].'\' >'.$row['nama_semester'].'</option>';
        }
		return $str_hasil;
		*/
    }
	function getOptProgramStudi($angkatan_id=null, $semester_id=null) {
		$sql = "select b.program_studi_id, b.nama_program_studi
				from akademik_view_paket_plot_mata_kuliah b
				where b.angkatan_id=$angkatan_id and b.semester_id=$semester_id
				group by program_studi_id";
        $query = $this->db->query($sql);
        return $query;
    }
	
	function getOptMataKuliah($angkatan_id=null, $semester_id=null, $program_studi_id=null, $jenis_nilai=0) {
		$sql = "select b.mata_kuliah_id, b.nama_mata_kuliah
				from akademik_view_paket_plot_mata_kuliah_detail b
				where b.angkatan_id=$angkatan_id and b.semester_id=$semester_id 
				and b.program_studi_id=$program_studi_id and b.jenis_nilai=$jenis_nilai
				order by b.nama_mata_kuliah";
		$query = $this->db->query($sql);
		//echo  '<pre>'.$this->db->last_query().'</pre><br>';
		return $query;
    }
	function getOptDataJadwal($angkatan_id=null, $semester_id=null, $program_studi_id=null, $mata_kuliah_id=null) {
        $sql = "select a.id, a.pertemuan_ke, a.pertemuan_dari, a.tanggal from akademik_t_jadwal_kuliah a ".
				"where a.angkatan_id=$angkatan_id and a.program_studi_id= $program_studi_id
				and a.mata_kuliah_id=$mata_kuliah_id and a.semester_id=$semester_id ";
        $query = $this->db->query($sql);
		return $query;
    }
	
	function getOptDataMahasiswaForm($angkatan_id=null, $semester_id=null, $program_studi_id=null, $mata_kuliah_id=null, $jadwal_kuliah_id=null) {
        $sql = "select m.rencana_mata_pelajaran_id, m.mahasiswa_id, m.nim, m.nama_mhs, m.jadwal_kuliah_id,
				m.pertemuan_ke, m.rencana_mata_pelajaran_pokok_id, 
				k.absensi as ket_absensi, a.absensi_id, a.mahasiswa_id as akademik_t_absensi_mhs_id
				from akademik_view_paket_plot_mata_kuliah_mahasiswa m
				left join akademik_t_absensi_mhs a on m.jadwal_kuliah_id = a.jadwal_kuliah_id  and a.mahasiswa_id = m.mahasiswa_id
				left join akademik_m_absensi k on a.absensi_id = k.id
				where m.angkatan_id = $angkatan_id and m.program_studi_id=$program_studi_id
				and m.semester_id = $semester_id and m.mata_kuliah_id = $mata_kuliah_id and m.jadwal_kuliah_id=$jadwal_kuliah_id";
        $query = $this->db->query($sql);
		//echo '<pre>'.$this->db->last_query().'</pre>'; //return;
		return $query;
    }
	
	function getOptDataDosenForm($angkatan_id=null, $semester_id=null, $program_studi_id=null, $mata_kuliah_id=null, $jadwal_kuliah_id=null) {
        $sql = "select a.id as akademik_t_absensi_mhs_id, d.dosen_id, s.no_karpeg_dosen as nim, s.nama_dosen as nama_mhs,
				j.id as jadwal_kuliah_id, d.dosen_ajar_id, 
				j.pertemuan_ke, d.id as rencana_mata_pelajaran_pokok_id,
				k.absensi as ket_absensi, a.absensi_id
				from akademik_view_paket_plot_mata_kuliah_detail m
				left join akademik_t_dosen_ajar z on z.paket_mata_kuliah_id=m.paket_mata_kuliah_id
				left join akademik_t_dosen_ajar_detail d on z.id=d.dosen_ajar_id and d.active=1
				left join akademik_m_dosen s on d.dosen_id = s.id
				left join akademik_t_jadwal_kuliah j on j.id=$jadwal_kuliah_id
				left join akademik_t_absensi_dosen a on j.id = a.jadwal_kuliah_id and a.dosen_id=d.dosen_id and a.dosen_ajar_id = d.dosen_ajar_id
				left join akademik_m_absensi k on a.absensi_id = k.id
				where m.angkatan_id = $angkatan_id and m.program_studi_id=$program_studi_id
				and m.semester_id = $semester_id and m.mata_kuliah_id = $mata_kuliah_id";
        $query = $this->db->query($sql);
		return $query;
    }
	
	function getDataJadwalInduk($angkatan_id=null, $semester_id=null, $program_studi_id=null, $mata_kuliah_id=null) {
		$sql ="select a.id, d.pelaksanaan_kuliah, d.`hari_id`, d.`jenis_waktu`,
				c.nama_mata_kuliah
				from akademik_t_jadwal_kuliah_induk a
				left join akademik_t_dosen_ajar b on b.id=a.dosen_ajar_id
				left join akademik_t_jadwal_kuliah_induk_detil d on d.jadwal_kuliah_induk_id=a.id
				left join akademik_view_paket_plot_mata_kuliah_detail m on m.paket_mata_kuliah_id=b.paket_mata_kuliah_id
				where m.angkatan_id = $angkatan_id and m.program_studi_id=$program_studi_id
				and m.semester_id = $semester_id and m.mata_kuliah_id = $mata_kuliah_id";
        $query = $this->db->query($sql);
		return $query;
	}
	
	function getOptDataMahasiswaUjian($angkatan_id=null, $semester_id=null, $program_studi_id=null, $mata_kuliah_id=null, $jadwal_kuliah_id=null) {
        $sql = "select m.mahasiswa_id, m.nim, m.nama_mhs, j.id as jadwal_kuliah_id,
				m.rencana_mata_pelajaran_pokok_id, k.absensi as ket_absensi, a.absensi_id, m.kode_ujian_mahasiswa
				from akademik_view_paket_plot_mata_kuliah_mahasiswa m
				left join akademik_t_jadwal_ujian j on j.id=$jadwal_kuliah_id
				left join akademik_t_absensi_ujian_mhs a on j.id = a.jadwal_ujian_id  and a.mahasiswa_id = m.mahasiswa_id
				left join akademik_m_absensi k on a.absensi_id = k.id
				where m.angkatan_id = $angkatan_id and m.program_studi_id=$program_studi_id 
				and m.semester_id = $semester_id and m.mata_kuliah_id = $mata_kuliah_id";
		
		/*
		select m.rencana_mata_pelajaran_id, m.mahasiswa_id, m.nim, m.nama_mhs, m.jadwal_kuliah_id,
				m.pertemuan_ke, m.rencana_mata_pelajaran_pokok_id, 
				k.absensi as ket_absensi, a.absensi_id, a.mahasiswa_id as akademik_t_absensi_mhs_id
				from akademik_view_paket_plot_mata_kuliah_mahasiswa m
				left join akademik_t_absensi_ujian_mhs a on m.jadwal_kuliah_id = a.jadwal_kuliah_id  and a.mahasiswa_id = m.mahasiswa_id
				left join akademik_m_absensi k on a.absensi_id = k.id
				where m.angkatan_id = $angkatan_id and m.program_studi_id=$program_studi_id
				and m.semester_id = $semester_id and m.mata_kuliah_id = $mata_kuliah_id and m.jadwal_kuliah_id=$jadwal_kuliah_id";
        */
		$query = $this->db->query($sql);
		//echo '<pre>'.$this->db->last_query().'</pre>'; //return;
		return $query;
	}
}
