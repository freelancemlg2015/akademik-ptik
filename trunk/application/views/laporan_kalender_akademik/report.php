<html>
    <head>
</head>
<body>
<?php 
// set document information
	    $pdf->SetCreator(PDF_CREATOR);
	    // remove default header/footer
	    $pdf->setPrintHeader(false);
	    $pdf->setPrintFooter(false);
	    //set margins
	    $pdf->SetMargins(8, 25, PDF_MARGIN_RIGHT);

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

	    
	    $pdf->SetXY(10,10,true);
	    	
	    $pdf->MultiCell(90, 15, "MARKAS BESAR\nKEPOLISIAN NEGARA REPUBLIK INDONESIA\nPERGURUAN TINGGI ILMU KEPOLISIAN", "B", 'C', 1, 0, '', '', true, 0, false, true, 15, 'M');
	    $pdf->MultiCell(50, 15, "", 0, 'L', 1, 0, '', '', true, 0, false, true, 15, 'M');
	    $pdf->MultiCell(80, 15, "LAMPIRAN SURAT KETUA STIK\nNOMOR  : B/      /I/2012/STIK\nTANGGAL :     JANUARI 2012", 0, 'L', 1, 0, '', '', true, 0, false, true, 15, 'M');
	    $pdf->Ln(20);
	    $pdf->SetFont('helvetica', 'B', 12);
	    $pdf->MultiCell(200, 15, "KALENDER AKADEMIK\nMAHASISWA STIK-PTIK ANGK KE-57 T.A. 2009-2011", 0, 'C', 1, 0, '', '', true, 0, false, true, 15, 'M');
	    
	    $pdf->SetFont('times', '', 10);

	    $pdf->Ln(20);

$table = '
	<table border = "1">
		<thead>
			<tr>
				<th align = "center" width = "30">
					<b>NO.</b>
				</th>
				<th align = "left"  width = "280">
					<b>WAKTU KEGIATAN.</b>
				</th>
				<th align = "center" width = "390">
					<b>NAMA KEGIATAN</b>
				</th>
			</tr>
		</thead>';


		$table .= '<tr>
			<td align = "left" colspan = "3" width = "700">
			<b>TRIMESTER 1 (18 Januari - 18 Mei 2010)</b>
			</td>
			</tr>
			<tr>
			<td align = "left" colspan = "3" width = "700">
			
			</td>
			</tr>';

		for($i=1;$i<18;$i++){	

		$table .= '<tr>
			<td align = "center" width = "30">
			'.$i.'.
			</td>
			<td align = "left" width = "280">
			18 Jan - 1 Maret 2010
			</td>
			<td align = "left" width = "390">
			Wawancara Mahasiswa untuk Pembagian PK Binkam dan Gakum
			</td>
		</tr>';
		}

		$table .= '
			<tr>
			<td align = "left" colspan = "3" width = "700">
			
			</td>
			</tr>';
	$table .= '</table>
		
';

	    $pdf->writeHTML($table, 0, 0, true, true);
 	$pdf->MultiCell(30, 10, "", 0, 'L', 1, 0, '', '', true, 0, false, true, 10, 'M');
	    $pdf->MultiCell(80, 10, "", 0, 'C', 1, 0, '', '', true, 0, false, true, 10, 'M');
	    $pdf->MultiCell(80, 10, "Ditetapkan di	:  Jakarta\nPada tanggal 	:  21 Desember 2012", "B", 'L', 1, 1, '', '', true, 0, false, true, 20, 'B');

	$pdf->Ln(3);
 	$pdf->MultiCell(30, 30, "", 0, 'L', 1, 0, '', '', true, 0, false, true, 20, 'M');
	    $pdf->MultiCell(70, 30, "", 0, 'C', 1, 0, '', '', true, 0, false, true, 20, 'M');
	    $pdf->MultiCell(100, 30, "GUBERNUR SELAKU KETUA SEKOLAH TINGGI\nPERGURUAN TINGGI ILMU KEPOLISIAN\n\n\n\n\nDrs. SUPRAPTO\nINSPEKTUR JENDRAL POLISI", 0, 'C', 1, 1, '', '', true, 0, false, true, 40, 'B');

	     
?>
</body>
</html>
