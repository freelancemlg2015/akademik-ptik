<?php
$this->load->view('_shared/header');
$this->load->view('_shared/menus');

//label
$control_label = array(
    'class' => 'control-label'
);

$keterangan_attr = array(
    'name' => 'keterangan',
    'class' => 'span3',
    'value' => set_value('keterangan', $keterangan),
    'autocomplete' => 'off'    
);

$angkatan_data[0] = '';
foreach ($angkatan_options as $row) {
    $angkatan_data[$row->id] = $row->nama_angkatan;
}

$tahun_akademik_data[0] = '';
foreach ($tahun_akademik_options as $row) {
    $tahun_akademik_data[$row->id] = $row->tahun_ajar_mulai.'-'.$row->tahun_ajar_akhir;
}

$semester_data[0] = '';
foreach ($semester_options as $row) {
    $semester_data[$row->id] = $row->nama_semester;
}

//$mata_kuliah_data[0] = '';
//foreach ($mata_kuliah_options as $row) {
//    $mata_kuliah_data[$row->id] = $row->nama_mata_kuliah;
//}

$program_studi_data[0] = '';
foreach ($program_studi_options as $row) {
    $program_studi_data[$row->id] = $row->nama_program_studi;
}

$plot_mata_kuliah_data[0] = '';
foreach ($plot_mata_kuliah_options as $row) {
    $plot_mata_kuliah_data[$row->id] = $row->mata_kuliah_id;
}

?>
<div class="container-full" id="rencana_mata_pelajaran">
<?= form_open($action_url, array('class' => 'form-horizontal')); ?>

    <div class="control-group">
        <?= form_label('Angkatan' .  required(), 'angkatan_id', $control_label); ?>
        <div class="controls">
        <?= form_dropdown('angkatan_id', $angkatan_data, set_value('angkatan_id', $angkatan_id), 'id="angkatan_id" class="input-medium" prevData-selected="' . set_value('angkatan_id', $angkatan_id) . '"'); ?>
            <p class="help-block"><?php echo form_error('angkatan_id') ?></p>
        </div>
    </div>

    <div class="control-group">
        <?= form_label('Tahun Akademik' , 'tahun_akademik_id', $control_label); ?>
        <div class="controls">
        <?= form_dropdown('tahun_akademik_id', $tahun_akademik_data, set_value('tahun_akademik_id', $tahun_akademik_id), 'id="tahun_akademik_id" class="input-medium" prevData-selected="' . set_value('tahun_akademik_id', $tahun_akademik_id) . '"'); ?>
            <p class="help-block"><?php echo form_error('tahun_akademik_id') ?></p>
        </div>
    </div>

    <div class="control-group">
        <?= form_label('Semester' , 'semester_id', $control_label); ?>
        <div class="controls">
        <?= form_dropdown('semester_id', $semester_data, set_value('semester_id', $semester_id), 'id="semester_id" class="input-medium" prevData-selected="' . set_value('semester_id', $semester_id) . '"'); ?>
            <p class="help-block"><?php echo form_error('semester_id') ?></p>
        </div>
    </div>
    
    <div class="control-group">
        <?= form_label('Program Studi' , 'program_studi_id', $control_label); ?>
        <div class="controls">
        <?= form_dropdown('program_studi_id', $program_studi_data, set_value('program_studi_id', $program_studi_id), 'id="program_studi_id" class="input-medium" prevData-selected="' . set_value('program_studi_id', $program_studi_id) . '"'); ?>
            <p class="help-block"><?php echo form_error('program_studi_id') ?></p>
        </div>
    </div>
    
    <div class="pagination pagination-centered">
        <div id='page_navigation' class="pagination"></div>
    </div>
    <table class="table table-bordered table-striped container-full"  id="rencana_mata_pelajaran" controller="transaction">
        <thead>
            <tr>
                <th width="20">No</th>
                <th>Nim</th>
                <th>Nama</th>
                <th width="30" style="text-align: center;"> 
                    <input type="checkbox" id="1" class="ck" style="cursor: pointer" onclick="cek_all('.ck')">
                </th>
            </tr>
        </thead>
        <tbody id="content">
            <?php
                $no = 1;
                foreach ($mahasiswa_options as $row) {
                echo '<tr id="' . $row->id . '">
                        <td style="text-align: center">' . $no . '</td>    
                        <td>' . $row->nim . '</td>    
                        <td>' . $row->nama . '</td>';
            ?>
                        <td style="text-align: center">
                            <input type="checkbox" name="mata_kuliah_id" id="cek" value="<?php echo $row->id ?>" >   
                        </td>
            <?php    
                 echo'</tr>
                ';
                $no++;                    
                }
                
            ?>
        </tbody>
    </table>
    
    
    <div class="form-actions well">
        <button class="btn btn-small btn-primary" type="submit">Simpan</button>
    </div>
<?php form_close() ?>
</div>
    <?php $this->load->view('_shared/footer'); ?>

<script type="text/javascript">
//    var pager = new Pager('rencana', 9); 
//    pager.init(); 
//    pager.showPageNav('pager', 'pageNavPosition'); 
//  
   
</script>
