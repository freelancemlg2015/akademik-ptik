<?php
$this->load->view('_shared/header');
$this->load->view('_shared/menus');
//label
$control_label = array(
    'class' => 'control-label'
);
?>
<div class="container-full form-horizontal" id="kesatuan_asal">
    <table cellspacing="0" cellpadding="0" border="0" class="table table-bordered span4">
        <tbody>
            <tr>
                <th class="span2">Kode Kesatuan Asal</th>
                <td><?= $kode_kesatuan_asal ?></td>
            </tr>
            <tr>
                <th class="span2">Nama Kesatuan Asal</th>
                <td><?= $nama_kesatuan_asal ?></td>
            </tr>
        </tbody>
    </table>
</div>

<?php $this->load->view('_shared/footer'); ?>