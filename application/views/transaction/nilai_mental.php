<?php
$this->load->view('_shared/header');
$this->load->view('_shared/menus');
?>

<div class="container-fluid form-inline well" id="nilai_mental-search">
    <?php
    $nim_attr = array(
        'id' => 'nim',
        'name' => 'nim',
        'class' => 'input-medium',
        'style' => 'text-transform : uppercase;',
        'placeholder' => 'Nim'
    );
    $nilai_mental_attr = array(
        'id' => 'nilai_mental',
        'name' => 'nilai_mental',
        'class' => 'input-medium',
        'style' => 'text-transform : uppercase;',
        'placeholder' => 'Nilai Mental'
    );
    echo form_open('transaction/nilai_mental/search/') .
    form_input($nim_attr) . ' ' .
    form_input($nilai_mental_attr) . ' ' .
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

<table class="table table-bordered table-striped container-full data_list" id="nilai_mental" controller="transaction">
    <thead>
        <tr>
            <th>Nim</th>
            <th>Nilai Mental</th>
        </tr>
    </thead>
    <tbody>
        <?php
        foreach ($results->result() as $row) {
            echo '<tr id="' . $row->id . '">
              <td>' . $row->nim . '</td>
              <td>' . $row->nilai_mental . '</td>    
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