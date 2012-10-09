<?php
	    // remove default header/footer
	    $pdf->setPrintHeader(false);
	    $pdf->setPrintFooter(false);
	    //set margins
	    $pdf->SetMargins(20, 5, PDF_MARGIN_RIGHT);

	    //set auto page breaks
	    $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

	    //set image scale factor
	    $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO); 

	    //initialize document
	    $pdf->AliasNbPages();

	    // add a page
	    $pdf->AddPage('P', 'A4');
	
	    $pdf->SetFont('helvetica', 'B', 14);
	
	    $pdf->setCellMargins(10);

	    $pdf->Cell(45, 0, 'SEKOLAH TINGGI ILMU KEPOLISIAN', 0, 1, 'C', 0, '', 0);
	    $pdf->Cell(45, 0, 'BIDANG AKADEMIK', 0, 1, 'C', 0, '', 0);

	    $pdf->Ln($data['attribute']['tinggi_gambar']+10);


	    $pdf->Image('./assets/images/images.jpg', 85, 30, $data['attribute']['lebar_gambar'], $data['attribute']['tinggi_gambar'], 'JPG', 'http://www.tcpdf.org', '', true, 150, '', false, false, 0, false, false, false);

	    $pdf->SetFillColor(255, 255, 255);	
	    
	    $pdf->SetFont('helvetica', 'B', 12);
	    $pdf->MultiCell(150, 15, "SEMESTER ".$data['attribute']['kode_semester']." ANGKATAN ".$data['attribute']['kode_angkatan'], 0, 'C', 1, 0, '', '', true, 0, false, true, 15, 'M');
	    $pdf->Ln(30);
	    
	    $pdf->SetFont('helvetica', '', 16);

	    $pdf->setCellMargins(0);

	    

$table ='
<table border = "0">';
	$i = 1;
	foreach ($data['data'] as $row) {	
		$table .= '<tr>
				<td width = "40" height = "35">'.$i.'.</td>
				<td width = "480" height = "35">'.$row['nama_mata_kuliah'].'</td>
				<td>'.$row['sks'].'</td>
			</tr>';		
		$i++;
	    }
$table .= '</table>';	
	    $pdf->writeHTML($table, 0, 0, true, true);
	$pdf->MultiCell(30, 15, "", "0", 'C', 1, 0, '', '', true, 0, false, true, 15, 'M');
	    $pdf->MultiCell(100, 15, "", 0, 'L', 1, 0, '', '', true, 0, false, true, 15, 'M');
	    $pdf->MultiCell(40, 15, $data['jumlah_sks']." SKS", "T", 'C', 1, 0, '', '', true, 0, false, true, 15, 'M');
	    
?>
