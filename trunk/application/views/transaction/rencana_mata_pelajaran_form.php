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
if(!empty($semester_options)){
    foreach ($semester_options as $row) {
        $semester_data[$row['semester_id']] = $row['nama_semester'];
    }
}
                                    
$program_data[0] = '';
if (isset($program_options)){
    foreach ($program_options as $row) {
        $program_data[$row['paket_mata_kuliah_id']] = $row['nama_program_studi'];
    }    
} 
else {
    $program_data[''] = '';
}

$matakuliah_data[0] = '';
if (isset($mata_kuliah_options)){
    foreach ($mata_kuliah_options as $row) {
        $matakuliah_data[$row['mata_kuliah_id']] = $row['nama_mata_kuliah'];
    }    
} 
else {
    $matakuliah_data[''] = '';
}
 
if (isset($paket_mata_kuliah->plot_mata_kuliah_id)){
    $plot_semester_id = $paket_mata_kuliah->plot_mata_kuliah_id;
}
else {
    $plot_semester_id = '';
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
        <?= form_label('Semester' , 'semester_id', $control_label); ?>
        <div class="controls">
            <?= form_dropdown('semester_id', $semester_data, set_value('semester_id', $semester_id), 'onChange="changeProgramStudi()" id="span_semester" class="input-medium" prevData-selected="' . set_value('semester_id', $semester_id) . '"'); ?>
            <p class="help-block"><?php echo form_error('semester_id') ?></p>
        </div>
    </div>
        
    <div class="control-group">
        <?= form_label('Konsentrasi Studi' , 'program_studi_id', $control_label); ?>
        <div class="controls">
            <?= form_dropdown('paket_mata_kuliah_id',$program_data, set_value('paket_mata_kuliah_id', $paket_mata_kuliah_id), 'onChange="changeMataKuliah()" id="span_program" class="input-medium" prevData-selected="' . set_value('paket_mata_kuliah_id', $paket_mata_kuliah_id) . '"'); ?>
            <p class="help-block"><?php echo form_error('program_studi_id') ?></p>
        </div>
    </div>
        
    <div class="control-group">
        <?= form_label('Mata Kuliah' , 'mata_kuliah_id', $control_label); ?>
        <div class="controls">
            <?= form_dropdown('mata_kuliah_id',$matakuliah_data, set_value('mata_kuliah_id', $mata_kuliah_id), 'onChange="changeMahasiswa()" id="span_mata_kuliah" class="input-medium" prevData-selected="' . set_value('mata_kuliah_id', $mata_kuliah_id) . '"'); ?>
            <p class="help-block"><?php echo form_error('mata_kuliah_id') ?></p>
        </div>
    </div>
    
    <span id="page" class="prev">Previous</span><span id="page" class="next">Next</span><br><br>
    <table class="table table-bordered table-striped container-full" id="recana_mata_pelajaran" controller="transaction">
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
            <?php
                if(isset($checked_mahasiswa)){
                    echo $checked_mahasiswa;                    
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
    
</script>    

<script type="text/javascript">
     var maxRows = 10;
    $('#recana_mata_pelajaran').each(function() {
    var cTable = $(this);
    var cRows = cTable.find('tr:gt(0)');
    var cRowCount = cRows.size();

        if (cRowCount < maxRows) {
            return;
        }

        cRows.each(function(i) {
            $(this).find('td:first').text(function(j, val) {
            return (i + 1) + val;
            }); 
        });

        cRows.filter(':gt(' + (maxRows - 1) + ')').hide();

        var cPrev = cTable.siblings('.prev');
        var cNext = cTable.siblings('.next');

        cPrev.addClass('disabled');

        cPrev.click(function() {
            var cFirstVisible = cRows.index(cRows.filter(':visible'));

            if (cPrev.hasClass('disabled')) {
                return false;
            }

            cRows.hide();
            if (cFirstVisible - maxRows - 1 > 0) {
                cRows.filter(':lt(' + cFirstVisible + '):gt(' + (cFirstVisible - maxRows - 1) + ')').show();
            } else {
                cRows.filter(':lt(' + cFirstVisible + ')').show();
            }

            if (cFirstVisible - maxRows <= 0) {
                cPrev.addClass('disabled');
            }

            cNext.removeClass('disabled');

            return false;
        });

        cNext.click(function() {
            var cFirstVisible = cRows.index(cRows.filter(':visible'));

            if (cNext.hasClass('disabled')) {
                return false;
            }

            cRows.hide();
            cRows.filter(':lt(' + (cFirstVisible +2 * maxRows) + '):gt(' + (cFirstVisible + maxRows - 1) + ')').show();

            if (cFirstVisible + 2 * maxRows >= cRows.size()) {
                cNext.addClass('disabled');
            }

            cPrev.removeClass('disabled');

            return false;
        });

    });
    function changeAngkatan(){
        var angkatan_id = ($('#angkatan_id').val()).split("-");
        $.post('<?php echo base_url(); ?>rencana_mata_pelajaran/getOptTahunAkademik', {angkatan_id: angkatan_id[1]},
        function(data){
            $('#thn_akademik_id_attr').val(data);
        });
        
       $.post('<?php echo base_url(); ?>rencana_mata_pelajaran/getOptSemester', {angkatan_id: angkatan_id[0]},
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
        $.post('<?php echo base_url(); ?>rencana_mata_pelajaran/getOptProgramStudi', {angkatan_id: angkatan_id[0], span_semester: span_semester[0]},
        function(data){                                                                 
            $("select[name='paket_mata_kuliah_id']").closest("div.controls").append("<select name='paket_mata_kuliah_id' onChange='changeMataKuliah()' id='span_program'></select>");
            $("select[name='paket_mata_kuliah_id']").closest("div.combobox-container").remove();
            $("select[name='paket_mata_kuliah_id']").html(data).combobox();
        });
    }
    $("select[name='paket_mata_kuliah_id']").combobox();
    
    function changeMataKuliah(){
        var angkatan_id   = ($('#angkatan_id').val());
        var span_semester = ($('#span_semester').val());
        var span_program  = ($('#span_program').val());
        $.post('<?php echo base_url(); ?>rencana_mata_pelajaran/getOptMataKuliah', {angkatan_id: angkatan_id[0], span_semester: span_semester[0], span_program: span_program[0]},
        function(data){                                                                 
            $("select[name='mata_kuliah_id']").closest("div.controls").append("<select name='mata_kuliah_id' onChange='changeMahasiswa()' id='span_mata_kuliah'></select>");
            $("select[name='mata_kuliah_id']").closest("div.combobox-container").remove();
            $("select[name='mata_kuliah_id']").html(data).combobox();
        });
    }
    $("select[name='mata_kuliah_id']").combobox(); 
   
    
    function changeMahasiswa(){ 
        $('#listmahasiswa').hide();
        if($('#span_mata_kuliah').val()<=0) return;                    
        var mode = 'view';
        var angkatan_id = ($('#angkatan_id').val());   
        $.post('<?php echo base_url(); ?>rencana_mata_pelajaran/getOptMahasiswa', {angkatan_id: angkatan_id[0]},
        function(data){
            $('#listmahasiswa').html(data);
            $('#listmahasiswa').show();
             var maxRows = 10;
            $('#recana_mata_pelajaran').each(function() {
            var cTable = $(this);
            var cRows = cTable.find('tr:gt(0)');
            var cRowCount = cRows.size();

                if (cRowCount < maxRows) {
                    return;
                }

                cRows.each(function(i) {
                    $(this).find('td:first').text(function(j, val) {
                    return (i + 1) + val;
                    }); 
                });

                cRows.filter(':gt(' + (maxRows - 1) + ')').hide();

                var cPrev = cTable.siblings('.prev');
                var cNext = cTable.siblings('.next');

                cPrev.addClass('disabled');

                cPrev.click(function() {
                    var cFirstVisible = cRows.index(cRows.filter(':visible'));

                    if (cPrev.hasClass('disabled')) {
                        return false;
                    }

                    cRows.hide();
                    if (cFirstVisible - maxRows - 1 > 0) {
                        cRows.filter(':lt(' + cFirstVisible + '):gt(' + (cFirstVisible - maxRows - 1) + ')').show();
                    } else {
                        cRows.filter(':lt(' + cFirstVisible + ')').show();
                    }

                    if (cFirstVisible - maxRows <= 0) {
                        cPrev.addClass('disabled');
                    }

                    cNext.removeClass('disabled');

                    return false;
                });

                cNext.click(function() {
                    var cFirstVisible = cRows.index(cRows.filter(':visible'));

                    if (cNext.hasClass('disabled')) {
                        return false;
                    }

                    cRows.hide();
                    cRows.filter(':lt(' + (cFirstVisible +2 * maxRows) + '):gt(' + (cFirstVisible + maxRows - 1) + ')').show();

                    if (cFirstVisible + 2 * maxRows >= cRows.size()) {
                        cNext.addClass('disabled');
                    }

                    cPrev.removeClass('disabled');

                    return false;
                });

            });
        });
    }
</script>

