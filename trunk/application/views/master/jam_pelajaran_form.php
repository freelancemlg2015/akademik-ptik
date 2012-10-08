<?php
$this->load->view('_shared/header');
$this->load->view('_shared/menus');

//label
$control_label = array(
    'class' => 'control-label'
);

$kode_jam_attr = array(
    'name' => 'kode_jam',
    'class' => 'input-small',
    'value' => set_value('kode_jam', $kode_jam),
    'autocomplete' => 'off'
);

$jam_normal_attr = array(
    'name' => 'jam_normal',
    'class' => 'input-mini',
    'value' => set_value('jam_normal', $jam_normal),
    'autocomplete' => 'off'
);

$jam_puasa_attr = array(
    'name' => 'jam_puasa',
    'class' => 'input-mini',
    'value' => set_value('jam_puasa', $jam_puasa),
    'autocomplete' => 'off'
);
?>
<div class="container-full" id="jam_pelajaran">
    <?= form_open($action_url, array('class' => 'form-horizontal')); ?>

    <div class="control-group">
        <?= form_label('Kode Jam' . required(), 'kode_jam', $control_label); ?>
        <div class="controls">
            <?= form_input($kode_jam_attr) ?>
            <p class="help-block"><?php echo form_error('kode_jam') ?></p>
        </div>
    </div>

    <div class="control-group">
        <?= form_label('Jam Normal' . required(), 'jam_normal', $control_label); ?>
        <div class="controls">
            <?= form_input($jam_normal_attr) ?>
            <p class="help-block"><?php echo form_error('jam_normal') ?></p>
        </div>
    </div>

    <div class="control-group">
        <?= form_label('Jam Puasa' . required(), 'jam_puasa', $control_label); ?>
        <div class="controls">
            <?= form_input($jam_puasa_attr) ?>
            <p class="help-block"><?php echo form_error('jam_puasa') ?></p>
        </div>
    </div>


    <div class="form-actions well">
        <button class="btn btn-small btn-primary" type="submit">Simpan</button>
    </div>
    <?php form_close() ?>
</div>
<?php $this->load->view('_shared/footer'); ?>