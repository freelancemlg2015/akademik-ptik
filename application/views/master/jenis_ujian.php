<?php
$this->load->view('_shared/header');
$this->load->view('_shared/menus');
?>

<div class="container-fluid form-inline well" id="jenis_ujian-search">
    <?php
    $kode_ujian_attr = array(
        'id' => 'kode_ujian',
        'name' => 'kode_ujian',
        'class' => 'input-medium',
        'style' => 'text-transform : uppercase;',
        'placeholder' => 'Kode Ujian'
    );
    $jenis_ujian_attr = array(
        'id' => 'jenis_ujian',
        'name' => 'jenis_ujian',
        'class' => 'input-medium',
        'style' => 'text-transform : uppercase;',
        'placeholder' => 'Jenis Ujian'
    );
    echo form_open('master/jeni_ujian/search/') .
    form_input($kode_ujian_attr) . ' ' .
    form_input($jenis_ujian_attr) . ' ' .
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

<table class="table table-bordered table-striped container-full data_list" id="jenis_ujian" controller="master">
    <thead>
        <tr>
            <th>Kode Ujian</th>
            <th>Jenis Ujian</th>
        </tr>
    </thead>
    <tbody>
        <?php
        foreach ($results->result() as $row) {
            echo '<tr id="' . $row->id . '">
              <td>' . $row->kode_ujian . '</td>
              <td>' . $row->jenis_ujian . '</td>    
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