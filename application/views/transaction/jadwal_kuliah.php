<?php
$this->load->view('_shared/header');
$this->load->view('_shared/menus');
?>

<div class="container-fluid form-inline well" id="jadwal_kuliah-search">
    <?php
    $nama_dosen_attr = array(
        'id' => 'nama_dosen',
        'name' => 'nama_dosen',
        'class' => 'input-medium',
        'style' => 'text-transform : uppercase;',
        'placeholder' => 'Nama Dosen'
    );
    $nama_ruang_attr = array(
        'id' => 'nama_ruang',
        'name' => 'nama_ruang',
        'class' => 'input-medium',
        'style' => 'text-transform : uppercase;',
        'placeholder' => 'Nama Ruang'
    );
    echo form_open('transaction/jadwal_kuliah/search/') .
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

<table class="table table-bordered table-striped container-full data_list" id="jadwal_kuliah" controller="transaction">
    <thead>
        <tr>
            <th>Dosen</th>
            <th>Ruang</th>
            <th>Jenis Waktu</th>
        </tr>
    </thead>
    <tbody>
        <?php
        foreach ($results->result() as $row) {
            echo '<tr id="' . $row->id . '">
              <td>' . $row->nama_dosen . '</td>  
              <td>' . $row->nama_ruang . '</td>  
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