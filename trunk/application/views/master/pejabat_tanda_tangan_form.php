<?php
$this->load->view('_shared/header');
$this->load->view('_shared/menus');

//label
$control_label = array(
    'class' => 'control-label'
);

$kop_attr = array(
    'name' => 'kop',
    'class' => 'input-small',
    'value' => set_value('kop', $kop),
    'autocomplete' => 'off'
);

$nama_pejabat_attr = array(
    'name' => 'nama_pejabat',
    'class' => 'input-medium',
    'value' => set_value('nama_pejabat', $nama_pejabat),
    'autocomplete' => 'off'
);

$tanggal_tanda_tangan_attr = array(
    'name' => 'tanggal_tanda_tangan',
    'class' => 'input-small',
    'value' => set_value('tanggal_tanda_tangan', $tanggal_tanda_tangan),
    'autocomplete' => 'off'
);

$subdirektorat_data[0] = '';
foreach ($subdirektorat_options as $row) {
    $subdirektorat_data[$row->id] = $row->nama_subdirektorat;
}

$kategori_pejabat_data[0] = '';
foreach ($kategori_pejabat_options as $row) {
    $kategori_pejabat_data[$row->id] = $row->nama_jenis_pejabat;
}
?>
<div class="container-full" id="pejabat_tanda_tangan">
    <?= form_open($action_url, array('class' => 'form-horizontal')); ?>

    <div class="control-group">
        <?= form_label('Sub Direktorat' , 'sub_direktorat_id', $control_label); ?>
        <div class="controls">
            <?= form_dropdown('sub_direktorat_id', $subdirektorat_data, set_value('sub_direktorat_id', $sub_direktorat_id), 'id="sub_direktorat_id" class="input-medium" prevData-selected="' . set_value('sub_direktorat_id', $sub_direktorat_id) . '"'); ?>
            <p class="help-block"><?php echo form_error('sub_direktorat_id') ?></p>
        </div>
    </div>
    
    <div class="control-group">
        <?= form_label('Kategori' , 'kategori_pejabat_id', $control_label); ?>
        <div class="controls">
           <?= form_dropdown('kategori_pejabat_id', $kategori_pejabat_data, set_value('kategori_pejabat_id', $kategori_pejabat_id), 'id="kategori_pejabat_id" class="input-medium" prevData-selected="' . set_value('kategori_pejabat_id', $kategori_pejabat_id) . '"'); ?>
            <p class="help-block"><?php echo form_error('karegori_pejabat_id') ?></p>
        </div>
    </div>
    
    <div class="control-group">
        <?= form_label('Kop' . required(), 'kop', $control_label); ?>
        <div class="controls">
            <?= form_input($kop_attr) ?>
            <p class="help-block"><?php echo form_error('kop') ?></p>
        </div>
    </div>

    <div class="control-group">
        <?= form_label('Nama Pejabat' . required(), 'nama_pejabt', $control_label); ?>
        <div class="controls">
            <?= form_input($nama_pejabat_attr) ?>
            <p class="help-block"><?php echo form_error('nama_pejabat') ?></p>
        </div>
    </div>
    
    <div class="control-group">
        <?= form_label('Tanggal' , 'tanggal_tanda_tangan', $control_label); ?>
        <div class="controls">
            <?= form_input($tanggal_tanda_tangan_attr) ?>
            <p class="help-block"><?php echo form_error('tanggal_tanda_tangan') ?></p>
        </div>
    </div>


    <div class="form-actions well">
        <button class="btn btn-small btn-primary" type="submit">Simpan</button>
    </div>
    <?php form_close() ?>
</div>
<?php $this->load->view('_shared/footer'); ?>