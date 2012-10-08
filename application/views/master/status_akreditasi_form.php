<?php
$this->load->view('_shared/header');
$this->load->view('_shared/menus');

//label
$control_label = array(
    'class' => 'control-label'
);

$status_akreditasi_attr = array(
    'name' => 'status_akreditasi',
    'class' => 'input-small',
    'value' => set_value('status_akreditasi', $status_akreditasi),
    'autocomplete' => 'off'
);

?>
<div class="container-full" id="status_akreditasi">
    <?= form_open($action_url, array('class' => 'form-horizontal')); ?>

    <div class="control-group">
        <?= form_label('Status Akreditasi' . required(), 'status_akreditasi', $control_label); ?>
        <div class="controls">
            <?= form_input($status_akreditasi_attr) ?>
            <p class="help-block"><?php echo form_error('status_akreditasi') ?></p>
        </div>
    </div>

    <div class="form-actions well">
        <button class="btn btn-small btn-primary" type="submit">Simpan</button>
    </div>
    <?php form_close() ?>
</div>
<?php $this->load->view('_shared/footer'); ?>