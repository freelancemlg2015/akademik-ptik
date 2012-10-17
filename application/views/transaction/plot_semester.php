<?php
$this->load->view('_shared/header');
$this->load->view('_shared/menus');
?>

<div class="container-fluid form-inline well" id="plot_semester-search">
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
    echo form_open('transaction/plot_semester/search/') .
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

<table class="table table-bordered table-striped container-full data_list" id="plot_semester" controller="transaction">
    <thead>
        <tr>
            <th>Angkatan</th>
            <th>Tahun Akademik</th>
            <th>Semester</th>
            <th>Tanggal Mulai</th>
            <th>Tanggal Akhir</th>
        </tr>
    </thead>
    <tbody>
        <?php
        foreach ($results->result() as $row) {
            echo '<tr id="' . $row->id . '">
              <td>' . $row->angkatan_id . '</td>
              <td>' . $row->no_dosen_fakultas . '</td>
              <td>' . $row->nama_dosen . '</td>
              <td>' . $row->tgl_lahir . '</td>
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