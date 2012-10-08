<?php
$this->load->view('_shared/header');
$this->load->view('_shared/menus');
?>

<div class="container-fluid form-inline well" id="konsentrasi_studi-search">
    <?php
    $kode_konsentrasi_studi_attr = array(
        'id' => 'kode_konsentrasi_studi',
        'name' => 'kode_konsentrasi_studi',
        'class' => 'input-medium',
        'style' => 'text-transform : uppercase;',
        'placeholder' => 'Kode Konsentrasi Studi'
    );
    $nama_konsentrasi_studi_attr = array(
        'id' => 'nama_konsentrasi_studi',
        'name' => 'nama_konsentrasi_studi',
        'class' => 'input-medium',
        'style' => 'text-transform : uppercase;',
        'placeholder' => 'Nama Konsentrasi Studi'
    );
    echo form_open('master/konsentrasi_studi/search/') .
    form_input($kode_konsentrasi_studi_attr) . ' ' .
    form_input($nama_konsentrasi_studi_attr) . ' ' .
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

<table class="table table-bordered table-striped container-full data_list" id="konsentrasi_studi" controller="master">
    <thead>
        <tr>
            <th>Kode Konsentrasi Studi</th>
            <th>Nama Konsentrasi Studi</th>
        </tr>
    </thead>
    <tbody>
        <?php
        foreach ($results->result() as $row) {
            echo '<tr id="' . $row->id . '">
              <td>' . $row->kode_konsentrasi_studi . '</td>
              <td>' . $row->nama_konsentrasi_studi . '</td>    
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