<?php
$this->load->view('_shared/header');
$this->load->view('_shared/menus');
?>

<div class="container-fluid form-inline well" id="mata_kuliah-search">
    <?php
    $kode_mata_kuliah_attr = array(
        'id' => 'kode_mata_kuliah',
        'name' => 'kode_mata_kuliah',
        'class' => 'input-medium',
        'style' => 'text-transform : uppercase;',
        'placeholder' => 'Kode Mata Kuliah'
    );
    $nama_mata_kuliah_attr = array(
        'id' => 'nama_mata_kuliah',
        'name' => 'nama_mata_kuliah',
        'class' => 'input-medium',
        'style' => 'text-transform : uppercase;',
        'placeholder' => 'Nama Mata Kuliah'
    );
    echo form_open('master/mata_kuliah/search/') .
    form_input($kode_mata_kuliah_attr) . ' ' .
    form_input($nama_mata_kuliah_attr) . ' ' .
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

<table class="table table-bordered table-striped container-full data_list" id="mata_kuliah" controller="master">
    <thead>
        <tr>
            <th>Angkatan</th>
            <th>Program Studi</th>
            <th>Jenjang Studi</th>
            <th>Tahun Ajar</th>
            <th>Kode Mata Kuliah</th>
            <th>Nama Mata Kuliah</th>
            <th>english</th>
            <th>Sks Mata Kuliah</th>
            <th>Sks Tatap Muka</th>
            <th>Sks Praktikum</th>
            <th>Nama Laboratorium</th>   
            <th>Sks Praktek Lapangan</th>
            <th>Semester</th>
            <th>Kelompok Mata Kuliah</th>
            <th>Jenis Kurikulum</th>
            <th>Jenis Mata Kuliah</th>
            <th>Jenis Program Studi Pengampu</th>
            <th>Program Studi Pengampu</th>
            <th>Status Mata Kuliah</th>
            <th>Mata Kuliah Syarat Tempuh</th>
            <th>Mata Kuliah Syarat Lulus</th>
            <th>Silabus</th>
        </tr>
    </thead>
    <tbody>
        <?php
        foreach ($results->result() as $row) {
            echo '<tr id="' . $row->id . '">
              <td>' . $row->nama_angkatan . '</td>
              <td>' . $row->nama_program_studi . '</td>
              <td>' . $row->jenjang_studi . '</td>
              <td>' . $row->tahun_ajar . '</td>
              <td>' . $row->kode_mata_kuliah . '</td>
              <td>' . $row->nama_mata_kuliah . '</td>
              <td>' . $row->english . '</td>
              <td>' . $row->sks_mata_kuliah . '</td>
              <td>' . $row->sks_tatap_muka . '</td>
              <td>' . $row->nama_laboratorium . '</td>
              <td>' . $row->sks_praktek_lapangan . '</td>
              <td>' . $row->semester . '</td>
              <td>' . $row->kelompok_mata_kuliah_id . '</td>    
              <td>' . $row->jenis_kurikulum . '</td>  
              <td>' . $row->jenis_mata_kuliah . '</td>  
              <td>' . $row->jenjang_program_studi_pengampu . '</td>  
              <td>' . $row->program_studi_pengampu . '</td>  
              <td>' . $row->status_mata_kuliah . '</td>    
              <td>' . $row->mata_kuliah_syarat_tempuh . '</td>
              <td>' . $row->mata_kuliah_syarat_lulus . '</td>  
              <td>' . $row->silabus . '</td>     
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