<?php
$this->load->view('_shared/header');
$this->load->view('_shared/menus');
//label
$control_label = array(
    'class' => 'control-label'
);
?>
<div class="container-full form-horizontal" id="bobot_nilai">
    <table cellspacing="0" cellpadding="0" border="0" class="table table-bordered span4">
        <tbody>
            <tr>
                <th class="span2">Kode Bobot Nilai</th>
                <td><?= $kode_bobot_nilai ?></td>
            </tr>
            <tr>
                <th class="span2">Keterangan Nilai</th>
                <td><?= $keterangan_nilai ?></td>
            </tr>
        </tbody>
    </table>
</div>

<?php $this->load->view('_shared/footer'); ?>