<?php
$this->load->view('_shared/header');
$this->load->view('_shared/menus');
?>

<div class="container-fluid form-inline well" id="nilai-search">
    <?php
    $kode_nilai_attr = array(
        'id' => 'kode_nilai',
        'name' => 'kode_nilai',
        'class' => 'input-medium',
        'style' => 'text-transform : uppercase;',
        'placeholder' => 'Kode Nilai'
    );
    $nilai_attr = array(
        'id' => 'nilai',
        'name' => 'nilai',
        'class' => 'input-medium',
        'style' => 'text-transform : uppercase;',
        'placeholder' => 'Nilai'
    );
    echo form_open('master/nilai/search/') .
    form_input($kode_nilai_attr) . ' ' .
    form_input($nilai_attr) . ' ' .
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

<table class="table table-bordered table-striped container-full data_list" id="nilai" controller="master">
    <thead>
        <tr>
            <th>Kode Nilai</th>
            <th>Nilai</th>
        </tr>
    </thead>
    <tbody>
        <?php
        foreach ($results->result() as $row) {
            echo '<tr id="' . $row->id . '">
              <td>' . $row->kode_nilai . '</td>
              <td>' . $row->nilai . '</td>    
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