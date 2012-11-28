<?php
$this->load->view('_shared/header');
$this->load->view('_shared/menus');
$control_label = array(
    'class' => 'control-label'
);
$action_url =''
?>
<?= form_open($action_url, array('class' => 'form-horizontal')); ?>
<?php $this->load->view('transaction/header_select_transaction_nilai'); ?>
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
	?>
</div>
<?php echo form_close() ?>

<table class="table table-bordered table-striped container-full" id="nilai_akademik" controller="transaction">
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
<?php $this->load->view('_shared/footer'); ?>
<script type="text/javascript">
    function mataKuliahChange(){
		///alert('wq'); return;
		$('#listMahasiswa').hide();
		//$('#listMahasiswa').show();
		if($('#pertemuan_id').val()<=0) return;
		var tahun_akademik = $('#tahun_akademik_id').val();
        var angkatan_id = $('#angkatan_id').val();
		var pertemuan_id = $('#pertemuan_id').val();
		var program_studi_id = $('#program_studi_id').val();
		var mata_kuliah_id = $('#mata_kuliah_id').val();
		var semester_id = $('#semester_id').val();
		var mode = 'view';
		//alert(pertemuan_id); 
        $.post('<?php echo $opt_data_mahasiswa_url; ?>',{tahun_akademik_id: tahun_akademik,angkatan_id: angkatan_id,
					pertemuan_id: pertemuan_id, semester_id:semester_id,
					program_studi_id: program_studi_id,mata_kuliah_id: mata_kuliah_id, mode: mode},
        function(data){
            $('#listMahasiswa').html(data);
			$('#listMahasiswa').show();
        });
    }
</script>