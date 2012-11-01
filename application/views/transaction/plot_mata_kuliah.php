<?php
$this->load->view('_shared/header');
$this->load->view('_shared/menus');
?>

<div class="container-fluid form-inline well" id="plot_mata_kuliah-search">
    <?php
    $nama_angkatan_attr = array(
        'id'    => 'nama_angkatan',
        'name'  => 'nama_angkatan',
        'class' => 'input-medium',
        'style' => 'text-transform : uppercase;',
        'placeholder' => 'Angkatan'
    );
    $semester_attr = array(
        'id'    => 'semester',
        'name'  => 'semester',
        'class' => 'input-medium',
        'style' => 'text-transform : uppercase;',
        'placeholder' => 'Semester'
    );
    echo form_open('transaction/plot_mata_kuliah/search/') .
    form_input($nama_angkatan_attr) . ' ' .
    form_input($semester_attr) . ' ' .
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

<table class="table table-bordered table-striped container-full data_list" id="plot_mata_kuliah" controller="transaction">
    <thead>
        <tr>
            <th>Angkatan</th>
            <th>Semester</th>
            <th>Kelompok Matakuliah</th>
        </tr>
    </thead>
    <tbody>
        <?php
        foreach ($results->result() as $row) {
            echo '<tr id="' . $row->id . '">
              <td>' . $row->nama_angkatan . '</td>
              <td>' . $row->nama_semester . '</td>    
              <td>' . $row->nama_kelompok_mata_kuliah . '</td>  
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