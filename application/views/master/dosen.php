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
            <th>Nama Dosen</th>
            <th>Tempat Lahir</th>
            <th>Tanggal Lahir</th>
        </tr>
    </thead>
    <tbody>
        <?php
        foreach ($results->result() as $row) {
            $nama = $row->gelar_depan.$row->nama_dosen.$row->gelar_belakang;
            if(strrpos($nama,'. ')<1) $nama = $row->gelar_depan.' '. $row->nama_dosen.' '. $row->gelar_belakang;
            echo '<tr id="' . $row->id . '">
              <td>' . $row->no_karpeg_dosen . '</td>
              <td>' . $row->no_dosen_fakultas . '</td>
              <td>' . $nama . '</td>
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