<?php
$this->load->view('_shared/header');
$this->load->view('_shared/menus');
?>


<div class="container-fluid well" id="user-search">
    <?php echo form_open('admin/users/search/'); ?>
    <?php
    $this->table->add_row(array(
        form_label('Username', 'user') . form_error('user'),
        form_input(array(
            'id' => 'user',
            'name' => 'user',
            'class' => 'span2',
            'style' =>'text-transform : uppercase;'
                )
        )
    ));
    
    echo $this->table->generate();
    echo '<div class="form-actions">'.form_submit('filter', 'Filter', 'class="btn small pull-right"').'</div>';
    echo form_close();
    ?>
</div>

<div class="container">
    <div class="pagination">
        <?php echo $pagination; ?>
    </div>
</div>

<table class="table table-bordered table-striped container-full data_list" id="users" controller="admin">
    <thead>
        <tr>
            <th>Username</th>
            <th>Display Name</th>
            <th>Fullname</th>
            <th>Email</th>
            <th>Telephone</th>
            <th>As</th>
            <th>Registered Date</th>
        </tr>
    </thead>
    <tbody>
        <?php
        foreach ($results->result() as $row) {
            echo '<tr id="'.$row->id.'">
              <td>' . $row->username . '</td>
              <td>' . $row->display_name . '</td>
              <td>' . $row->fullname . '</td>
              <td>' . $row->email . '</td>
              <td>' . $row->telephone . '</td>
              <td>' . $row->role . '</td>
              <td>' . $row->created_on . '</td>         
            </tr>
          ';
        }
        ?>
    </tbody>
</table>

<div class="container">
    <div class="pagination">
        <?php echo $pagination; ?>
    </div>
</div>


<?php $this->load->view('_shared/footer'); ?>