<?php
$this->load->view('_shared/header');
$this->load->view('_shared/menus');

//label
$control_label = array(
    'class' => 'control-label'
);

$nama_direktorat_attr = array(
    'name' => 'nama_direktorat',
    'class' => 'input-medium',
    'value' => set_value('nama_direktorat', $nama_direktorat),
    'autocomplete' => 'off'
);

$keterangan_attr = array(
    'name' => 'keterangan',
    'class' => 'span3',
    'value' => set_value('keterangan', $keterangan),
    'autocomplete' => 'off'
);
?>
<div class="container-full" id="direktorat">
    <?= form_open($action_url, array('class' => 'form-horizontal')); ?>

    <div class="control-group">
        <?= form_label('Nama Direktorat' . required(), 'nama_direktorat', $control_label); ?>
        <div class="controls">
            <?= form_input($nama_direktorat_attr) ?>
            <p class="help-block"><?php echo form_error('nama_direktorat') ?></p>
        </div>
    </div>

    <div class="control-group">
        <?= form_label('Keterangan' , 'keterangan', $control_label); ?>
        <div class="controls">
            <?= form_textarea($keterangan_attr) ?>
            <p class="help-block"><?php echo form_error('keterangan') ?></p>
        </div>
    </div>


    <div class="form-actions well">
        <button class="btn btn-small btn-primary" type="submit">Simpan</button>
    </div>
    <?php form_close() ?>
</div>
<?php $this->load->view('_shared/footer'); ?>