<?php
$this->load->view('_shared/header');
$this->load->view('_shared/menus');

//label
$control_label = array(
    'class' => 'control-label'
);

$nim_attr = array(
    'name'  => 'nim',
    'class' => 'input-small',
    'value' => set_value('nim', $nim),
    'autocomplete' => 'off'
);

$nama_mata_kuliah_attr = array(
    'name'  => 'nama_mata_kuliah',
    'class' => 'input-medium',
    'value' => set_value('nama_mata_kuliah', $nama_mata_kuliah),
    'autocomplete' => 'off'
);

$nilai_nts_attr = array(
    'name'  => 'nilai_nts',
    'class' => 'input-small',
    'value' => set_value('nilai_nts', $nilai_nts),
    'autocomplete' => 'off'
);

$nilai_tgs_attr = array(
    'name'  => 'nilai_tgs',
    'class' => 'input-small',
    'value' => set_value('nilai_tgs', $nilai_tgs),
    'autocomplete' => 'off'
);

$nilai_nas_attr = array(
    'name'  => 'nilai_nas',
    'class' => 'input-small',
    'value' => set_value('nilai_nas', $nilai_nas),
    'autocomplete' => 'off'
);

$nilai_prb_attr = array(
    'name'  => 'nilai_prb',
    'class' => 'input-small',
    'value' => set_value('nilai_prb', $nilai_prb),
    'autocomplete' => 'off'
);

$nilai_akhir_attr = array(
    'name'  => 'nilai_akhir',
    'class' => 'input-small',
    'value' => set_value('nilai_akhir', $nilai_akhir),
    'autocomplete' => 'off'
);

$rangking_attr = array(
    'name'  => 'rangking',
    'class' => 'input-mini',
    'value' => set_value('rangking', $rangking),
    'autocomplete' => 'off'
);

$keterangan_attr = array(
    'name'  => 'keterangan',
    'class' => 'span3',
    'value' => set_value('keterangan', $keterangan),
    'autocomplete' => 'off',
    'style' => 'text-transform : uppercase'
);
?>
<div class="container-full" id="nilai_akademik">
<?= form_open($action_url, array('class' => 'form-horizontal')); ?>

    <div class="control-group">
        <?= form_label('Nim' , 'nim', $control_label); ?>
        <div class="controls">
        <?= form_input($nim_attr) ?>
            <p class="help-block"><?php echo form_error('nim') ?></p>
        </div>
    </div>

    <div class="control-group">
        <?= form_label('Mata Kuliah' , 'nama_mata_kuliah', $control_label); ?>
        <div class="controls">
        <?= form_input($nama_mata_kuliah_attr) ?>
            <p class="help-block"><?php echo form_error('nama_mata_kuliah') ?></p>
        </div>
    </div>
    
    <div class="control-group">
        <?= form_label('Nilai NTS' . required(), 'nilai_nts', $control_label); ?>
        <div class="controls">
        <?= form_input($nilai_nts_attr) ?>
            <p class="help-block"><?php echo form_error('nilai_nts') ?></p>
        </div>
    </div>
    
    <div class="control-group">
        <?= form_label('Nilai Tugas' . required(), 'nilai_tgs', $control_label); ?>
        <div class="controls">
        <?= form_input($nilai_tgs_attr) ?>
            <p class="help-block"><?php echo form_error('nilai_tgs') ?></p>
        </div>
    </div>
    
    <div class="control-group">
        <?= form_label('Nilai NAS' . required(), 'nilai_tgs', $control_label); ?>
        <div class="controls">
        <?= form_input($nilai_tgs_attr) ?>
            <p class="help-block"><?php echo form_error('nilai_tgs') ?></p>
        </div>
    </div>
    
    <div class="control-group">
        <?= form_label('Nilai Perubahan' . required(), 'nilai_prb', $control_label); ?>
        <div class="controls">
        <?= form_input($nilai_prb_attr) ?>
            <p class="help-block"><?php echo form_error('nilai_prb') ?></p>
        </div>
    </div>
    
    <div class="control-group">
        <?= form_label('Nilai Akhir' , 'nilai_akhir', $control_label); ?>
        <div class="controls">
        <?= form_input($nilai_akhir_attr) ?>
            <p class="help-block"><?php echo form_error('nilai_akhir') ?></p>
        </div>
    </div>
    
    <div class="control-group">
        <?= form_label('Rangking' , 'rangking', $control_label); ?>
        <div class="controls">
        <?= form_input($rangking_attr) ?>
            <p class="help-block"><?php echo form_error('rangking') ?></p>
        </div>
    </div>
    
    <div class="control-group">
        <?= form_label('Keterangan', 'keterangan', $control_label); ?>
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