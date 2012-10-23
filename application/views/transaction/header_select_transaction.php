<?php
$control_label = array(
    'class' => 'control-label'
);
?>
    <div class="control-group">
        <?= form_label('Angkatan'. required(), 'angkatan_id', $control_label); ?>
        <div class="controls">
			<?= form_dropdown('angkatan_id', $angkatan_options, set_value('angkatan_id', $angkatan_id), 'id="angkatan_id" onChange="changeAngkatan()" class="input-medium" prevData-selected="' . set_value('angkatan_id', $angkatan_id) . '"') . '&nbsp;'; ?>
            <p class="help-block"><?php echo form_error('angkatan_id') ?></p>
        </div>
    </div>  
    <div class="control-group">
        <?= form_label('Tahun Akademik'. required(), 'tahun_akademik_id', $control_label); ?>
        <div class="controls">
			<?= form_dropdown('tahun_akademik_id', $tahun_akademik_options, set_value('tahun_akademik_id', $tahun_akademik_id), 'id="tahun_akademik_id" onChange="programStudiChange()" class="input-medium" prevData-selected="' . set_value('tahun_akademik_id', $tahun_akademik_id) . '"') . '&nbsp;'; ?>
            <p class="help-block"><?php echo form_error('tahun_akademik_id') ?></p>
        </div>
    </div>
    <div class="control-group">
        <?= form_label('Semester'. required(), 'semester_id', $control_label); ?>
        <div class="controls">
			<?= form_dropdown('semester_id', $semester_options, set_value('semester_id', $semester_id), 'id="semester_id" onChange="programStudiChange()" class="input-medium" prevData-selected="' . set_value('semester_id', $semester_id) . '"') . '&nbsp;'; ?>
            <p class="help-block"><?php echo form_error('semester_id') ?></p>
        </div>
    </div>
    <div class="control-group">
        <?= form_label('Konsentrasi Studi'. required(), 'program_studi_id', $control_label); ?>
        <div class="controls">
			<?= form_dropdown('program_studi', $data_program_studi, '', 'id="program_studi" onChange="programStudiChange()" class="input-medium" prevData-selected="' . set_value('program_studi', 1) . '"') . '&nbsp;'; ?>
            <p class="help-block"><?php echo form_error('program_studi') ?></p>
        </div>
    </div>

    <div class="control-group">
        <?= form_label('Mata Kuliah'. required(), 'mata_kuliah', $control_label); ?>
        <div class="controls">
            <?= form_dropdown('mata_kuliah', $data_mata_kuliah, '', 'id="mata_kuliah" ') ?>
            <p class="help-block"><?php echo form_error('mata_kuliah') ?></p>
        </div>
    </div>

<script type="text/javascript">
    function changeAngkatan(){
        var tahun_akademik = $('#tahun_akademik_id').val();
        var angkatan_id = $('#angkatan_id').val();
		//alert(angkatan_id);
        $.post('<?php echo $opt_program_studi_url; ?>',{tahun_akademik_id: tahun_akademik,angkatan_id: angkatan_id },
        function(data){
            $('#program_studi').html(data);
			$('#mata_kuliah').html('');
            
        });
    }
	function changeTahunAkademik(){
        var tahun_akademik = $('#tahun_akademik_id').val();
        var angkatan_id = $('#angkatan_id').val();
        $.post('<?php echo $opt_program_studi_url; ?>',{tahun_akademik_id: tahun_akademik,angkatan_id: angkatan_id },
        function(data){
            $('#program_studi').html(data);
			$('#mata_kuliah').html('');
        });
    }
	function programStudiChange(){
        var angkatan_id = $('#angkatan_id').val();
        var program_studi_id = $('#program_studi').val();
		var semester_id = $('#semester_id').val();
		var tahun_akademik = $('#tahun_akademik_id').val();
        $.post('<?php echo $opt_mata_kuliah_url; ?>',{tahun_akademik_id: tahun_akademik,angkatan_id: angkatan_id,
					semester_id:semester_id, program_studi_id: program_studi_id},
        function(data){
            $('#mata_kuliah').html(data);
        });
    }
</script>