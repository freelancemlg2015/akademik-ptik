<?php
$this->load->view('_shared/header');
$this->load->view('_shared/menus');

//label
$control_label = array(
    'class' => 'control-label'
);

$jenis_kelamin_attr = array(
    'name' => 'jenis_kelamin',
    'class' => 'input-small',
    'value' => set_value('jenis_kelamin', $jenis_kelamin),
    'autocomplete' => 'off'
);

?>
<div class="container-full" id="jenis_kelamin">
    <?= form_open($action_url, array('class' => 'form-horizontal')); ?>

    <div class="control-group">
        <?= form_label('Jenis Kelamin' . required(), 'jenis_kelamin', $control_label); ?>
        <div class="controls">
            <?= form_input($jenis_kelamin_attr) ?>
            <p class="help-block"><?php echo form_error('jenis_kelamin') ?></p>
        </div>
    </div>

    <div class="form-actions well">
        <button class="btn btn-small btn-primary" type="submit">Simpan</button>
    </div>
    <?php form_close() ?>
</div>
<?php $this->load->view('_shared/footer'); ?>