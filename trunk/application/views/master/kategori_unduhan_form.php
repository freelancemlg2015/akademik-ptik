<?php
$this->load->view('_shared/header');
$this->load->view('_shared/menus');

//label
$control_label = array(
    'class' => 'control-label'
);

$kategori_unduhan_attr = array(
    'name' => 'kategori_unduhan',
    'class' => 'input-medium',
    'value' => set_value('kategori_unduhan', $kategori_unduhan),
    'autocomplete' => 'off'
);

$keterangan_attr = array(
    'name' => 'keterangan',
    'class' => 'span3',
    'value' => set_value('keterangan', $keterangan),
    'autocomplete' => 'off'
);
?>
<div class="container-full" id="kategori_unduhan">
    <?= form_open($action_url, array('class' => 'form-horizontal')); ?>

    <div class="control-group">
        <?= form_label('Kategori Uduhan' . required(), 'kategori_unduhan', $control_label); ?>
        <div class="controls">
            <?= form_input($kategori_unduhan_attr) ?>
            <p class="help-block"><?php echo form_error('kategori_unduhan') ?></p>
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