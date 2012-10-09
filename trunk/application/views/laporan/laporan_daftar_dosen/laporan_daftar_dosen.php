<?php
$this->load->view('_shared/header');
$this->load->view('_shared/menus');
?>

<div class="container-fluid form-inline well" id="dosen-search">
    <?php
    $angkatan_attr = array(
        'id' => 'kode_angkatan',
        'name' => 'kode_angkatan',
        'class' => 'input-medium',
        'placeholder' => 'Angkatan'
    );
    $prodi_attr = array(
        'id' => 'prodi',
        'name' => 'prodi',
        'class' => 'input-medium',
        'style' => 'text-transform : uppercase;',
        'placeholder' => 'Program Studi'
    );
    echo form_open('laporan/laporan_daftar_dosen/search/') .
    form_input($angkatan_attr) . ' ' .
    form_input($prodi_attr) . ' ' .
    form_submit('cari', 'CARI', 'class="btn btn-mini"') .
    form_close();
    ?>

    <div class="pull-right">
          <div class="btn-group">
	    <?php
	    echo form_open('laporan/laporan_daftar_dosen/report/') .
    	    form_hidden("kode_angkatan", $kode_angkatan) . ' ' .
    	    form_hidden("prodi", $prodi) . ' ' .
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

<table class="table table-bordered table-striped container-full data_list" id="dosen" controller="master">
    <thead>
        <tr>
            <th>No Karpeg Dosen</th>
            <th>No Dosen Fakultas</th>
            <th>Nama Dosen</th>
            <th>Gelar Depan</th>
            <th>Gelar Belakang</th>
            <th>Tempat Lahir</th>
            <th>Tanggal Lahir</th>
        </tr>
    </thead>
    <tbody>
        <?php
        foreach ($results->result() as $row) {
            echo '<tr id="' . $row->id . '">
              <td>' . $row->no_karpeg_dosen . '</td>
              <td>' . $row->no_dosen_fakultas . '</td>
              <td>' . $row->nama_dosen . '</td>
              <td>' . $row->gelar_depan . '</td>
              <td>' . $row->gelar_belakang . '</td>
              <td>' . $row->tempat_lahir . '</td>
              <td>' . $row->tgl_lahir . '</td>     
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
