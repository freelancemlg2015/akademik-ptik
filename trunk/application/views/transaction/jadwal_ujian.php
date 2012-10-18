<?php
$this->load->view('_shared/header');
$this->load->view('_shared/menus');
?>

<div class="container-fluid form-inline well" id="jadwal_kuliah-search">
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
    echo form_open('transaction/jadwal_ujian/search/') .
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

<table class="table table-bordered table-striped container-full data_list" id="jadwal_ujian" controller="transaction">
    <thead>
        <tr>
            <th>Nama Mata Kuliah</th>
			<th>Jenis Ujian</th>
			<th>Waktu</th>
            <th>Ruang</th>
        </tr>
    </thead>
    <tbody>
        <?php
        foreach ($results->result() as $row) {
			echo '<tr id="' . $row->id . '">
              <td>' . $row->nama_mata_kuliah . '</td>
              <td>' . $row->kode_ujian . '</td>
              <td>'.$row->tanggal.' ('.$row->waktu_mulai. ' - '. $row->waktu_mulai  . ')</td>
			   <td>' . $row->nama_ruang . '</td>
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