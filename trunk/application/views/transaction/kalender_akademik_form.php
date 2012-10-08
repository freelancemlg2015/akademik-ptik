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

$tahun_attr = array(
    'id'    => 'tahun',
    'name'  => 'tahun_',
    'class' => 'input-medium',
    'value' => set_value('tahun', @$tahun),
    'autocomplete' => 'off'
);

$attributes = array('class' => 'tahun_akademik_id', 'id' => 'myform');

$tgl_kalender_mulai_attr = array(
    'name' => 'tgl_kalender_mulai',
    'class' => 'input-small',
    'value' => set_value('tgl_kalender_mulai', $tgl_kalender_mulai),
    'autocomplete' => 'off'    
);

$tgl_kalender_akhir_attr = array(
    'name' => 'tgl_kalender_akhir',
    'class' => 'input-small',
    'value' => set_value('tgl_kalender_akhir', $tgl_kalender_akhir),
    'autocomplete' => 'off'    
);

$tgl_mulai_kegiatan_attr = array(
    'name' => 'tgl_mulai_kegiatan',
    'class' => 'input-small',
    'value' => set_value('tgl_mulai_kegiatan', $tgl_mulai_kegiatan),
    'autocomplete' => 'off'    
);

$tgl_akhir_kegiatan_attr = array(
    'name' => 'tgl_akhir_kegiatan',
    'class' => 'input-small',
    'value' => set_value('tgl_akhir_kegiatan', $tgl_akhir_kegiatan),
    'autocomplete' => 'off'    
);

$nama_kegiatan_attr = array(
    'name' => 'nama_kegiatan',
    'class' => 'input-medium',
    'value' => set_value('nama_kegiatan', $nama_kegiatan),
    'autocomplete' => 'off'    
);

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
<div class="container-full" id="kalender_akademik">
<?= form_open($action_url, array('class' => 'form-horizontal')); ?>

    <div class="control-group">
        <?= form_label('Angkatan' , 'nama_angkatan', $control_label); ?>
        <div class="controls">
        <?= form_input($nama_angkatan_attr) ?> <?= form_hidden('angkatan_id', '') ?> 
            <p class="help-block"><?php echo form_error('nama_angkatan') ?></p>
        </div>
    </div>

    <div class="control-group">
        <?= form_label('Tahun Akademik' , 'tahun', $control_label); ?>
        <div class="controls">
        <?= form_input($tahun_attr) ?> <?= form_hidden('tahun_akademik_id', '') ?> 
            <p class="help-block"><?php echo form_error('tahun') ?></p>
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
        <?= form_label('Tanggal Kalender Mulai' . required(), 'tgl_kalender_mulai', $control_label); ?>
        <div class="controls">
        <?= form_input($tgl_kalender_mulai_attr) ?>
            <p class="help-block"><?php echo form_error('tgl_kalender_mulai') ?></p>
        </div>
    </div>
    
    <div class="control-group">
        <?= form_label('Tanggal Kalender Akhir' . required(), 'tgl_kalender_akhir', $control_label); ?>
        <div class="controls">
        <?= form_input($tgl_kalender_akhir_attr) ?>
            <p class="help-block"><?php echo form_error('tgl_kalender_akhir') ?></p>
        </div>
    </div>
    
    <div class="control-group">
        <?= form_label('Tanggal Mulai Kegiatan' . required(), 'tgl_mulai_kegiatan', $control_label); ?>
        <div class="controls">
        <?= form_input($tgl_mulai_kegiatan_attr) ?>
            <p class="help-block"><?php echo form_error('tgl_mulai_kegiatan') ?></p>
        </div>
    </div>
    
    <div class="control-group">
        <?= form_label('Tanggal Akhir Kegiatan' . required(), 'tgl_akhir_kegiatan', $control_label); ?>
        <div class="controls">
        <?= form_input($tgl_akhir_kegiatan_attr) ?>
            <p class="help-block"><?php echo form_error('tgl_akhir_kegiatan') ?></p>
        </div>
    </div>
    
    <div class="control-group">
        <?= form_label('Kegiatan' . required(), 'nama_kegiatan', $control_label); ?>
        <div class="controls">
        <?= form_input($nama_kegiatan_attr) ?>
            <p class="help-block"><?php echo form_error('nama_kegiatan') ?></p>
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