<?php
$this->load->view('_shared/header');
$this->load->view('_shared/menus');
$control_label = array(
    'class' => 'control-label'
);
$action_url =''
?>
<?= form_open($action_url, array('class' => 'form-horizontal')); ?>   
<div class="container-full" id="nilai_akademik-search">
    <?php
    $nim_attr = array(
        'id' => 'nim',
        'name' => 'nim',
        'class' => 'input-medium',
        'style' => 'text-transform : uppercase;',
        'placeholder' => 'Nim'
    );
    $nama_mata_kuliah_attr = array(
        'id' => 'nama_mata_kuliah',
        'name' => 'nama_mata_kuliah',
        'class' => 'input-medium',
        'style' => 'text-transform : uppercase;',
        'placeholder' => 'Mata Kuliah'
    );
    //echo form_open('transaction/nilai_akademik/search/') .
    //form_input($nim_attr) . ' ' .
    //form_input($nama_mata_kuliah_attr) . ' ' .
    //form_submit('cari', 'CARI', 'class="btn btn-mini"') .
    //form_close();
    ?>
	
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
	
</div>
<?php echo form_close() ?>
<?php if ($pagination): ?>
    <div class="container">
        <div class="pagination pagination-centered">
            <?php echo $pagination; ?>
        </div>
    </div>
<?php endif; ?>

<table class="table table-bordered table-striped container-full data_list" id="nilai_akademik" controller="transaction">
    <thead class="table table-bordered span4">
		<tr class="table-bordered span4">
			<th rowspan='2' style="width:20px">No.</th>
			<th rowspan='2' style="width:80px">NIM</th>
			<th rowspan='2' >Nama</th>
			<th colspan='4' style="">Nilai</th>
			<th colspan='2' style="">Nilai Akhir</th>

		</tr>
		<tr>
			<th style="width:80px">Tengah Sms</th>
			<th style="width:80px">Tugas</th>
			<th style="width:80px">Akhir Sms</th>
			<th style="width:80px">Perbaikan</th>
			<th style="width:80px">Angka</th>
			<th style="width:80px">Huruf</th>
		</tr>
	</thead>
    <tbody id="listMahasiswa">
			<tr><td colspan="9">&nbsp;</td></tr>
    </tbody>
</table>

<?php if ($pagination): ?>
    <div class="container">
        <div class="pagination pagination-centered">
            <?php echo $pagination; ?>
        </div>
    </div>
<?php endif; ?>
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
	
		
        if(mata_kuliah_id!='' & angkatan_id!='' & program_studi_id !='' & tahun_akademik_id !='' ) $.post('<?php echo $Mahasiswa_list_url; ?>',{program_studi_id: program_studi_id,angkatan_id: angkatan_id, mata_kuliah_id :mata_kuliah_id,tahun_akademik_id: tahun_akademik_id,mode:'view' },
        function(data){
            $('#listMahasiswa').html(data);
            /*$('#formNilai').submit(function(){
				return false;
			})*/
        });
    }
	
	
	
    
</script>

<?php $this->load->view('_shared/footer'); ?>