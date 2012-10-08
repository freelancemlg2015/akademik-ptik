<?php
$this->load->view('_shared/header');
$this->load->view('_shared/menus');

//label
$control_label = array(
    'class' => 'control-label'
);

$kode_ujian_attr = array(
    'name' => 'kode_ujian',
    'class' => 'input-small',
    'value' => set_value('kode_ujian', $kode_ujian),
    'autocomplete' => 'off'
);

$jenis_ujian_attr = array(
    'name' => 'jenis_ujian',
    'class' => 'input-medium',
    'value' => set_value('jenis_ujian', $jenis_ujian),
    'autocomplete' => 'off'
);
?>
<div class="container-full" id="jenis_ujian">
    <?= form_open($action_url, array('class' => 'form-horizontal')); ?>

    <div class="control-group">
        <?= form_label('Kode Ujian' . required(), 'kode_ujian', $control_label); ?>
        <div class="controls">
            <?= form_input($kode_ujian_attr) ?>
            <p class="help-block"><?php echo form_error('kode_ujian') ?></p>
        </div>
    </div>

    <div class="control-group">
        <?= form_label('Jenis Ujian' . required(), 'jenis_ujian', $control_label); ?>
        <div class="controls">
            <?= form_input($jenis_ujian_attr) ?>
            <p class="help-block"><?php echo form_error('jenis_ujian') ?></p>
        </div>
    </div>


    <div class="form-actions well">
        <button class="btn btn-small btn-primary" type="submit">Simpan</button>
    </div>
    <?php form_close() ?>
</div>
<?php $this->load->view('_shared/footer'); ?>