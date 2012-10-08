<?php
$this->load->view('_shared/header');
$this->load->view('_shared/menus');
?>

<div class="container-fluid form-inline well" id="semester-search">
    <?php
    $kode_semester_attr = array(
        'id' => 'kode_semester',
        'name' => 'kode_semester',
        'class' => 'input-medium',
        'style' => 'text-transform : uppercase;',
        'placeholder' => 'Kode Semester'
    );
    $nama_semester_attr = array(
        'id' => 'nama_semester',
        'name' => 'nama_semester',
        'class' => 'input-medium',
        'style' => 'text-transform : uppercase;',
        'placeholder' => 'Nama Semester'
    );
    echo form_open('master/semester/search/') .
    form_input($kode_semester_attr) . ' ' .
    form_input($nama_semester_attr) . ' ' .
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

<table class="table table-bordered table-striped container-full data_list" id="semester" controller="master">
    <thead>
        <tr>
            <th>Kode Semester</th>
            <th>Nama Semester</th>
        </tr>
    </thead>
    <tbody>
        <?php
        foreach ($results->result() as $row) {
            echo '<tr id="' . $row->id . '">
              <td>' . $row->kode_semester . '</td>
              <td>' . $row->nama_semester . '</td>    
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