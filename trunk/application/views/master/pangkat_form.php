<?php
$this->load->view('_shared/header');
$this->load->view('_shared/menus');

//label
$control_label = array(
    'class' => 'control-label'
);

$kode_pangkat_attr = array(
    'name' => 'kode_pangkat',
    'class' => 'input-small',
    'value' => set_value('kode_pangkat', $kode_pangkat),
    'autocomplete' => 'off'
);

$nama_pangkat_attr = array(
    'name' => 'nama_pangkat',
    'class' => 'input-medium',
    'value' => set_value('nama_pangkat', $nama_pangkat),
    'autocomplete' => 'off'
);
?>
<div class="container-full" id="pangkat">
    <?= form_open($action_url, array('class' => 'form-horizontal')); ?>

    <div class="control-group">
        <?= form_label('Kode Pangkat' . required(), 'kode_pangkat', $control_label); ?>
        <div class="controls">
            <?= form_input($kode_pangkat_attr) ?>
            <p class="help-block"><?php echo form_error('kode_pangkat') ?></p>
        </div>
    </div>

    <div class="control-group">
        <?= form_label('Nama Pangkat' . required(), 'nama_pangkat', $control_label); ?>
        <div class="controls">
            <?= form_input($nama_pangkat_attr) ?>
            <p class="help-block"><?php echo form_error('nama_pangkat') ?></p>
        </div>
    </div>


    <div class="form-actions well">
        <button class="btn btn-small btn-primary" type="submit">Simpan</button>
    </div>
    <?php form_close() ?>
</div>
<?php $this->load->view('_shared/footer'); ?>