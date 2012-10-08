<?php
$this->load->view('_shared/header');
$this->load->view('_shared/menus');

//label
$control_label = array(
    'class' => 'control-label'
);

$jenis_ruang_attr = array(
    'name' => 'jenis_ruang',
    'class' => 'input-small',
    'value' => set_value('jenis_ruang', $jenis_ruang),
    'autocomplete' => 'off'
);
?>
<div class="container-full" id="jenis_ruang">
    <?= form_open($action_url, array('class' => 'form-horizontal')); ?>

    <div class="control-group">
        <?= form_label('Jenis Ruang' . required(), 'jenis_ruang', $control_label); ?>
        <div class="controls">
            <?= form_input($jenis_ruang_attr) ?>
            <p class="help-block"><?php echo form_error('jenis_ruang') ?></p>
        </div>
    </div>

    <div class="form-actions well">
        <button class="btn btn-small btn-primary" type="submit">Simpan</button>
    </div>
    <?php form_close() ?>
</div>
<?php $this->load->view('_shared/footer'); ?>