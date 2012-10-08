<?php
$this->load->view('_shared/header');
$this->load->view('_shared/menus');
//label
$control_label = array(
    'class' => 'control-label'
);
?>
<div class="container-full form-horizontal" id="kelompok_mata_kuliah">
    <table cellspacing="0" cellpadding="0" border="0" class="table table-bordered span4">
        <tbody>
            <tr>
                <th class="span2">Kode Kelompok Mata Kuliah</th>
                <td><?= $kode_kelompok_mata_kuliah ?></td>
            </tr>
            <tr>
                <th class="span2">Kelompok Mata Kuliah</th>
                <td><?= $kelompok_mata_kuliah ?></td>
            </tr>
        </tbody>
    </table>
</div>

<?php $this->load->view('_shared/footer'); ?>