<?php
$control_label = array(
    'class' => 'control-label'
);
$tahun_akademik_id_attr = array(
    'id' => 'tahun_akademik_id_attr',
	'name' => 'tahun_akademik_id_attr',
    'class' => 'input-small',
	'readonly' => 'readonly',
    'value' => set_value('tahun_akademik_id_attr', ''),
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
			<?= form_dropdown('semester_id', $semester_options, set_value('semester_id', $semester_id), 'id="semester_id" onChange="programStudiChange()" class="input-medium" prevData-selected="' . set_value('semester_id', $semester_id) . '"'); ?>
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
        <?= form_label('Nilai'. required(), 'mata_kuliah_id', $control_label); ?>
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
		$('#listMahasiswa').html('');
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
        });
    }
</script>