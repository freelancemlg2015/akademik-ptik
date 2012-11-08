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
$jam_normal_mulai_attr = array(
    'name' => 'jam_normal_mulai',
    'class' => 'input-mini',
    'value' => set_value('jam_normal_mulai', $jam_normal_mulai),
    'autocomplete' => 'off'
);


$jam_normal_akhir_attr = array(
    'name' => 'jam_normal_akhir',
    'class' => 'input-mini',
    'value' => set_value('jam_normal_akhir', $jam_normal_akhir),
    'autocomplete' => 'off'
);
$ruang_pelajaran_data[0] = '';
foreach ($ruang_pelajaran_options as $row) {
    $ruang_pelajaran_data[$row->id] = $row->nama_ruang;
}
$dosen_data[] = '';
    foreach ($dosen_options as $row) {
        $dosen_data[$row->id] = $row->nama_dosen;
}
$pegawai_data[] = '';
    foreach ($pegawai_options as $row) {
        $pegawai_data[$row->id] = $row->nama_pegawai;
}
//print_r($nama_dosen_data);
?>
<div class="container-full" id="jadwal_kuliah">
    <?php echo form_open($action_url, array('class' => 'form-horizontal')); ?>
	<?php $this->load->view('transaction/header_select_transaction'); ?>
	
	<div class="control-group">
        <?= form_label('Jenis Ujian' . required(), 'jenis_ujian_id', $control_label); ?>
        <div class="controls">
			<?= form_dropdown('jenis_ujian_id', $kegiatan_options, set_value('jenis_ujian_id', $jenis_ujian_id), 'id="jenis_ujian_id" class="input-medium" prevData-selected="' . set_value('jenis_ujian_id', $jenis_ujian_id) . '"') . '&nbsp;&nbsp;'; ?>
            <p class="help-block"><?php echo form_error('jenis_ujian_id') ?></p>
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
		<?= form_label('Waktu' . required(), 'jam_normal_mulai', $control_label); ?>
        <div class="controls">
            <?= form_input($jam_normal_mulai_attr) ?> <?= form_input($jam_normal_akhir_attr) ?>
            <p class="help-block"><?php echo form_error('jam_normal_mulai') ?></p>
        </div>
	</div>
	
	<div class="control-group">
        <?= form_label('Ruang' . required(), 'nama_ruang_id', $control_label); ?>
        <div class="controls">
            <?= form_dropdown('nama_ruang_id', $ruang_pelajaran_data, set_value('nama_ruang_id', $nama_ruang_id), 'id="nama_ruang_id" class="input-medium" prevData-selected="' . set_value('nama_ruang_id', $nama_ruang_id) . '"') . '&nbsp;&nbsp;'; ?>
            <p class="help-block"><?php echo form_error('nama_ruang_id') ?></p>
        </div>
    </div>
	
	<fieldset>
        <legend><b>Pengawas Ujian</b></legend>
        <div class="control-group">
            <a id="button_add_dosen" class="btn btn-mini button_add_dosen_class"><i class="icon-plus"></i></a>
            <?= form_label('<b>Dosen</b>' , 'dosen_id', $control_label); ?>
            <div class="controls">
                <?php                            
                    //echo form_dropdown('dosen_id[]', $dosen_data, set_value('dosen_id', ''), 'id="dosen_id" class="input-medium" prevData-selected="' . set_value('dosen_id', '') . '"');
					if (!empty($dosen_options_edit)){
						$i=0;
                        foreach($dosen_options_edit as $row) {    
							//form_label('<b>dosen_id</b>' , 'dosen_id', $control_label);
							//if($i>0) echo  '<label class="control-label" for="dosen_id">Dosen</label>';
							echo form_dropdown('dosen_id[]', $dosen_data, set_value('dosen_id', $row['dosen_id']), 'id="dosen_id" class="input-medium" prevData-selected="' . set_value('dosen_id', $row['dosen_id']) . '"');
							if($i>0) {
								echo '<span class="btn-mini-class"><a class="btn btn-mini remove-add_dosen"><i class="icon-minus"></i></a></span>';
							}
							$i++;
                        };
                    }
                    else {
                        echo form_dropdown('dosen_id[]', $dosen_data, set_value('dosen_id', ''), 'id="dosen_id" class="input-medium" prevData-selected="' . set_value('dosen_id', '') . '"');
                    }
                ?>
                <p class="help-block"><?php echo form_error('dosen_id') ?></p>
            </div>
        </div>
		<div class="clear:both"></div>
		<div class="control-group">
			<a id="button_add_pegawai" class="btn btn-mini button_add_pegawai_class"><i class="icon-plus"></i></a>
            <?= form_label('<b>Pegawai</b>' , 'pegawai_id', $control_label); ?>
            <div class="controls">
                <?php                            
                   // echo form_dropdown('pegawai_id[]', $pegawai_data, set_value('pegawai_id', ''), 'id="pegawai_id" class="input-medium" prevData-selected="' . set_value('pegawai_id', '') . '"');
					if (!empty($pegawai_options_edit)){
                        $i=0;
						foreach($pegawai_options_edit as $row) {    
							echo form_dropdown('pegawai_id[]', $pegawai_data, set_value('pegawai_id', $row['pegawai_id']), 'id="pegawai_id" class="input-medium" prevData-selected="' . set_value('pegawai_id', $row['pegawai_id']) . '"');
							if($i>0) {
								echo '<span class="btn-mini-class"><a class="btn btn-mini remove-add_pegawai"><i class="icon-minus"></i></a></span>';
							}
							$i++;
						};
                    }
                    else {
                        echo form_dropdown('pegawai_id[]', $pegawai_data, set_value('pegawai_id', ''), 'id="pegawai_id" class="input-medium" prevData-selected="' . set_value('pegawai_id', '') . '"');
                    }
                ?>
                <p class="help-block"><?php echo form_error('pegawai_id') ?></p>
            </div>
        </div>
    </fieldset>
    <div class="clear:both"></div>
	
    <div class="form-actions well">
        <button class="btn btn-small btn-primary" type="submit">Simpan</button>
    </div>
    <?php form_close() ?>
</div>
<?php $this->load->view('_shared/footer'); ?>