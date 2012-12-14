<?php
$this->load->view('_shared/header');
$this->load->view('_shared/menus');
//label
$control_label = array(
    'class' => 'control-label'
);

$nilai_ketua_attr = array(
    'name'  => 'nilai_ketua',
    'class' => 'input-mini',
    'value' => set_value($nilai_ketua),
    'autocomplete' => 'off',
    'readonly' => 'readonly' 
);

?>
<div class="container-full form-horizontal" id="nilai_skripsi">
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
                <th class="span2">Tanggal Ujian</th>
                <td><?= $tgl_ujian ?></td>
            </tr>
            <tr>
                <th class="span2">Jam</th>
                <td>
                    <?php 
                        $jam = $jam_mulai.$jam_akhir;
                        if(!empty($jam)){
                            echo substr($jam_mulai, 0,5).'-'.substr($jam_akhir, 0,5);
                        }
                    ?>
                </td>
            </tr>
        </tbody>
    </table>
    
    <fieldset>                
        <table  class="table table-bordered table-striped container-full"  id="nilai_skripsi" controller="transaction">
            <thead>
                <tr>
                    <th colspan="3" style="text-align: center;"></th>
                    <th colspan="1" style="text-align: center;">Nilai</th>
                </tr>
            </thead>
            <tbody>  
                <tr>
                    <th class="span3">Judul Skripsi</th>
                    <td colspan="3"><?= $judul_skripsi_diajukan ?></td>
                </tr>                            
                <tr>
                    <th class="span3">Ketua Penguji</th>
                    <td colspan="2"><?= $nama_ketua_penguji ?></td> &nbsp; <td style="text-align: center;"><input type="text" style="text-align: center;" class="input-mini" readonly="readonly" value="<?= $nilai_ketua ?>"></td>
                </tr>
                <tr>
                    <th class="span3">Anggota Penguji 1</th>
                    <td colspan="2"><?= $nama_anggota_satu ?></td> &nbsp; <td style="text-align: center;"><input type="text" style="text-align: center;" class="input-mini" readonly="readonly" value="<?= $nilai_agt_1 ?>"></td>
                </tr>
                <tr>
                    <th class="span3">Anggota Penguji 2</th>
                    <td colspan="2"><?= $nama_anggota_dua ?></td> &nbsp; <td style="text-align: center;"><input type="text"  style="text-align: center;" class="input-mini" readonly="readonly" value="<?= $nilai_agt_2 ?>"></td>
                </tr>
                <tr>
                    <th class="span2">Sekretaris Penguji</th>
                    <td colspan="3"><?= $nama_sekretaris ?></td>
                </tr>
                <tr>
                    <th class="span2">Keterangan</th>
                    <td colspan="3"><?= $keterangan ?></td>
                </tr>    
            </tbody>
        </table>
    </fieldset>
</div>

<?php $this->load->view('_shared/footer'); ?>