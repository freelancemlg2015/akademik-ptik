<?php
$this->load->view('_shared/header');
$this->load->view('_shared/menus');
?>

<div class="container-fluid form-inline well" id="penasehat_akademik-search">
    <?php
    $kode_angkatan_attr = array(
        'id' => 'kode_angkatan',
        'name' => 'kode_angkatan',
        'class' => 'input-medium',
        'style' => 'text-transform : uppercase;',
        'placeholder' => 'Kode Angkatan'
    );
    $program_studi_attr = array(
        'id' => 'program_studi',
        'name' => 'program_studi',
        'class' => 'input-medium',
        'style' => 'text-transform : uppercase;',
        'placeholder' => 'Program Studi'
    );
    $penasehat_akademik_attr = array(
        'id' => 'penasehat_akademik',
        'name' => 'penasehat_akademik',
        'class' => 'input-medium',
        'style' => 'text-transform : uppercase;',
        'placeholder' => 'Penasehat Akademik'
    );
    $keterangan_attr = array(
        'id' => 'keterangan',
        'name' => 'keterangan',
        'class' => 'input-medium',
        'style' => 'text-transform : uppercase;',
        'placeholder' => 'Keterangan'
    );
    $jenjang_studi_data[0] = '-PILIH-';
    foreach ($jenjang_studi_options as $row) {
        $jenjang_studi_data[$row->id] = $row->jenjang_studi;
    }

    echo form_open('transaction/penasehat_akademik/search/') .
    form_input($kode_angkatan_attr) . ' ' .
    form_dropdown('jenjang_studi_id', $jenjang_studi_data, set_value('jenjang_studi_id', ''), 'id="jenjang_studi_id" class="input-medium" prevData-selected="' . set_value('jenjang_studi_id', '') . '"') . ' ' .
    form_input($program_studi_attr) . ' ' .
    form_input($penasehat_akademik_attr) . ' ' .
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

<table class="table table-bordered table-striped container-full data_list" id="penasehat_akademik" controller="transaction">
    <thead>
        <tr>
            <th>Kode Angkatan</th>
            <th>Jenjang Studi</th>
            <th>Program Studi</th>
            <th>Penasehat Akademik</th>
        </tr>
    </thead>
    <tbody>
        <?php
        foreach ($results->result() as $row) {
            echo '<tr id="' . $row->id . '">
              <td>' . $row->kode_angkatan . '</td>
                   <td>' . $row->jenjang_studi . '</td>
                        <td>' . $row->nama_program_studi . '</td>
                            <td>' . $row->penasehat_akademik . '</td>    
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