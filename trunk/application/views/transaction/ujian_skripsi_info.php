<?php
$this->load->view('_shared/header');
$this->load->view('_shared/menus');
//label
$control_label = array(
    'class' => 'control-label'
);
?>
<div class="container-full form-horizontal" id="ujian_skripsi">
    <table cellspacing="0" cellpadding="0" border="0" class="table table-bordered span4">
        <tbody>
            <tr>
                <th class="span2">Nim</th>
                <td><?= $nim ?></td>
            </tr>
            <tr>
                <th class="span2">Judul Skripsi</th>
                <td><?= $judul_skripsi ?></td>
            </tr>
            <tr>
                <th class="span2">Tanggal Ujian</th>
                <td><?= $tgl_ujian ?></td>
            </tr>
            <tr>
                <th class="span2">Jam Mulai</th>
                <td><?= $jam_mulai ?></td>
            </tr>
            <tr>
                <th class="span2">Jam Akhir</th>
                <td><?= $jam_akhir ?></td>
            </tr>
            <tr>
                <th class="span2">Ketua Penguji</th>
                <td><?= $ketua_penguji ?></td>
            </tr>
            <tr>
                <th class="span2">Anggota Penguji 1</th>
                <td><?= $anggota_penguji_1 ?></td>
            </tr>
            <tr>
                <th class="span2">Anggota Penguji 2</th>
                <td><?= $anggota_penguji_2 ?></td>
            </tr>
            <tr>
                <th class="span2">Sekretaris Penguji</th>
                <td><?= $sekretaris_penguji ?></td>
            </tr>
            <tr>
                <th class="span2">Keterangan</th>
                <td><?= $keterangan ?></td>
            </tr>
        </tbody>
    </table>
</div>

<?php $this->load->view('_shared/footer'); ?>