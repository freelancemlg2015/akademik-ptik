<?php

class Absensi_ujian_mahasiswa_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }
	public function data_jadwal_ujian($$jadwal_kuliah_id=0, $angkatan_id=0, $program_studi_id=0, $semester_id=0, $mata_kuliah_id=0 ) {
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
	}
}