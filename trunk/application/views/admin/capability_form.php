<?php
$this->load->view('_shared/header');
$this->load->view('_shared/menus');
?>
<div class="container span7" id="capabilities">
    <?php echo form_open($action_url); ?>
    <?php
    // capability
    $this->table->add_row(array(
        form_label(required() . 'Capability', 'capability') . form_error('capability'),
        form_input(array(
            'id' => 'capability',
            'name' => 'capability',
            'class' => 'field',
            'value' => set_value('capability',$capability)
                )
        )
    ));
    // description
    $this->table->add_row(array(
        form_label('Description', 'description') . form_error('description'),
        form_textarea(array(
            'id' => 'description',
            'name' => 'description',
            'class' => 'field',
            'value' => set_value('description',$description)
                )
        )
    ));
    
    $this->table->add_row(array(
        '',form_submit('Save', 'save', 'class="btn primary pull-right"')
    ));

    echo $this->table->generate();
    ?>

    <?php form_close() ?>
</div>
<?php $this->load->view('_shared/footer'); ?>