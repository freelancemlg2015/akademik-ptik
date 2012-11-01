<?php
$this->load->view('_shared/header');
$this->load->view('_shared/menus');
//label
$control_label = array(
    'class' => 'control-label'
);
?>
<div class="container-full form-horizontal" id="mata_kuliah">
    <table cellspacing="0" cellpadding="0" border="0" class="table table-bordered">
        <tbody>
            <tr>
                <th class="span2">Kode Mata Kuliah</th>
                <td><?= $kode_mata_kuliah ?></td>
            </tr>
            <tr>
                <th class="span2">Nama Mata Kuliah</th>
                <td><?= $nama_mata_kuliah ?></td>
            </tr>
            <tr>
                <th class="span2">Sks Mata Kuliah</th>
                <td><?= $sks_mata_kuliah ?></td>
            </tr>
            <tr>
                <th class="span2">Sks Tatap Muka</th>
                <td><?= $sks_tatap_muka ?></td>
            </tr>
            <tr>
                <th class="span2">Jenis Mata Kuliah</th>
                <td><?= $jenis_mata_kuliah ?></td>
<!--            </tr>
            <tr>
                <th class="span2">Silabus</th>
                <td><?//= $silabus ?></td>
            </tr>-->
        </tbody>
    </table>
</div>

<?php $this->load->view('_shared/footer'); ?>