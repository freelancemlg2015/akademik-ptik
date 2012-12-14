<?php
$this->load->view('_shared/header');
$this->load->view('_shared/menus');

//label
$control_label = array(
    'class' => 'control-label'
);
$tgl_lahir_attr = array(
    'name' => 'tgl_lahir',
    'class' => 'input-small',
    'value' => set_value('tgl_lahir', $tgl_lahir),
    'autocomplete' => 'off'
);
$pertemuan_ke_attr = array(
    'name' => 'pertemuan_ke',
    'class' => 'input-small',
    'value' => set_value('pertemuan_ke', $pertemuan_ke),
    'autocomplete' => 'off'
);
$pertemuan_dari_attr = array(
    'name' => 'pertemuan_dari',
    'class' => 'input-small',
    'value' => set_value('pertemuan_dari', $pertemuan_dari),
    'autocomplete' => 'off'
);

$ruang_pelajaran_data[0] = '';
foreach ($ruang_pelajaran_options as $row) {
    $ruang_pelajaran_data[$row->id] = $row->nama_ruang;
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
        <?= form_label('Kegiatan', 'kegiatan_id', $control_label); ?>
        <div class="controls">
			<?= form_dropdown('kegiatan_id', $kegiatan_options, set_value('kegiatan_id', $kegiatan_id), 'id="pangkat_id" class="input-medium" prevData-selected="' . set_value('kegiatan_id', $kegiatan_id) . '"'); ?>
			(<b>jika mengisi kegiatan</b>, maka proses yang disimpan adalah <b>data kegiatan</b> bukan mata kuliah)
            <p class="help-block"><?php echo form_error('kegiatan_id') ?></p>
        </div>
    </div>
	<div class="control-group">
        <?= form_label('Minggu Ke' . required(), 'minggu_ke', $control_label); ?>
        <div class="controls">
			<?= form_dropdown('minggu_ke', $minggu_ke_options, set_value('minggu_ke', $minggu_ke), 'id="agama_id" class="input-medium" prevData-selected="' . set_value('minggu_ke', $minggu_ke) . '"'); ?>
            <p class="help-block"><?php echo form_error('minggu_ke') ?></p>
        </div>
    </div>
	<div class="control-group">
        <?= form_label('Tanggal' . required(), 'tgl_lahir', $control_label); ?>
		<div class="controls">
            <?= form_input($tgl_lahir_attr) ?>
            <p class="help-block"><?php echo form_error('tgl_lahir') ?></p>
        </div>
    </div>
	<div class="control-group">
        <?= form_label('Waktu' . required(), 'jenis_waktu', $control_label); ?>
        <div class="controls">
            <?= form_dropdown('jenis_waktu', $jam_pelajaran_data, set_value('jenis_waktu', $jenis_waktu), 'id="jenis_waktu" class="input-medium" prevData-selected="' . set_value('jenis_waktu', $jenis_waktu) . '"'); ?>
            <p class="help-block"><?php echo form_error('jenis_waktu') ?></p>
        </div>
    </div>
	<div class="control-group">
        <?= form_label('Pertemuan ke' . required(), 'pertemuan_ke', $control_label); ?>
        <div class="controls">
			<?= form_input($pertemuan_ke_attr) ?>
            <p class="help-block"><?php echo form_error('pertemuan_ke') ?></p>
        </div>
    </div>
	<div class="control-group">
        <?= form_label('Pertemuan dari' . required(), 'pertemuan_dari', $control_label); ?>
        <div class="controls">
			<?= form_input($pertemuan_dari_attr) ?>
            <p class="help-block"><?php echo form_error('pertemuan_dari') ?></p>
        </div>
    </div>
	<div class="control-group">
        <?= form_label('Metode Ajar', 'metode_ajar_id', $control_label); ?>
        <div class="controls">
			<?= form_dropdown('metode_ajar_id', $metode_ajar_options, set_value('metode_ajar_id', $metode_ajar_id), 'id="pangkat_id" class="input-medium" prevData-selected="' . set_value('metode_ajar_id', $metode_ajar_id) . '"'); ?>
            <p class="help-block"><?php echo form_error('metode_ajar_id') ?></p>
        </div>
    </div>
	<div class="control-group">
        <?= form_label('Ruang' . required(), 'nama_ruang_id', $control_label); ?>
        <div class="controls">
            <?= form_dropdown('nama_ruang_id', $ruang_pelajaran_data, set_value('nama_ruang_id', $nama_ruang_id), 'id="nama_ruang_id" class="input-medium" prevData-selected="' . set_value('nama_ruang_id', $nama_ruang_id) . '"'); ?>
            <p class="help-block"><?php echo form_error('nama_ruang_id') ?></p>
        </div>
    </div>
    <div class="form-actions well">
        <button class="btn btn-small btn-primary" type="submit">Simpan</button>
    </div>
    <?php form_close() ?>
</div>
<?php $this->load->view('_shared/footer'); ?>
<script type="text/javascript">
	function mataKuliahChange(){}
</script>