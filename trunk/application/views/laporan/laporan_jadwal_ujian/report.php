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
	    $pdf->SetMargins(5, 25, PDF_MARGIN_RIGHT);

	    //set auto page breaks
	    $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

	    //set image scale factor
	    $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO); 

	    //initialize document
	    $pdf->AliasNbPages();

	    // add a page
	    $pdf->AddPage('P', 'LEGAL');
	
	    $pdf->SetFont('helvetica', '', 11);
	
	    $pdf->setCellMargins(0,0);

	    $pdf->SetFillColor(255, 255, 255);

	    $pdf->SetXY(0,10,true);

	    $pdf->Image('./assets/images/images.jpg', 43, 3, $lebar_gambar, $tinggi_gambar, 'JPG', 'http://www.tcpdf.org', '', true, 150, '', false, false, 0, false, false, false);
	
	    $pdf->Ln(15);		
	
	    $pdf->MultiCell(100, 15, "LEMBAGA PENDIDIKAN POLRI\nSEKOLAH TINGGI ILMU KEPOLISIAN", 0, 'C', 1, 0, '', '', true, 0, false, true, 15, 'M');
	    $pdf->MultiCell(40, 15, "", 0, 'L', 1, 0, '', '', true, 0, false, true, 15, 'M');
	    $pdf->MultiCell(80, 15, "LAMPIRAN SURAT KETUA STIK\nNOMOR  : B/      /I/2012/STIK\nTANGGAL :     JANUARI 2012", 0, 'L', 1, 0, '', '', true, 0, false, true, 15, 'M');
	    $pdf->Ln(20);
	    $pdf->SetFont('helvetica', 'B', 12);
	    $pdf->MultiCell(190, 15, "JADWAL UJIAN AKHIR SEMESTER III\nMAHASISWA STIK-PTIK ANGK KE-57", 0, 'C', 1, 0, '', '', true, 0, false, true, 15, 'M');
	    
	    $pdf->SetFont('times', '', 10);

	    $pdf->Ln(20);

$table = '
	<table border = "1">
		<thead>
			<tr>
				<th align = "center" width = "30">
					<b>NO.</b>
				</th>
				<th align = "center"  width = "80">
					<b>HARI/TGL.</b>
				</th>
				<th align = "center" width = "90">
					<b>JAM</b>
				</th>
				<th align = "center" width = "180">
					<b>MATAKULIAH</b>
				</th>
				<th align = "center"  width = "330">
					<b>DOSEN</b>
				</th>
			</tr>
		</thead>';

		for($i=1;$i<18;$i++){	

		$table .= '<tr>
			<td align = "center" width = "30" height = "40">
			&nbsp;<br/>'.$i.'.
			</td>
			<td align = "center" height = "40" width = "80">
			JUMAT<br/>27-01-2012
			</td>
			<td align = "left" width = "90" height = "40" >
			&nbsp;<br/>08:00 - 09:45
			</td>
			<td align = "left" height = "40" width = "180">
			PSIKOLOGI FORENSIK
			</td>
			<td align = "left" height = "40" width = "330">
			- BRIGJEN POL (P) Prof. Dr. HR. ABDUSSALAM, SH., MH.
			</td>
		</tr>';
		}
	$table .= '</table>
		
';

	    $pdf->writeHTML($table, 0, 0, true, true);
 	$pdf->MultiCell(30, 30, "", 0, 'L', 1, 0, '', '', true, 0, false, true, 20, 'M');
	    $pdf->MultiCell(90, 30, "", 0, 'C', 1, 0, '', '', true, 0, false, true, 20, 'M');
	    $pdf->MultiCell(100, 30, "Jakarta,     Januari 2012\na.n. KETUA STIK LEMDIKPOL\nWAKET BIDANG AKADEMIK\nu.b\nKABAG LADIKJARLAT\n\n\n\n\nDrs. MISRAN MUSA\nKOMISARIS BESAR POLISI NRP. 56060855 ", 0, 'C', 1, 1, '', '', true, 0, false, true, 60, 'B');

	     
?>
</body>
</html>
