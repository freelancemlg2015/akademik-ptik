<?php
$this->load->view('_shared/header');
$this->load->view('_shared/menus');
//label
$control_label = array(
    'class' => 'control-label'
);
?>
<div class="container-full form-horizontal" id="jabatan_tertinggi">
    <table cellspacing="0" cellpadding="0" border="0" class="table table-bordered span4">
        <tbody>
            <tr>
                <th class="span2">Kode Jabatan Tertinggi</th>
                <td><?= $kode_jabatan_tertinggi ?></td>
            </tr>
            <tr>
                <th class="span2">Jabatan Tertinggi</th>
                <td><?= $jabatan_tertinggi ?></td>
            </tr>
             <tr>
                <th class="span2">Status Akreditasi</th>
                <td><?= $status_akreditasi ?></td>
            </tr>
        </tbody>
    </table>
</div>

<?php $this->load->view('_shared/footer'); ?>