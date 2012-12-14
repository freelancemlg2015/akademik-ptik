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

$semester_data[0] = '';
foreach ($semester_options as $row) {
    $semester_data[$row->id] = $row->nama_semester;
}

$program_studi_data[0] = '';
foreach ($program_studi_options as $row) {
    $program_studi_data[$row->id] = $row->nama_program_studi;
}
                                      
$dosen_data[0] = '';
foreach ($dosen_options as $row) {
    $dosen_data[$row->id] = $row->nama_dosen;
}

$dosen_data_1[0] = '';
foreach ($dosen_options as $row) {
    $dosen_data_1[$row->id] = $row->nama_dosen;
}

$thn_akademik_id_attr = array(
    'id' => 'thn_akademik_id_attr',
    'name' => 'tahun_akademik_id',
    'class' => 'input-small',
    'readonly' => 'readonly',
    'value' => set_value('tahun_akademik_id', $thn_akademik_id_attr),
    'autocomplete' => 'off'
);

$tanggal_pengajuan_attr = array(
    'id'    => 'tgl_pengajuan',
    'name'  => 'tgl_pengajuan',
    'class' => 'input-small',
    'value' => set_value('tgl_pengajuan', $tgl_pengajuan),
    'autocomplete' => 'off'
);

$jam_attr = array(
    'id'    => 'jam',
    'name'  => 'jam',
    'class' => 'input-mini',
    'value' => set_value('jam', $jam),
    'autocomplete' => 'off'
);

$judul_checked = array(
    'id'          => 'judul_skripsi_diajukan',
    'name'        => 'judul_skripsi_diajukan',
    'value'       => set_value('judul_skripsi_diajukan', ''),
    'checked'     => TRUE,  
    'autocomplete'=> 'off'
);

$judul_checked_1 = array(
    'id'          => 'judul_skripsi_diajukan',
    'name'        => 'judul_skripsi_diajukan',
    'value'       => set_value('judul_skripsi_diajukan', ''),
    'checked'     => TRUE,  
    'autocomplete'=> 'off'
);

$judul_checked_2 = array(
    'id'          => 'judul_skripsi_diajukan',
    'name'        => 'judul_skripsi_diajukan',
    'value'       => set_value('judul_skripsi_diajukan', ''),
    'checked'     => TRUE,  
    'autocomplete'=> 'off'
);

$judul_skripsi_diajukan_attr = array(                          
    'name'        => 'judul_skripsi_diajukan',
    'class'       => 'span3',
    'value'       => set_value('judul_skripsi_diajukan', $judul_skripsi_diajukan_attr),
    'rows'        => '3', 
    'cols'        => '40',
    'autocomplete'=> 'off'    
);

/*$judul_skripsi_diajukan_satu_attr = array(                          
    'name'        => 'judul_skripsi_diajukan_satu',
    'class'       => 'span3',
    'value'       => set_value('judul_skripsi_diajukan', $judul_skripsi_diajukan_satu_attr),
    'rows'        => '3', 
    'cols'        => '40',
    'autocomplete'=> 'off'    
);

$judul_skripsi_diajukan_dua_attr = array(                          
    'name'        => 'judul_skripsi_diajukan_dua',
    'class'       => 'span3',
    'value'       => set_value('judul_skripsi_diajukan', $judul_skripsi_diajukan_dua_attr),
    'rows'        => '3', 
    'cols'        => '40',
    'autocomplete'=> 'off'    
);
*/

$mahasiswa_data_attr[0] = '';
if (isset($mahasiswa_data)){
    foreach ($mahasiswa_data as $row) {
        $mahasiswa_data_attr[$row['rencana_mata_pelajaran_detail_id']] = $row['nama'];
    }    
} 
else {
    $mahasiswa_data_attr[''] = '';
}

?>
<div class="container-full" id="pengajuan_skripsi">
<?= form_open($action_url, array('class' => 'form-horizontal')); ?>
    
    <div class="control-group">
        <?= form_label('Angkatan' . required(), 'angkatan_id', $control_label); ?>
        <div class="controls">
            <?= form_dropdown('angkatan_id', $angkatan_data, set_value('angkatan_id', $angkatan_id."-".$thn_akademik_id), 'onChange="changeAngkatan()" id="angkatan_id" class="input-medium" prevData-selected="' . set_value('angkatan_id', $angkatan_id) . '"'); ?>
            <p class="help-block"><?php echo form_error('angkatan_id') ?></p>
        </div>
    </div>
    
    <div class="control-group">&nbsp;
        <?= form_label('Tahun Akademik' , 'thn_akademik_id', $control_label); ?>
        <div class="controls">
                <?= form_input($thn_akademik_id_attr); ?>
            <p class="help-block"><?php echo form_error('thn_akademik_id') ?></p>
        </div>
    </div>
    
    <div class="control-group">
        <?= form_label('Semester' , 'semester_id', $control_label); ?>
        <div class="controls">
            <?= form_dropdown('semester_id', $semester_data, set_value('semester_id', $semester_id), 'onChange="changeProgramStudi()" id="span_semester" class="input-medium" prevData-selected="' . set_value('semester_id', $semester_id) . '"'); ?>
            <p class="help-block"><?php echo form_error('semester_id') ?></p>
        </div>
    </div>
    
    <div class="control-group">
        <?= form_label('Konsentrasi Studi' , 'program_studi_id', $control_label); ?>
        <div class="controls">
            <?= form_dropdown('program_studi_id', $program_studi_data, set_value('program_studi_id', $program_studi_id), 'onChange="changeMahasiswa()" id="span_program" class="input-medium" prevData-selected="' . set_value('program_studi_id', $program_studi_id) . '"'); ?>
            <p class="help-block"><?php echo form_error('program_studi_id') ?></p>
        </div>
    </div>
    
    <div class="control-group">
        <?= form_label('Nama Mahasiswa' , 'rencana_mata_pelajaran_detail_id', $control_label); ?>
        <div class="controls">
            <?= form_dropdown('rencana_mata_pelajaran_detail_id', $mahasiswa_data_attr, set_value('rencana_mata_pelajaran_detail_id', $rencana_mata_pelajaran_detail_id), 'class="input-medium" prevData-selected="' . set_value('rencana_mata_pelajaran_detail_id', $rencana_mata_pelajaran_detail_id) .'"'); ?>
            <p class="help-block"><?php echo form_error('rencana_mata_pelajaran_detail_id') ?></p>
        </div>
    </div>
    
    <div class="control-group">
        <?= form_label('Tanggal Pengajuan' , 'tgl_pengajuan', $control_label); ?>
        <div class="controls controls-row">
            <?= form_input($tanggal_pengajuan_attr); ?> <?= form_input($jam_attr); ?>
            <p class="help-block"><?php echo form_error('tgl_pengajuan') ?></p>
        </div>
    </div><br>
    
    <fieldset>
        <legend>Team Penguji</legend>
        <div class="control-group">
            <?= form_label('Dosen Pembimbing 1' , 'dosen_pembimbing_1_id', $control_label); ?>
            <div class="controls">
                <?= form_dropdown('dosen_pembimbing_1_id', $dosen_data, set_value('dosen_pembimbing_1_id', $dosen_pembimbing_1_id), 'id="dosen_pembimbing_id" class="input-medium" prevData-selected="' . set_value('dosen_pembimbing_1_id', $dosen_pembimbing_1_id) . '"'); ?>
                <p class="help-block"><?php echo form_error('dosen_pembimbing_1_id') ?></p>
            </div>
        </div>
        
        <div class="control-group">
            <?= form_label('Dosen Pembimbing 2' , 'dosen_pembimbing_2_id', $control_label); ?>
            <div class="controls">
                <?= form_dropdown('dosen_pembimbing_2_id', $dosen_data_1, set_value('dosen_pembimbing_2_id', $dosen_pembimbing_2_id), 'id="dosen_pembimbing_id" class="input-medium" prevData-selected="' . set_value('dosen_pembimbing_2_id', $dosen_pembimbing_2_id) . '"'); ?>
                <p class="help-block"><?php echo form_error('dosen_pembimbing_2_id') ?></p>
            </div>
        </div>
    </fieldset><br>
    
    <fieldset>
        <legend>Pengajuan Judul Skripsi</legend>
        <div class="control-group">                                                                             
            <?= form_label('Judul 1' , 'judul_skripsi_diajukan', $control_label); ?>
            <div class="controls" style="margin-top: 5px;"> 
                <?= form_radio($judul_checked)?> <?= form_textarea($judul_skripsi_diajukan_attr)?>
                <p class="help-block"><?php echo form_error('judul_skripsi_diajukan') ?></p>
            </div>
        </div>
        
        <div class="control-group">                                                                             
            <?= form_label('Judul 2' , 'judul_skripsi_diajukan', $control_label); ?>
            <div class="controls" style="margin-top: 5px;"> 
                <?= form_radio($judul_checked_1)?> <?= form_textarea($judul_skripsi_diajukan_attr)?>
                <p class="help-block"><?php echo form_error('judul_skripsi_diajukan') ?></p>
            </div>
        </div> 
        
        <div class="control-group">                                                                             
            <?= form_label('Judul 3' , 'judul_skripsi_diajukan', $control_label); ?>
            <div class="controls" style="margin-top: 5px;"> 
                <?= form_radio($judul_checked_2)?> <?= form_textarea($judul_skripsi_diajukan_attr)?>
                <p class="help-block"><?php echo form_error('judul_skripsi_diajukan') ?></p>
            </div>
        </div>     
        
        <div class="control-group">
            <?= form_label('Status Judul' , 'status_approval', $control_label); ?>
            <div class="controls" style="margin-left:177px;">
                <?php 
                    if(empty($status_approval)){
                        echo"<select id='status_judul' name='status_approval' value=''>
                            <option value='not_approval'>Not Approval</option>
                            <option value='approval'>Approval</option>
                         </select>";        
                    }else{
                        echo"<select id='status_judul' name='status_approval' value='".$status_approval."'>
                            <option value='Not Approval'>Not Approval</option>
                            <option value='Approval'>Approval</option>
                         </select>";        
                        
                    }
                ?>
                <p class="help-block"><?php echo form_error('status_approval') ?></p>
            </div>
        </div>
    </fieldset>
    
    <div class="form-actions well">
        <button class="btn btn-small btn-primary" type="submit">Simpan</button>
    </div>
<?php form_close() ?>
</div>
    <?php $this->load->view('_shared/footer'); ?>

<script type="text/javascript">
    function changeAngkatan(){
        var angkatan_id = ($('#angkatan_id').val()).split("-");
	    $.post('<?php echo base_url(); ?>pengajuan_skripsi/getOptTahunAkademik', {angkatan_id: angkatan_id[1]},
        function(data){
            $('#thn_akademik_id_attr').val(data);
        });
        
        $.post('<?php echo base_url(); ?>pengajuan_skripsi/getOptSemester', {angkatan_id: angkatan_id[0]},
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
        $.post('<?php echo base_url(); ?>pengajuan_skripsi/getOptPrograStudi', {angkatan_id: angkatan_id[0], span_semester:span_semester},
        function(data){                                                                 
            $("select[name='program_studi_id']").closest("div.controls").append("<select name='program_studi_id' onChange='changeMahasiswa()' id='span_program'></select>");
            $("select[name='program_studi_id']").closest("div.combobox-container").remove();
            $("select[name='program_studi_id']").html(data).combobox();
        });        
    }  
    $("select[name='program_studi_id']").combobox();
    
    function changeMahasiswa(){
        var angkatan_id   = ($('#angkatan_id').val());
        var span_semester = ($('#span_semester').val());
        var span_program  = ($('#span_program').val());  
        $.post('<?php echo base_url(); ?>pengajuan_skripsi/getOptMahasiswa', {angkatan_id: angkatan_id[0], span_semester: span_semester, span_program: span_program},
        function(data){                                                                 
            $("select[name='rencana_mata_pelajaran_detail_id']").closest("div.controls").append("<select name='rencana_mata_pelajaran_detail_id'></select>");
            $("select[name='rencana_mata_pelajaran_detail_id']").closest("div.combobox-container").remove();
            $("select[name='rencana_mata_pelajaran_detail_id']").html(data).combobox();
        });
    } 
     $("select[name='rencana_mata_pelajaran_detail_id']").combobox();  
</script>