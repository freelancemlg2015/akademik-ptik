<?php
$this->load->view('_shared/header');
$this->load->view('_shared/menus');
//label
$control_label = array(
    'class' => 'control-label'
);
?>
<div class="container-full form-horizontal" id="rencana_mata_pelajaran">
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
            <tr>
                <th class="span2">Mata Kuliah</th>
                <td>
                    <?php
                      foreach($mata_kuliah_info as $row){
                         echo $row['nama_mata_kuliah'];                          
                      }
                    ?> 
                </td>
            </tr> 
        </tbody>
    </table>
    
    <table class="table table-bordered table-striped container-full"  id="rencana_mata_pelajaran" controller="transaction">
        <thead>
            <tr>
                <th width="20">No</th>
                <th>Nim</th>
                <th>Mahasiswa</th>
            </tr>
        </thead>
        <tbody>
            <?php         
                $no = 1;
                if(isset($mahasiswa_info)){
                    foreach ($mahasiswa_info As $row) {
                    echo '<tr>
                            <td style="text-align: center">' . $no . '</td>    
                            <td>' . $row['nim'] . '</td>    
                            <td>' . $row['nama'] . '</td>
                        </tr>';
                    $no++;                    
                    }
                }
            ?>
        </tbody>
    </table>
</div>

<?php $this->load->view('_shared/footer'); ?>