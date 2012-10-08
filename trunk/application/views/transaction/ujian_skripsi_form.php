<?php
$this->load->view('_shared/header');
$this->load->view('_shared/menus');

//label
$control_label = array(
    'class' => 'control-label'
);

$nim_attr = array(
    'name' => 'nim',
    'class' => 'input-medium',
    'value' => set_value('nim', $nim),
    'autocomplete' => 'off'
);

$judul_skripsi_attr = array(
    'name' => 'judul_skripsi',
    'class' => 'input-medium',
    'value' => set_value('judul_skripsi', $judul_skripsi),
    'autocomplete' => 'off',
    'style' => 'text-transform : uppercase'
);

$tgl_ujian_attr = array(
    'name' => 'tgl_ujian',
    'class' => 'input-small',
    'value' => set_value('tgl_ujian', $tgl_ujian),
    'autocomplete' => 'off'    
);

$jam_mulai_attr = array(
    'name' => 'jam_mulai',
    'class' => 'input-mini',
    'value' => set_value('jam_mulai', $jam_mulai),
    'autocomplete' => 'off'    
);

$jam_akhir_attr = array(
    'name' => 'jam_akhir',
    'class' => 'input-mini',
    'value' => set_value('jam_akhir', $jam_akhir),
    'autocomplete' => 'off'    
);

$ketua_penguji_attr = array(
    'name' => 'ketua_penguji',
    'class' => 'input-medium',
    'value' => set_value('ketua_penguji', $ketua_penguji),
    'autocomplete' => 'on'    
);

$anggota_penguji_1_attr = array(
    'name' => 'anggota_penguji_1',
    'class' => 'input-medium',
    'value' => set_value('anggota_penguji_1', $anggota_penguji_1),
    'autocomplete' => 'on'    
);

$anggota_penguji_2_attr = array(
    'name' => 'anggota_penguji_2',
    'class' => 'input-medium',
    'value' => set_value('anggota_penguji_2', $anggota_penguji_2),
    'autocomplete' => 'on'    
);

$sekretaris_penguji_attr = array(
    'name' => 'sekretaris_penguji',
    'class' => 'input-medium',
    'value' => set_value('sekretaris_penguji', $sekretaris_penguji),
    'autocomplete' => 'on'    
);

$keterangan_attr = array(
    'name' => 'keterangan',
    'class' => 'span3',
    'value' => set_value('keterangan', $keterangan),
    'autocomplete' => 'on'    
);
?>
<div class="container-full" id="ujian_skripsi">
<?= form_open($action_url, array('class' => 'form-horizontal')); ?>

    <div class="control-group">
        <?= form_label('Nim' . required(), 'nim', $control_label); ?>
        <div class="controls">
        <?= form_input($nim_attr) ?>
            <p class="help-block"><?php echo form_error('nim') ?></p>
        </div>
    </div>

    <div class="control-group">
        <?= form_label('Judul Skripsi' . required(), 'judul_skripsi', $control_label); ?>
        <div class="controls">
        <?= form_input($judul_skripsi_attr) ?>
            <p class="help-block"><?php echo form_error('judul_skripsi') ?></p>
        </div>
    </div>

    <div class="control-group">
        <?= form_label('Tanggal Ujian' , 'tgl_ujian', $control_label); ?>
        <div class="controls">
        <?= form_input($tgl_ujian_attr) ?>
            <p class="help-block"><?php echo form_error('tgl_ujian') ?></p>
        </div>
    </div>
    
    <div class="control-group">
        <?= form_label('Jam Mulai' , 'jam_mulai', $control_label); ?>
        <div class="controls">
        <?= form_input($jam_mulai_attr) ?>
            <p class="help-block"><?php echo form_error('jam_mulai') ?></p>
        </div>
    </div>
    
    <div class="control-group">
        <?= form_label('Jam Akhir' , 'jam_akhir', $control_label); ?>
        <div class="controls">
        <?= form_input($jam_akhir_attr) ?>
            <p class="help-block"><?php echo form_error('jam_akhir') ?></p>
        </div>
    </div>
    
    <div class="control-group">
        <?= form_label('Ketua Penguji' , 'ketua_penguji', $control_label); ?>
        <div class="controls">
        <?= form_input($ketua_penguji_attr) ?>
            <p class="help-block"><?php echo form_error('ketua_penguji') ?></p>
        </div>
    </div>
    
    <div class="control-group">
        <?= form_label('Anggota Penguji 1' , 'anggota_penguji_1', $control_label); ?>
        <div class="controls">
        <?= form_input($anggota_penguji_1_attr) ?>
            <p class="help-block"><?php echo form_error('anggota_penguji_1') ?></p>
        </div>
    </div>
    
    <div class="control-group">
        <?= form_label('Anggota Penguji 2' , 'anggota_penguji_2', $control_label); ?>
        <div class="controls">
        <?= form_input($anggota_penguji_2_attr) ?>
            <p class="help-block"><?php echo form_error('anggota_penguji_2') ?></p>
        </div>
    </div>
    
    <div class="control-group">
        <?= form_label('Sekretaris Penguji' , 'sekretaris_penguji', $control_label); ?>
        <div class="controls">
        <?= form_input($sekretaris_penguji_attr) ?>
            <p class="help-block"><?php echo form_error('sekretaris_penguji') ?></p>
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