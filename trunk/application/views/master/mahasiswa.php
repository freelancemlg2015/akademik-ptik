<?php
$this->load->view('_shared/header');
$this->load->view('_shared/menus');
?>

<div class="container-fluid form-inline well" id="mahasiswa-search">
    <?php
    $nim_attr = array(
        'id' => 'nim',
        'name' => 'nim',
        'class' => 'input-medium',
        'style' => 'text-transform : uppercase;',
        'placeholder' => 'Nim'
    );
    $nama_attr = array(
        'id' => 'nama',
        'name' => 'nama',
        'class' => 'input-medium',
        'style' => 'text-transform : uppercase;',
        'placeholder' => 'Nama'
    );
    echo form_open('master/mahasiswa/search/') .
    form_input($nim_attr) . ' ' .
    form_input($nama_attr) . ' ' .
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

<table class="table table-bordered table-striped container-full data_list" id="mahasiswa" controller="master">
    <thead>
        <tr>
            <?php /*?><th>Kode Dik</th><?php */?>
            <th>Angkatan</th>
            <?php /*?><th>Kode Dik Ang</th><?php 
            <th>Jenis Dik</th>
            <th>Sebutan Dik</th>*/?>
            <th>Nim</th>
            <th>Nama</th>
        </tr>
    </thead>
    <tbody>
        <?php
        foreach ($results->result() as $row) {
            echo '<tr id="' . $row->id . '">
              <td>' . $row->nama_angkatan . '</td>
              <td>' . $row->nim . '</td>
              <td>' . $row->nama . '</td>
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