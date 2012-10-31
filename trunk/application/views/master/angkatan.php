<?php
$this->load->view('_shared/header');
$this->load->view('_shared/menus');
?>

<div class="container-fluid form-inline well" id="angkatan-search">
    <?php
    $kode_angkatan_attr = array(
        'id' => 'kode_angkatan',
        'name' => 'kode_angkatan',
        'class' => 'input-medium',
        'style' => 'text-transform : uppercase;',
        'placeholder' => 'Kode Angkatan'
    );
    $nama_angkatan_attr = array(
        'id' => 'nama_angkatan',
        'name' => 'nama_angkatan',
        'class' => 'input-medium',
        'style' => 'text-transform : uppercase;',
        'placeholder' => 'Nama Angkatan'
    );
    echo form_open('master/angkatan/search/') .
    form_input($kode_angkatan_attr) . ' ' .
    form_input($nama_angkatan_attr) . ' ' .
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

<table class="table table-bordered table-striped container-full data_list" id="angkatan" controller="master">
    <thead>
        <tr>
            <th>Kode Angkatan</th>
            <th>Nama Angkatan</th>
            <th>Tahun</th>
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
              <td>' . $row->kode_angkatan . '</td>
              <td>' . $row->nama_angkatan . '</td>
              <td>' . $tahun . '</td>    
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