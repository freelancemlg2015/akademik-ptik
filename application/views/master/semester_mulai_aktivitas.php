<?php
$this->load->view('_shared/header');
$this->load->view('_shared/menus');
?>

<div class="container-fluid form-inline well" id="semester_mulai_aktivitas-search">
    <?php
    $semester_mulai_aktivitas_attr = array(
        'id' => 'semester_mulai_aktivitas',
        'name' => 'semester_mulai_aktivitas',
        'class' => 'input-medium',
        'style' => 'text-transform : uppercase;',
        'placeholder' => 'Semester Mulai Aktivitas'
    );
    echo form_open('master/semester_mulai_aktivitas/search/') .
    form_input($semester_mulai_aktivitas_attr) . ' ' .
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

<table class="table table-bordered table-striped container-full data_list" id="semester_mulai_aktivitas" controller="master">
    <thead>
        <tr>
            <th>Semester Mulai Aktivitas</th>
        </tr>
    </thead>
    <tbody>
        <?php
        foreach ($results->result() as $row) {
            echo '<tr id="' . $row->id . '">
              <td>' . $row->semester_mulai_aktivitas . '</td>
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