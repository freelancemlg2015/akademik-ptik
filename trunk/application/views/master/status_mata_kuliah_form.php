<?php
$this->load->view('_shared/header');
$this->load->view('_shared/menus');

//label
$control_label = array(
    'class' => 'control-label'
);

$status_mata_kuliah_attr = array(
    'name' => 'status_mata_kuliah',
    'class' => 'input-small',
    'value' => set_value('status_mata_kuliah', $status_mata_kuliah),
    'autocomplete' => 'off'
);

?>
<div class="container-full" id="status_mata_kuliah">
    <?= form_open($action_url, array('class' => 'form-horizontal')); ?>

    <div class="control-group">
        <?= form_label('Status Mata Kuliah' . required(), 'status_mata_kuliah', $control_label); ?>
        <div class="controls">
            <?= form_input($status_mata_kuliah_attr) ?>
            <p class="help-block"><?php echo form_error('status_mata_kuliah') ?></p>
        </div>
    </div>


    <div class="form-actions well">
        <button class="btn btn-small btn-primary" type="submit">Simpan</button>
    </div>
    <?php form_close() ?>
</div>
<?php $this->load->view('_shared/footer'); ?>