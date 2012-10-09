<?php
$this->load->view('_shared/header');
$this->load->view('_shared/menus');
//label
$control_label = array(
    'class' => 'control-label'
);
?>
<div class="container-full form-horizontal" id="jam_pelajaran">
    <table cellspacing="0" cellpadding="0" border="0" class="table table-bordered">
        <tbody>
            <tr>
                <th class="span2">Kode Jam</th>
                <td><?= $kode_jam ?></td>
            </tr>
            <tr>
                <th class="span2">Jam Normal</th>
                <td><?= substr($jam_normal_mulai, 0,5).'-'.substr($jam_normal_akhir, 0,5) ?></td>
            </tr>
            <tr>
                <th class="span2">Jam Puasa</th>
                <td><?= substr($jam_puasa_akhir, 0,5).'-'.substr($jam_puasa_akhir, 0,5) ?></td>
            </tr>
        </tbody>
    </table>
</div>

<?php $this->load->view('_shared/footer'); ?>