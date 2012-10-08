<?php
$this->load->view('_shared/header');
$this->load->view('_shared/menus');

//label
$control_label = array(
    'class' => 'control-label'
);

$kode_bobot_nilai_attr = array(
    'name' => 'kode_bobot_nilai',
    'class' => 'input-small',
    'value' => set_value('kode_bobot_nilai', $kode_bobot_nilai),
    'autocomplete' => 'off'
);

$keterangan_nilai_attr = array(
    'name' => 'keterangan_nilai',
    'class' => 'input-medium',
    'value' => set_value('keterangan_nilai', $keterangan_nilai),
    'autocomplete' => 'off'
);
?>
<div class="container-full" id="bobot_nilai">
    <?= form_open($action_url, array('class' => 'form-horizontal')); ?>

    <div class="control-group">
        <?= form_label('Kode Bobot Nilai' . required(), 'kode_bobot_nilai', $control_label); ?>
        <div class="controls">
            <?= form_input($kode_bobot_nilai_attr) ?>
            <p class="help-block"><?php echo form_error('kode_bobot_nilai') ?></p>
        </div>
    </div>

    <div class="control-group">
        <?= form_label('Keterangan Nilai' . required(), 'keterangan_nilai', $control_label); ?>
        <div class="controls">
            <?= form_input($keterangan_nilai_attr) ?>
            <p class="help-block"><?php echo form_error('keterangan_nilai') ?></p>
        </div>
    </div>


    <div class="form-actions well">
        <button class="btn btn-small btn-primary" type="submit">Simpan</button>
    </div>
    <?php form_close() ?>
</div>
<?php $this->load->view('_shared/footer'); ?>