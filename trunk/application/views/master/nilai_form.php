<?php
$this->load->view('_shared/header');
$this->load->view('_shared/menus');

//label
$control_label = array(
    'class' => 'control-label'
);

$kode_nilai_attr = array(
    'name' => 'kode_nilai',
    'class' => 'input-small',
    'value' => set_value('kode_nilai', $kode_nilai),
    'autocomplete' => 'off'
);

$nilai_attr = array(
    'name' => 'nilai',
    'class' => 'input-medium',
    'value' => set_value('nilai', $nilai),
    'autocomplete' => 'off'
);
?>
<div class="container-full" id="nilai">
    <?= form_open($action_url, array('class' => 'form-horizontal')); ?>

    <div class="control-group">
        <?= form_label('Kode Nilai' . required(), 'kode_nilai', $control_label); ?>
        <div class="controls">
            <?= form_input($kode_nilai_attr) ?>
            <p class="help-block"><?php echo form_error('kode_nilai') ?></p>
        </div>
    </div>

    <div class="control-group">
        <?= form_label('Nilai' . required(), 'nilai', $control_label); ?>
        <div class="controls">
            <?= form_input($nilai_attr) ?>
            <p class="help-block"><?php echo form_error('nilai') ?></p>
        </div>
    </div>


    <div class="form-actions well">
        <button class="btn btn-small btn-primary" type="submit">Simpan</button>
    </div>
    <?php form_close() ?>
</div>
<?php $this->load->view('_shared/footer'); ?>