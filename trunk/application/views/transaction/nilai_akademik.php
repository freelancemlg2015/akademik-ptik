<?php
$this->load->view('_shared/header');
$this->load->view('_shared/menus');
?>

<div class="container-fluid form-inline well" id="nilai_akademik-search">
    <?php
    $nim_attr = array(
        'id' => 'nim',
        'name' => 'nim',
        'class' => 'input-medium',
        'style' => 'text-transform : uppercase;',
        'placeholder' => 'Nim'
    );
    $nama_mata_kuliah_attr = array(
        'id' => 'nama_mata_kuliah',
        'name' => 'nama_mata_kuliah',
        'class' => 'input-medium',
        'style' => 'text-transform : uppercase;',
        'placeholder' => 'Mata Kuliah'
    );
    echo form_open('transaction/nilai_akademik/search/') .
    form_input($nim_attr) . ' ' .
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

<table class="table table-bordered table-striped container-full data_list" id="nilai_akademik" controller="transaction">
    <thead>
        <tr>
            <th>Nim</th>
            <th>Mata Kuliah</th>
            <th>Nilai NTS</th>
            <th>Nilai Tugas</th>
            <th>Nilai NAS</th>
            <th>Mata Perubahan</th>
            <th>Nilai Akhir</th>
            <th>Rangking</th>
        </tr>
    </thead>
    <tbody>
        <?php
        foreach ($results->result() as $row) {
            echo '<tr id="' . $row->id . '">
              <td>' . $row->nim . '</td>
              <td>' . $row->nama_matakuliah . '</td>    
              <td>' . $row->nilai_nts . '</td>    
              <td>' . $row->nilai_tgs . '</td>    
              <td>' . $row->nilai_nas . '</td>    
              <td>' . $row->nilai_prb . '</td>    
              <td>' . $row->rangking . '</td>    
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