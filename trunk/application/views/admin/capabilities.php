<?php
$this->load->view('_shared/header');
$this->load->view('_shared/menus');
?>

<div class="container-fluid form-inline well" id="capabilities-search">
    <?php
    $capability_attr = array(
        'id' => 'capability',
        'name' => 'capability',
        'class' => 'input-medium',
        'style' => 'text-transform : uppercase;',
        'placeholder' => 'Capability'
    );
   
    
    echo form_open('admin/capabilities/search/') .
    form_input($capability_attr) . ' ' .
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

<table class="table table-bordered table-striped container-full data_list"  id="capabilities" controller="admin">
    <thead>
        <tr>
            <th>Capability</th>
            <th>Description</th>
        </tr>
    </thead>
    <tbody>
        <?php
        foreach ($results->result() as $row) {
             echo '<tr id="'.$row->id.'">
              <td>' . $row->capability . '</td>
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