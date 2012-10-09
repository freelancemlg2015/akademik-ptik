<?php
$this->load->view('_shared/header');
$this->load->view('_shared/menus');
?>

<div class="container-fluid form-inline well" id="jadwal_kuliah-search">
    <?php
    $semester_attr = array(
        'id' => 'kode_semester',
        'name' => 'kode_semester',
        'class' => 'input-medium',
        'placeholder' => 'Semester'
    );
    $angkatan_attr = array(
        'id' => 'kode_angkatan',
        'name' => 'kode_angkatan',
        'class' => 'input-medium',
        'placeholder' => 'Angkatan'
    );
    $minggu_attr = array(
        'id' => 'minggu',
        'name' => 'minggu',
        'class' => 'input-medium',
        'placeholder' => 'Minggu Ke'
    );
    echo form_open('laporan/laporan_jadwal_perkuliahan/search/') .
    form_input($semester_attr) . ' ' .
    form_input($angkatan_attr) . ' ' .
    form_input($minggu_attr) . ' ' .
    form_submit('cari', 'CARI', 'class="btn btn-mini"') .
    form_close();
    ?>

     <div class="pull-right">
          <div class="btn-group">
	    <?php
	    echo form_open('laporan/laporan_jadwal_perkuliahan/report/') .
    	    form_hidden("kode_angkatan", $kode_angkatan) . ' ' .
    	    form_hidden("kode_semester", $kode_semester) . ' ' .
    	    form_hidden("minggu", $minggu) . ' ' .
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

<table class="table table-bordered table-striped container-full data_list" id="jadwal_kuliah" controller="transaction">
    <thead>
        <tr>
            <th>Dosen</th>
            <th>Ruang</th>
            <th>Mata Kuliah</th>
            <th>Jenis Waktu</th>
        </tr>
    </thead>
    <tbody>
        <?php
        foreach ($results->result() as $row) {
            echo '<tr id="' . $row->id . '">
              <td>' . $row->nama_dosen . '</td>  
              <td>' . $row->nama_ruang . '</td>  
              <td>' . $row->nama_mata_kuliah . '</td>  
              <td>' . $row->jenis_waktu . '</td>  
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
