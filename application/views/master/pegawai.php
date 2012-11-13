<?php
$this->load->view('_shared/header');
$this->load->view('_shared/menus');
?>

<div class="container-fluid form-inline well" id="pegawai-search">
    <?php
    $no_karpeg_pegawai_attr = array(
        'id' => 'no_karpeg_pegawai',
        'name' => 'no_karpeg_pegawai',
        'class' => 'input-medium',
        'style' => 'text-transform : uppercase;',
        'placeholder' => 'No Karpeg pegawai'
    );
    $nama_pegawai_attr = array(
        'id' => 'nama_pegawai',
        'name' => 'nama_pegawai',
        'class' => 'input-medium',
        'style' => 'text-transform : uppercase;',
        'placeholder' => 'Nama pegawai'
    );
    echo form_open('master/pegawai/search/') .
    form_input($no_karpeg_pegawai_attr) . ' ' .
    form_input($nama_pegawai_attr) . ' ' .
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

<table class="table table-bordered table-striped container-full data_list" id="pegawai" controller="master">
    <thead>
        <tr>
            <th>No Karpeg pegawai</th>
            <th>Nama pegawai</th>
            <th>Tempat Lahir</th>
            <th>Tanggal Lahir</th>
        </tr>
    </thead>
    <tbody>
        <?php
        foreach ($results->result() as $row) {
            $nama = $row->gelar_depan.$row->nama_pegawai.$row->gelar_belakang;
            if(strrpos($nama,'. ')<1) $nama = $row->gelar_depan.' '. $row->nama_pegawai.' '. $row->gelar_belakang;
            echo '<tr id="' . $row->id . '">
              <td>' . $row->no_karpeg_pegawai . '</td>
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