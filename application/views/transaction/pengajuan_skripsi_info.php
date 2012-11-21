<?php
$this->load->view('_shared/header');
$this->load->view('_shared/menus');
//label
$control_label = array(
    'class' => 'control-label'
);
?>
<div class="container-full form-horizontal" id="pengajuan_skripsi">
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
                <th class="span2">Konsentrasi Studi</th>
                <td><?= $nama_program_studi ?></td>
            </tr>
            <tr>
                <th class="span2">Nim</th>
                <td><?= $nim ?></td>
            </tr>
            <tr>
                <th class="span2">Nama Mahasiswa</th>
                <td><?= $nama ?></td>
            </tr>
            <tr>
                <th class="span2">Dosen Pembimbing 1</th>
                <td>
                    <?php
                        foreach($dosen_data as $row){
                           echo  $row['nama_dosen_1'];                            
                        }    
                    ?>
                </td>
            </tr>
            <tr>                                  
                <th class="span2">Dosen Pembimbing 2</th>
                <td>
                    <?php
                        foreach($dosen_data as $row){
                           echo  $row['nama_dosen_2'];                            
                        }    
                    ?>
                </td>
            </tr>
            <tr>
                <th>Judul</th>
                <td>
                    <?php
                        if(isset($detail_data)){
                            foreach($detail_data as $row){
                                echo $row['judul_skripsi_diajukan'];                                    
                            }    
                        }
                    ?>
                </td>
            </tr>   
            <tr>
                <th class="span2">Status Judul</th>
                <td><?= $status_approval ?></td>
            </tr>
        </tbody>
    </table> 
</div>

<?php $this->load->view('_shared/footer'); ?>