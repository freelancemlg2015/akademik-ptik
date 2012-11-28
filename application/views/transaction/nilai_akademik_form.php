<?php
$this->load->view('_shared/header');
$this->load->view('_shared/menus');

//label
$control_label = array(
    'class' => 'control-label'
);
?>

<div class="container-full" id="nilai_akademik">
    <?php echo form_open($action_url, array('class' => 'form-horizontal')); ?>
	<?php $this->load->view('transaction/header_select_transaction_nilai'); ?>
	
    <input type="hidden" id="tahun_akademik_ids" name="tahun_akademik_ids" />
    <input type="hidden" id="angkatan_ids" name="angkatan_ids" />
    <input type="hidden" id="semester_ids" name="semester_ids" />
    <input type="hidden" id="program_studi_ids" name="program_studi_ids" />
    <input type="hidden" id="mata_kuliah_ids" name="mata_kuliah_ids" />
    <table class="table table-bordered table-striped container-full" >
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
		var pertemuan_id = $('#pertemuan_id').val();
		var program_studi_id = $('#program_studi_id').val();
		var mata_kuliah_id = $('#mata_kuliah_id').val();
		var semester_id = $('#semester_id').val();
		var mode = 'edit';
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