<?php
$this->load->view('_shared/header');
$this->load->view('_shared/menus');
?>

<div class="container-fluid form-inline well" id="unduhan-search">
    <?php
    $kategori_unduhan_attr = array(
        'id' => 'kategori_unduhan',
        'name' => 'kategori_unduhan',
        'class' => 'input-medium',
        'style' => 'text-transform : uppercase;',
        'placeholder' => 'Kategori Unduhan'
    );
    $nama_unduhan_attr = array(
        'id' => 'nama_unduhan',
        'name' => 'nama_unduhan',
        'class' => 'input-medium',
        'style' => 'text-transform : uppercase;',
        'placeholder' => 'Nama Unduhan'
    );
    echo form_open('master/unduhan/search/') .
    form_input($kategori_unduhan_attr) . ' ' .
    form_input($nama_unduhan_attr) . ' ' .
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

<table class="table table-bordered table-striped container-full data_list" id="unduhan" controller="master">
    <thead>
        <tr>
            <th>Kategori</th>
            <th>Unduhan</th>
            <th>Keterangan</th>
        </tr>
    </thead>
    <tbody>
        <?php
        foreach ($results->result() as $row) {
            echo '<tr id="' . $row->id . '">
              <td>' . $row->kategori_unduhan . '</td>
              <td>' . $row->nama_unduhan . '</td>    
              <td>' . $row->keterangan . '</td>    
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