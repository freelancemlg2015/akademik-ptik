<?php
$this->load->view('_shared/header');
$this->load->view('_shared/menus');
//label
$control_label = array(
    'class' => 'control-label'
);
?>
<div class="container-full form-horizontal" id="dosen">
    <table cellspacing="0" cellpadding="0" border="0" class="table table-bordered span4">
        <tbody>
            <tr>
                <th class="span2">Angkatan</th>
                <td><?= $nama_angkatan ?></td>
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
                <th class="span2">No Karpeg Dosen</th>
                <td><?= $no_karpeg_dosen ?></td>
            </tr>
             <tr>
                <th class="span2">No Dosen Fakultas</th>
                <td><?= $no_dosen_fakultas ?></td>
            </tr>
            <tr>
                <th class="span2">No Dosen Dikti</th>
                <td><?= $no_dosen_dikti ?></td>
            </tr>
             <tr>
                <th class="span2">Nama Dosen</th>
                <td><?= $nama_dosen ?></td>
            </tr>
            <tr>
                <th class="span2">Gelar Depan</th>
                <td><?= $gelar_depan ?></td>
            </tr>
             <tr>
                <th class="span2">Gelar Belakang</th>
                <td><?= $gelar_belakang ?></td>
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
                <th class="span2">Jabatan_akademik</th>
                <td><?= $nama_jabatan_akademik ?></td>
            </tr>
            <tr>
                <th class="span2">Jabatan Tertinggi</th>
                <td><?= $jabatan_tertinggi ?></td>
            </tr>
            <tr>
                <th class="span2">Status Kerja Dosen</th>
                <td><?= $status_kerja_dosen ?></td>
            </tr>
            <tr>
                <th class="span2">Status Aktivitas Dosen</th>
                <td><?= $status_aktivitas_dosen ?></td>
            </tr>
            <tr>
                <th class="span2">Semester Mulai Aktivitas</th>
                <td><?= $semester_mulai_aktivitas ?></td>
            </tr>
            <tr>
                <th class="span2">Akta Mengajar</th>
                <td><?= $nama_akta_mengajar ?></td>
            </tr>
            <tr>
                <th class="span2">Surat Ijin Mengajar</th>
                <td><?= $surat_ijin_mengajar ?></td>
            </tr>
            <tr>
                <th class="span2">NIP PNS</th>
                <td><?= $nip_pns ?></td>
            </tr>
            <tr>
                <th class="span2">Instansi Induk Dosen</th>
                <td><?= $instansi_induk_dosen ?></td>
            </tr>
            <tr>
                <th class="span2">Golongan</th>
                <td><?= $golongan ?></td>
            </tr>
            <tr>
                <th class="span2">TMT Golongan</th>
                <td><?= $tmt_golongan ?></td>
            </tr>
            <tr>
                <th class="span2">Jabatan Struktural</th>
                <td><?= $jabatan_struktural ?></td>
            </tr>
            <tr>
                <th class="span2">TMT Jabatan</th>
                <td><?= $tmt_jabatan ?></td>
            </tr>
            <tr>
                <th class="span2">Alamat</th>
                <td><?= $alamat ?></td>
            </tr>
            <tr>
                <th class="span2">No Telepon</th>
                <td><?= $no_telp ?></td>
            </tr>
            <tr>
                <th class="span2">No HP</th>
                <td><?= $no_hp ?></td>
            </tr>
            <tr>
                <th class="span2">Tanggal Masuk</th>
                <td><?= $tgl_mulai_masuk ?></td>
            </tr>
            <tr>
                <th class="span2">Tanggal Keluar</th>
                <td><?= $tgl_keluar ?></td>
            </tr>
            <tr>
                <th class="span2">Email</th>
                <td><?= $email ?></td>
            </tr>
            <tr>
                <th class="span2">Foto Dosen</th>
                <td>
                    <?php
                        $path_parts = pathinfo('/assets/dosen/thumbs/'.$foto_dosen);
                        $image_filename = $path_parts['filename'];
                        $image_extension = @$path_parts['extension'];
                        if(isset($image_extension)){
                            echo"<a href='".base_url()."assets/dosen/medium/".$image_filename.'_medium.'.$image_extension."' rel="."shadowbox".">
                                    <img src=".base_url()."assets/dosen/thumbs/".$image_filename.'_thumb.'.$image_extension.">
                                </a>";
                        }
                    ?>
                </td>
            </tr>
        </tbody>
    </table>
</div>

<?php $this->load->view('_shared/footer'); ?>