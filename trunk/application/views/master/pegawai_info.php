<?php
$this->load->view('_shared/header');
$this->load->view('_shared/menus');
//label
$control_label = array(
    'class' => 'control-label'
);
?>
<div class="container-full form-horizontal" id="pegawai">
    <table cellspacing="0" cellpadding="0" border="0" class="table table-bordered">
        <tbody>
             <tr>
                <th class="span2">Pangkat</th>
                <td><?= $nama_pangkat ?></td>
            </tr>
            <tr>
                <th class="span2">No Karpeg Pegawai</th>
                <td><?= $no_karpeg_pegawai ?></td>
            </tr>
             <tr>
                <th class="span2">Nama Pegawai</th>
                <td><?= $nama_pegawai ?></td>
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
                <th class="span2">NIP PNS</th>
                <td><?= $nip_pns ?></td>
            </tr>
            <tr>
                <th class="span2">Jabatan Struktural</th>
                <td><?= $jabatan_struktural ?></td>
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
                <th class="span2">Email</th>
                <td><?= $email ?></td>
            </tr>
            <tr>
                <th class="span2">Foto Pegawai</th>
                <td>
                    <?php
                        $path_parts = pathinfo('/assets/pegawai/thumbs/'.$foto_pegawai);
                        $image_filename = $path_parts['filename'];
                        $image_extension = @$path_parts['extension'];
                        if(isset($image_extension)){
                            echo"<a href='".base_url()."assets/pegawai/medium/".$image_filename.'_medium.'.$image_extension."' rel="."shadowbox".">
                                    <img src=".base_url()."assets/pegawai/thumbs/".$image_filename.'_thumb.'.$image_extension.">
                                </a>";
                        }
                    ?>
                </td>
            </tr>
        </tbody>
    </table>
</div>

<?php $this->load->view('_shared/footer'); ?>