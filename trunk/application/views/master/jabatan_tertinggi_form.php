<?php
$this->load->view('_shared/header');
$this->load->view('_shared/menus');

//label
$control_label = array(
    'class' => 'control-label'
);

$kode_jabatan_tertinggi_attr = array(
    'name' => 'kode_jabatan_tertinggi',
    'class' => 'input-small',
    'value' => set_value('kode_jabatan_tertinggi', $kode_jabatan_tertinggi),
    'autocomplete' => 'off'
);

$jabatan_tertinggi_attr = array(
    'name' => 'jabatan_tertinggi',
    'class' => 'input-xlarge',
    'value' => set_value('jabatan_tertinggi', $jabatan_tertinggi),
    'autocomplete' => 'off'
);

$status_akreditasi_data[0] = '-PILIH-';
foreach ($status_akreditasi_options as $row) {
    $status_akreditasi_data[$row->id] = $row->status_akreditasi;
}


?>
<div class="container-full" id="jabatan_tertinggi">
    <?= form_open($action_url, array('class' => 'form-horizontal')); ?>

    <div class="control-group">
        <?= form_label('Kode Jabatan Tertinggi' . required(), 'kode_jabatan_tertinggi', $control_label); ?>
        <div class="controls">
            <?= form_input($kode_jabatan_tertinggi_attr) ?>
            <p class="help-block"><?php echo form_error('kode_jabatan_tertinggi') ?></p>
        </div>
    </div>

    <div class="control-group">
        <?= form_label('Jabatan Tertinggi' . required(), 'jabatan_tertinggi', $control_label); ?>
        <div class="controls">
            <?= form_input($jabatan_tertinggi_attr) ?>
            <p class="help-block"><?php echo form_error('jabatan_tertinggi') ?></p>
        </div>
    </div>

    <div class="control-group">
        <?= form_label('Status Akreditasi', 'status_akreditasi_id', $control_label); ?>
        <div class="controls">
            <?= form_dropdown('status_akreditasi_id', $status_akreditasi_data, set_value('status_akreditasi_id', $status_akreditasi_id), 'id="status_akreditasi_id" class="input-medium" prevData-selected="' . set_value('status_akreditasi_id', $status_akreditasi_id) . '"') . '&nbsp;&nbsp;'; ?>
            <p class="help-block"><?php echo form_error('status_akreditasi_id') ?></p>
        </div>
    </div>

    <div class="form-actions well">
        <button class="btn btn-small btn-primary" type="submit">Simpan</button>
    </div>
    <?php form_close() ?>
</div>
<?php $this->load->view('_shared/footer'); ?>