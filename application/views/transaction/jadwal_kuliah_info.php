<?php
$this->load->view('_shared/header');
$this->load->view('_shared/menus');
//label
$control_label = array(
    'class' => 'control-label'
);
?>
<div class="container-full form-horizontal" id="jadwal_kuliah">
    <table cellspacing="0" cellpadding="0" border="0" class="table table-bordered">
        <tbody>
            <tr>
                <th class="span2">Nama Mata Kuliah</th>
                <td><?= $nama_mata_kuliah  ?></td>
            </tr>
            <tr>
                <th class="span2">Ruang</th>
                <td><?= $nama_ruang ?></td>
            </tr>
            <tr>
                <th class="span2">Jenis Waktu</th>
                <td><?//= $jenis_waktu ?></td>
            </tr>
            <tr>
                <th class="span2">Tanggal</th>
                <td><?//= $tanggal ?></td>
            </tr>
            <tr>
                <th class="span2">Jam</th>
                <td><?//= $jam ?></td>
            </tr>
            <tr>
                <th class="span2">Keterangan</th>
                <td><?= $keterangan ?></td>
            </tr>
        </tbody>
    </table>
</div>

<?php $this->load->view('_shared/footer'); ?>