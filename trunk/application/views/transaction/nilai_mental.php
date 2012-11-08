<?php
$this->load->view('_shared/header');
$this->load->view('_shared/menus');

//label
$control_label = array(
    'class' => 'control-label'
);
?>
<?= form_open('#', array('class' => 'form-horizontal')); ?>      
<div class="container-full" id="nilai_akademik">    
    <div class="control-group">
        <?= form_label('Angkatan', 'angkatan', $control_label); ?>
        <div class="controls">
            <?= form_dropdown('angkatan', $angkatans, '', ' id="angkatan" onChange=\'changeAngkatan()\''); ?>
            <p class="help-block"><?php echo form_error('angkatan') ?></p>
        </div>
    </div>  


    <div class="control-group">
        <?= form_label('Tahun Akademik', 'tahun_akademik', $control_label); ?>
        <div class="controls">
            <?= form_dropdown('tahun_akademik', $opt_tahun_akademik, '', 'id="tahun_akademik" ') ?>
            <p class="help-block"><?php echo form_error('tahun_akademik') ?></p>
        </div>
    </div>

    <div class="control-group">
        <?= form_label('Semester', 'semester', $control_label); ?>
        <div class="controls">
            <?= form_dropdown('semester', $opt_semester, '', 'id="semester" onChange=\'semesterChange()\'') ?>
            <p class="help-block"><?php echo form_error('semester') ?></p>
        </div>
    </div>
	<div class="control-group">
        <?= form_label('Program Studi', 'program_studi', $control_label); ?>
        <div class="controls">
            <?= form_dropdown('program_studi', array(), '', 'id="program_studi" onChange=\'programStudiChange()\''); ?>
            <p class="help-block"><?php echo form_error('program_studi') ?></p>
        </div>
    </div>
    <?php echo form_close() ?>
    <?= form_open('#', array('class' => 'form-horizontal', 'id' => 'formNilai')); ?>            
    <table class="table table-bordered table-striped container-full data_list" >
        <thead class="table table-bordered span4">
            <tr class="table-bordered span4">
                <th style="width:20px">No.</th>
                <th style="width:80px">NIM</th>
                <th>Nama</th>
                <th style="width:80px">Nilai</th>

            </tr>
        </thead>
        <tbody id="listMahasiswa">
			<tr><td colspan="4">&nbsp;</td></tr>
        </tbody>
    </table>
    <?php echo form_close() ?>
	<div class="form-actions well">
        <button class="btn btn-small btn-primary" onClick="submitNilai(); return false;">Simpan</button>
    </div>
</div>
<script>
    function changeTahunAkademik(){
        var tahun_akademik = $('#tahun_akademik').val();
        var angkatan_id = $('#angkatan').val();
        $.post('<?php echo $opt_program_studi_url; ?>',{tahun_akademik_id: tahun_akademik,angkatan_id: angkatan_id },
        function(data){
            $('#program_studi').html(data);
            
        });
    }
    
    function changeAngkatan(){
        var tahun_akademik = $('#tahun_akademik').val();
        var angkatan_id = $('#angkatan').val();
		//alert(angkatan_id);
        $.post('<?php echo $opt_program_studi_url; ?>',{tahun_akademik_id: tahun_akademik,angkatan_id: angkatan_id },
        function(data){
            $('#program_studi').html(data);
            
        });
    }
	
	function semesterChange(){
		getMahasiswa();
	}
    
    function programStudiChange(){
        getMahasiswa();
    }
    
    function getMahasiswa(){
        var angkatan_id = $('#angkatan').val();
        var program_studi_id = $('#program_studi').val();
        var tahun_akademik_id= $('#tahun_akademik').val();
		var semester_id = $('#semester').val();
		
		$('#tahun_akademik_id').val(tahun_akademik_id)
		$('#angkatan_id').val(angkatan_id)
		$('#semester_id').val(semester_id)
		$('#program_studi_id').val(program_studi_id)
        if( angkatan_id!='' & program_studi_id !='' & tahun_akademik_id !='' & semester_id !='') $.post('<?php echo $Mahasiswa_list_url; ?>',{program_studi_id: program_studi_id,angkatan_id: angkatan_id, tahun_akademik_id: tahun_akademik_id, semester : semester_id, mode : 'view' },
        function(data){
            $('#listMahasiswa').html(data);
            /*$('#formNilai').submit(function(){
				return false;
			})*/
        });
    }
	
	function submitNilai(){
		var data_nilai = $('#formNilai').serializeArray();
		$.post('<?php echo $submit_url; ?>',data_nilai,function(data){
			
		});
		//alert('formNilai submit');
		return false;
	}
	
    
</script>
<?php $this->load->view('_shared/footer'); ?>