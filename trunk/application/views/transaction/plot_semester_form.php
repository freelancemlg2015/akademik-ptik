<?php
$this->load->view('_shared/header');
$this->load->view('_shared/menus');

//label
$control_label = array(
    'class' => 'control-label'
);
$tgl_mulai_attr = array(
    'name' => 'tgl_mulai',
    'class' => 'input-small',
    'value' => set_value('tgl_mulai', @$tgl_mulai),
    'autocomplete' => 'off'
);

$tgl_akhir_attr = array(
    'name' => 'tgl_akhir',
    'class' => 'input-small',
    'value' => set_value('tgl_akhir', @$tgl_akhir),
    'autocomplete' => 'off'
);

$tahun_akademik_id_attr = array(
    'id' => 'tahun_akademik_id_attr',
	'name' => 'tahun_akademik_id_attr',
    'class' => 'input-small',
	'readonly' => 'readonly',
    'value' => set_value('tahun_akademik_id_attr', $tahun_akademik_id_attr),
    'autocomplete' => 'off'
);
//print_r($nama_dosen_data);
?>
<div class="container-full" id="jadwal_kuliah">
    <?php echo form_open($action_url, array('class' => 'form-horizontal')); ?>
	<?php //$this->load->view('transaction/header_select_transaction'); ?>
	    <div class="control-group">
        <?= form_label('Angkatan'. required(), 'angkatan_id', $control_label); ?>
        <div class="controls">
			<?= form_dropdown('angkatan_id', $angkatan_options, set_value('angkatan_id', $angkatan_id), 'id="angkatan_id" onChange="changeAngkatan()" class="input-medium" prevData-selected="' . set_value('angkatan_id', $angkatan_id) . '"'); ?>
            <p class="help-block"><?php echo form_error('angkatan_id') ?></p>
        </div>
    </div>  
    <div class="control-group">
        <?= form_label('Tahun Akademik', 'tahun_akademik_id_attr', $control_label); ?>
        <div class="controls">
			<?= form_input($tahun_akademik_id_attr) ?>
            <p class="help-block"><?php echo form_error('tahun_akademik_id_attr') ?></p>
        </div>
    </div>
    <div class="control-group">
        <?= form_label('Semester'. required(), 'semester_id', $control_label); ?>
        <div class="controls">
			<?= form_dropdown('semester_id', $semester_options, set_value('semester_id', $semester_id), 'id="semester_id" onChange="programStudiChange()" class="input-medium" prevData-selected="' . set_value('semester_id', $semester_id) . '"'); ?>
            <p class="help-block"><?php echo form_error('semester_id') ?></p>
        </div>
    </div>
	<div class="control-group">
        <?= form_label('Tanggal' . required(), 'tgl_mulai', $control_label); ?>
		<div class="controls">
            <?= form_input($tgl_mulai_attr) ?>
            <p class="help-block"><?php echo form_error('tgl_mulai') ?></p>
        </div>
    </div>
	<div class="control-group">
        <?= form_label('Tanggal' . required(), 'tgl_akhir', $control_label); ?>
		<div class="controls">
            <?= form_input($tgl_akhir_attr) ?>
            <p class="help-block"><?php echo form_error('tgl_akhir') ?></p>
        </div>
    </div>
    <div class="form-actions well">
        <button class="btn btn-small btn-primary" type="submit">Simpan</button>
    </div>
    <script type="text/javascript">
    function changeAngkatan(){
        var angkatan_id = $('#angkatan_id').val();
		$('#program_studi_id').html('');
		$('#mata_kuliah_id').html('');
		$('#pertemuan_id').html('');
		//alert(angkatan_id);
		$.post('<?php echo $opt_angkatan_url; ?>',{angkatan_id: angkatan_id },
        function(data){
			$('#tahun_akademik_id_attr').val(data);
        });
        $.post('<?php echo $opt_program_studi_url; ?>',{angkatan_id: angkatan_id },
        function(data){
			$("select[name='program_studi_id']").closest("div.controls").append("<select id='program_studi_id' name='program_studi_id' onChange='programStudiChange()'></select>");
            $("select[name='program_studi_id']").closest("div.combobox-container").remove();
            $("select[name='program_studi_id']").html(data).combobox();
			$('#mata_kuliah_id').html('');
			$('#pertemuan_id').html('');
        });
    }
	function programStudiChange(){
        var angkatan_id = $('#angkatan_id').val();
        var program_studi_ids = parseInt(' '+$('#program_studi_id').val(), 10);
		var program_studi_id = program_studi_ids;
		//alert(program_studi_id);
		var semester_id = $('#semester_id').val();
		if(program_studi_id<=0) return;
        $.post('<?php echo $opt_mata_kuliah_url; ?>',{angkatan_id: angkatan_id,
					semester_id:semester_id, program_studi_id: program_studi_id},
        function(data){
			$("select[name='mata_kuliah_id']").closest("div.controls").append("<select id='mata_kuliah_id' name='mata_kuliah_id'></select>");
            $("select[name='mata_kuliah_id']").closest("div.combobox-container").remove();
            $("select[name='mata_kuliah_id']").html(data).combobox();
        });
    }
</script>
    <?php form_close() ?>
</div>
<?php $this->load->view('_shared/footer'); ?>