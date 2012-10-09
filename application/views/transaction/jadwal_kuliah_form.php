<?php
$this->load->view('_shared/header');
$this->load->view('_shared/menus');

//label
$control_label = array(
    'class' => 'control-label'
);
$ruang_pelajaran_data[0] = '';
foreach ($ruang_pelajaran_options as $row) {
    $ruang_pelajaran_data[$row->id] = $row->nama_ruang;
}
$hari_pelajaran_data[0] = '';
foreach ($hari_pelajaran_options as $row) {
    $hari_pelajaran_data[$row->id] = $row->nama_hari ;
}
$jam_pelajaran_data[0] = '';
foreach ($jam_pelajaran_options as $row) {
    $jam_pelajaran_data[$row->id] = $row->kode_jam. ' - '. $row->jam_normal_mulai.'-'. $row->jam_normal_akhir;
}
//print_r($nama_dosen_data);
?>
<div class="container-full" id="jadwal_kuliah">
    <?php echo form_open($action_url, array('class' => 'form-horizontal')); ?>
	<?php $this->load->view('transaction/header_select_transaction'); ?>
	<div class="control-group">
        <?= form_label('Hari' . required(), 'hari_id', $control_label); ?>
        <div class="controls">
            <?= form_dropdown('hari_id', $hari_pelajaran_data, set_value('hari_id', $hari_id), 'id="hari_id" class="input-medium" prevData-selected="' . set_value('hari_id', $hari_id) . '"') . '&nbsp;&nbsp;'; ?>
            <p class="help-block"><?php echo form_error('hari_id') ?></p>
        </div>
    </div>
	
	<div class="control-group">
        <?= form_label('Jam' . required(), 'jenis_waktu', $control_label); ?>
        <div class="controls">
            <?= form_dropdown('jenis_waktu', $jam_pelajaran_data, set_value('jenis_waktu', $jenis_waktu), 'id="jenis_waktu" class="input-medium" prevData-selected="' . set_value('jenis_waktu', $jenis_waktu) . '"') . '&nbsp;&nbsp;'; ?>
            <p class="help-block"><?php echo form_error('jenis_waktu') ?></p>
        </div>
    </div>
	<div class="control-group">
        <?= form_label('Ruang' . required(), 'nama_ruang_id', $control_label); ?>
        <div class="controls">
            <?= form_dropdown('nama_ruang_id', $ruang_pelajaran_data, set_value('nama_ruang_id', $nama_ruang_id), 'id="nama_ruang_id" class="input-medium" prevData-selected="' . set_value('nama_ruang_id', $nama_ruang_id) . '"') . '&nbsp;&nbsp;'; ?>
            <p class="help-block"><?php echo form_error('nama_ruang_id') ?></p>
        </div>
    </div>
    <div class="form-actions well">
        <button class="btn btn-small btn-primary" type="submit">Simpan</button>
    </div>
    <?php form_close() ?>
</div>
<?php $this->load->view('_shared/footer'); ?>