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

$english_attr = array(
    'name' => 'english',
    'class' => 'input-medium',
    'value' => set_value('english', $english),
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

$angkatan_data[0] = '';
foreach ($angkatan_options as $row) {
    $angkatan_data[$row->id] = $row->nama_angkatan;
}

$jenjang_studi_data[0] = '';
foreach ($jenjang_studi_options as $row) {
    $jenjang_studi_data[$row->id] = $row->jenjang_studi;
}

$program_studi_data[0] = '';
foreach ($program_studi_options as $row) {
    $program_studi_data[$row->id] = $row->nama_program_studi;
}

$tahun_akademik_data[0] = '';
foreach ($tahun_akademik_options as $row) {
    $tahun_akademik_data[$row->id] = $row->tahun_ajar_mulai.'-'.$row->tahun_ajar_akhir;
}

$semester_data[0] = '';
foreach ($semester_options as $row) {
    $semester_data[$row->id] = $row->nama_semester;
}

$status_matakuliah_data[0] = '';
foreach ($status_matakuliah_options as $row) {
    $status_matakuliah_data[$row->id] = $row->nama_matakuliah;
}
?>
<div class="container-full" id="angkatan">
    <?= form_open($action_url, array('class' => 'form-horizontal')); ?>
    
    <div class="control-group">
        <?= form_label('Angkatan', 'angkatan_id', $control_label); ?>
        <div class="controls">
            <?= form_dropdown('angkatan_id', $angkatan_data, set_value('angkatan_id', $angkatan_id), 'id="angkatan_id" class="input-medium" prevData-selected="' . set_value('angkatan_id', $angkatan_id) . '"'); ?>
            <p class="help-block"><?php echo form_error('angkatan_id') ?></p>
        </div>
    </div>

    <div class="control-group">
        <?= form_label('Program Studi', 'program_studi_id', $control_label); ?>
        <div class="controls">
            <?= form_dropdown('program_studi_id', $program_studi_data, set_value('program_studi_id', $program_studi_id), 'id="program_studi_id" class="input-medium" prevData-selected="' . set_value('program_studi_id', $program_studi_id) . '"'); ?>
            <p class="help-block"><?php echo form_error('program_studi_id') ?></p>
        </div>
    </div>

    <div class="control-group">
        <?= form_label('Jenjang Studi', 'jenjang_studi_id', $control_label); ?>
        <div class="controls">
            <?= form_dropdown('jenjang_studi_id', $jenjang_studi_data, set_value('jenjang_studi_id', $jenjang_studi_id), 'id="jenjang_studi_id" class="input-medium" prevData-selected="' . set_value('jenjang_studi_id', $jenjang_studi_id) . '"'); ?>
            <p class="help-block"><?php echo form_error('jenjang_studi_id') ?></p>
        </div>
    </div>

    <div class="control-group">
        <?= form_label('Tahun Akademik', 'tahun_akademik_id', $control_label); ?>
        <div class="controls">
            <?= form_dropdown('tahun_akademik_id', $tahun_akademik_data, set_value('tahun_akademik_id', $tahun_akademik_id), 'id="tahun_akademik_id" class="input-medium" prevData-selected="' . set_value('tahun_akademik_id', @$tahun_akademik_id) . '"'); ?>
            <p class="help-block"><?php echo form_error('tahun_akademik_id') ?></p>
        </div>
    </div>

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
        <?= form_label('english', 'english', $control_label); ?>
        <div class="controls">
            <?= form_input($english_attr) ?>
            <p class="help-block"><?php echo form_error('english') ?></p>
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
        <?= form_label('SKS Tatap Muka', 'sks_tatap_muka', $control_label); ?>
        <div class="controls">
            <?= form_input($sks_tatap_muka_attr) ?>
            <p class="help-block"><?php echo form_error('sks_tatap_muka') ?></p>
        </div>
    </div>

    <div class="control-group">
        <?= form_label('SKS Praktikum', 'sks_praktikum', $control_label); ?>
        <div class="controls">
            <?= form_input($sks_praktikum_attr) ?>
            <p class="help-block"><?php echo form_error('sks_praktikum') ?></p>
        </div>
    </div>
    
    <div class="control-group">
        <?= form_label('SKS Peraktek Lapangan', 'sks_praktek_lapangan', $control_label); ?>
        <div class="controls">
            <?= form_input($sks_praktek_lapangan_attr) ?>
            <p class="help-block"><?php echo form_error('sks_praktek_lapangan') ?></p>
        </div>
    </div>

    <div class="control-group">
        <?= form_label('Nama Laboratorium', 'nama_laboratorium', $control_label); ?>
        <div class="controls">
            <?= form_input($nama_laboratorium_attr) ?>
            <p class="help-block"><?php echo form_error('nama_laboratorium') ?></p>
        </div>
    </div>

    <div class="control-group">
        <?= form_label('Semester', 'semester', $control_label); ?>
        <div class="controls">
            <?= form_dropdown('semester', $semester_data, set_value('semester', $semester), 'id="semester_id" class="input-medium" prevData-selected="' . set_value('semester', $semester) . '"'); ?>
            <p class="help-block"><?php echo form_error('semester') ?></p>
        </div>
    </div>

    <div class="control-group">
        <?= form_label('Jenis Kurikulum', 'jenis_kurikulum', $control_label); ?>
        <div class="controls">
            <?= form_input($jenis_kurikulum_attr) ?>
            <p class="help-block"><?php echo form_error('jenis_kurikulum') ?></p>
        </div>
    </div>

    <div class="control-group">
        <?= form_label('Jenis Mata Kuliah', 'jenis_mata_kuliah', $control_label); ?>
        <div class="controls">
            <?= form_input($jenis_mata_kuliah_attr) ?>
            <p class="help-block"><?php echo form_error('jenis_mata_kuliah') ?></p>
        </div>
    </div>

    <div class="control-group">
        <?= form_label('Jenjang Program Studi Pengampu', 'jenjang_program_studi_pengampu', $control_label); ?>
        <div class="controls">
            <?= form_input($jenjang_program_studi_pengampu_attr) ?>
            <p class="help-block"><?php echo form_error('jenjang_program_studi_pengampu') ?></p>
        </div>
    </div>

    <div class="control-group">
        <?= form_label('Program Studi Pengampu', 'program_studi_pengampu', $control_label); ?>
        <div class="controls">
            <?= form_input($program_studi_pengampu_attr) ?>
            <p class="help-block"><?php echo form_error('program_studi_pengampu') ?></p>
        </div>
    </div>

    <div class="control-group">
        <?= form_label('Program Studi Pengampu', 'program_studi_pengampu', $control_label); ?>
        <div class="controls">
            <?= form_input($program_studi_pengampu_attr) ?>
            <p class="help-block"><?php echo form_error('program_studi_pengampu') ?></p>
        </div>
    </div>

    <div class="control-group">
        <?= form_label('Status MataKuliah', 'status_mata_kuliah_id', $control_label); ?>
        <div class="controls">
            <?= form_dropdown('status_mata_kuliah_id', $status_matakuliah_data, set_value('status_mata_kuliah_id', $status_mata_kuliah_id), 'id="status_mata_kuliah_id" class="input-medium" prevData-selected="' . set_value('status_mata_kuliah_id', $status_mata_kuliah_id) . '"') . '&nbsp;&nbsp;'; ?>
            <p class="help-block"><?php echo form_error('status_mata_kuliah_id') ?></p>
        </div>
    </div>

    <div class="control-group">
        <?= form_label('Mata Kuliah Syarat Tempuh', 'mata_kuliah_syarat_tempuh', $control_label); ?>
        <div class="controls">
            <?= form_input($mata_kuliah_syarat_tempuh_attr) ?>
            <p class="help-block"><?php echo form_error('mata_kuliah_syarat_tempuh') ?></p>
        </div>
    </div>

    <div class="control-group">
        <?= form_label('Mata Kuliah Syarat Lulus', 'mata_kuliah_syarat_lulus', $control_label); ?>
        <div class="controls">
            <?= form_input($mata_kuliah_syarat_lulus_attr) ?>
            <p class="help-block"><?php echo form_error('mata_kuliah_syarat_lulus') ?></p>
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