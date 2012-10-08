<?php
$this->load->view('_shared/header');
$this->load->view('_shared/menus');
?>

<div class="container-fluid form-inline well" id="pelaksana_pemutahiran-search">
    <?php
    $pelaksana_pemutahiran_attr = array(
        'id' => 'pelaksana_pemutahiran',
        'name' => 'pelaksana_pemutahiran',
        'class' => 'input-medium',
        'style' => 'text-transform : uppercase;',
        'placeholder' => 'Pelaksana Pemutahiran'
    );
    echo form_open('master/pelaksana_pemutakhiran/search/') .
    form_input($pelaksana_pemutahiran_attr) . ' ' .
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

<table class="table table-bordered table-striped container-full data_list" id="pelaksana_pemutakhiran" controller="master">
    <thead>
        <tr>
            <th>Pelaksana Pemutakhiran</th>
        </tr>
    </thead>
    <tbody>
        <?php
        foreach ($results->result() as $row) {
            echo '<tr id="' . $row->id . '">
              <td>' . $row->pelaksana_pemutahiran . '</td>    
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