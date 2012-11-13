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

if (isset($t_plot_mata_kuliah->semester_id)){
    $plot_semester_id = $t_plot_mata_kuliah->semester_id;
}
else {
    $plot_semester_id = '';
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
    'value' => set_value('tahun_akademik_id', $thn_akademik_id_attr),
    'autocomplete' => 'off'
);

print_r($plot_mata_kuliah_id."-".$plot_semester_id);

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
        <?= form_label('Semesters' , 'plot_mata_kuliah_id', $control_label); ?>
        <div class="controls">
            <?= form_dropdown('plot_mata_kuliah_id', $plot_mata_kuliah_data, set_value('plot_mata_kuliah_id', $plot_mata_kuliah_id."-".$plot_semester_id), 'onChange="changeKelompok()" id="plot_mata_kuliah_id" class="input-medium" prevData-selected="' . set_value('plot_mata_kuliah_id', $plot_mata_kuliah_id) . '"'); ?>
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
            <div id="listkelompok" class="controls">
            <?php           
                if(isset($plot_detail_checked)){
                    echo $plot_detail_checked;                    
                }        
            ?>    
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
    function changeAngkatan(){
        var angkatan_id = ($('#angkatan_id').val()).split("-");
		$.post('<?php echo base_url(); ?>paket_matakuliah/getOptTahunAkademik', {angkatan_id: angkatan_id[1]},
        function(data){
            $('#thn_akademik_id_attr').val(data);
        });
    }
                    
    function changeKelompok(){
        $('#listkelompok').hide();
        if($('#plot_mata_kuliah_id').val()<=0) return;     
        var plot_mata_kuliah_id = ($('#plot_mata_kuliah_id').val()).split("-");
        var mode = 'view';      
        $.post('<?php echo base_url(); ?>paket_matakuliah/getOptPlotmatakuliah', {plot_mata_kuliah_id: plot_mata_kuliah_id[1]},
        function(data){
            $('#listkelompok').html(data);
            $('#listkelompok').show();
        });
    }
</script>
