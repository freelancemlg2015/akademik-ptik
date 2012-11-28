<?php
$this->load->view('_shared/header');
$this->load->view('_shared/menus');
?>

<div class="container-fluid form-inline well" id="ujian_skripsi-search">
    <?php
    $nama_attr = array(
        'id' => 'nama',
        'name' => 'nama',
        'class' => 'input-medium',
        'style' => 'text-transform : uppercase;',
        'placeholder' => 'Nama'
    );
    $judul_skripsi_attr = array(
        'id' => 'judul_skripsi',
        'name' => 'judul_skripsi',
        'class' => 'input-medium',
        'style' => 'text-transform : uppercase;',
        'placeholder' => 'Judul Skripsi'
    );
    echo form_open('transaction/ujian_skripsi/search/') .
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

<table class="table table-bordered table-striped container-full data_list" id="ujian_skripsi" controller="transaction">
    <thead>
        <tr>
            <th>Mahasiswa</th>
            <th>Judul Skripsi</th>
            <th>Tanggal Ujian</th>
            <th>Jam</th>
            <th>Ketua Penguji</th>
            <th>Sekretaris Penguji</th>
        </tr>
    </thead>
    <tbody>
        <?php
        foreach ($results->result() as $row) {
            $jam = $row->jam_mulai.$row->jam_akhir;
            if(empty($jam)){
                
            }else{
               $jam = substr($row->jam_mulai,0,5).'-'.substr($row->jam_akhir, 0,5); 
            }
            echo '<tr id="' . $row->id . '">
              <td>' . $row->nama . '</td>
              <td>' . $row->judul_skripsi . '</td>    
              <td>' . $row->tgl_ujian . '</td>   
              <td>' . $jam . '</td>   
              <td>' . $row->nama_ketua_penguji . '</td>     
              <td>' . $row->nama_sekretaris . '</td>    
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