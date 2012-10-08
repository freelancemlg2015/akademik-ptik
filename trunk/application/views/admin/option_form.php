<?php
$this->load->view('_shared/header');
$this->load->view('_shared/menus');
?>
<div class="container" id="options">
    <?php echo form_open($action_url); ?>
    <?php
    
    $this->table->add_row(array(
        form_label(required() . 'option', 'option') . form_error('option'),
        form_input(array(
            'id' => 'option',
            'name' => 'option',
            'class' => 'field',
            'value' => set_value('option', $option)
                )
        )
    ));
    
    $this->table->add_row(array(
        form_label(required() . 'option_value', 'option_value') . form_error('option_value'),
        form_input(array(
            'id' => 'option_value',
            'name' => 'option_value',
            'class' => 'field',
            'value' => set_value('option_value', $option_value)
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
            'value' => set_value('description', $description)
                )
        )
    ));

    echo $this->table->generate();
    ?>
    <?php echo form_submit('Save', 'save', 'class="btn primary"') ?>

    <?php form_close() ?>
</div>
<?php $this->load->view('_shared/footer'); ?>