<?php
$this->load->view('_shared/header');
$this->load->view('_shared/menus');

//label
$control_label = array(
    'class' => 'control-label'
);

$no_karpeg_dosen_attr = array(
    'name' => 'no_karpeg_dosen',
    'class' => 'input-small',
    'value' => set_value('no_karpeg_dosen', $no_karpeg_dosen),
    'autocomplete' => 'off'
);

$no_dosen_fakultas_attr = array(
    'name' => 'no_dosen_fakultas',
    'class' => 'input-small',
    'value' => set_value('no_dosen_fakultas', $no_dosen_fakultas),
    'autocomplete' => 'off'
);

$no_dosen_dikti_attr = array(
    'name' => 'no_dosen_dikti',
    'class' => 'input-small',
    'value' => set_value('no_dosen_dikti', $no_dosen_dikti),
    'autocomplete' => 'off'
);

$nama_dosen_attr = array(
    'name' => 'nama_dosen',
    'class' => 'input-medium',
    'value' => set_value('nama_dosen', $nama_dosen),
    'autocomplete' => 'off'
);

$gelar_depan_attr = array(
    'name' => 'gelar_depan',
    'class' => 'input-mini',
    'value' => set_value('gelar_depan', $gelar_depan),
    'autocomplete' => 'off'
);

$gelar_belakang_attr = array(
    'name' => 'gelar_belakang',
    'class' => 'input-mini',
    'value' => set_value('gelar_belakang', $gelar_belakang),
    'autocomplete' => 'off'
);

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

$nip_pns_attr = array(
    'name' => 'nip_pns',
    'class' => 'input-small',
    'value' => set_value('nip_pns', $nip_pns),
    'autocomplete' => 'off'
);

$instansi_induk_dosen_attr = array(
    'name' => 'instansi_induk_dosen',
    'class' => 'input-medium',
    'value' => set_value('instansi_induk_dosen', $instansi_induk_dosen),
    'autocomplete' => 'off'
);

$tmt_golongan_attr = array(
    'name' => 'tmt_golongan',
    'class' => 'input-medium',
    'value' => set_value('tmt_golongan', $tmt_golongan),
    'autocomplete' => 'off'
);

$jabatan_struktural_attr = array(
    'name' => 'jabatan_struktural',
    'class' => 'input-medium',
    'value' => set_value('jabatan_struktural', $jabatan_struktural),
    'autocomplete' => 'off'
);

$tmt_jabatan_attr = array(
    'name' => 'tmt_jabatan',
    'class' => 'input-medium',
    'value' => set_value('tmt_jabatan', $tmt_jabatan),
    'autocomplete' => 'off'
);

$alamat_attr = array(
    'name' => 'alamat',
    'class' => 'span3',
    'value' => set_value('alamat', $alamat),
    'autocomplete' => 'off'
);

$no_telp_attr = array(
    'name' => 'no_telp',
    'class' => 'input-medium',
    'value' => set_value('no_telp', $no_telp),
    'autocomplete' => 'off'
);

$no_hp_attr = array(
    'name' => 'no_hp',
    'class' => 'input-medium',
    'value' => set_value('no_hp', $no_hp),
    'autocomplete' => 'off'
);

$tgl_mulai_masuk_attr = array(
    'name' => 'tgl_mulai_masuk',
    'class' => 'input-small',
    'value' => set_value('tgl_mulai_masuk', $tgl_mulai_masuk),
    'autocomplete' => 'off'
);

$tgl_keluar_attr = array(
    'name' => 'tgl_keluar',
    'class' => 'input-small',
    'value' => set_value('tgl_keluar', $tgl_keluar),
    'autocomplete' => 'off'
);

$email_attr = array(
    'name' => 'email',
    'class' => 'input-medium',
    'value' => set_value('email', $email),
    'autocomplete' => 'off'
);

$foto_dosen_attr = array(
    'name' => 'foto_dosen',
    'class' => 'input-medium',
    'value' => set_value('foto_dosen', $foto_dosen),
    'autocomplete' => 'off'
);

$angkatan_data[0] = '';
foreach ($angkatan_options as $row) {
    $angkatan_data[$row->id] = $row->nama_angkatan;
}

$nama_pangkat_attr = array(
    'name' => 'span_pangkat',
    'class' => 'input-medium',
    'value' => set_value('span_pangkat', ''),
    'autocomplete' => 'off'
);

$pangkat_data[0] = '';
foreach ($pangkat_options as $row) {
    $pangkat_data[$row->id."-".$row->nama_pangkat] = $row->kode_pangkat;
}

$program_studi_data[0] = '';
foreach ($program_studi_options as $row) {
    $program_studi_data[$row->id] = $row->nama_program_studi;
}

$jenjang_studi_data[0] = '';
foreach ($jenjang_studi_options as $row) {
    $jenjang_studi_data[$row->id] = $row->jenjang_studi;
}

$jenis_kelamin_data[0] = '';
foreach ($jenis_kelamin_options as $row) {
    $jenis_kelamin_data[$row->id] = $row->jenis_kelamin;
}

$agama_data[0] = '';
foreach ($agama_options as $row) {
    $agama_data[$row->id] = $row->agama;
}

$jabatan_akademik_data[0] = '';
foreach ($jabatan_akademik_options as $row) {
    $jabatan_akademik_data[$row->id] = $row->nama_jabatan_akademik;
}

$jabatan_tertinggi_data[0] = '';
foreach ($jabatan_tertinggi_options as $row) {
    $jabatan_tertinggi_data[$row->id] = $row->jabatan_tertinggi;
}

$status_kerja_dosen_data[0] = '';
foreach ($status_kerja_dosen_options as $row) {
    $status_kerja_dosen_data[$row->id] = $row->status_kerja_dosen;
}

$status_aktivitas_dosen_data[0] = '';
foreach ($status_aktivitas_dosen_options as $row) {
    $status_aktivitas_dosen_data[$row->id] = $row->status_aktivitas_dosen;
}

$semester_mulai_aktivitas_data[0] = '';
foreach ($semester_mulai_aktivitas_options as $row) {
    $semester_mulai_aktivitas_data[$row->id] = $row->semester_mulai_aktivitas;
}

$akta_mengajar_data[0] = '';
foreach ($akta_mengajar_options as $row) {
    $akta_mengajar_data[$row->id] = $row->nama_akta_mengajar;
}

$surat_ijin_mengajar_data[0] = '';
foreach ($surat_ijin_mengajar_options as $row) {
    $surat_ijin_mengajar_data[$row->id] = $row->surat_ijin_mengajar;
}

$golongan_data[0] = '';
foreach ($golongan_options as $row) {
    $golongan_data[$row->id] = $row->golongan;
}

?>
<div class="container-full" id="dosen">
    <?= form_open_multipart($action_url, array('class' => 'form-horizontal')); ?>

    <div class="control-group">
        <?= form_label('Angkatan' . required(), 'angkatan_id', $control_label); ?>
        <div class="controls">
            <?= form_dropdown('angkatan_id', $angkatan_data, set_value('angkatan_id', $angkatan_id), 'id="angkatan_id" class="input-medium" prevData-selected="' . set_value('angkatan_id', $angkatan_id) . '"'); ?>
            <p class="help-block"><?php echo form_error('angkatan_id') ?></p>
        </div>
    </div>
    
    <div class="control-group">
        <?= form_label('Program Studi', 'program_studi_id', $control_label); ?>
        <div class="controls">
            <?= form_dropdown('program_studi_id', $program_studi_data, set_value('program_studi_id', $program_studi_id), 'id="program_studi_id" class="input-medium" prevData-selected="' . set_value('program_studi_id', $program_studi_id) . '"'); ?>
            <p class="help-block"><?php echo form_error('program_studi_id') ?></p>
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
        <?= form_label('Pangkat', 'pangkat_id', $control_label); ?>
        <div class="controls">
            <?= form_dropdown('pangkat_id', $pangkat_data, set_value('pangkat_id', $pangkat_id), 'id="pangkat_id" class="input-medium" prevData-selected="' . set_value('pangkat_id', $pangkat_id) . '"'); ?>  
            <p class="help-block"><?php echo form_error('pangkat_id') ?></p>
        </div>
    </div>
    
    <div class="control-group">
        <?= form_label('Nama Pangkat', 'nama_pangkat', $control_label); ?>
        <div class="controls">
             <?=form_input($nama_pangkat_attr) ?>
            <p class="help-block"><?php echo form_error('nama_pangkat') ?></p>
        </div>
    </div>

    <div class="control-group">
        <?= form_label('No Karpeg Dosen' , 'no_karpeg_dosen', $control_label); ?>
        <div class="controls">
            <?= form_input($no_karpeg_dosen_attr) ?>
            <p class="help-block"><?php echo form_error('no_karpeg_dosen') ?></p>
        </div>
    </div>

    

    <div class="control-group">
        <?= form_label('No Dosen Fakultas' , 'no_dosen_fakultas', $control_label); ?>
        <div class="controls">
            <?= form_input($no_dosen_fakultas_attr) ?>
            <p class="help-block"><?php echo form_error('no_dosen_fakultas') ?></p>
        </div>
    </div>

    <div class="control-group">
        <?= form_label('No Dosen Dikti' , 'no_dosen_dikti', $control_label); ?>
        <div class="controls">
            <?= form_input($no_dosen_dikti_attr) ?>
            <p class="help-block"><?php echo form_error('no_dosen_dikti') ?></p>
        </div>
    </div>

    <div class="control-group">
        <?= form_label('Nama Dosen' . required(), 'nama_dosen', $control_label); ?>
        <div class="controls">
            <?= form_input($nama_dosen_attr) ?>
            <p class="help-block"><?php echo form_error('nama_dosen') ?></p>
        </div>
    </div>

    <div class="control-group">
        <?= form_label('Gelar Depan', 'gelar_depan', $control_label); ?>
        <div class="controls">
            <?= form_input($gelar_depan_attr) ?>
            <p class="help-block"><?php echo form_error('gelar_depan') ?></p>
        </div>
    </div>

    <div class="control-group">
        <?= form_label('Gelar Belakang', 'gelar_belakang', $control_label); ?>
        <div class="controls">
            <?= form_input($gelar_belakang_attr) ?>
            <p class="help-block"><?php echo form_error('gelar_belakang') ?></p>
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
        <?= form_label('Tanggal Lahir', 'tgl_lahir', $control_label); ?>
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
        <?= form_label('Jabatan Akademik', 'jabatan_akademik_id', $control_label); ?>
        <div class="controls">
            <?= form_dropdown('jabatan_akademik_id', $jabatan_akademik_data, set_value('jabatan_akademik_id', $jabatan_akademik_id), 'id="jabatan_akademik_id" class="input-medium" prevData-selected="' . set_value('jabatan_akademik_id', $jabatan_akademik_id) . '"'); ?>
            <p class="help-block"><?php echo form_error('jabatan_akademik_id') ?></p>
        </div>
    </div>
    
    <div class="control-group">
        <?= form_label('Jabatan Tertinggi', 'jabatan_tertinggi_id', $control_label); ?>
        <div class="controls">
            <?= form_dropdown('jabatan_tertinggi_id', $jabatan_tertinggi_data, set_value('jabatan_tertinggi_id', $jabatan_tertinggi_id), 'id="jabatan_tertinggi_id" class="input-medium" prevData-selected="' . set_value('jabatan_tertinggi_id', $jabatan_tertinggi_id) . '"'); ?>
            <p class="help-block"><?php echo form_error('jabatan_tertinggi_id') ?></p>
        </div>
    </div>
    
    <div class="control-group">
        <?= form_label('Status Kerja Dosen', 'status_kerja_dosen_id', $control_label); ?>
        <div class="controls">
            <?= form_dropdown('status_kerja_dosen_id', $status_kerja_dosen_data, set_value('status_kerja_dosen_id', $status_kerja_dosen_id), 'id="status_kerja_dosen_id" class="input-medium" prevData-selected="' . set_value('status_kerja_dosen_id', $status_kerja_dosen_id) . '"'); ?>
            <p class="help-block"><?php echo form_error('status_kerja_dosen_id') ?></p>
        </div>
    </div>
    
    <div class="control-group">
        <?= form_label('Status Aktivitas Dosen', 'status_aktivitas_dosen_id', $control_label); ?>
        <div class="controls">
            <?= form_dropdown('status_aktivitas_dosen_id', $status_aktivitas_dosen_data, set_value('status_aktivitas_dosen_id', $status_aktivitas_dosen_id), 'id="status_aktivitas_dosen_id" class="input-medium" prevData-selected="' . set_value('status_aktivitas_dosen_id', $status_aktivitas_dosen_id) . '"'); ?>
            <p class="help-block"><?php echo form_error('status_aktivitas_dosen_id') ?></p>
        </div>
    </div>
    
    <div class="control-group">
        <?= form_label('Semester Mulai Aktivitas', 'semester_mulai_aktivitas_id', $control_label); ?>
        <div class="controls">
            <?= form_dropdown('semester_mulai_aktivitas_id', $semester_mulai_aktivitas_data, set_value('semester_mulai_aktivitas_id', $semester_mulai_aktivitas_id), 'id="semester_mulai_aktivitas_id" class="input-medium" prevData-selected="' . set_value('semester_mulai_aktivitas_id', $semester_mulai_aktivitas_id) . '"'); ?>
            <p class="help-block"><?php echo form_error('semester_mulai_aktivitas_id') ?></p>
        </div>
    </div>
    
    <div class="control-group">
        <?= form_label('Akta Mengajar', 'akta_mengajar_id', $control_label); ?>
        <div class="controls">
            <?= form_dropdown('akta_mengajar_id', $akta_mengajar_data, set_value('akta_mengajar_id', $akta_mengajar_id), 'id="akta_mengajar_id" class="input-medium" prevData-selected="' . set_value('akta_mengajar_id', $akta_mengajar_id) . '"'); ?>
            <p class="help-block"><?php echo form_error('akta_mengajar_id') ?></p>
        </div>
    </div>
    
    <div class="control-group">
        <?= form_label('Surat Ijin Mengajar', 'surat_ijin_mengajar_id', $control_label); ?>
        <div class="controls">
            <?= form_dropdown('surat_ijin_mengajar_id', $surat_ijin_mengajar_data, set_value('surat_ijin_mengajar_id', $surat_ijin_mengajar_id), 'id="surat_ijin_mengajar_id" class="input-medium" prevData-selected="' . set_value('surat_ijin_mengajar_id', $surat_ijin_mengajar_id) . '"'); ?>
            <p class="help-block"><?php echo form_error('surat_ijin_mengajar_id') ?></p>
        </div>
    </div>
    
    <div class="control-group">
        <?= form_label('NIP PNS', 'nip_pns', $control_label); ?>
        <div class="controls">
            <?= form_input($nip_pns_attr) ?>
            <p class="help-block"><?php echo form_error('nip_pns') ?></p>
        </div>
    </div>

    <div class="control-group">
        <?= form_label('Instansi Induk Dosen', 'instansi_induk_dosen', $control_label); ?>
        <div class="controls">
            <?= form_input($instansi_induk_dosen_attr) ?>
            <p class="help-block"><?php echo form_error('instansi_induk_dosen') ?></p>
        </div>
    </div>
    
    <div class="control-group">
        <?= form_label('Golongan', 'golongan_id', $control_label); ?>
        <div class="controls">
            <?= form_dropdown('golongan_id', $golongan_data, set_value('golongan_id', $golongan_id), 'id="golongan_id" class="input-medium" prevData-selected="' . set_value('golongan_id', $golongan_id) . '"'); ?>
            <p class="help-block"><?php echo form_error('golongan_id') ?></p>
        </div>
    </div>

    <div class="control-group">
        <?= form_label('TMT Golongan', 'tmt_golongan_attr', $control_label); ?>
        <div class="controls">
            <?= form_input($tmt_golongan_attr) ?>
            <p class="help-block"><?php echo form_error('tmt_golongan') ?></p>
        </div>
    </div>

    <div class="control-group">
        <?= form_label('Jabatan Struktural', 'jabatan_struktural', $control_label); ?>
        <div class="controls">
            <?= form_input($jabatan_struktural_attr) ?>
            <p class="help-block"><?php echo form_error('jabatan_struktural') ?></p>
        </div>
    </div>

    <div class="control-group">
        <?= form_label('TMT Jabatan', 'tmt_jabatan', $control_label); ?>
        <div class="controls">
            <?= form_input($tmt_jabatan_attr) ?>
            <p class="help-block"><?php echo form_error('tmt_jabatan') ?></p>
        </div>
    </div>

    <div class="control-group">
        <?= form_label('Alamat', 'alamat', $control_label); ?>
        <div class="controls">
            <?= form_textarea($alamat_attr) ?>
            <p class="help-block"><?php echo form_error('alamat') ?></p>
        </div>
    </div>

    <div class="control-group">
        <?= form_label('No Telepon', 'no_telp', $control_label); ?>
        <div class="controls">
            <?= form_input($no_telp_attr) ?>
            <p class="help-block"><?php echo form_error('no_telp') ?></p>
        </div>
    </div>
    
    <div class="control-group">
        <?= form_label('No Hp', 'no_hp', $control_label); ?>
        <div class="controls">
            <?= form_input($no_hp_attr) ?>
            <p class="help-block"><?php echo form_error('no_hp') ?></p>
        </div>
    </div>
    
    <div class="control-group">
        <?= form_label('Tanggal Masuk', 'tgl_mulai_masuk', $control_label); ?>
        <div class="controls">
            <?= form_input($tgl_mulai_masuk_attr) ?>
            <p class="help-block"><?php echo form_error('tgl_mulai_masuk') ?></p>
        </div>
    </div>
    
    <div class="control-group">
        <?= form_label('Tanggal Keluar', 'tgl_keluar', $control_label); ?>
        <div class="controls">
            <?= form_input($tgl_keluar_attr) ?>
            <p class="help-block"><?php echo form_error('tgl_keluar') ?></p>
        </div>
    </div>
    
    <div class="control-group">
        <?= form_label('Email', 'email', $control_label); ?>
        <div class="controls">
            <?= form_input($email_attr) ?>
            <p class="help-block"><?php echo form_error('email') ?></p>
        </div>
    </div>
    
    <div class="control-group">
        <?= form_open_multipart('dosen/do_upload'); ?>
        <?= form_label('Foto Dosen', 'foto_dosen', $control_label); ?>
        <div class="controls">
            <?= form_upload($foto_dosen_attr) ?>
            <p class="help-block"><?php echo form_error('foto') ?></p>
        </div>
    </div>


    <div class="form-actions well">
        <button class="btn btn-small btn-primary" type="submit">Simpan</button>
    </div>
    <?php form_close() ?>
</div>
<?php $this->load->view('_shared/footer'); ?>
