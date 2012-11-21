<?php
$this->load->view('_shared/header');
$this->load->view('_shared/menus');
?>

<div class="container-fluid form-inline well" id="pengajuan_skripsi-search">
    <?php
    $nim_attr = array(
        'id'    => 'nim',
        'name'  => 'nim',
        'class' => 'input-medium',
        'style' => 'text-transform : uppercase;',
        'placeholder' => 'Nim'
    );
    $nama_attr = array(
        'id'    => 'nama',
        'name'  => 'nama',
        'class' => 'input-medium',
        'style' => 'text-transform : uppercase;',
        'placeholder' => 'Nama'
    );
    echo form_open('transaction/pengajuan_skripsi/search/') .
    form_input($nim_attr) . ' ' .
    form_input($nama_attr) . ' ' .
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

<table class="table table-bordered table-striped container-full data_list" id="pengajuan_skripsi" controller="transaction">
    <thead>
        <tr>
            <th>Angkatan</th>
            <th>Tahun Akademik</th>
            <th>Nim</th>
            <th>Nama Mahasiswa</th>
            <th>Program Studi</th>
        </tr>
    </thead>
    <tbody>
        <?php
        foreach ($results->result() as $row) {
            $tahun = $row->tahun_ajar_mulai.$row->tahun_ajar_akhir;
            if(!empty($tahun)){
                $tahun = $row->tahun_ajar_mulai.'-'.$row->tahun_ajar_akhir;
            }
            echo '<tr id="' . $row->id . '">
              <td>' . $row->nama_angkatan . '</td>
              <td>' . $tahun. '</td>
              <td>' . $row->nim . '</td>    
              <td>' . $row->nama. '</td>
              <td>' . $row->nama_program_studi. '</td>  
            </tr>';
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