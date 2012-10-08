<?php
$this->load->view('_shared/header');
$this->load->view('_shared/menus');

//label
$control_label = array(
    'class' => 'control-label'
);

$kode_konsentrasi_studi_attr = array(
    'name' => 'kode_konsentrasi_studi',
    'class' => 'input-small',
    'value' => set_value('kode_konsentrasi_studi', $kode_konsentrasi_studi),
    'autocomplete' => 'off'
);

$nama_konsentrasi_studi_attr = array(
    'name' => 'nama_konsentrasi_studi',
    'class' => 'input-medium',
    'value' => set_value('nama_konsentrasi_studi', $nama_konsentrasi_studi),
    'autocomplete' => 'off'
);
?>
<div class="container-full" id="konsentrasi_studi">
    <?= form_open($action_url, array('class' => 'form-horizontal')); ?>

    <div class="control-group">
        <?= form_label('Kode Konsentrasi Studi' . required(), 'kode_konsentrasi_studi', $control_label); ?>
        <div class="controls">
            <?= form_input($kode_konsentrasi_studi_attr) ?>
            <p class="help-block"><?php echo form_error('kode_konsentrasi_studi') ?></p>
        </div>
    </div>

    <div class="control-group">
        <?= form_label('Nama Konsentrasi Studi' . required(), 'nama_konsentrasi_studi', $control_label); ?>
        <div class="controls">
            <?= form_input($nama_konsentrasi_studi_attr) ?>
            <p class="help-block"><?php echo form_error('nama_konsentrasi_studi') ?></p>
        </div>
    </div>


    <div class="form-actions well">
        <button class="btn btn-small btn-primary" type="submit">Simpan</button>
    </div>
    <?php form_close() ?>
</div>
<?php $this->load->view('_shared/footer'); ?>