<?php
$this->load->view('_shared/header');
$this->load->view('_shared/menus');
?>

<div class="container-fluid form-inline well" id="jam_pelajaran-search">
    <?php
    $kode_jam_attr = array(
        'id' => 'kode_jam',
        'name' => 'kode_jam',
        'class' => 'input-medium',
        'style' => 'text-transform : uppercase;',
        'placeholder' => 'Kode Jam'
    );
    echo form_open('master/jam_pelajaran/search/') .
    form_input($kode_jam_attr) . ' ' .
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

<table class="table table-bordered table-striped container-full data_list" id="jam_pelajaran" controller="master">
    <thead>
        <tr>
            <th>Kode Jam</th>
            <th>Jam Normal</th>
            <th>Jam puasa</th>
        </tr>
    </thead>
    <tbody>
        <?php
        foreach ($results->result() as $row) {
            $jam_normal  = $row->jam_normal_mulai.$row->jam_normal_akhir;
            if(strrpos($jam_normal,'-')<1)$jam_normal = substr ($row->jam_normal_mulai, 0,5).'-'.substr ($row->jam_normal_akhir, 0,5);
            $jam_puasa  = $row->jam_puasa_mulai.$row->jam_puasa_akhir;
            if(strrpos($jam_puasa,'-')<1)$jam_puasa = substr ($row->jam_puasa_mulai, 0,5).'-'.substr ($row->jam_puasa_akhir, 0,5);
            echo '<tr id="' . $row->id . '">
              <td>' . $row->kode_jam . '</td>
              <td>' . $jam_normal . '</td>    
              <td>' . $jam_puasa . '</td>    
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