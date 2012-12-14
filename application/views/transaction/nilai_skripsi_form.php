<?php
$this->load->view('_shared/header');
$this->load->view('_shared/menus');

//label
$control_label = array(
    'class' => 'control-label'
);

$nilai_ketua_attr = array(
    'name'  => 'nilai_ketua',
    'class' => 'input-mini',
    'value' => set_value('nilai_ketua', $nilai_ketua),
    'autocomplete' => 'off'
);

$nilai_anggota_satu_attr = array(
    'name'  => 'nilai_agt_1',
    'class' => 'input-mini',
    'value' => set_value('nilai_ketua', $nilai_ketua),
    'autocomplete' => 'off'
);

$nilai_anggota_dua_attr = array(
    'name'  => 'nilai_agt_2',
    'class' => 'input-mini',
    'value' => set_value('nilai_ketua', $nilai_ketua),
    'autocomplete' => 'off'
);
         
$judul_skripsi_attr = array(
    'id'       => 'judul_skripsi_attr',                 
    'name'     => 'judul_skripsi_diajukan',
    'class'    => 'input_medium',
    'readonly' => 'readonly',
    'value'    => set_value('judul_skripsi_diajukan', $judul_skripsi_diajukan),
    'style'    => 'text-transform : uppercase',
    'autocomplete' => 'off'
);

$tgl_ujian_attr = array(
    'id'    => 'tgl_ujian_attr',
    'name'  => 'tgl_ujian_attr',
    'class' => 'input-small',
    'value' => set_value('tgl_ujian', @$tgl_ujian),
    'readonly'  => 'readonly',
    'autocomplete' => 'off'    
);

$jam_mulai_attr = array(
    'id'    => 'jam_mulai_attr',
    'name'  => 'jam_mulai_attr',
    'class' => 'input-mini',
    'value' => set_value('jam_mulai', @$jam_mulai),
    'readonly'  => 'readonly',
    'autocomplete' => 'off'    
);

$jam_akhir_attr = array(
    'id'    => 'jam_akhir_attr',
    'name'  => 'jam_mulai_attr',
    'class' => 'input-mini',
    'value' => set_value('jam_akhir', @$jam_akhir),
    'readonly'  => 'readonly',
    'autocomplete' => 'off'    
);

/*
$ketua_penguji_attr = array(
    'name' => 'ketua_penguji',
    'class' => 'input-medium',
    'value' => set_value('ketua_penguji', $ketua_penguji),
    'autocomplete' => 'on'    
);

$anggota_penguji_1_attr = array(
    'name' => 'anggota_penguji_1',
    'class' => 'input-medium',
    'value' => set_value('anggota_penguji_1', $anggota_penguji_1),
    'autocomplete' => 'on'    
);

$anggota_penguji_2_attr = array(
    'name' => 'anggota_penguji_2',
    'class' => 'input-medium',
    'value' => set_value('anggota_penguji_2', $anggota_penguji_2),
    'autocomplete' => 'on'    
);

$sekretaris_penguji_attr = array(
    'name' => 'sekretaris_penguji',
    'class' => 'input-medium',
    'value' => set_value('sekretaris_penguji', $sekretaris_penguji),
    'autocomplete' => 'on'    
);
*/

$keterangan_attr = array(
    'name'  => 'keterangan',
    'class' => 'span3',
    'value' => set_value('keterangan', $keterangan),
    'rows'  => '3',
    'cols'  => '40',
    'autocomplete' => 'off',
    'style'    => 'text-transform : uppercase',    
);

$angkatan_id_attr[0]= '';
if(!empty($m_angkatan_options)){
    foreach($m_angkatan_options as $row){
        $angkatan_id_attr[$row['id']."-".$row['angkatan_id']] = $row['nama_angkatan'];    
    }                            
}                             

$semester_id_data[0] = ''; 
if (!empty($semester)){                    
    foreach ($semester as $row) {
        $semester_id_data[$row['id']] = $row['nama_semester'];
    }                          
} 
else {
    $semester_id_data[''] = ''; 
}                        
    
$program_id_data_attr[0]= '';
if(!empty($program_data)){
    foreach($program_data as $row){
        $program_id_data_attr[$row['id']] = $row['nama_program_studi'];    
    }
}else{
    $program_id_data_attr[''] = '';    
}

$mahasiswa_id_data_attr[0]= '';
if(!empty($mahasiswa_data)){
   foreach($mahasiswa_data as $row){
        $mahasiswa_id_data_attr[$row['id']] = $row['nama'];    
    }         
}else{
   $mahasiswa_id_data_attr['']= ''; 
}                    

$thn_akademik_id_attr = array(
    'id'        => 'thn_akademik_id_attr',
    'name'      => 'tahun_akademik_id',
    'class'     => 'input-small',
    'readonly'  => 'readonly',
    'value'     => set_value('tahun_akademik_id', $thn_akademik_id_attr),
    'autocomplete' => 'off'
);

$ketua_penguji_data_attr = array(
    'id'        => 'ketua_penguji_id_attr',
    'name'      => 'ketua_penguji_id',
    'class'     => 'input_medium',
    'readonly'  => 'readonly',
    'value'     => set_value('ketua_penguji_id', @$ketua_penguji_id),
    'autocomplete' => 'off'
);

$anggota_penguji_1_data_attr = array(
    'id'        => 'anggota_penguji_id_1_attr',
    'name'      => 'anggota_penguji_1_id',
    'class'     => 'input_medium',
    'readonly'  => 'readonly',
    'value'     => set_value('anggota_penguji_1_id', @$anggota_penguji_1_id),
    'autocomplete' => 'off'
);

$anggota_penguji_2_data_attr = array(
    'id'        => 'anggota_penguji_id_2_attr',
    'name'      => 'anggota_penguji_2_id',
    'class'     => 'input_medium',
    'readonly'  => 'readonly',
    'value'     => set_value('anggota_penguji_2_id', @$anggota_penguji_2_id),
    'autocomplete' => 'off'
);
  
$sekretaris_penguji_data_attr = array(
    'id'        => 'sekretaris_penguji_id_attr',
    'name'      => 'sekretaris_penguji_id',
    'class'     => 'input_medium',
    'readonly'  => 'readonly',
    'value'     => set_value('sekretaris_penguji_id', @$sekretaris_penguji_id),
    'autocomplete' => 'off'
);
                                  
?>
<div class="container-full" id="nilai_skripsi">
<?= form_open($action_url, array('class' => 'form-horizontal')); ?>
    <div class="control-group">
        <?= form_label('Angkatan' , 'angkatan_id', $control_label); ?>
        <div class="controls">
            <?= form_dropdown('angkatan_id', $angkatan_id_attr, set_value('angkatan_id', $pengajuan_skripsi_id_attr), 'id="angkatan_id" class="input-medium" prevData-selected="' . set_value('angkatan_id', $pengajuan_skripsi_id_attr) . '"'); ?>
            <p class="help-block"><?php echo form_error('angkatan_id') ?></p>
        </div>
    </div>
    
    <div class="control-group">&nbsp;
        <?= form_label('Tahun Akademik' , 'tahun_akademik_id', $control_label); ?>
        <div class="controls">
                <?= form_input($thn_akademik_id_attr); ?>
            <p class="help-block"><?php echo form_error('tahun_akademik_id') ?></p>
        </div>
    </div>
    
    <div class="control-group">
        <?= form_label('Semester' , 'semester_id', $control_label); ?>
        <div class="controls">
            <?= form_dropdown('span_semester',$semester_id_data ,set_value('semester_id', $semester_id_attr), 'onChange="changeProgramStudi()" id="span_semester" class="input-medium" prevData-selected="' . set_value('semester_id', $semester_id_attr) . '"'); ?>
            <p class="help-block"><?php echo form_error('pengajuan_skripsi_id') ?></p>
        </div>
    </div>
    
    <div class="control-group">
        <?= form_label('Konsentrasi Studi' , 'program_studi_id', $control_label); ?>
        <div class="controls">
            <?= form_dropdown('span_program_studi',$program_id_data_attr, set_value('program_studi_id', $program_studi_id_attr), 'onChange="changeMahasiswa()" id="span_program_studi" class="input-medium" prevData-selected="' . set_value('program_studi_id', $program_studi_id_attr) . '"'); ?>
            <p class="help-block"><?php echo form_error('program_studi_id') ?></p>
        </div>
    </div>

    <div class="control-group">
        <?= form_label('Mahasiswa' , 'mahasiswa_id', $control_label); ?>
        <div class="controls">
            <?= form_dropdown('ujian_skripsi_id',$mahasiswa_id_data_attr, set_value('mahasiswa_id', $mahasiswa_id_attr), 'onChange="changePengajuan()" id="span_mahasiswa" class="input-medium" prevData-selected="' . set_value('pengajuan_skripsi_id', $mahasiswa_id_attr) . '"'); ?>
            <p class="help-block"><?php echo form_error('mahasiswa_id') ?></p>
        </div>
    </div>

    <div class="control-group">
        <?= form_label('Tanggal Ujian' , 'tgl_ujian', $control_label); ?>
        <div class="controls">
        <?= form_input($tgl_ujian_attr) ?>
            <p class="help-block"><?php echo form_error('tgl_ujian') ?></p>
        </div>
    </div>
    
    <div class="control-group">
        <?= form_label('Jam' , 'jam_mulai', $control_label); ?>
        <div class="controls">
        <?= form_input($jam_mulai_attr) ?> s/d <?= form_input($jam_akhir_attr) ?>
            <p class="help-block"><?php echo form_error('jam_mulai') ?></p>
        </div>
    </div>
    
    <fieldset>
        <legend>Pengajuan Judul Skripsi</legend>
        <div class="control-group">
            <?= form_label('Judul Skripsi' , 'judul_skripsi_diajukan', $control_label); ?>
            <div class="controls">
            <?= form_input($judul_skripsi_attr) ?>
                <p class="help-block"><?php echo form_error('judul_skripsi_diajukan') ?></p>
            </div>
        </div>

        <div class="control-group">
        <?= form_label('Ketua Penguji' .required(), 'ketua_penguji_id', $control_label); ?>
            <div class="controls">
                <?= form_input($ketua_penguji_data_attr); ?> 
                <p class="help-block"><?php //echo form_error('ketua_penguji_id') ?></p>
            </div>
            <div style="margin-left: 400px; margin-top: -28px;">
                <?= form_input($nilai_ketua_attr)?>
                <p class="help-block"><?php echo form_error('nilai_ketua') ?></p>                                    
            </div>
        </div>
        
        <div class="control-group">
            <?= form_label('Anggota Penguji 1' .required(), 'anggota_penguji_1_id', $control_label); ?>
            <div class="controls">
                <?= form_input($anggota_penguji_1_data_attr); ?>
                <p class="help-block"><?php //echo form_error('anggota_penguji_1_id') ?></p>
            </div>
            <div style="margin-left: 400px; margin-top: -28px;">
                <?= form_input($nilai_anggota_satu_attr)?>
                <p class="help-block"><?php echo form_error('nilai_agt_1') ?></p>
            </div>
        </div>
        
        <div class="control-group">
            <?= form_label('Anggota Penguji 2' .required(), 'anggota_penguji_2_id', $control_label); ?>
            <div class="controls">
                <?= form_input($anggota_penguji_2_data_attr);?>
                <p class="help-block"><?php //echo form_error('anggota_penguji_2_id') ?></p>
            </div>
            <div style="margin-left: 400px; margin-top: -28px;">
                <?= form_input($nilai_anggota_dua_attr)?>
                <p class="help-block"><?php echo form_error('nilai_agt_2') ?></p>
            </div>
        </div>
        
        <div class="control-group">
            <?= form_label('Sekretaris Penguji' , 'sekretaris_penguji_id', $control_label); ?>
            <div class="controls">
                <?= form_input($sekretaris_penguji_data_attr); ?>
                <p class="help-block"><?php //echo form_error('ketua_penguji_id') ?></p>
            </div>
        </div> 
        
        <div class="control-group">
            <?= form_label('Keterangan', 'keterangan', $control_label); ?>
            <div class="controls">
            <?= form_textarea($keterangan_attr) ?>
                <p class="help-block"><?php echo form_error('keterangan') ?></p>
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
    $("#angkatan_id").change(function(){
        var angkatan_id = ($(this).val()).split("-");
        $.post('<?php echo base_url(); ?>nilai_skripsi/getOptTahunAkademik', {angkatan_id: angkatan_id[1]},
        function(data){
            $('input[name="tahun_akademik_id"]').val(data);
            
        });
        
        $.post('<?php echo base_url(); ?>nilai_skripsi/getOptSemester', {angkatan_id: angkatan_id[1]},
        function(data){                                                                 
            $("select[name='span_semester']").closest("div.controls").append("<select name='span_semester' onChange='changeProgramStudi()' id='span_semester'></select>");
            $("select[name='span_semester']").closest("div.combobox-container").remove();
            $("select[name='span_semester']").html(data).combobox();
        });
    })
    $("select[name='span_semester']").combobox();
    
    function changeProgramStudi(){
        var angkatan_id = ($('#angkatan_id').val()).split("-");                                                   
        var span_semester = ($('#span_semester').val());
        $.post('<?php echo base_url(); ?>nilai_skripsi/getOptProgramStudi', {angkatan_id: angkatan_id[1], span_semester: span_semester},
        function(data){
            $("select[name='span_program_studi']").closest("div.controls").append("<select name='span_program_studi' onChange='changeMahasiswa()' id='span_program_studi'></select>");
            $("select[name='span_program_studi']").closest("div.combobox-container").remove();
            $("select[name='span_program_studi']").html(data).combobox();
        });
    }                                          
    $("select[name='span_program_studi']").combobox();
    
    function changeMahasiswa(){
        var angkatan_id = ($('#angkatan_id').val()).split("-");                                                   
        var span_semester = ($('#span_semester').val());
        var span_program_studi = ($('#span_program_studi').val());
        $.post('<?php echo base_url(); ?>nilai_skripsi/getOptMahasiswa', {angkatan_id: angkatan_id[1], span_semester: span_semester, span_program_studi:span_program_studi},
        function(data){
            $("select[name='ujian_skripsi_id']").closest("div.controls").append("<select name='ujian_skripsi_id' onChange='changePengajuan()' id='span_mahasiswa'></select>");
            $("select[name='ujian_skripsi_id']").closest("div.combobox-container").remove();
            $("select[name='ujian_skripsi_id']").html(data).combobox();
        });
    }                                          
    $("select[name='ujian_skripsi_id']").combobox();
    
    function changePengajuan(){ 
        if($('#span_mahasiswa').val()<=0) return;
        var angkatan_id = ($('#angkatan_id').val()).split("-");                                                   
        var span_semester = ($('#span_semester').val());         
        var span_program_studi = ($('#span_program_studi').val());
        var span_mahasiswa = ($('#span_mahasiswa').val());
        $.post('<?php echo base_url(); ?>nilai_skripsi/getOptPengajuanSkripsi', {angkatan_id: angkatan_id[1], span_semester:span_semester, span_program_studi:span_program_studi, span_mahasiswa:span_mahasiswa},
        function(data){
            $('#judul_skripsi_attr').val(data);            
        });
        
        $.post('<?php echo base_url(); ?>nilai_skripsi/getOptTanggal', {angkatan_id: angkatan_id[1], span_semester:span_semester, span_program_studi:span_program_studi, span_mahasiswa:span_mahasiswa},
        function(data){
            $('#tgl_ujian_attr').val(data);            
        });
        
        $.post('<?php echo base_url(); ?>nilai_skripsi/getOptJamMulai', {angkatan_id: angkatan_id[1], span_semester:span_semester, span_program_studi:span_program_studi, span_mahasiswa:span_mahasiswa},
        function(data){
            $('#jam_mulai_attr').val(data);            
        });
        
        $.post('<?php echo base_url(); ?>nilai_skripsi/getOptJamAkhir', {angkatan_id: angkatan_id[1], span_semester:span_semester, span_program_studi:span_program_studi, span_mahasiswa:span_mahasiswa},
        function(data){
            $('#jam_akhir_attr').val(data);            
        });
        
        $.post('<?php echo base_url(); ?>nilai_skripsi/getOptKetuaPenguji', {angkatan_id: angkatan_id[1], span_semester:span_semester, span_program_studi:span_program_studi, span_mahasiswa:span_mahasiswa},
        function(data){                                                                 
            $('#ketua_penguji_id_attr').val(data); 
        });
        
        $.post('<?php echo base_url(); ?>nilai_skripsi/getOptAnggotaPengujiStu', {angkatan_id: angkatan_id[1], span_semester: span_semester, span_program_studi:span_program_studi},
        function(data){
             $('#anggota_penguji_id_1_attr').val(data);
        });
        
        $.post('<?php echo base_url(); ?>nilai_skripsi/getOptAnggotaPengujiDwa', {angkatan_id: angkatan_id[1], span_semester: span_semester, span_program_studi:span_program_studi},
        function(data){
             $('#anggota_penguji_id_2_attr').val(data); 
        });
        
        $.post('<?php echo base_url(); ?>nilai_skripsi/getOptSekretarisPenguji', {angkatan_id: angkatan_id[1], span_semester: span_semester, span_program_studi:span_program_studi},
        function(data){
            $('#sekretaris_penguji_id_attr').val(data); 
        });
    }
     
</script>    
