<?php
$this->load->view('_shared/header');
$this->load->view('_shared/menus');

//label
$control_label = array(
    'class' => 'control-label'
);

$keterangan_attr = array(
    'name' => 'keterangan',
    'class' => 'span3',
    'value' => set_value('keterangan', $keterangan),
    'autocomplete' => 'off'    
);

$angkatan_data[0] = '';
foreach ($angkatan_options as $row) {
    $angkatan_data[$row->id.'-'.$row->tahun_akademik_id] = $row->nama_angkatan;
}

$tahun_data[0] = '';
if (isset($m_tahun_akademik)){
    foreach ($m_tahun_akademik as $row) {
        $tahun_data[$row['id']] = $row['tahun_ajar_mulai'].'-'.$row['tahun_ajar_akhir'];
    }    
} 
else {
    $tahun_data[''] = '';
}

if (isset($m_angkatan->tahun_akademik_id)){
    $thn_akademik_id = $m_angkatan->tahun_akademik_id;
}
else {
    $thn_akademik_id = '';
}

$plot_mata_kuliah_data[0] = '';
foreach ($plot_mata_kuliah_options as $row) {
    $plot_mata_kuliah_data[$row['id'].'-'.$row['semester_id']] = $row['nama_semester'];
}

$program_studi_data[0] = '';
foreach ($program_studi_options as $row) {
    $program_studi_data[$row->id] = $row->nama_program_studi;
}

$thn_akademik_id_attr = array(
    'id' => 'thn_akademik_id_attr',
    'name' => 'tahun_akademik_id',
    'class' => 'input-small',
    'readonly' => 'readonly',
    'value' => set_value('tahun_akademik_id', ''),
    'autocomplete' => 'off'
);



?>
<div class="container-full" id="paket_matakuliah">
<?= form_open($action_url, array('class' => 'form-horizontal')); ?>

    <div class="control-group">
        <?= form_label('Angkatan' . required(), 'angkatan_id', $control_label); ?>
        <div class="controls">
            <?= form_dropdown('angkatan_id', $angkatan_data, set_value('angkatan_id', $angkatan_id."-".$thn_akademik_id), 'onChange="changeAngkatan()" id="angkatan_id" class="input-medium" prevData-selected="' . set_value('angkatan_id', $angkatan_id) . '"'); ?>
            <p class="help-block"><?php echo form_error('angkatan_id') ?></p>
        </div>
    </div>

    <div class="control-group">
        <?= form_label('Tahun Akademik' , 'thn_akademik_id', $control_label); ?>
        <div class="controls">
            <?= form_input($thn_akademik_id_attr); ?>
            <p class="help-block"><?php echo form_error('thn_akademik_id') ?></p>
        </div>
    </div>

    <div class="control-group">
        <?= form_label('Semester' , 'plot_mata_kuliah_id', $control_label); ?>
        <div class="controls">
            <?= form_dropdown('plot_mata_kuliah_id', $plot_mata_kuliah_data, set_value('plot_mata_kuliah_id', $plot_mata_kuliah_id), 'id="plot_mata_kuliah_id" class="input-medium" prevData-selected="' . set_value('plot_mata_kuliah_id', $plot_mata_kuliah_id) . '"'); ?>
            <p class="help-block"><?php echo form_error('plot_mata_kuliah_id') ?></p>
        </div>
    </div>
    
    <div class="control-group">
        <?= form_label('Program Studi' , 'program_studi_id', $control_label); ?>
        <div class="controls">
        <?= form_dropdown('program_studi_id', $program_studi_data, set_value('program_studi_id', $program_studi_id), 'id="program_studi_id" class="input-medium" prevData-selected="' . set_value('program_studi_id', $program_studi_id) . '"'); ?>
            <p class="help-block"><?php echo form_error('program_studi_id') ?></p>
        </div>
    </div>
    
    <div class="control-group">
        <fieldset>
            <legend>Pilih Kelompok Mata Kuliah</legend>
            <label class="control-label" for=""></label>
            <div class="controls">
                <?= form_dropdown('span_kelompok') ?>
            </div>
        </fieldset>
    </div>
    
    <div class="form-actions well">
        <button class="btn btn-small btn-primary" type="submit">Simpan</button>
    </div>
<?php form_close() ?>
</div>
    <?php $this->load->view('_shared/footer'); ?>

<script type="text/javascript">
    /*$("#angkatan_id").change(function(){
        var value = ($(this).val()).split("-");
        $.post('<?php //echo base_url(); ?>paket_matakuliah/getOptTahunAkademik', {angkatan_id: value[1]},
        function(data){                                                                 
            $("select[name='span_tahun']").closest("div.controls").append("<select name='span_tahun'></select>");
            $("select[name='span_tahun']").closest("div.combobox-container").remove();
            $("select[name='span_tahun']").html(data).combobox();
        });
    })                                         
    $("select[name='span_tahun']").combobox();*/

    function changeAngkatan(){
        var angkatan_id = ($('#angkatan_id').val()).split("-");;
		//alert(angkatan_id);
	$.post('<?php echo base_url(); ?>paket_matakuliah/getOptTahunAkademik', {angkatan_id: angkatan_id[1]},
        function(data){
            $('#thn_akademik_id_attr').val(data);
        });
    }  

    $("#plot_mata_kuliah_id").change(function(){
        var value = ($(this).val()).split("-");
        $.post('<?php echo base_url(); ?>paket_matakuliah/getOptPlotmatakuliah', {plot_mata_kuliah_id: value[1]},
        function(data){                                                                 
            $("select[name='span_kelompok']").closest("div.controls").append("<select name='span_kelompok'></select>");
            $("select[name='span_kelompok']").closest("div.combobox-container").remove();
            $("select[name='span_kelompok']").html(data).combobox();
        });
    })                                         
    $("select[name='span_kelompok']").combobox();
    
    /*$("#plot_mata_kuliah_id").change(function(){
        var value = ($(this).val()).split("-");
        $.post('<?php //echo base_url(); ?>paket_matakuliah/getOptPlotmatakuliah', {plot_mata_kuliah_id: value[1]},
        function(data){
              $("input[name='span_kelompok']").closest("div.controls").append("<input type='checkbox' name='span_kelompok'>");
              //$("input[name='span_kelompok']").closest("div.controls").remove();
              $("input[name='span_kelompok']").html(data);
        });
    })*/ 
</script>
