<?php
$this->load->view('_shared/header');
$this->load->view('_shared/menus');
?>

<div class="container-fluid form-inline well" id="pangkat-search">
    <?php
    $kode_pangkat_attr = array(
        'id' => 'kode_pangkat',
        'name' => 'kode_pangkat',
        'class' => 'input-medium',
        'style' => 'text-transform : uppercase;',
        'placeholder' => 'Kode Pangkat'
    );
    $nama_pangkat_attr = array(
        'id' => 'nama_pangkat',
        'name' => 'nama_pangkat',
        'class' => 'input-medium',
        'style' => 'text-transform : uppercase;',
        'placeholder' => 'Nama Pangkat'
    );
    echo form_open('master/pangkat/search/') .
    form_input($kode_pangkat_attr) . ' ' .
    form_input($nama_pangkat_attr) . ' ' .
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

<table class="table table-bordered table-striped container-full data_list" id="pangkat" controller="master">
    <thead>
        <tr>
            <th>Kode Pangkat</th>
            <th>Nama Pangkat</th>
        </tr>
    </thead>
    <tbody>
        <?php
        foreach ($results->result() as $row) {
            echo '<tr id="' . $row->id . '">
              <td>' . $row->kode_pangkat . '</td>
              <td>' . $row->nama_pangkat . '</td>    
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