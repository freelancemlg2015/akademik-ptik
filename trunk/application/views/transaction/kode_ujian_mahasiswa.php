<?php
$this->load->view('_shared/header');
$this->load->view('_shared/menus');

//label
$control_label = array(
    'class' => 'control-label'
);
$action_url =''
?>
<?= form_open($action_url, array('class' => 'form-horizontal')); ?>
<?php $this->load->view('transaction/header_select_transaction_kode_ujian_mahasiswa'); ?>   
<div class="container-full" id="nilai_fisik-search">
    <?php echo form_close() ?>    
    <table class="table table-bordered table-striped container-full" id="nilai_fisik" controller="transaction">
        <thead class="table table-bordered span4">
            <tr class="table-bordered span4">
                <th style="width:20px">No.</th>
                <th style="width:80px">NIM</th>
                <th>Nama</th>
                <th style="width:80px">Kode Ujian</th>
            </tr>
        </thead>
        <tbody id="listMahasiswa">
			<tr><td colspan="4">&nbsp;</td></tr>
        </tbody>
    </table>
</div>
<?php $this->load->view('_shared/footer'); ?>
<script type="text/javascript">
	function mataKuliahChange(){
		///alert('wq'); return;
		$('#listMahasiswa').hide();
		//$('#listMahasiswa').show();
		if($('#pertemuan_id').val()<=0) return;
		var tahun_akademik = $('#tahun_akademik_id').val();
        var angkatan_id = $('#angkatan_id').val();
		var program_studi_id = $('#program_studi_id').val();
		var mata_kuliah_id = $('#mata_kuliah_id').val();
		var semester_id = $('#semester_id').val();
		var mode = 'view';
		//alert(pertemuan_id); 
        $.post('<?php echo $opt_data_mahasiswa_url; ?>',{tahun_akademik_id: tahun_akademik,angkatan_id: angkatan_id,
					semester_id:semester_id,
					program_studi_id: program_studi_id,mata_kuliah_id: mata_kuliah_id, mode: mode},
        function(data){
            $('#listMahasiswa').html(data);
			$('#listMahasiswa').show();
        });
    }
</script>