<?php
$this->load->view('_shared/header');
$this->load->view('_shared/menus');

//label
$control_label = array(
    'class' => 'control-label'
);
              
$angkatan_data[0] = '';
foreach ($angkatan_options as $row) {
    $angkatan_data[$row['angkatan_id'].'-'.$row['tahun_akademik_id']] = $row['nama_angkatan'];
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

$semester_data_attr[0] = '';        
if(!empty($semester_data_options)){                                  
    foreach ($semester_data_options as $row) {
        $semester_data_attr[$row['group_id']] = $row['nama_semester'];
    }                                  
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
        <?= form_label('Semester' , 'semester_id', $control_label); ?>
        <div class="controls">
            <?= form_dropdown('plot_mata_kuliah_id', $semester_data_attr, set_value('semester_id', $semester_id_attr), 'onChange="changeKelompok()" id="span_semester" class="input-medium" prevData-selected="' . set_value('semester_id', $semester_id_attr) . '"'); ?>
            <p class="help-block"><?php echo form_error('semester_id') ?></p>
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
        
        $.post('<?php echo base_url(); ?>paket_matakuliah/getOptSemester', {angkatan_id: angkatan_id[0]},
        function(data){                                                                 
            $("select[name='plot_mata_kuliah_id']").closest("div.controls").append("<select name='plot_mata_kuliah_id' onChange='changeKelompok()' id='span_semester'></select>");
            $("select[name='plot_mata_kuliah_id']").closest("div.combobox-container").remove();
            $("select[name='plot_mata_kuliah_id']").html(data).combobox();
        });
    }
    $("select[name='plot_mata_kuliah_id']").combobox();
                    
    function changeKelompok(){
        $('#listkelompok').hide();
        if($('#span_semester').val()<=0) return;
        var angkatan_id = ($('#angkatan_id').val());
        var span_semester = ($('#span_semester').val()).split(";");
        var mode = 'view';      
        $.post('<?php echo base_url(); ?>paket_matakuliah/getOptKelompokMatakuliah', {angkatan_id: angkatan_id, span_semester: span_semester[0]},
        function(data){
            $('#listkelompok').html(data);
            $('#listkelompok').show();
        });
    }
</script>
