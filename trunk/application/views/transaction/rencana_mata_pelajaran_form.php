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

$mata_kuliah_data[0] = '';
foreach ($mata_kuliah_options as $row) {
    $mata_kuliah_data[$row->id] = $row->nama_mata_kuliah;
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
<div class="container-full" id="rencana_mata_pelajaran">
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
        <?= form_label('Mata Kuliah' , 'paket_mata_kuliah_id', $control_label); ?>
        <div class="controls">
            <?= form_dropdown('span_matakuliah'); ?>
            <p class="help-block"><?php echo form_error('paket_mata_kuliah_id') ?></p>
        </div>
    </div>
    
    <div class="pagination pagination-centered">
        <div id="pageNavPosition"></div> 
    </div>
    <table class="table table-bordered table-striped container-full" controller="transaction">
        <thead>
            <tr>
                <th width="20">No</th>
                <th>Nim</th>
                <th>Nama</th>
                <th width="30" style="text-align: center;"> 
                    <input type="checkbox" id="1" class="ck" style="cursor: pointer" onclick="cek_all('.ck')">
                </th>
            </tr>
        </thead>
        <tbody id="listmahasiswa">
            <tr><td colspan="4">&nbsp;</td></tr>
        </tbody>
        
    </table>
    
    
    <div class="form-actions well">
        <button class="btn btn-small btn-primary" type="submit">Simpan</button>
    </div>
<?php form_close() ?>
</div>
    <?php $this->load->view('_shared/footer'); ?>

<script type="text/javascript">
//    var pager = new Pager('rencana', 10); 
//    pager.init(); 
//    pager.showPageNav('pager', 'pageNavPosition'); 
//    pager.showPage(1);
    
    function changeAngkatan(){
        var angkatan_id = ($('#angkatan_id').val()).split("-");
        $.post('<?php echo base_url(); ?>rencana_mata_pelajaran/getOptTahunAkademik', {angkatan_id: angkatan_id[1]},
        function(data){
            $('#thn_akademik_id_attr').val(data);
        });
    }
    
    $("#plot_mata_kuliah_id").change(function(){
        var value = ($(this).val()).split("-");
        $.post('<?php echo base_url(); ?>rencana_mata_pelajaran/getOptPlotmatakuliah', {paket_mata_kuliah_id: value[1]},
        function(data){                                                                 
            $("select[name='span_kelompok']").closest("div.controls").append("<select name='span_kelompok'></select>");
            $("select[name='span_kelompok']").closest("div.combobox-container").remove();
            $("select[name='span_kelompok']").html(data).combobox();
        });
    })                                         
    $("select[name='span_kelompok']").combobox();
    
    $("#plot_mata_kuliah_id").change(function(){
        var value = ($(this).val()).split("-");
        $.post('<?php echo base_url(); ?>rencana_mata_pelajaran/getOptPlotmatakuliahDetil', {paket_mata_kuliah_id: value[1]},
        function(data){                                                                 
            $("select[name='span_matakuliah']").closest("div.controls").append("<select name='span_matakuliah'></select>");
            $("select[name='span_matakuliah']").closest("div.combobox-container").remove();
            $("select[name='span_matakuliah']").html(data).combobox();
        });
    })                                         
    $("select[name='span_matakuliah']").combobox();
    
    function changeMahasiswa(){
        $('#listmahasiswa').hide();
        if($('#angatan_id').val()<=0) return;     
        var angkatan_id = ($('#angkatan_id').val()).split("-");
        var mode = 'view';      
            $.post('<?php echo base_url(); ?>rencana_mata_pelajaran/getOptMahasiswa', {angkatan_id: angkatan_id[1]},
        function(data){
            $('#listmahasiswa').html(data);
            $('#listmahasiswa').show();
        });
    } 
</script>

