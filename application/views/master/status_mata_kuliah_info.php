<?php
$this->load->view('_shared/header');
$this->load->view('_shared/menus');
//label
$control_label = array(
    'class' => 'control-label'
);
?>
<div class="container-full form-horizontal" id="status_mata_kuliah">
    <table cellspacing="0" cellpadding="0" border="0" class="table table-bordered">
        <tbody>
            <tr>
                <th class="span2">Angkatan</th>
                <td><?= $nama_angkatan ?></td>
            </tr>
            <tr>
                <th class="span2">Kode Dik Angkatan</th>
                <td><?= $kode_dikang ?></td>
            </tr>
            <tr>
                <th class="span2">Kode Matakuliah</th>
                <td><?= $kode_matakuliah ?></td>
            </tr>
            <tr>
                <th class="span2">Nama Matakuliah</th>
                <td><?= $nama_matakuliah ?></td>
            </tr>
            <tr>
                <th class="span2">Status Mata Kuliah</th>
                <td><?= $status_mata_kuliah ?></td>
            </tr>
            <tr>
                <th class="span2">Jumlah SKS</th>
                <td><?= $jml_sks ?></td>
            </tr>
            <tr>
                <th class="span2">Konsentrasi Studi</th>
                <td><?= $nama_konsentrasi_studi ?></td>
            </tr>
            <tr>
                <th class="span2">Bobot Nts</th>
                <td><?= $nama_konsentrasi_studi ?></td>
            </tr>
            <tr>
                <th class="span2">Bobot Nas</th>
                <td><?= $bobot_nas ?></td>
            </tr>
            <tr>
                <th class="span2">Bobot Tgs</th>
                <td><?= $bobot_tgs ?></td>
            </tr>
        </tbody>
    </table>
</div>

<?php $this->load->view('_shared/footer'); ?>