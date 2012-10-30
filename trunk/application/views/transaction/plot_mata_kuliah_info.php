<?php
$this->load->view('_shared/header');
$this->load->view('_shared/menus');
//label
$control_label = array(
    'class' => 'control-label'
);
?>
<div class="container-full form-horizontal" id="plot_mata_kuliah">
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
                        $tahun = $tahun_ajar_mulai.$tahun_ajar_akhir ; 
                        if(!empty($tahun)){
                           echo $tahun_ajar_mulai.'-'.$tahun_ajar_akhir ; 
                        }
                    ?>
                </td>
            </tr>
            <tr>
                <th class="span2">Semester</th>
                <td><?= $nama_semester ?></td>
            </tr>
            <tr>
                <th class="span2">Kelompok Matakuliah</th>
                <td><?= $nama_kelompok_mata_kuliah ?></td>
            </tr>
            <tr>
                <th class="span2">Matakuliah</th>
                <td>
                    <?php
                        //foreach($matakuliah as $row){
                          //  $nama_mata_kuliah;
                        //}
                    ?>
                </td><br/>
            </tr>
        </tbody>
    </table>
</div>

<?php $this->load->view('_shared/footer'); ?>