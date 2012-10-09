<?php
$this->load->view('_shared/header');
$this->load->view('_shared/menus');
//label
$control_label = array(
    'class' => 'control-label'
);
?>
<div class="container-full form-horizontal" id="bobot_nilai">
    <table cellspacing="0" cellpadding="0" border="0" class="table table-bordered">
        <tbody>
            <tr>
                <th class="span2">Nilai Angka</th>
                <td><?= $nilai_angka ?></td>
            </tr>
            <tr>
                <th class="span2">Nilai Huruf</th>
                <td><?= $nilai_huruf ?></td>
            </tr>
            <tr>
                <th class="span2">Bobot Nilai Huruf</th>
                <td><?= $bobot_nilai_huruf ?></td>
            </tr>
            <tr>
                <th class="span2">Keterangan Bobot Nilai</th>
                <td><?= $keterangan_bobot_nilai ?></td>
            </tr>
        </tbody>
    </table>
</div>

<?php $this->load->view('_shared/footer'); ?>