<?php
if (!$this->session->userdata('logged_in'))
    redirect('login');

$myrole_raw = $auth->my_role();
$this->myrole_ID = $myrole_raw['id'];
$this->myrole_NAME = $myrole_raw['name'];

$primary_nav = $this->uri->segment(1);
$secondary_nav = $this->uri->segment(2);

$icon_color = 'icon-grey';
?> 
<div align="center">
    <img src="<?= base_url() ?>assets/img/header.jpg">
</div>
<div class="navbar navbar-fixed-top">
    <div class="navbar-inner">
        <div class="container">
            <a href="#" class="brand">STIK-PTIK AKADEMIK</a>
            <ul class="nav">

                <?php if ($auth->has_capability('m_home')): ?>
                    <li class="<?= isActive($primary_nav, 'home') ?>"><?= anchor('home', isIconActive($primary_nav, 'home', 'icon-home')) ?></li>
                <?php endif; ?>

                <?php if ($auth->has_capability('m_master')): ?>
                    <li class="<?= isActive($primary_nav, 'master'); ?>"><?= anchor('master', isIconActive($primary_nav, 'sample', 'icon-hdd') . ' Master'); ?></li>
                <?php endif; ?>

                <?php if ($auth->has_capability('t_transaction')): ?>
                    <li class="<?= ($this->uri->segment(1) == 'transaction') ? 'active' : ''; ?>"><?= anchor('transaction', isIconActive($primary_nav, 'transaction', 'icon-list-alt') . ' Transaksi'); ?></li>
                <?php endif; ?>

                <?php if ($auth->has_capability('r_report')): ?>
                    <li class="<?= isActive($primary_nav, 'laporan'); ?>"><?= anchor('laporan', isIconActive($primary_nav, 'laporan', 'icon-info-sign') . ' Laporan'); ?></li>
                <?php endif; ?>

                <?php if ($auth->has_capability('g_help')): ?>
                    <li class="<?= isActive($primary_nav, 'help') ? 'active' : ''; ?>"><?= anchor('help', isIconActive($primary_nav, 'help', 'icon-question-sign') . ' Bantuan'); ?></li>
                <?php endif; ?>

                <?php if ($auth->has_capability('a_admin')): ?>
                    <li class="<?= isActive($primary_nav, 'admin'); ?>"><?= anchor('admin', isIconActive($primary_nav, 'admin', 'icon-cog') . ' Admin'); ?></li>              
                <?php endif; ?>

            </ul>
            <ul class="nav pull-right">
                <li class="dropdown <?= ($primary_nav == 'profile') ? 'active' : ''; ?>">
                    <a data-toggle="dropdown" class="dropdown-toggle" href="#"><icon class="icon-user icon-grey"></icon> <?= $auth->logged_in(); ?><b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        <li><?= anchor('home/logout', 'Logout'); ?></li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</div>
<div class="container-fluid" id="main-container">
    <?php
    //buat dinamis next version ya!!!
    switch ($primary_nav) {
        case 'master':
            ?>
            <div class="subnav subnav-fixed">
                <ul class="nav nav-pills">

                    <?php if ($auth->has_capability('m_kurikulum')): ?>
                        <li class="dropdown <?= ($secondary_nav == 'program_studi' || $secondary_nav == 'tahun_akademik' || $secondary_nav == 'kelompok_matakuliah' || $secondary_nav == 'matakuliah' || $secondary_nav == 'jenjang_studi' || $secondary_nav == 'frekuensi_pemutakhiran' || $secondary_nav == 'pelaksana_pemutakhiran' || $secondary_nav == 'angkatan') ? 'active' : ''; ?>">
                            <a href="#" data-toggle="dropdown" class="dropdown-toggle">Kurikulum<b class="caret"></b></a>
                            <ul class="dropdown-menu">

                                <?php if ($auth->has_capability('m_kurikulum_tahun_akademik')): ?>
                                    <li class="<?= isActive($secondary_nav, 'tahun_akademik'); ?>"><?= anchor('master/tahun_akademik', 'Tahun Akademik'); ?></li>
                                <?php endif; ?>

                                <?php if ($auth->has_capability('m_kurikulum_angkatan')): ?>
                                    <li class="<?= isActive($secondary_nav, 'angkatan'); ?>"><?= anchor('master/angkatan', 'Angkatan'); ?></li>
                                <?php endif; ?>

                                <?php if ($auth->has_capability('m_kurikulum_program_studi')): ?>
                                    <li class="<?= isActive($secondary_nav, 'program_studi'); ?>"><?= anchor('master/program_studi', 'Program Studi'); ?></li>
                                <?php endif; ?>

                                <?php if ($auth->has_capability('m_kurikulum_mata_kuliah')): ?>
                                    <li class="<?= isActive($secondary_nav, 'mata_kuliah'); ?>"><?= anchor('master/mata_kuliah', 'Mata kuliah'); ?></li>
                                <?php endif; ?>

                                <?php if ($auth->has_capability('m_kurikulum_jenjang_studi')): ?>
                                    <li class="<?= isActive($secondary_nav, 'jenjang_studi'); ?>"><?= anchor('master/jenjang_studi', 'Jenjang Studi'); ?></li>
                                <?php endif; ?>

                            </ul>
                        </li>
                    <?php endif; ?>

                    <?php if ($auth->has_capability('m_perkuliahan')): ?>
                        <li class="dropdown <?= ($secondary_nav == 'jam_pelajaran' || $secondary_nav == 'ruang_pelajaran' || $secondary_nav == 'jenis_ruang' || $secondary_nav == 'semester' || $secondary_nav == 'semester_mulai_aktivitas' || $secondary_nav == 'akta_mengajar' || $secondary_nav == 'bobot_nilai') ? 'active' : ''; ?>">
                            <a href="#" data-toggle="dropdown" class="dropdown-toggle">Perkuliahan<b class="caret"></b></a>
                            <ul class="dropdown-menu">

                                <?php if ($auth->has_capability('m_perkuliahan_jam_pelajaran')): ?>
                                    <li class="<?= isActive($secondary_nav, 'jam_pelajaran'); ?>"><?= anchor('master/jam_pelajaran', 'Jam Kuliah'); ?></li>
                                <?php endif; ?>

                                <?php if ($auth->has_capability('m_perkuliahan_jenis_ruang')): ?>
                                    <li class="<?= isActive($secondary_nav, 'jenis_ruang'); ?>"><?= anchor('master/jenis_ruang', 'Jenis Ruang'); ?></li>
                                <?php endif; ?>

                                <?php if ($auth->has_capability('m_perkuliahan_ruang_pelajaran')): ?>
                                    <li class="<?= isActive($secondary_nav, 'ruang_pelajaran'); ?>"><?= anchor('master/ruang_pelajaran', 'Ruang Kelas'); ?></li>
                                <?php endif; ?>

                                <?php if ($auth->has_capability('m_perkuliahan_semester')): ?>
                                    <li class="<?= isActive($secondary_nav, 'semester'); ?>"><?= anchor('master/semester', 'Semester'); ?></li>
                                <?php endif; ?>

                                <?php if ($auth->has_capability('m_perkuliahan_bobot_nilai')): ?>
                                    <li class="<?= isActive($secondary_nav, 'bobot_nilai'); ?>"><?= anchor('master/bobot_nilai', 'Bobot Nilai'); ?></li>
                                <?php endif; ?>

                            </ul>
                        </li>
                    <?php endif; ?>

                    <?php if ($auth->has_capability('m_informasi')): ?>
                        <li class="dropdown <?= ($secondary_nav == 'kategori_berita' || $secondary_nav == 'berita' || $secondary_nav == 'polling' || $secondary_nav == 'kategori_unduhan' || $secondary_nav == 'unduhan' || $secondary_nav == 'tanya_jawab') ? 'active' : ''; ?>">
                            <a href="#" data-toggle="dropdown" class="dropdown-toggle">Informasi<b class="caret"></b></a>
                            <ul class="dropdown-menu">

                                <?php if ($auth->has_capability('m_informasi_kategori_berita')): ?>
                                    <li class="<?= isActive($secondary_nav, 'kategori_berita'); ?>"><?= anchor('master/kategori_berita', 'Kategori berita'); ?></li>
                                <?php endif; ?>

                                <?php if ($auth->has_capability('m_informasi_berita')): ?>
                                    <li class="<?= isActive($secondary_nav, 'berita'); ?>"><?= anchor('master/berita', 'Berita'); ?></li>
                                <?php endif; ?>

                            </ul>
                        </li>
                    <?php endif; ?>


                    <?php if ($auth->has_capability('m_dosen')): ?>
                        <li class="dropdown <?= ($secondary_nav == 'dosen') ? 'active' : ''; ?>">
                            <a href="#" data-toggle="dropdown" class="dropdown-toggle">Dosen<b class="caret"></b></a>
                            <ul class="dropdown-menu">

                                <?php if ($auth->has_capability('m_dosen_data_dosen')): ?>
                                    <li class="<?= isActive($secondary_nav, 'dosen'); ?>"><?= anchor('master/dosen', 'Data Dosen'); ?></li>
                                <?php endif; ?>

                            </ul>
                        </li>
                    <?php endif; ?>

                    <?php if ($auth->has_capability('m_pegawai')): ?>
                        <li class="dropdown <?= ($secondary_nav == 'pegawai') ? 'active' : ''; ?>">
                            <a href="#" data-toggle="dropdown" class="dropdown-toggle">Pegawai<b class="caret"></b></a>
                            <ul class="dropdown-menu">

                                <?php if ($auth->has_capability('m_pegawai_data_pegawai')): ?>
                                    <li class="<?= isActive($secondary_nav, 'pegawai'); ?>"><?= anchor('master/pegawai', 'Data Pegawai'); ?></li>
                                <?php endif; ?>

                            </ul>
                        </li>
                    <?php endif; ?>

                    <?php if ($auth->has_capability('m_mahasiswa')): ?>
                        <li class="dropdown <?= ($secondary_nav == 'mahasiswa' || $secondary_nav == 'nilai' || $secondary_nav == 'pangkat' || $secondary_nav == 'kesatuan_asal') ? 'active' : ''; ?>">
                            <a href="#" data-toggle="dropdown" class="dropdown-toggle">Mahasiswa<b class="caret"></b></a>
                            <ul class="dropdown-menu">

                                <?php if ($auth->has_capability('m_mahasiswa_data_mahasiswa')): ?>
                                    <li class="<?= isActive($secondary_nav, 'mahasiswa'); ?>"><?= anchor('master/mahasiswa', 'Data Mahasiswa'); ?></li>
                                <?php endif; ?>

                                <?php if ($auth->has_capability('m_mahasiswa_nilai')): ?>
                                    <li class="<?= isActive($secondary_nav, 'nilai'); ?>"><?= anchor('master/nilai', 'Nilai'); ?></li>
                                <?php endif; ?>

                                <?php if ($auth->has_capability('m_mahasiswa_pangkat')): ?>
                                    <li class="<?= isActive($secondary_nav, 'pangkat'); ?>"><?= anchor('master/pangkat', 'Pangkat'); ?></li>
                                <?php endif; ?>

                                <?php if ($auth->has_capability('m_mahasiswa_kesatuan_asal')): ?>
                                    <li class="<?= isActive($secondary_nav, 'kesatuan_asal'); ?>"><?= anchor('master/kesatuan_asal', 'Kesatuan Asal'); ?></li>
                                <?php endif; ?>

                            </ul>
                        </li>
                    <?php endif; ?>

                    <?php if ($auth->has_capability('m_surat')): ?>
                        <li class="dropdown <?= ($secondary_nav == 'surat_ijin_mengajar' || $secondary_nav == 'direktorat' || $secondary_nav == 'subdirektorat' || $secondary_nav == 'kategori_pejabat' || $secondary_nav == 'pejabat_tanda_tangan') ? 'active' : ''; ?>">
                            <a href="#" data-toggle="dropdown" class="dropdown-toggle">Surat<b class="caret"></b></a>
                            <ul class="dropdown-menu">

                                <?php if ($auth->has_capability('m_surat_direktorat')): ?>
                                    <li class="<?= isActive($secondary_nav, 'direktorat'); ?>"><?= anchor('master/direktorat', 'Direktorat'); ?></li>
                                <?php endif; ?>

                                <?php if ($auth->has_capability('m_surat_subdirektorat')): ?>
                                    <li class="<?= isActive($secondary_nav, 'subdirektorat'); ?>"><?= anchor('master/subdirektorat', 'Sub Direktorat'); ?></li>
                                <?php endif; ?>

                                <?php if ($auth->has_capability('m_surat_kategori_pejabat')): ?>
                                    <li class="<?= isActive($secondary_nav, 'kategori_pejabat'); ?>"><?= anchor('master/kategori_pejabat', 'Kategori Pejabat'); ?></li>
                                <?php endif; ?>

                                <?php if ($auth->has_capability('m_surat_pejabat_tanda_tangan')): ?>
                                    <li class="<?= isActive($secondary_nav, 'pejabat_tanda_tangan'); ?>"><?= anchor('master/pejabat_tanda_tangan', 'Tanda Tangan Pejabat'); ?></li>
                                <?php endif; ?>

                            </ul>
                        </li>
                    <?php endif; ?>

                    <?php if ($auth->has_capability('m_utilitas')): ?>
                        <li class="dropdown <?= ($secondary_nav == 'jenis_kelamin' || $secondary_nav == 'provinsi' || $secondary_nav == 'status_akreditasi' || $secondary_nav == 'status_aktivitas_dosen' || $secondary_nav == 'status_kerja_dosen' || $secondary_nav == 'status_dosen_penasehat' || $secondary_nav == 'status_mata_kuliah' || $secondary_nav == 'golongan' || $secondary_nav == 'jabatan_akademik' || $secondary_nav == 'jabatan_tertinggi' ) ? 'active' : ''; ?>">
                            <a href="#" data-toggle="dropdown" class="dropdown-toggle">Utilitas<b class="caret"></b></a>

                            <ul class="dropdown-menu">

                                <?php if ($auth->has_capability('m_utilitas_golongan')): ?>
                                    <li class="<?= isActive($secondary_nav, 'golongan'); ?>"><?= anchor('master/golongan', 'Golongan'); ?></li>
                                <?php endif; ?>

                                <?php if ($auth->has_capability('m_utilitas_jabatan_akademik')): ?>
                                    <li class="<?= isActive($secondary_nav, 'jabatan_akademik'); ?>"><?= anchor('master/jabatan_akademik', 'Jabatan Akademik'); ?></li>
                                <?php endif; ?>

                                <?php if ($auth->has_capability('m_utilitas_jabatan_tertinggi')): ?>
                                    <li class="<?= isActive($secondary_nav, 'jabatan_tertinggi'); ?>"><?= anchor('master/jabatan_tertinggi', 'Jabatan Tertinggi'); ?></li>
                                <?php endif; ?>

                                <?php if ($auth->has_capability('m_utilitas_jenis_kelamin')): ?>
                                    <li class="<?= isActive($secondary_nav, 'jenis_kelamin'); ?>"><?= anchor('master/jenis_kelamin', 'Jenis Kelamin'); ?></li>
                                <?php endif; ?>

                                <?php if ($auth->has_capability('m_utilitas_provinsi')): ?>
                                    <li class="<?= isActive($secondary_nav, 'provinsi'); ?>"><?= anchor('master/provinsi', 'Provinsi'); ?></li>
                                <?php endif; ?>

                                <?php if ($auth->has_capability('m_utilitas_status_akreditasi')): ?>
                                    <li class="<?= isActive($secondary_nav, 'status_akreditasi'); ?>"><?= anchor('master/status_akreditasi', 'Status Akreditasi'); ?></li>
                                <?php endif; ?>

                                <?php if ($auth->has_capability('m_utilitas_status_aktivitas_dosen')): ?>
                                    <li class="<?= isActive($secondary_nav, 'status_aktivitas_dosen'); ?>"><?= anchor('master/status_aktivitas_dosen', 'Status Aktivitas Dosen'); ?></li>
                                <?php endif; ?>

                                <?php if ($auth->has_capability('m_utilitas_status_kerja_dosen')): ?>
                                    <li class="<?= isActive($secondary_nav, 'status_kerja_dosen'); ?>"><?= anchor('master/status_kerja_dosen', 'Status Kerja Dosen'); ?></li>
                                <?php endif; ?>

                                <?php if ($auth->has_capability('m_utilitas_status_dosen_penasehat')): ?>
                                    <li class="<?= isActive($secondary_nav, 'status_dosen_penasehat'); ?>"><?= anchor('master/status_dosen_penasehat', 'Status Dosen Penasehat'); ?></li>
                                <?php endif; ?>

                                <?php if ($auth->has_capability('m_utilitas_status_mata_kuliah')): ?>
                                    <li class="<?= isActive($secondary_nav, 'status_mata_kuliah'); ?>"><?= anchor('master/status_mata_kuliah', 'Status Mata Kuliah'); ?></li>                      
                                <?php endif; ?>

                            </ul>
                        </li>
                    <?php endif; ?>
            </div>
            <?php
            break;
        case 'transaction':
            ?>
            <div class="subnav subnav-fixed">
                <ul class="nav nav-pills">

                    <?php if ($auth->has_capability('t_kurikulum')): ?>
                        <li class="dropdown <?= ($secondary_nav == 'pake_matakuliah' || $secondary_nav == 'plot_mata_kuliah' || $secondary_nav == 'plot_dosen_penanggung_jawab' || $secondary_nav == 'rencana_mata_pelajaran' || $secondary_nav == 'plot_semester' || $secondary_nav == 'kalender_akademik') ? 'active' : ''; ?>">
                            <a href="#" data-toggle="dropdown" class="dropdown-toggle">Kurikulum<b class="caret"></b></a>
                            <ul class="dropdown-menu">    

                                <?php if ($auth->has_capability('t_kurikulum_plot_mata_kuliah')): ?>
                                    <li class="<?= isActive($secondary_nav, 'plot_mata_kuliah'); ?>"><?= anchor('transaction/plot_mata_kuliah', 'Plot Mata kuliah'); ?></li>                  
                                <?php endif; ?>

                                <?php if ($auth->has_capability('t_kurikulum_paket_matakuliah')): ?>
                                    <li class="<?= isActive($secondary_nav, 'paket_matakuliah'); ?>"><?= anchor('transaction/paket_matakuliah', 'Paket Matakuliah'); ?></li>
                                <?php endif; ?>

                                <?php if ($auth->has_capability('t_kurikulum_plot_dosen_penanggung_jawab')): ?>
                                    <li class="<?= isActive($secondary_nav, 'plot_dosen_penanggung_jawab'); ?>"><?= anchor('transaction/plot_dosen_penanggung_jawab', 'Plot Dosen Penanggung Jawab'); ?></li>  
                                <?php endif; ?>

                                <?php if ($auth->has_capability('t_kurikulum_rencana_mata_pelajaran')): ?>
                                    <li class="<?= isActive($secondary_nav, 'rencana_mata_pelajaran'); ?>"><?= anchor('transaction/rencana_mata_pelajaran', 'Rencana Mata Pelajaran'); ?></li>  
                                <?php endif; ?>

                                <?php if ($auth->has_capability('t_kurikulum_plot_semester')): ?>
                                    <li class="<?= isActive($secondary_nav, 'plot_semester'); ?>"><?= anchor('transaction/plot_semester', 'Plot Semester'); ?></li>                  
                                <?php endif; ?>

                                <?php if ($auth->has_capability('t_kurikulum_kalender_akademik')): ?>
                                    <li class="<?= isActive($secondary_nav, 'kalender_akademik'); ?>"><?= anchor('transaction/kalender_akademik', 'Kalender Akademik'); ?></li>
                                <?php endif; ?>

                            </ul>
                        </li>
                    <?php endif; ?>

                    <?php if ($auth->has_capability('t_jadwal_perkuliahan')): ?>
                        <li class="dropdown <?= ($secondary_nav == 'jadwal_induk' || $secondary_nav == 'jadwal_kuliah' || $secondary_nav == 'jadwal_ujian' || $secondary_nav == 'ujian_skripsi' || $secondary_nav == 'plot_kelas' || $secondary_nav == 'absensi_mahasiswa' || $secondary_nav == 'absensi_dosen') ? 'active' : ''; ?>">
                            <a href="#" data-toggle="dropdown" class="dropdown-toggle">Jadwal Perkuliahan<b class="caret"></b></a>
                            <ul class="dropdown-menu">     

                                <?php if ($auth->has_capability('t_jadwal_perkuliahan_jadwal_induk')): ?>
                                    <li class="<?= isActive($secondary_nav, 'jadwal_induk'); ?>"><?= anchor('transaction/jadwal_induk', 'Jadwal Induk'); ?></li>             
                                <?php endif; ?>

                                <?php if ($auth->has_capability('t_jadwal_perkuliahan_jadwal_kuliah')): ?>
                                    <li class="<?= isActive($secondary_nav, 'jadwal_kuliah'); ?>"><?= anchor('transaction/jadwal_kuliah', 'Jadwal Kuliah'); ?></li>
                                <?php endif; ?>

                                <?php if ($auth->has_capability('t_jadwal_perkuliahan_jadwal_ujian')): ?>
                                    <li class="<?= isActive($secondary_nav, 'jadwal_ujian'); ?>"><?= anchor('transaction/jadwal_ujian', 'Jadwal Ujian'); ?></li>
                                <?php endif; ?>

                                <?php if ($auth->has_capability('t_jadwal_perkuliahan_ujian_skripsi')): ?>
                                    <li class="<?= isActive($secondary_nav, 'ujian_skripsi'); ?>"><?= anchor('transaction/ujian_skripsi', 'Jadwal Skripsi'); ?></li>
                                <?php endif; ?>

                                <?php if ($auth->has_capability('t_jadwal_perkuliahan_absensi_mahasiswa')): ?>
                                    <li class="<?= isActive($secondary_nav, 'absensi_mahasiswa'); ?>"><?= anchor('transaction/absensi_mahasiswa', 'Absensi Mahasiswa'); ?></li>
                                <?php endif; ?>

                                <?php if ($auth->has_capability('t_jadwal_perkuliahan_absensi_dosen')): ?>
                                    <li class="<?= isActive($secondary_nav, 'absensi_dosen'); ?>"><?= anchor('transaction/absensi_dosen', 'Absensi Dosen'); ?></li>
                                <?php endif; ?>

                                <?php if ($auth->has_capability('t_jadwal_perkuliahan_absensi_ujian_mahasiswa')): ?>
                                    <li class="<?= isActive($secondary_nav, 'absensi_ujian_mahasiswa'); ?>"><?= anchor('transaction/absensi_ujian_mahasiswa', 'Absensi Ujian Mahasiswa'); ?></li>
                                <?php endif; ?>

                                <?php if ($auth->has_capability('t_jadwal_perkuliahan_absensi_ujian_dosen')): ?>
                                    <li class="<?= isActive($secondary_nav, 'absensi_ujian_dosen'); ?>"><?= anchor('transaction/absensi_ujian_dosen', 'Absensi Ujian Dosen'); ?></li>
                                <?php endif; ?>

                            </ul>
                        </li>
                    <?php endif; ?>

                    <?php if ($auth->has_capability('t_nilai_mahasiswa')): ?>
                        <li class="dropdown <?= ($secondary_nav == 'nilai_ipk' || $secondary_nav == 'nilai_akademik' || $secondary_nav == 'nilai_fisik' || $secondary_nav == 'nilai_mental') ? 'active' : ''; ?>">
                            <a href="#" data-toggle="dropdown" class="dropdown-toggle">Nilai Mahasiswa<b class="caret"></b></a>
                            <ul class="dropdown-menu">            

                                <?php if ($auth->has_capability('t_nilai_mahasiswa_nilai_akademik')): ?>
                                    <li class="<?= isActive($secondary_nav, 'nilai_akademik'); ?>"><?= anchor('transaction/nilai_akademik', 'Nilai Akademik'); ?></li>
                                <?php endif; ?>

                                <?php if ($auth->has_capability('t_nilai_mahasiswa_nilai_fisik')): ?>
                                    <li class="<?= isActive($secondary_nav, 'nilai_fisik'); ?>"><?= anchor('transaction/nilai_fisik', 'Nilai Fisik'); ?></li>
                                <?php endif; ?>

                                <?php if ($auth->has_capability('t_nilai_mahasiswa_nilai_mental')): ?>
                                    <li class="<?= isActive($secondary_nav, 'nilai_mental'); ?>"><?= anchor('transaction/nilai_mental', 'Nilai Mental'); ?></li>
                                <?php endif; ?>

                                <?php if ($auth->has_capability('t_nilai_mahasiswa_nilai_ipk')): ?>
                                    <li class="<?= isActive($secondary_nav, 'nilai_ipk'); ?>"><?= anchor('transaction/nilai_ipk', 'Nilai IPK'); ?></li>
                                <?php endif; ?>

                            </ul>
                        </li>
                    <?php endif; ?>

                    <?php if ($auth->has_capability('t_skripsi')): ?>
                        <li class="dropdown <?= ($secondary_nav == 'pengajuan_skripsi' || $secondary_nav == 'jadwal_ujian_skripsi' || $secondary_nav == 'nilai_skripsi') ? 'active' : ''; ?>">
                            <a href="#" data-toggle="dropdown" class="dropdown-toggle">Skripsi<b class="caret"></b></a>
                            <ul class="dropdown-menu">        

                                <?php if ($auth->has_capability('t_skripsi_pengajuan_skripsi')): ?>
                                    <li class="<?= isActive($secondary_nav, 'pengajuan_skripsi'); ?>"><?= anchor('transaction/pengajuan_skripsi', 'Pengajuan Skripsi'); ?></li>
                                <?php endif; ?>

                                <?php if ($auth->has_capability('t_skripsi_nilai_skripsi')): ?>
                                    <li class="<?= isActive($secondary_nav, 'nilai_skripsi'); ?>"><?= anchor('transaction/nilai_skripsi', 'Nilai Skripsi'); ?></li>
                                <?php endif; ?>    

                            </ul>
                        </li>
                    <?php endif; ?>

                    <?php if ($auth->has_capability('t_penasehat_akademik')): ?>
                        <li class="<?= isActive($secondary_nav, 'penasehat_akademik'); ?>"><?= anchor('transaction/penasehat_akademik', 'Penasehat Akademik'); ?></li>
                    <?php endif; ?>

                </ul>
            </div>
            <?php
            break;
        case 'admin':
            ?>
            <div class="subnav subnav-fixed">
                <ul class="nav nav-pills">

                    <?php if ($auth->has_capability('a_users')): ?>
                        <li class="<?= isActive($secondary_nav, 'users') ? 'active' : ''; ?>"><?= anchor('admin/users', 'Users'); ?></li>
                    <?php endif; ?>

                    <?php if ($auth->has_capability('a_roles')): ?>
                        <li class="<?= isActive($secondary_nav, 'roles') ? 'active' : ''; ?>"><?= anchor('admin/roles', 'Roles'); ?></li>
                    <?php endif; ?>

                    <?php if ($auth->has_capability('a_capabilities')): ?>
                        <li class="<?= isActive($secondary_nav, 'capabilities') ? 'active' : ''; ?>"><?= anchor('admin/capabilities', 'Capabilities'); ?></li>
                    <?php endif; ?>

                    <?php if ($auth->has_capability('a_options')): ?>
                        <li class="<?= isActive($secondary_nav, 'options') ? 'active' : ''; ?>"><?= anchor('admin/options', 'Options'); ?></li>
                    <?php endif; ?>

                </ul>
            </div>
            <?php
            break;
        case 'laporan':
            ?>
            <div class="subnav subnav-fixed">           
                <ul class="nav nav-pills">
                    <?php if ($auth->has_capability('r_laporan_kurikulum')): ?>
                        <li class="dropdown <?= ($secondary_nav == 'laporan_daftar_matakuliah_paket' || $secondary_nav == 'laporan_kalender_akademik') ? 'active' : ''; ?>">
                            <a href="#" data-toggle="dropdown" class="dropdown-toggle">Laporan Kurikulum<b class="caret"></b></a>
                            <ul class="dropdown-menu">     

                                <?php if ($auth->has_capability('r_kurikulum_daftar_mata_kuliah_paket')): ?>
                                    <li class="<?= isActive($secondary_nav, 'laporan_daftar_matakuliah_paket'); ?>"><?= anchor('laporan/laporan_daftar_matakuliah_paket', 'Laporan Daftar Mata Kuliah Paket'); ?></li>
                                <?php endif; ?>

                                <?php if ($auth->has_capability('r_kurikulum_kalender_akademik')): ?>                              
                                    <li class="<?= isActive($secondary_nav, 'laporan_kalender_akademik'); ?>"><?= anchor('laporan/laporan_kalender_akademik', 'Laporan Kalender Akademik'); ?></li>
                                <?php endif; ?>

                            </ul>
                        </li>
                    <?php endif; ?>

                    <?php if ($auth->has_capability('r_daftar_mahasiswa')): ?>
                        <li class="<?= isActive($secondary_nav, 'laporan_daftar_mahasiswa'); ?>"><?= anchor('laporan/laporan_daftar_mahasiswa', 'Laporan Daftar Mahasiswa'); ?></li>
                    <?php endif; ?>

                    <?php if ($auth->has_capability('r_daftar_dosen')): ?>
                        <li class="<?= isActive($secondary_nav, 'laporan_daftar_dosen'); ?>"><?= anchor('laporan/laporan_daftar_dosen', 'Laporan Daftar Dosen'); ?></li>
                    <?php endif; ?>

                    <?php if ($auth->has_capability('r_laporan_perkuliahan')): ?>
                        <li class="dropdown <?= ($secondary_nav == 'laporan_daftar_ruang' || $secondary_nav == 'laporan_jadwal_perkuliahan' || $secondary_nav == 'laporan_jadwal_ujian' || $secondary_nav == 'laporan_rekap_absensi_mahasiswa' || $secondary_nav == 'laporan_rekap_absensi_dosen') ? 'active' : ''; ?>">
                            <a href="#" data-toggle="dropdown" class="dropdown-toggle">Laporan Perkuliahan<b class="caret"></b></a>
                            <ul class="dropdown-menu">    

                                <?php if ($auth->has_capability('r_perkuliahan_daftar_ruang')): ?>
                                    <li class="<?= isActive($secondary_nav, 'laporan_daftar_ruang'); ?>"><?= anchor('laporan/laporan_daftar_ruang', 'Laporan Daftar Ruang'); ?></li>
                                <?php endif; ?>

                                <?php if ($auth->has_capability('r_perkuliahan_jadwal_perkuliahan')): ?>
                                    <li class="<?= isActive($secondary_nav, 'laporan_jadwal_perkuliahan'); ?>"><?= anchor('laporan/laporan_jadwal_perkuliahan', 'Laporan Jadwal Perkuliahan'); ?></li>
                                <?php endif; ?>

                                <?php if ($auth->has_capability('r_perkuliahan_jadwal_ujian')): ?>
                                    <li class="<?= isActive($secondary_nav, 'laporan_jadwal_ujian'); ?>"><?= anchor('laporan/laporan_jadwal_ujian', 'Laporan Jadwal Ujian'); ?></li>
                                <?php endif; ?>

                                <?php if ($auth->has_capability('r_perkuliahan_rekap_absensi_mahasiswa')): ?>
                                    <li class="<?= isActive($secondary_nav, 'laporan_rekap_absensi_mahasiswa'); ?>"><?= anchor('laporan/laporan_rekap_absensi_mahasiswa', 'Laporan Rekap Absensi Mahasiswa'); ?></li>
                                <?php endif; ?>

                                <?php if ($auth->has_capability('r_perkuliahan_format_absensi_dosen')): ?>
                                    <li class="<?= isActive($secondary_nav, 'laporan_rekap_absensi_dosen'); ?>"><?= anchor('laporan/laporan_rekap_absensi_dosen', 'Laporan Format Absensi Dosen'); ?></li>
                                <?php endif; ?>

                            </ul>
                        </li>
                    <?php endif; ?>

                    <?php if ($auth->has_capability('r_laporan_nilai')): ?>
                        <li class="dropdown <?= ($secondary_nav == 'lembar_hasil_studi' || $secondary_nav == 'laporan_nilai_akademik' || $secondary_nav == 'laporan_peringkat_kelulusan_nilai_akhir' || $secondary_nav == 'laporan_peringkat_kelulusan_nilai_akhir' || $secondary_nav == 'laporan_ranking_per_matakuliah' || $secondary_nav == 'laporan_ip' || $secondary_nav == 'laporan_ipk') ? 'active' : ''; ?>">
                            <a href="#" data-toggle="dropdown" class="dropdown-toggle">Laporan Nilai<b class="caret"></b></a>
                            <ul class="dropdown-menu">     

                                <?php if ($auth->has_capability('r_nilai_khs')): ?>
                                    <li class="<?= isActive($secondary_nav, 'lembar_hasil_studi'); ?>"><?= anchor('laporan/lembar_hasil_studi', 'Laporan KHS'); ?></li>
                                <?php endif; ?>

                                <?php if ($auth->has_capability('r_nilai_transkip_nilai')): ?>
                                    <li class="<?= isActive($secondary_nav, 'laporan_nilai_akademik'); ?>"><?= anchor('laporan/laporan_nilai_akademik', 'Laporan Transkip Nilai'); ?></li>
                                <?php endif; ?>

                                <?php if ($auth->has_capability('r_nilai_peringkat_kelulusan_nilai_akhir')): ?>
                                    <li class="<?= isActive($secondary_nav, 'laporan_peringkat_kelulusan_nilai_akhir'); ?>"><?= anchor('laporan/laporan_peringkat_kelulusan_nilai_akhir', 'Laporan Peringkat Kelulusan Nilai Akhir'); ?></li>
                                <?php endif; ?>

                                <?php if ($auth->has_capability('r_nilai_peringkat_kelulusan_akademik')): ?>
                                    <li class="<?= isActive($secondary_nav, 'laporan_peringkat_kelulusan_akademik'); ?>"><?= anchor('laporan/laporan_peringkat_kelulusan_akademik', 'Laporan Peringkat Kelulusan Akademik'); ?></li>
                                <?php endif; ?>

                                <?php if ($auth->has_capability('r_nilai_ranking_per_matakuliah')): ?>
                                    <li class="<?= isActive($secondary_nav, 'laporan_ranking_per_matakuliah'); ?>"><?= anchor('laporan/laporan_ranking_per_matakuliah', 'Laporan Ranking Per Matakuliah'); ?></li>
                                <?php endif; ?>

                                <?php if ($auth->has_capability('r_nilai_ip')): ?>
                                    <li class="<?= isActive($secondary_nav, 'laporan_ip'); ?>"><?= anchor('laporan/laporan_ip', 'Laporan IP'); ?></li>
                                <?php endif; ?>

                                <?php if ($auth->has_capability('r_nilai_ipk')): ?>
                                    <li class="<?= isActive($secondary_nav, 'laporan_ipk'); ?>"><?= anchor('laporan/laporan_ipk', 'Laporan IPK'); ?></li>
                                <?php endif; ?>

                            </ul>
                        </li>
                    <?php endif; ?>
            </div>
            <?php
            break;
        case 'modul':
            ?>
            <div class="subnav subnav-fixed">           
                <li class="dropdown <?= ($secondary_nav == 'kategori_sample' || $secondary_nav == 'sample') ? 'active' : ''; ?>">
                    <a href="#" data-toggle="dropdown" class="dropdown-toggle">Modul<b class="caret"></b></a>
                    <ul class="dropdown-menu">

                        <?php if ($auth->has_capability('')): ?>
                            <li class="<?= isActive($secondary_nav, 'sample'); ?>"><?= anchor('master/sample', 'Akademik'); ?></li>
                        <?php endif; ?>

                        <?php if ($auth->has_capability('')): ?>
                            <li class="<?= isActive($secondary_nav, 'sample'); ?>"><?= anchor('master/sample', 'Kemahasiswaan'); ?></li>
                        <?php endif; ?>

                        <?php if ($auth->has_capability('')): ?>
                            <li class="<?= isActive($secondary_nav, 'sample'); ?>"><?= anchor('master/sample', 'Kepegawaian'); ?></li>
                        <?php endif; ?>

                        <?php if ($auth->has_capability('')): ?>
                            <li class="<?= isActive($secondary_nav, 'sample'); ?>"><?= anchor('master/sample', 'Layanan Dosen'); ?></li>
                        <?php endif; ?>

                        <?php if ($auth->has_capability('')): ?>
                            <li class="<?= isActive($secondary_nav, 'sample'); ?>"><?= anchor('master/sample', 'Layanan Pimpinan'); ?></li>
                        <?php endif; ?>

                        <?php if ($auth->has_capability('')): ?>
                            <li class="<?= isActive($secondary_nav, 'sample'); ?>"><?= anchor('master/sample', 'Layanan Mahasiswa'); ?></li>
                        <?php endif; ?>

                        <?php if ($auth->has_capability('')): ?>
                            <li class="<?= isActive($secondary_nav, 'sample'); ?>"><?= anchor('master/sample', 'Komunitas'); ?></li>
                        <?php endif; ?>

                        <?php if ($auth->has_capability('')): ?>
                            <li class="<?= isActive($secondary_nav, 'sample'); ?>"><?= anchor('master/sample', 'Utilitas'); ?></li>
                        <?php endif; ?>

                        <?php if ($auth->has_capability('')): ?>
                            <li class="<?= isActive($secondary_nav, 'sample'); ?>"><?= anchor('master/sample', 'Konfigurasi'); ?></li>
                        <?php endif; ?>

                    </ul>
                </li>
            </div>
            <?php
            break;
    }
    ?>
    <?php if (isset($page_title)): ?>

        <div class="well">
            <b class="pull-left"><?php
    $num_results = (isset($num_results)) ? ' <span class="badge"> ' . $num_results . ' </span> ' : ' ';
    echo (isset($page_title)) ? $num_results . strtoupper($page_title) : '';
        ?></b>
            <div class="pull-right">
                <div class="btn-group">
                    <?php
                    if (isset($tools)) {
                        foreach ($tools as $url => $link_label) {
                            $icon = '';
                            $anchor_attr = 'class="btn btn-mini"';
                            switch (strtolower($link_label)) {
                                case 'new':$icon = 'icon-plus';
                                    break;
                                case 'back':$icon = 'icon-arrow-left';
                                    break;
                                case 'edit':$icon = 'icon-pencil';
                                    break;
                                case 'delete':
                                    $icon = 'icon-trash';
                                    $anchor_attr = 'class="btn btn-mini" onclick="return confirm_it(\'Anda yakin akan menghapus data ini ?\');" ';
                                    break;
                                case 'batal':
                                    $icon = 'icon-trash';
                                    $anchor_attr = 'class="btn btn-mini" onclick="return confirm_it(\'Anda yakin ingin membatalkan WO ini ?\');" ';
                                    break;
                            }
                            echo anchor(site_url($url), '<i class="' . $icon . '"></i> ' . $link_label, $anchor_attr);
                        }
                    }
                    ?>
                </div>
            </div>
            <?php if (isset($group_by)): //sementara ditutup, diset di controller   ?>
                <ul class="nav nav-pills pull-left centered">
                    <li <?php if ($sort_by == 'no_polisi') echo 'class="active"'; ?>><?= anchor('master/kendaraan', 'Kendaraan [ ' . $count_kendaraan . ' ]'); ?></li>
                    <li <?php if ($sort_by == 'merk_id') echo 'class="active"'; ?>><?= anchor('master/kendaraan/view/1/merk_id', 'Merk [ ' . $count_merk . ' ]'); ?></li>
                    <li <?php if ($sort_by == 'jenis_id') echo 'class="active"'; ?>><?= anchor('master/kendaraan/view/1/jenis_id', 'Jenis [ ' . $count_jenis . ' ]'); ?></li>
                </ul> 
            <?php endif; ?>
        </div>

    <?php endif; ?>