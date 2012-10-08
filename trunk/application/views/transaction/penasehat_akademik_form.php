<?php
$this->load->view('_shared/header');
$this->load->view('_shared/menus');

//label
$control_label = array(
    'class' => 'control-label'
);

$kode_angkatan_attr = array(
    'name' => 'kode_angkatan',
    'class' => 'input-small',
    'value' => set_value('kode_angkatan', $kode_angkatan),
    'autocomplete' => 'off'
);

$jenjang_studi_attr = array(
    'name' => 'jenjang_studi',
    'class' => 'input-small',
    'value' => set_value('jenjang_studi', $jenjang_studi),
    'autocomplete' => 'off'
);
$program_studi_attr = array(
    'name' => 'program_studi',
    'class' => 'input-small',
    'value' => set_value('program_studi', $program_studi),
    'autocomplete' => 'off'
);

$penasehat_akademik_attr = array(
    'name' => 'penasehat_akademik',
    'class' => 'input-small',
    'value' => set_value('penasehat_akademik', $penasehat_akademik),
    'autocomplete' => 'off'
);

$keterangan_attr = array(
    'name' => 'keterangan',
    'class' => 'span3',
    'value' => set_value('keterangan', $keterangan),
    'autocomplete' => 'off',
    'style' => 'text-transform : uppercase'
);
?>
<div class="container-full" id="penasehat_akademik">
    <?= form_open($action_url, array('class' => 'form-horizontal')); ?>

    <div class="control-group">
        <?= form_label('Kode Angkatan' . required(), 'kode_angkatan', $control_label); ?>
        <div class="controls">
            <?= form_input($kode_angkatan_attr) ?>
            <p class="help-block"><?php echo form_error('kode_angkatan') ?></p>
        </div>
    </div>
 
        <div class="control-group">
            <?= form_label('Jenjang Studi' . required(), 'jenjang_studi', $control_label); ?>
            <div class="controls">
                <?= form_input($jenjang_studi_attr) ?>
                <p class="help-block"><?php echo form_error('jenjang_studi') ?></p>
            </div>
        </div>

        <div class="control-group">
            <?= form_label('Program Studi' . required(), 'program_studi', $control_label); ?>
            <div class="controls">
                <?= form_input($program_studi_attr) ?>
                <p class="help-block"><?php echo form_error('program_studi') ?></p>
            </div>
        </div>

        <div class="control-group">
            <?= form_label('Penasehat Akademik' . required(), 'penasehat_akademik', $control_label); ?>
            <div class="controls">
                <?= form_input($penasehat_akademik_attr) ?>
                <p class="help-block"><?php echo form_error('penasehat_akademik') ?></p>
            </div>
        </div>

        <div class="control-group">
            <?= form_label('Keterangan', 'keterangan', $control_label); ?>
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