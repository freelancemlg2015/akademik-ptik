<?php
$this->load->view('_shared/header');
$this->load->view('_shared/menus');

//label
$control_label = array(
    'class' => 'control-label'
);

$nim_attr = array(
    'name' => 'nim',
    'class' => 'input-small',
    'value' => set_value('nim', $nim),
    'autocomplete' => 'off'
);

$nama_attr = array(
    'name' => 'nama',
    'class' => 'input-xlarge',
    'value' => set_value('nama', $nama),
    'autocomplete' => 'off'
);

$tempet_lahir_attr = array(
    'name' => 'tempet_lahir',
    'class' => 'input-medium',
    'value' => set_value('tempet_lahir', $tempet_lahir),
    'autocomplete' => 'off'
);

$tgl_lahir_attr = array(
    'name' => 'tgl_lahir',
    'class' => 'input-small',
    'value' => set_value('tgl_lahir', $tgl_lahir),
    'autocomplete' => 'off'
);

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
    'class' => 'input-xlarge',
    'value' => set_value('jurusan_sebelumnya', $jurusan_sebelumnya),
    'autocomplete' => 'off'
);

$judicium_attr = array(
    'name' => 'judicium',
    'class' => 'input-medium',
    'value' => set_value('judicium', $judicium),
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
    'class' => 'span3',
    'value' => set_value('alamat', $alamat),
    'autocomplete' => 'off'
);

$telepon_attr = array(
    'name' => 'telepon',
    'class' => 'input-medium',
    'value' => set_value('telepon', $telepon),
    'autocomplete' => 'off'
);

$foto_attr = array(
    'name' => 'foto',
    'class' => 'input-xlarge',
    'value' => set_value('foto', $foto),
    'autocomplete' => 'off'
);

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
    'class' => 'input-mini',
    'value' => set_value('thn_dik_abri', $thn_dik_abri),
    'autocomplete' => 'off'
);

$nama_ayah_attr = array(
    'name' => 'nama_ayah',
    'class' => 'input-xlarge',
    'value' => set_value('nama_ayah', $nama_ayah),
    'autocomplete' => 'off'
);

$pekerjaan_ayah_attr = array(
    'name' => 'pekerjaan_ayah',
    'class' => 'input-xlarge',
    'value' => set_value('pekerjaan_ayah', $pekerjaan_ayah),
    'autocomplete' => 'off'
);

$tgl_lahir_ayah_attr = array(
    'name' => 'tgl_lahir_ayah',
    'class' => 'input-small',
    'value' => set_value('tgl_lahir_ayah', $tgl_lahir_ayah),
    'autocomplete' => 'off'
);

$pendidikan_ayah_attr = array(
    'name' => 'pendidikan_ayah',
    'class' => 'input-meidum',
    'value' => set_value('pendidikan_ayah', $pendidikan_ayah),
    'autocomplete' => 'off'
);

$alamat_ayah_attr = array(
    'name' => 'alamat_ayah',
    'class' => 'span3',
    'value' => set_value('alamat_ayah', $alamat_ayah),
    'autocomplete' => 'off'
);

$no_telepon_attr = array(
    'name' => 'no_telepon',
    'class' => 'input-medium',
    'value' => set_value('no_telepon', $no_telepon),
    'autocomplete' => 'off'
);

$nama_wali_attr = array(
    'name' => 'nama_wali',
    'class' => 'input-xlarge',
    'value' => set_value('nama_wali', $nama_wali),
    'autocomplete' => 'off'
);

$pekerjaan_wali_attr = array(
    'name' => 'pekerjaan_wali',
    'class' => 'input-medium',
    'value' => set_value('pekerjaan_wali', $pekerjaan_wali),
    'autocomplete' => 'off'
);

$tgl_lahir_wali_attr = array(
    'name' => 'pekerjaan_wali',
    'class' => 'input-small',
    'value' => set_value('pekerjaan_wali', $pekerjaan_wali),
    'autocomplete' => 'off'
);

$pendidikan_wali_attr = array(
    'name' => 'pekerjaan_wali',
    'class' => 'input-medium',
    'value' => set_value('pekerjaan_wali', $pekerjaan_wali),
    'autocomplete' => 'off'
);

$alamat_wali_attr = array(
    'name' => 'alamat_wali',
    'class' => 'span3',
    'value' => set_value('alamat_wali', $alamat_wali),
    'autocomplete' => 'off'
);

$angkatan_data[0] = '-PILIH-';
foreach ($angkatan_options as $row) {
    $angkatan_data[$row->id] = $row->nama_angkatan;
}

$program_studi_data[0] = '-PILIH-';
foreach ($program_studi_studi_options as $row) {
    $program_studi_data[$row->id] = $row->nama_program_studi;
}

$jenjang_studi_data[0] = '-PILIH-';
foreach ($jenjang_studi_options as $row) {
    $jenjang_studi_data[$row->id] = $row->jenjang_studi;
}

$konsentrasi_studi_data[0] = '-PILIH-';
foreach ($konsentrasi_studi_options as $row) {
    $konsentrasi_studi_data[$row->id] = $row->nama_konsentrasi_studi;
}

$jenis_kelamin_data[0] = '-PILIH-';
foreach ($jenis_kelamin_options as $row) {
    $jenis_kelamin_data[$row->id] = $row->jenis_kelamin;
}

$agama_data[0] = '-PILIH-';
foreach ($agama_options as $row) {
    $agam_data[$row->id] = $row->agama;
}

$status_dosen_penasehat_data[0] = '-PILIH-';
foreach ($status_dosen_penasehat_options as $row) {
    $status_dosen_penasehat_data[$row->id] = $row->status_dosen_penasehat;
}

$jabatan_tertinggi_data[0] = '-PILIH-';
foreach ($jabatan_tertinggi_options as $row) {
    $jabatan_tertinggi_data[$row->id] = $row->jabatan_tertinggi;
}

$kesatuan_asal_data[0] = '-PILIH-';
foreach ($kesatuan_asal_options as $row) {
    $kesatuan_asal_data[$row->id] = $row->nama_kesatuan_asal;
}

$pangkat_data[0] = '-PILIH-';
foreach ($pangkat_options as $row) {
    $pangkat_data[$row->id] = $row->nama_pangkat;
}

$agama_data[0] = '-PILIH-';
foreach ($agama_options as $row) {
    $agam_data[$row->id] = $row->agama;
}

$agama_data[0] = '-PILIH-';
foreach ($agama_options as $row) {
    $agam_data[$row->id] = $row->agama;
}

?>
<div class="container-full" id="data_mahasiswa">
    <?= form_open($action_url, array('class' => 'form-horizontal')); ?>

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
        <?= form_label('Angkatan', 'angkatan_id', $control_label); ?>
        <div class="controls">
            <?= form_dropdown('angkatan_id', $angkatan_data, set_value('angkatan_id', $angkatan_id), 'id="angkatan_id" class="input-medium" prevData-selected="' . set_value('angkatan_id', $angkatan_id) . '"') . '&nbsp;&nbsp;'; ?>
            <p class="help-block"><?php echo form_error('angkatan_id') ?></p>
        </div>
    </div>
    
    <div class="control-group">
        <?= form_label('Program Studi', 'program_studi_id', $control_label); ?>
        <div class="controls">
            <?= form_dropdown('program_studi_id', $program_studi_data, set_value('program_studi_id', $angkatan_id), 'id="program_studi_id" class="input-medium" prevData-selected="' . set_value('program_studi_id', $program_studi_id) . '"') . '&nbsp;&nbsp;'; ?>
            <p class="help-block"><?php echo form_error('program_studi_id') ?></p>
        </div>
    </div>
    
    <div class="control-group">
        <?= form_label('Jenjang Studi', 'jenjang_studi_id', $control_label); ?>
        <div class="controls">
            <?= form_dropdown('jenjang_studi_id', $program_studi_data, set_value('jenjang_studi_id', $angkatan_id), 'id="jenjang_studi_id" class="input-medium" prevData-selected="' . set_value('jenjang_studi_id', $jenjang_studi_id) . '"') . '&nbsp;&nbsp;'; ?>
            <p class="help-block"><?php echo form_error('jenjang_studi_id') ?></p>
        </div>
    </div>

    <div class="control-group">
        <?= form_label('Konsentrasi Studi', 'kons_studi_id', $control_label); ?>
        <div class="controls">
            <?= form_dropdown('kons_studi_id', $konsentrasi_studi_data, set_value('kons_studi_id', $angkatan_id), 'id="kons_studi_id" class="input-medium" prevData-selected="' . set_value('kons_studi_id', $kons_studi_id) . '"') . '&nbsp;&nbsp;'; ?>
            <p class="help-block"><?php echo form_error('jenjang_studi_id') ?></p>
        </div>
    </div>
    
    <div class="control-group">
        <?= form_label('Tempat Lahir' . required(), 'tempat_lahir', $control_label); ?>
        <div class="controls">
            <?= form_input($tempat_lahir_attr) ?>
            <p class="help-block"><?php echo form_error('tempat_lahir') ?></p>
        </div>
    </div>
    
    <div class="control-group">
        <?= form_label('Tanggal Lahir' . required(), 'tgl_lahir', $control_label); ?>
        <div class="controls">
            <?= form_input($tgl_lahir_attr) ?>
            <p class="help-block"><?php echo form_error('tgl_lahir') ?></p>
        </div>
    </div>
    
    <div class="control-group">
        <?= form_label('Jenis Kelamin', 'jenis_kelamin_id', $control_label); ?>
        <div class="controls">
            <?= form_dropdown('jenis_kelamin_id', $jenis_kelamin_data, set_value('jenis_kelamin_id', $angkatan_id), 'id="jenis_kelamin_id" class="input-medium" prevData-selected="' . set_value('jenis_kelamin_id', $jenis_kelamin_id) . '"') . '&nbsp;&nbsp;'; ?>
            <p class="help-block"><?php echo form_error('jenis_kelamin_id') ?></p>
        </div>
    </div>
    
    <div class="control-group">
        <?= form_label('Agama', 'agama_id', $control_label); ?>
        <div class="controls">
            <?= form_dropdown('agama_id', $agama_data, set_value('agama_id', $agama_id), 'id="agama_id" class="input-medium" prevData-selected="' . set_value('agama_id', $agama_id) . '"') . '&nbsp;&nbsp;'; ?>
            <p class="help-block"><?php echo form_error('agama_id') ?></p>
        </div>
    </div>
    
    <div class="control-group">
        <?= form_label('Status Aktifitas Mahasasiswa' . required(), 'status_aktifitas_mhs', $control_label); ?>
        <div class="controls">
            <?= form_input($status_aktifitas_mhs_attr) ?>
            <p class="help-block"><?php echo form_error('status_aktifitas_mhs') ?></p>
        </div>
    </div>
    
    <div class="control-group">
        <?= form_label('Jumlah SKS', 'jml_sks_diakui', $control_label); ?>
        <div class="controls">
            <?= form_input($jml_sks_diakui_attr) ?>
            <p class="help-block"><?php echo form_error('jml_sks_diakui') ?></p>
        </div>
    </div>
    
    <div class="control-group">
        <?= form_label('Perguruan Tinggi' . required(), 'perguruan_tinggi_sebelumnya', $control_label); ?>
        <div class="controls">
            <?= form_input($perguruan_tinggi_sebelumnya_attr) ?>
            <p class="help-block"><?php echo form_error('perguruan_tinggi_sebelumnya') ?></p>
        </div>
    </div>
    
    <div class="control-group">
        <?= form_label('Jurusan Sebelumnya' . required(), 'jurusan_sebelumnya', $control_label); ?>
        <div class="controls">
            <?= form_input($jurusan_sebelumnya_attr) ?>
            <p class="help-block"><?php echo form_error('jurusan_sebelumnya') ?></p>
        </div>
    </div>
    
    <div class="control-group">
        <?= form_label('Judicium' . required(), 'judicium', $control_label); ?>
        <div class="controls">
            <?= form_input($judicium_attr) ?>
            <p class="help-block"><?php echo form_error('judicium') ?></p>
        </div>
    </div>
    
    <div class="control-group">
        <?= form_label('Penasehat Akademik', 'penasehat_akademik_id', $control_label); ?>
        <div class="controls">
            <?= form_dropdown('penasehat_akademik_id', $status_dosen_penasehat_data, set_value('penasehat_akademik_id', $penasehat_akademik_id), 'id="penasehat_akademik_id" class="input-medium" prevData-selected="' . set_value('penasehat_akademik_id', $penasehat_akademik_id) . '"') . '&nbsp;&nbsp;'; ?>
            <p class="help-block"><?php echo form_error('penasehat_akademik_id') ?></p>
        </div>
    </div>
    
    <div class="control-group">
        <?= form_label('Propinsi SLTA' . required(), 'propinsi_asal_slta', $control_label); ?>
        <div class="controls">
            <?= form_input($propinsi_asal_slta_attr) ?>
            <p class="help-block"><?php echo form_error('propinsi_asal_slta') ?></p>
        </div>
    </div>
    
    <div class="control-group">
        <?= form_label('Kota SLTA' . required(), 'kota_asal_slta', $control_label); ?>
        <div class="controls">
            <?= form_input($kota_asal_slta_attr) ?>
            <p class="help-block"><?php echo form_error('kota_asal_slta') ?></p>
        </div>
    </div>
    
    <div class="control-group">
        <?= form_label('Nama SLTA' . required(), 'nama_slta', $control_label); ?>
        <div class="controls">
            <?= form_input($nama_slta_attr) ?>
            <p class="help-block"><?php echo form_error('nama_slta') ?></p>
        </div>
    </div>
    
    <div class="control-group">
        <?= form_label('Jurusan SLTA' . required(), 'jurusan_slta', $control_label); ?>
        <div class="controls">
            <?= form_input($jurusan_slta_attr) ?>
            <p class="help-block"><?php echo form_error('jurusan_slta') ?></p>
        </div>
    </div>
    
    <div class="control-group">
        <?= form_label('Alamat' . required(), 'alamat', $control_label); ?>
        <div class="controls">
            <?= form_input($alamat_attr) ?>
            <p class="help-block"><?php echo form_error('alamat') ?></p>
        </div>
    </div>
    
     <div class="control-group">
        <?= form_label('Telepon' . required(), 'telepon', $control_label); ?>
        <div class="controls">
            <?= form_input($telepon_attr) ?>
            <p class="help-block"><?php echo form_error('telepon') ?></p>
        </div>
    </div>
    
    <div class="control-group">
        <?= form_label('Hobby' . required(), 'hobby', $control_label); ?>
        <div class="controls">
            <?= form_input($hobby_attr) ?>
            <p class="help-block"><?php echo form_error('hobby') ?></p>
        </div>
    </div>
    
    <div class="control-group">
        <?= form_label('Foto' . required(), 'foto', $control_label); ?>
        <div class="controls">
            <?= form_input($foto_attr) ?>
            <p class="help-block"><?php echo form_error('foto') ?></p>
        </div>
    </div>
    
    <div class="control-group">
        <?= form_label('Jabatan Terakhir', 'jabatan_terakhir_id', $control_label); ?>
        <div class="controls">
            <?= form_dropdown('jabatan_terakhir_id', $jabatan_tertinggi_data, set_value('jabatan_terakhir_id', $jabatan_terakhir_id), 'id="jabatan_terakhir_id" class="input-medium" prevData-selected="' . set_value('jabatan_terakhir_id', $jabatan_terakhir_id) . '"') . '&nbsp;&nbsp;'; ?>
            <p class="help-block"><?php echo form_error('jabatan_terakhir_id') ?></p>
        </div>
    </div>
    
    <div class="control-group">
        <?= form_label('Kesatuan Asal', 'satuan_asal_id', $control_label); ?>
        <div class="controls">
            <?= form_dropdown('satuan_asal_id', $kesatuan_asal_data, set_value('satuan_asal_id', $satuan_asal_id), 'id="satuan_asal_id" class="input-medium" prevData-selected="' . set_value('satuan_asal_id', $satuan_asal_id) . '"') . '&nbsp;&nbsp;'; ?>
            <p class="help-block"><?php echo form_error('satuan_asal_id') ?></p>
        </div>
    </div>
    
    <div class="control-group">
        <?= form_label('Pangkat', 'pangkat_id', $control_label); ?>
        <div class="controls">
            <?= form_dropdown('pangkat_id', $pangkat_data, set_value('pangkat_id', $pangkat_id), 'id="pangkat_id" class="input-medium" prevData-selected="' . set_value('pangkat_id', $pangkat_id) . '"') . '&nbsp;&nbsp;'; ?>
            <p class="help-block"><?php echo form_error('pangkat_id') ?></p>
        </div>
    </div>
    
    <div class="control-group">
        <?= form_label('Nrp' , 'nrp', $control_label); ?>
        <div class="controls">
            <?= form_input($nrp_attr) ?>
            <p class="help-block"><?php echo form_error('nrp') ?></p>
        </div>
    </div>
    
    <div class="control-group">
        <?= form_label('Dik Abri' , 'dik_abri', $control_label); ?>
        <div class="controls">
            <?= form_input($dik_abri_attr) ?>
            <p class="help-block"><?php echo form_error('dik_abri') ?></p>
        </div>
    </div>
    
    <div class="control-group">
        <?= form_label('Tahun Dik Abri' , 'thn_dik_abri', $control_label); ?>
        <div class="controls">
            <?= form_input($thn_dik_abri_attr) ?>
            <p class="help-block"><?php echo form_error('thn_dik_abri') ?></p>
        </div>
    </div>
    
    <div class="control-group">
        <?= form_label('Nama Ayah' , 'nama_ayah', $control_label); ?>
        <div class="controls">
            <?= form_input($nama_ayah_attr) ?>
            <p class="help-block"><?php echo form_error('nama_ayah') ?></p>
        </div>
    </div>
    
    <div class="control-group">
        <?= form_label('Pekerjaan Ayah' , 'pekerjaan_ayah', $control_label); ?>
        <div class="controls">
            <?= form_input($pekerjaan_ayah_attr) ?>
            <p class="help-block"><?php echo form_error('pekerjaan_ayah') ?></p>
        </div>
    </div>
    
    <div class="control-group">
        <?= form_label('Tanggal Lahir Ayah' , 'tgl_lahir_ayah', $control_label); ?>
        <div class="controls">
            <?= form_input($tgl_lahir_ayah_attr) ?>
            <p class="help-block"><?php echo form_error('tgl_lahir_ayah') ?></p>
        </div>
    </div>
    
    <div class="control-group">
        <?= form_label('Agama', 'agama_ayah_id', $control_label); ?>
        <div class="controls">
            <?= form_dropdown('agama_ayah_id', $agama_data, set_value('agama_ayah_id', $agama_id), 'id="agama_ayah_id" class="input-medium" prevData-selected="' . set_value('agama_id', $agama_id) . '"') . '&nbsp;&nbsp;'; ?>
            <p class="help-block"><?php echo form_error('agama_ayah_id') ?></p>
        </div>
    </div>
    
    <div class="control-group">
        <?= form_label('Pendidikan Ayah' , 'pendidikan_ayah', $control_label); ?>
        <div class="controls">
            <?= form_input($pendidikan_ayah_attr) ?>
            <p class="help-block"><?php echo form_error('pendidikan_ayah') ?></p>
        </div>
    </div>
    
    <div class="control-group">
        <?= form_label('Alamat Ayah' , 'alamat_ayah', $control_label); ?>
        <div class="controls">
            <?= form_input($alamat_ayah_attr) ?>
            <p class="help-block"><?php echo form_error('alamat_ayah') ?></p>
        </div>
    </div>
    
    <div class="control-group">
        <?= form_label('No Telepon' , 'no_telepon', $control_label); ?>
        <div class="controls">
            <?= form_input($no_telepon_attr) ?>
            <p class="help-block"><?php echo form_error('no_telepon') ?></p>
        </div>
    </div>
    
    <div class="control-group">
        <?= form_label('Nama Wali' , 'nama_wali', $control_label); ?>
        <div class="controls">
            <?= form_input($nama_wali_attr) ?>
            <p class="help-block"><?php echo form_error('nama_wali') ?></p>
        </div>
    </div>
    
    <div class="control-group">
        <?= form_label('Pekerjaan Wali' , 'pekerjaan_wali', $control_label); ?>
        <div class="controls">
            <?= form_input($pekerjaan_wali_attr) ?>
            <p class="help-block"><?php echo form_error('pekerjaan_wali') ?></p>
        </div>
    </div>
    
    <div class="control-group">
        <?= form_label('Tanggal Lahir Wali' , 'tgl_lahir_wali', $control_label); ?>
        <div class="controls">
            <?= form_input($tgl_lahir_wali_attr) ?>
            <p class="help-block"><?php echo form_error('tgl_lahir_wali') ?></p>
        </div>
    </div>
    
    <div class="control-group">
        <?= form_label('Agama', 'agama_wali_id', $control_label); ?>
        <div class="controls">
            <?= form_dropdown('agama_wali_id', $agama_data, set_value('agama_wali_id', $agama_id), 'id="agama_wali_id" class="input-medium" prevData-selected="' . set_value('agama_wali_id', $agama_wali_id) . '"') . '&nbsp;&nbsp;'; ?>
            <p class="help-block"><?php echo form_error('agama_wali_id') ?></p>
        </div>
    </div>
    
    <div class="control-group">
        <?= form_label('Pendidikan Wali' , 'pendidikan_wali', $control_label); ?>
        <div class="controls">
            <?= form_input($pendidikan_wali_attr) ?>
            <p class="help-block"><?php echo form_error('pendidikan_wali') ?></p>
        </div>
    </div>
    
    <div class="control-group">
        <?= form_label('Alamat Wali' , 'alamat_wali', $control_label); ?>
        <div class="controls">
            <?= form_input($alamat_wali_attr) ?>
            <p class="help-block"><?php echo form_error('alamat_wali') ?></p>
        </div>
    </div>
    
    <div class="form-actions well">
        <button class="btn btn-small btn-primary" type="submit">Simpan</button>
    </div>
    <?php form_close() ?>
</div>
<?php $this->load->view('_shared/footer'); ?>