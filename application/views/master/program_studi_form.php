<?php
$this->load->view('_shared/header');
$this->load->view('_shared/menus');

//label
$control_label = array(
    'class' => 'control-label'
);

$kode_program_studi_attr = array(
    'name' => 'kode_program_studi',
    'class' => 'input-small',
    'value' => set_value('kode_program_studi', $kode_program_studi),
    'autocomplete' => 'off'
);

$nama_program_studi_attr = array(
    'name' => 'nama_program_studi',
    'class' => 'input-xlarge',
    'value' => set_value('nama_program_studi', $nama_program_studi),
    'autocomplete' => 'off'
);

$inisial_attr = array(
    'name' => 'inisial',
    'class' => 'input-mini',
    'value' => set_value('inisial', $inisial),
    'autocomplete' => 'off'
);

$status_akreditasi_attr = array(
    'name' => 'status_akreditasi',
    'class' => 'input-medium',
    'value' => set_value('status_akreditasi', $status_akreditasi),
    'autocomplete' => 'off'
);

$no_sk_terakhir_attr = array(
    'name' => 'no_sk_terakhir',
    'class' => 'input-medium',
    'value' => set_value('no_sk_terakhir', $no_sk_terakhir),
    'autocomplete' => 'off'
);

$tgl_sk_terakhir_attr = array(
    'name' => 'tgl_sk_terakhir',
    'class' => 'input-small',
    'value' => set_value('tgl_sk_terakhir', $tgl_sk_terakhir),
    'autocomplete' => 'off'
);

$jml_sks_attr = array(
    'name' => 'jml_sks',
    'class' => 'input-mini',
    'value' => set_value('jml_sks', $jml_sks),
    'autocomplete' => 'off'
);

$kode_status_program_studi_attr = array(
    'name' => 'kode_status_program_studi',
    'class' => 'input-medium',
    'value' => set_value('kode_status_program_studi', $kode_status_program_studi),
    'autocomplete' => 'off'
);

$thn_semester_mulai_attr = array(
    'name' => 'thn_semester_mulai',
    'class' => 'input-mini',
    'value' => set_value('thn_semester_mulai', $thn_semester_mulai),
    'autocomplete' => 'off'
);

$email_attr = array(
    'name' => 'email',
    'class' => 'input-medium',
    'value' => set_value('email', $email),
    'autocomplete' => 'off'
);

$tgl_pendirian_program_studi_attr = array(
    'name' => 'tgl_pendirian_program_studi',
    'class' => 'input-small',
    'value' => set_value('tgl_pendirian_program_studi', $tgl_pendirian_program_studi),
    'autocomplete' => 'off'
);

$no_sk_akreditasi_attr = array(
    'name' => 'no_sk_akreditasi',
    'class' => 'input-medium',
    'value' => set_value('no_sk_akreditasi', $no_sk_akreditasi),
    'autocomplete' => 'off'
);

$tgl_sk_akreditasi_attr = array(
    'name' => 'tgl_sk_akreditasi',
    'class' => 'input-small',
    'value' => set_value('tgl_sk_akreditasi', $tgl_sk_akreditasi),
    'autocomplete' => 'off'
);

$tgl_akhir_sk_attr = array(
    'name' => 'tgl_akhir_sk',
    'class' => 'input-small',
    'value' => set_value('tgl_akhir_sk', $tgl_akhir_sk),
    'autocomplete' => 'off'
);

$frekuensi_pemutahiran_kurikulum_attr = array(
    'name' => 'frekuensi_pemutahiran_kurikulum',
    'class' => 'input-medium',
    'value' => set_value('frekuensi_pemutahiran_kurikulum', $frekuensi_pemutahiran_kurikulum),
    'autocomplete' => 'off'
);

$pelaksana_pemutahiran_attr = array(
    'name' => 'pelaksana_pemutahiran',
    'class' => 'input-medium',
    'value' => set_value('pelaksana_pemutahiran', $pelaksana_pemutahiran),
    'autocomplete' => 'off'
);

$angkatan_data[0] = '-PILIH-';
foreach ($angkatan_options as $row) {
    $angkatan_data[$row->id] = $row->nama_angkatan;
}

$jenjang_studi_data[0] = '-PILIH-';
foreach ($jenjang_studi_options as $row) {
    $jenjang_studi_data[$row->id] = $row->jenjang_studi;
}

?>
<div class="container-full" id="angkatan">
    <?= form_open($action_url, array('class' => 'form-horizontal')); ?>

    <div class="control-group">
        <?= form_label('Kode Program Studi' . required(), 'kode_program_studi', $control_label); ?>
        <div class="controls">
            <?= form_input($kode_program_studi_attr) ?>
            <p class="help-block"><?php echo form_error('kode_program_studi') ?></p>
        </div>
    </div>

    <div class="control-group">
        <?= form_label('Nama Program Studi' . required(), 'nama_program_studi', $control_label); ?>
        <div class="controls">
            <?= form_input($nama_program_studi_attr) ?>
            <p class="help-block"><?php echo form_error('nama_program_studi') ?></p>
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
        <?= form_label('Inisial', 'inisial', $control_label); ?>
        <div class="controls">
            <?= form_input($inisial_attr) ?>
            <p class="help-block"><?php echo form_error('inisial') ?></p>
        </div>
    </div>

    <div class="control-group">
        <?= form_label('Jenjang Studi', 'jenjang_studi_id', $control_label); ?>
        <div class="controls">
            <?= form_dropdown('jenjang_studi_id', $jenjang_studi_data, set_value('jenjang_studi_id', $jenjang_studi_id), 'id="jenjang_studi_id" class="input-medium" prevData-selected="' . set_value('jenjang_studi_id', $jenjang_studi_id) . '"') . '&nbsp;&nbsp;'; ?>
            <p class="help-block"><?php echo form_error('jenjang_studi_id') ?></p>
        </div>
    </div>

    <div class="control-group">
        <?= form_label('Status Akreditasi', 'status_akreditasi', $control_label); ?>
        <div class="controls">
            <?= form_input($status_akreditasi_attr) ?>
            <p class="help-block"><?php echo form_error('status_akreditasi') ?></p>
        </div>
    </div>

    <div class="control-group">
        <?= form_label('No SK Terakhir', 'no_sk_terakhir', $control_label); ?>
        <div class="controls">
            <?= form_input($no_sk_terakhir_attr) ?>
            <p class="help-block"><?php echo form_error('no_sk_terakhir') ?></p>
        </div>
    </div>

    <div class="control-group">
        <?= form_label('Tgl SK Terakhir', 'tgl_sk_terakhir', $control_label); ?>
        <div class="controls">
            <?= form_input($tgl_sk_terakhir_attr) ?>
            <p class="help-block"><?php echo form_error('tgl_sk_terakhir') ?></p>
        </div>
    </div>

    <div class="control-group">
        <?= form_label('Jumlah SKS', 'jml_sks', $control_label); ?>
        <div class="controls">
            <?= form_input($jml_sks_attr) ?>
            <p class="help-block"><?php echo form_error('jml_sks') ?></p>
        </div>
    </div>

    <div class="control-group">
        <?= form_label('Kode Status Program Studi', 'kode_status_program_studi', $control_label); ?>
        <div class="controls">
            <?= form_input($kode_status_program_studi_attr) ?>
            <p class="help-block"><?php echo form_error('kode_status_program_studi') ?></p>
        </div>
    </div>

    <div class="control-group">
        <?= form_label('Tahun Semester Mulai', 'thn_semester_mulai', $control_label); ?>
        <div class="controls">
            <?= form_input($thn_semester_mulai_attr) ?>
            <p class="help-block"><?php echo form_error('thn_semester_mulai') ?></p>
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
        <?= form_label('Tgl Pendirian Program Studi', 'tgl_pendirian_program_studi', $control_label); ?>
        <div class="controls">
            <?= form_input($tgl_pendirian_program_studi_attr) ?>
            <p class="help-block"><?php echo form_error('tgl_pendirian_program_studi') ?></p>
        </div>
    </div>

    <div class="control-group">
        <?= form_label('No SK Akreditasi', 'no_sk_akreditasi_attr', $control_label); ?>
        <div class="controls">
            <?= form_input($no_sk_akreditasi_attr) ?>
            <p class="help-block"><?php echo form_error('no_sk_akreditasi_attr') ?></p>
        </div>
    </div>

    <div class="control-group">
        <?= form_label('Tgl SK Akreditasi', 'tgl_sk_akreditasi', $control_label); ?>
        <div class="controls">
            <?= form_input($tgl_sk_akreditasi_attr) ?>
            <p class="help-block"><?php echo form_error('tgl_sk_akreditasi') ?></p>
        </div>
    </div>

    <div class="control-group">
        <?= form_label('Tgl Akhir SK', 'tgl_akhir_sk', $control_label); ?>
        <div class="controls">
            <?= form_input($tgl_akhir_sk_attr) ?>
            <p class="help-block"><?php echo form_error('tgl_akhir_sk') ?></p>
        </div>
    </div>

    <div class="control-group">
        <?= form_label('Frekuensi Pemutahiran Kurikulum', 'frekuensi_pemutahiran_kurikulum', $control_label); ?>
        <div class="controls">
            <?= form_input($frekuensi_pemutahiran_kurikulum_attr) ?>
            <p class="help-block"><?php echo form_error('frekuensi_pemutahiran_kurikulum') ?></p>
        </div>
    </div>

    <div class="control-group">
        <?= form_label('Pelaksana Pemutahiran', 'pelaksana_pemutahiran', $control_label); ?>
        <div class="controls">
            <?= form_input($pelaksana_pemutahiran_attr) ?>
            <p class="help-block"><?php echo form_error('pelaksana_pemutahiran') ?></p>
        </div>
    </div>


    <div class="form-actions well">
        <button class="btn btn-small btn-primary" type="submit">Simpan</button>
    </div>
    <?php form_close() ?>
</div>
<?php $this->load->view('_shared/footer'); ?>