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
                          
$plot_mata_kuliah_data[0] = '';
if(!empty($plot_mata_kuliah_options)){
    foreach ($plot_mata_kuliah_options as $row) {
        $plot_mata_kuliah_data[$row['id'].'-'.$row['semester_id']] = $row['nama_semester'];
    }    
}
          
$mata_data[0] = '';
if (isset($t_plot_mata_kuliah)){
    foreach ($t_plot_mata_kuliah as $row) {
        $mata_data[$row['plot_mata_kuliah_id']] = $row['nama_kelompok_mata_kuliah'];
    }    
} 
else {
    $mata_data[''] = '';
}

$matakuliah_attr_data[0] = '';
if (isset($t_mata_kuliah)){
    foreach ($t_mata_kuliah as $row) {
        $matakuliah_attr_data[$row['plot_mata_kuliah_id']] = $row['nama_mata_kuliah'];
    }    
} 
else {
    $matakuliah_attr_data[''] = '';
}
 
if (isset($paket_mata_kuliah->plot_mata_kuliah_id)){
    $plot_semester_id = $paket_mata_kuliah->plot_mata_kuliah_id;
}
else {
    $plot_semester_id = '';
}
                         
 
$dosen_data[0] = '';
foreach ($dosen_options as $row) {
    $dosen_data[$row->id] = $row->nama_dosen;
}

$thn_akademik_id_attr = array(
    'id' => 'thn_akademik_id_attr',
    'name' => 'thn_akademik_id_attr',
    'class' => 'input-small',
    'readonly' => 'readonly',
    'value' => set_value('tahun_akademik_id', $thn_akademik_id_attr),
    'autocomplete' => 'off'
);                                                                                           

?>
<div class="container-full" id="plot_dosen_penanggung_jawab">
<?= form_open($action_url, array('class' => 'form-horizontal')); ?>

    <div class="control-group">
        <?= form_label('Angkatan' . required(), 'angkatan_id', $control_label); ?>
        <div class="controls">
            <?= form_dropdown('angkatan_id', $angkatan_data, set_value('angkatan_id', $angkatan_id."-".$thn_akademik_id), 'onChange="changeAngkatan()" id="angkatan_id" class="input-medium" prevData-selected="' . set_value('angkatan_id', $angkatan_id) . '"'); ?>
            <p class="help-block"><?php echo form_error('angkatan_id') ?></p>
        </div>
    </div>

    <!--<div class="control-group">
        <?//= form_label('Tahun Akademik' , 'thn_akademik_id', $control_label); ?>
        <div class="controls">
            <?//= form_dropdown('span_tahun', $tahun_data, set_value('thn_akademik_id', $angkatan_id), 'id="thn_akademik_id" class="input-medium" prevData-selected="' . set_value('thn_akademik_id', $angkatan_id) . '"'); ?>
            <p class="help-block"><?php //echo form_error('thn_akademik_id') ?></p>
        </div>
    </div>-->
    
    <div class="control-group">
        <?= form_label('Tahun Akademik' , 'thn_akademik_id', $control_label); ?>
        <div class="controls">
            <?= form_input($thn_akademik_id_attr); ?>
            <p class="help-block"><?php echo form_error('thn_akademik_id') ?></p>
        </div>
    </div>
        
    <div class="control-group">
        <?= form_label('Semester' , 'paket_mata_kuliah_id', $control_label); ?>
        <div class="controls">
            <?= form_dropdown('semester_id', $plot_mata_kuliah_data, set_value('paket_mata_kuliah_id', $semester_id), 'onChange="changeProgramStudi()" id="span_semester" class="input-medium" prevData-selected="' . set_value('paket_mata_kuliah_id', $paket_mata_kuliah_id) . '"'); ?>
            <p class="help-block"><?php echo form_error('paket_mata_kuliah_id') ?></p>
        </div>
    </div>
        
    <div class="control-group">
        <?= form_label('Konsentrasi Studi' , 'paket_mata_kuliah_id', $control_label); ?>
        <div class="controls">
            <?= form_dropdown('program_studi_id',$mata_data, set_value('paket_mata_kuliah_id', $kelompok_mata_kuliah_id_attr), 'onChange="changeMataKuliah()" id="span_program" class="input-medium" prevData-selected="' . set_value('paket_mata_kuliah_id', $kelompok_mata_kuliah_id_attr) . '"'); ?>
            <p class="help-block"><?php echo form_error('paket_mata_kuliah_id') ?></p>
        </div>
    </div>
        
    <div class="control-group">
        <?= form_label('Mata Kuliah' , 'paket_mata_kuliah_id', $control_label); ?>
        <div class="controls">
            <?= form_dropdown('mata_kuliah_id',$matakuliah_attr_data, set_value('paket_mata_kuliah_id', @$mata_kuliah_id_attr), 'id="span_mata_kuliah"  class="input-medium" prevData-selected="' . set_value('paket_mata_kuliah_id', @$mata_kuliah_id_attr) . '"'); ?>
            <p class="help-block"><?php echo form_error('paket_mata_kuliah_id') ?></p>
        </div>
    </div>
   
    <fieldset>
        <legend>Nama Dosen/Penanggung Jawab</legend>
        <div class="control-group">
            <a id="button_add_dosen" class="btn btn-mini button_add_dosen_class"><i class="icon-plus"></i></a>
            <?= form_label('Dosen Penanggung Jawab' , 'dosen_id', $control_label); ?>
            <div class="controls">
                <?php                            
                    if (!empty($dosen_options_edit)){
                        $i = 0;
                        foreach($dosen_options_edit as $row):
                            if($i>0){
                                echo '<label style="margin-left: -160px;" class="control-label" for="dosen_id">Dosen Anggota</label>';    
                            }    
                                echo form_dropdown('dosen_id[]', $dosen_data, set_value('dosen_id', $row['dosen_id']), 'id="dosen_id" class="input-medium" prevData-selected="' . set_value('dosen_id', $row['dosen_id']) . '"');
                            if($i>0){
                                echo '<span class="btn-mini-class"><a class="btn btn-mini remove-add_dosen_1"><i class="icon-minus"></i></a></span>';    
                            }
                        $i++;
                        endforeach;
                    }
                    else {
                        echo form_dropdown('dosen_id[]', $dosen_data, set_value('dosen_id', @$dosen_id), 'id="dosen_id" class="input-medium" prevData-selected="' . set_value('dosen_id', @$dosen_id) . '"');
                    }
                ?>
                <p class="help-block"><?php echo form_error('dosen_id') ?></p>                 
            </div>
        </div>
    </fieldset>
    <div class="clear:both"></div>
    
    <div class="form-actions well">
        <button class="btn btn-small btn-primary" type="submit">Simpan</button>
    </div>
<?php form_close() ?>
</div>
    <?php $this->load->view('_shared/footer'); ?>

<script type="text/javascript">
    function changeAngkatan(){
        var angkatan_id = ($('#angkatan_id').val()).split("-");;
        //alert(angkatan_id);
        $.post('<?php echo base_url(); ?>plot_dosen_penanggung_jawab/getOptTahunAkademik', {angkatan_id: angkatan_id[1]},
        function(data){
            $('#thn_akademik_id_attr').val(data);
        });
        
        $.post('<?php echo base_url(); ?>plot_dosen_penanggung_jawab/getOptSemester', {angkatan_id: angkatan_id[0]},
        function(data){                                                                 
            $("select[name='semester_id']").closest("div.controls").append("<select name='semester_id' onChange='changeProgramStudi()' id='span_semester'></select>");
            $("select[name='semester_id']").closest("div.combobox-container").remove();
            $("select[name='semester_id']").html(data).combobox();
        });
    }
    $("select[name='semester_id']").combobox();
    
    function changeProgramStudi(){
        var angkatan_id   = ($('#angkatan_id').val());
        var span_semester = ($('#span_semester').val());
        $.post('<?php echo base_url(); ?>plot_dosen_penanggung_jawab/getOptProgramStudi', {angkatan_id: angkatan_id[0], span_semester: span_semester[0]},
        function(data){                                                                 
            $("select[name='program_studi_id']").closest("div.controls").append("<select name='program_studi_id' onChange='changeMataKuliah()' id='span_program'></select>");
            $("select[name='program_studi_id']").closest("div.combobox-container").remove();
            $("select[name='program_studi_id']").html(data).combobox();
        });
    }
    $("select[name='program_studi_id']").combobox();
    
    function changeMataKuliah(){
        var angkatan_id   = ($('#angkatan_id').val());
        var span_semester = ($('#span_semester').val());
        var span_program  = ($('#span_program').val());
        $.post('<?php echo base_url(); ?>plot_dosen_penanggung_jawab/getOptMataKuliah', {angkatan_id: angkatan_id[0], span_semester: span_semester[0], span_program: span_program[0]},
        function(data){                                                                 
            $("select[name='mata_kuliah_id']").closest("div.controls").append("<select name='mata_kuliah_id'></select>");
            $("select[name='mata_kuliah_id']").closest("div.combobox-container").remove();
            $("select[name='mata_kuliah_id']").html(data).combobox();
        });
    }
    $("select[name='mata_kuliah_id']").combobox();        
</script>

