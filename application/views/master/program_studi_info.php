<?php
$this->load->view('_shared/header');
$this->load->view('_shared/menus');
//label
$control_label = array(
    'class' => 'control-label'
);
?>
<div class="container-full form-horizontal" id="program_studi">
    <table cellspacing="0" cellpadding="0" border="0" class="table table-bordered span4">
        <tbody>
            <tr>
                <th class="span2">Kode Program Studi</th>
                <td><?= $kode_program_studi ?></td>
            </tr>
            <tr>
                <th class="span2">Nama Program Studi</th>
                <td><?= $nama_program_studi ?></td>
            </tr>
             <tr>
                <th class="span2">Angkatan</th>
                <td><?= $nama_angkatan ?></td>
            </tr>
            <tr>
                <th class="span2">Inisial</th>
                <td><?= $inisial ?></td>
            </tr>
             <tr>
                <th class="span2">Jenjang Studi</th>
                <td><?= $jenjang_studi ?></td>
            </tr>
            <tr>
                <th class="span2">Status Akreditasi</th>
                <td><?= $status_akreditasi ?></td>
            </tr>
             <tr>
                <th class="span2">No SK Terakhir</th>
                <td><?= $no_sk_terakhir ?></td>
            </tr>
            <tr>
                <th class="span2">Tgl SK Terakhir</th>
                <td><?= $tgl_sk_terakhir ?></td>
            </tr>
             <tr>
                <th class="span2">Jumlah SKS</th>
                <td><?= $jml_sks ?></td>
            </tr>
             <tr>
                <th class="span2">Kode Status Program Studi</th>
                <td><?= $kode_status_program_studi ?></td>
            </tr>
            <tr>
                <th class="span2">Tahun Semester Mulai</th>
                <td><?= $thn_semester_mulai ?></td>
            </tr>
             <tr>
                <th class="span2">Email</th>
                <td><?= $email ?></td>
            </tr>
            <tr>
                <th class="span2">Tgl Pendirian Program Studi</th>
                <td><?= $tgl_pendirian_program_studi ?></td>
            </tr>
             <tr>
                <th class="span2">No SK Akreditasi</th>
                <td><?= $no_sk_akreditasi ?></td>
            </tr>
            <tr>
                <th class="span2">Tgl SK Akreditasi</th>
                <td><?= $tgl_sk_akreditasi ?></td>
            </tr>
            <tr>
                <th class="span2">Tgl Akhir SK</th>
                <td><?= $tgl_akhir_sk ?></td>
            </tr>
            <tr>
                <th class="span2">Frekuensi Pemutakhiran Kurikulum</th>
                <td><?= $frekuensi_pemutahiran_kurikulum ?></td>
            </tr>
            <tr>
                <th class="span2">Pelaksana Pemutakhiran</th>
                <td><?= $pelaksana_pemutahiran ?></td>
            </tr>
        </tbody>
    </table>
</div>

<?php $this->load->view('_shared/footer'); ?>