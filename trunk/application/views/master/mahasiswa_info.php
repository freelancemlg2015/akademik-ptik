<?php
$this->load->view('_shared/header');
$this->load->view('_shared/menus');
//label
$control_label = array(
    'class' => 'control-label'
);
?>
<div class="container-full form-horizontal" id="mahasiswa">
    <table cellspacing="0" cellpadding="0" border="0" class="table table-bordered">
        <tbody>
            <tr>
                <th class="span2">Kode Dik</th>
                <td><?= $kode_dik ?></td>
            </tr>
            <tr>
                <th class="span2">Angkatan</th>
                <td><?= $nama_angkatan ?></td>
            </tr>
            <tr>
                <th class="span2">Kode Dik Ang</th>
                <td><?= $kode_dik_ang ?></td>
            </tr>
            <tr>
                <th class="span2">Jenis Dik</th>
                <td><?= $nama_jenis_dik ?></td>
            </tr>
            <tr>
                <th class="span2">Sebutan Dik</th>
                <td><?= $sebutan_dik ?></td>
            </tr>
            <tr>
                <th class="span2">Nim</th>
                <td><?= $nim ?></td>
            </tr>
            <tr>
                <th class="span2">Nama</th>
                <td><?= $nama ?></td>
            </tr>
            <tr>
                <th class="span2">Program Studi</th>
                <td><?= $nama_program_studi ?></td>
            </tr>
             <tr>
                <th class="span2">Jenjang Studi</th>
                <td><?= $jenjang_studi ?></td>
            </tr>
            <tr>
                <th class="span2">Konsentrasi Studi</th>
                <td><?= $nama_konsentrasi_studi ?></td>
            </tr>
             <tr>
                <th class="span2">Tempat Lahir</th>
                <td><?= $tempat_lahir ?></td>
            </tr>
            <tr>
                <th class="span2">Tanggal Lahir</th>
                <td><?= $tgl_lahir ?></td>
            </tr>
             <tr>
                <th class="span2">Jenis Kelamin</th>
                <td><?= $jenis_kelamin ?></td>
            </tr>
            <tr>
                <th class="span2">Agama</th>
                <td><?= $agama ?></td>
            </tr>
             <tr>
                <th class="span2">Status Aktifitas MHS</th>
                <td><?= $status_aktifitas_mhs ?></td>
            </tr>
             <tr>
                <th class="span2">Jumlah SKS Diakui</th>
                <td><?= $jml_sks_diakui ?></td>
            </tr>
            <tr>
                <th class="span2">Perguruan Tinggi Sebelumnya</th>
                <td><?= $perguruan_tinggi_sebelumnya ?></td>
            </tr>
             <tr>
                <th class="span2">Jurusan Sebelumnya</th>
                <td><?= $jurusan_sebelumnya ?></td>
            </tr>
            <tr>
                <th class="span2">Propinsi SLTA</th>
                <td><?= $propinsi_asal_slta ?></td>
            </tr>
            <tr>
                <th class="span2">Kota Asal SlTA</th>
                <td><?= $kota_asal_slta ?></td>
            </tr>
            <tr>
                <th class="span2">Nama SLTA</th>
                <td><?= $nama_slta ?></td>
            </tr>
            <tr>
                <th class="span2">Jurusan SLTA</th>
                <td><?= $jurusan_slta ?></td>
            </tr>
            <tr>
                <th class="span2">Alamat</th>
                <td><?= $alamat ?></td>
            </tr>
            <tr>
                <th class="span2">Telepon</th>
                <td><?= $telepon ?></td>
            </tr>
            <tr>
                <th class="span2">Hobby</th>
                <td><?= $hobby ?></td>
            </tr>
            <tr>
                <th class="span2">Foto Mahasiswa</th>
                <td>
                    <?php
                        $path_parts = pathinfo('/assets/mahasiswa/thumbs/'.$foto_mahasiswa);
                        $image_filename = $path_parts['filename'];
                        $image_extension = @$path_parts['extension'];
                        if(isset($image_extension)){
                            echo"<a href='".base_url()."assets/mahasiswa/medium/".$image_filename.'_medium.'.$image_extension."' rel="."shadowbox".">
                                    <img src=".base_url()."assets/mahasiswa/thumbs/".$image_filename.'_thumb.'.$image_extension.">
                                </a>";
                        }
                    ?>
                </td>
            </tr>
            <tr>
                <th class="span2">Jabatan Akhir</th>
                <td><?= $jabatan_tertinggi ?></td>
            </tr>
            <tr>
                <th class="span2">Satuan Asal</th>
                <td><?= $nama_kesatuan_asal ?></td>
            </tr>
            <tr>
                <th class="span2">Pangkat</th>
                <td><?= $nama_pangkat ?></td>
            </tr>
            <tr>
                <th class="span2">NRP</th>
                <td><?= $nrp ?></td>
            </tr>
            <tr>
                <th class="span2">Dik Abri</th>
                <td><?= $dik_abri ?></td>
            </tr>
            <tr>
                <th class="span2">Tahun Dik Abri</th>
                <td><?= $thn_dik_abri ?></td>
            </tr>
            <tr>
                <th class="span2">Sindikat</th>
                <td><?= $sindikat ?></td>
            </tr>
            <tr>
                <th class="span2">Nama Istri</th>
                <td><?= $nama_istri ?></td>
            </tr>
            <tr>
                <th class="span2">Anak</th>
                <td><?= $nama_anak ?></td>
            </tr>            
        </tbody>
    </table>
</div>

<?php $this->load->view('_shared/footer'); ?>