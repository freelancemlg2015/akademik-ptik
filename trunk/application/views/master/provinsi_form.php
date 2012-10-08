<?php
$this->load->view('_shared/header');
$this->load->view('_shared/menus');

//label
$control_label = array(
    'class' => 'control-label'
);

$nama_provinsi_attr = array(
    'name' => 'nama_provinsi',
    'class' => 'input-medium',
    'value' => set_value('nama_provinsi', $nama_provinsi),
    'autocomplete' => 'off'
);
?>
<div class="container-full" id="provinsi">
    <?= form_open($action_url, array('class' => 'form-horizontal')); ?>

    <div class="control-group">
        <?= form_label('Nama Provinsi' . required(), 'nama_provinsi', $control_label); ?>
        <div class="controls">
            <?= form_input($nama_provinsi_attr) ?>
            <p class="help-block"><?php echo form_error('nama_provinsi') ?></p>
        </div>
    </div>


    <div class="form-actions well">
        <button class="btn btn-small btn-primary" type="submit">Simpan</button>
    </div>
    <?php form_close() ?>
</div>
<?php $this->load->view('_shared/footer'); ?>