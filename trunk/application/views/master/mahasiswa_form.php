<?php
$this->load->view('_shared/header');
$this->load->view('_shared/menus');

//label
$control_label = array(
    'class' => 'control-label'
);

$kode_dik_attr = array(
    'name' => 'kode_dik',
    'class' => 'input-small',
    'value' => set_value('kode_dik', $kode_dik),
    'autocomplete' => 'off'
);

$angkatan_data[0] = '';
foreach ($angkatan_options as $row) {
    $angkatan_data[$row->id] = $row->nama_angkatan;
}

$kode_dik_ang_attr = array(
    'name' => 'kode_dik_ang',
    'class' => 'input-small',
    'value' => set_value('kode_dik_ang', $kode_dik_ang),
    'autocomplete' => 'off'
);

$nama_jenis_dik_attr = array(
    'name' => 'nama_jenis_dik',
    'class' => 'input-medium',
    'value' => set_value('nama_jenis_dik', $nama_jenis_dik),
    'autocomplete' => 'off'
);

$sebutan_dik_attr = array(
    'name' => 'sebutan_dik',
    'class' => 'input-medium',
    'value' => set_value('sebutan_dik', $sebutan_dik),
    'autocomplete' => 'off'
);

$nim_attr = array(
    'name' => 'nim',
    'class' => 'input-small',
    'value' => set_value('nim', $nim),
    'autocomplete' => 'off'
);

$nama_attr = array(
    'name' => 'nama',
    'class' => 'input-medium',
    'value' => set_value('nama', $nama),
    'autocomplete' => 'off'
);



$program_studi_data[0] = '';
foreach ($program_studi_options as $row) {
    $program_studi_data[$row->id] = $row->nama_program_studi;
}

$jenjang_studi_data[0] = '';
foreach ($jenjang_studi_options as $row) {
    $jenjang_studi_data[$row->id] = $row->jenjang_studi;
}

$konsentrasi_studi_data[0] = '';
foreach ($konsentrasi_studi_options as $row) {
    $konsentrasi_studi_data[$row->id] = $row->nama_konsentrasi_studi;
}

$tempat_lahir_attr = array(
    'name' => 'tempat_lahir',
    'class' => 'input-medium',
    'value' => set_value('tempat_lahir', $tempat_lahir),
    'autocomplete' => 'off'
);

$tgl_lahir_attr = array(
    'name' => 'tgl_lahir',
    'class' => 'input-small',
    'value' => set_value('tgl_lahir', $tgl_lahir),
    'autocomplete' => 'off'
);

$jenis_kelamin_data[0] = '';
foreach ($jenis_kelamin_options as $row) {
    $jenis_kelamin_data[$row->id] = $row->jenis_kelamin;
}

$agama_data[0] = '';
foreach ($agama_options as $row) {
    $agama_data[$row->id] = $row->agama;
}

$status_aktifitas_mhs_attr = array(
    'name' => 'status_aktifitas_mhs',
    'class' => 'input-medium',
    'value' => set_value('status_aktifitas_mhs', $status_aktifitas_mhs),
    'autocomplete' => 'off'
);



$jml_sks_diakui_attr = array(
    'name' => 'jml_sks_diakui',
    'class' => 'input-mini',
    'value' => set_value('jml_sks_diakui', $jml_sks_diakui),
    'autocomplete' => 'off'
);

$perguruan_tinggi_sebelumnya_attr = array(
    'name' => 'perguruan_tinggi_sebelumnya',
    'class' => 'input-medium',
    'value' => set_value('perguruan_tinggi_sebelumnya', $perguruan_tinggi_sebelumnya),
    'autocomplete' => 'off'
);

$jurusan_sebelumnya_attr = array(
    'name' => 'jurusan_sebelumnya',
    'class' => 'input-medium',
    'value' => set_value('jurusan_sebelumnya', $jurusan_sebelumnya),
    'autocomplete' => 'off'
);

$propinsi_asal_slta_attr = array(
    'name' => 'propinsi_asal_slta',
    'class' => 'input-medium',
    'value' => set_value('propinsi_asal_slta', $propinsi_asal_slta),
    'autocomplete' => 'off'
);

$kota_asal_slta_attr = array(
    'name' => 'kota_asal_slta',
    'class' => 'input-medium',
    'value' => set_value('kota_asal_slta', $kota_asal_slta),
    'autocomplete' => 'off'
);

$nama_slta_attr = array(
    'name' => 'nama_slta',
    'class' => 'input-medium',
    'value' => set_value('nama_slta', $nama_slta),
    'autocomplete' => 'off'
);

$jurusan_slta_attr = array(
    'name' => 'jurusan_slta',
    'class' => 'input-medium',
    'value' => set_value('jurusan_slta', $jurusan_slta),
    'autocomplete' => 'off'
);

$alamat_attr = array(
    'name' => 'alamat',
    'class' => 'input-xlarge',
    'value' => set_value('alamat', $alamat),
    'autocomplete' => 'off'
);

$telepon_attr = array(
    'name' => 'telepon',
    'class' => 'input-medium',
    'value' => set_value('telepon', $telepon),
    'autocomplete' => 'off'
);

$hobby_attr = array(
    'name' => 'hobby',
    'class' => 'input-medium',
    'value' => set_value('hobby', $hobby),
    'autocomplete' => 'off'
);

$foto_mahasiswa_attr = array(
    'name' => 'foto_mahasiswa',
    'class' => 'input-medium',
    'value' => set_value('foto_mahasiswa', $foto_mahasiswa),
    'autocomplete' => 'off'
);

$span_pangkat_attr = array(
    'id'    => 'span_pangkat',
    'name'  => 'span_pangkat',
    'class' => 'input-medium',
    'value' => set_value('span_pangkat', ''),
    'autocomplete' => 'off'
);

$pangkat_data[0] = '';
foreach ($pangkat_options as $row) {
    $pangkat_data[$row->id."-".$row->nama_pangkat] = $row->kode_pangkat;
}

$jabatan_tertinggi_data[0] = '';
foreach ($jabatan_tertinggi_options as $row) {
    $jabatan_tertinggi_data[$row->id] = $row->jabatan_tertinggi;
}

$kesatuan_asal_data[0] = '';
foreach ($kesatuan_asal_options as $row) {
    $kesatuan_asal_data[$row->id] = $row->nama_kesatuan_asal;
}

$nrp_attr = array(
    'name' => 'nrp',
    'class' => 'input-small',
    'value' => set_value('nrp', $nrp),
    'autocomplete' => 'off'
);

$dik_abri_attr = array(
    'name' => 'dik_abri',
    'class' => 'input-medium',
    'value' => set_value('dik_abri', $dik_abri),
    'autocomplete' => 'off'
);

$thn_dik_abri_attr = array(
    'name' => 'thn_dik_abri',
    'class' => 'input-small',
    'value' => set_value('thn_dik_abri', $thn_dik_abri),
    'autocomplete' => 'off'
);

$sindikat_attr = array(
    'name' => 'sindikat',
    'class' => 'input-mini',
    'value' => set_value('sindikat', $sindikat),
    'autocomplete' => 'off'
);

$nama_istri_attr = array(
    'name' => 'nama_istri',
    'class' => 'input-medium',
    'value' => set_value('nama_istri', $nama_istri),
    'autocomplete' => 'off'
);

$anak_data[0] = '';
foreach ($anak_options as $row) {
    $anak_data[$row->id] = $row->nama_anak;
}

?>
<div class="container-full" id="mahasiswa">
    <?= form_open_multipart($action_url, array('class' => 'form-horizontal')); ?>
    
     <div class="control-group">
        <?= form_label('Kode Dik' . required(), 'kode_dik', $control_label); ?>
        <div class="controls">
            <?= form_input($kode_dik_attr) ?>
            <p class="help-block"><?php echo form_error('kode_dik') ?></p>
        </div>
    </div>
    
    <div class="control-group">
        <?= form_label('Angkatan', 'angkatan_id', $control_label); ?>
        <div class="controls">
            <?= form_dropdown('angkatan_id', $angkatan_data, set_value('angkatan_id', $angkatan_id), 'id="angkatan_id" class="input-medium" prevData-selected="' . set_value('angkatan_id', $angkatan_id) . '"'); ?>
            <p class="help-block"><?php echo form_error('angkatan_id') ?></p>
        </div>
    </div>
    
        
     <div class="control-group">
        <?= form_label('Kode Dik Ang' . required(), 'kode_dik_ang', $control_label); ?>
        <div class="controls">
            <?= form_input($kode_dik_ang_attr) ?>
            <p class="help-block"><?php echo form_error('kode_dik_ang') ?></p>
        </div>
    </div>
    
     <div class="control-group">
        <?= form_label('Jenis Dik' . required(), 'nama_jenis_dik', $control_label); ?>
        <div class="controls">
            <?= form_input($nama_jenis_dik_attr) ?>
            <p class="help-block"><?php echo form_error('nama_jenis_dik') ?></p>
        </div>
    </div>
    
    
     <div class="control-group">
        <?= form_label('Sebutan Dik' . required(), 'sebutan_dik', $control_label); ?>
        <div class="controls">
            <?= form_input($sebutan_dik_attr) ?>
            <p class="help-block"><?php echo form_error('sebutan_dik') ?></p>
        </div>
    </div>
    
    <div class="control-group">
        <?= form_label('Nim' . required(), 'nim', $control_label); ?>
        <div class="controls">
            <?= form_input($nim_attr) ?>
            <p class="help-block"><?php echo form_error('nim') ?></p>
        </div>
    </div>
    
     <div class="control-group">
        <?= form_label('Nama' . required(), 'nama', $control_label); ?>
        <div class="controls">
            <?= form_input($nama_attr) ?>
            <p class="help-block"><?php echo form_error('nama') ?></p>
        </div>
    </div>
    
    <div class="control-group">
        <?= form_label('Program Studi', 'program_studi_id', $control_label); ?>
        <div class="controls">
            <?= form_dropdown('program_studi_id', $program_studi_data, set_value('program_studi_id', $program_studi_id), 'id="program_studi_id" class="input-medium" prevData-selected="' . set_value('program_studi_id', $program_studi_id) . '"'); ?>
            <p class="help-block"><?php echo form_error('jenjang_studi_id') ?></p>
        </div>
    </div>
    
    <div class="control-group">
        <?= form_label('Jenjang Studi', 'jenjang_studi_id', $control_label); ?>
        <div class="controls">
            <?= form_dropdown('jenjang_studi_id', $jenjang_studi_data, set_value('jenjang_studi_id', $program_studi_id), 'id="jenjang_studi_id" class="input-medium" prevData-selected="' . set_value('jenjang_studi_id', $jenjang_studi_id) . '"'); ?>
            <p class="help-block"><?php echo form_error('jenjang_studi_id') ?></p>
        </div>
    </div>
    
    <div class="control-group">
        <?= form_label('Konsentrasi Studi', 'kons_studi_id', $control_label); ?>
        <div class="controls">
            <?= form_dropdown('kons_studi_id', $konsentrasi_studi_data, set_value('kons_studi_id', $kons_studi_id), 'id="kons_studi_id" class="input-medium" prevData-selected="' . set_value('kons_studi_id', $kons_studi_id) . '"'); ?>
            <p class="help-block"><?php echo form_error('kons_studi_id') ?></p>
        </div>
    </div>

    <div class="control-group">
        <?= form_label('Tempat Lahir', 'tempat_lahir', $control_label); ?>
        <div class="controls">
            <?= form_input($tempat_lahir_attr) ?>
            <p class="help-block"><?php echo form_error('tempat_lahir') ?></p>
        </div>
    </div>

    

    <div class="control-group">
        <?= form_label('Tanggal Lahir' , 'tgl_lahir', $control_label); ?>
        <div class="controls">
            <?= form_input($tgl_lahir_attr) ?>
            <p class="help-block"><?php echo form_error('tgl_lahir') ?></p>
        </div>
    </div>
    
    <div class="control-group">
        <?= form_label('Jenis Kelamin', 'jenis_kelamin_id', $control_label); ?>
        <div class="controls">
            <?= form_dropdown('jenis_kelamin_id', $jenis_kelamin_data, set_value('jenis_kelamin_id', $jenis_kelamin_id), 'id="jenis_kelamin_id" class="input-medium" prevData-selected="' . set_value('jenis_kelamin_id', $jenis_kelamin_id) . '"'); ?>
            <p class="help-block"><?php echo form_error('jenis_kelamin_id') ?></p>
        </div>
    </div>
    
    <div class="control-group">
        <?= form_label('Agama', 'agama_id', $control_label); ?>
        <div class="controls">
            <?= form_dropdown('agama_id', $agama_data, set_value('agama_id', $agama_id), 'id="agama_id" class="input-medium" prevData-selected="' . set_value('agama_id', $agama_id) . '"'); ?>
            <p class="help-block"><?php echo form_error('agama_id') ?></p>
        </div>
    </div>

    <div class="control-group">
        <?= form_label('Status Aktifitas MHS' , 'no_dosen_dikti', $control_label); ?>
        <div class="controls">
            <?= form_input($status_aktifitas_mhs_attr) ?>
            <p class="help-block"><?php echo form_error('status_aktifitas_mhs') ?></p>
        </div>
    </div>

    <div class="control-group">
        <?= form_label('Jumlah SKS' , 'jml_sks_diakui', $control_label); ?>
        <div class="controls">
            <?= form_input($jml_sks_diakui_attr) ?>
            <p class="help-block"><?php echo form_error('jml_sks_diakui') ?></p>
        </div>
    </div>

    <div class="control-group">
        <?= form_label('Perguruan Tinggi Sebelumnya', 'perguruan_tinggi_sebelumnya', $control_label); ?>
        <div class="controls">
            <?= form_input($perguruan_tinggi_sebelumnya_attr) ?>
            <p class="help-block"><?php echo form_error('perguruan_tinggi_sebelumnya') ?></p>
        </div>
    </div>

    <div class="control-group">
        <?= form_label('Jurusan Sebelumnya', 'jurusan_sebelumnya', $control_label); ?>
        <div class="controls">
            <?= form_input($jurusan_sebelumnya_attr) ?>
            <p class="help-block"><?php echo form_error('jurusan_sebelumnya') ?></p>
        </div>
    </div>
    
    <div class="control-group">
        <?= form_label('Propinsi SLTA', 'propinsi_asal_slta', $control_label); ?>
        <div class="controls">
            <?= form_input($propinsi_asal_slta_attr) ?>
            <p class="help-block"><?php echo form_error('propinsi_asal_slta') ?></p>
        </div>
    </div>
    
    <div class="control-group">
        <?= form_label('Kota SLTA', 'kota_asal_slta', $control_label); ?>
        <div class="controls">
            <?= form_input($kota_asal_slta_attr) ?>
            <p class="help-block"><?php echo form_error('kota_asal_slta') ?></p>
        </div>
    </div>
    
    <div class="control-group">
        <?= form_label('Nama SLTA', 'nama_slta', $control_label); ?>
        <div class="controls">
            <?= form_input($nama_slta_attr) ?>
            <p class="help-block"><?php echo form_error('nama_slta') ?></p>
        </div>
    </div>
    
    <div class="control-group">
        <?= form_label('Jurusan SLTA', 'jurusan_slta', $control_label); ?>
        <div class="controls">
            <?= form_input($jurusan_slta_attr) ?>
            <p class="help-block"><?php echo form_error('jurusan_slta') ?></p>
        </div>
    </div>
    
    <div class="control-group">
        <?= form_label('Alamat', 'alamat', $control_label); ?>
        <div class="controls">
            <?= form_input($alamat_attr) ?>
            <p class="help-block"><?php echo form_error('alamat') ?></p>
        </div>
    </div>
    
    <div class="control-group">
        <?= form_label('Telepon', 'telepon', $control_label); ?>
        <div class="controls">
            <?= form_input($telepon_attr) ?>
            <p class="help-block"><?php echo form_error('telepon') ?></p>
        </div>
    </div>
    
    <div class="control-group">
        <?= form_label('Hobby', 'hobby', $control_label); ?>
        <div class="controls">
            <?= form_input($hobby_attr) ?>
            <p class="help-block"><?php echo form_error('hobby') ?></p>
        </div>
    </div>
    
    <div class="control-group">
        <?php echo form_open_multipart('mahasiswa/do_Upload'); ?>
        <?= form_label('Foto Mahasiswa', 'foto_mahasiswa', $control_label); ?>
        <div class="controls">
            <?= form_upload($foto_mahasiswa_attr) ?>
            <p class="help-block"><?php echo form_error('foto') ?></p>
        </div>
    </div>
    
    <div class="control-group">
        <?= form_label('Jabatan Tertinggi', 'jabatan_akhir_id', $control_label); ?>
        <div class="controls">
            <?= form_dropdown('jabatan_akhir_id', $jabatan_tertinggi_data, set_value('jabatan_akhir_id', $jabatan_akhir_id), 'id="jabatan_akhir_id" class="input-medium" prevData-selected="' . set_value('jabatan_akhir_id', $jabatan_akhir_id) . '"'); ?>
            <p class="help-block"><?php echo form_error('jabatan_akhir_id') ?></p>
        </div>
    </div>
    
    <div class="control-group">
        <?= form_label('Kesatuan Asal', 'kesatuan_asal_id', $control_label); ?>
        <div class="controls">
            <?= form_dropdown('kesatuan_asal_id', $kesatuan_asal_data, set_value('kesatuan_asal_id', $kesatuan_asal_id), 'id="kesatuan_asal_id" class="input-medium" prevData-selected="' . set_value('kesatuan_asal_id', $kesatuan_asal_id) . '"'); ?>
            <p class="help-block"><?php echo form_error('satuan_asal_id') ?></p>
        </div>
    </div>
    
    <div class="control-group">
        <?= form_label('Kode Pangkat', 'pangkat_id', $control_label); ?>
        <div class="controls">
            <?= form_dropdown('pangkat_id', $pangkat_data, set_value('pangkat_id', $pangkat_id), 'id="pangkat_id" class="input-medium" prevData-selected="' . set_value('pangkat_id', $pangkat_id) . '"'); ?>  
            <p class="help-block"><?php echo form_error('pangkat_id') ?></p>
        </div>
    </div>
    
    <div class="control-group">
        <?= form_label('Nama Pangkat', 'nama_pangkat', $control_label); ?>
        <div class="controls">
             <?=form_input($span_pangkat_attr) ?>
            <p class="help-block"><?php echo form_error('nama_pangkat') ?></p>
        </div>
    </div>
    
    <div class="control-group">
        <?= form_label('NRP', 'nrp', $control_label); ?>
        <div class="controls">
            <?= form_input($nrp_attr) ?>
            <p class="help-block"><?php echo form_error('nrp') ?></p>
        </div>
    </div>
    
    <div class="control-group">
        <?= form_label('Dik Abri', 'dik_abri', $control_label); ?>
        <div class="controls">
            <?= form_input($dik_abri_attr) ?>
            <p class="help-block"><?php echo form_error('dik_abri') ?></p>
        </div>
    </div>
    
    <div class="control-group">
        <?= form_label('Tahun Dik Abri', 'thn_dik_abri', $control_label); ?>
        <div class="controls">
            <?= form_input($thn_dik_abri_attr) ?>
            <p class="help-block"><?php echo form_error('thn_dik_abri') ?></p>
        </div>
    </div>
    
    <div class="control-group">
        <?= form_label('Sindikat', 'sindikat', $control_label); ?>
        <div class="controls">
            <?= form_input($sindikat_attr) ?>
            <p class="help-block"><?php echo form_error('sindikat') ?></p>
        </div>
    </div>
    
    <div class="control-group">
        <?= form_label('Nama Istri', 'nama_istri', $control_label); ?>
        <div class="controls">
            <?= form_input($nama_istri_attr) ?>
            <p class="help-block"><?php echo form_error('nama_istri') ?></p>
        </div>
    </div>
    
    <div class="control-group">
        <?= form_label('Anak', 'anak_id', $control_label); ?>
        <div class="controls">
            <?= form_dropdown('anak_id', $anak_data, set_value('anak_id', $anak_id), 'id="anak_id" class="input-medium" prevData-selected="' . set_value('anak_id', $anak_id) . '"'); ?>
            <p class="help-block"><?php echo form_error('anak_id') ?></p>
        </div>
    </div>

    <div class="form-actions well">
        <button class="btn btn-small btn-primary" type="submit">Simpan</button>
    </div>
    <?php form_close() ?>
</div>
<?php $this->load->view('_shared/footer'); ?>
