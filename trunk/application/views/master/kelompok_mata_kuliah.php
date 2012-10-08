<?php
$this->load->view('_shared/header');
$this->load->view('_shared/menus');
?>

<div class="container-fluid form-inline well" id="kelompok_mata_kuliah-search">
    <?php
    $kode_mata_kuliah_attr = array(
        'id' => 'kode_kelompok_mata_kuliah',
        'name' => 'kode_kelompok_mata_kuliah',
        'class' => 'input-medium',
        'style' => 'text-transform : uppercase;',
        'placeholder' => 'Kode Kelompok Mata Kuliah'
    );
    $kelompok_mata_kuliah_attr = array(
        'id' => 'kelompok_mata_kuliah',
        'name' => 'kelompok_mata_kuliah',
        'class' => 'input-medium',
        'style' => 'text-transform : uppercase;',
        'placeholder' => 'Kelompok Mata Kuliah'
    );
    echo form_open('master/kelompok_mata_kuliah/search/') .
    form_input($kode_mata_kuliah_attr) . ' ' .
    form_input($kelompok_mata_kuliah_attr) . ' ' .
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

<table class="table table-bordered table-striped container-full data_list" id="kelompok_mata_kuliah" controller="master">
    <thead>
        <tr>
            <th>Kode Kelompok</th>
            <th>Kelompok Mata Kuliah</th>
        </tr>
    </thead>
    <tbody>
        <?php
        foreach ($results->result() as $row) {
            echo '<tr id="' . $row->id . '">
              <td>' . $row->kode_kelompok_mata_kuliah . '</td>
              <td>' . $row->kelompok_mata_kuliah . '</td>    
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