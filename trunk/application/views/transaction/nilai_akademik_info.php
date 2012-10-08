<?php
$this->load->view('_shared/header');
$this->load->view('_shared/menus');
//label
$control_label = array(
    'class' => 'control-label'
);
?>
<div class="container-full form-horizontal" id="nilai_akademik">
    <table cellspacing="0" cellpadding="0" border="0" class="table table-bordered span4">
        <tbody>
            <tr>
                <th class="span2">Nim</th>
                <td><?= $nim ?></td>
            </tr>
            <tr>
                <th class="span2">Mata Kuliah</th>
                <td><?= $nama_mata_kuliah ?></td>
            </tr>
            <tr>
                <th class="span2">Nilai NTS</th>
                <td><?= $nilai_nts ?></td>
            </tr>
            <tr>
                <th class="span2">Mata Tugas</th>
                <td><?= $nilai_tgs ?></td>
            </tr>
            <tr>
                <th class="span2">Nilai NAS</th>
                <td><?= $nilai_nas ?></td>
            </tr>
            <tr>
                <th class="span2">Nilai Perubahan</th>
                <td><?= $nilai_prb ?></td>
            </tr>
            <tr>
                <th class="span2">Nilai Akhir</th>
                <td><?= $nilai_akhir ?></td>
            </tr>
            <tr>
                <th class="span2">Rangking</th>
                <td><?= $rangking ?></td>
            </tr>
            <tr>
                <th class="span2">Keterangan</th>
                <td><?= $keterangan ?></td>
            </tr>
        </tbody>
    </table>
</div>

<?php $this->load->view('_shared/footer'); ?>