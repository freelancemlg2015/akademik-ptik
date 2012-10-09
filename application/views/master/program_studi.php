<?php
$this->load->view('_shared/header');
$this->load->view('_shared/menus');
?>

<div class="container-fluid form-inline well" id="program_studi-search">
    <?php
    $kode_program_studi_attr = array(
        'id' => 'kode_program_studi',
        'name' => 'kode_program_studi',
        'class' => 'input-medium',
        'style' => 'text-transform : uppercase;',
        'placeholder' => 'Kode Program Studi'
    );
    $nama_program_studi_attr = array(
        'id' => 'nama_program_studi',
        'name' => 'nama_program_studi',
        'class' => 'input-medium',
        'style' => 'text-transform : uppercase;',
        'placeholder' => 'Nama Program Studi'
    );
    echo form_open('master/program_studi/search/') .
    form_input($kode_program_studi_attr) . ' ' .
    form_input($nama_program_studi_attr) . ' ' .
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

<table class="table table-bordered table-striped container-full data_list" id="program_studi" controller="master">
    <thead>
        <tr>
            <th>Angkatan</th>
            <th>Kode Program Studi</th>
            <th>Nama Program Studi</th>
            <th>Inisial</th>
            <th>Jenjang Studi</th>
            <th>Status Akreditasi</th>
        </tr>
    </thead>
    <tbody>
        <?php
        foreach ($results->result() as $row) {
            echo '<tr id="' . $row->id . '">
              <td>' . $row->nama_angkatan . '</td>
              <td>' . $row->kode_program_studi . '</td>
              <td>' . $row->nama_program_studi . '</td>
              <td>' . $row->inisial . '</td>
              <td>' . $row->jenjang_studi . '</td>
              <td>' . $row->status_akreditasi . '</td>      
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