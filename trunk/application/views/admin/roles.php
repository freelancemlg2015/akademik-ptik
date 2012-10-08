<?php
$this->load->view('_shared/header');
$this->load->view('_shared/menus');
?>

<div class="container-fluid form-inline well" id="roles-search">
    <?php
    $role_attr = array(
        'id' => 'role',
        'name' => 'role',
        'class' => 'input-medium',
        'style' => 'text-transform : uppercase;',
        'placeholder' => 'role'
    );


    echo form_open('admin/roles/search/') .
    form_input($role_attr) . ' ' .
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

<table class="table table-bordered table-striped container-full data_list" controller="admin"  id="roles">
    <thead>
        <tr>
            <th>Role</th>
            <th>Description</th>
            <th>Capabilities</th>
        </tr>
    </thead>
    <tbody>
        <?php
        foreach ($results->result() as $row) {
            echo '<tr id="' . $row->id . '">
              <td>' . $row->role . '</td>
              <td>' . $row->description . '</td>      
              <td>' . $row->capabilities_id . '</td> 
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