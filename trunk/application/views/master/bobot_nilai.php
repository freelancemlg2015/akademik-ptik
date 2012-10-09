<?php
$this->load->view('_shared/header');
$this->load->view('_shared/menus');
?>

<div class="container-fluid form-inline well" id="bobot_nilai-search">
    <?php
    $nilai_angka_attr = array(
        'id' => 'nilai_angka',
        'name' => 'nilai_angka',
        'class' => 'input-medium',
        'style' => 'text-transform : uppercase;',
        'placeholder' => 'Nilai Angka'
    );
    $nilai_huruf_attr = array(
        'id' => 'nilai_huruf',
        'name' => 'nilai_huruf',
        'class' => 'input-medium',
        'style' => 'text-transform : uppercase;',
        'placeholder' => 'Nilai Huruf'
    );
    echo form_open('master/bobot_nilai/search/') .
    form_input($nilai_angka_attr) . ' ' .
    form_input($nilai_huruf_attr) . ' ' .
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
            <th>Nilai Angka</th>
            <th>Nilai Huruf</th>
            <th>Bobot Nilai Huruf</th>
        </tr>
    </thead>
    <tbody>
        <?php
        foreach ($results->result() as $row) {
            echo '<tr id="' . $row->id . '">
              <td>' . $row->nilai_angka . '</td>
              <td>' . $row->nilai_huruf . '</td>    
              <td>' . $row->bobot_nilai_huruf . '</td>    
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