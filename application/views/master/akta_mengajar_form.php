<?php
$this->load->view('_shared/header');
$this->load->view('_shared/menus');

//label
$control_label = array(
    'class' => 'control-label'
);

$kode_akta_attr = array(
    'name' => 'kode_akta',
    'class' => 'input-small',
    'value' => set_value('kode_akta', $kode_akta),
    'autocomplete' => 'off'
);

$nama_akta_mengajar_attr = array(
    'name' => 'nama_akta_mengajar',
    'class' => 'input-medium',
    'value' => set_value('nama_akta_mengajar', $nama_akta_mengajar),
    'autocomplete' => 'off'
);
?>
<div class="container-full" id="akta_mengajar">
    <?= form_open($action_url, array('class' => 'form-horizontal')); ?>

    <div class="control-group">
        <?= form_label('Kode Akta' . required(), 'kode_akta', $control_label); ?>
        <div class="controls">
            <?= form_input($kode_akta_attr) ?>
            <p class="help-block"><?php echo form_error('kode_akta') ?></p>
        </div>
    </div>

    <div class="control-group">
        <?= form_label('Nama Akta Mengajar' . required(), 'nama_akta_mengajar', $control_label); ?>
        <div class="controls">
            <?= form_input($nama_akta_mengajar_attr) ?>
            <p class="help-block"><?php echo form_error('nama_akta_mengajar') ?></p>
        </div>
    </div>


    <div class="form-actions well">
        <button class="btn btn-small btn-primary" type="submit">Simpan</button>
    </div>
    <?php form_close() ?>
</div>
<?php $this->load->view('_shared/footer'); ?>