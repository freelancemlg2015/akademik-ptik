<?php
$this->load->view('_shared/header');
$this->load->view('_shared/menus');
//label
$control_label = array(
    'class' => 'control-label'
);
?>
<div class="container-full form-horizontal" id="jabatan_akademik">
    <table cellspacing="0" cellpadding="0" border="0" class="table table-bordered">
        <tbody>
            <tr>
                <th class="span2">Kode Jabatan Akademik</th>
                <td><?= $kode_jabatan_akademik ?></td>
            </tr>
            <tr>
                <th class="span2">Nama Jabatan Akademik</th>
                <td><?= $nama_jabatan_akademik ?></td>
            </tr>
        </tbody>
    </table>
</div>

<?php $this->load->view('_shared/footer'); ?>