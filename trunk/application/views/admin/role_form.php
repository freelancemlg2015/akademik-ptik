<?php
$this->load->view('_shared/header');
$this->load->view('_shared/menus');
?>
<div class="container" id="roles" >
    
    <?php echo form_open($action_url); ?>
    
    <?php
    // role
    $this->table->add_row(array(
        form_label(required() . 'Role', 'role') . form_error('role'),
        form_input(array(
            'id' => 'role',
            'name' => 'role',
            'class' => 'field',
            'maxlength' => 50,
            'value' => set_value('role', $role)
                )
        )
    ));

    // description
    $this->table->add_row(array(
        form_label('Description', 'description') . form_error('description'),
        form_input(array(
            'id' => 'description',
            'name' => 'description',
            'class' => 'field',
            'maxlength' => 50,
            'value' => set_value('description', $description)
                )
        )
    ));

    // capabilities
    $capabilities_html = '<table class="table table-bordered" id="role_capabilities">
    <thead>
        <tr>
            <th>' . form_checkbox(array(
                'name' => 'capability_all',
                'class' => 'check_all',
                'checked' => FALSE
            )) . '</th>
            <th>Capability</th>
            <th>Description</th>
        </tr>
    </thead><tbody>';

    //if(!isset($capabilities_id))$capabilities_id = '';
    foreach ($capabilities_option->result() as $capability) {
        $capabilities_data = array(
            'name' => 'capability[]',
            'value' => $capability->id,
            'checked' => ( in_array($capability->id, explode(',', $capabilities_id))) ? 'checked' : ''
        );
        $capabilities_html .= '<tr><td>' . form_checkbox($capabilities_data) . '</td><td>' . $capability->capability . '</td><td>' . $capability->description . '</td></tr>';
    }
    $capabilities_html .= '</body></table>';
    $this->table->add_row(array(
        form_label(required() . 'Capabilities', 'capability') . form_error('capability'),
        $capabilities_html
            )
    );

    echo $this->table->generate();
    ?>
    <?php echo form_submit('Save', 'save', 'class="btn primary"') ?>

    <?php form_close() ?>
</div>
<?php $this->load->view('_shared/footer'); ?>