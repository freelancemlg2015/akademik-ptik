<?php $this->load->view('_shared/header'); ?>

<div id="login" class="modal hide fade span4">
    <?php echo form_open('login'); ?>
    <div class="modal-header">
        <h3 style="text-align: center;">SISTEM INFORMASI AKADEMIK SEKOLAH TINGGI ILMU KEPOLISIAN</h3>
    </div>
    <div class="modal-body">
        <?php
        $attributes = array(
            'class' => 'mycustomclass',
            'style' => 'color: #000;',
        );

        $tmpl = array('table_open' => '<table border="0" cellpadding="0" cellspacing="0" class="span3 form-inline">');
        $this->table->set_template($tmpl); 

        $this->table->add_row(array(
            form_label('Username', 'username', $attributes),
            form_input(array(
                'id' => 'username',
                'name' => 'username',
                'class' => 'span2',
                'value' => set_value('username'),
                'placeholder' => 'username'
                    )
            )
        ));

        $this->table->add_row(array(
            form_label('Password', 'pass', $attributes),
            form_password(array(
                'id' => 'pass',
                'name' => 'pass',
                'class' => 'span2',
                'value' => set_value('pass'),
                'placeholder' => 'password'
                    )
            )
        ));

        $this->table->add_row(array(
            form_label('', ''),
            form_submit('login', 'LOGIN', 'class="btn btn-primary btn-small pull-left"')
        ));

        echo $this->table->generate();
        ?>

        <?php
        echo form_error('username');
        echo form_error('pass');
        ?>
    </div>

    <div class="modal-footer">
        <h6 style="text-align: center;"><p>&copy; 2012</p></h6>
    </div>

    <?php form_close() ?>
</div>

<?php $this->load->view('_shared/footer'); ?>