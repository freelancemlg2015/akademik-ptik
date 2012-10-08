<?php
$this->load->view('_shared/header');
$this->load->view('_shared/menus');
//label
$control_label = array(
    'class' => 'control-label'
);
?>
<div class="container-full form-horizontal" id="mata_kuliah">
    <table cellspacing="0" cellpadding="0" border="0" class="table table-bordered span4">
        <tbody>
            <tr>
                <th class="span2">Angkatan</th>
                <td><?= $nama_angkatan ?></td>
            </tr>
            <tr>
                <th class="span2">Program Studi</th>
                <td><?= $nama_program_studi ?></td>
            </tr>
            <tr>
                <th class="span2">Jenjang Studi</th>
                <td><?= $jenjang_studi ?></td>
            </tr>
            <tr>
                <th class="span2">Tahun Ajar</th>
                <td><?= $tahun_ajar ?></td>
            </tr>
            <tr>
                <th class="span2">Kode Mata Kuliah</th>
                <td><?= $kode_mata_kuliah ?></td>
            </tr>
            <tr>
                <th class="span2">Nama Mata Kuliah</th>
                <td><?= $nama_mata_kuliah ?></td>
            </tr>
            <tr>
                <th class="span2">english</th>
                <td><?= $english ?></td>
            </tr>
            <tr>
                <th class="span2">Sks Mata Kuliah</th>
                <td><?= $sks_mata_kuliah ?></td>
            </tr>
            <tr>
                <th class="span2">Sks Tatap Muka</th>
                <td><?= $sks_tatap_muka ?></td>
            </tr>
            <tr>
                <th class="span2">Sks Praktikum</th>
                <td><?= $sks_praktikum ?></td>
            </tr>
            <tr>
                <th class="span2">Nama Laboratorium</th>
                <td><?= $nama_laboratorium ?></td>
            </tr>
            <tr>
                <th class="span2">Sks Praktek Lapangan</th>
                <td><?= $sks_praktek_lapangan ?></td>
            </tr>
            <tr>
                <th class="span2">Semester</th>
                <td><?= $semester ?></td>
            </tr>
            <tr>
                <th class="span2">Kelompok Mata Kuliah</th>
                <td><?= $kelompok_mata_kuliah ?></td>
            </tr>
            <tr>
                <th class="span2">Jenis Kurikulum</th>
                <td><?= $jenis_kurikulum ?></td>
            </tr>
            <tr>
                <th class="span2">Jenis Mata Kuliah</th>
                <td><?= $jenis_mata_kuliah ?></td>
            </tr>
            <tr>
                <th class="span2">Jenis Program Studi Pengampu</th>
                <td><?= $jenjang_program_studi_pengampu ?></td>
            </tr>
            <tr>
                <th class="span2">Program Studi Pengampu</th>
                <td><?= $program_studi_pengampu ?></td>
            </tr>
            <tr>
                <th class="span2">Status Mata Kuliah</th>
                <td><?= $status_mata_kuliah ?></td>
            </tr>
            <tr>
                <th class="span2">Mata Kuliah Syarat Tempuh</th>
                <td><?= $mata_kuliah_syarat_tempuh ?></td>
            </tr>
            <tr>
                <th class="span2">Mata Kuliah Syarat Lulus</th>
                <td><?= $mata_kuliah_syarat_lulus ?></td>
            </tr>
            <tr>
                <th class="span2">Silabus</th>
                <td><?= $silabus ?></td>
            </tr>
        </tbody>
    </table>
</div>

<?php $this->load->view('_shared/footer'); ?>