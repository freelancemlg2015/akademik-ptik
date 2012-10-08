<?php
$this->load->view('_shared/header');
$this->load->view('_shared/menus');
//label
$control_label = array(
    'class' => 'control-label'
);
?>
<div class="container-full form-horizontal" id="plot_dosen_ajar">
    <table cellspacing="0" cellpadding="0" border="0" class="table table-bordered span4">
        <tbody>
            <tr>
                <th class="span2">Angkatan</th>
                <td><?= $nama_angkatan ?></td>
            </tr>
            <tr>
                <th class="span2">Tahun Akademik</th>
                <td><?= $tahun_ajar ?></td>
            </tr>
            <tr>
                <th class="span2">Semester</th>
                <td><?= $nama_semester ?></td>
            </tr>
            <tr>
                <th class="span2">Mata Kuliah</th>
                <td><?= $nama_mata_kuliah ?></td>
            </tr>
            <tr>
                <th class="span2">Dosen</th>
                <td><?= $nama_dosen ?></td>
            </tr>
            <tr>
                <th class="span2">Mahasiswa</th>
                <td><?= $nama ?></td>
            </tr>
            <tr>
                <th class="span2">Keterangan</th>
                <td><?= $keterangan ?></td>
            </tr>
        </tbody>
    </table>
</div>

<?php $this->load->view('_shared/footer'); ?>