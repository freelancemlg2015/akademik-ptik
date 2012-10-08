<?php
$this->load->view('_shared/header');
$this->load->view('_shared/menus');

//label
$control_label = array(
    'class' => 'control-label'
);

$kode_kesatuan_asal_attr = array(
    'name' => 'kode_kesatuan_asal',
    'class' => 'input-small',
    'value' => set_value('kode_kesatuan_asal', $kode_kesatuan_asal),
    'autocomplete' => 'off'
);

$nama_kesatuan_asal_attr = array(
    'name' => 'nama_kesatuan_asal',
    'class' => 'input-medium',
    'value' => set_value('nama_kesatuan_asal', $nama_kesatuan_asal),
    'autocomplete' => 'off'
);
?>
<div class="container-full" id="kesatuan_asal">
    <?= form_open($action_url, array('class' => 'form-horizontal')); ?>

    <div class="control-group">
        <?= form_label('Kode Kesatuan Asal' . required(), 'kode_kesatuan_asal', $control_label); ?>
        <div class="controls">
            <?= form_input($kode_kesatuan_asal_attr) ?>
            <p class="help-block"><?php echo form_error('kode_kesatuan_asal') ?></p>
        </div>
    </div>

    <div class="control-group">
        <?= form_label('Nama Kesatuan Asal' . required(), 'nama_kesatuan_asal', $control_label); ?>
        <div class="controls">
            <?= form_input($nama_kesatuan_asal_attr) ?>
            <p class="help-block"><?php echo form_error('nama_kesatuan_asal') ?></p>
        </div>
    </div>


    <div class="form-actions well">
        <button class="btn btn-small btn-primary" type="submit">Simpan</button>
    </div>
    <?php form_close() ?>
</div>
<?php $this->load->view('_shared/footer'); ?>