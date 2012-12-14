<?php
$this->load->view('_shared/header');
$this->load->view('_shared/menus');

//label
$control_label = array(
    'class' => 'control-label'
);
$pelaksanaan_kuliah='';
$pelaksanaan_kuliah_attr = array(
    'name' => 'pelaksanaan_kuliah[]',
    'class' => 'span5',
	'rows' => '4',
    'value' => set_value('pelaksanaan_kuliah[]', $pelaksanaan_kuliah),
    'autocomplete' => 'off'
);

$keterangan_attr = array(
    'name' => 'keterangan',
    'class' => 'span5',
	'rows' => '2',
    'value' => set_value('keterangan', $keterangan),
    'autocomplete' => 'off'
);

$hari_data[0] = '';
foreach ($hari_options as $row) {
    $hari_data[$row->id] = $row->nama_hari;
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
	<fieldset>
		<div class="clear:both"></div>
        <legend><b>Jadwal Pelaksanaan Kuliah</b></legend>
        <div class="control-group">
            <div id='dosen_id[]'>
			<a id="button_add_induk" class="btn btn-mini button_add_induk_class"><i class="icon-plus"></i></a>
			<?php                            
				// echo form_dropdown('pegawai_id[]', $pegawai_data, set_value('pegawai_id', ''), 'id="pegawai_id" class="input-medium" prevData-selected="' . set_value('pegawai_id', '') . '"');
				if (!empty($data_jadwal_induk_options_edit)){
					//print_r($data_jadwal_induk_options_edit);
					$i=0;
					foreach($data_jadwal_induk_options_edit as $row) {    
						?>
						<div class="control-group">
							<?= form_label('<b>Hari</b>' . required(), 'hari_id[]', $control_label); ?>
							<div class="controls">
								<?= form_dropdown('hari_id[]', $hari_data, set_value('hari_id', $row->hari_id), 'id="hari_id" class="input-medium" prevData-selected="' . set_value('hari_id', $row->hari_id) . '"'); ?>								
								<?php
									//echo $i;
									if($i>0) {
										echo '<span class="btn-mini-class"><a class="btn btn-mini remove-add_induk"><i class="icon-minus"></i></a></span>';
									}
									$i++;
								?>
								<p class="help-block"><?php echo form_error('hari_id') ?></p>
							</div>
						</div>
						<div class="control-group">
							<?= form_label('Waktu' . required(), 'jenis_waktu', $control_label); ?>
							<div class="controls">
								<?= form_dropdown('jenis_waktu[]', $jam_pelajaran_data, set_value('jenis_waktu', $row->jenis_waktu), 'id="jenis_waktu" class="input-medium" prevData-selected="' . set_value('jenis_waktu', $row->jenis_waktu) . '"'); ?>
								<p class="help-block"><?php echo form_error('jenis_waktu') ?></p>
							</div>
						</div>
						<div class="control-group">
							<?= form_label('Pelaksanaan Kuliah' . required(), 'pelaksanaan_kuliah', $control_label); ?>
							<div class="controls">
								<textarea class="span5" autocomplete="off" rows="4" cols="40" text="" name="pelaksanaan_kuliah[]"><?php echo $row->pelaksanaan_kuliah;?></textarea>
								<p class="help-block"><?php echo form_error('pelaksanaan_kuliah') ?></p>
							</div>
						</div>
						<?
					};
					echo '</div>';
			} else {
			?>
				<div class="control-group">
					<?= form_label('<b>Hari</b>' . required(), 'hari_id[]', $control_label); ?>
					<div class="controls">
						<?= form_dropdown('hari_id[]', $hari_data, set_value('hari_id', ''), 'id="hari_id" class="input-medium" prevData-selected="' . set_value('hari_id', '') . '"'); ?>
						<p class="help-block"><?php echo form_error('hari_id') ?></p>
					</div>
				</div>
				<div class="control-group">
					<?= form_label('Waktu' . required(), 'jenis_waktu', $control_label); ?>
					<div class="controls">
						<?= form_dropdown('jenis_waktu[]', $jam_pelajaran_data, set_value('jenis_waktu', ''), 'id="jenis_waktu" class="input-medium" prevData-selected="' . set_value('jenis_waktu', '') . '"'); ?>
						<p class="help-block"><?php echo form_error('jenis_waktu') ?></p>
					</div>
				</div>
				<div class="control-group">
					<?= form_label('Pelaksanaan Kuliah' . required(), 'pelaksanaan_kuliah', $control_label); ?>
					<div class="controls">
						<?= form_textarea($pelaksanaan_kuliah_attr) ?>
						<p class="help-block"><?php echo form_error('pelaksanaan_kuliah') ?></p>
					</div>
				</div>
				</div>
				<?php                            
					}
				?>
			
        </div>
    </fieldset>
    <div class="clear:both"></div><hr></hr>
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
<script type="text/javascript">
	function mataKuliahChange(){}
	
$().ready(function(){
    if($('#button_add_induk').length > 0 ){
        $('#button_add_induk').live('click',function(){
			var cloned_hari_id = $("#hari_id").html();
			var cloned_jenis_waktu = $("#jenis_waktu").html();
            var elem = $(this);
            var elem_parent = elem.parents('.control-group');
            var html_to_add = 
				'<div class="control-group">\n\
					<label class="control-label" for="hari_id"><b>Hari</b><em class="required">* </em></label>\n\
					<div class="controls">\n\
						<select id="hari_id_1" class="input-medium" prevdata-selected="" name="hari_id[]">'+cloned_hari_id+'</select>\n\
						<span class="btn-mini-class"><a class="btn btn-mini remove-add_induk"><i class="icon-minus"></i></a></span>\n\
					</div>\n\
					<label class="control-label" for="jenis_waktu">Waktu<em class="required">* </em></label>\n\
					<div class="controls">\n\
						<select id="jenis_waktu_1" class="input-medium" prevdata-selected="" name="jenis_waktu[]">'+cloned_jenis_waktu+'</select>\n\
					</div>\n\
					<label class="control-label" for="pelaksanaan_kuliah">Pelaksanaan Kuliah<em class="required">* </em></label>\n\
					<div class="controls">\n\
						<textarea class="span5" autocomplete="off" rows="4" cols="40" text="" name="pelaksanaan_kuliah[]"></textarea>\n\
					</div>\n\
					<div class="clear:both"></div>\n\
				</div>';
			elem_parent.after(html_to_add);
			$('#hari_id_1').combobox();
			$('#jenis_waktu_1').combobox();
			
			if($('.remove-add_induk').length > 0 ){
				$('.remove-add_induk').live('click',function(){
				elem = $(this);
				var idx = $('.remove-add_induk').index(this);
				var elem = $(this);
				var elem_parent = elem.parents('.controls').parent().remove();
				})
			}
			
        });
    }
});
</script>