<?php
$this->load->view('_shared/header');
$this->load->view('_shared/menus');
//label
$control_label = array(
    'class' => 'control-label'
);
?>
<div class="container-full form-horizontal" id="akta_mengajar">
    <table cellspacing="0" cellpadding="0" border="0" class="table table-bordered span4">
        <tbody>
            <tr>
                <th class="span2">Kode Akta</th>
                <td><?= $kode_akta ?></td>
            </tr>
            <tr>
                <th class="span2">Nama Akta Mengajar</th>
                <td><?= $nama_akta_mengajar ?></td>
            </tr>
        </tbody>
    </table>
</div>

<?php $this->load->view('_shared/footer'); ?>