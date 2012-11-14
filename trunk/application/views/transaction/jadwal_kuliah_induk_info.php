<?php
$this->load->view('_shared/header');
$this->load->view('_shared/menus');
//label
$control_label = array(
    'class' => 'control-label'
);
?>
<?php
//echo '<pre>info</pre>'; return; exit;
?>
<div class="container-full form-horizontal" id="jadwal_kuliah_induk">
    <table cellspacing="0" cellpadding="0" border="0" class="table table-bordered">
        <tbody>
            <tr>
                <th class="span2">Mata Kuliah</th>
                <td><?= $nama_mata_kuliah; ?>
				</td>
            </tr>
			<tr>
                <th class="span2">Hari / Jam</th>
                <td><?= $nama_hari.'<br>'.$jam_normal_mulai.' - '.$jam_normal_akhir;  ?></td>
            </tr>
            <tr>
                <th class="span2">Keterangan</th>
                <td><?= $keterangan ?></td>
            </tr>
        </tbody>
    </table>
</div>

<?php $this->load->view('_shared/footer'); ?>