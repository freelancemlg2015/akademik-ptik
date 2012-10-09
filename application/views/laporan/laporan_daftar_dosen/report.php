<html>
    <head>
</head>
<body>
<?php 
// set document information
	    // remove default header/footer
	    $pdf->setPrintHeader(true);
	    $pdf->setPrintFooter(true);
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

	    $pdf->MultiCell(120, 15, "MARKAS BESAR\nKEPOLISIAN NEGARA REPUBLIK INDONESIA\nPERGURUAN TINGGI ILMU KEPOLISIAN", 0, 'C', 1, 0, '', '', true, 0, false, true, 15, 'M');
	    $pdf->Ln(40);
	    $pdf->Image('./assets/images/images.jpg', 93, 25, $lebar_gambar, $tinggi_gambar, 'JPG', 'http://www.tcpdf.org', '', true, 150, '', false, false, 0, false, false, false);
	
	    $pdf->SetFont('helvetica', 'B', 12);

            $program_studi_statement = '';
	    $table = '';
	    if(!empty($prodi))
		$program_studi_statement = "PROGRAM STUDI $prodi\n";

	    $pdf->MultiCell(200, 15, "DAFTAR DOSEN PTIK\n".$program_studi_statement."ANGKATAN ".$results['0']['kode_angkatan'], 0, 'C', 1, 0, '', '', true, 0, false, true, 18, 'M');
	    
	    $pdf->SetFont('times', '', 10);

	    $pdf->Ln(20);

$table_header = '
	<table border = "1">
		<thead>
			<tr>
				<th align = "center" width = "30">
					<b>NO.</b>
				</th>
				<th align = "center" width = "70">
					<b>NO.MHS</b>
				</th>
				<th align = "center" width = "250">
					<b>N A M A</b>
				</th>
				<th align = "center">
					<b>PANGKAT<br/>NRP</b>
				</th>
				<th align = "center" colspan = "2">
					<b>TANDA TANGAN</b>
				</th>
			</tr>
		</thead>';
		$i = 1;
		
	    	$pdf->writeHTML($table, 0, 0, true, true);
		foreach ($results as $row) {	
		if($i%2==0)
			$position = "right";
		else
			$position = "left";
		
		if($table == '')
			$table .= $table_header;

		$table .= '<tr>
			<td align = "center" width = "30" height = "40">
			&nbsp;<br/>'.$i.'.
			</td>
			<td align = "center" width = "70" height = "40">
			&nbsp;<br/>'.$row['nip_pns'].'
			</td>
			<td align = "left" width = "250" height = "40">
			&nbsp;<br/>&nbsp;'.$row['nama_dosen'].'
			</td>
			<td align = "center" height = "40">
			&nbsp;<br/>'.$row['nama_pangkat'].'
			</td>
			<td align = "'.$position.'" height = "40" colspan = "2">
			&nbsp;<br/>&nbsp;'.$i.'..........................&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
			</td>
		</tr>';

		if($i%20 == 0){
			$table .= '</table>';
		        $pdf->writeHTML($table, 0, 0, true, true);
			$table = '';
			
			    // add a page
			    if($i < $jumlah_dosen){
				    $pdf->AddPage('P', 'LEGAL');
				    $pdf->Ln(50);
			    }
		}else if($i == $jumlah_dosen){
			$table .= '</table>';
		        $pdf->writeHTML($table, 0, 0, true, true);
			$table = '';
		}
		$i++;
		}
?>
</body>
</html>
