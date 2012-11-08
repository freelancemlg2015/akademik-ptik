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

//$plot_data[0] = '';
//if (isset($m_semester)){
//    foreach ($m_semester as $row) {
//        $tahun_data[$row['$m_semester']] = $row['nama_semester'];
//    }    
//} 
//else {
//    $plot_data[''] = '';
//}
//
//if (isset($t_plot_mata_kuliah->semester_id)){
//    $smster_id = $t_plot_mata_kuliah->semester_id;
//}
//else {
//    $smster_id = '';
//}

$dosen_data[0] = '';
foreach ($dosen_options as $row) {
    $dosen_data[$row->id] = $row->nama_dosen;
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
            <?= form_dropdown('paket_mata_kuliah_id', $plot_mata_kuliah_data, set_value('paket_mata_kuliah_id', $paket_mata_kuliah_id), 'id="plot_mata_kuliah_id" class="input-medium" prevData-selected="' . set_value('paket_mata_kuliah_id', $paket_mata_kuliah_id) . '"'); ?>
            <p class="help-block"><?php echo form_error('plot_mata_kuliah_id') ?></p>
        </div>
    </div>
        
    <div class="control-group">
        <?= form_label('Konsentrasi Studi' , 'paket_mata_kuliah_id', $control_label); ?>
        <div class="controls">
            <?= form_dropdown('span_kelompok'); ?>
            <p class="help-block"><?php echo form_error('plot_mata_kuliah_id') ?></p>
        </div>
    </div>
        
    <div class="control-group">
        <?= form_label('Mata Kuliah' , 'plot_mata_kuliah_id', $control_label); ?>
        <div class="controls">
            <?= form_dropdown('span_matakuliah'); ?>
            <p class="help-block"><?php echo form_error('plot_mata_kuliah_id') ?></p>
        </div>
    </div>
   
    <fieldset>
        <legend>Nama Dosen/Penanggung Jawab</legend>
        <div class="control-group">
            <a id="button_add_dosen" class="btn btn-mini button_add_dosen_class"><i class="icon-plus"></i></a>
            <?= form_label('Dosen' , 'dosen_id', $control_label); ?>
            <div class="controls">
                <?php                            
                    if (!empty($dosen_options_edit)){
                        foreach($dosen_options_edit as $row):    
                        echo form_dropdown('dosen_id[]', $dosen_data, set_value('dosen_id', $row['dosen_id']), 'id="dosen_id" class="input-medium" prevData-selected="' . set_value('dosen_id', $row['dosen_id']) . '"');
                        endforeach;
                    }
                    else {
                        echo form_dropdown('dosen_id[]', $dosen_data, set_value('dosen_id', $dosen_id), 'id="dosen_id" class="input-medium" prevData-selected="' . set_value('dosen_id', $dosen_id) . '"');
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
    }
    //$("#angkatan_id").change(function(){
//        var value = ($(this).val()).split("-");
//        $.post('<?php //echo base_url(); ?>plot_dosen_penanggung_jawab/getOptTahunAkademik', {angkatan_id: value[1]},
//        function(data){                                                                 
//            $("select[name='span_tahun']").closest("div.controls").append("<select name='span_tahun'></select>");
//            $("select[name='span_tahun']").closest("div.combobox-container").remove();
//            $("select[name='span_tahun']").html(data).combobox();
//        });
//    })                                         
//    $("select[name='span_tahun']").combobox();
    
    $("#plot_mata_kuliah_id").change(function(){
        var value = ($(this).val()).split("-");
        $.post('<?php echo base_url(); ?>plot_dosen_penanggung_jawab/getOptPlotmatakuliah', {plot_mata_kuliah_id: value[1]},
        function(data){                                                                 
            $("select[name='span_kelompok']").closest("div.controls").append("<select name='span_kelompok'></select>");
            $("select[name='span_kelompok']").closest("div.combobox-container").remove();
            $("select[name='span_kelompok']").html(data).combobox();
        });
    })                                         
    $("select[name='span_kelompok']").combobox();
    
    $("#plot_mata_kuliah_id").change(function(){
        var value = ($(this).val()).split("-");
        $.post('<?php echo base_url(); ?>plot_dosen_penanggung_jawab/getOptPlotmatakuliahDetil', {plot_mata_kuliah_id: value[1]},
        function(data){                                                                 
            $("select[name='span_matakuliah']").closest("div.controls").append("<select name='span_matakuliah'></select>");
            $("select[name='span_matakuliah']").closest("div.combobox-container").remove();
            $("select[name='span_matakuliah']").html(data).combobox();
        });
    })                                         
    $("select[name='span_matakuliah']").combobox();
</script>

