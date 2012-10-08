<?php
$this->load->view('_shared/header');
$this->load->view('_shared/menus');

//label
$control_label = array(
    'class' => 'control-label'
);

$kode_kelompok_mata_kuliah_attr = array(
    'name' => 'kode_kelompok_mata_kuliah',
    'class' => 'input-small',
    'value' => set_value('kode_kelompok_mata_kuliah', $kode_kelompok_mata_kuliah),
    'autocomplete' => 'off'
);

$kelompok_mata_kuliah_attr = array(
    'name' => 'kelompok_mata_kuliah',
    'class' => 'input-medium',
    'value' => set_value('kelompok_mata_kuliah', $kelompok_mata_kuliah),
    'autocomplete' => 'off'
);
?>
<div class="container-full" id="kelompok_mata_kuliah">
    <?= form_open($action_url, array('class' => 'form-horizontal')); ?>

    <div class="control-group">
        <?= form_label('Kode Kelompok Mata Kuliah' . required(), 'kode_kelompok_mata_kuliah', $control_label); ?>
        <div class="controls">
            <?= form_input($kode_kelompok_mata_kuliah_attr) ?>
            <p class="help-block"><?php echo form_error('kode_kelompok_mata_kuliah') ?></p>
        </div>
    </div>

    <div class="control-group">
        <?= form_label('Kelompok Mata Kuliah' . required(), 'kelompok_mata_kuliah', $control_label); ?>
        <div class="controls">
            <?= form_input($kelompok_mata_kuliah_attr) ?>
            <p class="help-block"><?php echo form_error('kelompok_mata_kuliah') ?></p>
        </div>
    </div>


    <div class="form-actions well">
        <button class="btn btn-small btn-primary" type="submit">Simpan</button>
    </div>
    <?php form_close() ?>
</div>
<?php $this->load->view('_shared/footer'); ?>