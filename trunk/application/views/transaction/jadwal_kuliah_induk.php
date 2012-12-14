<?php
$this->load->view('_shared/header');
$this->load->view('_shared/menus');
$action_url='';
?>
<script type="text/javascript">
	function mataKuliahChange(){
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
		var mode = 'view';
		//alert(pertemuan_id); 
        $.post('<?php echo $opt_data_mahasiswa_url; ?>',{angkatan_id: angkatan_id,
					pertemuan_id: pertemuan_id, semester_id:semester_id,
					program_studi_id: program_studi_id,mata_kuliah_id: mata_kuliah_id, mode: mode},
        function(data){
            $('#listMahasiswa').html(data);
			$('#listMahasiswa').show();
        });
    }
</script>
<div class="container-fluid form-inline well" id="jadwal_kuliah_induk-search">
	<?php echo form_open($action_url, array('class' => 'form-horizontal')); ?>
	<?php $this->load->view('transaction/header_select_transaction'); ?>
    <?php
    $nama_dosen_attr = array(
        'id' => 'nama_dosen', //yg ini masih rancu dosen apa mata kuliah
        'name' => 'nama_dosen',
        'class' => 'input-medium',
        'style' => 'text-transform : uppercase;',
        'placeholder' => 'Nama Mata Kuliah'
    );
    $nama_ruang_attr = array(
        'id' => 'nama_ruang',
        'name' => 'nama_ruang',
        'class' => 'input-medium',
        'style' => 'text-transform : uppercase;',
        'placeholder' => 'Nama Ruang'
    );
    echo form_open('transaction/jadwal_kuliah_induk/search/') .
    form_input($nama_dosen_attr) . ' ' .
    form_input($nama_ruang_attr) . ' ' .
    form_submit('cari', 'CARI', 'class="btn btn-mini"') .
    form_close();
    ?>
</div>

<?php if ($pagination): ?>
    <div class="container">
        <div class="pagination pagination-centered">
            <?php echo $pagination; ?>
        </div>
    </div>
<?php endif; ?>

<table class="table table-bordered table-striped container-full data_list" id="jadwal_kuliah_induk" controller="transaction">
    <thead>
        <tr>
            <th>Mata Kuliah</th>
            <th>Hari / Jam</th>
            <th>Pelaksanaan Kuliah</th>
        </tr>
    </thead>
    <tbody id="listMahasiswa">
		<tr><td colspan="4">&nbsp;</td></tr>
	</tbody>
	<div class="control-group" id="data-sub-form" style="display:none"></div>
</table>

<?php if ($pagination): ?>
    <div class="container">
        <div class="pagination pagination-centered">
            <?php echo $pagination; ?>
        </div>
    </div>
<?php endif; ?>

<?php $this->load->view('_shared/footer'); ?>