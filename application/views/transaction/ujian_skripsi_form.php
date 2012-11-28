<?php
$this->load->view('_shared/header');
$this->load->view('_shared/menus');

//label
$control_label = array(
    'class' => 'control-label'
);

$judul_skripsi_attr = array(                  
    'name'  => 'judul_skripsi',
    'class' => 'span3',
    'value' => set_value('judul_skripsi', $judul_skripsi),
    'autocomplete' => 'off',
    'rows'  => '3',
    'cols'  => '40',
    'style' => 'text-transform : uppercase'
);

$tgl_ujian_attr = array(
    'name'  => 'tgl_ujian',
    'class' => 'input-small',
    'value' => set_value('tgl_ujian', $tgl_ujian),
    'autocomplete' => 'off'    
);

$jam_mulai_attr = array(
    'name'  => 'jam_mulai',
    'class' => 'input-mini',
    'value' => set_value('jam_mulai', $jam_mulai),
    'autocomplete' => 'off'    
);

$jam_akhir_attr = array(
    'name'  => 'jam_akhir',
    'class' => 'input-mini',
    'value' => set_value('jam_akhir', $jam_akhir),
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
    'autocomplete' => 'on'    
);

$angkatan_id_attr[0]= '';
foreach($m_angkatan_options as $row){
    $angkatan_id_attr[$row['id']."-".$row['angkatan_id']] = $row['nama_angkatan'];    
}
                   

$thn_akademik_id_attr = array(
    'id' => 'thn_akademik_id_attr',
    'name' => 'tahun_akademik_id',
    'class' => 'input-small',
    'readonly' => 'readonly',
    'value' => set_value('tahun_akademik_id', $thn_akademik_id_attr),
    'autocomplete' => 'off'
);
                                         
$ketua_penguji_data[0] = '';
foreach ($dosen_options as $row) {
    $ketua_penguji_data[$row->id] = $row->nama_dosen;
}

$dosen_penguji_1_data[0] = '';
foreach ($dosen_options as $row) {
    $dosen_penguji_1_data[$row->id] = $row->nama_dosen;
}

$dosen_penguji_2_data[0] = '';
foreach ($dosen_options as $row) {
    $dosen_penguji_2_data[$row->id] = $row->nama_dosen;
}

$sekretaris_penguji_data[0] = '';
foreach ($dosen_options as $row) {
    $sekretaris_penguji_data[$row->id] = $row->nama_dosen;
}
                        

?>
<div class="container-full" id="ujian_skripsi">
<?= form_open($action_url, array('class' => 'form-horizontal')); ?>
    <div class="control-group">
        <?= form_label('Angkatan' , 'pengajuan_skripsi_id', $control_label); ?>
        <div class="controls">
            <?= form_dropdown('angkatan_id', $angkatan_id_attr, set_value('pengajuan_skripsi_id', $pengajuan_skripsi_id_attr), 'id="pengajuan_skripsi_id" class="input-medium" prevData-selected="' . set_value('pengajuan_skripsi_id', $pengajuan_skripsi_id_attr) . '"'); ?>
            <p class="help-block"><?php echo form_error('pengajuan_skripsi_id') ?></p>
        </div>
    </div>
    
    <div class="control-group">&nbsp;
        <?= form_label('Tahun Akademik' , 'pengajuan_skripsi_id', $control_label); ?>
        <div class="controls">
                <?= form_input($thn_akademik_id_attr); ?>
            <p class="help-block"><?php echo form_error('pengajuan_skripsi_id') ?></p>
        </div>
    </div>
    
    <div class="control-group">
        <?= form_label('Semester' , 'pengajuan_skripsi_id', $control_label); ?>
        <div class="controls">
            <?= form_dropdown('span_semester'); ?>
            <p class="help-block"><?php echo form_error('pengajuan_skripsi_id') ?></p>
        </div>
    </div>
    
    <div class="control-group">
        <?= form_label('Konsentrasi Studi' , 'pengajuan_skripsi_id', $control_label); ?>
        <div class="controls">
            <?= form_dropdown('span_program_studi'); ?>
            <p class="help-block"><?php echo form_error('pengajuan_skripsi_id') ?></p>
        </div>
    </div>

    <div class="control-group">
        <?= form_label('Mahasiswa' , 'mahasiswa_id', $control_label); ?>
        <div class="controls">
            <?= form_dropdown('pengajuan_skripsi_id'); ?>
            <p class="help-block"><?php echo form_error('nim') ?></p>
        </div>
    </div>

    <div class="control-group">
        <?= form_label('Judul Skripsi' .required(), 'judul_skripsi', $control_label); ?>
        <div class="controls">
        <?= form_textarea($judul_skripsi_attr) ?>
            <p class="help-block"><?php echo form_error('judul_skripsi') ?></p>
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
        <?= form_input($jam_mulai_attr) ?> <?= form_input($jam_akhir_attr) ?>
            <p class="help-block"><?php echo form_error('jam_mulai') ?></p>
        </div>
    </div>
        
    <div class="control-group">
        <?= form_label('Ketua Penguji' , 'ketua_penguji_id', $control_label); ?>
        <div class="controls">
            <?= form_dropdown('ketua_penguji_id', $ketua_penguji_data, set_value('ketua_penguji_id', $ketua_penguji_id), 'id="ketua_penguji_id" class="input-medium" prevData-selected="' . set_value('ketua_penguji_id', $ketua_penguji_id) . '"'); ?>
            <p class="help-block"><?php echo form_error('ketua_penguji_id') ?></p>
        </div>
    </div>
    
    <div class="control-group">
        <?= form_label('Anggota Penguji 1' , 'anggota_penguji_1_id', $control_label); ?>
        <div class="controls">
            <?= form_dropdown('anggota_penguji_1_id', $dosen_penguji_1_data, set_value('anggota_penguji_1_id', $anggota_penguji_1_id), 'id="anggota_penguji_1_id" class="input-medium" prevData-selected="' . set_value('anggota_penguji_1_id', $anggota_penguji_1_id) . '"'); ?>
            <p class="help-block"><?php echo form_error('anggota_penguji_1_id') ?></p>
        </div>
    </div>
    
    <div class="control-group">
        <?= form_label('Anggota Penguji 2' , 'anggota_penguji_2_id', $control_label); ?>
        <div class="controls">
            <?= form_dropdown('anggota_penguji_2_id', $dosen_penguji_2_data, set_value('anggota_penguji_2_id', $anggota_penguji_2_id), 'id="anggota_penguji_2_id" class="input-medium" prevData-selected="' . set_value('anggota_penguji_2_id', $anggota_penguji_2_id) . '"'); ?>
            <p class="help-block"><?php echo form_error('anggota_penguji_2_id') ?></p>
        </div>
    </div>
    
    <div class="control-group">
        <?= form_label('Sekretaris Penguji' , 'sekretaris_penguji_id', $control_label); ?>
        <div class="controls">
            <?= form_dropdown('sekretaris_penguji_id', $sekretaris_penguji_data, set_value('sekretaris_penguji_id', $sekretaris_penguji_id), 'id="sekretaris_penguji_id" class="input-medium" prevData-selected="' . set_value('sekretaris_penguji_id', $sekretaris_penguji_id) . '"'); ?>
            <p class="help-block"><?php echo form_error('ketua_penguji_id') ?></p>
        </div>
    </div> 
    
    <div class="control-group">
        <?= form_label('Keterangan', 'keterangan', $control_label); ?>
        <div class="controls">
        <?= form_textarea($keterangan_attr) ?>
            <p class="help-block"><?php echo form_error('keterangan') ?></p>
        </div>
    </div>

    <div class="form-actions well">
        <button class="btn btn-small btn-primary" type="submit">Simpan</button>
    </div>
<?php form_close() ?>
</div>
    <?php $this->load->view('_shared/footer'); ?>
<script type="text/javascript">                 
    $("#pengajuan_skripsi_id").change(function(){
        var value = ($(this).val()).split("-");
        $.post('<?php echo base_url(); ?>ujian_skripsi/getOptTahunAkademik', {pengajuan_skripsi_id: value[1]},
        function(data){
            $('input[name="tahun_akademik_id"]').val(data);
            
        });
        
        $.post('<?php echo base_url(); ?>ujian_skripsi/getOptSemester', {pengajuan_skripsi_id: value[1]},
        function(data){                                                                 
            $("select[name='span_semester']").closest("div.controls").append("<select name='span_semester'></select>");
            $("select[name='span_semester']").closest("div.combobox-container").remove();
            $("select[name='span_semester']").html(data).combobox();
        });
    })
    $("select[name='span_semester']").combobox();
                                                     
    $("#pengajuan_skripsi_id").change(function(){
        var value = ($(this).val()).split("-");   
        $.post('<?php echo base_url(); ?>ujian_skripsi/getOptProgramStudi', {pengajuan_skripsi_id: value[1]},
        function(data){                                                                 
            $("select[name='span_program_studi']").closest("div.controls").append("<select name='span_program_studi'></select>");
            $("select[name='span_program_studi']").closest("div.combobox-container").remove();
            $("select[name='span_program_studi']").html(data).combobox();
        });
    })                                         
    $("select[name='span_program_studi']").combobox();
    
    $("#pengajuan_skripsi_id").change(function(){
        var value = ($(this).val()).split("-");   
        $.post('<?php echo base_url(); ?>ujian_skripsi/getOptMahasiswa', {pengajuan_skripsi_id: value[1]},
        function(data){                                                                 
            $("select[name='pengajuan_skripsi_id']").closest("div.controls").append("<select name='pengajuan_skripsi_id'></select>");
            $("select[name='pengajuan_skripsi_id']").closest("div.combobox-container").remove();
            $("select[name='pengajuan_skripsi_id']").html(data).combobox();
        });
    })                                         
    $("select[name='pengajuan_skripsi_id']").combobox();
               
      
</script>    
