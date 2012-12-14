<?php
$control_label = array(
    'class' => 'control-label'
);
$tahun_akademik_id_attr = array(
    'id' => 'tahun_akademik_id_attr',
	'name' => 'tahun_akademik_id_attr',
    'class' => 'input-small',
	'readonly' => 'readonly',
    'value' => set_value('tahun_akademik_id_attr', $tahun_akademik_id_attr),
    'autocomplete' => 'off'
);
?>
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
			<?= form_dropdown('semester_id', $semester_options, set_value('semester_id', $semester_id), 'id="semester_id" onChange="changeSemester()" class="input-medium" prevData-selected="' . set_value('semester_id', $semester_id) . '"'); ?>
            <p class="help-block"><?php echo form_error('semester_id') ?></p>
        </div>
    </div>
    <div class="control-group">
        <?= form_label('Konsentrasi Studi'. required(), 'program_studi_id', $control_label); ?>
        <div class="controls">
			<?= form_dropdown('program_studi_id', $data_program_studi, '', 'id="program_studi_id" onChange="programStudiChange()" class="input-medium" prevData-selected="' . set_value('program_studi', 1) . '"'); ?>
            <p class="help-block"><?php echo form_error('program_studi_id') ?></p>
        </div>
    </div>
    <div class="control-group">
        <?= form_label('Mata Kuliah'. required(), 'mata_kuliah_id', $control_label); ?>
        <div class="controls">
            <?= form_dropdown('mata_kuliah_id', $data_mata_kuliah, '', 'id="mata_kuliah_id" onChange="mataKuliahChange()" class="input-medium" prevData-selected="' . set_value('mata_kuliah_id', 0) . '"'); ?>
            <p class="help-block"><?php echo form_error('mata_kuliah_id') ?></p>
        </div>
    </div>

<script type="text/javascript">
    function changeAngkatan(){
        var angkatan_id = $('#angkatan_id').val();
		$('#program_studi_id').html('');
		$('#mata_kuliah_id').html('');
		$('#pertemuan_id').html('');
		$('#semester_id').html('');
		//alert(angkatan_id);
		var datas = null;
		$('#mata_kuliah_id').val('');
		$('#mata_kuliah_id option').each(function() { 
			$(this).removeAttr('selected')
		});
		$.post('<?php echo $opt_angkatan_url; ?>',{angkatan_id: angkatan_id },
        function(data){
			$('#tahun_akademik_id_attr').val(data);
        });
		$('#semester_id').html('');
		$.post('<?php echo $opt_semester_url; ?>',{angkatan_id: angkatan_id },
		function(data){
			$("select[name='semester_id']").closest("div.controls").append("<select id='semester_id' name='semester_id' onChange='changeSemester()'></select>");
			$("select[name='semester_id']").closest("div.combobox-container").remove();
			$("select[name='semester_id']").html(data).combobox();
		});
		$('#program_studi_id').html('');
		$('#mata_kuliah_id').html('');
		$('#pertemuan_id').html('');
    }
	function changeSemester(){
        var angkatan_id = $('#angkatan_id').val();
		var semester_id = $('#semester_id').val();
		$('#program_studi_id').html('');
		$('#mata_kuliah_id').html('');
		$('#pertemuan_id').html('');
		//$('#semester_id').html('');
		//alert(angkatan_id);
		$.post('<?php echo $opt_program_studi_url; ?>',{angkatan_id: angkatan_id, semester_id:semester_id },
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
		var jenis_nilai = 0;
		//alert(program_studi_id);
		var semester_id = $('#semester_id').val();
		$('#mata_kuliah_id').html('');
		$('#pertemuan_id').html('');
		if(semester_id<=0) {
			$('#program_studi_id').html('');
			$('#mata_kuliah_id').html('');
			$('#pertemuan_id').html('');
			alert('semester can not be null');
			return;
		}
        $.post('<?php echo $opt_mata_kuliah_url; ?>',{angkatan_id: angkatan_id,
					semester_id:semester_id, program_studi_id: program_studi_id, jenis_nilai:jenis_nilai},
        function(data){
			$("select[name='mata_kuliah_id']").closest("div.controls").append("<select id='mata_kuliah_id' name='mata_kuliah_id' onChange='mataKuliahChange()'></select>");
            $("select[name='mata_kuliah_id']").closest("div.combobox-container").remove();
            $("select[name='mata_kuliah_id']").html(data).combobox();
        });
    }
	function mataKuliahChange(){
		//alert('mataKuliahChange'); return;
		$('#listMahasiswa').hide();
		//if($('#mata_kuliah_id').val()<=0) return;
        var angkatan_id = $('#angkatan_id').val();
		var semester_id = $('#semester_id').val();
		var program_studi_ids = parseInt(' '+$('#program_studi_id').val(), 10);
		var program_studi_id = program_studi_ids;
		//alert(program_studi_id);
		var mata_kuliah_id = $('#mata_kuliah_id').val();
		if(program_studi_id<=0) return;
		if(semester_id<=0) return;
        $.post('<?php echo $opt_data_jadwal_url; ?>',{angkatan_id: angkatan_id,
					semester_id:semester_id, program_studi_id: program_studi_id,mata_kuliah_id: mata_kuliah_id},
        function(data){
            $('#pertemuan_id').html(data);
			$('#listMahasiswa').html('');
        });
    }
</script>