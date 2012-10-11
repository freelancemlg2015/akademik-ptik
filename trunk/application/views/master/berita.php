<?php
$this->load->view('_shared/header');
$this->load->view('_shared/menus');
?>

<div class="container-fluid form-inline well" id="berita-search">
    <?php
    $kategori_berita_attr = array(
        'id' => 'kategori_berita',
        'name' => 'kategori_berita',
        'class' => 'input-medium',
        'style' => 'text-transform : uppercase;',
        'placeholder' => 'Kategori'
    );
    $judul_berita_attr = array(
        'id' => 'judul_berita',
        'name' => 'judul_berita',
        'class' => 'input-medium',
        'style' => 'text-transform : uppercase;',
        'placeholder' => 'Berita'
    );
    echo form_open('master/berita/search/') .
    form_input($kategori_berita_attr) . ' ' .
    form_input($judul_berita_attr) . ' ' .
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

<table class="table table-bordered table-striped container-full data_list" id="berita" controller="master">
    <thead>
        <tr>
            <th>Kategori</th>
            <th>Judul</th>
            <th>Konten</th>
        </tr>
    </thead>
    <tbody>
        <?php
        foreach ($results->result() as $row) {
            echo '<tr id="' . $row->id . '">
              <td>' . $row->kategori_berita . '</td>
              <td>' . $row->judul_berita . '</td>    
              <td>' . $row->konten_berita . '</td>    
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