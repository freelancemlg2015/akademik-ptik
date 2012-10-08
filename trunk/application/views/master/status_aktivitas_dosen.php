<?php
$this->load->view('_shared/header');
$this->load->view('_shared/menus');
?>

<div class="container-fluid form-inline well" id="status_aktivitas_dosen-search">
    <?php
    $kode_status_aktivitas_attr = array(
        'id' => 'kode_status_aktivitas',
        'name' => 'kode_status_aktivitas',
        'class' => 'input-medium',
        'style' => 'text-transform : uppercase;',
        'placeholder' => 'Kode Status Aktivitas'
    );
    $status_aktivitas_dosen_attr = array(
        'id' => 'status_aktivitas_dosen',
        'name' => 'status_aktivitas_dosen',
        'class' => 'input-medium',
        'style' => 'text-transform : uppercase;',
        'placeholder' => 'Status Aktivitas Dosen'
    );
    echo form_open('master/status_aktivitas_dosen/search/') .
    form_input($kode_status_aktivitas_attr) . ' ' .
    form_input($status_aktivitas_dosen_attr) . ' ' .
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

<table class="table table-bordered table-striped container-full data_list" id="status_aktivitas_dosen" controller="master">
    <thead>
        <tr>
            <th>Kode Status Aktivitas</th>
            <th>Status Aktivitas Dosen</th>
        </tr>
    </thead>
    <tbody>
        <?php
        foreach ($results->result() as $row) {
            echo '<tr id="' . $row->id . '">
              <td>' . $row->kode_status_aktivitas . '</td>
              <td>' . $row->status_aktivitas_dosen . '</td>    
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