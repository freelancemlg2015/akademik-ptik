<?php
$this->load->view('_shared/header');
$this->load->view('_shared/menus');

//label
$control_label = array(
    'class' => 'control-label'
);

$kode_angkatan_attr = array(
    'name' => 'kode_angkatan',
    'class' => 'input-small',
    'value' => set_value('kode_angkatan', $kode_angkatan),
    'autocomplete' => 'off'
);

$nama_angkatan_attr = array(
    'name' => 'nama_angkatan',
    'class' => 'input-medium',
    'value' => set_value('nama_angkatan', $nama_angkatan),
    'autocomplete' => 'off'
);
?>
<div class="container-full" id="angkatan">
    <?= form_open($action_url, array('class' => 'form-horizontal')); ?>

    <div class="control-group">
        <?= form_label('Kode Angkatan' . required(), 'kode_angkatan', $control_label); ?>
        <div class="controls">
            <?= form_input($kode_angkatan_attr) ?>
            <p class="help-block"><?php echo form_error('kode_angkatan') ?></p>
        </div>
    </div>

    <div class="control-group">
        <?= form_label('Nama Angkatan' . required(), 'nama_angkatan', $control_label); ?>
        <div class="controls">
            <?= form_input($nama_angkatan_attr) ?>
            <p class="help-block"><?php echo form_error('nama_angkatan') ?></p>
        </div>
    </div>


    <div class="form-actions well">
        <button class="btn btn-small btn-primary" type="submit">Simpan</button>
    </div>
    <?php form_close() ?>
</div>
<?php $this->load->view('_shared/footer'); ?>