<?php
$this->load->view('_shared/header');
$this->load->view('_shared/menus');
?>

<div class="container-fluid form-inline well" id="dosen-search">
    <?php
    $no_karpeg_dosen_attr = array(
        'id' => 'no_karpeg_dosen',
        'name' => 'no_karpeg_dosen',
        'class' => 'input-medium',
        'style' => 'text-transform : uppercase;',
        'placeholder' => 'No Karpeg Dosen'
    );
    $nama_dosen_attr = array(
        'id' => 'nama_dosen',
        'name' => 'nama_dosen',
        'class' => 'input-medium',
        'style' => 'text-transform : uppercase;',
        'placeholder' => 'Nama Dosen'
    );
    echo form_open('master/dosen/search/') .
    form_input($no_karpeg_dosen_attr) . ' ' .
    form_input($nama_dosen_attr) . ' ' .
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

<table class="table table-bordered table-striped container-full data_list" id="dosen" controller="master">
    <thead>
        <tr>
            <th>No Karpeg Dosen</th>
            <th>No Dosen Fakultas</th>
            <th>No Dosen Dikti</th>
            <th>Nama Dosen</th>
            <th>Gelar Depan</th>
            <th>Gelar Belakang</th>
            <th>Tempat Lahir</th>
            <th>Tanggal Lahir</th>
        </tr>
    </thead>
    <tbody>
        <?php
        foreach ($results->result() as $row) {
            echo '<tr id="' . $row->id . '">
              <td>' . $row->no_karpeg_dosen . '</td>
              <td>' . $row->no_dosen_fakultas . '</td>
              <td>' . $row->no_dosen_dikti . '</td>
              <td>' . $row->nama_dosen . '</td>
              <td>' . $row->gelar_depan . '</td>
              <td>' . $row->gelar_belakang . '</td>
              <td>' . $row->tempat_lahir . '</td>
              <td>' . $row->tgl_lahir . '</td>     
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