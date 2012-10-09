<?php
$this->load->view('_shared/header');
$this->load->view('_shared/menus');

//label
$control_label = array(
    'class' => 'control-label'
);

$nama_unduhan_attr = array(
    'name' => 'nama_unduhan',
    'class' => 'input-medium',
    'value' => set_value('nama_unduhan', $nama_unduhan),
    'autocomplete' => 'off'
);

$keterangan_attr = array(
    'name' => 'keterangan',
    'class' => 'span3',
    'value' => set_value('keterangan', $keterangan),
    'autocomplete' => 'off'
);

$kategori_unduhan_data[0] = '';
foreach ($kategori_unduhan_options as $row) {
    $kategori_unduhan_data[$row->id] = $row->kategori_unduhan;
}

?>
<div class="container-full" id="unduhan">
    <?= form_open($action_url, array('class' => 'form-horizontal')); ?>

    <div class="control-group">
        <?= form_label('Kategori' , 'kategori_unduhan_id', $control_label); ?>
        <div class="controls">
            <?= form_dropdown('kategori_unduhan_id', $kategori_unduhan_data, set_value('kategori_unduhan_id', $kategori_unduhan_id), 'id="kategori_unduhan_id" class="input-medium" prevData-selected="' . set_value('kategori_unduhan_id', $kategori_unduhan_id) . '"'); ?>
            <p class="help-block"><?php echo form_error('kategori_unduhan_id') ?></p>
        </div>
    </div>

    <div class="control-group">
        <?= form_label('Unduhan' . required(), 'nama_unduhan', $control_label); ?>
        <div class="controls">
            <?= form_input($nama_unduhan_attr) ?>
            <p class="help-block"><?php echo form_error('nama_unduhan') ?></p>
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