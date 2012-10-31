<?php
$this->load->view('_shared/header');
$this->load->view('_shared/menus');
//label
$control_label = array(
    'class' => 'control-label'
);
?>
<div class="container-full form-horizontal" id="angkatan">
    <table cellspacing="0" cellpadding="0" border="0" class="table table-bordered">
        <tbody>
            <tr>
                <th class="span2">Kode Angkatan</th>
                <td><?= $kode_angkatan ?></td>
            </tr>
            <tr>
                <th class="span2">Nama Angkatan</th>
                <td><?= $nama_angkatan ?></td>
            </tr>
            <tr>
                <th class="span2">Tahun</th>
                <td>    
                    <?php
                        $tahun = $tahun_ajar_mulai.$tahun_ajar_akhir ; 
                        if(!empty($tahun)){
                           echo $tahun_ajar_mulai.'-'.$tahun_ajar_akhir ; 
                        }
                    ?>
                </td>
            </tr>
        </tbody>
    </table>
</div>

<?php $this->load->view('_shared/footer'); ?>