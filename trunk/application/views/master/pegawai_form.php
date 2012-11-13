<?php
$this->load->view('_shared/header');
$this->load->view('_shared/menus');

//label
$control_label = array(
    'class' => 'control-label'
);

$no_karpeg_pegawai_attr = array(
    'name' => 'no_karpeg_pegawai',
    'class' => 'input-small',
    'value' => set_value('no_karpeg_pegawai', $no_karpeg_pegawai),
    'autocomplete' => 'off'
);


$nama_pegawai_attr = array(
    'name' => 'nama_pegawai',
    'class' => 'input-medium',
    'value' => set_value('nama_pegawai', $nama_pegawai),
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


$jabatan_struktural_attr = array(
    'name' => 'jabatan_struktural',
    'class' => 'input-medium',
    'value' => set_value('jabatan_struktural', $jabatan_struktural),
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

$email_attr = array(
    'name' => 'email',
    'class' => 'input-medium',
    'value' => set_value('email', $email),
    'autocomplete' => 'off'
);

$foto_pegawai_attr = array(
    'name' => 'foto_pegawai',
    'class' => 'input-medium',
    'value' => set_value('foto_pegawai', $foto_pegawai),
    'autocomplete' => 'off'
);


$nama_pangkat_attr = array(
    'name' => 'span_pangkat',
    'class' => 'input-medium',
    'value' => set_value('span_pangkat', ''),
    'autocomplete' => 'off'
);

$pangkat_data[0] = '';
foreach ($pangkat_options as $row) {
    $pangkat_data[$row->id."-".$row->nama_pangkat] = $row->kode_pangkat.'-'.$row->nama_pangkat;
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

?>
<div class="container-full" id="pegawai">
    <?= form_open_multipart($action_url, array('class' => 'form-horizontal')); ?>


    <div class="control-group">
        <?= form_label('Pangkat', 'pangkat_id', $control_label); ?>
        <div class="controls">
            <?= form_dropdown('pangkat_id', $pangkat_data, set_value('pangkat_id', $pangkat_id), 'id="pangkat_id" class="input-medium" prevData-selected="' . set_value('pangkat_id', $pangkat_id) . '"'); ?>  
            <p class="help-block"><?php echo form_error('pangkat_id') ?></p>
        </div>
    </div>
    
<?php /*?>    <div class="control-group">
        <?= form_label('Nama Pangkat', 'nama_pangkat', $control_label); ?>
        <div class="controls">
             <?=form_input($nama_pangkat_attr) ?>
            <p class="help-block"><?php echo form_error('nama_pangkat') ?></p>
        </div>
    </div><?php */?>

    <div class="control-group">
        <?= form_label('No Karpeg Pegawai' , 'no_karpeg_pegawai', $control_label); ?>
        <div class="controls">
            <?= form_input($no_karpeg_pegawai_attr) ?>
            <p class="help-block"><?php echo form_error('no_karpeg_pegawai') ?></p>
        </div>
    </div>
  

    <div class="control-group">
        <?= form_label('Nama Pegawai' . required(), 'nama_pegawai', $control_label); ?>
        <div class="controls">
            <?= form_input($nama_pegawai_attr) ?>
            <p class="help-block"><?php echo form_error('nama_pegawai') ?></p>
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
        <?= form_label('NIP PNS', 'nip_pns', $control_label); ?>
        <div class="controls">
            <?= form_input($nip_pns_attr) ?>
            <p class="help-block"><?php echo form_error('nip_pns') ?></p>
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
        <?= form_label('Email', 'email', $control_label); ?>
        <div class="controls">
            <?= form_input($email_attr) ?>
            <p class="help-block"><?php echo form_error('email') ?></p>
        </div>
    </div>
    
    <div class="control-group">
        <?= form_open_multipart('pegawai/do_upload'); ?>
        <?= form_label('Foto Pegawai', 'foto_pegawai', $control_label); ?>
        <div class="controls">
            <?= form_upload($foto_pegawai_attr) ?>
            <p class="help-block"><?php echo form_error('foto') ?></p>
        </div>
    </div>


    <div class="form-actions well">
        <button class="btn btn-small btn-primary" type="submit">Simpan</button>
    </div>
    <?php form_close() ?>
</div>
<?php $this->load->view('_shared/footer'); ?>
