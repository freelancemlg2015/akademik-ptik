<?php
$this->load->view('_shared/header');
$this->load->view('_shared/menus');
//label
$control_label = array(
    'class' => 'control-label'
);
?>
<div class="container-full form-horizontal" id="berita">
    <table cellspacing="0" cellpadding="0" border="0" class="table table-bordered">
        <tbody>
            <tr>
                <th class="span2">Kategori</th>
                <td><?= $kategori_berita ?></td>
            </tr>
            <tr>
                <th class="span2">Judul</th>
                <td><?= $judul_berita ?></td>
            </tr>
            <tr>
                <th class="span2">Konten</th>
                <td><?= $konten_berita ?></td>
            </tr>
            <tr>
                <th class="span2">Foto Berita</th>
                <td>
                    <?php
                        $path_parts = pathinfo('/assets/berita/thumbs/'.$foto_berita);
                        $image_filename = $path_parts['filename'];
                        $image_extension = @$path_parts['extension'];
                        if(isset($image_extension)){
                            echo"<a href='".base_url()."assets/berita/medium/".$image_filename.'_medium.'.$image_extension."' rel="."shadowbox".">
                                    <img src=".base_url()."assets/berita/thumbs/".$image_filename.'_thumb.'.$image_extension.">
                                </a>";
                        }
                    ?>
                </td>
            </tr>
        </tbody>
    </table>
</div>

<?php $this->load->view('_shared/footer'); ?>