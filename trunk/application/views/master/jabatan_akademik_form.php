<?php
$this->load->view('_shared/header');
$this->load->view('_shared/menus');

//label
$control_label = array(
    'class' => 'control-label'
);

$kode_jabatan_akademik_attr = array(
    'name' => 'kode_jabatan_akademik',
    'class' => 'input-small',
    'value' => set_value('kode_jabatan_akademik', $kode_jabatan_akademik),
    'autocomplete' => 'off'
);

$nama_jabatan_akademik_attr = array(
    'name' => 'nama_jabatan_akademik',
    'class' => 'input-medium',
    'value' => set_value('nama_jabatan_akademik', $nama_jabatan_akademik),
    'autocomplete' => 'off'
);
?>
<div class="container-full" id="jabatan_akademik">
    <?= form_open($action_url, array('class' => 'form-horizontal')); ?>

    <div class="control-group">
        <?= form_label('Kode Jabatan Akademik' . required(), 'kode_jabatan_akademik', $control_label); ?>
        <div class="controls">
            <?= form_input($kode_jabatan_akademik_attr) ?>
            <p class="help-block"><?php echo form_error('kode_jabatan_akademik') ?></p>
        </div>
    </div>

    <div class="control-group">
        <?= form_label('Nama Jabatan Akademik' . required(), 'nama_jabatan_akademik', $control_label); ?>
        <div class="controls">
            <?= form_input($nama_jabatan_akademik_attr) ?>
            <p class="help-block"><?php echo form_error('nama_jabatan_akademik') ?></p>
        </div>
    </div>


    <div class="form-actions well">
        <button class="btn btn-small btn-primary" type="submit">Simpan</button>
    </div>
    <?php form_close() ?>
</div>
<?php $this->load->view('_shared/footer'); ?>