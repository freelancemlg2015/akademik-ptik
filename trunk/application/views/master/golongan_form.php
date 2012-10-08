<?php
$this->load->view('_shared/header');
$this->load->view('_shared/menus');

//label
$control_label = array(
    'class' => 'control-label'
);

$kode_golongan_attr = array(
    'name' => 'kode_golongan',
    'class' => 'input-small',
    'value' => set_value('kode_golongan', $kode_golongan),
    'autocomplete' => 'off'
);

$golongan_attr = array(
    'name' => 'golongan',
    'class' => 'input-medium',
    'value' => set_value('golongan', $golongan),
    'autocomplete' => 'off'
);
?>
<div class="container-full" id="golongan">
    <?= form_open($action_url, array('class' => 'form-horizontal')); ?>

    <div class="control-group">
        <?= form_label('Kode Golongan' . required(), 'kode_golongan', $control_label); ?>
        <div class="controls">
            <?= form_input($kode_golongan_attr) ?>
            <p class="help-block"><?php echo form_error('kode_golongan') ?></p>
        </div>
    </div>

    <div class="control-group">
        <?= form_label('Golongan' . required(), 'golongan', $control_label); ?>
        <div class="controls">
            <?= form_input($golongan_attr) ?>
            <p class="help-block"><?php echo form_error('golongan') ?></p>
        </div>
    </div>


    <div class="form-actions well">
        <button class="btn btn-small btn-primary" type="submit">Simpan</button>
    </div>
    <?php form_close() ?>
</div>
<?php $this->load->view('_shared/footer'); ?>