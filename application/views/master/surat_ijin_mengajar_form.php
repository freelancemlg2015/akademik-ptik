<?php
$this->load->view('_shared/header');
$this->load->view('_shared/menus');

//label
$control_label = array(
    'class' => 'control-label'
);

$surat_ijin_mengajar_attr = array(
    'name' => 'surat_ijin_mengajar',
    'class' => 'input-small',
    'value' => set_value('surat_ijin_mengajar', $surat_ijin_mengajar),
    'autocomplete' => 'off'
);

?>
<div class="container-full" id="surat_ijin_mengajar">
    <?= form_open($action_url, array('class' => 'form-horizontal')); ?>

    <div class="control-group">
        <?= form_label('Surat Ijin Mengajar' . required(), 'surat_ijin_mengajar', $control_label); ?>
        <div class="controls">
            <?= form_input($surat_ijin_mengajar_attr) ?>
            <p class="help-block"><?php echo form_error('surat_ijin_mengajar') ?></p>
        </div>
    </div>
    
    <div class="form-actions well">
        <button class="btn btn-small btn-primary" type="submit">Simpan</button>
    </div>
    <?php form_close() ?>
</div>
<?php $this->load->view('_shared/footer'); ?>