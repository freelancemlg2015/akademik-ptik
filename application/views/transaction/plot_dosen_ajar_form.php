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

$mata_kuliah_data[0] = '';
foreach ($mata_kuliah_options as $row) {
    $mata_kuliah_data[$row->id] = $row->nama_mata_kuliah;
}

$dosen_data[0] = '';
foreach ($dosen_options as $row) {
    $dosen_data[$row->id] = $row->nama_dosen;
}

$mahasiswa_data[0] = '';
foreach ($mahasiswa_options as $row) {
    $mahasiswa_data[$row->id] = $row->nama;
}

?>
<div class="container-full" id="plot_dosen_ajar">
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
        <?= form_label('Mata Kuliah' , 'mata_kuliah_id', $control_label); ?>
        <div class="controls">
            <?= form_dropdown('mata_kuliah_id', $mata_kuliah_data, set_value('mata_kuliah_id', $mata_kuliah_id), 'id="mata_kuliah_id" class="input-medium" prevData-selected="' . set_value('mata_kuliah_id', $mata_kuliah_id) . '"'); ?>
            <p class="help-block"><?php echo form_error('mata_kuliah_id') ?></p>
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
        <?= form_label('Dosen' , 'dosen_id', $control_label); ?>
        <div class="controls">
            <?= form_dropdown('dosen_id', $dosen_data, set_value('dosen_id', $dosen_id), 'id="dosen_id" class="input-medium" prevData-selected="' . set_value('dosen_id', $dosen_id) . '"'); ?>
            <p class="help-block"><?php echo form_error('dosen_id') ?></p>
        </div>
    </div>
    
    <div class="control-group">
        <?= form_label('Mahasiswa' , 'mahasiswa_id', $control_label); ?>
        <div class="controls">
            <?= form_dropdown('mahasiswa_id', $mahasiswa_data, set_value('mahasiswa_id', $mahasiswa_id), 'id="mahasiswa_id" class="input-medium" prevData-selected="' . set_value('mahasiswa_id', $mahasiswa_id) . '"'); ?>
            <p class="help-block"><?php echo form_error('mahasiswa_id') ?></p>
        </div>
    </div>
    
    <div class="control-group">
        <?= form_label('Keterangan' , 'keterangan', $control_label); ?>
        <div class="controls">
        <?= form_textarea($keterangan_attr) ?>
            <p class="help-block"><?php echo form_error('keterangan') ?></p>
        </div>
    </div>
    
    <div class="form-actions well">
        <button class="btn btn-small btn-primary" type="submit">Simpan</button>
    </div>
<?php form_close() ?>
</div>
    <?php $this->load->view('_shared/footer'); ?>