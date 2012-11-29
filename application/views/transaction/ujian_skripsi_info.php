<?php
$this->load->view('_shared/header');
$this->load->view('_shared/menus');
//label
$control_label = array(
    'class' => 'control-label'
);
?>
<div class="container-full form-horizontal" id="ujian_skripsi">
    <table cellspacing="0" cellpadding="0" border="0" class="table table-bordered">
        <tbody>
            <tr>
                <th class="span2">Angkatan</th>
                <td><?= $nama_angkatan ?></td>
            </tr>
            <tr>
                <th class="span2">Tahun</th>
                <td>
                    <?php
                        $tahun = $tahun_ajar_mulai.'-'.$tahun_ajar_akhir;
                        if(!empty($tahun)){
                            echo $tahun;                                                        
                        }     
                    ?>
                </td>
            </tr>
            <tr>
                <th class="span2">Semester</th>
                <td><?= $nama_semester ?></td>
            </tr>
            <tr>
                <th class="span2">Program Studi</th>
                <td><?= $nama_program_studi ?></td>
            </tr>
            <tr>
                <th class="span2">Mahasiswa</th>
                <td><?= $nama ?></td>
            </tr>
            <tr>
                <th class="span2">Judul Skripsi</th>
                <td><?= $judul_skripsi_diajukan ?></td>
            </tr>
            <tr>
                <th class="span2">Tanggal Ujian</th>
                <td><?= $tgl_ujian ?></td>
            </tr>
            <tr>
                <th class="span2">Jam</th>
                <td>
                    <?php 
                        $jam = $jam_mulai.$jam_akhir;
                        if(empty($jam)){
                            
                        }else{
                    ?>
                        <?= substr($jam_mulai, 0,5).'-'.substr($jam_akhir, 0,5) ?>
                    <?php
                        }
                    ?>
                </td>
            </tr>
            <tr>
                <th class="span2">Jam Akhir</th>
                <td><?= $jam_akhir ?></td>
            </tr>
            <tr>
                <th class="span2">Ketua Penguji</th>
                <td><?= $nama_ketua_penguji ?></td>
            </tr>
            <tr>
                <th class="span2">Anggota Penguji 1</th>
                <td><?= $nama_anggota_satu ?></td>
            </tr>
            <tr>
                <th class="span2">Anggota Penguji 2</th>
                <td><?= $nama_anggota_dua ?></td>
            </tr>
            <tr>
                <th class="span2">Sekretaris Penguji</th>
                <td><?= $nama_sekretaris ?></td>
            </tr>
            <tr>
                <th class="span2">Keterangan</th>
                <td><?= $keterangan ?></td>
            </tr>
        </tbody>
    </table>
</div>

<?php $this->load->view('_shared/footer'); ?>