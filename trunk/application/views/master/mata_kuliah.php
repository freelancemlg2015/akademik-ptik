<?php
$this->load->view('_shared/header');
$this->load->view('_shared/menus');
?>

<div class="container-fluid form-inline well" id="mata_kuliah-search">
    <?php
    $kode_mata_kuliah_attr = array(
        'id' => 'kode_mata_kuliah',
        'name' => 'kode_mata_kuliah',
        'class' => 'input-medium',
        'style' => 'text-transform : uppercase;',
        'placeholder' => 'Kode Mata Kuliah'
    );
    $nama_mata_kuliah_attr = array(
        'id' => 'nama_mata_kuliah',
        'name' => 'nama_mata_kuliah',
        'class' => 'input-medium',
        'style' => 'text-transform : uppercase;',
        'placeholder' => 'Nama Mata Kuliah'
    );
    echo form_open('master/mata_kuliah/search/') .
    form_input($kode_mata_kuliah_attr) . ' ' .
    form_input($nama_mata_kuliah_attr) . ' ' .
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

<table class="table table-bordered table-striped container-full data_list" id="mata_kuliah" controller="master">
    <thead>
        <tr>
<!--        <th>Angkatan</th>
            <th>Tahun Akademik</th>
            <th>Program Studi</th>
            <th>Semester</th>-->
            <th>Kode Matakuliah</th>
            <th>Nama Matakuliah</th>
            <th>SKS</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody>
        <?php
        foreach ($results->result() as $row) {
            echo '<tr id="' . $row->id . '">
              <td>' . $row->kode_mata_kuliah . '</td>
              <td>' . $row->nama_mata_kuliah . '</td>
              <td>' . $row->sks_mata_kuliah . '</td>
			  <td>' . $row->status_mata_kuliah . '</td>
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