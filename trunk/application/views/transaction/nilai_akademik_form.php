<?php
$this->load->view('_shared/header');
$this->load->view('_shared/menus');

//label
$control_label = array(
    'class' => 'control-label'
);
?>
<?= form_open($action_url, array('class' => 'form-horizontal')); ?>      
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
            <?= form_dropdown('semester', $opt_semester, '', 'id="semester"') ?>
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

    <div class="control-group">
        <?= form_label('Mata Kuliah', 'mata_kuliah', $control_label); ?>
        <div class="controls">
            <?= form_dropdown('mata_kuliah', array(), '', 'id="mata_kuliah" onChange=getMahasiswa()') ?>
            <p class="help-block"><?php echo form_error('mata_kuliah') ?></p>
        </div>
    </div>
    <?php echo form_close() ?>
    <?= form_open($action_url, array('class' => 'form-horizontal', 'id' => 'formNilai')); ?>            
    <input type="hidden" id="tahun_akademik_id" name="tahun_akademik_id" />
    <input type="hidden" id="angkatan_id" name="angkatan_id" />
    <input type="hidden" id="semester_id" name="semester_id" />
    <input type="hidden" id="program_studi_id" name="program_studi_id" />
    <input type="hidden" id="mata_kuliah_id" name="mata_kuliah_id" />
    <table class="table table-bordered table-striped container-full data_list" >
        <thead class="table table-bordered span4">
            <tr class="table-bordered span4">
                <th rowspan='2' style="width:20px">No.</th>
                <th rowspan='2' style="width:80px">NIM</th>
                <th rowspan='2' >Nama</th>
                <th colspan='4' style="">Nilai</th>

            </tr>
            <tr>
                <th style="width:80px">Tengah Sms</th>
                <th style="width:80px">Tugas</th>
                <th style="width:80px">Akhir Sms</th>
                <th style="width:80px">Perbaikan</th>
            </tr>
        </thead>
        <tbody id="listMahasiswa">
			<tr><td colspan="9">&nbsp;</td></tr>
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
        $.post('<?php echo $opt_program_studi_url; ?>',{tahun_akademik_id: tahun_akademik,angkatan_id: angkatan_id },
        function(data){
            $('#program_studi').html(data);
            
        });
    }
    
    function programStudiChange(){
        var angkatan_id = $('#angkatan').val();
        var program_studi_id = $('#program_studi').val();
        $.post('<?php echo $opt_mata_kuliah_url; ?>',{program_studi_id: program_studi_id,angkatan_id: angkatan_id },
        function(data){
            $('#mata_kuliah').html(data);            
        });
    }
    
    function getMahasiswa(){
        var mata_kuliah_id = $('#mata_kuliah').val();
        var angkatan_id = $('#angkatan').val();
        var program_studi_id = $('#program_studi').val();
        var tahun_akademik_id= $('#tahun_akademik').val();
		var semester_id = $('#semester').val();
		
		$('#tahun_akademik_id').val(tahun_akademik_id)
		$('#angkatan_id').val(angkatan_id)
		$('#semester_id').val(semester_id)
		$('#program_studi_id').val(program_studi_id)
		$('#mata_kuliah_id').val(mata_kuliah_id)
        if(mata_kuliah_id!='' & angkatan_id!='' & program_studi_id !='' & tahun_akademik_id !='' ) $.post('<?php echo $Mahasiswa_list_url; ?>',{program_studi_id: program_studi_id,angkatan_id: angkatan_id, mata_kuliah_id :mata_kuliah_id,tahun_akademik_id: tahun_akademik_id },
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