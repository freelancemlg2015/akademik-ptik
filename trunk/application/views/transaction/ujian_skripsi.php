<?php
$this->load->view('_shared/header');
$this->load->view('_shared/menus');
?>

<div class="container-fluid form-inline well" id="ujian_skripsi-search">
    <?php
    $nim_attr = array(
        'id' => 'nim',
        'name' => 'nim',
        'class' => 'input-medium',
        'style' => 'text-transform : uppercase;',
        'placeholder' => 'Nim'
    );
    $judul_skripsi_attr = array(
        'id' => 'judul_skripsi',
        'name' => 'judul_skripsi',
        'class' => 'input-medium',
        'style' => 'text-transform : uppercase;',
        'placeholder' => 'Judul Skripsi'
    );
    echo form_open('transaction/ujian_skripsi/search/') .
    form_input($nim_attr) . ' ' .
    form_input($judul_skripsi_attr) . ' ' .
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

<table class="table table-bordered table-striped container-full data_list" id="ujian_skripsi" controller="transaction">
    <thead>
        <tr>
            <th>Nim</th>
            <th>Judul Skripsi</th>
            <th>Tanggal Ujian</th>
            <th>Jam Mulai</th>
            <th>Jam Akhir</th>
            <th>Ketua Penguji</th>
        </tr>
    </thead>
    <tbody>
        <?php
        foreach ($results->result() as $row) {
            echo '<tr id="' . $row->id . '">
              <td>' . $row->nim . '</td>
              <td>' . $row->judul_skripsi . '</td>    
              <td>' . $row->tgl_ujian . '</td>    
              <td>' . $row->jam_mulai . '</td>    
              <td>' . $row->jam_akhir . '</td>    
              <td>' . $row->ketua_penguji . '</td>    
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