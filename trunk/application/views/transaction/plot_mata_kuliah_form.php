<?php
$this->load->view('_shared/header');
$this->load->view('_shared/menus');

//label
$control_label = array(
    'class' => 'control-label'
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

$semester_data[0] = '';
foreach ($semester_options as $row) {
    $semester_data[$row->id] = $row->nama_semester;
}

$kelompok_matakuliah_data[0] = '';
foreach ($kelompok_matakuliah_options as $row) {
    $kelompok_matakuliah_data[$row->id] = $row->nama_kelompok_mata_kuliah;
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
<div class="container-full" id="plot_mata_kuliah">
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
                foreach ($get_matakuliah_detil_options as $row) {                              
                @$checked = in_array($row['id'], $detail_options) ? "checked='checked'" : "";    
                echo '<tr id="' . $row['id'] . '">
                        <td style="text-align: center">' . $no . '</td>    
                        <td>' . $row['kode_mata_kuliah'] . '</td>    
                        <td>' . $row['nama_mata_kuliah'] . '</td>
                        <td style="text-align: center">' . "<input type='hidden' name='id' id='cek' value=".$row['id']." ><input type='checkbox'". $checked ." name='mata_kuliah_id[]' id='cek' value=".$row['id']." >" . '</td>
                      </tr>';
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
    
    function changeAngkatan(){
        var angkatan_id = ($('#angkatan_id').val()).split("-");;
		//alert(angkatan_id);
	$.post('<?php echo base_url(); ?>plot_mata_kuliah/getOptTahunAkademik', {angkatan_id: angkatan_id[1]},
        function(data){
            $('#thn_akademik_id_attr').val(data);
        });
    }   
</script>