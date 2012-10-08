<?php
$this->load->view('_shared/header');
$this->load->view('_shared/menus');

//label
$control_label = array(
    'class' => 'control-label'
);

$pelaksana_pemutahiran_attr = array(
    'name' => 'pelaksana_pemutahiran',
    'class' => 'input-small',
    'value' => set_value('pelaksana_pemutahiran', $pelaksana_pemutahiran),
    'autocomplete' => 'off'
);

?>
<div class="container-full" id="pelaksana_pemutakhiran">
    <?= form_open($action_url, array('class' => 'form-horizontal')); ?>

    <div class="control-group">
        <?= form_label('Pelaksana Pemutakhiran' . required(), 'pelaksana_pemutahiran', $control_label); ?>
        <div class="controls">
            <?= form_input($pelaksana_pemutahiran_attr) ?>
            <p class="help-block"><?php echo form_error('pelaksana_pemutahiran') ?></p>
        </div>
    </div>

    <div class="form-actions well">
        <button class="btn btn-small btn-primary" type="submit">Simpan</button>
    </div>
    <?php form_close() ?>
</div>
<?php $this->load->view('_shared/footer'); ?>