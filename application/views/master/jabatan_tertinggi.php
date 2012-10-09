<?php
$this->load->view('_shared/header');
$this->load->view('_shared/menus');
?>

<div class="container-fluid form-inline well" id="jabatan_tertinggi-search">
    <?php
    $kode_jabatan_tertinggi_attr = array(
        'id' => 'kode_jabatan_tertinggi',
        'name' => 'kode_jabatan_tertinggi',
        'class' => 'input-medium',
        'style' => 'text-transform : uppercase;',
        'placeholder' => 'Kode Jabatan Tertinggi'
    );
    $jabatan_tertinggi_attr = array(
        'id' => 'jabatan_tertinggi',
        'name' => 'jabatan_tertinggi',
        'class' => 'input-medium',
        'style' => 'text-transform : uppercase;',
        'placeholder' => 'Jabatan Tertinggi'
    );
    echo form_open('master/jabatan_tertinggi/search/') .
    form_input($kode_jabatan_tertinggi_attr) . ' ' .
    form_input($jabatan_tertinggi_attr) . ' ' .
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

<table class="table table-bordered table-striped container-full data_list" id="jabatan_tertinggi" controller="master">
    <thead>
        <tr>
            <th>Kode Jabatan Tertinggi</th>
            <th>Jabatan Tertinggi</th>
        <!--<th>Status Akreditasi</th>-->
        </tr>
    </thead>
    <tbody>
        <?php
        foreach ($results->result() as $row) {
            echo '<tr id="' . $row->id . '">
              <td>' . $row->kode_jabatan_tertinggi . '</td>
              <td>' . $row->jabatan_tertinggi . '</td>
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