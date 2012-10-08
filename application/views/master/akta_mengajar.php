<?php
$this->load->view('_shared/header');
$this->load->view('_shared/menus');
?>

<div class="container-fluid form-inline well" id="akta_mengajar-search">
    <?php
    $kode_akta_attr = array(
        'id' => 'kode_akta',
        'name' => 'kode_akta',
        'class' => 'input-medium',
        'style' => 'text-transform : uppercase;',
        'placeholder' => 'Kode Akta'
    );
    $nama_akta_mengajar_attr = array(
        'id' => 'nama_akta_mengajar',
        'name' => 'nama_akta_mengajar',
        'class' => 'input-medium',
        'style' => 'text-transform : uppercase;',
        'placeholder' => 'Nama Akta Mengajar'
    );
    echo form_open('master/akta_mengajar/search/') .
    form_input($kode_akta_attr) . ' ' .
    form_input($nama_akta_mengajar_attr) . ' ' .
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

<table class="table table-bordered table-striped container-full data_list" id="akta_mengajar" controller="master">
    <thead>
        <tr>
            <th>Kode Akta</th>
            <th>Nama Akta Mengajar</th>
        </tr>
    </thead>
    <tbody>
        <?php
        foreach ($results->result() as $row) {
            echo '<tr id="' . $row->id . '">
              <td>' . $row->kode_akta . '</td>
              <td>' . $row->nama_akta_mengajar . '</td>    
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