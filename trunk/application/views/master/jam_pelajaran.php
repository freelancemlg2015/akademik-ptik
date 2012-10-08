<?php
$this->load->view('_shared/header');
$this->load->view('_shared/menus');
?>

<div class="container-fluid form-inline well" id="jam_pelajaran-search">
    <?php
    $kode_jam_attr = array(
        'id' => 'kode_jam',
        'name' => 'kode_jam',
        'class' => 'input-medium',
        'style' => 'text-transform : uppercase;',
        'placeholder' => 'Kode Jam'
    );
    $jam_normal_attr = array(
        'id' => 'jam_normal',
        'name' => 'jam_normal',
        'class' => 'input-medium',
        'style' => 'text-transform : uppercase;',
        'placeholder' => 'Jam Normal'
    );
    echo form_open('master/jam_pelajaran/search/') .
    form_input($kode_jam_attr) . ' ' .
    form_input($jam_normal_attr) . ' ' .
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

<table class="table table-bordered table-striped container-full data_list" id="jam_pelajaran" controller="master">
    <thead>
        <tr>
            <th>Kode Jam</th>
            <th>Jam Normal</th>
            <th>Jam puasa</th>
        </tr>
    </thead>
    <tbody>
        <?php
        foreach ($results->result() as $row) {
            echo '<tr id="' . $row->id . '">
              <td>' . $row->kode_jam . '</td>
              <td>' . $row->jam_normal . '</td>    
              <td>' . $row->jam_puasa . '</td>    
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