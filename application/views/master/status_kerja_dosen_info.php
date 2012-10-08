<?php
$this->load->view('_shared/header');
$this->load->view('_shared/menus');
//label
$control_label = array(
    'class' => 'control-label'
);
?>
<div class="container-full form-horizontal" id="status_kerja_dosen">
    <table cellspacing="0" cellpadding="0" border="0" class="table table-bordered span4">
        <tbody>
            <tr>
                <th class="span2">Kode Status Kerja Dosen</th>
                <td><?= $kode_status_kerja_dosen ?></td>
            </tr>
            <tr>
                <th class="span2">Status Kerja Dosen</th>
                <td><?= $status_kerja_dosen ?></td>
            </tr>
        </tbody>
    </table>
</div>

<?php $this->load->view('_shared/footer'); ?>