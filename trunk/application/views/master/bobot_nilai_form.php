<?php
$this->load->view('_shared/header');
$this->load->view('_shared/menus');

//label
$control_label = array(
    'class' => 'control-label'
);

$nilai_angka_attr = array(
    'name' => 'nilai_angka',
    'class' => 'input-mini',
    'value' => set_value('nilai_angka', $nilai_angka),
    'autocomplete' => 'off'
);

$nilai_huruf_attr = array(
    'name' => 'nilai_huruf',
    'class' => 'input-mini',
    'value' => set_value('nilai_huruf', $nilai_huruf),
    'autocomplete' => 'off'
);

$bobot_nilai_huruf_attr = array(
    'name' => 'bobot_nilai_huruf',
    'class' => 'input-medium',
    'value' => set_value('bobot_nilai_huruf', $bobot_nilai_huruf),
    'autocomplete' => 'off'
);

$keterangan_bobot_nilai_attr = array(
    'name' => 'keterangan_bobot_nilai',
    'class' => 'input-medium',
    'value' => set_value('keterangan_bobot_nilai', $keterangan_bobot_nilai),
    'autocomplete' => 'off'
);
?>
<div class="container-full" id="bobot_nilai">
    <?= form_open($action_url, array('class' => 'form-horizontal')); ?>

    <div class="control-group">
        <?= form_label('Nilai Angak' . required(), 'nilai_angka', $control_label); ?>
        <div class="controls">
            <?= form_input($nilai_angka_attr) ?>
            <p class="help-block"><?php echo form_error('nilai_angka') ?></p>
        </div>
    </div>

    <div class="control-group">
        <?= form_label('Nilai Huruf' . required(), 'nilai_huruf', $control_label); ?>
        <div class="controls">
            <?= form_input($nilai_huruf_attr) ?>
            <p class="help-block"><?php echo form_error('nilai_huruf') ?></p>
        </div>
    </div>
    
    <div class="control-group">
        <?= form_label('Bobot Nilai Huruf' . required(), 'bobot_nilai_huruf', $control_label); ?>
        <div class="controls">
            <?= form_input($bobot_nilai_huruf_attr) ?>
            <p class="help-block"><?php echo form_error('bobot_nilai_huruf') ?></p>
        </div>
    </div>
    
    <div class="control-group">
        <?= form_label('Keterangan Bobot Nilai' . required(), 'keterangan_bobot_nilai', $control_label); ?>
        <div class="controls">
            <?= form_input($keterangan_bobot_nilai_attr) ?>
            <p class="help-block"><?php echo form_error('keterangan_bobot_nilai') ?></p>
        </div>
    </div>


    <div class="form-actions well">
        <button class="btn btn-small btn-primary" type="submit">Simpan</button>
    </div>
    <?php form_close() ?>
</div>
<?php $this->load->view('_shared/footer'); ?>