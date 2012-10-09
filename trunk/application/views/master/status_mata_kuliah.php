<?php
$this->load->view('_shared/header');
$this->load->view('_shared/menus');
?>

<div class="container-fluid form-inline well" id="status_mata_kuliah-search">
    <?php
    $kode_matakuliah_attr = array(
        'id' => 'kode_matakuliah',
        'name' => 'kode_matakuliah',
        'class' => 'input-medium',
        'style' => 'text-transform : uppercase;',
        'placeholder' => 'Kode Matakuliah'
    );
    $nama_matakuliah_attr = array(
        'id' => 'nama_matakuliah',
        'name' => 'nama_matakuliah',
        'class' => 'input-medium',
        'style' => 'text-transform : uppercase;',
        'placeholder' => 'Nama Matakuliah'
    );
    echo form_open('master/status_mata_kuliah/search/') .
    form_input($kode_matakuliah_attr) . ' ' .
    form_input($nama_matakuliah_attr) . ' ' .
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

<table class="table table-bordered table-striped container-full data_list" id="status_mata_kuliah" controller="master">
    <thead>
        <tr>
            <th>Kode Dik</th>
            <th>Angkatan</th>
<!--            <th>Kode Dik Angkatan</th>-->
            <th>Kode Matakuliah</th>
            <th>Nama Matakuliah</th>
            <th>Status Matakuliah</th>
            <th>Jumlah SKS</th>
        </tr>
    </thead>
    <tbody>
        <?php
        foreach ($results->result() as $row) {
            echo '<tr id="' . $row->id . '"> 
              <td>' . $row->nama_angkatan . '</td>   
              <td>' . $row->kode_dikang . '</td>   
              <td>' . $row->kode_matakuliah . '</td>   
              <td>' . $row->nama_matakuliah . '</td>   
              <td>' . $row->status_mata_kuliah . '</td>   
              <td>' . $row->jml_sks . '</td>   
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