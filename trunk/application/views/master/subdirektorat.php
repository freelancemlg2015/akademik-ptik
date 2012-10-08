<?php
$this->load->view('_shared/header');
$this->load->view('_shared/menus');
?>

<div class="container-fluid form-inline well" id="subdirektorat-search">
    <?php
    $nama_direktorat_attr = array(
        'id' => 'nama_direktorat',
        'name' => 'nama_direktorat',
        'class' => 'input-medium',
        'style' => 'text-transform : uppercase;',
        'placeholder' => 'Direktorat'
    );
    $nama_subdirektorat_attr = array(
        'id' => 'nama_subdirektorat',
        'name' => 'nama_subdirektorat',
        'class' => 'input-medium',
        'style' => 'text-transform : uppercase;',
        'placeholder' => 'Sub Direktorat'
    );
    echo form_open('master/subdirektorat/search/') .
    form_input($nama_direktorat_attr) . ' ' .
    form_input($nama_subdirektorat_attr) . ' ' .
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

<table class="table table-bordered table-striped container-full data_list" id="subdirektorat" controller="master">
    <thead>
        <tr>
            <th>Direktorat</th>
            <th>Sub Direktorat</th>
            <th>Keterangan</th>
        </tr>
    </thead>
    <tbody>
        <?php
        foreach ($results->result() as $row) {
            echo '<tr id="' . $row->id . '">
              <td>' . $row->nama_direktorat . '</td>
              <td>' . $row->nama_subdirektorat . '</td>
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