<?php
$this->load->view('_shared/header');
$this->load->view('_shared/menus');
?>

<div class="container-fluid form-inline well" id="bobot_nilai-search">
    <?php
    $kode_bobot_nilai_attr = array(
        'id' => 'kode_bobot_nilai',
        'name' => 'kode_bobot_nilai',
        'class' => 'input-medium',
        'style' => 'text-transform : uppercase;',
        'placeholder' => 'Kode Bobot Nilai'
    );
    $keterangan_nilai_attr = array(
        'id' => 'keterangan_nilai',
        'name' => 'keterangan_nilai',
        'class' => 'input-medium',
        'style' => 'text-transform : uppercase;',
        'placeholder' => 'Keterangan Nilai'
    );
    echo form_open('master/bobot_nilai/search/') .
    form_input($kode_bobot_nilai_attr) . ' ' .
    form_input($keterangan_nilai_attr) . ' ' .
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

<table class="table table-bordered table-striped container-full data_list" id="bobot_nilai" controller="master">
    <thead>
        <tr>
            <th>Kode Bobot Nilai</th>
            <th>Keterangan Nilai</th>
        </tr>
    </thead>
    <tbody>
        <?php
        foreach ($results->result() as $row) {
            echo '<tr id="' . $row->id . '">
              <td>' . $row->kode_bobot_nilai . '</td>
              <td>' . $row->keterangan_nilai . '</td>    
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