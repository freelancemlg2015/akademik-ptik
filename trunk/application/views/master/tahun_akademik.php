<?php
$this->load->view('_shared/header');
$this->load->view('_shared/menus');
?>

<div class="container-fluid form-inline well" id="tahun_akademik-search">
    <?php
    $kode_tahun_ajar_attr = array(
        'id' => 'kode_tahun_ajar',
        'name' => 'kode_tahun_ajar',
        'class' => 'input-medium',
        'style' => 'text-transform : uppercase;',
        'placeholder' => 'Kode Tahun Ajar'
    );
    $tahun_attr = array(
        'id' => 'tahun',
        'name' => 'tahun',
        'class' => 'input-medium',
        'style' => 'text-transform : uppercase;',
        'placeholder' => 'Tahun'
    );
    echo form_open('master/tahun_akademik/search/') .
    form_input($kode_tahun_ajar_attr) . ' ' .
    form_input($tahun_attr) . ' ' .
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

<table class="table table-bordered table-striped container-full data_list" id="tahun_akademik" controller="master">
    <thead>
        <tr>
            <th>Kode Tahun Ajar</th>
            <th>Tahun</th>
            <th>Tgl Mulai</th>
        </tr>
    </thead>
    <tbody>
        <?php
        foreach ($results->result() as $row) {
            echo '<tr id="' . $row->id . '">
              <td>' . $row->kode_tahun_ajar . '</td>
              <td>&nbsp;' . $row->tahun . '</td>        
              <td>' . $row->tgl_mulai . '</td>        
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