<?php
$this->load->view('_shared/header');
$this->load->view('_shared/menus');
?>

<div class="container-fluid form-inline well" id="jadwal_kuliah_induk-search">
    <?php
    $nama_dosen_attr = array(
        'id' => 'nama_dosen', //yg ini masih rancu dosen apa mata kuliah
        'name' => 'nama_dosen',
        'class' => 'input-medium',
        'style' => 'text-transform : uppercase;',
        'placeholder' => 'Nama Mata Kuliah'
    );
    $nama_ruang_attr = array(
        'id' => 'nama_ruang',
        'name' => 'nama_ruang',
        'class' => 'input-medium',
        'style' => 'text-transform : uppercase;',
        'placeholder' => 'Nama Ruang'
    );
    echo form_open('transaction/jadwal_kuliah_induk/search/') .
    form_input($nama_dosen_attr) . ' ' .
    form_input($nama_ruang_attr) . ' ' .
    form_submit('cari', 'CARI', 'class="btn btn-mini"') .
    form_close();
    ?>
</div>

<?php if ($pagination): ?>
    <div class="container">
        <div class="pagination pagination-centered">
            <?php echo $pagination; ?>
        </div>
    </div>
<?php endif; ?>

<table class="table table-bordered table-striped container-full data_list" id="jadwal_kuliah_induk" controller="transaction">
    <thead>
        <tr>
            <th>Mata Kuliah</th>
            <th>Hari / Jam</th>
            <th>Pelaksanaan Kuliah</th>
        </tr>
    </thead>
    <tbody>
        <?php
		// $row->nama_mata_kuliah.
		//$row->nama_hari.'<br>'.$row->jam_normal_mulai .' - '. $row->jam_normal_akhir .
		//$row->pelaksanaan_kuliah.
        foreach ($results->result() as $row) {
			echo '<tr id="' . $row->id . '">
              <td>' . $row->nama_mata_kuliah . '</td>  
              <td>' . $row->nama_hari.'<br>'.$row->jam_normal_mulai .' - '. $row->jam_normal_akhir . '</td>  
              <td>' . $row->pelaksanaan_kuliah . '</td>  
            </tr>
          ';
        }
        ?>
    </tbody>
</table>

<?php if ($pagination): ?>
    <div class="container">
        <div class="pagination pagination-centered">
            <?php echo $pagination; ?>
        </div>
    </div>
<?php endif; ?>

<?php $this->load->view('_shared/footer'); ?>