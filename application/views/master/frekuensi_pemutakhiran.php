<?php
$this->load->view('_shared/header');
$this->load->view('_shared/menus');
?>

<div class="container-fluid form-inline well" id="frekuensi_pemutakhiran-search">
    <?php
    $frekuensi_pemutahiran_kurikulum_attr = array(
        'id' => 'frekuensi_pemutahiran_kurikulum',
        'name' => 'frekuensi_pemutahiran_kurikulum',
        'class' => 'input-medium',
        'style' => 'text-transform : uppercase;',
        'placeholder' => 'Frekuensi Pemutahiran Kurikulum'
    );
    echo form_open('master/frekuensi_pemutakhiran/search/') .
    form_input($frekuensi_pemutahiran_kurikulum_attr) . ' ' .
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

<table class="table table-bordered table-striped container-full data_list" id="frekuensi_pemutakhiran" controller="master">
    <thead>
        <tr>
            <th>Frekuensi Pemutakhiran Kurikulum</th>
        </tr>
    </thead>
    <tbody>
        <?php
        foreach ($results->result() as $row) {
            echo '<tr id="' . $row->id . '">
              <td>' . $row->frekuensi_pemutahiran_kurikulum . '</td>    
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