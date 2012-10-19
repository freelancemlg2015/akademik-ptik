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
            <a href="#" class="brand">STIK-PTIK AKADEMIK App&trade;</a>
            <ul class="nav">

                <li class="<?= isActive($primary_nav, 'home') ?>"><?= anchor('home', isIconActive($primary_nav, 'home', 'icon-home')) ?></li>
                <li class="<?= isActive($primary_nav, 'master'); ?>"><?= anchor('master', isIconActive($primary_nav, 'sample', 'icon-hdd') . ' Master'); ?></li>
                <li class="<?= ($this->uri->segment(1) == 'transaction') ? 'active' : ''; ?>"><?= anchor('transaction', isIconActive($primary_nav, 'transaction', 'icon-list-alt') . ' Transaksi'); ?></li>
                <li class="<?= isActive($primary_nav, 'laporan'); ?>"><?= anchor('laporan', isIconActive($primary_nav, 'laporan', 'icon-info-sign') . ' Laporan'); ?></li>
<!--            <li class="<?//= isActive($primary_nav, 'modul') ? 'active' : ''; ?>"><?//= anchor('modul', isIconActive($primary_nav, 'modul', 'icon-folder-open') . ' Modul'); ?></li>-->
<!--            <li class="<?//= isActive($primary_nav, 'forum') ? 'active' : ''; ?>"><?//= anchor('forum', isIconActive($primary_nav, 'forum', 'icon-th-list') . ' Forum'); ?></li>-->
                <li class="<?= isActive($primary_nav, 'help') ? 'active' : ''; ?>"><?= anchor('help', isIconActive($primary_nav, 'help', 'icon-question-sign') . ' Bantuan'); ?></li>
                <li class="<?= isActive($primary_nav, 'admin'); ?>"><?= anchor('admin', isIconActive($primary_nav, 'admin', 'icon-cog') . ' Admin'); ?></li>              

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

                    <li class="dropdown <?= ($secondary_nav == 'direktorat' || $secondary_nav == 'subdirektorat') ? 'active' : ''; ?>">
                        <a href="#" data-toggle="dropdown" class="dropdown-toggle">Akademik<b class="caret"></b></a>
                        <ul class="dropdown-menu">
                            <li class="<?= isActive($secondary_nav, 'direktorat'); ?>"><?= anchor('master/direktorat', 'Direktorat'); ?></li>
                            <li class="<?= isActive($secondary_nav, 'subdirektorat'); ?>"><?= anchor('master/subdirektorat', 'Sub Direktorat'); ?></li>
                        </ul>
                    </li>

                    <li class="dropdown <?= ($secondary_nav == 'program_studi' || $secondary_nav == 'tahun_akademik' || $secondary_nav == 'kelompok_matakuliah' || $secondary_nav == 'matakuliah' || $secondary_nav == 'jenjang_studi' || $secondary_nav == 'frekuensi_pemutakhiran' || $secondary_nav == 'pelaksana_pemutakhiran' || $secondary_nav == 'angkatan') ? 'active' : ''; ?>">
                        <a href="#" data-toggle="dropdown" class="dropdown-toggle">Kurikulum<b class="caret"></b></a>
                        <ul class="dropdown-menu">
                            <li class="<?= isActive($secondary_nav, 'angkatan'); ?>"><?= anchor('master/angkatan', 'Angkatan'); ?></li>
                            <li class="<?= isActive($secondary_nav, 'program_studi'); ?>"><?= anchor('master/program_studi', 'Program Studi'); ?></li>
                            <li class="<?= isActive($secondary_nav, 'tahun_akademik'); ?>"><?= anchor('master/tahun_akademik', 'Tahun Akademik'); ?></li>
                            <li class="<?= isActive($secondary_nav, 'mata_kuliah'); ?>"><?= anchor('master/mata_kuliah', 'Mata kuliah'); ?></li>
                            <li class="<?= isActive($secondary_nav, 'jenjang_studi'); ?>"><?= anchor('master/jenjang_studi', 'Jenjang Studi'); ?></li>
<!--                        <li class="<?//= isActive($secondary_nav, 'konsentrasi_studi'); ?>"><?//= anchor('master/konsentrasi_studi', 'Konsentrasi Studi'); ?></li>                           
                            <li class="<?//= isActive($secondary_nav, 'frekuensi_pemutakhiran'); ?>"><?//= anchor('master/frekuensi_pemutakhiran', 'Frekuensi Pemutakhiran'); ?></li>
                            <li class="<?//= isActive($secondary_nav, 'pelaksana_pemutakhiran'); ?>"><?//= anchor('master/pelaksana_pemutakhiran', 'Pelaksana Pemutakhiran'); ?></li>-->
                        </ul>
                    </li>

                    <li class="dropdown <?= ($secondary_nav == 'jam_pelajaran' || $secondary_nav == 'ruang_pelajaran' || $secondary_nav == 'jenis_ruang' || $secondary_nav == 'semester' || $secondary_nav == 'semester_mulai_aktivitas' || $secondary_nav == 'akta_mengajar' || $secondary_nav == 'bobot_nilai' || $secondary_nav == 'golongan' || $secondary_nav == 'jabatan_akademik' || $secondary_nav == 'jabatan_tertinggi') ? 'active' : ''; ?>">
                        <a href="#" data-toggle="dropdown" class="dropdown-toggle">Perkuliahan<b class="caret"></b></a>
                        <ul class="dropdown-menu">
                            <li class="<?= isActive($secondary_nav, 'jam_pelajaran'); ?>"><?= anchor('master/jam_pelajaran', 'Jam Pelajaran'); ?></li>
                            <li class="<?= isActive($secondary_nav, 'ruang_pelajaran'); ?>"><?= anchor('master/ruang_pelajaran', 'Ruang Pelajaran'); ?></li>
                            <li class="<?= isActive($secondary_nav, 'jenis_ruang'); ?>"><?= anchor('master/jenis_ruang', 'Jenis Ruang'); ?></li>
                            <li class="<?= isActive($secondary_nav, 'semester'); ?>"><?= anchor('master/semester', 'Semester'); ?></li>
<!--                        <li class="<?//= isActive($secondary_nav, 'semester_mulai_aktivitas'); ?>"><?//= anchor('master/semester_mulai_aktivitas', 'Semester Mulai Aktivitas'); ?></li>  
                            <li class="<?//= isActive($secondary_nav, 'akta_mengajar'); ?>"><?//= anchor('master/akta_mengajar', 'Akta Mengajar'); ?></li>-->
                            <li class="<?= isActive($secondary_nav, 'bobot_nilai'); ?>"><?= anchor('master/bobot_nilai', 'Bobot Nilai'); ?></li>
                            <li class="<?= isActive($secondary_nav, 'golongan'); ?>"><?= anchor('master/golongan', 'Golongan'); ?></li>
                            <li class="<?= isActive($secondary_nav, 'jabatan_akademik'); ?>"><?= anchor('master/jabatan_akademik', 'Jabatan Akademik'); ?></li>
                            <li class="<?= isActive($secondary_nav, 'jabatan_tertinggi'); ?>"><?= anchor('master/jabatan_tertinggi', 'Jabatan Tertinggi'); ?></li>
                        </ul>
                    </li>

                    <li class="dropdown <?= ($secondary_nav == 'kategori_berita' || $secondary_nav == 'berita' || $secondary_nav == 'polling' || $secondary_nav == 'kategori_unduhan' || $secondary_nav == 'unduhan' || $secondary_nav == 'tanya_jawab') ? 'active' : ''; ?>">
                        <a href="#" data-toggle="dropdown" class="dropdown-toggle">Informasi<b class="caret"></b></a>
                        <ul class="dropdown-menu">
                            <li class="<?= isActive($secondary_nav, 'kategori_berita'); ?>"><?= anchor('master/kategori_berita', 'Kategori berita'); ?></li>
                            <li class="<?= isActive($secondary_nav, 'berita'); ?>"><?= anchor('master/berita', 'Berita'); ?></li>
                            <li class="<?= isActive($secondary_nav, 'kategori_unduhan'); ?>"><?= anchor('master/kategori_unduhan', 'Kategori Unduhan'); ?></li>
                            <li class="<?= isActive($secondary_nav, 'unduhan'); ?>"><?= anchor('master/unduhan', 'Unduhan'); ?></li>
<!--                        <li class="<?//= isActive($secondary_nav, 'polling'); ?>"><?//= anchor('master/polling', 'Polling'); ?></li>
                            <li class="<?//= isActive($secondary_nav, 'tanya_jawab'); ?>"><?//= anchor('master/tanya_jawab', 'Tanya Jawab'); ?></li>-->

                        </ul>
                    </li>

                    <li class="dropdown <?= ($secondary_nav == 'dosen') ? 'active' : ''; ?>">
                        <a href="#" data-toggle="dropdown" class="dropdown-toggle">Dosen<b class="caret"></b></a>
                        <ul class="dropdown-menu">
                            <li class="<?= isActive($secondary_nav, 'dosen'); ?>"><?= anchor('master/dosen', 'Data Dosen'); ?></li>
                        </ul>
                    </li>

                    <li class="dropdown <?= ($secondary_nav == 'mahasiswa' || $secondary_nav == 'nilai' || $secondary_nav == 'pangkat' || $secondary_nav == 'kesatuan_asal') ? 'active' : ''; ?>">
                        <a href="#" data-toggle="dropdown" class="dropdown-toggle">Mahasiswa<b class="caret"></b></a>
                        <ul class="dropdown-menu">
                            <li class="<?= isActive($secondary_nav, 'mahasiswa'); ?>"><?= anchor('master/mahasiswa', 'Data Mahasiswa'); ?></li>
                            <li class="<?= isActive($secondary_nav, 'nilai'); ?>"><?= anchor('master/nilai', 'Nilai'); ?></li>
                            <li class="<?= isActive($secondary_nav, 'pangkat'); ?>"><?= anchor('master/pangkat', 'Pangkat'); ?></li>
                            <li class="<?= isActive($secondary_nav, 'kesatuan_asal'); ?>"><?= anchor('master/kesatuan_asal', 'Kesatuan Asal'); ?></li>
                        </ul>
                    </li>

                    <li class="dropdown <?= ($secondary_nav == 'surat_ijin_mengajar') ? 'active' : ''; ?>">
                        <a href="#" data-toggle="dropdown" class="dropdown-toggle">Surat<b class="caret"></b></a>
                        <ul class="dropdown-menu">
                            <li class="<?= isActive($secondary_nav, 'surat_ijin_mengajar'); ?>"><?= anchor('master/surat_ijin_mengajar', 'Surat Ijin Mengajar'); ?></li>
                        </ul>
                    </li>

                    <li class="dropdown <?= ($secondary_nav == 'jenis_kelamin' || $secondary_nav == 'provinsi' || $secondary_nav == 'kategori_pejabat' || $secondary_nav == 'status_akreditasi' || $secondary_nav == 'status_aktivitas_dosen' || $secondary_nav == 'status_kerja_dosen' || $secondary_nav == 'status_dosen_penasehat' || $secondary_nav == 'status_mata_kuliah') ? 'active' : ''; ?>">
                        <a href="#" data-toggle="dropdown" class="dropdown-toggle">Lain-Lain<b class="caret"></b></a>
                        <ul class="dropdown-menu">
                            <li class="<?= isActive($secondary_nav, 'jenis_kelamin'); ?>"><?= anchor('master/jenis_kelamin', 'Jenis Kelamin'); ?></li>
                            <li class="<?= isActive($secondary_nav, 'provinsi'); ?>"><?= anchor('master/provinsi', 'Provinsi'); ?></li>
                            <li class="<?= isActive($secondary_nav, 'kategori_pejabat'); ?>"><?= anchor('master/kategori_pejabat', 'Kategori Pejabat'); ?></li>
                            <li class="<?= isActive($secondary_nav, 'pejabat_tanda_tangan'); ?>"><?= anchor('master/pejabat_tanda_tangan', 'Tanda Tangan Pejabat'); ?></li>
                            <li class="<?= isActive($secondary_nav, 'status_akreditasi'); ?>"><?= anchor('master/status_akreditasi', 'Status Akreditasi'); ?></li>
                            <li class="<?= isActive($secondary_nav, 'status_aktivitas_dosen'); ?>"><?= anchor('master/status_aktivitas_dosen', 'Status Aktivitas Dosen'); ?></li>
                            <li class="<?= isActive($secondary_nav, 'status_kerja_dosen'); ?>"><?= anchor('master/status_kerja_dosen', 'Status Kerja Dosen'); ?></li>
                            <li class="<?= isActive($secondary_nav, 'status_dosen_penasehat'); ?>"><?= anchor('master/status_dosen_penasehat', 'Status Dosen Penasehat'); ?></li>
                            <li class="<?= isActive($secondary_nav, 'status_mata_kuliah'); ?>"><?= anchor('master/status_mata_kuliah', 'Status Mata Kuliah'); ?></li>                      

                        </ul>
                    </li>

                </ul>

            </div><?php
        break;
    case 'transaction':
            ?>
            <div class="subnav subnav-fixed">
                <ul class="nav nav-pills">

                    <li class="dropdown <?= ($secondary_nav == 'pake_matakuliah' || $secondary_nav == 'plot_mata_kuliah' || $secondary_nav == 'plot_dosen_penanggung_jawab' || $secondary_nav == 'rencana_mata_pelajaran' || $secondary_nav == 'plot_semester' || $secondary_nav == 'kalender_akademik') ? 'active' : ''; ?>">
                        <a href="#" data-toggle="dropdown" class="dropdown-toggle">Kurikulum<b class="caret"></b></a>
                        <ul class="dropdown-menu">    
                            <li class="<?= isActive($secondary_nav, 'plot_mata_kuliah'); ?>"><?= anchor('transaction/plot_mata_kuliah', 'Plot Mata kuliah'); ?></li>                  
                            <li class="<?= isActive($secondary_nav, 'paket_matakuliah'); ?>"><?= anchor('transaction/paket_matakuliah', 'Paket Matakuliah'); ?></li>
                            <li class="<?= isActive($secondary_nav, 'plot_dosen_penanggung_jawab'); ?>"><?= anchor('transaction/plot_dosen_penanggung_jawab', 'Plot Dosen Penanggung Jawab'); ?></li>  
                            <li class="<?= isActive($secondary_nav, 'rencana_mata_pelajaran'); ?>"><?= anchor('transaction/rencana_mata_pelajaran', 'Rencana Mata Pelajaran'); ?></li>  
                            <li class="<?= isActive($secondary_nav, 'plot_semester'); ?>"><?= anchor('transaction/plot_semester', 'Plot Semester'); ?></li>                  

                            <li class="<?= isActive($secondary_nav, 'kalender_akademik'); ?>"><?= anchor('transaction/kalender_akademik', 'Kalender Akademik'); ?></li>

                        </ul>
                    </li>

                    <li class="dropdown <?= ($secondary_nav == 'jadwal_kuliah' || $secondary_nav == 'jadwal_ujian' ||$secondary_nav == 'ujian_skripsi' || $secondary_nav == 'plot_kelas' || $secondary_nav == 'absensi_mahasiswa' || $secondary_nav == 'absensi_dosen') ? 'active' : ''; ?>">
                        <a href="#" data-toggle="dropdown" class="dropdown-toggle">Jadwal Perkuliahan<b class="caret"></b></a>
                        <ul class="dropdown-menu">     
                            <?php /*?><li class="<?= isActive($secondary_nav, 'plot_kelas'); ?>"><?= anchor('transaction/plot_kelas', 'Plot Kelas'); ?></li><?php */?>               
                            <li class="<?= isActive($secondary_nav, 'jadwal_kuliah'); ?>"><?= anchor('transaction/jadwal_kuliah', 'Jadwal Kuliah'); ?></li>
                            <li class="<?= isActive($secondary_nav, 'jadwal_ujian'); ?>"><?= anchor('transaction/jadwal_ujian', 'Jadwal Ujian'); ?></li>
                            <li class="<?= isActive($secondary_nav, 'ujian_skripsi'); ?>"><?= anchor('transaction/ujian_skripsi', 'Jadwal Skripsi'); ?></li>
                            <li class="<?= isActive($secondary_nav, 'absensi_mahasiswa'); ?>"><?= anchor('transaction/absensi_mahasiswa', 'Absensi Mahasiswa'); ?></li>
                            <li class="<?= isActive($secondary_nav, 'absensi_dosen'); ?>"><?= anchor('transaction/absensi_dosen', 'Absensi Dosen'); ?></li>
                            <li class="<?= isActive($secondary_nav, 'absensi_mahasiswa'); ?>"><?= anchor('transaction/absensi_mahasiswa', 'Absensi Ujian Mahasiswa'); ?></li>
                            <li class="<?= isActive($secondary_nav, 'absensi_dosen'); ?>"><?= anchor('transaction/absensi_dosen', 'Absensi Ujian Dosen'); ?></li>

                        </ul>
                    </li>

                    <li class="dropdown <?= ($secondary_nav == 'nilai_ipk' || $secondary_nav == 'nilai_akademik' || $secondary_nav == 'nilai_fisik' || $secondary_nav == 'nilai_mental') ? 'active' : ''; ?>">
                        <a href="#" data-toggle="dropdown" class="dropdown-toggle">Nilai Mahasiswa<b class="caret"></b></a>
                        <ul class="dropdown-menu">                      
                            <li class="<?= isActive($secondary_nav, 'nilai_akademik'); ?>"><?= anchor('transaction/nilai_akademik', 'Nilai Akademik'); ?></li>
                            <li class="<?= isActive($secondary_nav, 'nilai_fisik'); ?>"><?= anchor('transaction/nilai_fisik', 'Nilai Fisik'); ?></li>
                            <li class="<?= isActive($secondary_nav, 'nilai_mental'); ?>"><?= anchor('transaction/nilai_mental', 'Nilai Mental'); ?></li>
                            <li class="<?= isActive($secondary_nav, 'nilai_ipk'); ?>"><?= anchor('transaction/nilai_ipk', 'Nilai IPK'); ?></li>
                        </ul>
                    </li>

                    <li class="dropdown <?= ($secondary_nav == 'pengajuan_skripsi' || $secondary_nav == 'jadwal_ujian_skripsi' || $secondary_nav == 'nilai_skripsi') ? 'active' : ''; ?>">
                        <a href="#" data-toggle="dropdown" class="dropdown-toggle">Skripsi<b class="caret"></b></a>
                        <ul class="dropdown-menu">                      
                            <li class="<?= isActive($secondary_nav, 'pengajuan_skripsi'); ?>"><?= anchor('transaction/pengajuan_skripsi', 'Pengajuan Skripsi'); ?></li>
                            <li class="<?= isActive($secondary_nav, 'jadwal_ujian_skripsi'); ?>"><?= anchor('transaction/jadwal_ujian_skripsi', 'Jadwal Ujian Skripsi'); ?></li>
                            <li class="<?= isActive($secondary_nav, 'nilai_skripsi'); ?>"><?= anchor('transaction/nilai_skripsi', 'Nilai Skripsi'); ?></li>
                        </ul>
                    </li>

                    <li class="<?= isActive($secondary_nav, 'penasehat_akademik'); ?>"><?= anchor('transaction/penasehat_akademik', 'Penasehat Akademik'); ?></li>
                    <li class="<?= isActive($secondary_nav, 'jadwal_yudisium'); ?>"><?= anchor('transaction/jadwal_yudisium', 'Jadwal Yudisium'); ?></li>

                </ul>
            </div>
            <?php
            break;
        case 'admin':
            ?>
            <div class="subnav subnav-fixed">
                <ul class="nav nav-pills">
                    <li class="<?= isActive($secondary_nav, 'users') ? 'active' : ''; ?>"><?= anchor('admin/users', 'Users'); ?></li>
                    <li class="<?= isActive($secondary_nav, 'roles') ? 'active' : ''; ?>"><?= anchor('admin/roles', 'Roles'); ?></li>
                    <li class="<?= isActive($secondary_nav, 'capabilities') ? 'active' : ''; ?>"><?= anchor('admin/capabilities', 'Capabilities'); ?></li>
                    <li class="<?= isActive($secondary_nav, 'options') ? 'active' : ''; ?>"><?= anchor('admin/options', 'Options'); ?></li>
                </ul>
            </div>
            <?php
            break;
        case 'laporan':
            ?>
            <div class="subnav subnav-fixed">           
                <ul class="nav nav-pills">
                    <li class="dropdown <?= ($secondary_nav == 'laporan_daftar_matakuliah_paket' || $secondary_nav == 'laporan_kalender_akademik') ? 'active' : ''; ?>">
                        <a href="#" data-toggle="dropdown" class="dropdown-toggle">Laporan Kurikulum<b class="caret"></b></a>
                        <ul class="dropdown-menu">                      
                            <li class="<?= isActive($secondary_nav, 'laporan_daftar_matakuliah_paket'); ?>"><?= anchor('laporan/laporan_daftar_matakuliah_paket', 'Laporan Daftar Mata Kuliah Paket'); ?></li>
                            <li class="<?= isActive($secondary_nav, 'laporan_kalender_akademik'); ?>"><?= anchor('laporan/laporan_kalender_akademik', 'Laporan Kalender Akademik'); ?></li>
                        </ul>
                    </li>

                    <li class="<?= isActive($secondary_nav, 'laporan_daftar_mahasiswa'); ?>"><?= anchor('laporan/laporan_daftar_mahasiswa', 'Laporan Daftar Mahasiswa'); ?></li>

                    <li class="<?= isActive($secondary_nav, 'laporan_daftar_dosen'); ?>"><?= anchor('laporan/laporan_daftar_dosen', 'Laporan Daftar Dosen'); ?></li>

                    <li class="dropdown <?= ($secondary_nav == 'laporan_daftar_ruang' || $secondary_nav == 'laporan_jadwal_perkuliahan' || $secondary_nav == 'laporan_jadwal_ujian' || $secondary_nav == 'laporan_rekap_absensi_mahasiswa' || $secondary_nav == 'laporan_rekap_absensi_dosen') ? 'active' : ''; ?>">
                        <a href="#" data-toggle="dropdown" class="dropdown-toggle">Laporan Perkuliahan<b class="caret"></b></a>
                        <ul class="dropdown-menu">                      
                            <li class="<?= isActive($secondary_nav, 'laporan_daftar_ruang'); ?>"><?= anchor('laporan/laporan_daftar_ruang', 'Laporan Daftar Ruang'); ?></li>
                            <li class="<?= isActive($secondary_nav, 'laporan_jadwal_perkuliahan'); ?>"><?= anchor('laporan/laporan_jadwal_perkuliahan', 'Laporan Jadwal Perkuliahan'); ?></li>
                            <li class="<?= isActive($secondary_nav, 'laporan_jadwal_ujian'); ?>"><?= anchor('laporan/laporan_jadwal_ujian', 'Laporan Jadwal Ujian'); ?></li>
                            <li class="<?= isActive($secondary_nav, 'laporan_rekap_absensi_mahasiswa'); ?>"><?= anchor('laporan/laporan_rekap_absensi_mahasiswa', 'Laporan Rekap Absensi Mahasiswa'); ?></li>
                            <li class="<?= isActive($secondary_nav, 'laporan_rekap_absensi_dosen'); ?>"><?= anchor('laporan/laporan_rekap_absensi_dosen', 'Laporan Format Absensi Dosen'); ?></li>
                        </ul>
                    </li>

                    <li class="dropdown <?= ($secondary_nav == 'lembar_hasil_studi' || $secondary_nav == 'laporan_nilai_akademik' || $secondary_nav == 'laporan_peringkat_kelulusan_nilai_akhir' || $secondary_nav == 'laporan_peringkat_kelulusan_nilai_akhir' || $secondary_nav == 'laporan_ranking_per_matakuliah' || $secondary_nav == 'laporan_ip' || $secondary_nav == 'laporan_ipk') ? 'active' : ''; ?>">
                        <a href="#" data-toggle="dropdown" class="dropdown-toggle">Laporan Nilai<b class="caret"></b></a>
                        <ul class="dropdown-menu">                      
                            <li class="<?= isActive($secondary_nav, 'lembar_hasil_studi'); ?>"><?= anchor('laporan/lembar_hasil_studi', 'Laporan KHS'); ?></li>
                            <li class="<?= isActive($secondary_nav, 'laporan_nilai_akademik'); ?>"><?= anchor('laporan/laporan_nilai_akademik', 'Laporan Transkip Nilai'); ?></li>
                            <li class="<?= isActive($secondary_nav, 'laporan_peringkat_kelulusan_nilai_akhir'); ?>"><?= anchor('laporan/laporan_peringkat_kelulusan_nilai_akhir', 'Laporan Peringkat Kelulusan Nilai Akhir'); ?></li>
                            <li class="<?= isActive($secondary_nav, 'laporan_peringkat_kelulusan_akademik'); ?>"><?= anchor('laporan/laporan_peringkat_kelulusan_akademik', 'Laporan Peringkat Kelulusan Akademik'); ?></li>
                            <li class="<?= isActive($secondary_nav, 'laporan_ranking_per_matakuliah'); ?>"><?= anchor('laporan/laporan_ranking_per_matakuliah', 'Laporan Ranking Per Matakuliah'); ?></li>
                            <li class="<?= isActive($secondary_nav, 'laporan_ip'); ?>"><?= anchor('laporan/laporan_ip', 'Laporan IP'); ?></li>
                            <li class="<?= isActive($secondary_nav, 'laporan_ipk'); ?>"><?= anchor('laporan/laporan_ipk', 'Laporan IPK'); ?></li>
                        </ul>
                    </li>

                </ul>
            </div>
            <?php
            break;
        case 'modul':
            ?>
            <div class="subnav subnav-fixed">           
                <li class="dropdown <?= ($secondary_nav == 'kategori_sample' || $secondary_nav == 'sample') ? 'active' : ''; ?>">
                    <a href="#" data-toggle="dropdown" class="dropdown-toggle">Modul<b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        <li class="<?= isActive($secondary_nav, 'sample'); ?>"><?= anchor('master/sample', 'Akademik'); ?></li>
                        <li class="<?= isActive($secondary_nav, 'sample'); ?>"><?= anchor('master/sample', 'Kemahasiswaan'); ?></li>
                        <li class="<?= isActive($secondary_nav, 'sample'); ?>"><?= anchor('master/sample', 'Kepegawaian'); ?></li>
                        <li class="<?= isActive($secondary_nav, 'sample'); ?>"><?= anchor('master/sample', 'Layanan Dosen'); ?></li>
                        <li class="<?= isActive($secondary_nav, 'sample'); ?>"><?= anchor('master/sample', 'Layanan Pimpinan'); ?></li>
                        <li class="<?= isActive($secondary_nav, 'sample'); ?>"><?= anchor('master/sample', 'Layanan Mahasiswa'); ?></li>
                        <li class="<?= isActive($secondary_nav, 'sample'); ?>"><?= anchor('master/sample', 'Komunitas'); ?></li>
                        <li class="<?= isActive($secondary_nav, 'sample'); ?>"><?= anchor('master/sample', 'Utilitas'); ?></li>
                        <li class="<?= isActive($secondary_nav, 'sample'); ?>"><?= anchor('master/sample', 'Konfigurasi'); ?></li>
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
