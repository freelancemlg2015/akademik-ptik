<?php
$this->load->view('_shared/header');
$this->load->view('_shared/menus');
?>

<div class="container-fluid form-inline well" id="status_kerja_dosen-search">
    <?php
    $kode_status_kerja_dosen_attr = array(
        'id' => 'kode_status_kerja_dosen',
        'name' => 'kode_status_kerja_dosen',
        'class' => 'input-medium',
        'style' => 'text-transform : uppercase;',
        'placeholder' => 'Kode Status Kerja Dosen'
    );
    $status_kerja_dosen_attr = array(
        'id' => 'status_kerja_dosen',
        'name' => 'status_kerja_dosen',
        'class' => 'input-medium',
        'style' => 'text-transform : uppercase;',
        'placeholder' => 'Status Kerja Dosen'
    );
    echo form_open('master/status_kerja_dosen/search/') .
    form_input($kode_status_kerja_dosen_attr) . ' ' .
    form_input($status_kerja_dosen_attr) . ' ' .
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

<table class="table table-bordered table-striped container-full data_list" id="status_kerja_dosen" controller="master">
    <thead>
        <tr>
            <th>Kode Status Kerja Dosen</th>
            <th>Status Kerja Dosen</th>
        </tr>
    </thead>
    <tbody>
        <?php
        foreach ($results->result() as $row) {
            echo '<tr id="' . $row->id . '">
              <td>' . $row->kode_status_kerja_dosen . '</td>
              <td>' . $row->status_kerja_dosen . '</td>    
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