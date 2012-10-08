<?php
$this->load->view('_shared/header');
$this->load->view('_shared/menus');
?>

<div class="container-fluid form-inline well" id="options-search">
    <?php
    $option_attr = array(
        'id' => 'option',
        'name' => 'option',
        'class' => 'input-medium',
        'style' => 'text-transform : uppercase;',
        'placeholder' => 'option'
    );
   
    
    echo form_open('admin/options/search/') .
    form_input($option_attr) . ' ' .
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

<table class="table table-bordered table-striped container-full data_list"  controller="admin"  id="options">
    <thead>
        <tr>
            <th>Option</th>
            <th>Value</th>
            <th>Description</th>
        </tr>
    </thead>
    <tbody>
        <?php
        foreach ($results->result() as $row) {
            echo  '<tr id="' . $row->id . '">
              <td>' . $row->option . '</td>
              <td>' . $row->option_value . '</td>
              <td>' . $row->description . '</td>        
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