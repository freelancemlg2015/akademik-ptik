<?php
$this->load->view('_shared/header');
$this->load->view('_shared/menus');
//label
$control_label = array(
    'class' => 'control-label'
);
?>
<div class="container-full form-horizontal" id="data_mahasiswa">
    <table cellspacing="0" cellpadding="0" border="0" class="table table-bordered">
        <tbody>
            <tr>
                <th class="span2">Nim</th>
                <td><?= $nim ?></td>
            </tr>
            <tr>
                <th class="span2">Nama</th>
                <td><?= $nama ?></td>
            </tr>
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
        </tbody>
    </table>
</div>

<?php $this->load->view('_shared/footer'); ?>