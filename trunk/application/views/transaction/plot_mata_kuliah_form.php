<?php
$this->load->view('_shared/header');
$this->load->view('_shared/menus');

//label
$control_label = array(
    'class' => 'control-label'
);

//$nama_angkatan_attr = array(
//    'id'    => 'nama_angkatan',
//    'name'  => 'nama_angkatan',
//    'class' => 'input-medium',
//    'value' => set_value('nama_angkatan', $nama_angkatan),
//    'autocomplete' => 'off'
//);
//
//$attributes = array('class' => 'angkatan_id', 'id' => 'myform');
//
//$tahun_ajar_attr = array(
//    'id'    => 'tahun_ajar',
//    'name'  => 'tahun_ajar',
//    'class' => 'input-medium',
//    'value' => set_value('tahun_ajar', $tahun_ajar),
//    'autocomplete' => 'off',
//);
//
//$attributes = array('class' => 'tahun_akademik_id', 'id' => 'myform');
//
//$nama_mata_kuliah_attr = array(
//    'name' => 'nama_mata_kuliah',
//    'class' => 'input-medium',
//    'value' => set_value('nama_mata_kuliah', $nama_mata_kuliah),
//    'autocomplete' => 'off'    
//);
//
//$attributes = array('class' => 'mata_kuliah_id', 'id' => 'myform');
//
//$nama_dosen_attr = array(
//    'name' => 'nama_dosen',
//    'class' => 'input-medium',
//    'value' => set_value('nama_dosen', $nama_dosen),
//    'autocomplete' => 'off'    
//);
//
//$attributes = array('class' => 'dosen_id', 'id' => 'myform');
//
//$nama_mahasiswa_attr = array(
//    'name' => 'nama',
//    'class' => 'input-medium',
//    'value' => set_value('nama', $nama_mahasiswa),
//    'autocomplete' => 'off'    
//);
//
//$attributes = array('class' => 'mahasiswa_id', 'id' => 'myform');

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

$kelompok_matakuliah_data[0] = '';
foreach ($kelompok_matakuliah_options as $row) {
    $kelompok_matakuliah_data[$row->id] = $row->nama_kelompok_mata_kuliah;
}


?>
<div class="container-full" id="plot_mata_kuliah">
<?= form_open($action_url, array('class' => 'form-horizontal')); ?>

    <div class="control-group">
        <?= form_label('Angkatan' , 'angkatan_id', $control_label); ?>
        <div class="controls">
            <?= form_dropdown('angkatan_id', $angkatan_data, set_value('angkatan_id', $angkatan_id), 'id="angkatan_id" class="input-medium" prevData-selected="' . set_value('angkatan_id', $angkatan_id) . '"'); ?>
            <p class="help-block"><?php echo form_error('angkatan_id') ?></p>
        </div>
    </div>

    <div class="control-group">
        <?= form_label('Tahun Akademik' , 'tahun_akademik_id', $control_label); ?>
        <div class="controls">
             <?= form_dropdown('tahun_akademik_id', $tahun_akademik_data, set_value('tahun_akademik_id', $tahun_akademik_id), 'id="tahun_akademik_id" class="input-medium" prevData-selected="' . set_value('tahun_akademik_id', $tahun_akademik_id) . '"'); ?>
            <p class="help-block"><?php echo form_error('tahun_ajar') ?></p>
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
        <?= form_label('Kelompok Matakuliah' , 'kelompok_mata_kuliah_id', $control_label); ?>
        <div class="controls">
            <?= form_dropdown('kelompok_mata_kuliah_id', $kelompok_matakuliah_data, set_value('kelompok_mata_kuliah_id', $kelompok_mata_kuliah_id), 'id="kelompok_mata_kuliah_id" class="input-medium" prevData-selected="' . set_value('kelompok_mata_kuliah_id', $kelompok_mata_kuliah_id) . '"'); ?>
            <p class="help-block"><?php echo form_error('kelompok_matakuliah_id') ?></p>
        </div>
    </div>
        
<!--    <div class="control-group">
        <?//= form_label('Mata Kuliah' , 'mata_kuliah_id', $control_label); ?>
        <div class="controls">
            <?//= form_dropdown('mata_kuliah_id', $mata_kuliah_data, set_value('mata_kuliah_id', $mata_kuliah_id), 'id="mata_kuliah_id" class="input-medium" prevData-selected="' . set_value('mata_kuliah_id', $mata_kuliah_id) . '"'); ?>
            <p class="help-block"><?php //echo form_error('mata_kuliah_id') ?></p>
        </div>
    </div>
    
    <div class="control-group">
        <?//= form_label('Keterangan' , 'keterangan', $control_label); ?>
        <div class="controls">
        <?//= form_textarea($keterangan_attr) ?>
            <p class="help-block"><?php //echo form_error('keterangan') ?></p>
        </div>
    </div>-->

    <table class="table table-bordered table-striped container-full"  id="plot_mata_kuliah" controller="transaction">
        <thead>
            <tr>
                <th width="20">No</th>
                <th>Kode Mata Kuliah</th>
                <th>Nama Mata Kuliah</th>
                <th width="30" style="text-align: center;"> 
                    <input type="checkbox" id="1" class="ck" style="cursor: pointer" onclick="cek_all('.ck')">
                </th>
            </tr>
        </thead>
        <tbody>
            <?php
                $no = 1;
                foreach ($mata_kuliah_options as $row) {
                echo '<tr id="' . $row->id . '">
                        <td style="text-align: center">' . $no . '</td>    
                        <td>' . $row->kode_mata_kuliah . '</td>    
                        <td>' . $row->nama_mata_kuliah . '</td>';
            ?>
                        <td style="text-align: center">
                            <input type="checkbox" name="mata_kuliah_id[]" id="cek" value="<?php echo $row->id ?>" >   
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