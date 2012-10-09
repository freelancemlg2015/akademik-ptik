<?php
$this->load->view('_shared/header');
$this->load->view('_shared/menus');

//label
$control_label = array(
    'class' => 'control-label'
);

$kode_tahun_ajar_attr = array(
    'name' => 'kode_tahun_ajar',
    'class' => 'input-small',
    'value' => set_value('kode_tahun_ajar', $kode_tahun_ajar),
    'autocomplete' => 'off'
);

$tahun_ajar_mulai_attr = array(
    'name' => 'tahun_ajar_mulai',
    'class' => 'input-small',
    'value' => set_value('tahun_ajar_mulai', @$tahun_ajar_mulai),
    'autocomplete' => 'off'
);

$tahun_ajar_akhir_attr = array(
    'name' => 'tahun_ajar_akhir',
    'class' => 'input-small',
    'value' => set_value('tahun_ajar_akhir', @$tahun_ajar_akhir),
    'autocomplete' => 'off'
);

$tgl_mulai_attr = array(
    'name' => 'tgl_mulai',
    'class' => 'input-small',
    'value' => set_value('tgl_mulai', $tgl_mulai),
    'autocomplete' => 'off'
);
?>
<div class="container-full" id="angkatan">
    <?= form_open($action_url, array('class' => 'form-horizontal')); ?>

    <div class="control-group">
        <?= form_label('Kode Tahun Ajar' , 'kode_tahun_ajar', $control_label); ?>
        <div class="controls">
            <?= form_input($kode_tahun_ajar_attr) ?>
            <p class="help-block"><?php echo form_error('kode_tahun_ajar') ?></p>
        </div>
    </div>

    <div class="control-group">
        <?= form_label('Tahun Mulai' , 'tahun_ajar_mulai', $control_label); ?>
        <div class="controls">
            <?= form_input($tahun_ajar_mulai_attr) ?> 
            <p class="help-block"><?php echo form_error('tahun_ajar_mulai') ?></p>
        </div>
    </div>

    <div class="control-group">
        <?= form_label('Tahun Akhir' , 'tahun_ajar_akhir', $control_label); ?>
        <div class="controls">
            <?= form_input($tahun_ajar_akhir_attr) ?>
            <p class="help-block"><?php echo form_error('tahun_ajar_akhir') ?></p>
        </div>
    </div>
    
     <div class="control-group">
        <?= form_label('Tgl Mulai' . required(), 'tgl_mulai', $control_label); ?>
        <div class="controls">
            <?= form_input($tgl_mulai_attr) ?>
            <p class="help-block"><?php echo form_error('tgl_mulai') ?></p>
        </div>
    </div>


    <div class="form-actions well">
        <button class="btn btn-small btn-primary" type="submit">Simpan</button>
    </div>
    <?php form_close() ?>
</div>
<?php $this->load->view('_shared/footer'); ?>