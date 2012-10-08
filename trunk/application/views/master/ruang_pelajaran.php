<?php
$this->load->view('_shared/header');
$this->load->view('_shared/menus');
?>

<div class="container-fluid form-inline well" id="ruang_pelajaran-search">
    <?php
    $kode_ruang_attr = array(
        'id' => 'kode_ruang',
        'name' => 'kode_ruang',
        'class' => 'input-medium',
        'style' => 'text-transform : uppercase;',
        'placeholder' => 'Kode Ruang'
    );
    $nama_ruang_attr = array(
        'id' => 'nama_ruang',
        'name' => 'nama_ruang',
        'class' => 'input-medium',
        'style' => 'text-transform : uppercase;',
        'placeholder' => 'Nama Ruang'
    );
    echo form_open('master/ruang_pelajaran/search/') .
    form_input($kode_ruang_attr) . ' ' .
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

<table class="table table-bordered table-striped container-full data_list" id="ruang_pelajaran" controller="master">
    <thead>
        <tr>
            <th>Kode Ruang</th>
            <th>Nama Ruang</th>
            <th>Jenis Ruang</th>
            <th>Kapasitas Ruang</th>
        </tr>
    </thead>
    <tbody>
        <?php
        foreach ($results->result() as $row) {
            echo '<tr id="' . $row->id . '">
              <td>' . $row->kode_ruang . '</td>
              <td>' . $row->nama_ruang . '</td>
              <td>' . $row->jenis_ruang. '</td>
              <td>' . $row->kapasitas_ruang . '</td>
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