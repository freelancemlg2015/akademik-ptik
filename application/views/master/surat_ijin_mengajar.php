<?php
$this->load->view('_shared/header');
$this->load->view('_shared/menus');
?>

<div class="container-fluid form-inline well" id="surat_ijin_mengajar-search">
    <?php
    $surat_ijin_mengajar_attr = array(
        'id' => 'surat_ijin_mengajar',
        'name' => 'surat_ijin_mengajar',
        'class' => 'input-medium',
        'style' => 'text-transform : uppercase;',
        'placeholder' => 'Surat Ijin Mengajar'
    );
    echo form_open('master/surat_ijin_mengajar/search/') .
    form_input($surat_ijin_mengajar_attr) . ' ' .
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

<table class="table table-bordered table-striped container-full data_list" id="surat_ijin_mengajar" controller="master">
    <thead>
        <tr>
            <th>Surat Ijin Mengajar</th>
        </tr>
    </thead>
    <tbody>
        <?php
        foreach ($results->result() as $row) {
            echo '<tr id="' . $row->id . '">
              <td>' . $row->surat_ijin_mengajar . '</td>
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