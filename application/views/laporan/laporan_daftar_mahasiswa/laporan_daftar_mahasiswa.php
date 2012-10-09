<?php
$this->load->view('_shared/header');
$this->load->view('_shared/menus');
?>

<div class="container-fluid form-inline well" id="mahasiswa-search">
    <?php
    $nama_attr = array(
        'id' => 'kode_angkatan',
        'name' => 'kode_angkatan',
        'class' => 'input-medium',
        'placeholder' => 'Angkatan'
    );
    echo form_open('laporan/laporan_daftar_mahasiswa/search/') .
    form_input($nama_attr) . ' ' .
    form_submit('cari', 'CARI', 'class="btn btn-mini"') .
    form_close();
    ?>

    <div class="pull-right">
          <div class="btn-group">
	    <?php
	    echo form_open('laporan/laporan_daftar_mahasiswa/report/') .
    	    form_hidden("kode_angkatan", $kode_angkatan) . ' ' .
	    form_submit('cetak', 'CETAK', 'class="btn btn-info"') .
	    form_close();
	    ?>
    	  </div>
    </div>
    </div>

<?php if ($pagination): ?>
    <div class="container">
        <div class="pagination pagination-centered">
            <?php echo $pagination; ?>
        </div>
    </div>
<?php endif; ?>

<table class="table table-bordered table-striped container-full data_list" id="mahasiswa" controller="master">
    <thead>
        <tr>
            <th>Nim</th>
            <th>Nama</th>
            <th>Angkatan</th>
            <th>Tempat Lahir</th>
            <th>Tanggal Lahir</th>
            <th>Jenis Kelamin</th>
            <th>Agama</th>
        </tr>
    </thead>
    <tbody>
        <?php
        foreach ($results->result() as $row) {
            echo '<tr id="' . $row->id . '">
              <td>' . $row->nim . '</td>
              <td>' . $row->nama . '</td>
              <td>' . $row->nama_angkatan . '</td>
              <td>' . $row->tempat_lahir . '</td>
              <td>' . $row->tgl_lahir . '</td>
              <td>' . $row->jenis_kelamin . '</td>
              <td>' . $row->agama . '</td>
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
