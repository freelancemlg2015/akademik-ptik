<?php
$this->load->view('_shared/header');
$this->load->view('_shared/menus');
?>

<div class="container-fluid form-inline well" id="data_mahasiwa-search">
    <?php
    $nim_attr = array(
        'id' => 'nim',
        'name' => 'nim',
        'class' => 'input-medium',
        'style' => 'text-transform : uppercase;',
        'placeholder' => 'Nim'
    );
    $nama_attr = array(
        'id' => 'nama',
        'name' => 'nama',
        'class' => 'input-medium',
        'style' => 'text-transform : uppercase;',
        'placeholder' => 'Nama'
    );
    echo form_open('master/data_mahasiswa/search/') .
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

<table class="table table-bordered table-striped container-full data_list" id="data_mahasiswa" controller="master">
    <thead>
        <tr>
            <th>Nim</th>
            <th>Nama</th>
            <th>Angkatan</th>
            <th>Jenjang Studi</th>
            <th>Konsentrasi Studi</th>
            <th>Tempat Lahir</th>
            <th>Tanggal Lahir</th>
            <th>Jenis Kelamin</th>
            <th>Agama</th>
            <th>Status Aktifitas Mahasiswa</th>
            <th>Jumlah SKS</th>
            <th>Perguruan Tinggi</th>
            <th>Jurusan</th>
            <th>Judicium</th>
            <th>Dosen Penasehat</th>
            <th>Propinsi SLTA</th>
            <th>Kota SLTA</th>
            <th>Nama SLTA</th>
            <th>Jurusan SLTA</th>
            <th>Alamat</th>
            <th>Telepon</th>
            <th>Hobby</th>
            <th>Foto</th>
            <th>Jabatan Tertinggi</th>
            <th>Pangkat</th>
            <th>NRP</th>
            <th>Dik Abri</th>
            <th>Tahun Dik Abri</th>
            <th>Nama Ayah</th>
            <th>Pekarjaan Ayah</th>
            <th>Tanggal Lahir Ayah</th>
            <th>Agama</th>
            <th>Pendidikan Ayah</th>
            <th>Alamat</th>
            <th>No Telepon</th>
            <th>Nama Wali</th>
            <th>Pekerjaan Wali</th>
            <th>Tanggl Lahir Wali</th>
            <th>Agama</th>
            <th>Pendidikan Wali</th>
            <th>Alamat Wali</th>
        </tr>
    </thead>
    <tbody>
        <?php
        foreach ($results->result() as $row) {
            echo '<tr id="' . $row->id . '">
              <td>' . $row->nim . '</td>
              <td>' . $row->nama_ruang . '</td>
              <td>' . $row->nama_angkatan. '</td>
              <td>' . $row->nama_program_studi . '</td>
              <td>' . $row->jenjang_studi . '</td>
              <td>' . $row->nama_konsentrasi_studi . '</td>
              <td>' . $row->tempat_lahir . '</td>
              <td>' . $row->tgl_lahir . '</td>
              <td>' . $row->jenis_kelamin . '</td>
              <td>' . $row->agama . '</td>
              <td>' . $row->status_aktifitas_mhs . '</td>
              <td>' . $row->jml_sks_diakui . '</td>
              <td>' . $row->perguruan_tinggi_sebelumny . '</td>
              <td>' . $row->jurusan_seblumnya  . '</td>
              <td>' . $row->judicium . '</td>
              <td>' . $row->status_dosen_penasehat . '</td>
              <td>' . $row->propinsi_asal_slta . '</td>
              <td>' . $row->kota_asal_slta . '</td>
              <td>' . $row->nama_slta . '</td>
              <td>' . $row->jurusan_slta . '</td>
              <td>' . $row->alamat . '</td>
              <td>' . $row->telepon . '</td>
              <td>' . $row->hobby . '</td>
              <td>' . $row->foto . '</td>
              <td>' . $row->jabatan_tertinggi . '</td>
              <td>' . $row->nama_kesatuan_asal . '</td>
              <td>' . $row->nama_pangkat . '</td>
              <td>' . $row->nrp . '</td>
              <td>' . $row->dik_abri . '</td>
              <td>' . $row->thn_dik_abri . '</td>
              <td>' . $row->nama_ayah . '</td>
              <td>' . $row->pekerjaan_ayah . '</td>
              <td>' . $row->tgl_lahir_ayah . '</td>
              <td>' . $row->agama_ayah_id . '</td>
              <td>' . $row->pendidikan_ayah . '</td>
              <td>' . $row->alamat_ayah . '</td>
              <td>' . $row->no_telepon . '</td>
              <td>' . $row->nama_wali . '</td>
              <td>' . $row->pekerjaan_wali . '</td>
              <td>' . $row->tgl_lahir_wali . '</td>
              <td>' . $row->agama_wali_id . '</td>
              <td>' . $row->pendidikan_wali . '</td>
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