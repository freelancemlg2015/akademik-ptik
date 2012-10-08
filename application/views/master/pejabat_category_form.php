<?php
$this->load->view('_shared/header');
$this->load->view('_shared/menus');

//label
$control_label = array(
    'class' => 'control-label'
);

$nama_jenis_pejabat_attr = array(
    'name' => 'nama_jenis_pejabat',
    'class' => 'input-medium',
    'value' => set_value('nama_jenis_pejabat', $nama_jenis_pejabat),
    'autocomplete' => 'off'
);

$keterangan_attr = array(
    'name' => 'keterangan',
    'class' => 'input-medium',
    'value' => set_value('keterangan', $keterangan),
    'autocomplete' => 'off'
);
?>
<div class="container-full" id="pejabat_kategori">
    <?= form_open($action_url, array('class' => 'form-horizontal')); ?>

    <div class="control-group">
        <?= form_label('Nama Jenis Pejabat' . required(), 'nama_jenis_pejabat', $control_label); ?>
        <div class="controls">
            <?= form_input($nama_jenis_pejabat_attr) ?>
            <p class="help-block"><?php echo form_error('nama_jenis_pejabat') ?></p>
        </div>
    </div>

    <div class="control-group">
        <?= form_label('Keterangan' , 'keterangan', $control_label); ?>
        <div class="controls">
            <?= form_input($keterangan_attr) ?>
            <p class="help-block"><?php echo form_error('keterangan') ?></p>
        </div>
    </div>


    <div class="form-actions well">
        <button class="btn btn-small btn-primary" type="submit">Simpan</button>
    </div>
    <?php form_close() ?>
</div>
<?php $this->load->view('_shared/footer'); ?>