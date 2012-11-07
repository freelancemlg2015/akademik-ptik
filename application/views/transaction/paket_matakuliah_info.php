<?php
$this->load->view('_shared/header');
$this->load->view('_shared/menus');
//label
$control_label = array(
    'class' => 'control-label'
);
?>
<div class="container-full form-horizontal" id="paket_matakuliah">
    <table cellspacing="0" cellpadding="0" border="0" class="table table-bordered">
        <tbody>
            <tr>
                <th class="span2">Angkatan</th>
                <td><?= $nama_angkatan ?></td>
            </tr>
            <tr>
                <th class="span2">Tahun Akademik</th>
                <td>
                    <?php
                        $tahun = $tahun_ajar_mulai.$tahun_ajar_akhir;
                        if(!empty($tahun)){
                            echo $tahun = $tahun_ajar_mulai.'-'.$tahun_ajar_akhir; 
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
        </tbody>
    </table>
    
    <table class="table table-bordered table-striped container-full"  id="paket_mata_kuliah" controller="transaction">
        <thead>
            <tr>
                <th width="20">No</th>
                <th>Kode Kelompok</th>
                <th>Nama Kelompok</th>
            </tr>
        </thead>
        <tbody>
            <?php         
                $no = 1;
                if(isset($paket_detil_options)){
                    foreach ($paket_detil_options As $row) {
                    echo '<tr>
                            <td style="text-align: center">' . $no . '</td>    
                            <td>' . $row['kode_kelompok'] . '</td>    
                            <td>' . $row['nama_kelompok_mata_kuliah'] . '</td>
                        </tr>';
                    $no++;                    
                    }
                }
            ?>
        </tbody>
    </table>

</div>

<?php $this->load->view('_shared/footer'); ?>