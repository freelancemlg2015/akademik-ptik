<?php
$this->load->view('_shared/header');
$this->load->view('_shared/menus');
//label
$control_label = array(
    'class' => 'control-label'
);
?>
<div class="container-full form-horizontal" id="tahun_akademik">
    <table cellspacing="0" cellpadding="0" border="0" class="table table-bordered">
        <tbody>
            <tr>
                <th class="span2">Kode Tahun Ajar</th>
                <td><?= $kode_tahun_ajar ?></td>
            </tr>
            <tr>
                <th class="span2">Tahun</th>
                <td><?= $tahun ?></td>
            </tr>
            <tr>
                <th class="span2">Tgl Mulai</th>
                <td><?= $tgl_mulai ?></td>
            </tr>
        </tbody>
    </table>
</div>

<?php $this->load->view('_shared/footer'); ?>