<?php

$config = array(
    /* SAMPLE */
    'sample_create' => array(
        array(
            'field' => 'sample',
            'label' => 'sample',
            'rules' => 'trim|required|callback_unique_sample'
        )
    ), 'sample_update' => array(
        array(
            'field' => 'sample',
            'label' => 'sample',
            'rules' => 'trim|required'
        )
    
    /*DIREKTORAT*/    
    ),  'direktorat_create' => array(
        array(
            'field' => 'nama_direktorat',
            'label' => 'nama_direktorat',
            'rules' => 'trim|required|callback_unique_nama_direktorat'
        )
    ), 'direktorat_update' => array(
        array(
            'field' => 'nama_direktorat',
            'label' => 'nama_direktorat',
            'rules' => 'trim|required'
        )
        
    /* SUBDIREKTORAT*/    
    ),  'subdirektorat_create' => array(
        array(
            'field' => 'direktorat_id',
            'label' => 'direktorat_id',
            'rules' => 'trim|required'
        ),
        array(
            'field' => 'nama_subdirektorat',
            'label' => 'nama_subdirektorat',
            'rules' => 'trim|required|callback_unique_nama_direktorat'
        )
    ), 'subdirektorat_update' => array(
        array(
            'field' => 'direktorat_id',
            'label' => 'direktorat_id',
            'rules' => 'trim|required'
        ),   
        array(
            'field' => 'nama_subdirektorat',
            'label' => 'nama_subdirektorat',
            'rules' => 'trim|required'
        )  
        
    /* BERITA KATEGORI */    
    ),  'kategori_berita_create' => array(
        array(
            'field' => 'kategori_berita',
            'label' => 'kategori_berita',
            'rules' => 'trim|required|callback_unique_kategori_berita'
        )
    ), 'kategori_berita_update' => array(
        array(
            'field' => 'kategori_berita',
            'label' => 'kategori_berita',
            'rules' => 'trim|required'
        )
        
    /* BERITA */
    ), 'berita_create' => array(
        array(
            'field' => 'judul_berita',
            'label' => 'judul_berita',
            'rules' => 'trim|required|callback_unique_judul_berita'
        ),
        array(
            'field' => 'konten_berita',
            'label' => 'konten_berita',
            'rules' => 'trim|required'
        )
    ), 'berita_update' => array(
        array(
            'field' => 'judul_berita',
            'label' => 'judul_berita',
            'rules' => 'trim|required'
        ),
        array(
            'field' => 'konten_berita',
            'label' => 'konten_berita',
            'rules' => 'trim|required'
        )
        
    /* KATEGORI UNDUHAN */
    ), 'kategori_unduhan_create' => array(
        array(
            'field' => 'kategori_unduhan',
            'label' => 'kategori_unduhan',
            'rules' => 'trim|required|callback_unique_kategori_unduhan'
        )
    ), 'kategori_unduhan_update' => array(
        array(
            'field' => 'kategori_unduhan',
            'label' => 'kategori_unduhan',
            'rules' => 'trim|required'
        )
        
    /* UNDUHAN */    
    ), 'unduhan_create' => array(
        array(
            'field' => 'nama_unduhan',
            'label' => 'nama_unduhan',
            'rules' => 'trim|required|callback_unique_nama_unduhan'
        )
    ), 'unduhan_update' => array(
        array(
            'field' => 'nama_unduhan',
            'label' => 'nama_unduhan',
            'rules' => 'trim|required'
        )
        
    /* ANGKATAN */
    ), 'angkatan_create' => array(
        array(
            'field' => 'kode_angkatan',
            'label' => 'kode_angkatan',
            'rules' => 'trim|required'
        ),
        array(
            'field' => 'nama_angkatan',
            'label' => 'nama_angkatan',
            'rules' => 'trim|required|callback_unique_nama_angkatan'
        )
    ), 'angkatan_update' => array(
        array(
            'field' => 'kode_angkatan',
            'label' => 'kode_angkatan',
            'rules' => 'trim|required'
        ),
        array(
            'field' => 'nama_angkatan',
            'label' => 'nama_angkatan',
            'rules' => 'trim|required'
        )

    /* PROGRAM STUDI */
    ), 'program_studi_create' => array(
        array(
            'field' => 'kode_program_studi',
            'label' => 'kode_program_studi',
            'rules' => 'trim|required'
        ),
        array(
            'field' => 'nama_program_studi',
            'label' => 'nama_program_studi',
            'rules' => 'trim|required'
        )
    ), 'program_studi_update' => array(
        array(
            'field' => 'kode_program_studi',
            'label' => 'kode_program_studi',
            'rules' => 'trim|required'
        ),
        array(
            'field' => 'nama_program_studi',
            'label' => 'nama_program_studi',
            'rules' => 'trim|required'
        )

    /* TAHUN AKADEMIK */
    ), 'tahun_akademik_create' => array(
        array(
            'field' => 'kode_tahun_ajar',
            'label' => 'kode_tahun_ajar',
            'rules' => 'trim|required|callback_unique_tahun_ajar'
        )
    ), 'tahun_akademik_update' => array(
        array(
            'field' => 'kode_tahun_ajar',
            'label' => 'kode_tahun_ajar',
            'rules' => 'trim|required'
        )

    /* KELOMPOK MATA KULIAH */
    ), 'kelompok_mata_kuliah_create' => array(
        array(
            'field' => 'kode_kelompok_mata_kuliah',
            'label' => 'kode_kelompok_mata_kuliah',
            'rules' => 'trim|required'
        ),
        array(
            'field' => 'kelompok_mata_kuliah',
            'label' => 'kelompok_mata_kuliah',
            'rules' => 'trim|required'
        )
    ), 'kelompok_mata_kuliah_update' => array(
        array(
            'field' => 'kode_kelompok_mata_kuliah',
            'label' => 'kode_kelompok_mata_kuliah',
            'rules' => 'trim|required'
        ),
        array(
            'field' => 'kelompok_mata_kuliah',
            'label' => 'kelompok_mata_kuliah',
            'rules' => 'trim|required'
        )

    /* JENJANG STUDI */
    ), 'jenjang_studi_create' => array(
        array(
            'field' => 'jenjang_studi',
            'label' => 'jenjang_studi',
            'rules' => 'trim|required|callback_unique_nama_jenjang_studi'
        )
    ), 'jenjang_studi_update' => array(
        array(
            'field' => 'jenjang_studi',
            'label' => 'jenjang_studi',
            'rules' => 'trim|required'
        )

    /* FREKUENSI PEMUTAHIRAN */
    ), 'frekuensi_pemutakhiran_create' => array(
        array(
            'field' => 'frekuensi_pemutahiran_kurikulum',
            'label' => 'frekuensi_pemutahiran_kurikulum',
            'rules' => 'trim|required'
        )
    ), 'frekuensi_pemutakhiran_update' => array(
        array(
            'field' => 'frekuensi_pemutahiran_kurikulum',
            'label' => 'frekuensi_pemutahiran_kurikulum',
            'rules' => 'trim|required'
        )

    /* PELAKSANA PEMUTAHIRAN */
    ), 'pelaksana_pemutakhiran_create' => array(
        array(
            'field' => 'pelaksana_pemutahiran',
            'label' => 'pelaksana_pemutahiran',
            'rules' => 'trim|required'
        )
    ), 'pelaksana_pemutakhiran_update' => array(
        array(
            'field' => 'pelaksana_pemutahiran',
            'label' => 'pelaksana_pemutahiran',
            'rules' => 'trim|required'
        )

    /* JAM PELAJARAN */
    ), 'jam_pelajaran_create' => array(
        array(
            'field' => 'kode_jam',
            'label' => 'kode_jam',
            'rules' => 'trim|required|callback_unique_kode_jam'
        ),
        array(
            'field' => 'jam_normal_mulai',
            'label' => 'jam_normal_mulai',
            'rules' => 'trim|required'
        ),
        array(
            'field' => 'jam_normal_akhir',
            'label' => 'jam_normal_akhir',
            'rules' => 'trim|required'
        ),
        array(
            'field' => 'jam_puasa_mulai',
            'label' => 'jam_puasa_mulai',
            'rules' => 'trim|required'
        ),
        array(
            'field' => 'jam_puasa_akhir',
            'label' => 'jam_puasa_akhir',
            'rules' => 'trim|required'
        )
    ), 'jam_pelajaran_update' => array(
        array(
            'field' => 'kode_jam',
            'label' => 'kode_jam',
            'rules' => 'trim|required|callback_unique_kode_jam'
        ),
        array(
            'field' => 'jam_normal_mulai',
            'label' => 'jam_normal_mulai',
            'rules' => 'trim|required'
        ),
        array(
            'field' => 'jam_normal_akhir',
            'label' => 'jam_normal_akhir',
            'rules' => 'trim|required'
        ),
        array(
            'field' => 'jam_puasa_mulai',
            'label' => 'jam_puasa_mulai',
            'rules' => 'trim|required'
        ),
        array(
            'field' => 'jam_puasa_akhir',
            'label' => 'jam_puasa_akhir',
            'rules' => 'trim|required'
        )

    /* RUANG PELAJARAN */
    ), 'ruang_pelajaran_create' => array(
        array(
            'field' => 'kode_ruang',
            'label' => 'kode_ruang',
            'rules' => 'trim|required|callback_unique_kode_ruang'
        ),
        array(
            'field' => 'nama_ruang',
            'label' => 'nama_ruang',
            'rules' => 'trim|required'
        ),
        array(
            'field' => 'kapasitas_ruang',
            'label' => 'kapasitas_ruang',
            'rules' => 'trim|required'
        )
    ), 'ruang_pelajaran_update' => array(
        array(
            'field' => 'kode_ruang',
            'label' => 'kode_ruang',
            'rules' => 'trim|required'
        ),
        array(
            'field' => 'nama_ruang',
            'label' => 'nama_ruang',
            'rules' => 'trim|required'
        ),
        array(
            'field' => 'kapasitas_ruang',
            'label' => 'kapasitas_ruang',
            'rules' => 'trim|required'
        )

    /* JENIS RUANG */
    ), 'jenis_ruang_create' => array(
        array(
            'field' => 'jenis_ruang',
            'label' => 'jenis_ruang',
            'rules' => 'trim|required|callback_unique_jenis_ruang'
        )
    ), 'jenis_ruang_update' => array(
        array(
            'field' => 'jenis_ruang',
            'label' => 'jenis_ruang',
            'rules' => 'trim|required'
        )

    /* STATUS AKREDITASI */
    ), 'status_akreditasi_create' => array(
        array(
            'field' => 'status_akreditasi',
            'label' => 'status_akreditasi',
            'rules' => 'trim|required|callback_unique_status_akreditasi'
        )
    ), 'status_akreditasi_update' => array(
        array(
            'field' => 'status_akreditasi',
            'label' => 'status_akreditasi',
            'rules' => 'trim|required'
        )

    /* STATUS AKTIVITAS DOSEN */
    ), 'status_aktivitas_dosen_create' => array(
        array(
            'field' => 'kode_status_aktivitas',
            'label' => 'kode_status_aktivitas',
            'rules' => 'trim|required|callback_unique_kode_status_aktivitas'
        ),
        array(
            'field' => 'status_aktivitas_dosen',
            'label' => 'status_aktivitas_dosen',
            'rules' => 'trim|required'
        )
    ), 'status_aktivitas_dosen_update' => array(
        array(
            'field' => 'kode_status_aktivitas',
            'label' => 'kode_status_aktivitas',
            'rules' => 'trim|required'
        ),
        array(
            'field' => 'status_aktivitas_dosen',
            'label' => 'status_aktivitas_dosen',
            'rules' => 'trim|required'
        )

    /* STATUS KERJA DOSEN */
    ), 'status_kerja_dosen_create' => array(
        array(
            'field' => 'kode_status_kerja_dosen',
            'label' => 'kode_status_kerja_dosen',
            'rules' => 'trim|required|callback_unique_kode_status_kerja_dosen'
        ),
        array(
            'field' => 'status_kerja_dosen',
            'label' => 'status_kerja_dosen',
            'rules' => 'trim|required'
        )
    ), 'status_kerja_dosen_update' => array(
        array(
            'field' => 'kode_status_kerja_dosen',
            'label' => 'kode_status_kerja_dosen',
            'rules' => 'trim|required'
        ),
        array(
            'field' => 'status_kerja_dosen',
            'label' => 'status_kerja_dosen',
            'rules' => 'trim|required'
        )

    /* STATUS DOSEN PENASEHAT */
    ), 'status_dosen_penasehat_create' => array(
        array(
            'field' => 'status_dosen_penasehat',
            'label' => 'status_dosen_penasehat',
            'rules' => 'trim|required|callback_unique_status_dosen_penasehat'
        )
    ), 'status_dosen_penasehat_update' => array(
        array(
            'field' => 'status_dosen_penasehat',
            'label' => 'status_dosen_penasehat',
            'rules' => 'trim|required'
        )

    /* STATUS MATA KULIAH */
    ), 'status_mata_kuliah_create' => array(
        array(
            'field' => 'kode_matakuliah',
            'label' => 'kode_matakuliah',
            'rules' => 'trim|required|callback_unique_kode_matakuliah'
        ),
        array(
            'field' => 'nama_matakuliah',
            'label' => 'nama_matakuliah',
            'rules' => 'trim|required'
        ),
        array(
            'field' => 'status_mata_kuliah',
            'label' => 'status_mata_kuliah',
            'rules' => 'trim|required'
        )
    ), 'status_mata_kuliah_update' => array(
        array(
            'field' => 'kode_matakuliah',
            'label' => 'kode_matakuliah',
            'rules' => 'trim|required|callback_unique_kode_matakuliah'
        ),
        array(
            'field' => 'nama_matakuliah',
            'label' => 'nama_matakuliah',
            'rules' => 'trim|required'
        ),
        array(
            'field' => 'status_mata_kuliah',
            'label' => 'status_mata_kuliah',
            'rules' => 'trim|required'
        )

    /* GOLONGAN */
    ), 'golongan_create' => array(
        array(
            'field' => 'kode_golongan',
            'label' => 'kode_golongan',
            'rules' => 'trim|required'
        ),
        array(
            'field' => 'golongan',
            'label' => 'golongan',
            'rules' => 'trim|required'
        )
    ), 'golongan_update' => array(
        array(
            'field' => 'kode_golongan',
            'label' => 'kode_golongan',
            'rules' => 'trim|required'
        ),
        array(
            'field' => 'golongan',
            'label' => 'golongan',
            'rules' => 'trim|required'
        )

    /* JABATAN TERTINGGI */
    ), 'jabatan_tertinggi_create' => array(
        array(
            'field' => 'kode_jabatan_tertinggi',
            'label' => 'kode_jabatan_tertinggi',
            'rules' => 'trim|required|callback_unique_kode_jabatan_tertinggi'
        ),
        array(
            'field' => 'jabatan_tertinggi',
            'label' => 'jabatan_tertinggi',
            'rules' => 'trim|required'
        )
    ), 'jabatan_tertinggi_update' => array(
        array(
            'field' => 'kode_jabatan_tertinggi',
            'label' => 'kode_jabatan_tertinggi',
            'rules' => 'trim|required'
        ),
        array(
            'field' => 'jabatan_tertinggi',
            'label' => 'jabatan_tertinggi',
            'rules' => 'trim|required'
        )

    /* JENIS KELAMIN */
    ), 'jenis_kelamin_create' => array(
        array(
            'field' => 'jenis_kelamin',
            'label' => 'jenis_kelamin',
            'rules' => 'trim|required|callback_unique_jenis_kelamin'
        )
    ), 'jenis_kelamin_update' => array(
        array(
            'field' => 'jenis_kelamin',
            'label' => 'jenis_kelamin',
            'rules' => 'trim|required'
        )

    /* JABATAN AKADEMIK */
    ), 'jabatan_akademik_create' => array(
        array(
            'field' => 'kode_jabatan_akademik',
            'label' => 'kode_jabatan_akademik',
            'rules' => 'trim|required|callback_unique_kode_jabatan_akademik'
        ),
        array(
            'field' => 'nama_jabatan_akademik',
            'label' => 'nama_jabatan_akademik',
            'rules' => 'trim|required'
        )
    ), 'jabatan_akademik_update' => array(
        array(
            'field' => 'kode_jabatan_akademik',
            'label' => 'kode_jabatan_akademik',
            'rules' => 'trim|required'
        ),
        array(
            'field' => 'nama_jabatan_akademik',
            'label' => 'nama_jabatan_akademik',
            'rules' => 'trim|required'
        )

    /* JENIS UJIAN */
    ), 'jenis_ujian_create' => array(
        array(
            'field' => 'kode_ujian',
            'label' => 'kode_ujian',
            'rules' => 'trim|required|callback_unique_kode_ujian'
        ),
        array(
            'field' => 'jenis_ujian',
            'label' => 'jenis_ujian',
            'rules' => 'nama_trim|required'
        )
    ), 'jenis_ujian_update' => array(
        array(
            'field' => 'kode_ujian',
            'label' => 'kode_ujian',
            'rules' => 'trim|required'
        ),
        array(
            'field' => 'jenis_ujian',
            'label' => 'jenis_ujian',
            'rules' => 'trim|required'
        )

    /* NILAI */
    ), 'nilai_create' => array(
        array(
            'field' => 'kode_nilai',
            'label' => 'kode_nilai',
            'rules' => 'trim|required|callback_unique_kode_nilai'
        ),
        array(
            'field' => 'nilai',
            'label' => 'nilai',
            'rules' => 'nama_trim|required'
        )
    ), 'nilai_update' => array(
        array(
            'field' => 'kode_nilai',
            'label' => 'kode_nilai',
            'rules' => 'trim|required'
        ),
        array(
            'field' => 'nilai',
            'label' => 'nilai',
            'rules' => 'trim|required'
        )

    /* PANGKAT */
    ), 'pangkat_create' => array(
        array(
            'field' => 'kode_pangkat',
            'label' => 'kode_pangkat',
            'rules' => 'trim|required|callback_unique_kode_pangkat'
        ),
        array(
            'field' => 'nama_pangkat',
            'label' => 'nama_pangkat',
            'rules' => 'nama_trim|required'
        )
    ), 'pangkat_update' => array(
        array(
            'field' => 'kode_pangkat',
            'label' => 'kode_pangkat',
            'rules' => 'trim|required'
        ),
        array(
            'field' => 'nama_pangkat',
            'label' => 'nama_pangkat',
            'rules' => 'trim|required'
        )

    /* KESATUAN ASAL */
    ), 'kesatuan_asal_create' => array(
        array(
            'field' => 'kode_kesatuan_asal',
            'label' => 'kode_kesatuan_asal',
            'rules' => 'trim|required|callback_unique_kode_kesatuan_asal'
        ),
        array(
            'field' => 'nama_kesatuan_asal',
            'label' => 'nama_kesatuan_asal',
            'rules' => 'nama_trim|required'
        )
    ), 'kesatuan_asal_update' => array(
        array(
            'field' => 'kode_kesatuan_asal',
            'label' => 'kode_kesatuan_asal',
            'rules' => 'trim|required'
        ),
        array(
            'field' => 'nama_kesatuan_asal',
            'label' => 'nama_kesatuan_asal',
            'rules' => 'trim|required'
        )

    /* KONSENTRASI STUDI */
    ), 'konsentrasi_studi_create' => array(
        array(
            'field' => 'kode_konsentrasi_studi',
            'label' => 'kode_konsentrasi_studi',
            'rules' => 'trim|required|callback_unique_kode_konsentrasi_studi'
        ),
        array(
            'field' => 'nama_konsentrasi_studi',
            'label' => 'nama_konsentrasi_studi',
            'rules' => 'trim|required'
        )
    ), 'konsentrasi_studi_update' => array(
        array(
            'field' => 'kode_konsentrasi_studi',
            'label' => 'kode_konsentrasi_studi',
            'rules' => 'trim|required'
        ),
        array(
            'field' => 'nama_konsentrasi_studi',
            'label' => 'nama_konsentrasi_studi',
            'rules' => 'trim|required'
        )

    /* SEMESTER */
    ), 'semester_create' => array(
        array(
            'field' => 'kode_semester',
            'label' => 'kode_semester',
            'rules' => 'trim|required|callback_unique_kode_semester'
        ),
        array(
            'field' => 'nama_semester',
            'label' => 'nama_semester',
            'rules' => 'trim|required'
        )
    ), 'semester_update' => array(
        array(
            'field' => 'kode_semester',
            'label' => 'kode_semester',
            'rules' => 'trim|required'
        ),
        array(
            'field' => 'nama_semester',
            'label' => 'nama_semester',
            'rules' => 'trim|required'
        )

    /* SEMESTER MULAI */
    ), 'semester_mulai_aktivitas_create' => array(
        array(
            'field' => 'semester_mulai_aktivitas',
            'label' => 'semester_mulai_aktivitas',
            'rules' => 'trim|required|callback_unique_semester_mulai_aktivitas'
        )
    ), 'semester_mulai_aktivitas_update' => array(
        array(
            'field' => 'semester_mulai_aktivitas',
            'label' => 'semester_mulai_aktivitas',
            'rules' => 'trim|required'
        )

    /* SURAT IJIN MENGAJAR */
    ), 'surat_ijin_mengajar_create' => array(
        array(
            'field' => 'surat_ijin_mengajar',
            'label' => 'surat_ijin_mengajar',
            'rules' => 'trim|required|callback_unique_surat_ijin_mengajar'
        )
    ), 'surat_ijin_mengajar_update' => array(
        array(
            'field' => 'surat_ijin_mengajar',
            'label' => 'surat_ijin_mengajar',
            'rules' => 'trim|required'
        )
        
    /* AKTA MENGAJAR */
    ), 'akta_mengajar_create' => array(
        array(
            'field' => 'kode_akta',
            'label' => 'kode_akta',
            'rules' => 'trim|required|callback_unique_kode_akta'
        )
    ), 'akta_mengajar_update' => array(
        array(
            'field' => 'kode_akta',
            'label' => 'kode_akta',
            'rules' => 'trim|required'
        )

    /* BOBOT NILAI */
    ), 'bobot_nilai_create' => array(
        array(
            'field' => 'nilai_angka',
            'label' => 'nilai_angka',
            'rules' => 'trim|required'
        ),
        array(
            'field' => 'nilai_huruf',
            'label' => 'nilai_huruf',
            'rules' => 'trim|required'
        ),
        array(
            'field' => 'bobot_nilai_huruf',
            'label' => 'bobot_nilai_huruf',
            'rules' => 'trim|required'
        ),
        array(
            'field' => 'keterangan_bobot_nilai',
            'label' => 'keterangan_bobot_nilai',
            'rules' => 'trim|required'
        )
    ), 'bobot_nilai_update' => array(
        array(
            'field' => 'nilai_angka',
            'label' => 'nilai_angka',
            'rules' => 'trim|required'
        ),
        array(
            'field' => 'nilai_huruf',
            'label' => 'nilai_huruf',
            'rules' => 'trim|required'
        ),
        array(
            'field' => 'bobot_nilai_huruf',
            'label' => 'bobot_nilai_huruf',
            'rules' => 'trim|required'
        ),
        array(
            'field' => 'keterangan_bobot_nilai',
            'label' => 'keterangan_bobot_nilai',
            'rules' => 'trim|required'
        )

    /* DATA MAHASISWA */
    ), 'mahasiswa_create' => array(
        array(
            'field' => 'kode_dik',
            'label' => 'kode_dik',
            'rules' => 'trim|required'
        ),
        array(
            'field' => 'kode_dik_ang',
            'label' => 'kode_dik_ang',
            'rules' => 'trim|required'
        ),
        array(
            'field' => 'nama_jenis_dik',
            'label' => 'nama_jenis_dik',
            'rules' => 'trim|required'
        ),
        array(
            'field' => 'sebutan_dik',
            'label' => 'sebutan_dik',
            'rules' => 'trim|required'
        ),
        array(
            'field' => 'nim',
            'label' => 'nim',
            'rules' => 'trim|required|callback_unique_nim'
        ),
        array(
            'field' => 'nama',
            'label' => 'nama',
            'rules' => 'trim|required'
        )
    ), 'mahasiswa_update' => array(
        array(
            'field' => 'kode_dik',
            'label' => 'kode_dik',
            'rules' => 'trim|required'
        ),
        array(
            'field' => 'kode_dik_ang',
            'label' => 'kode_dik_ang',
            'rules' => 'trim|required'
        ),
        array(
            'field' => 'nama_jenis_dik',
            'label' => 'nama_jenis_dik',
            'rules' => 'trim|required'
        ),
        array(
            'field' => 'sebutan_dik',
            'label' => 'sebutan_dik',
            'rules' => 'trim|required'
        ),
        array(
            'field' => 'nim',
            'label' => 'nim',
            'rules' => 'trim|required'
        ),
        array(
            'field' => 'nama',
            'label' => 'nama',
            'rules' => 'trim|required'
        )

    /* DATA DOSEN */
    ), 'dosen_create' => array(
        array(
            'field' => 'angkatan_id',
            'label' => 'angkatan_id',
            'rules' => 'trim|required|greater_than[0]'
        ),
        array(
            'field' => 'nama_dosen',
            'label' => 'nama_dosen',
            'rules' => 'trim|required'
        )
    ), 'dosen_update' => array(
        array(
            'field' => 'angkatan_id',
            'label' => 'angkatan_id',
            'rules' => 'trim|required'
        ),
        array(
            'field' => 'nama_dosen',
            'label' => 'nama_dosen',
            'rules' => 'trim|required'
        )

    /* MATA KULIAH */
    ), 'mata_kuliah_create' => array(
        array(
            'field' => 'kode_mata_kuliah',
            'label' => 'kode_mata_kuliah',
            'rules' => 'trim|required'
        ),
        array(
            'field' => 'nama_mata_kuliah',
            'label' => 'nama_mata_kuliah',
            'rules' => 'trim|required'
        ),
        array(
            'field' => 'angkatan_id',
            'label' => 'angkatan',
            'rules' => 'trim|greater_than[0]'
        )
    ), 'mata_kuliah_update' => array(
        array(
            'field' => 'kode_mata_kuliah',
            'label' => 'kode_mata_kuliah',
            'rules' => 'trim|required'
        ),
        array(
            'field' => 'nama_mata_kuliah',
            'label' => 'nama_mata_kuliah',
            'rules' => 'trim|required'
        ),
        array(
            'field' => 'angkatan_id',
            'label' => 'angkatan',
            'rules' => 'trim|greater_than[0]'
        )

    /* NILAI FISIK : Indah */
    ), 'nilai_fisik_create' => array(
        array(
            'field' => 'mahasiswa_id',
            'label' => 'mahasiswa_id',
            'rules' => 'trim|required'
        ),
        array(
            'field' => 'nilai_fisik',
            'label' => 'nilai_fisik',
            'rules' => 'trim|required'
        )
    ), 'nilai_fisik_update' => array(
        array(
            'field' => 'mahasiswa_id',
            'label' => 'mahasiswa_id',
            'rules' => 'trim|required'
        ),
        array(
            'field' => 'nilai_fisik',
            'label' => 'nilai_fisik',
            'rules' => 'trim|required'
        )
    
    /*NILAI MENTAL*/    
    ), 'nilai_mental_create' => array(
        array(
            'field' => 'nim',
            'label' => 'nim',
            'rules' => 'trim|required'
        ),
        array(
            'field' => 'nilai_mental',
            'label' => 'nilai_mental',
            'rules' => 'trim|required'
        )
    ), 'nilai_mental_update' => array(
        array(
            'field' => 'nim',
            'label' => 'nim',
            'rules' => 'trim|required'
        ),
        array(
            'field' => 'nilai_mental',
            'label' => 'nilai_mental',
            'rules' => 'trim|required'
        )
    )

    /* JADWAL KULIAH */
    , 'jadwal_kuliah_create' => array(
        array(
            'field' => 'angkatan_id',
            'label' => 'angkatan',
            'rules' => 'trim|required|greater_than[0]'
        ),
		array(
            'field' => 'program_studi_id',
            'label' => 'program studi',
            'rules' => 'trim|required|greater_than[0]'
        ),
		/*array(
            'field' => 'mata_kuliah',
            'label' => 'mata kuliah',
            'rules' => 'trim|required|greater_than[0]'
        ),*/
		array(
            'field' => 'metode_ajar_id',
            'label' => 'metode ajar',
            'rules' => 'trim|required|greater_than[0]'
        ),
        array(
            'field' => 'jenis_waktu',
            'label' => 'jenis waktu',
            'rules' => 'trim|required|greater_than[0]'
        ),
        array(
            'field' => 'nama_ruang_id',
            'label' => 'nama ruang',
            'rules' => 'trim|required|greater_than[0]'
        ),
        array(
            'field' => 'minggu_ke',
            'label' => 'Minggu ke',
            'rules' => 'trim|required|greater_than[0]'
        ),
        array(
            'field' => 'pertemuan_ke',
            'label' => 'pertemuan ke',
            'rules' => 'trim|required|greater_than[0]'
        ),
		
        array(
            'field' => 'pertemuan_dari',
            'label' => 'pertemuan dari',
            'rules' => 'trim|required|greater_than[0]'
        ),
        array(
            'field' => 'tgl_lahir',
            'label' => 'tanggal lahir',
            'rules' => 'trim|required'
        )
    ), 'jadwal_kuliah_update' => array(
        array(
            'field' => 'angkatan_id',
            'label' => 'angkatan',
            'rules' => 'trim|required|greater_than[0]'
        ),
		array(
            'field' => 'program_studi_id',
            'label' => 'program studi',
            'rules' => 'trim|required|greater_than[0]'
        ),
		/*array(
            'field' => 'mata_kuliah',
            'label' => 'mata kuliah',
            'rules' => 'trim|required|greater_than[0]'
        ),*/
		array(
            'field' => 'metode_ajar_id',
            'label' => 'metode ajar',
            'rules' => 'trim|required|greater_than[0]'
        ),
        array(
            'field' => 'jenis_waktu',
            'label' => 'jenis waktu',
            'rules' => 'trim|required|greater_than[0]'
        ),
        array(
            'field' => 'nama_ruang_id',
            'label' => 'nama ruang',
            'rules' => 'trim|required|greater_than[0]'
        ),
		array(
            'field' => 'minggu_ke',
            'label' => 'Minggu ke',
            'rules' => 'trim|required|greater_than[0]'
        ),
        array(
            'field' => 'pertemuan_ke',
            'label' => 'pertemuan ke',
            'rules' => 'trim|required|greater_than[0]'
        ),
        array(
            'field' => 'pertemuan_dari',
            'label' => 'pertemuan dari',
            'rules' => 'trim|required|greater_than[0]'
        ),
        array(
            'field' => 'tgl_lahir',
            'label' => 'tanggal lahir',
            'rules' => 'trim|required'
        )
        
    /* JADWAL UJIAN */
    ), 'jadwal_ujian_create' => array(
        array(
            'field' => 'angkatan_id',
            'label' => 'angkatan',
            'rules' => 'trim|required|greater_than[0]'
        ),
		array(
            'field' => 'program_studi_id',
            'label' => 'program studi',
            'rules' => 'trim|required|greater_than[0]'
        ),
		array(
            'field' => 'mata_kuliah_id',
            'label' => 'mata kuliah',
            'rules' => 'trim|required|greater_than[0]'
        ),
		array(
            'field' => 'jenis_ujian_id',
            'label' => 'jenis ujian',
            'rules' => 'trim|required|greater_than[0]'
        ),
        array(
            'field' => 'nama_ruang_id',
            'label' => 'nama ruang',
            'rules' => 'trim|required|greater_than[0]'
        ),
        array(
            'field' => 'tgl_lahir',
            'label' => 'tanggal lahir',
            'rules' => 'trim|required'
        )
    ), 'jadwal_ujian_update' => array(
        array(
            'field' => 'angkatan_id',
            'label' => 'angkatan',
            'rules' => 'trim|required|greater_than[0]'
        ),
		array(
            'field' => 'program_studi_id',
            'label' => 'program studi',
            'rules' => 'trim|required|greater_than[0]'
        ),
		array(
            'field' => 'mata_kuliah_id',
            'label' => 'mata kuliah',
            'rules' => 'trim|required|greater_than[0]'
        ),
		array(
            'field' => 'jenis_ujian_id',
            'label' => 'jenis ujian',
            'rules' => 'trim|required|greater_than[0]'
        ),
        array(
            'field' => 'nama_ruang_id',
            'label' => 'nama ruang',
            'rules' => 'trim|required|greater_than[0]'
        ),
        array(
            'field' => 'tgl_lahir',
            'label' => 'tanggal lahir',
            'rules' => 'trim|required'
        )
    /* ABSENSI MAHASISWA */
    ), 'absensi_mahasiswa_create' => array(
        array(
            'field' => 'angkatan_id',
            'label' => 'angkatan',
            'rules' => 'trim|required|greater_than[0]'
        )
	/* ABSENSI DOSEN */
    ), 'absensi_dosen_create' => array(
        array(
            'field' => 'angkatan_id',
            'label' => 'angkatan',
            'rules' => 'trim|required|greater_than[0]'
        )	
	/* ABSENSI ujian MAHASISWA */
    ), 'absensi_ujian_mahasiswa_create' => array(
        array(
            'field' => 'angkatan_id',
            'label' => 'angkatan',
            'rules' => 'trim|required|greater_than[0]'
        )		
	/* ABSENSI ujain dosen */
    ), 'absensi_ujian_dosen_create' => array(
        array(
            'field' => 'angkatan_id',
            'label' => 'angkatan',
            'rules' => 'trim|required|greater_than[0]'
        )		
    /*UJIAN SKRIPSI*/
    ),'ujian_skripsi_create' => array(
        array(
            'field' => 'judul_skripsi',
            'label' => 'judul_skripsi',
            'rules' => 'trim|required'
        )
    ), 'ujian_skripsi_update' => array(
        array(
            'field' => 'judul_skripsi',
            'label' => 'judul_skripsi',
            'rules' => 'trim|required'
        )
        
    /* PAKET MATAKULIAH */
    ), 'paket_matakuliah_create' => array(
        array(
            'field' => 'nama_paket',
            'label' => 'nama_paket',
            'rules' => 'trim|required'
        )
    ), 'paket_matakuliah_update' => array(
        array(
            'field' => 'nama_paket',
            'label' => 'nama_paket',
            'rules' => 'trim|required'
        )
        
    /* KALENDER AKADEMIK */
    ), 'kalender_akademik_create' => array(
        array(
            'field' => 'tgl_kalender_mulai',
            'label' => 'tgl_kalender_mulai',
            'rules' => 'trim|required'
        ),
        array(
            'field' => 'tgl_kalender_akhir',
            'label' => 'tgl_kalender_akhir',
            'rules' => 'trim|required'
        ),
        array(
            'field' => 'tgl_mulai_kegiatan',
            'label' => 'tgl_mulai_kegiatan',
            'rules' => 'trim|required'
        ),
        array(
            'field' => 'tgl_akhir_kegiatan',
            'label' => 'tgl_akhir_kegiatan',
            'rules' => 'trim|required'
        ),
        array(
            'field' => 'nama_kegiatan',
            'label' => 'nama_kegiatan',
            'rules' => 'trim|required'
        )
    ), 'kalender_akademik_update' => array(
        array(
            'field' => 'tgl_kalender_mulai',
            'label' => 'tgl_kalender_mulai',
            'rules' => 'trim|required'
        ),
        array(
            'field' => 'tgl_kalender_akhir',
            'label' => 'tgl_kalender_akhir',
            'rules' => 'trim|required'
        ),
        array(
            'field' => 'tgl_mulai_kegiatan',
            'label' => 'tgl_mulai_kegiatan',
            'rules' => 'trim|required'
        ),
        array(
            'field' => 'tgl_akhir_kegiatan',
            'label' => 'tgl_akhir_kegiatan',
            'rules' => 'trim|required'
        ),
        array(
            'field' => 'nama_kegiatan',
            'label' => 'nama_kegiatan',
            'rules' => 'trim|required'
        )
        
    /* PENASEHAT AKADEMIK : Indah */
    ), 'penasehat_akademik_create' => array(
        array(
            'field' => 'kode_angkatan',
            'label' => 'kode_angkatan',
            'rules' => 'trim|required'
        ),
        array(
            'field' => 'jenjang_studi',
            'label' => 'jenjang_studi',
            'rules' => 'trim|required'
        ),
        array(
            'field' => 'program_studi',
            'label' => 'program_studi',
            'rules' => 'trim|required'
        ),
        array(
            'field' => 'penasehat_akademik',
            'label' => 'penasehat_akademik',
            'rules' => 'trim|required'
        )
    ), 'penasehat_akademik_update' => array(
        array(
            'field' => 'kode_angkatan',
            'label' => 'kode_angkatan',
            'rules' => 'trim|required'
        ),
        array(
            'field' => 'jenjang_studi',
            'label' => 'jenjang_studi',
            'rules' => 'trim|required'
        ),
        array(
            'field' => 'program_studi',
            'label' => 'program_studi',
            'rules' => 'trim|required'
        ),
        array(
            'field' => 'penasehat_akademik',
            'label' => 'penasehat_akademik',
            'rules' => 'trim|required'
        )
        
    /*NILAI AKADEMIK */    
    ),'nilai_akademik_create' => array(
        array(
            'field' => 'nilai_nts',
            'label' => 'nilai_nts',
            'rules' => 'trim|required'
        ),
        array(
            'field' => 'nilai_tgs',
            'label' => 'nilai_tgs',
            'rules' => 'trim|required'
        ),
        array(
            'field' => 'nilai_nas',
            'label' => 'nilai_nas',
            'rules' => 'trim|required'
        ),
        array(
            'field' => 'nilai_prb',
            'label' => 'nilai_prb',
            'rules' => 'trim|required'
        )
    ), 'nilai_akademik_update' => array(
        array(
            'field' => 'nilai_nts',
            'label' => 'nilai_nts',
            'rules' => 'trim|required'
        ),
        array(
            'field' => 'nilai_tgs',
            'label' => 'nilai_tgs',
            'rules' => 'trim|required'
        ),
        array(
            'field' => 'nilai_nas',
            'label' => 'nilai_nas',
            'rules' => 'trim|required'
        ),
        array(
            'field' => 'nilai_prb',
            'label' => 'nilai_prb',
            'rules' => 'trim|required'
        )
        
    /*PROVINSI*/
    ),  'provinsi_create' => array(
        array(
            'field' => 'nama_provinsi',
            'label' => 'nama_provinsi',
            'rules' => 'trim|required|callback_unique_nama_provinsi'
        )
    ), 'provinsi_update' => array(
        array(
            'field' => 'nama_provinsi',
            'label' => 'nama_provinsi',
            'rules' => 'trim|required'
        )
        
    /* KATEGORI PEJABAT */    
    ),  'kategori_pejabat_create' => array(
        array(
            'field' => 'nama_jenis_pejabat',
            'label' => 'nama_jenis_pejabat',
            'rules' => 'trim|required|callback_unique_nama_jenis_pejabat'
        )
    ), 'kategori_pejabat_update' => array(
        array(
            'field' => 'nama_jenis_pejabat',
            'label' => 'nama_jenis_pejabat',
            'rules' => 'trim|required'
        )
        
    /* PEJABAT TANDA TANGAN */
    ), 'pejabat_tanda_tangan_create' => array(
        array(
            'field' => 'kop',
            'label' => 'kop',
            'rules' => 'trim|required'
        )
    ), 'pejabat_tanda_tangan_update' => array(
        array(
            'field' => 'nama_pejabat',
            'label' => 'nama_pejabat',
            'rules' => 'trim|required'
        )
     
	/* PLOT MATA KULIAH*/
    ), 'plot_mata_kuliah_create' => array(
        array(
            'field' => 'angkatan_id',
            'label' => 'angkatan_id',
            'rules' => 'trim|required'
        )
    ), 'plot_mata_kuliah_update' => array(
        array(
            'field' => 'angkatan_id',
            'label' => 'angkatan_id',
            'rules' => 'trim|required'
        )      
 
	/* STATUS PLOT KELAS */
    ), 'plot_kelas_create' => array(
        array(
            'field' => 'jumlah_kelas',
            'label' => 'jumlah_kelas',
            'rules' => 'trim|required'
        )
    ), 'plot_kelas_update' => array(
        array(
            'field' => 'jumlah_kelas',
            'label' => 'jumlah_kelas',
            'rules' => 'trim|required'
        )
	 
	 

    /* PLOT DOSEN AJAR*/
    ), 'plot_dosen_ajar_create' => array(
//        array(
//            'field' => 'keterangan',
//            'label' => 'keterangan',
//            'rules' => 'trim|required'
//        )
    ), 'plot_dosen_ajar_update' => array(
//        array(
//            'field' => 'keterangan',
//            'label' => 'keterangan',
//            'rules' => 'trim|required'
//        )      

    /* PLOT DOSEN PENANGGUNG JAWAB*/
    ), 'plot_dosen_penanggung_jawab_create' => array(
        array(
            'field' => 'angkatan_id',
            'label' => 'angkatan_id',
            'rules' => 'trim|required'
        )
    ), 'plot_dosen_penanggung_jawab_update' => array(
        array(
            'field' => 'angkatan_id',
            'label' => 'angkatan_id',
            'rules' => 'trim|required'
        )   
        
    /* RENCANA MATA PELAJARAN*/       
    ), 'rencana_mata_pelajaran_create' => array(
        array(
            'field' => 'angkatan_id',
            'label' => 'angkatan_id',
            'rules' => 'trim|required'
        )
    ), 'rencana_mata_pelajaran_update' => array(
        array(
            'field' => 'angkatan_id',
            'label' => 'angkatan_id',
            'rules' => 'trim|required'
        )      

    )
    
);