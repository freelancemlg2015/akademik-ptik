<html>
    <head>
</head>
<body>
<?php 
// set document information
	    $pdf->SetCreator(PDF_CREATOR);
	    $pdf->SetAuthor("PTIK");
	    $pdf->SetTitle("NILAI AKADEMIK");
	    $pdf->SetSubject("NILAI AKADEMIK");
	    $pdf->SetKeywords("laporan, report, NILAI AKADEMIK, ptik");
	    // remove default header/footer
	    $pdf->setPrintHeader(false);
	    $pdf->setPrintFooter(false);
	    //set margins
	    $pdf->SetMargins(5, 5, PDF_MARGIN_RIGHT);

	    //set auto page breaks
	    $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

	    //set image scale factor
	    $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO); 

	    //initialize document
	    $pdf->AliasNbPages();

	    // add a page
	    $pdf->AddPage('L', 'LEGAL');
	
	    $pdf->SetFont('helvetica', '', 11);
	
	    $pdf->setCellMargins(0,0);

	    $pdf->SetFillColor(255, 255, 255);

	    $pdf->MultiCell(145, 15, "BIDANG AKADEMIK\nBAGIAN PELAKSANAAN PENDIDIKAN PENGAJARAN DAN PELATIHAN", 0, 'C', 1, 0, '', '', true, 0, false, true, 10, 'M');
	    $pdf->MultiCell(80, 15, "", 0, 'C', 1, 0, '', '', true, 0, false, true, 10, 'M');
	    $pdf->MultiCell(100, 15, "JADWAL MINGGUAN SEMETER KE ".$attribute['kode_semester']."\nMAHASISWA STIK-PTIK ANGKATAN KE-".$attribute['kode_angkatan']."\nMINGGU KE ".$attribute['minggu']."\nPROGRAM STUDI ADMINISTRASI KEPOLISIAN\n ", 0, 'J', 1, 1, '', '', true, 0, false, true, 24, 'B');

	    $pdf->SetFont('times', '', 10);


$table = '
<table>
<tr>
	<td border = "1" rowspan = "2" align = "center" width = "80" style="vertical-align: middle;">HARI<br/>TANGGAL</td>
	<td border = "1" rowspan = "2" align = "center" width = "45" >UNIT<br/>KE</td>
	<td border = "1" rowspan = "2" align = "center" width = "80">WAKTU</td>
	<td border = "1" colspan = "2" align = "center" width = "100">PERTEMUAN</td>
	<td border = "1" rowspan = "2" align = "center" width = "320">MATA KULIAH</td>
	<td border = "1" rowspan = "2" align = "center" width = "100">METODE</td>
	<td border = "1" rowspan = "2" align = "center" width = "350">DOSEN PENGAJAR</td>
	<td border = "1" rowspan = "2" align = "center" width = "150">TEMPAT</td>
</tr>
<tr>
	<td border = "1" align = "center">KE</td>
	<td border = "1" align = "center">DARI</td>
</tr>';
foreach($data as $row){
$table .= '<tr>
	<td border = "1" width = "80" align = "center">
		'.$row['hari'].'
	</td>
	<td border = "1" width = "45"  align = "center">
		'.$row['unit_ke'].'
	</td>
	<td border = "1" width = "80"  align = "center">
		'.$row['jam'].'
	</td>
	<td border = "1" align = "center">
		'.$row['pertemuan_ke'].'
	</td>
	<td border = "1" align = "center">
		'.$row['pertemuan_dari'].'
	</td>
	<td border = "1" width = "320">
		'.$row['nama_mata_kuliah'].'
	</td>
	<td border = "1" width = "100">
		'.$row['metode'].'
	</td>
	<td border = "1" width = "350">
		'.$row['nama_dosen'].'
	</td>
	<td border = "1" width = "150">
		'.$row['nama_ruang'].'
	</td>
	
</tr>';
}
$table .= '</table>';

	    $pdf->writeHTML($table, 0, 0, true, true);

	     $pdf->MultiCell(145, 30, "KETERANGAN\n1. WAKTU ISTIRAHAT\n   a. JAM 09:40 - 10:00 (PERTAMA)\n   b. JAM 11:40 - 13:00 WIB (KEDUA)\n2. *) JAM CADANGAN", 0, 'L', 1, 0, '', '', true, 0, false, true, 30, 'M');
	    $pdf->MultiCell(80, 30, "", 0, 'C', 1, 0, '', '', true, 0, false, true, 20, 'M');
	    $pdf->MultiCell(100, 30, "Jakarta,     ".date("F Y")."\nKABAG LAKDIKLARJAT\n\n\nDrs. MISRAN MUSA\nKOMISARIS BESAR POLISI NRP. 56060855 ", 0, 'C', 1, 1, '', '', true, 0, false, true, 30, 'B');

?>
</body>
</html>
