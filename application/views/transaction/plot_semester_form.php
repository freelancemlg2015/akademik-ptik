<?php
$this->load->view('_shared/header');
$this->load->view('_shared/menus');

//label
$control_label = array(
    'class' => 'control-label'
);


$tempat_lahir_attr = array(
    'name' => 'tempat_lahir',
    'class' => 'input-medium',
    'value' => set_value('tempat_lahir', $tempat_lahir),
    'autocomplete' => 'off'
);

$tgl_lahir_attr = array(
    'name' => 'tgl_lahir',
    'class' => 'input-small',
    'value' => set_value('tgl_lahir', $tgl_lahir),
    'autocomplete' => 'off'
);

$tgl_mulai_attr = array(
    'name' => 'tgl_mulai',
    'class' => 'input-small',
    'value' => set_value('tgl_mulai', $tgl_mulai),
    'autocomplete' => 'off'
);

$tgl_akhir_attr = array(
    'name' => 'tgl_akhir',
    'class' => 'input-small',
    'value' => set_value('tgl_akhir', $tgl_akhir),
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

?>
<div class="container-full" id="plot_semester">
    <?= form_open_multipart($action_url, array('class' => 'form-horizontal')); ?>

    <div class="control-group">
        <?= form_label('Angkatan' . required(), 'angkatan_id', $control_label); ?>
        <div class="controls">
            <?= form_dropdown('angkatan_id', $angkatan_data, set_value('angkatan_id', $angkatan_id), 'id="angkatan_id" class="input-medium" prevData-selected="' . set_value('angkatan_id', $angkatan_id) . '"'); ?>
            <p class="help-block"><?php echo form_error('angkatan_id') ?></p>
        </div>
    </div>
    
    <div class="control-group">
        <?= form_label('Tahun Akademik' , 'tahun_akademik_id', $control_label); ?>
        <div class="controls">
             <?= form_dropdown('tahun_akademik_id', $tahun_akademik_data, set_value('tahun_akademik_id', @$tahun_akademik_id), 'id="tahun_akademik_id" class="input-medium" prevData-selected="' . set_value('tahun_akademik_id', @$tahun_akademik_id) . '"'); ?>
            <p class="help-block"><?php echo form_error('tahun_ajar') ?></p>
        </div>
    </div>
    
    <div class="control-group">
        <?= form_label('Semester' , 'semester_id', $control_label); ?>
        <div class="controls">
            <?= form_dropdown('semester_id', $semester_data, set_value('semester_id', @$semester_id), 'id="semester_id" class="input-medium" prevData-selected="' . set_value('semester_id', @$semester_id) . '"'); ?>
            <p class="help-block"><?php echo form_error('semester_id') ?></p>
        </div>
    </div>
    
    <div class="control-group">
        <?= form_label('Tanggal Mulai', 'tgl_mulai', $control_label); ?>
        <div class="controls">
            <?= form_input($tgl_mulai_attr) ?>
            <p class="help-block"><?php echo form_error('tgl_mulai') ?></p>
        </div>
    </div>
    
   
    <div class="control-group">
        <?= form_label('Tanggal Akhir', 'tgl_akhir', $control_label); ?>
        <div class="controls">
            <?= form_input($tgl_akhir_attr) ?>
            <p class="help-block"><?php echo form_error('tgl_akhir') ?></p>
        </div>
    </div>
    
    <div class="form-actions well">
        <button class="btn btn-small btn-primary" type="submit">Simpan</button>
    </div>
    <?php form_close() ?>
</div>
<?php $this->load->view('_shared/footer'); ?>
