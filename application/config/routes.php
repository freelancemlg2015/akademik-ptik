<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	http://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There area two reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router what URI segments to use if those provided
| in the URL cannot be matched to a valid route.
|
*/

$route['default_controller'] = "login";
$route['404_override'] = '';


/* End of file routes.php */
/* Location: ./application/config/routes.php */

/*
 * CUSTOM
 */

$route['master/type/(:num)/swap'] = "type/swap/$1";

//SAMPLE
$route['master/sample'] = "sample";
$route['master/sample/view/(:any)'] = "sample/index/$1";
$route['master/sample/(:any)/info'] = "sample/info/$1";
$route['master/sample/(:any)/edit'] = "sample/edit/$1";
$route['master/sample/(:any)/delete'] = "sample/delete/$1";
$route['master/sample/(:any)/(:any)/(:any)'] = "sample/index/$1/$2/$3";
$route['master/sample/create/(:any)'] = "sample/create/$1";
$route['master/sample/create'] = "sample/create";
$route['master/sample/search'] = "sample/search";
//END


//DIREKTORAT
$route['master/direktorat'] = "direktorat";
$route['master/direktorat/view/(:any)'] = "direktorat/index/$1";
$route['master/direktorat/(:any)/info'] = "direktorat/info/$1";
$route['master/direktorat/(:any)/edit'] = "direktorat/edit/$1";
$route['master/direktorat/(:any)/delete'] = "direktorat/delete/$1";
$route['master/direktorat/(:any)/(:any)/(:any)'] = "direktorat/index/$1/$2/$3";
$route['master/direktorat/create/(:any)'] = "direktorat/create/$1";
$route['master/direktorat/create'] = "direktorat/create";
$route['master/direktorat/search'] = "direktorat/search";
//END

//DIREKTORAT
$route['master/subdirektorat'] = "subdirektorat";
$route['master/subdirektorat/view/(:any)'] = "subdirektorat/index/$1";
$route['master/subdirektorat/(:any)/info'] = "subdirektorat/info/$1";
$route['master/subdirektorat/(:any)/edit'] = "subdirektorat/edit/$1";
$route['master/subdirektorat/(:any)/delete'] = "subdirektorat/delete/$1";
$route['master/subdirektorat/(:any)/(:any)/(:any)'] = "subdirektorat/index/$1/$2/$3";
$route['master/subdirektorat/create/(:any)'] = "subdirektorat/create/$1";
$route['master/subdirektorat/create'] = "subdirektorat/create";
$route['master/subdirektorat/search'] = "subdirektorat/search";
//END

//KATEGORI BERITA
$route['master/kategori_berita'] = "kategori_berita";
$route['master/kategori_berita/view/(:any)'] = "kategori_berita/index/$1";
$route['master/kategori_berita/(:any)/info'] = "kategori_berita/info/$1";
$route['master/kategori_berita/(:any)/edit'] = "kategori_berita/edit/$1";
$route['master/kategori_berita/(:any)/delete'] = "kategori_berita/delete/$1";
$route['master/kategori_berita/(:any)/(:any)/(:any)'] = "kategori_berita/index/$1/$2/$3";
$route['master/kategori_berita/create/(:any)'] = "kategori_berita/create/$1";
$route['master/kategori_berita/create'] = "kategori_berita/create";
$route['master/kategori_berita/search'] = "kategori_berita/search";
$route['master/kategori_berita/suggestion'] = "kategori_berita/suggestion";
//END

//BERITA
$route['master/berita'] = "berita";
$route['master/berita/view/(:any)'] = "berita/index/$1";
$route['master/berita/(:any)/info'] = "berita/info/$1";
$route['master/berita/(:any)/edit'] = "berita/edit/$1";
$route['master/berita/(:any)/delete'] = "berita/delete/$1";
$route['master/berita/(:any)/(:any)/(:any)'] = "berita/index/$1/$2/$3";
$route['master/berita/create/(:any)'] = "berita/create/$1";
$route['master/berita/create'] = "berita/create";
$route['master/berita/search'] = "berita/search";
//END

//KATEGORI UNDUHAN
$route['master/kategori_unduhan'] = "kategori_unduhan";
$route['master/kategori_unduhan/view/(:any)'] = "kategori_unduhan/index/$1";
$route['master/kategori_unduhan/(:any)/info'] = "kategori_unduhan/info/$1";
$route['master/kategori_unduhan/(:any)/edit'] = "kategori_unduhan/edit/$1";
$route['master/kategori_unduhan/(:any)/delete'] = "kategori_unduhan/delete/$1";
$route['master/kategori_unduhan/(:any)/(:any)/(:any)'] = "kategori_unduhan/index/$1/$2/$3";
$route['master/kategori_unduhan/create/(:any)'] = "kategori_unduhan/create/$1";
$route['master/kategori_unduhan/create'] = "kategori_unduhan/create";
$route['master/kategori_unduhan/search'] = "kategori_unduhan/search";
//END

//UNDUHAN
$route['master/unduhan'] = "unduhan";
$route['master/unduhan/view/(:any)'] = "unduhan/index/$1";
$route['master/unduhan/(:any)/info'] = "unduhan/info/$1";
$route['master/unduhan/(:any)/edit'] = "unduhan/edit/$1";
$route['master/unduhan/(:any)/delete'] = "unduhan/delete/$1";
$route['master/unduhan/(:any)/(:any)/(:any)'] = "unduhan/index/$1/$2/$3";
$route['master/unduhan/create/(:any)'] = "unduhan/create/$1";
$route['master/unduhan/create'] = "unduhan/create";
$route['master/unduhan/search'] = "unduhan/search";
//END

//ANGKATAN
$route['master/angkatan'] = "angkatan";
$route['master/angkatan/view/(:any)'] = "angkatan/index/$1";
$route['master/angkatan/(:any)/info'] = "angkatan/info/$1";
$route['master/angkatan/(:any)/edit'] = "angkatan/edit/$1";
$route['master/angkatan/(:any)/delete'] = "angkatan/delete/$1";
$route['master/angkatan/(:any)/(:any)/(:any)'] = "angkatan/index/$1/$2/$3";
$route['master/angkatan/create/(:any)'] = "angkatan/create/$1";
$route['master/angkatan/create'] = "angkatan/create";
$route['master/angkatan/search'] = "angkatan/search";
$route['master/angkatan/suggestion'] = "angkatan/suggestion";
//END

//PROGRAM STUDI 
$route['master/program_studi'] = "program_studi";
$route['master/program_studi/view/(:any)'] = "program_studi/index/$1";
$route['master/program_studi/(:any)/info'] = "program_studi/info/$1";
$route['master/program_studi/(:any)/edit'] = "program_studi/edit/$1";
$route['master/program_studi/(:any)/delete'] = "program_studi/delete/$1";
$route['master/program_studi/(:any)/(:any)/(:any)'] = "program_studi/index/$1/$2/$3";
$route['master/program_studi/create/(:any)'] = "program_studi/create/$1";
$route['master/program_studi/create'] = "program_studi/create";
$route['master/program_studi/search'] = "program_studi/search";
//END

//TAHUN AKADEMIK 
$route['master/tahun_akademik'] = "tahun_akademik";
$route['master/tahun_akademik/view/(:any)'] = "tahun_akademik/index/$1";
$route['master/tahun_akademik/(:any)/info'] = "tahun_akademik/info/$1";
$route['master/tahun_akademik/(:any)/edit'] = "tahun_akademik/edit/$1";
$route['master/tahun_akademik/(:any)/delete'] = "tahun_akademik/delete/$1";
$route['master/tahun_akademik/(:any)/(:any)/(:any)'] = "tahun_akademik/index/$1/$2/$3";
$route['master/tahun_akademik/create/(:any)'] = "tahun_akademik/create/$1";
$route['master/tahun_akademik/create'] = "tahun_akademik/create";
$route['master/tahun_akademik/search'] = "tahun_akademik/search";
$route['master/tahun_akademik/suggestion'] = "tahun_akademik/suggestion";
//END

//MATA KULIAH 
$route['master/mata_kuliah'] = "mata_kuliah";
$route['master/mata_kuliah/view/(:any)'] = "mata_kuliah/index/$1";
$route['master/mata_kuliah/(:any)/info'] = "mata_kuliah/info/$1";
$route['master/mata_kuliah/(:any)/edit'] = "mata_kuliah/edit/$1";
$route['master/mata_kuliah/(:any)/delete'] = "mata_kuliah/delete/$1";
$route['master/mata_kuliah/(:any)/(:any)/(:any)'] = "mata_kuliah/index/$1/$2/$3";
$route['master/mata_kuliah/create/(:any)'] = "mata_kuliah/create/$1";
$route['master/mata_kuliah/create'] = "mata_kuliah/create";
$route['master/mata_kuliah/search'] = "mata_kuliah/search";
//END

//JENJANG STUDI 
$route['master/jenjang_studi'] = "jenjang_studi";
$route['master/jenjang_studi/view/(:any)'] = "jenjang_studi/index/$1";
$route['master/jenjang_studi/(:any)/info'] = "jenjang_studi/info/$1";
$route['master/jenjang_studi/(:any)/edit'] = "jenjang_studi/edit/$1";
$route['master/jenjang_studi/(:any)/delete'] = "jenjang_studi/delete/$1";
$route['master/jenjang_studi/(:any)/(:any)/(:any)'] = "jenjang_studi/index/$1/$2/$3";
$route['master/jenjang_studi/create/(:any)'] = "jenjang_studi/create/$1";
$route['master/jenjang_studi/create'] = "jenjang_studi/create";
$route['master/jenjang_studi/search'] = "jenjang_studi/search";
//END

//FREKUENSI PEMUTAHIRAN
$route['master/frekuensi_pemutakhiran'] = "frekuensi_pemutakhiran";
$route['master/frekuensi_pemutakhiran/view/(:any)'] = "frekuensi_pemutakhiran/index/$1";
$route['master/frekuensi_pemutakhiran/(:any)/info'] = "frekuensi_pemutakhiran/info/$1";
$route['master/frekuensi_pemutakhiran/(:any)/edit'] = "frekuensi_pemutakhiran/edit/$1";
$route['master/frekuensi_pemutakhiran/(:any)/delete'] = "frekuensi_pemutakhiran/delete/$1";
$route['master/frekuensi_pemutakhiran/(:any)/(:any)/(:any)'] = "frekuensi_pemutakhiran/index/$1/$2/$3";
$route['master/frekuensi_pemutakhiran/create/(:any)'] = "frekuensi_pemutakhiran/create/$1";
$route['master/frekuensi_pemutakhiran/create'] = "frekuensi_pemutakhiran/create";
$route['master/frekuensi_pemutakhiran/search'] = "frekuensi_pemutakhiran/search";
//END

//PELAKSANA PEMUTAHIRAN
$route['master/pelaksana_pemutakhiran'] = "pelaksana_pemutakhiran";
$route['master/pelaksana_pemutakhiran/view/(:any)'] = "pelaksana_pemutakhiran/index/$1";
$route['master/pelaksana_pemutakhiran/(:any)/info'] = "pelaksana_pemutakhiran/info/$1";
$route['master/pelaksana_pemutakhiran/(:any)/edit'] = "pelaksana_pemutakhiran/edit/$1";
$route['master/pelaksana_pemutakhiran/(:any)/delete'] = "pelaksana_pemutakhiran/delete/$1";
$route['master/pelaksana_pemutakhiran/(:any)/(:any)/(:any)'] = "pelaksana_pemutakhiran/index/$1/$2/$3";
$route['master/pelaksana_pemutakhiran/create/(:any)'] = "pelaksana_pemutakhiran/create/$1";
$route['master/pelaksana_pemutakhiran/create'] = "pelaksana_pemutakhiran/create";
$route['master/pelaksana_pemutakhiran/search'] = "pelaksana_pemutakhiran/search";
//END


//JAM PELAJARAN
$route['master/jam_pelajaran'] = "jam_pelajaran";
$route['master/jam_pelajaran/view/(:any)'] = "jam_pelajaran/index/$1";
$route['master/jam_pelajaran/(:any)/info'] = "jam_pelajaran/info/$1";
$route['master/jam_pelajaran/(:any)/edit'] = "jam_pelajaran/edit/$1";
$route['master/jam_pelajaran/(:any)/delete'] = "jam_pelajaran/delete/$1";
$route['master/jam_pelajaran/(:any)/(:any)/(:any)'] = "jam_pelajaran/index/$1/$2/$3";
$route['master/jam_pelajaran/create/(:any)'] = "jam_pelajaran/create/$1";
$route['master/jam_pelajaran/create'] = "jam_pelajaran/create";
$route['master/jam_pelajaran/search'] = "jam_pelajaran/search";
//

//RUANG PELAJARAN
$route['master/ruang_pelajaran'] = "ruang_pelajaran";
$route['master/ruang_pelajaran/view/(:any)'] = "ruang_pelajaran/index/$1";
$route['master/ruang_pelajaran/(:any)/info'] = "ruang_pelajaran/info/$1";
$route['master/ruang_pelajaran/(:any)/edit'] = "ruang_pelajaran/edit/$1";
$route['master/ruang_pelajaran/(:any)/delete'] = "ruang_pelajaran/delete/$1";
$route['master/ruang_pelajaran/(:any)/(:any)/(:any)'] = "ruang_pelajaran/index/$1/$2/$3";
$route['master/ruang_pelajaran/create/(:any)'] = "ruang_pelajaran/create/$1";
$route['master/ruang_pelajaran/create'] = "ruang_pelajaran/create";
$route['master/ruang_pelajaran/search'] = "ruang_pelajaran/search";
$route['master/ruang_pelajaran/suggestion'] = "ruang_pelajaran/suggestion";
//END

//JENIS RUANG
$route['master/jenis_ruang'] = "jenis_ruang";
$route['master/jenis_ruang/view/(:any)'] = "jenis_ruang/index/$1";
$route['master/jenis_ruang/(:any)/info'] = "jenis_ruang/info/$1";
$route['master/jenis_ruang/(:any)/edit'] = "jenis_ruang/edit/$1";
$route['master/jenis_ruang/(:any)/delete'] = "jenis_ruang/delete/$1";
$route['master/jenis_ruang/(:any)/(:any)/(:any)'] = "jenis_ruang/index/$1/$2/$3";
$route['master/jenis_ruang/create/(:any)'] = "jenis_ruang/create/$1";
$route['master/jenis_ruang/create'] = "jenis_ruang/create";
$route['master/jenis_ruang/search'] = "jenis_ruang/search";
//END

//STATUS AKREDITASI
$route['master/status_akreditasi'] = "status_akreditasi";
$route['master/status_akreditasi/view/(:any)'] = "status_akreditasi/index/$1";
$route['master/status_akreditasi/(:any)/info'] = "status_akreditasi/info/$1";
$route['master/status_akreditasi/(:any)/edit'] = "status_akreditasi/edit/$1";
$route['master/status_akreditasi/(:any)/delete'] = "status_akreditasi/delete/$1";
$route['master/status_akreditasi/(:any)/(:any)/(:any)'] = "status_akreditasi/index/$1/$2/$3";
$route['master/status_akreditasi/create/(:any)'] = "status_akreditasi/create/$1";
$route['master/status_akreditasi/create'] = "status_akreditasi/create";
$route['master/status_akreditasi/search'] = "status_akreditasi/search";
//END

//STATUS AKTIVITAS DOSEN
$route['master/status_aktivitas_dosen'] = "status_aktivitas_dosen";
$route['master/status_aktivitas_dosen/view/(:any)'] = "status_aktivitas_dosen/index/$1";
$route['master/status_aktivitas_dosen/(:any)/info'] = "status_aktivitas_dosen/info/$1";
$route['master/status_aktivitas_dosen/(:any)/edit'] = "status_aktivitas_dosen/edit/$1";
$route['master/status_aktivitas_dosen/(:any)/delete'] = "status_aktivitas_dosen/delete/$1";
$route['master/status_aktivitas_dosen/(:any)/(:any)/(:any)'] = "status_aktivitas_dosen/index/$1/$2/$3";
$route['master/status_aktivitas_dosen/(:any)'] = "status_aktivitas_dosen/create/$1";
$route['master/status_aktivitas_dosen/create'] = "status_aktivitas_dosen/create";
$route['master/status_aktivitas_dosen/search'] = "status_aktivitas_dosen/search";
//END

//STATUS AKTIVITAS DOSEN
$route['master/status_kerja_dosen'] = "status_kerja_dosen";
$route['master/status_kerja_dosen/view/(:any)'] = "status_kerja_dosen/index/$1";
$route['master/status_kerja_dosen/(:any)/info'] = "status_kerja_dosen/info/$1";
$route['master/status_kerja_dosen/(:any)/edit'] = "status_kerja_dosen/edit/$1";
$route['master/status_kerja_dosen/(:any)/delete'] = "status_kerja_dosen/delete/$1";
$route['master/status_kerja_dosen/(:any)/(:any)/(:any)'] = "status_kerja_dosen/index/$1/$2/$3";
$route['master/status_kerja_dosen/(:any)'] = "status_kerja_dosen/create/$1";
$route['master/status_kerja_dosen/create'] = "status_kerja_dosen/create";
$route['master/status_kerja_dosen/search'] = "status_kerja_dosen/search";
//END

//STATUS DOSEN PENASEHAT
$route['master/status_dosen_penasehat'] = "status_dosen_penasehat";
$route['master/status_dosen_penasehat/view/(:any)'] = "status_dosen_penasehat/index/$1";
$route['master/status_dosen_penasehat/(:any)/info'] = "status_dosen_penasehat/info/$1";
$route['master/status_dosen_penasehat/(:any)/edit'] = "status_dosen_penasehat/edit/$1";
$route['master/status_dosen_penasehat/(:any)/delete'] = "status_dosen_penasehat/delete/$1";
$route['master/status_dosen_penasehat/(:any)/(:any)/(:any)'] = "status_dosen_penasehat/index/$1/$2/$3";
$route['master/status_dosen_penasehat/(:any)'] = "status_dosen_penasehat/create/$1";
$route['master/status_dosen_penasehat/create'] = "status_dosen_penasehat/create";
$route['master/status_dosen_penasehat/search'] = "status_dosen_penasehat/search";
//END

//STATUS MATA KULIAH 
$route['master/status_mata_kuliah'] = "status_mata_kuliah";
$route['master/status_mata_kuliah/view/(:any)'] = "status_mata_kuliah/index/$1";
$route['master/status_mata_kuliah/(:any)/info'] = "status_mata_kuliah/info/$1";
$route['master/status_mata_kuliah/(:any)/edit'] = "status_mata_kuliah/edit/$1";
$route['master/status_mata_kuliah/(:any)/delete'] = "status_mata_kuliah/delete/$1";
$route['master/status_mata_kuliah/(:any)/(:any)/(:any)'] = "status_mata_kuliah/index/$1/$2/$3";
$route['master/status_mata_kuliah/(:any)'] = "status_mata_kuliah/create/$1";
$route['master/status_mata_kuliah/create'] = "status_mata_kuliah/create";
$route['master/status_mata_kuliah/search'] = "status_mata_kuliah/search";
//END

//AKTA MENGAJAR 
$route['master/akta_mengajar'] = "akta_mengajar";
$route['master/akta_mengajar/view/(:any)'] = "akta_mengajar/index/$1";
$route['master/akta_mengajar/(:any)/info'] = "akta_mengajar/info/$1";
$route['master/akta_mengajar/(:any)/edit'] = "akta_mengajar/edit/$1";
$route['master/akta_mengajar/(:any)/delete'] = "akta_mengajar/delete/$1";
$route['master/akta_mengajar/(:any)/(:any)/(:any)'] = "akta_mengajar/index/$1/$2/$3";
$route['master/akta_mengajar/create/(:any)'] = "akta_mengajar/create/$1";
$route['master/akta_mengajar/create'] = "akta_mengajar/create";
$route['master/akta_mengajar/search'] = "akta_mengajar/search";
//END

//BOBOT NILAI
$route['master/bobot_nilai'] = "bobot_nilai";
$route['master/bobot_nilai/view/(:any)'] = "bobot_nilai/index/$1";
$route['master/bobot_nilai/(:any)/info'] = "bobot_nilai/info/$1";
$route['master/bobot_nilai/(:any)/edit'] = "bobot_nilai/edit/$1";
$route['master/bobot_nilai/(:any)/delete'] = "bobot_nilai/delete/$1";
$route['master/bobot_nilai/(:any)/(:any)/(:any)'] = "bobot_nilai/index/$1/$2/$3";
$route['master/bobot_nilai/create/(:any)'] = "bobot_nilai/create/$1";
$route['master/bobot_nilai/create'] = "bobot_nilai/create";
$route['master/bobot_nilai/search'] = "bobot_nilai/search";
//END

//DATA MAHASISWA
$route['master/mahasiswa'] = "mahasiswa";
$route['master/mahasiswa/view/(:any)'] = "mahasiswa/index/$1";
$route['master/mahasiswa/(:any)/info'] = "mahasiswa/info/$1";
$route['master/mahasiswa/(:any)/edit'] = "mahasiswa/edit/$1";
$route['master/mahasiswa/(:any)/delete'] = "mahasiswa/delete/$1";
$route['master/mahasiswa/(:any)/(:any)/(:any)'] = "mahasiswa/index/$1/$2/$3";
$route['master/mahasiswa/create/(:any)'] = "mahasiswa/create/$1";
$route['master/mahasiswa/create'] = "mahasiswa/create";
$route['master/mahasiswa/search'] = "mahasiswa/search";
$route['master/mahasiswa/suggestion'] = "mahasiswa/suggestion";
//END

//DATA DOSEN
$route['master/dosen'] = "dosen";
$route['master/dosen/view/(:any)'] = "dosen/index/$1";
$route['master/dosen/(:any)/info'] = "dosen/info/$1";
$route['master/dosen/(:any)/edit'] = "dosen/edit/$1";
$route['master/dosen/(:any)/delete'] = "dosen/delete/$1";
$route['master/dosen/(:any)/(:any)/(:any)'] = "dosen/index/$1/$2/$3";
$route['master/dosen/create/(:any)'] = "dosen/create/$1";
$route['master/dosen/create'] = "dosen/create";
$route['master/dosen/search'] = "dosen/search";
$route['master/dosen/suggestion'] = "dosen/suggestion";
//END

//GOLONGAN
$route['master/golongan'] = "golongan";
$route['master/golongan/view/(:any)'] = "golongan/index/$1";
$route['master/golongan/(:any)/info'] = "golongan/info/$1";
$route['master/golongan/(:any)/edit'] = "golongan/edit/$1";
$route['master/golongan/(:any)/delete'] = "golongan/delete/$1";
$route['master/golongan/(:any)/(:any)/(:any)'] = "golongan/index/$1/$2/$3";
$route['master/golongan/create/(:any)'] = "golongan/create/$1";
$route['master/golongan/create'] = "golongan/create";
$route['master/golongan/search'] = "golongan/search";
//END

//JABATAN AKADEMIK
$route['master/jabatan_akademik'] = "jabatan_akademik";
$route['master/jabatan_akademik/view/(:any)'] = "jabatan_akademik/index/$1";
$route['master/jabatan_akademik/(:any)/info'] = "jabatan_akademik/info/$1";
$route['master/jabatan_akademik/(:any)/edit'] = "jabatan_akademik/edit/$1";
$route['master/jabatan_akademik/(:any)/delete'] = "jabatan_akademik/delete/$1";
$route['master/jabatan_akademik/(:any)/(:any)/(:any)'] = "jabatan_akademik/index/$1/$2/$3";
$route['master/jabatan_akademik/create/(:any)'] = "jabatan_akademik/create/$1";
$route['master/jabatan_akademik/create'] = "jabatan_akademik/create";
$route['master/jabatan_akademik/search'] = "jabatan_akademik/search";
//END

//JABATAN TERTINGGI
$route['master/jabatan_tertinggi'] = "jabatan_tertinggi";
$route['master/jabatan_tertinggi/view/(:any)'] = "jabatan_tertinggi/index/$1";
$route['master/jabatan_tertinggi/(:any)/info'] = "jabatan_tertinggi/info/$1";
$route['master/jabatan_tertinggi/(:any)/edit'] = "jabatan_tertinggi/edit/$1";
$route['master/jabatan_tertinggi/(:any)/delete'] = "jabatan_tertinggi/delete/$1";
$route['master/jabatan_tertinggi/(:any)/(:any)/(:any)'] = "jabatan_tertinggi/index/$1/$2/$3";
$route['master/jabatan_tertinggi/create/(:any)'] = "jabatan_tertinggi/create/$1";
$route['master/jabatan_tertinggi/create'] = "jabatan_tertinggi/create";
$route['master/jabatan_tertinggi/search'] = "jabatan_tertinggi/search";
//END

//JENIS KELAMIN
$route['master/jenis_kelamin'] = "jenis_kelamin";
$route['master/jenis_kelamin/view/(:any)'] = "jenis_kelamin/index/$1";
$route['master/jenis_kelamin/(:any)/info'] = "jenis_kelamin/info/$1";
$route['master/jenis_kelamin/(:any)/edit'] = "jenis_kelamin/edit/$1";
$route['master/jenis_kelamin/(:any)/delete'] = "jenis_kelamin/delete/$1";
$route['master/jenis_kelamin/(:any)/(:any)/(:any)'] = "jenis_kelamin/index/$1/$2/$3";
$route['master/jenis_kelamin/create/(:any)'] = "jenis_kelamin/create/$1";
$route['master/jenis_kelamin/create'] = "jenis_kelamin/create";
$route['master/jenis_kelamin/search'] = "jenis_kelamin/search";
//END

//JENIS UJIAN
$route['master/jenis_ujian'] = "jenis_ujian";
$route['master/jenis_ujian/view/(:any)'] = "jenis_ujian/index/$1";
$route['master/jenis_ujian/(:any)/info'] = "jenis_ujian/info/$1";
$route['master/jenis_ujian/(:any)/edit'] = "jenis_ujian/edit/$1";
$route['master/jenis_ujian/(:any)/delete'] = "jenis_ujian/delete/$1";
$route['master/jenis_ujian/(:any)/(:any)/(:any)'] = "jenis_ujian/index/$1/$2/$3";
$route['master/jenis_ujian/create/(:any)'] = "jenis_ujian/create/$1";
$route['master/jenis_ujian/create'] = "jenis_ujian/create";
$route['master/jenis_ujian/search'] = "jenis_ujian/search";
//END

//NILAI
$route['master/nilai'] = "nilai";
$route['master/nilai/view/(:any)'] = "nilai/index/$1";
$route['master/nilai/(:any)/info'] = "nilai/info/$1";
$route['master/nilai/(:any)/edit'] = "nilai/edit/$1";
$route['master/nilai/(:any)/delete'] = "nilai/delete/$1";
$route['master/nilai/(:any)/(:any)/(:any)'] = "nilai/index/$1/$2/$3";
$route['master/nilai/create/(:any)'] = "nilai/create/$1";
$route['master/nilai/create'] = "nilai/create";
$route['master/nilai/search'] = "nilai/search";
//END

//PANGKAT
$route['master/pangkat'] = "pangkat";
$route['master/pangkat/view/(:any)'] = "pangkat/index/$1";
$route['master/pangkat/(:any)/info'] = "pangkat/info/$1";
$route['master/pangkat/(:any)/edit'] = "pangkat/edit/$1";
$route['master/pangkat/(:any)/delete'] = "pangkat/delete/$1";
$route['master/pangkat/(:any)/(:any)/(:any)'] = "pangkat/index/$1/$2/$3";
$route['master/pangkat/create/(:any)'] = "pangkat/create/$1";
$route['master/pangkat/create'] = "pangkat/create";
$route['master/pangkat/search'] = "pangkat/search";
$route['master/pangkat/suggestion'] = "pangkat/suggestion";
//END

//KESATUAN ASAL
$route['master/kesatuan_asal'] = "kesatuan_asal";
$route['master/kesatuan_asal/view/(:any)'] = "kesatuan_asal/index/$1";
$route['master/kesatuan_asal/(:any)/info'] = "kesatuan_asal/info/$1";
$route['master/kesatuan_asal/(:any)/edit'] = "kesatuan_asal/edit/$1";
$route['master/kesatuan_asal/(:any)/delete'] = "kesatuan_asal/delete/$1";
$route['master/kesatuan_asal/(:any)/(:any)/(:any)'] = "kesatuan_asal/index/$1/$2/$3";
$route['master/kesatuan_asal/create/(:any)'] = "kesatuan_asal/create/$1";
$route['master/kesatuan_asal/create'] = "kesatuan_asal/create";
$route['master/kesatuan_asal/search'] = "kesatuan_asal/search";
//END

//KONSENTRASI STUDI
$route['master/konsentrasi_studi'] = "konsentrasi_studi";
$route['master/konsentrasi_studi/view/(:any)'] = "konsentrasi_studi/index/$1";
$route['master/konsentrasi_studi/(:any)/info'] = "konsentrasi_studi/info/$1";
$route['master/konsentrasi_studi/(:any)/edit'] = "konsentrasi_studi/edit/$1";
$route['master/konsentrasi_studi/(:any)/delete'] = "konsentrasi_studi/delete/$1";
$route['master/konsentrasi_studi/(:any)/(:any)/(:any)'] = "konsentrasi_studi/index/$1/$2/$3";
$route['master/konsentrasi_studi/create/(:any)'] = "konsentrasi_studi/create/$1";
$route['master/konsentrasi_studi/create'] = "konsentrasi_studi/create";
$route['master/konsentrasi_studi/search'] = "konsentrasi_studi/search";
//END

//SEMESTER
$route['master/semester'] = "semester";
$route['master/semester/view/(:any)'] = "semester/index/$1";
$route['master/semester/(:any)/info'] = "semester/info/$1";
$route['master/semester/(:any)/edit'] = "semester/edit/$1";
$route['master/semester/(:any)/delete'] = "semester/delete/$1";
$route['master/semester/(:any)/(:any)/(:any)'] = "semester/index/$1/$2/$3";
$route['master/semester/create/(:any)'] = "semester/create/$1";
$route['master/semester/create'] = "semester/create";
$route['master/semester/search'] = "semester/search";
$route['master/semester/suggestion'] = "semester/suggestion";
//END

//SEMESTER MULAI AKTIVITAS
$route['master/semester_mulai_aktivitas'] = "semester_mulai_aktivitas";
$route['master/semester_mulai_aktivitas/view/(:any)'] = "semester_mulai_aktivitas/index/$1";
$route['master/semester_mulai_aktivitas/(:any)/info'] = "semester_mulai_aktivitas/info/$1";
$route['master/semester_mulai_aktivitas/(:any)/edit'] = "semester_mulai_aktivitas/edit/$1";
$route['master/semester_mulai_aktivitas/(:any)/delete'] = "semester_mulai_aktivitas/delete/$1";
$route['master/semester_mulai_aktivitas/(:any)/(:any)/(:any)'] = "semester_mulai_aktivitas/index/$1/$2/$3";
$route['master/semester_mulai_aktivitas/create/(:any)'] = "semester_mulai_aktivitas/create/$1";
$route['master/semester_mulai_aktivitas/create'] = "semester_mulai_aktivitas/create";
$route['master/semester_mulai_aktivitas/search'] = "semester_mulai_aktivitas/search";
//END

//SURAT IJIN MENGAJAR
$route['master/surat_ijin_mengajar'] = "surat_ijin_mengajar";
$route['master/surat_ijin_mengajar/view/(:any)'] = "surat_ijin_mengajar/index/$1";
$route['master/surat_ijin_mengajar/(:any)/info'] = "surat_ijin_mengajar/info/$1";
$route['master/surat_ijin_mengajar/(:any)/edit'] = "surat_ijin_mengajar/edit/$1";
$route['master/surat_ijin_mengajar/(:any)/delete'] = "surat_ijin_mengajar/delete/$1";
$route['master/surat_ijin_mengajar/(:any)/(:any)/(:any)'] = "surat_ijin_mengajar/index/$1/$2/$3";
$route['master/surat_ijin_mengajar/create/(:any)'] = "surat_ijin_mengajar/create/$1";
$route['master/surat_ijin_mengajar/create'] = "surat_ijin_mengajar/create";
$route['master/surat_ijin_mengajar/search'] = "surat_ijin_mengajar/search";
//END

//PROVINSI
$route['master/provinsi'] = "provinsi";
$route['master/provinsi/view/(:any)'] = "provinsi/index/$1";
$route['master/provinsi/(:any)/info'] = "provinsi/info/$1";
$route['master/provinsi/(:any)/edit'] = "provinsi/edit/$1";
$route['master/provinsi/(:any)/delete'] = "provinsi/delete/$1";
$route['master/provinsi/(:any)/(:any)/(:any)'] = "provinsi/index/$1/$2/$3";
$route['master/provinsi/create/(:any)'] = "provinsi/create/$1";
$route['master/provinsi/create'] = "provinsi/create";
$route['master/provinsi/search'] = "provinsi/search";
//END

//KATEGORI PEJABAT
$route['master/kategori_pejabat'] = "kategori_pejabat";
$route['master/kategori_pejabat/view/(:any)'] = "kategori_pejabat/index/$1";
$route['master/kategori_pejabat/(:any)/info'] = "kategori_pejabat/info/$1";
$route['master/kategori_pejabat/(:any)/edit'] = "kategori_pejabat/edit/$1";
$route['master/kategori_pejabat/(:any)/delete'] = "kategori_pejabat/delete/$1";
$route['master/kategori_pejabat/(:any)/(:any)/(:any)'] = "kategori_pejabat/index/$1/$2/$3";
$route['master/kategori_pejabat/create/(:any)'] = "kategori_pejabat/create/$1";
$route['master/kategori_pejabat/create'] = "kategori_pejabat/create";
$route['master/kategori_pejabat/search'] = "kategori_pejabat/search";
//END

//PEJABAT TANDA TANGAN
$route['master/pejabat_tanda_tangan'] = "pejabat_tanda_tangan";
$route['master/pejabat_tanda_tangan/view/(:any)'] = "pejabat_tanda_tangan/index/$1";
$route['master/pejabat_tanda_tangan/(:any)/info'] = "pejabat_tanda_tangan/info/$1";
$route['master/pejabat_tanda_tangan/(:any)/edit'] = "pejabat_tanda_tangan/edit/$1";
$route['master/pejabat_tanda_tangan/(:any)/delete'] = "pejabat_tanda_tangan/delete/$1";
$route['master/pejabat_tanda_tangan/(:any)/(:any)/(:any)'] = "pejabat_tanda_tangan/index/$1/$2/$3";
$route['master/pejabat_tanda_tangan/create/(:any)'] = "pejabat_tanda_tangan/create/$1";
$route['master/pejabat_tanda_tangan/create'] = "pejabat_tanda_tangan/create";
$route['master/pejabat_tanda_tangan/search'] = "pejabat_tanda_tangan/search";
//END

//JADWAL KULIAH
$route['transaction/jadwal_kuliah'] = "jadwal_kuliah";
$route['transaction/jadwal_kuliah/view/(:any)'] = "jadwal_kuliah/index/$1";
$route['transaction/jadwal_kuliah/(:any)/info'] = "jadwal_kuliah/info/$1";
$route['transaction/jadwal_kuliah/(:any)/edit'] = "jadwal_kuliah/edit/$1";
$route['transaction/jadwal_kuliah/(:any)/delete'] = "jadwal_kuliah/delete/$1";
$route['transaction/jadwal_kuliah/(:any)/(:any)/(:any)'] = "jadwal_kuliah/index/$1/$2/$3";
$route['transaction/jadwal_kuliah/create/(:any)'] = "jadwal_kuliah/create/$1";
$route['transaction/jadwal_kuliah/create'] = "jadwal_kuliah/create";
$route['transaction/jadwal_kuliah/search'] = "jadwal_kuliah/search";
//END

//UJIAN SKRIPSI
$route['transaction/ujian_skripsi'] = "ujian_skripsi";
$route['transaction/ujian_skripsi/view/(:any)'] = "ujian_skripsi/index/$1";
$route['transaction/ujian_skripsi/(:any)/info'] = "ujian_skripsi/info/$1";
$route['transaction/ujian_skripsi/(:any)/edit'] = "ujian_skripsi/edit/$1";
$route['transaction/ujian_skripsi/(:any)/delete'] = "ujian_skripsi/delete/$1";
$route['transaction/ujian_skripsi/(:any)/(:any)/(:any)'] = "ujian_skripsi/index/$1/$2/$3";
$route['transaction/ujian_skripsi/create/(:any)'] = "ujian_skripsi/create/$1";
$route['transaction/ujian_skripsi/create'] = "ujian_skripsi/create";
$route['transaction/ujian_skripsi/search'] = "ujian_skripsi/search";
//END

//PLOT MATAKULIAH
$route['transaction/plot_mata_kuliah'] = "plot_mata_kuliah";
$route['transaction/plot_mata_kuliah/view/(:any)'] = "plot_mata_kuliah/index/$1";
$route['transaction/plot_mata_kuliah/(:any)/info'] = "plot_mata_kuliah/info/$1";
$route['transaction/plot_mata_kuliah/(:any)/edit'] = "plot_mata_kuliah/edit/$1";
$route['transaction/plot_mata_kuliah/(:any)/delete'] = "plot_mata_kuliah/delete/$1";
$route['transaction/plot_mata_kuliah/(:any)/(:any)/(:any)'] = "plot_mata_kuliah/index/$1/$2/$3";
$route['transaction/plot_mata_kuliah/create/(:any)'] = "plot_mata_kuliah/create/$1";
$route['transaction/plot_mata_kuliah/create'] = "plot_mata_kuliah/create";
$route['transaction/plot_mata_kuliah/search'] = "plot_mata_kuliah/search";
$route['transaction/plot_mata_kuliah/suggestion'] = "plot_mata_kuliah/suggestion";
//END


//PLOT SEMESTER
$route['transaction/plot_semester'] = "plot_semester";
$route['transaction/plot_semester/view/(:any)'] = "plot_semester/index/$1";
$route['transaction/plot_semester/(:any)/info'] = "plot_semester/info/$1";
$route['transaction/plot_semester/(:any)/edit'] = "plot_semester/edit/$1";
$route['transaction/plot_semester/(:any)/delete'] = "plot_semester/delete/$1";
$route['transaction/plot_semester/(:any)/(:any)/(:any)'] = "plot_semester/index/$1/$2/$3";
$route['transaction/plot_semester/create/(:any)'] = "plot_semester/create/$1";
$route['transaction/plot_semester/create'] = "plot_semester/create";
$route['transaction/plot_semester/search'] = "plot_semester/search";
//END


//PAKET MATAKULIAH
$route['transaction/paket_matakuliah'] = "paket_matakuliah";
$route['transaction/paket_matakuliah/view/(:any)'] = "paket_matakuliah/index/$1";
$route['transaction/paket_matakuliah/(:any)/info'] = "paket_matakuliah/info/$1";
$route['transaction/paket_matakuliah/(:any)/edit'] = "paket_matakuliah/edit/$1";
$route['transaction/paket_matakuliah/(:any)/delete'] = "paket_matakuliah/delete/$1";
$route['transaction/paket_matakuliah/(:any)/(:any)/(:any)'] = "paket_matakuliah/index/$1/$2/$3";
$route['transaction/paket_matakuliah/create/(:any)'] = "paket_matakuliah/create/$1";
$route['transaction/paket_matakuliah/create'] = "paket_matakuliah/create";
$route['transaction/paket_matakuliah/search'] = "paket_matakuliah/search";
//END

//KALENDER AKADEMIK
$route['transaction/kalender_akademik'] = "kalender_akademik";
$route['transaction/kalender_akademik/view/(:any)'] = "kalender_akademik/index/$1";
$route['transaction/kalender_akademik/(:any)/info'] = "kalender_akademik/info/$1";
$route['transaction/kalender_akademik/(:any)/edit'] = "kalender_akademik/edit/$1";
$route['transaction/kalender_akademik/(:any)/delete'] = "kalender_akademik/delete/$1";
$route['transaction/kalender_akademik/(:any)/(:any)/(:any)'] = "kalender_akademik/index/$1/$2/$3";
$route['transaction/kalender_akademik/create/(:any)'] = "kalender_akademik/create/$1";
$route['transaction/kalender_akademik/create'] = "kalender_akademik/create";
$route['transaction/kalender_akademik/search'] = "kalender_akademik/search";
$route['transaction/kalender_akademik/suggestion'] = "kalender_akademik/suggestion";
//END

//PLOT KELAS 
$route['transaction/plot_kelas'] = "plot_kelas";
$route['transaction/plot_kelas/view/(:any)'] = "plot_kelas/index/$1";
$route['transaction/plot_kelas/(:any)/info'] = "plot_kelas/info/$1";
$route['transaction/plot_kelas/(:any)/edit'] = "plot_kelas/edit/$1";
$route['transaction/plot_kelas/(:any)/delete'] = "plot_kelas/delete/$1";
$route['transaction/plot_kelas/(:any)/(:any)/(:any)'] = "plot_kelas/index/$1/$2/$3";
$route['transaction/plot_kelas/create/(:any)'] = "plot_kelas/create/$1";
$route['transaction/plot_kelas/create'] = "plot_kelas/create";
$route['transaction/plot_kelas/search'] = "plot_kelas/search";
$route['transaction/plot_kelas/suggestion'] = "plot_kelas/suggestion";
//END

//PLOT DOSEN PENANGGUNG JAWAB
$route['transaction/plot_dosen_penanggung_jawab'] = "plot_dosen_penanggung_jawab";
$route['transaction/plot_dosen_penanggung_jawab/view/(:any)'] = "plot_dosen_penanggung_jawab/index/$1";
$route['transaction/plot_dosen_penanggung_jawab/(:any)/info'] = "plot_dosen_penanggung_jawab/info/$1";
$route['transaction/plot_dosen_penanggung_jawab/(:any)/edit'] = "plot_dosen_penanggung_jawab/edit/$1";
$route['transaction/plot_dosen_penanggung_jawab/(:any)/delete'] = "plot_dosen_penanggung_jawab/delete/$1";
$route['transaction/plot_dosen_penanggung_jawab/(:any)/(:any)/(:any)'] = "plot_dosen_penanggung_jawab/index/$1/$2/$3";
$route['transaction/plot_dosen_penanggung_jawab/create/(:any)'] = "plot_dosen_penanggung_jawab/create/$1";
$route['transaction/plot_dosen_penanggung_jawab/create'] = "plot_dosen_penanggung_jawab/create";
$route['transaction/plot_dosen_penanggung_jawab/search'] = "plot_dosen_penanggung_jawab/search";
$route['transaction/plot_dosen_penanggung_jawab/suggestion'] = "plot_dosen_penanggung_jawab/suggestion";
//END

//RENCANA MATA PELAJARAN
$route['transaction/rencana_mata_pelajaran'] = "rencana_mata_pelajaran";
$route['transaction/rencana_mata_pelajaran/view/(:any)'] = "rencana_mata_pelajaran/index/$1";
$route['transaction/rencana_mata_pelajaran/(:any)/info'] = "rencana_mata_pelajaran/info/$1";
$route['transaction/rencana_mata_pelajaran/(:any)/edit'] = "rencana_mata_pelajaran/edit/$1";
$route['transaction/rencana_mata_pelajaran/(:any)/delete'] = "rencana_mata_pelajaran/delete/$1";
$route['transaction/rencana_mata_pelajaran/(:any)/(:any)/(:any)'] = "rencana_mata_pelajaran/index/$1/$2/$3";
$route['transaction/rencana_mata_pelajaran/create/(:any)'] = "rencana_mata_pelajaran/create/$1";
$route['transaction/rencana_mata_pelajaran/create'] = "rencana_mata_pelajaran/create";
$route['transaction/rencana_mata_pelajaran/search'] = "rencana_mata_pelajaran/search";
$route['transaction/rencana_mata_pelajaran/suggestion'] = "rencana_mata_pelajaran/suggestion";
//END

//ABSENSI DOSEN
$route['transaction/absensi_dosen'] = "absensi_dosen";
$route['transaction/absensi_dosen/view/(:any)'] = "absensi_dosen/index/$1";
$route['transaction/absensi_dosen/(:any)/info'] = "absensi_dosen/info/$1";
$route['transaction/absensi_dosen/(:any)/edit'] = "absensi_dosen/edit/$1";
$route['transaction/absensi_dosen/(:any)/delete'] = "absensi_dosen/delete/$1";
$route['transaction/absensi_dosen/(:any)/(:any)/(:any)'] = "absensi_dosen/index/$1/$2/$3";
$route['transaction/absensi_dosen/create/(:any)'] = "absensi_dosen/create/$1";
$route['transaction/absensi_dosen/create'] = "absensi_dosen/create";
$route['transaction/absensi_dosen/search'] = "absensi_dosen/search";
//END

//JADWAL UJIAN
$route['transaction/jadwal_ujian'] = "jadwal_ujian";
$route['transaction/jadwal_ujian/view/(:any)'] = "jadwal_ujian/index/$1";
$route['transaction/jadwal_ujian/(:any)/info'] = "jadwal_ujian/info/$1";
$route['transaction/jadwal_ujian/(:any)/edit'] = "jadwal_ujian/edit/$1";
$route['transaction/jadwal_ujian/(:any)/delete'] = "jadwal_ujian/delete/$1";
$route['transaction/jadwal_ujian/(:any)/(:any)/(:any)'] = "jadwal_ujian/index/$1/$2/$3";
$route['transaction/jadwal_ujian/create/(:any)'] = "jadwal_ujian/create/$1";
$route['transaction/jadwal_ujian/create'] = "jadwal_ujian/create";
$route['transaction/jadwal_ujian/search'] = "jadwal_ujian/search";
//END

//NILAI MENTAL
$route['transaction/nilai_mental'] = "nilai_mental";
$route['transaction/nilai_mental/view/(:any)'] = "nilai_mental/index/$1";
$route['transaction/nilai_mental/(:any)/info'] = "nilai_mental/info/$1";
$route['transaction/nilai_mental/(:any)/edit'] = "nilai_mental/edit/$1";
$route['transaction/nilai_mental/(:any)/delete'] = "nilai_mental/delete/$1";
$route['transaction/nilai_mental/(:any)/(:any)/(:any)'] = "nilai_mental/index/$1/$2/$3";
$route['transaction/nilai_mental/create/(:any)'] = "nilai_mental/create/$1";
$route['transaction/nilai_mental/create'] = "nilai_mental/create";
$route['transaction/nilai_mental/search'] = "nilai_mental/search";
//END

//NILAI FISIK
$route['transaction/nilai_fisik'] = "nilai_fisik";
$route['transaction/nilai_fisik/view/(:any)'] = "nilai_fisik/index/$1";
$route['transaction/nilai_fisik/(:any)/info'] = "nilai_fisik/info/$1";
$route['transaction/nilai_fisik/(:any)/edit'] = "nilai_fisik/edit/$1";
$route['transaction/nilai_fisik/(:any)/delete'] = "nilai_fisik/delete/$1";
$route['transaction/nilai_fisik/(:any)/(:any)/(:any)'] = "nilai_fisik/index/$1/$2/$3";
$route['transaction/nilai_fisik/create/(:any)'] = "nilai_fisik/create/$1";
$route['transaction/nilai_fisik/create'] = "nilai_fisik/create";
$route['transaction/nilai_fisik/search'] = "nilai_fisik/search";
//END

//PENASEHAT AKADEMIK
$route['transaction/penasehat_akademik'] = "penasehat_akademik";
$route['transaction/penasehat_akademik/view/(:any)'] = "penasehat_akademik/index/$1";
$route['transaction/penasehat_akademik/(:any)/info'] = "penasehat_akademik/info/$1";
$route['transaction/penasehat_akademik/(:any)/edit'] = "penasehat_akademik/edit/$1";
$route['transaction/penasehat_akademik/(:any)/delete'] = "penasehat_akademik/delete/$1";
$route['transaction/penasehat_akademik/(:any)/(:any)/(:any)'] = "penasehat_akademik/index/$1/$2/$3";
$route['transaction/penasehat_akademik/create/(:any)'] = "penasehat_akademik/create/$1";
$route['transaction/penasehat_akademik/create'] = "penasehat_akademik/create";
$route['transaction/penasehat_akademik/search'] = "penasehat_akademik/search";
//END

//NILAI AKADEMIK
$route['transaction/nilai_akademik'] = "nilai_akademik";
$route['transaction/nilai_akademik/view/(:any)'] = "nilai_akademik/index/$1";
$route['transaction/nilai_akademik/(:any)/info'] = "nilai_akademik/info/$1";
$route['transaction/nilai_akademik/(:any)/edit'] = "nilai_akademik/edit/$1";
$route['transaction/nilai_akademik/(:any)/delete'] = "nilai_akademik/delete/$1";
$route['transaction/nilai_akademik/(:any)/(:any)/(:any)'] = "nilai_akademik/index/$1/$2/$3";
$route['transaction/nilai_akademik/create/(:any)'] = "nilai_akademik/create/$1";
$route['transaction/nilai_akademik/create'] = "nilai_akademik/create";
$route['transaction/nilai_akademik/search'] = "nilai_akademik/search";
$route['transaction/nilai_akademik/getOptProgramStudi'] = "nilai_akademik/getOptProgramStudi";
$route['transaction/nilai_akademik/getOptMataKuliah'] = "nilai_akademik/getMataKuliah";
$route['transaction/nilai_akademik/getMahasiswa'] = "nilai_akademik/getMahasiswa";
$route['transaction/nilai_akademik/submit_nilai'] = "nilai_akademik/submit_nilai";
//END

//NILAI AKADEMIK
$route['laporan/template_report'] = "template_report";
$route['laporan/template_report/view/(:any)'] = "template_report/index/$1";
$route['laporan/template_report/(:any)/info'] = "template_report/info/$1";
$route['laporan/template_report/(:any)/edit'] = "template_report/edit/$1";
$route['laporan/template_report/(:any)/delete'] = "template_report/delete/$1";
$route['laporan/template_report/(:any)/(:any)/(:any)'] = "template_report/index/$1/$2/$3";
$route['laporan/template_report/create/(:any)'] = "template_report/create/$1";
$route['laporan/template_report/create'] = "template_report/create";
$route['laporan/template_report/search'] = "template_report/search";
//END


//LAPORAN DAFTAR MATAKULIAH PAKET
$route['laporan/laporan_daftar_matakuliah_paket'] = "laporan_daftar_matakuliah_paket";
$route['laporan/laporan_daftar_matakuliah_paket/view/(:any)'] = "laporan_daftar_matakuliah_paket/index/$1";
$route['laporan/laporan_daftar_matakuliah_paket/(:any)/info'] = "laporan_daftar_matakuliah_paket/info/$1";
$route['laporan/laporan_daftar_matakuliah_paket/(:any)/edit'] = "laporan_daftar_matakuliah_paket/edit/$1";
$route['laporan/laporan_daftar_matakuliah_paket/(:any)/delete'] = "laporan_daftar_matakuliah_paket/delete/$1";
$route['laporan/laporan_daftar_matakuliah_paket/(:any)/(:any)/(:any)'] = "laporan_daftar_matakuliah_paket/index/$1/$2/$3";
$route['laporan/laporan_daftar_matakuliah_paket/create/(:any)'] = "laporan_daftar_matakuliah_paket/create/$1";
$route['laporan/laporan_daftar_matakuliah_paket/create'] = "laporan_daftar_matakuliah_paket/create";
$route['laporan/laporan_daftar_matakuliah_paket/search'] = "laporan_daftar_matakuliah_paket/search";
$route['laporan/laporan_daftar_matakuliah_paket/report'] = "laporan_daftar_matakuliah_paket/report";
//END

//LAPORAN DAFTAR MAHASISWA
$route['laporan/laporan_daftar_mahasiswa'] = "laporan_daftar_mahasiswa";
$route['laporan/laporan_daftar_mahasiswa/view/(:any)'] = "laporan_daftar_mahasiswa/index/$1";
$route['laporan/laporan_daftar_mahasiswa/(:any)/info'] = "laporan_daftar_mahasiswa/info/$1";
$route['laporan/laporan_daftar_mahasiswa/(:any)/edit'] = "laporan_daftar_mahasiswa/edit/$1";
$route['laporan/laporan_daftar_mahasiswa/(:any)/delete'] = "laporan_daftar_mahasiswa/delete/$1";
$route['laporan/laporan_daftar_mahasiswa/(:any)/(:any)/(:any)'] = "laporan_daftar_mahasiswa/index/$1/$2/$3";
$route['laporan/laporan_daftar_mahasiswa/create/(:any)'] = "laporan_daftar_mahasiswa/create/$1";
$route['laporan/laporan_daftar_mahasiswa/create'] = "laporan_daftar_mahasiswa/create";
$route['laporan/laporan_daftar_mahasiswa/search'] = "laporan_daftar_mahasiswa/search";
$route['laporan/laporan_daftar_mahasiswa/report'] = "laporan_daftar_mahasiswa/report";
//END

//LAPORAN DAFTAR JADWAL PERKULIAHAN
$route['laporan/laporan_jadwal_perkuliahan'] = "laporan_jadwal_perkuliahan";
$route['laporan/laporan_jadwal_perkuliahan/view/(:any)'] = "laporan_jadwal_perkuliahan/index/$1";
$route['laporan/laporan_jadwal_perkuliahan/(:any)/info'] = "laporan_jadwal_perkuliahan/info/$1";
$route['laporan/laporan_jadwal_perkuliahan/(:any)/edit'] = "laporan_jadwal_perkuliahan/edit/$1";
$route['laporan/laporan_jadwal_perkuliahan/(:any)/delete'] = "laporan_jadwal_perkuliahan/delete/$1";
$route['laporan/laporan_jadwal_perkuliahan/(:any)/(:any)/(:any)'] = "laporan_jadwal_perkuliahan/index/$1/$2/$3";
$route['laporan/laporan_jadwal_perkuliahan/create/(:any)'] = "laporan_jadwal_perkuliahan/create/$1";
$route['laporan/laporan_jadwal_perkuliahan/create'] = "laporan_jadwal_perkuliahan/create";
$route['laporan/laporan_jadwal_perkuliahan/search'] = "laporan_jadwal_perkuliahan/search";
$route['laporan/laporan_jadwal_perkuliahan/report'] = "laporan_jadwal_perkuliahan/report";
//END

//LAPORAN DAFTAR DOSEN
$route['laporan/laporan_daftar_dosen'] = "laporan_daftar_dosen";
$route['laporan/laporan_daftar_dosen/view/(:any)'] = "laporan_daftar_dosen/index/$1";
$route['laporan/laporan_daftar_dosen/(:any)/info'] = "laporan_daftar_dosen/info/$1";
$route['laporan/laporan_daftar_dosen/(:any)/edit'] = "laporan_daftar_dosen/edit/$1";
$route['laporan/laporan_daftar_dosen/(:any)/delete'] = "laporan_daftar_dosen/delete/$1";
$route['laporan/laporan_daftar_dosen/(:any)/(:any)/(:any)'] = "laporan_daftar_dosen/index/$1/$2/$3";
$route['laporan/laporan_daftar_dosen/create/(:any)'] = "laporan_daftar_dosen/create/$1";
$route['laporan/laporan_daftar_dosen/create'] = "laporan_daftar_dosen/create";
$route['laporan/laporan_daftar_dosen/search'] = "laporan_daftar_dosen/search";
$route['laporan/laporan_daftar_dosen/report'] = "laporan_daftar_dosen/report";
//END

