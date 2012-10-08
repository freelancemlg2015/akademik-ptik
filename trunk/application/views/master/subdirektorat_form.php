<?php
$this->load->view('_shared/header');
$this->load->view('_shared/menus');

//label
$control_label = array(
    'class' => 'control-label'
);

$direktorat_id_attr = array(
    'id'    => 'direktorat_id',
    'name'  => 'direktorat_id',
    'class' => 'input-medium',
    'value' => set_value('direktorat_id', ''),
    'autocomplete' => 'off'
);

$nama_subdirektorat_attr = array(
    'id' => 'nama_subdirektorat',
    'name' => 'nama_subdirektorat',
    'class' => 'input-medium',
    'value' => set_value('nama_subdirektorat', $nama_subdirektorat),
    'autocomplete' => 'off'
);

$keterangan_attr = array(
    'name' => 'keterangan',
    'class' => 'span3',
    'value' => set_value('keterangan', $keterangan),
    'autocomplete' => 'off'
);

$direktorat_data[0] = '-PILIH-';
foreach ($direktorat_options as $row) {
    $direktorat_data[$row->id] = $row->nama_direktorat;
}

?>
<div class="container-full" id="subdirektorat">
    <?= form_open($action_url, array('class' => 'form-horizontal')); ?>

    <div class="control-group">
        <?= form_label('Direktorat' . required(), 'nama_direktorat', $control_label); ?>
        <div class="controls">
            <?= form_dropdown('direktorat_id', $direktorat_data, set_value('direktorat_id', $direktorat_id), 'id="direktorat_id" class="input-medium" prevData-selected="' . set_value('direktorat_id', $direktorat_id) . '"') . '&nbsp;&nbsp;'; ?>
            <p class="help-block"><?php echo form_error('nama_direktorat') ?></p>
        </div>
    </div>
    
    <div class="control-group">
        <?= form_label('Sub Direktorat' . required(), 'nama_subdirektorat', $control_label); ?>
        <div class="controls">
            <?= form_input($nama_subdirektorat_attr) ?>
            <p class="help-block"><?php echo form_error('nama_subdirektorat') ?></p>
        </div>
    </div>

    <div class="control-group">
        <?= form_label('Keterangan' , 'keterangan', $control_label); ?>
        <div class="controls">
            <?= form_textarea($keterangan_attr) ?>
            <p class="help-block"><?php echo form_error('keterangan') ?></p>
        </div>
    </div>


    <div class="form-actions well">
        <button class="btn btn-small btn-primary" type="submit">Simpan</button>
    </div>
    <?php form_close() ?>
</div>
<?php $this->load->view('_shared/footer'); ?>