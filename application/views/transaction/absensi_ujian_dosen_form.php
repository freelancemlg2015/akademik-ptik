<?php
$this->load->view('_shared/header');
$this->load->view('_shared/menus');

//label
$control_label = array(
    'class' => 'control-label'
);
?>
<div class="container-full" id="jadwal_kuliah">
    <?php echo form_open($action_url, array('class' => 'form-horizontal')); ?>
	<?php $this->load->view('transaction/header_select_transaction_jadwal_ujian'); ?>
	
	<div class="control-group">
        <?= form_label('Jenis Ujian' . required(), 'pertemuan_id', $control_label); ?>
        <div class="controls">
			<?= form_dropdown('pertemuan_id', array(), set_value('pertemuan_id', 0), 'onchange="get_data_mahasiswa()" id="pertemuan_id" class="input-medium" prevData-selected="' . set_value('jenis_ujian_id', 0) . '"') . '&nbsp;&nbsp;'; ?>
            <p class="help-block"><?php echo form_error('jenis_ujian_id') ?></p>
        </div>
    </div>
	
	<div class="control-group">
		<table class="table table-bordered table-striped container-full data_list" >
			<thead class="table table-bordered span4">
				<tr class="table-bordered span4">
					<th style="width:20px">No.</th>
					<th style="width:20%">No Karpeg</th>
					<th style="width:70%">Nama</th>
					<th >Status</th>
				</tr>
			</thead>
			<tbody id="listMahasiswa">
				<tr><td colspan="4">&nbsp;</td></tr>
			</tbody>
			<div class="control-group" id="data-sub-form" style="display:none"></div>
		</table>
	</div>
	
    
    <?php form_close() ?>
</div>
<?php $this->load->view('_shared/footer'); ?>
<script type="text/javascript">
	function get_data_mahasiswa(){
		//alert('wq'); return;
		$('#listMahasiswa').hide();
		//$('#listMahasiswa').show();
		if($('#pertemuan_id').val()<=0) return;
		//var tahun_akademik = $('#tahun_akademik_id').val();
        var angkatan_id = $('#angkatan_id').val();
		var pertemuan_id = $('#pertemuan_id').val();
		var program_studi_id = $('#program_studi_id').val();
		var mata_kuliah_id = $('#mata_kuliah_id').val();
		var semester_id = $('#semester_id').val();
		//alert(pertemuan_id); 
        $.post('<?php echo $opt_data_mahasiswa_url; ?>',{angkatan_id: angkatan_id,
					pertemuan_id: pertemuan_id, semester_id:semester_id,
					program_studi_id: program_studi_id,mata_kuliah_id: mata_kuliah_id},
        function(data){
            $('#listMahasiswa').html(data);
			$('#listMahasiswa').show();
        });
    }
</script>