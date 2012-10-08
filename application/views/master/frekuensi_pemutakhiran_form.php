<?php
$this->load->view('_shared/header');
$this->load->view('_shared/menus');

//label
$control_label = array(
    'class' => 'control-label'
);

$frekuensi_pemutahiran_kurikulum_attr = array(
    'name' => 'frekuensi_pemutahiran_kurikulum',
    'class' => 'input-small',
    'value' => set_value('frekuensi_pemutahiran_kurikulum', $frekuensi_pemutahiran_kurikulum),
    'autocomplete' => 'off'
);

?>
<div class="container-full" id="frekuensi_pemutakhiran">
    <?= form_open($action_url, array('class' => 'form-horizontal')); ?>

    <div class="control-group">
        <?= form_label('Frekuensi Pemutakhiran Kurikulum' . required(), 'frekuensi_pemutahiran_kurikulum', $control_label); ?>
        <div class="controls">
            <?= form_input($frekuensi_pemutahiran_kurikulum_attr) ?>
            <p class="help-block"><?php echo form_error('frekuensi_pemutahiran_kurikulum') ?></p>
        </div>
    </div>

    <div class="form-actions well">
        <button class="btn btn-small btn-primary" type="submit">Simpan</button>
    </div>
    <?php form_close() ?>
</div>
<?php $this->load->view('_shared/footer'); ?>