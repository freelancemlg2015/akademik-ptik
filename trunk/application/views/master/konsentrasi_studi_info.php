<?php
$this->load->view('_shared/header');
$this->load->view('_shared/menus');
//label
$control_label = array(
    'class' => 'control-label'
);
?>
<div class="container-full form-horizontal" id="konsentrasi_studi">
    <table cellspacing="0" cellpadding="0" border="0" class="table table-bordered span4">
        <tbody>
            <tr>
                <th class="span2">Kode Konsentrasi Studi</th>
                <td><?= $kode_konsentrasi_studi ?></td>
            </tr>
            <tr>
                <th class="span2">Nama Konsentrasi Studi</th>
                <td><?= $nama_konsentrasi_studi ?></td>
            </tr>
        </tbody>
    </table>
</div>

<?php $this->load->view('_shared/footer'); ?>