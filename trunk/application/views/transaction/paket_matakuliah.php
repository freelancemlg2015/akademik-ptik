<?php
$this->load->view('_shared/header');
$this->load->view('_shared/menus');
?>

<div class="container-fluid form-inline well" id="paket_matakuliah-search">
    <?php
    $nama_angkatan_attr = array(
        'id' => 'nama_angkatan',
        'name' => 'nama_angkatan',
        'class' => 'input-medium',
        'style' => 'text-transform : uppercase;',
        'placeholder' => 'Angkatan'
    );
    $nama_paket_attr = array(
        'id' => 'nama_paket',
        'name' => 'nama_paket',
        'class' => 'input-medium',
        'style' => 'text-transform : uppercase;',
        'placeholder' => 'Paket'
    );
    echo form_open('transaction/paket_matakuliah/search/') .
    form_input($nama_angkatan_attr) . ' ' .
    form_input($nama_paket_attr) . ' ' .
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

<table class="table table-bordered table-striped container-full data_list" id="paket_matakuliah" controller="transaction">
    <thead>
        <tr>
            <th>Angkatan</th>
            <th>Tahun Akademik</th>
            <th>Semester</th>
            <th>Paket</th>
            <th>Mata Kuliah</th>
        </tr>
    </thead>
    <tbody>
        <?php
        foreach ($results->result() as $row) {
            $tahun = $row->tahun_ajar_mulai.$row->tahun_ajar_akhir;
            if(strrpos($tahun,'-')<1)$tahun = $row->tahun_ajar_mulai.'-'.$row->tahun_ajar_akhir;
            echo '<tr id="' . $row->id . '">
              <td>' . $row->nama_angkatan . '</td>
              <td>' . $tahun . '</td>    
              <td>' . $row->nama_semester . '</td>    
              <td>' . $row->nama_paket . '</td>    
              <td>' . $row->nama_mata_kuliah . '</td>    
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