<?php
$this->load->view('_shared/header');
$this->load->view('_shared/menus');

//label
$control_label = array(
    'class' => 'control-label'
);

$kode_semester_attr = array(
    'name' => 'kode_semester',
    'class' => 'input-small',
    'value' => set_value('kode_semester', $kode_semester),
    'autocomplete' => 'off'
);

$nama_semester_attr = array(
    'name' => 'nama_semester',
    'class' => 'input-medium',
    'value' => set_value('nama_semester', $nama_semester),
    'autocomplete' => 'off'
);
?>
<div class="container-full" id="semester">
    <?= form_open($action_url, array('class' => 'form-horizontal')); ?>

    <div class="control-group">
        <?= form_label('Kode Semester' . required(), 'kode_semester', $control_label); ?>
        <div class="controls">
            <?= form_input($kode_semester_attr) ?>
            <p class="help-block"><?php echo form_error('kode_semester') ?></p>
        </div>
    </div>

    <div class="control-group">
        <?= form_label('Nama Semeter' . required(), 'nama_semester', $control_label); ?>
        <div class="controls">
            <?= form_input($nama_semester_attr) ?>
            <p class="help-block"><?php echo form_error('nama_semester') ?></p>
        </div>
    </div>


    <div class="form-actions well">
        <button class="btn btn-small btn-primary" type="submit">Simpan</button>
    </div>
    <?php form_close() ?>
</div>
<?php $this->load->view('_shared/footer'); ?>