<?php
$this->load->view('_shared/header');
$this->load->view('_shared/menus');
?>

<div class="container-fluid form-inline well" id="kesatuan_asal-search">
    <?php
    $kode_kesatuan_asal_attr = array(
        'id' => 'kode_kesatuan_asal',
        'name' => 'kode_kesatuan_asal',
        'class' => 'input-medium',
        'style' => 'text-transform : uppercase;',
        'placeholder' => 'Kode Kesatuan Asal'
    );
    $nama_kesatuan_asal_attr = array(
        'id' => 'nama_kesatuan_asal',
        'name' => 'nama_kesatuan_asal',
        'class' => 'input-medium',
        'style' => 'text-transform : uppercase;',
        'placeholder' => 'Nama Kesatuan Asal'
    );
    echo form_open('master/kesatuan_asal/search/') .
    form_input($kode_kesatuan_asal_attr) . ' ' .
    form_input($nama_kesatuan_asal_attr) . ' ' .
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

<table class="table table-bordered table-striped container-full data_list" id="kesatuan_asal" controller="master">
    <thead>
        <tr>
            <th>Kode Kesatuan Asal</th>
            <th>Nama Kesatuan Asal</th>
        </tr>
    </thead>
    <tbody>
        <?php
        foreach ($results->result() as $row) {
            echo '<tr id="' . $row->id . '">
              <td>' . $row->kode_kesatuan_asal . '</td>
              <td>' . $row->nama_kesatuan_asal . '</td>    
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