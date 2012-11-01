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

$pangkat_data[0] = '';
if (isset($m_tahun_akademik)){
    foreach ($m_tahun_akademik as $row) {
        $pangkat_data[$row['id']] = $row['tahun_ajar_mulai'].'-'.$row['tahun_ajar_akhir'];
    }    
}
else {
    $pangkat_data[''] = '';
}


$semester_data[0] = '';
foreach ($semester_options as $row) {
    $semester_data[$row->id] = $row->nama_semester;
}

$kelompok_matakuliah_data[0] = '';
foreach ($kelompok_matakuliah_options as $row) {
    $kelompok_matakuliah_data[$row->id] = $row->nama_kelompok_mata_kuliah;
}

if (isset($m_angkatan->tahun_akademik_id)){
    $thn_akademik_id = $m_angkatan->tahun_akademik_id;
}
else {
    $thn_akademik_id = '';
}
                 

?>
<div class="container-full" id="plot_mata_kuliah">
<?= form_open($action_url, array('class' => 'form-horizontal')); ?>
    
    <div class="control-group">
        <?= form_label('Angkatan' . required(), 'angkatan_id', $control_label); ?>
        <div class="controls">
            <?= form_dropdown('angkatan_id', $angkatan_data, set_value('angkatan_id', $angkatan_id."-".$thn_akademik_id), 'id="angkatan_id" class="input-medium" prevData-selected="' . set_value('angkatan_id', $angkatan_id) . '"'); ?>
            <p class="help-block"><?php echo form_error('angkatan_id') ?></p>
        </div>
    </div>

    <div class="control-group">
        <?= form_label('Tahun Akademik' , 'tahun_akademik_id', $control_label); ?>
        <div class="controls">
            <?= form_dropdown('span_pangkat', $pangkat_data, set_value('thn_akademik_id', $angkatan_id), 'id="thn_akademik_id" class="input-medium" prevData-selected="' . set_value('thn_akademik_id', $angkatan_id) . '"'); ?>
            <p class="help-block"><?php echo form_error('tahun_ajar') ?></p>
        </div>
    </div>
    
    <div class="control-group">
        <?= form_label('Semester' , 'semester_id', $control_label); ?>
        <div class="controls">
            <?= form_dropdown('semester_id', $semester_data, set_value('semester_id', $semester_id), 'id="semester_id" class="input-medium" prevData-selected="' . set_value('semester_id', $semester_id) . '"'); ?>
            <p class="help-block"><?php echo form_error('semester_id') ?></p>
        </div>
    </div>
    
    <div class="control-group">
        <?= form_label('Kelompok Matakuliah' , 'kelompok_mata_kuliah_id', $control_label); ?>
        <div class="controls">
            <?= form_dropdown('kelompok_mata_kuliah_id', $kelompok_matakuliah_data, set_value('kelompok_mata_kuliah_id', $kelompok_mata_kuliah_id), 'id="kelompok_mata_kuliah_id" class="input-medium" prevData-selected="' . set_value('kelompok_mata_kuliah_id', $kelompok_mata_kuliah_id) . '"'); ?>
            <p class="help-block"><?php echo form_error('kelompok_matakuliah_id') ?></p>
        </div>
    </div>

    <div class="container">
        <div class="pagination pagination-centered">
            <div id="pageNavPosition"></div> 
        </div>
    </div>

    <table class="table table-bordered table-striped container-full"  id="plot_maata_kuliah" controller="transaction">
        <thead>
            <tr>
                <th width="20">No</th>
                <th>Kode Mata Kuliah</th>
                <th>Nama Mata Kuliah</th>
                <th width="30" style="text-align: center;"> 
                    <input type="checkbox" id="1" class="ck" style="cursor: pointer" onclick="cek_all('.ck')">
                </th>
            </tr>
        </thead>
        <tbody>
            <?php                                           
                $no = 1;
                foreach ($mata_kuliah_options as $row) {
                echo '<tr id="' . $row->id . '">
                        <td style="text-align: center">' . $no . '</td>    
                        <td>' . $row->kode_mata_kuliah . '</td>    
                        <td>' . $row->nama_mata_kuliah . '</td>';
                        @$checked = in_array($row->id, $get_matakuliah_detil_options) ? "checked='checked'" : "";
                        if(empty($checked)){
                            echo "<td style='text-align: center'>
                                    <input type='checkbox' name='mata_kuliah_id[]' id='cek' value='$row->id' >   
                                </td>"; 
                        }else{
                            echo "<td style='text-align: center'>
                                    <input type='checkbox' $checked name='mata_kuliah_id[]' id='cek' value='$row->id' >   
                                </td>"; 
                        }
                 echo'</tr>
                ';
                $no++;                    
                }
                
            ?>
        </tbody>
    </table>
    
    <div class="form-actions well">
        <button class="btn btn-small btn-primary" type="submit">Simpan</button>
    </div>
<?php form_close() ?>
</div>
    <?php $this->load->view('_shared/footer'); ?>

<script type="text/javascript">
    var pager = new Pager('plot_maata_kuliah', 10); 
    pager.init(); 
    pager.showPageNav('pager', 'pageNavPosition'); 
    pager.showPage(1);
    $("#angkatan_id").change(function(){
        var value = ($(this).val()).split("-");
        $.post('<?php echo base_url(); ?>plot_mata_kuliah/getOptTahunAkademik', {angkatan_id: value[1]},
        function(data){
            $("select[name='span_pangkat']").closest("div.controls").append("<select name='span_pangkat'></select>");
            $("select[name='span_pangkat']").closest("div.combobox-container").remove();
            $("select[name='span_pangkat']").html(data).combobox();
        });
    })
    $("select[name='span_pangkat']").combobox();
</script>