<?php
$this->load->view('_shared/header');
$this->load->view('_shared/menus');
//label
$control_label = array(
    'class' => 'control-label'
);
?>
<div class="container-full form-horizontal" id="jadwal_kuliah">
    <table cellspacing="0" cellpadding="0" border="0" class="table table-bordered">
        <tbody>
            <tr>
                <th class="span2">Angkatan</th>
                <td><?= $nama_angkatan;	?></td>
            </tr>
			<tr>
                <th class="span2">Tahun Akademik</th>
                <td><?= $tahun_ajar_mulai ."-". $tahun_ajar_akhir ?></td>
            </tr>
            <tr>
                <th class="span2">Semester</th>
                <td><?= $nama_semester ?></td>
            </tr>
            <tr>
                <th class="span2">Tanggal Mulai</th>
                <td><?= $tgl_kalender_mulai ?></td>
            </tr>
            <tr>
                <th class="span2">Tanggal Akhir</th>
                <td><?= $tgl_kalender_akhir ?></td>
            </tr>
        </tbody>
    </table>
</div>

<?php $this->load->view('_shared/footer'); ?>