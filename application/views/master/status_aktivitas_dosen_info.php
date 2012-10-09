<?php
$this->load->view('_shared/header');
$this->load->view('_shared/menus');
//label
$control_label = array(
    'class' => 'control-label'
);
?>
<div class="container-full form-horizontal" id="status_aktivitas_dosen">
    <table cellspacing="0" cellpadding="0" border="0" class="table table-bordered">
        <tbody>
            <tr>
                <th class="span2">Kode Status Aktivitas</th>
                <td><?= $kode_status_aktivitas ?></td>
            </tr>
            <tr>
                <th class="span2">Status Aktivitas Dosen</th>
                <td><?= $status_aktivitas_dosen ?></td>
            </tr>
        </tbody>
    </table>
</div>

<?php $this->load->view('_shared/footer'); ?>