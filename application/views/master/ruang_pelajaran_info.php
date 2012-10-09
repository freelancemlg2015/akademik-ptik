<?php
$this->load->view('_shared/header');
$this->load->view('_shared/menus');
//label
$control_label = array(
    'class' => 'control-label'
);
?>
<div class="container-full form-horizontal" id="ruang_pelajaran">
    <table cellspacing="0" cellpadding="0" border="0" class="table table-bordered">
        <tbody>
            <tr>
                <th class="span2">Kode Ruang</th>
                <td><?= $kode_ruang ?></td>
            </tr>
            <tr>
                <th class="span2">Nama Ruang</th>
                <td><?= $nama_ruang ?></td>
            </tr>
             <tr>
                <th class="span2">Jensi Ruang</th>
                <td><?= $jenis_ruang ?></td>
            </tr>
            <tr>
                <th class="span2">Kapasitas Ruang</th>
                <td><?= $kapasitas_ruang ?></td>
            </tr>
        </tbody>
    </table>
</div>

<?php $this->load->view('_shared/footer'); ?>