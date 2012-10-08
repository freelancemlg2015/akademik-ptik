<?php
$this->load->view('_shared/header');
$this->load->view('_shared/menus');

//label
$control_label = array(
    'class' => 'control-label'
);

$status_dosen_penasehat_attr = array(
    'name' => 'status_dosen_penasehat',
    'class' => 'input-small',
    'value' => set_value('status_dosen_penasehat', $status_dosen_penasehat),
    'autocomplete' => 'off'
);

?>
<div class="container-full" id="status_dosen_penasehat">
    <?= form_open($action_url, array('class' => 'form-horizontal')); ?>

    <div class="control-group">
        <?= form_label('Status Dosen Penasehat' . required(), 'status_dosen_penasehat', $control_label); ?>
        <div class="controls">
            <?= form_input($status_dosen_penasehat_attr) ?>
            <p class="help-block"><?php echo form_error('status_dosen_penasehat') ?></p>
        </div>
    </div>


    <div class="form-actions well">
        <button class="btn btn-small btn-primary" type="submit">Simpan</button>
    </div>
    <?php form_close() ?>
</div>
<?php $this->load->view('_shared/footer'); ?>