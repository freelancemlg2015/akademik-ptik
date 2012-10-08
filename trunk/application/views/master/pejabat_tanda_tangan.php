<?php
$this->load->view('_shared/header');
$this->load->view('_shared/menus');
?>

<div class="container-fluid form-inline well" id="pejabat_tanda_tangan-search">
    <?php
    $nama_jenis_pejabat_attr = array(
        'id' => 'nama_jenis_pejabat',
        'name' => 'nama_jenis_pejabat',
        'class' => 'input-medium',
        'style' => 'text-transform : uppercase;',
        'placeholder' => 'Kategori'
    );
    $nama_pejabat_attr = array(
        'id' => 'nama_pejabat',
        'name' => 'nama_pejabat',
        'class' => 'input-medium',
        'style' => 'text-transform : uppercase;',
        'placeholder' => 'Pejabat'
    );
    echo form_open('master/pejabat_tanda_tangan/search/') .
    form_input($nama_jenis_pejabat_attr) . ' ' .
    form_input($nama_pejabat_attr) . ' ' .
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

<table class="table table-bordered table-striped container-full data_list" id="pejabat_tanda_tangan" controller="master">
    <thead>
        <tr>
            <th>Sub Direktorat</th>
            <th>Kategori</th>
            <th>Kop</th>
            <th>Pejabat</th>
            <th>Tanggal</th>
        </tr>
    </thead>
    <tbody>
        <?php
        foreach ($results->result() as $row) {
            echo '<tr id="' . $row->id . '">
              <td>' . $row->nama_subdirektorat . '</td>
              <td>' . $row->nama_jenis_pejabat . '</td>    
              <td>' . $row->kop . '</td>    
              <td>' . $row->nama_pejabat . '</td>    
              <td>' . $row->tanggal_tanda_tangan . '</td>    
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