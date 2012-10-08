<?php
$this->load->view('_shared/header');
$this->load->view('_shared/menus');

//label
$control_label = array(
    'class' => 'control-label'
);

$kode_ruang_attr = array(
    'name' => 'kode_ruang',
    'class' => 'input-small',
    'value' => set_value('kode_ruang', $kode_ruang),
    'autocomplete' => 'off'
);

$nama_ruang_attr = array(
    'name' => 'nama_ruang',
    'class' => 'input-xlarge',
    'value' => set_value('nama_ruang', $nama_ruang),
    'autocomplete' => 'off'
);

$jenis_ruang_data[0] = '-PILIH-';
foreach ($jenis_ruang_options as $row) {
    $jenis_ruang_data[$row->id] = $row->jenis_ruang;
}

$kapasitas_ruang_attr = array(
    'name' => 'kapasitas_ruang',
    'class'=> 'input-xlarge',
    'value'=> set_value('kapasitas_ruang', $kapasitas_ruang),
    'autorcomplete' => 'off'
);

?>
<div class="container-full" id="ruang_pelajaran">
    <?= form_open($action_url, array('class' => 'form-horizontal')); ?>

    <div class="control-group">
        <?= form_label('Kode Ruang' . required(), 'kode_ruang', $control_label); ?>
        <div class="controls">
            <?= form_input($kode_ruang_attr) ?>
            <p class="help-block"><?php echo form_error('kode_ruang') ?></p>
        </div>
    </div>

    <div class="control-group">
        <?= form_label('Nama Ruang' . required(), 'nama_ruang', $control_label); ?>
        <div class="controls">
            <?= form_input($nama_ruang_attr) ?>
            <p class="help-block"><?php echo form_error('nama_ruang') ?></p>
        </div>
    </div>

    <div class="control-group">
        <?= form_label('Jenis Ruang', 'jenis_ruang_id', $control_label); ?>
        <div class="controls">
            <?= form_dropdown('jenis_ruang_id', $jenis_ruang_data, set_value('jenis_ruang_id', $jenis_ruang_id), 'id="jenis_ruang_id" class="input-medium" prevData-selected="' . set_value('jenis_ruang_id', $jenis_ruang_id) . '"') . '&nbsp;&nbsp;'; ?>
            <p class="help-block"><?php echo form_error('jenis_ruang_id') ?></p>
        </div>
    </div>

    <div class="control-group">
        <?= form_label('Kapasitas Ruang' . required(), 'kapasitas_ruang', $control_label); ?>
        <div class="controls">
            <?= form_input($kapasitas_ruang_attr) ?>
            <p class="help-block"><?php echo form_error('kapasitas_ruang') ?></p>
        </div>
    </div>


    <div class="form-actions well">
        <button class="btn btn-small btn-primary" type="submit">Simpan</button>
    </div>
    <?php form_close() ?>
</div>
<?php $this->load->view('_shared/footer'); ?>