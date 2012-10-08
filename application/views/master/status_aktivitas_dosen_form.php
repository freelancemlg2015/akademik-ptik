<?php
$this->load->view('_shared/header');
$this->load->view('_shared/menus');

//label
$control_label = array(
    'class' => 'control-label'
);

$kode_status_aktivitas_attr = array(
    'name' => 'kode_status_aktivitas',
    'class' => 'input-small',
    'value' => set_value('kode_status_aktivitas', $kode_status_aktivitas),
    'autocomplete' => 'off'
);

$status_aktivitas_dosen_attr = array(
    'name' => 'status_aktivitas_dosen',
    'class' => 'input-medium',
    'value' => set_value('status_aktivitas_dosen', $status_aktivitas_dosen),
    'autocomplete' => 'off'
);
?>
<div class="container-full" id="status_aktivitas_dosen">
    <?= form_open($action_url, array('class' => 'form-horizontal')); ?>

    <div class="control-group">
        <?= form_label('Kode Status Aktivitas' . required(), 'kode_status_aktivitas', $control_label); ?>
        <div class="controls">
            <?= form_input($kode_status_aktivitas_attr) ?>
            <p class="help-block"><?php echo form_error('kode_status_aktivitas') ?></p>
        </div>
    </div>

    <div class="control-group">
        <?= form_label('Status Aktivitas Dosen' . required(), 'status_aktivitas_dosen', $control_label); ?>
        <div class="controls">
            <?= form_input($status_aktivitas_dosen_attr) ?>
            <p class="help-block"><?php echo form_error('status_aktivitas_dosen') ?></p>
        </div>
    </div>


    <div class="form-actions well">
        <button class="btn btn-small btn-primary" type="submit">Simpan</button>
    </div>
    <?php form_close() ?>
</div>
<?php $this->load->view('_shared/footer'); ?>