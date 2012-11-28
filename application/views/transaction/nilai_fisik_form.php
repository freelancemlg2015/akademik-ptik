<?php
$this->load->view('_shared/header');
$this->load->view('_shared/menus');

//label
$control_label = array(
    'class' => 'control-label'
);
?>
<div class="container-full" id="nilai_fisik">
    <?php echo form_open($action_url, array('class' => 'form-horizontal')); ?>
	<?php $this->load->view('transaction/header_select_transaction_nilai_fisik'); ?>
	           
    <input type="hidden" id="tahun_akademik_ids" name="tahun_akademik_ids" />
    <input type="hidden" id="angkatan_ids" name="angkatan_ids" />
    <input type="hidden" id="semester_ids" name="semester_ids" />
    <input type="hidden" id="program_studi_ids" name="program_studi_ids" />
    <table class="table table-bordered table-striped container-full" >
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
</div>
<?php $this->load->view('_shared/footer'); ?>
<script type="text/javascript">
    function programStudiChange(){
        $('#pertemuan_id').html('');
		$('#listMahasiswa').html('');
		$('#mata_kuliah_id').html('');
		var angkatan_id = $('#angkatan_id').val();
        var program_studi_ids = parseInt(' '+$('#program_studi_id').val(), 10);
		var program_studi_id = program_studi_ids;
		var jenis_nilai = 1;
		var semester_id = $('#semester_id').val();
		if(program_studi_id<=0) return;
        $.post('<?php echo $opt_mata_kuliah_url; ?>',{angkatan_id: angkatan_id,
					semester_id:semester_id, program_studi_id: program_studi_id, jenis_nilai: jenis_nilai},
        function(data){
			$("select[name='mata_kuliah_id']").closest("div.controls").append("<select id='mata_kuliah_id' name='mata_kuliah_id' onchange='mataKuliahChange()'></select>");
            $("select[name='mata_kuliah_id']").closest("div.combobox-container").remove();
            $("select[name='mata_kuliah_id']").html(data).combobox();
        });
    }
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