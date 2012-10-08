<?php
$this->load->view('_shared/header');
$this->load->view('_shared/menus');

//label
$control_label = array(
    'class' => 'control-label'
);

$semester_mulai_aktivitas_attr = array(
    'name' => 'semester_mulai_aktivitas',
    'class' => 'input-small',
    'value' => set_value('semester_mulai_aktivitas', $semester_mulai_aktivitas),
    'autocomplete' => 'off'
);

?>
<div class="container-full" id="semester_mulai_aktivitas">
    <?= form_open($action_url, array('class' => 'form-horizontal')); ?>

    <div class="control-group">
        <?= form_label('Semester Mulai Aktivitas' . required(), 'semester_mulai_aktivitas', $control_label); ?>
        <div class="controls">
            <?= form_input($semester_mulai_aktivitas_attr) ?>
            <p class="help-block"><?php echo form_error('semester_mulai_aktivitas') ?></p>
        </div>
    </div>
    
    <div class="form-actions well">
        <button class="btn btn-small btn-primary" type="submit">Simpan</button>
    </div>
    <?php form_close() ?>
</div>
<?php $this->load->view('_shared/footer'); ?>