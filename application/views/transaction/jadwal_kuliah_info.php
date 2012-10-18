<?php
$this->load->view('_shared/header');
$this->load->view('_shared/menus');
//label
$control_label = array(
    'class' => 'control-label'
);
?>
<div class="container-full form-horizontal" id="jadwal_kuliah">
    <table cellspacing="0" cellpadding="0" border="0" class="table table-bordered">
        <tbody>
            <tr>
                <th class="span2">Mata Kuliah</th>
                <td><?php 
				$display_event = $nama_mata_kuliah;
				if($kegiatan_id!=0) $display_event = $nama_kegiatan;
				echo $display_event;
				?>
				</td>
            </tr>
			<tr>
                <th class="span2">Metode</th>
                <td><?= $metode_ajar  ?></td>
            </tr>
            <tr>
                <th class="span2">Ruang</th>
                <td><?= $nama_ruang ?></td>
            </tr>
            <tr>
                <th class="span2">Jenis Waktu</th>
                <td><?= $kode_jam ?></td>
            </tr>
            <tr>
                <th class="span2">Tanggal</th>
                <td><?= $tanggal ?></td>
            </tr>
            <tr>
                <th class="span2">Jam</th>
                <td><?= $jam_normal_mulai. ' - '. $jam_normal_akhir ?></td>
            </tr>
        </tbody>
    </table>
</div>

<?php $this->load->view('_shared/footer'); ?>