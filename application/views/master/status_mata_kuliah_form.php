<?php
$this->load->view('_shared/header');
$this->load->view('_shared/menus');

//label
$control_label = array(
    'class' => 'control-label'
);

$angkatan_data[0] = '';
foreach ($angkatan_options as $row) {
    $angkatan_data[$row->id] = $row->nama_angkatan;
}

$kode_matakuliah_attr = array(
    'name' => 'kode_matakuliah',
    'class' => 'input-small',
    'value' => set_value('kode_matakuliah', $kode_matakuliah),
    'autocomplete' => 'off'
);

$kode_dikang_attr = array(
    'name' => 'kode_dikang',
    'class'=> 'input-small',
    'value'=> set_value('kode_dikang', $kode_dikang),
    'autocomplete' => 'off'
);

$nama_matakuliah_attr = array(
    'name' => 'nama_matakuliah',
    'class'=> 'input-medium',
    'value'=> set_value('nama_matakuliah', $nama_matakuliah),
    'autocomplete' => 'off'
);

$status_mata_kuliah_attr = array(
    'name' => 'status_mata_kuliah',
    'class' => 'input-small',
    'value' => set_value('status_mata_kuliah', $status_mata_kuliah),
    'autocomplete' => 'off'
);

$jml_sks_attr = array(
    'name' => 'jml_sks',
    'class' => 'input-small',
    'value' => set_value('jml_sks', $jml_sks),
    'autocomplete' => 'off'
);

$konsentrasi_studi_data[0] = '';
foreach ($konsentrasi_studi_options as $row) {
    $konsentrasi_studi_data[$row->id] = $row->nama_konsentrasi_studi;
}

$bobot_nts_attr = array(
    'name' => 'bobot_nts',
    'class' => 'input-small',
    'value' => set_value('bobot_nts', $bobot_nts),
    'autocomplete' => 'off'
);

$bobot_nas_attr = array(
    'name' => 'bobot_nas',
    'class' => 'input-small',
    'value' => set_value('bobot_nas', $bobot_nas),
    'autocomplete' => 'off'
);

$bobot_tgs_attr = array(
    'name' => 'bobot_tgs',
    'class' => 'input-small',
    'value' => set_value('bobot_tgs', $bobot_tgs),
    'autocomplete' => 'off'
);

?>
<div class="container-full" id="status_mata_kuliah">
    <?= form_open($action_url, array('class' => 'form-horizontal')); ?>

    <div class="control-group">
        <?= form_label('Nama Matakuliah' .required(), 'nama_matakuliah', $control_label); ?>
        <div class="controls">
            <?= form_input($nama_matakuliah_attr) ?>
            <p class="help-block"><?php echo form_error('nama_matakuliah') ?></p>
        </div>
    </div>

    <div class="control-group">
        <?= form_label('Status Mata Kuliah' . required(), 'status_mata_kuliah', $control_label); ?>
        <div class="controls">
            <?= form_input($status_mata_kuliah_attr) ?>
            <p class="help-block"><?php echo form_error('status_mata_kuliah') ?></p>
        </div>
    </div>

    <div class="control-group">
        <?= form_label('Jumlah SKS' , 'jml_sks', $control_label); ?>
        <div class="controls">
            <?= form_input($jml_sks_attr) ?>
            <p class="help-block"><?php echo form_error('jml_sks') ?></p>
        </div>
    </div>
       
    <div class="control-group">
        <?= form_label('Bobot NTS' , 'bobot_nts', $control_label); ?>
        <div class="controls">
            <?= form_input($bobot_nts_attr) ?>
            <p class="help-block"><?php echo form_error('bobot_nts') ?></p>
        </div>
    </div>
    
    <div class="control-group">
        <?= form_label('Bobot NAS' , 'bobot_nas', $control_label); ?>
        <div class="controls">
            <?= form_input($bobot_nas_attr) ?>
            <p class="help-block"><?php echo form_error('bobot_nas') ?></p>
        </div>
    </div>
    
    <div class="control-group">
        <?= form_label('Bobot Tugas' , 'bobot_tgs', $control_label); ?>
        <div class="controls">
            <?= form_input($bobot_tgs_attr) ?>
            <p class="help-block"><?php echo form_error('bobot_tgs') ?></p>
        </div>
    </div>

    <div class="form-actions well">
        <button class="btn btn-small btn-primary" type="submit">Simpan</button>
    </div>
    <?php form_close() ?>
</div>
<?php $this->load->view('_shared/footer'); ?>