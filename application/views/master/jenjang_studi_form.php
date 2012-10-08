<?php
$this->load->view('_shared/header');
$this->load->view('_shared/menus');

//label
$control_label = array(
    'class' => 'control-label'
);

$jenjang_studi_attr = array(
    'name' => 'jenjang_studi',
    'class' => 'input-small',
    'value' => set_value('jenjang_studi', $jenjang_studi),
    'autocomplete' => 'off'
);

?>
<div class="container-full" id="jenjang_studi">
    <?= form_open($action_url, array('class' => 'form-horizontal')); ?>

    <div class="control-group">
        <?= form_label('Jenjang Studi' . required(), 'jenjang_studi', $control_label); ?>
        <div class="controls">
            <?= form_input($jenjang_studi_attr) ?>
            <p class="help-block"><?php echo form_error('jenjang_studi') ?></p>
        </div>
    </div>

  
    <div class="form-actions well">
        <button class="btn btn-small btn-primary" type="submit">Simpan</button>
    </div>
    <?php form_close() ?>
</div>
<?php $this->load->view('_shared/footer'); ?>