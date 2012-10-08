<?php
$this->load->view('_shared/header');
$this->load->view('_shared/menus');
//label
$control_label = array(
    'class' => 'control-label'
);
?>
<div class="container-full form-horizontal" id="pejabat_tanda_tangan">
    <table cellspacing="0" cellpadding="0" border="0" class="table table-bordered span4">
        <tbody>
            <tr>
                <th class="span2">Sub Direktorat</th>
                <td><?= $nama_subdirektorat ?></td>
            </tr>
            <tr>
                <th class="span2">Kategori</th>
                <td><?= $nama_jenis_pejabat ?></td>
            </tr>
            <tr>
                <th class="span2">Kop</th>
                <td><?= $kop ?></td>
            </tr>
            <tr>
                <th class="span2">Pejabat</th>
                <td><?= $nama_pejabat ?></td>
            </tr>
            <tr>
                <th class="span2">Tanggal</th>
                <td><?= $tanggal_tanda_tangan ?></td>
            </tr>
        </tbody>
    </table>
</div>

<?php $this->load->view('_shared/footer'); ?>