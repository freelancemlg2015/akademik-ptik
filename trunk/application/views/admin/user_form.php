<?php
$this->load->view('_shared/header');
$this->load->view('_shared/menus');

$role_options = array();
$role_options[0] = '-ROLE-';
foreach ($roles->result() as $role_m) {
    $role_options[$role_m->id] = $role_m->role;
}

$control_label = array('class' => 'control-label');
?>


<?php echo form_open($action_url, array('class' => 'form-horizontal')); ?>

<div class="container no-enter" id="users">

    <div class="control-group" >
        <?php echo form_label('Username' . required(), 'username', $control_label); ?>
        <div class="controls">
            <?php
            echo form_input(array(
                'id' => 'username',
                'name' => 'username',
                'class' => 'span2',
                'value' => set_value('username', $username)
                    )
            )
            ?>
            <p class="help-block"><?php echo form_error('username') ?></p>
        </div>
    </div>

    <div class="control-group" >
        <?php echo form_label('Password' . required(), 'pass', $control_label); ?>
        <div class="controls">
            <?php
            echo form_input(array(
                'id' => 'pass',
                'name' => 'pass',
                'class' => 'span2',
                'value' => set_value('pass', $pass)
                    )
            )
            ?>
            <p class="help-block"><?php echo form_error('pass') ?></p>
        </div>
    </div>

    <div class="control-group" >
        <?php echo form_label('Display Name' . required(), 'display_name', $control_label); ?>
        <div class="controls">
            <?php
            echo form_input(array(
                'id' => 'display_name',
                'name' => 'display_name',
                'class' => 'span2',
                'value' => set_value('display_name', $display_name)
                    )
            )
            ?>
            <p class="help-block"><?php echo form_error('display_name') ?></p>
        </div>
    </div>

    <div class="control-group" >
        <?php echo form_label('Fullname' . required(), 'fullname', $control_label); ?>
        <div class="controls">
            <?php
            echo form_input(array(
                'id' => 'fullname',
                'name' => 'fullname',
                'class' => 'span2',
                'value' => set_value('fullname', $fullname)
                    )
            )
            ?>
            <p class="help-block"><?php echo form_error('fullname') ?></p>
        </div>
    </div>

    <div class="control-group" >
        <?php echo form_label('Email' . required(), 'email', $control_label); ?>
        <div class="controls">
            <?php
            echo form_input(array(
                'id' => 'email',
                'name' => 'email',
                'class' => 'span2',
                'value' => set_value('email', $email)
                    )
            )
            ?>
            <p class="help-block"><?php echo form_error('email') ?></p>
        </div>
    </div>

    <div class="control-group" >
        <?php echo form_label('Telephone' . required(), 'telephone', $control_label); ?>
        <div class="controls">
            <?php
            echo form_input(array(
                'id' => 'telephone',
                'name' => 'telephone',
                'class' => 'span2',
                'value' => set_value('telephone', $telephone)
                    )
            )
            ?>
            <p class="help-block"><?php echo form_error('telephone') ?></p>
        </div>
    </div>

    <div class="control-group" >
        <?php echo form_label('Role' . required(), 'role', $control_label); ?>
        <div class="controls">
            <?php
            echo form_dropdown('role', $role_options, set_value('role', $role))
            ?>
            <p class="help-block"><?php echo form_error('role') ?></p>
        </div>
    </div>

    <div class="form-actions">
        <button class="btn small btn-primary" type="submit">Simpan</button>
    </div>


</div>

<?php form_close() ?>

<?php $this->load->view('_shared/footer'); ?>