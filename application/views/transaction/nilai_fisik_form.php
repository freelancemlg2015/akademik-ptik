<?php
$this->load->view('_shared/header');
$this->load->view('_shared/menus');

//label
$control_label = array(
    'class' => 'control-label'
);

$nim_attr = array(
    'id'    => 'nim',
    'name'  => 'nim',
    'class' => 'input-small',
    'value' => set_value('nim', $nim),
    'autocomplete' => 'off'
);

$nilai_fisik_attr = array(
    'name' => 'nilai_fisik',
    'class' => 'input-medium',
    'value' => set_value('nilai_fisik', $nilai_fisik),
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
<div class="container-full" id="nilai_fisik">
<?= form_open($action_url, array('class' => 'form-horizontal')); ?>

    <div class="control-group">
<?= form_label('Nim' . required(), 'nim', $control_label); ?>
        <div class="controls">
        <?= form_input($nim_attr) ?>
            <p class="help-block"><?php echo form_error('nim') ?></p>
        </div>
    </div>

    <div class="control-group">
<?= form_label('Nilai Fisik' . required(), 'nilai_fisik', $control_label); ?>
        <div class="controls">
        <?= form_input($nilai_fisik_attr) ?>
            <p class="help-block"><?php echo form_error('nilai_fisik') ?></p>
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