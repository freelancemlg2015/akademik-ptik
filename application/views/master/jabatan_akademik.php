<?php
$this->load->view('_shared/header');
$this->load->view('_shared/menus');
?>

<div class="container-fluid form-inline well" id="jabatan_akademik-search">
    <?php
    $kode_jabatan_akademik_attr = array(
        'id' => 'kode_jabatan_akademik',
        'name' => 'kode_jabatan_akademik',
        'class' => 'input-medium',
        'style' => 'text-transform : uppercase;',
        'placeholder' => 'Kode Jabatan Akademik'
    );
    $nama_jabatan_akademik_attr = array(
        'id' => 'nama_jabatan_akademik',
        'name' => 'nama_jabatan_akademik',
        'class' => 'input-medium',
        'style' => 'text-transform : uppercase;',
        'placeholder' => 'Nama Jabatan Akademik'
    );
    echo form_open('master/jabatan_akademik/search/') .
    form_input($kode_jabatan_akademik_attr) . ' ' .
    form_input($nama_jabatan_akademik_attr) . ' ' .
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

<table class="table table-bordered table-striped container-full data_list" id="jabatan_akademik" controller="master">
    <thead>
        <tr>
            <th>Kode Jabatan Akademik</th>
            <th>Nama Jabatan Akademik</th>
        </tr>
    </thead>
    <tbody>
        <?php
        foreach ($results->result() as $row) {
            echo '<tr id="' . $row->id . '">
              <td>' . $row->kode_jabatan_akademik . '</td>
              <td>' . $row->nama_jabatan_akademik . '</td>    
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