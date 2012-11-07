<?php
$this->load->view('_shared/header');
$this->load->view('_shared/menus');
//label
$control_label = array(
    'class' => 'control-label'
);
?>
<div class="container-full form-horizontal" id="plot_dosen_penanggung_jawab">
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
                            echo $tahun_ajar_mulai.'-'.$tahun_ajar_akhir; 
                        }     
                    ?>
                </td>
            </tr>
            <tr>
                <th class="span2">Semester</th>
                <td><?= $nama_semester ?></td>
            </tr>
            <tr>
                <th class="span2">Konsentrasi Studi</th>
                <td><?= $nama_kelompok_mata_kuliah ?></td>
            </tr>
            <tr>
                <th class="span2">Mata Kuliah</th>
                <td>
                    <?php
                        if(isset($plot_detil_options)){
                            foreach($plot_detil_options as $row){
                                echo $row['nama_mata_kuliah'];
                            }
                        }
                    ?>
                </td>
            </tr>
        </tbody>
    </table>
    
    <table class="table table-bordered table-striped container-full"  id="plot_dosen_penanggung_jawab" controller="transaction">
        <thead>
            <tr>
                <th width="20">No</th>
                <th>No Karpeg Dosen</th>
                <th>No Dosen Fakultas</th>
                <th>No Dosen Dikti</th>
                <th>Dosen</th>
            </tr>
        </thead>
        <tbody>
            <?php         
                $no = 1;
                if(isset($dosen_detil_options)){
                    foreach ($dosen_detil_options As $row) {
                    echo '<tr>
                            <td style="text-align: center">' . $no . '</td>    
                            <td>' . $row['no_karpeg_dosen'] . '</td>    
                            <td>' . $row['no_dosen_fakultas'] . '</td>
                            <td>' . $row['no_dosen_dikti'] . '</td>
                            <td>' . $row['nama_dosen'] . '</td>
                        </tr>';
                    $no++;                    
                    }
                }
            ?>
        </tbody>
    </table>
</div>

<?php $this->load->view('_shared/footer'); ?>