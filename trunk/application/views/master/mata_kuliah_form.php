<?php
$this->load->view('_shared/header');
$this->load->view('_shared/menus');

//label
$control_label = array(
    'class' => 'control-label'
);

$kode_mata_kuliah_attr = array(
    'name' => 'kode_mata_kuliah',
    'class' => 'input-small',
    'value' => set_value('kode_mata_kuliah', $kode_mata_kuliah),
    'autocomplete' => 'off'
);

$nama_mata_kuliah_attr = array(
    'name' => 'nama_mata_kuliah',
    'class' => 'input-medium',
    'value' => set_value('nama_mata_kuliah', $nama_mata_kuliah),
    'autocomplete' => 'off'
);

$sks_mata_kuliah_attr = array(
    'name' => 'sks_mata_kuliah',
    'class' => 'input-mini',
    'value' => set_value('sks_mata_kuliah', $sks_mata_kuliah),
    'autocomplete' => 'off'
);

$sks_tatap_muka_attr = array(
    'name' => 'sks_tatap_muka',
    'class' => 'input-mini',
    'value' => set_value('sks_tatap_muka', $sks_tatap_muka),
    'autocomplete' => 'off'
);

$sks_praktikum_attr = array(
    'name' => 'sks_praktikum',
    'class' => 'input-mini',
    'value' => set_value('sks_praktikum', $sks_praktikum),
    'autocomplete' => 'off'
);

$nama_laboratorium_attr = array(
    'name' => 'nama_laboratorium',
    'class' => 'input-medium',
    'value' => set_value('nama_laboratorium', $nama_laboratorium),
    'autocomplete' => 'off'
);

$sks_praktek_lapangan_attr = array(
    'name' => 'sks_praktek_lapangan',
    'class' => 'input-mini',
    'value' => set_value('sks_praktek_lapangan', $sks_praktek_lapangan),
    'autocomplete' => 'off'
);

$semester_attr = array(
    'name' => 'semester',
    'class' => 'input-medium',
    'value' => set_value('semester', $semester),
    'autocomplete' => 'off'
);

$jenis_kurikulum_attr = array(
    'name' => 'jenis_kurikulum',
    'class' => 'input-small',
    'value' => set_value('jenis_kurikulum', $jenis_kurikulum),
    'autocomplete' => 'off'
);

$jenis_mata_kuliah_attr = array(
    'name' => 'jenis_mata_kuliah',
    'class' => 'input-medium',
    'value' => set_value('jenis_mata_kuliah', $jenis_mata_kuliah),
    'autocomplete' => 'off'
);

$jenjang_program_studi_pengampu_attr = array(
    'name' => 'jenjang_program_studi_pengampu',
    'class' => 'input-small',
    'value' => set_value('jenjang_program_studi_pengampu', $jenjang_program_studi_pengampu),
    'autocomplete' => 'off'
);

$program_studi_pengampu_attr = array(
    'name' => 'program_studi_pengampu',
    'class' => 'input-small',
    'value' => set_value('program_studi_pengampu', $program_studi_pengampu),
    'autocomplete' => 'off'
);

$mata_kuliah_syarat_tempuh_attr = array(
    'name' => 'mata_kuliah_syarat_tempuh',
    'class' => 'input-medium',
    'value' => set_value('mata_kuliah_syarat_tempuh', $mata_kuliah_syarat_tempuh),
    'autocomplete' => 'off'
);

$mata_kuliah_syarat_lulus_attr = array(
    'name' => 'mata_kuliah_syarat_lulus',
    'class' => 'input-medium',
    'value' => set_value('mata_kuliah_syarat_lulus', $mata_kuliah_syarat_lulus),
    'autocomplete' => 'off'
);

$silabus_attr = array(
    'name' => 'silabus',
    'class' => 'input-medium',
    'value' => set_value('silabus', $silabus),
    'autocomplete' => 'off'
);

$status_matakuliah_data[0] = '';
foreach ($status_matakuliah_options as $row) {
    $status_matakuliah_data[$row->id] = $row->status_mata_kuliah;
}
?>
<div class="container-full" id="angkatan">
    <?= form_open($action_url, array('class' => 'form-horizontal')); ?>
    
    <div class="control-group">
        <?= form_label('Kode Mata Kuliah' . required(), 'kode_mata_kuliah', $control_label); ?>
        <div class="controls">
            <?= form_input($kode_mata_kuliah_attr) ?>
            <p class="help-block"><?php echo form_error('kode_mata_kuliah') ?></p>
        </div>
    </div>

    <div class="control-group">
        <?= form_label('Nama Mata Kuliah' . required(), 'nama_mata_kuliah', $control_label); ?>
        <div class="controls">
            <?= form_input($nama_mata_kuliah_attr) ?>
            <p class="help-block"><?php echo form_error('nama_mata_kuliah') ?></p>
        </div>
    </div>

    <div class="control-group">
        <?= form_label('SKS Mata Kuliah', 'sks_mata_kuliah', $control_label); ?>
        <div class="controls">
            <?= form_input($sks_mata_kuliah_attr) ?>
            <p class="help-block"><?php echo form_error('sks_mata_kuliah') ?></p>
        </div>
    </div>
    
    <div class="control-group">
        <?= form_label('Status MataKuliah', 'status_mata_kuliah_id', $control_label); ?>
        <div class="controls">
            <?= form_dropdown('status_mata_kuliah_id', $status_matakuliah_data, set_value('status_mata_kuliah_id', @$status_mata_kuliah_id), 'id="status_mata_kuliah_id" class="input-medium" prevData-selected="' . set_value('status_mata_kuliah_id', @$status_mata_kuliah_id) . '"') . '&nbsp;&nbsp;'; ?>
            <p class="help-block"><?php echo form_error('status_mata_kuliah_id') ?></p>
        </div>
    </div>
    
    <div class="control-group">
        <?= form_label('Silabus', 'silabus', $control_label); ?>
        <div class="controls">
            <?= form_input($silabus_attr) ?>
            <p class="help-block"><?php echo form_error('silabus') ?></p>
        </div>
    </div>

    <div class="form-actions well">
        <button class="btn btn-small btn-primary" type="submit">Simpan</button>
    </div>
    <?php form_close() ?>
</div>
<?php $this->load->view('_shared/footer'); ?>