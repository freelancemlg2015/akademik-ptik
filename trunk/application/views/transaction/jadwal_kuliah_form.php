<?php
$this->load->view('_shared/header');
$this->load->view('_shared/menus');

//label
$control_label = array(
    'class' => 'control-label'
);

echo $nama_dosen;
$nama_dosen_attr = array(
    'id' => 'nama_dosen',
    'name' => 'nama_dosen',
    'class' => 'input-medium',
    'value' => set_value('nama_dosen', $nama_dosen),
    'autocomplete' => 'off'
);

$attributes = array('class' => 'dosen_ajar_id', 'id' => 'myform');

//$dosen_ajar_id_attr = array(
//    'id'    => 'dosen_ajar_id',
//    'name'  => 'dosen_ajar_id',
//    'class' => 'input-medium',
//    'value' => set_value('dosen_ajar_id', ''),
//    'autocomplete' => 'off'
//);

$jenis_waktu_attr = array(
    'name' => 'jenis_waktu',
    'class' => 'input-small',
    'value' => set_value('jenis_waktu', $jenis_waktu),
    'autocomplete' => 'off'
);

$tanggal_attr = array(
    'name' => 'tanggal',
    'class' => 'input-small',
    'value' => set_value('tanggal', $tanggal),
    'autocomplete' => 'off'
);

$jam_attr = array(
    'name' => 'jam',
    'class' => 'input-mini',
    'value' => set_value('jam', $jam),
    'autocomplete' => 'off'
);

$keterangan_attr = array(
    'name' => 'keterangan',
    'class' => 'span3',
    'value' => set_value('keterangan', $keterangan),
    'autocomplete' => 'off'
);

$ruang_pelajaran_data[0] = '-PILIH-';
foreach ($ruang_pelajaran_options as $row) {
    $ruang_pelajaran_data[$row->id] = $row->nama_ruang;
}
?>
<div class="container-full" id="jadwal_kuliah">
    <?= form_open($action_url, array('class' => 'form-horizontal')); ?>

    <div class="control-group">
        <?= form_label('Nama Dosen' . required(), 'nama_dosen', $control_label); ?>
        <div class="controls">
            <?= form_input($nama_dosen_attr) ?> <?= form_hidden('dosen_ajar_id', '') ?> 
            <p class="help-block"><?php echo form_error('nama_dosen') ?></p>
        </div>
    </div>

    <div class="control-group">
        <?= form_label('Ruang', 'nama_ruang_id', $control_label); ?>
        <div class="controls">
            <?= form_dropdown('nama_ruang_id', $ruang_pelajaran_data, set_value('nama_ruang_id', $nama_ruang_id), 'id="nama_ruang_id" class="input-medium" prevData-selected="' . set_value('nama_ruang_id', $nama_ruang_id) . '"') . '&nbsp;&nbsp;'; ?>
            <p class="help-block"><?php echo form_error('nama_ruang_id') ?></p>
        </div>
    </div>

    <div class="control-group">
        <?= form_label('Jenis Waktu' . required(), 'jenis_waktu', $control_label); ?>
        <div class="controls">
            <?= form_input($jenis_waktu_attr) ?>
            <p class="help-block"><?php echo form_error('jenis_waktu') ?></p>
        </div>
    </div>

    <div class="control-group">
        <?= form_label('Tanggal' . required(), 'tanggal', $control_label); ?>
        <div class="controls">
            <?= form_input($tanggal_attr) ?>
            <p class="help-block"><?php echo form_error('tanggal') ?></p>
        </div>
    </div>

    <div class="control-group">
        <?= form_label('Jam', 'jam', $control_label); ?>
        <div class="controls">
            <?= form_input($jam_attr) ?>
            <p class="help-block"><?php echo form_error('jam') ?></p>
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