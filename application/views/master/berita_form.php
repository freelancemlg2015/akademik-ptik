<?php
$this->load->view('_shared/header');
$this->load->view('_shared/menus');

//label
$control_label = array(
    'class' => 'control-label'
);

$judul_berita_attr = array(
    'name' => 'judul_berita',
    'class' => 'input-medium',
    'value' => set_value('judul_berita', $judul_berita),
    'autocomplete' => 'off'
);

$konten_berita_attr = array(
    'name' => 'konten_berita',
    'class' => 'span3',
    'value' => set_value('konten_berita', $konten_berita),
    'autocomplete' => 'off'
);

$foto_berita_attr = array(
    'name' => 'foto_berita',
    'class' => 'input-medium',
    'value' => set_value('foto_berita', $foto_berita),
    'autocomplete' => 'off'
);

$kategori_berita_data[0] = '';
foreach ($kategori_berita_options as $row) {
    $kategori_berita_data[$row->id] = $row->kategori_berita;
}

?>
<div id="contant">
  <div id="main">
     <div class="left">
      <div class="leftbox">
        <div class="leftnav"><strong>Pengumuman</strong></div>
        <div class="leftn"> <marquee direction="up"  height="160" scrollamount="2"  onMouseOver="this.stop()" onMouseOut="this.start()">
	   Ini konten kiri
		</a>

					</marquee></div>
      </div>
      <div class="leftbox">
        <div class="leftnav"><strong>ewwew</strong></div>
        <div class="leftn">
        
        
        <br />PTIK
		<br />eqweq 
		<br />eqweq
        <br />2027-88888888
        <br />2027-88888888</div>
      </div>
    </div>
<div class="container" id="berita">
<div id="main">
    <?= form_open_multipart($action_url, array('class' => 'form-horizontal')); ?>

    <div class="control-group">
        <?= form_label('Kategori', 'kategori_berita_id', $control_label); ?>
        <div class="controls">
            <?= form_dropdown('kategori_berita_id', $kategori_berita_data, set_value('kategori_berita_id', $kategori_berita_id), 'id="kategori_berita_id" class="input-medium" prevData-selected="' . set_value('kategori_berita_id', $kategori_berita_id) . '"'); ?>
            <p class="help-block"><?php echo form_error('kode_angkatan') ?></p>
        </div>
    </div>

    <div class="control-group">
        <?= form_label('Judul' . required(), 'judul_berita', $control_label); ?>
        <div class="controls">
            <?= form_input($judul_berita_attr) ?>
            <p class="help-block"><?php echo form_error('judul_berita') ?></p>
        </div>
    </div>
    
    <div class="control-group">
        <?= form_label('Konten Berita' . required(), 'konten_berita', $control_label); ?>
        <div class="controls">
            <?= form_textarea($konten_berita_attr) ?>
            <p class="help-block"><?php echo form_error('konten_berita') ?></p>
        </div>
    </div>
    
    <div class="control-group">
        <?= form_label('Foto Berita' , 'foto_berita', $control_label); ?>
        <div class="controls">
            <?= form_upload($foto_berita_attr) ?>
            <p class="help-block"><?php echo form_error('foto_berita') ?></p>
        </div>
    </div>


    <div class="form-actions well">
        <button class="btn btn-small btn-primary" type="submit">Simpan</button>
    </div>
    <?php form_close() ?>
</div>
<?php $this->load->view('_shared/footer'); ?>