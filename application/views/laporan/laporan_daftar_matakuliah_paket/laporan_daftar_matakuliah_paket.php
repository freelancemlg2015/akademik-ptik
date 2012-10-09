<?php
$this->load->view('_shared/header');
$this->load->view('_shared/menus');
?>

<div class="container-fluid form-inline well" id="mata_kuliah-search">
    <?php
     $semester_attr = array(
        'id' => 'kode_semester',
        'name' => 'kode_semester',
        'class' => 'input-medium',
        'style' => 'text-transform : uppercase;',
        'placeholder' => 'Semester'
    );
    $angkatan_attr = array(
        'id' => 'kode_angkatan',
        'name' => 'kode_angkatan',
        'class' => 'input-medium',
        'placeholder' => 'Kode Angakatan'
    );
    echo form_open('laporan/laporan_daftar_matakuliah_paket/search/') .
    form_input($semester_attr) . ' ' .
    form_input($angkatan_attr) . ' ' .
    form_submit('cari', 'CARI', 'class="btn btn-mini"') .
    form_close();
    ?>

    <div class="pull-right">
          <div class="btn-group">
	    <?php
	    echo form_open('laporan/laporan_daftar_matakuliah_paket/report/') .
    	    form_hidden("kode_angkatan", $kode_angkatan) . ' ' .
    	    form_hidden("kode_semester", $kode_semester) . ' ' .
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

<table class="table table-bordered table-striped container-full data_list" id="mata_kuliah" controller="master">
    <thead>
        <tr>
            <th>Angkatan</th>
            <th>Program Studi</th>
            <th>Jenjang Studi</th>
            <th>Tahun Akademik</th>
            <th>Kode Mata Kuliah</th>
            <th>Nama Mata Kuliah</th>
        </tr>
    </thead>
    <tbody>
        <?php
        foreach ($results->result() as $row) {
            echo '<tr id="' . $row->id . '">
              <td>' . $row->nama_angkatan . '</td>
              <td>' . $row->nama_program_studi . '</td>
              <td>' . $row->jenjang_studi . '</td>
              <td>' . $row->tahun_ajar_mulai . ' - ' . $row->tahun_ajar_akhir . '</td>
              <td>' . $row->kode_mata_kuliah . '</td>
              <td>' . $row->nama_mata_kuliah . '</td>
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
