<?php
$this->load->view('_shared/header');
$this->load->view('_shared/menus');
?>

<div class="container-fluid form-inline well" id="jadwal_kuliah-search">
    <?php
    echo form_open('transaction/plot_semester/search/') .
    //form_input($nama_dosen_attr) . ' ' .
   // form_input($nama_ruang_attr) . ' ' .
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

<table class="table table-bordered table-striped container-full data_list" id="plot_semester" controller="transaction">
    <thead>
        <tr>
            <th>Angkatan</th>
            <th>Tahun Akademik</th>
            <th>Semester</th>
            <th>Tanggal Mulai</th>
            <th>Tanggal Akhir</th>
        </tr>
    </thead>
    <tbody>
        <?php
        foreach ($results->result() as $row) {
            //$display_event = $row->nama_mata_kuliah;
			//if($row->kegiatan_id!=0) $display_event = $row->nama_kegiatan;
			echo '<tr id="' . $row->id . '">
              <td>' . $row->nama_angkatan . '</td>
              <td>' . $row->tahun_ajar_mulai .'-'. $row->tahun_ajar_akhir . '</td>
              <td>' . $row->nama_semester . '</td>
              <td>' . $row->tgl_kalender_mulai . '</td>
              <td>' . $row->tgl_kalender_akhir . '</td> 
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