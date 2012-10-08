<?php
$this->load->view('_shared/header');
$this->load->view('_shared/menus');

//label
$control_label = array(
    'class' => 'control-label'
);

$nama_angkatan_attr = array(
    'id'    => 'nama_angkatan',
    'name'  => 'nama_angkatan',
    'class' => 'input-medium',
    'value' => set_value('nama_angkatan', $nama_angkatan),
    'autocomplete' => 'off'
);

$attributes = array('class' => 'angkatan_id', 'id' => 'myform');

$tahun_ajar_attr = array(
    'id'    => 'tahun_ajar',
    'name'  => 'tahun_ajar',
    'class' => 'input-medium',
    'value' => set_value('tahun_ajar', $tahun_ajar),
    'autocomplete' => 'off',
);

$attributes = array('class' => 'tahun_akademik_id', 'id' => 'myform');

$nama_paket_attr = array(
    'name'  => 'nama_paket',
    'class' => 'input-medium',
    'value' => set_value('nama_paket', $nama_paket),
    'autocomplete' => 'off'    
);

$nama_mata_kuliah_attr = array(
    'id'    => 'nama_mata_kuliah',
    'name'  => 'nama_mata_kuliah',
    'class' => 'input-medium',
    'value' => set_value('nama_mata_kuliah', $nama_mata_kuliah),
    'autocomplete' => 'off'    
);

$attributes = array('class' => 'mata_kuliah_id', 'id' => 'myform');

$keterangan_attr = array(
    'name' => 'keterangan',
    'class' => 'span3',
    'value' => set_value('keterangan', $keterangan),
    'autocomplete' => 'off'    
);

$semester_data[0] = '-PILIH-';
foreach ($semester_options as $row) {
    $semester_data[$row->id] = $row->nama_semester;
}

?>
<div class="container-full" id="paket_matakuliah">
<?= form_open($action_url, array('class' => 'form-horizontal')); ?>

    <div class="control-group">
        <?= form_label('Angkatan' , 'nama_angkatan', $control_label); ?>
        <div class="controls">
        <?= form_input($nama_angkatan_attr) ?> <?= form_hidden('angkatan_id', '') ?> 
            <p class="help-block"><?php echo form_error('nama_angkatan') ?></p>
        </div>
    </div>

    <div class="control-group">
        <?= form_label('Tahun Akademik' , 'tahun_ajar', $control_label); ?>
        <div class="controls">
        <?= form_input($tahun_ajar_attr) ?> <?= form_hidden('tahun_akademik_id', '') ?> 
            <p class="help-block"><?php echo form_error('tahun_ajar') ?></p>
        </div>
    </div>

    <div class="control-group">
        <?= form_label('Semester' , 'semester_id', $control_label); ?>
        <div class="controls">
        <?= form_dropdown('semester_id', $semester_data, set_value('semester_id', $semester_id), 'id="semester_id" class="input-medium" prevData-selected="' . set_value('semester_id', $semester_id) . '"') . '&nbsp;&nbsp;'; ?>
            <p class="help-block"><?php echo form_error('semester_id') ?></p>
        </div>
    </div>
    
    <div class="control-group">
        <?= form_label('Paket' . required(), 'nama_paket', $control_label); ?>
        <div class="controls">
        <?= form_input($nama_paket_attr) ?>
            <p class="help-block"><?php echo form_error('nama_paket') ?></p>
        </div>
    </div>
    
    <div class="control-group">
        <?= form_label('Mata Kuliah' , 'nama_mata_kuliah', $control_label); ?>
        <div class="controls">
        <?= form_input($nama_mata_kuliah_attr) ?> <?= form_input('mata_kuliah_id', '') ?>
            <p class="help-block"><?php echo form_error('nama_mata_kuliah') ?></p>
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