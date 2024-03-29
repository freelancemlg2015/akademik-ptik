<?php
$this->load->view('_shared/header');
$this->load->view('_shared/menus');
?>

<div class="container-fluid form-inline well" id="nilai_skripsi-search">
    <?php
    $nama_attr = array(
        'id' => 'nama_angkatan',
        'name' => 'nama_angkatan',
        'class' => 'input-medium',
        'style' => 'text-transform : uppercase;',
        'placeholder' => 'Nama Angkatan'
    );
    $judul_skripsi_attr = array(
        'id' => 'nama',
        'name' => 'nama',
        'class' => 'input-medium',
        'style' => 'text-transform : uppercase;',
        'placeholder' => 'Nama'
    );
    echo form_open('transaction/nilai_skripsi/search/') .
    form_input($nama_attr) . ' ' .
    form_input($judul_skripsi_attr) . ' ' .
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

<table class="table table-bordered table-striped container-full data_list" id="nilai_skripsi" controller="transaction">
    <thead>
        <tr>
            <th>Angkatan</th>
            <th>Tahun</th>
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
              <td>' . $tahun . '</td>    
              <td>' . $row->nim . '</td>  
              <td>' . $row->nama . '</td>     
              <td>' . $row->nama_program_studi . '</td>    
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