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
	    $pdf->SetMargins(15, 10, PDF_MARGIN_RIGHT);

	    //set auto page breaks
	    $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

	    //set image scale factor
	    $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO); 

	    //initialize document
	    $pdf->AliasNbPages();

	    // add a page
	    $pdf->AddPage('P', 'LEGAL');
	
	    $pdf->SetFont('helvetica', 'B', 12);
	
	    $pdf->setCellMargins(15);

	    $pdf->Cell(45, 0, 'MARKAS BESAR KEPOLISIAN', 0, 1, 'C', 0, '', 0);
	    $pdf->Cell(45, 0, 'KEPOLISIAN NEGARA REPUBLIK INDONESIA', 0, 1, 'C', 0, '', 0);
	    $pdf->SetXY(0,20,true);
	    $pdf->setCellMargins(10);
	    $pdf->Cell(90, 0, 'PERGURUAN TINGGI ILMU KEPOLISIAN', "B", 1, 'C', 0, '', 0);

	    $pdf->Ln(15);

	    $pdf->Image('./assets/images/images.jpg', 95, 40, $lebar_gambar, $tinggi_gambar, 'JPG', 'http://www.tcpdf.org', '', true, 150, '', false, false, 0, false, false, false);

	   
	    $pdf->Ln(10);

	    $pdf->SetFont('helvetica', '', 16);

	    $pdf->setCellMargins(0);

	    $pdf->SetFont('times', '', 12);

	    $pdf->Ln(25); 
?>
<?php $table = '<table width = "100%">
<tr>
	<td width = "140"></td>
	<td width = "130">Nama Lengkap</td>
	<td width = "15">:</td>
	<td width = "100%">PRANARIA KARTIKANINGSATYA, S.KG</td>
</tr>
<tr>
	<td width = "140"></td>
	<td width = "130">No. Mahasiswa</td>
	<td width = "15">:</td>
	<td>7130</td>
</tr>
<tr>
	<td width = "140"></td>
	<td width = "130">Pangkat/NRP</td>
	<td width = "15">:</td>
	<td>IPTU /84101906</td>
</tr>
<tr>
	<td width = "140"></td>
	<td width = "130">Program Pendidikan</td>
	<td width = "15">:</td>
	<td>S1-STIK</td>
</tr>
<tr>
	<td width = "140"></td>
	<td width = "130">Tahun Ajaran</td>
	<td width = "15">:</td>
	<td>2012-2013</td>
</tr>
<tr>
	<td width = "140"></td>
	<td width = "130">Angkatan</td>
	<td width = "15">:</td>
	<td>LVIII</td>
</tr>
<tr>
	<td width = "140"></td>
	<td width = "130">Tanggal Yudisium</td>
	<td width = "15">:</td>
	<td></td>
</tr>
<tr>
	<td width = "140"></td>
	<td width = "130">Konsentrasi Studi</td>
	<td width = "15">:</td>
	<td>AK</td>
</tr>
</table>

<br/>
<br/>
<b>NILAI AKADEMIK</b>
<br/>
<br/>
<table border = "2">
<tr>
	<td rowspan = "2" align = "center" width = "40" height = "20" style="vertical-align: middle;height:100px;">&nbsp;<br/>No.</td>
	<td rowspan = "2" align = "center" width = "320" height = "20" >&nbsp;<br/>NAMA MATA KULIAH</td>
	<td rowspan = "2" align = "center" width = "60" height = "20">BOBOT SKS<br/>(X)</td>
	<td colspan = "2" align = "center" width = "130" height = "25">NILAI</td>
	<td rowspan = "2" align = "center" width = "55" height = "20">NILAI BOBOT (Y)</td>
	<td rowspan = "2" align = "center" width = "60" height = "20">&nbsp;<br/>(X Y)</td>
</tr>
<tr>
	<td align = "center" height = "20">ANGKA</td>
	<td align = "center" height = "20">HURUF</td>
</tr>
<tr>
<td align = "center"><br/>1.<br/>2.</td>
<td>&nbsp;FILSAFAT ILMU<br/>&nbsp;SOSIOLOGI<br/>&nbsp;SOSIOLOGI<br/>&nbsp;SOSIOLOGI<br/>&nbsp;SOSIOLOGI<br/>&nbsp;SOSIOLOGI<br/>&nbsp;SOSIOLOGI<br/>&nbsp;SOSIOLOGI<br/>&nbsp;SOSIOLOGI<br/>&nbsp;SOSIOLOGI<br/>&nbsp;SOSIOLOGI<br/>&nbsp;SOSIOLOGI<br/>&nbsp;SOSIOLOGI<br/>&nbsp;SOSIOLOGI<br/>&nbsp;SOSIOLOGI<br/>&nbsp;SOSIOLOGI<br/>&nbsp;SOSIOLOGI<br/>&nbsp;SOSIOLOGI</td>
<td align = "center"><br/>2<br/>2<br/>2<br/>2<br/>2<br/>2<br/>2<br/>2<br/>2<br/>2<br/>2<br/>2<br/>2<br/>2<br/>2<br/>2<br/>2<br/>2</td>
<td align = "center"><br/>90<br/>99<br/>99<br/>99<br/>99<br/>99<br/>99<br/>99<br/>99<br/>99<br/>99<br/>99<br/>99<br/>99<br/>99<br/>99<br/>99<br/>99</td>
<td align = "center"><br/>A<br/>A<br/>A<br/>A<br/>A<br/>A<br/>A<br/>A<br/>A<br/>A<br/>A<br/>A<br/>A<br/>A<br/>A<br/>A<br/>A<br/>A</td>
<td align = "center"><br/>4.0<br/>3.0<br/>3.0<br/>3.0<br/>3.0<br/>3.0<br/>3.0<br/>3.0<br/>3.0<br/>3.0<br/>3.0<br/>3.0<br/>3.0<br/>3.0<br/>3.0<br/>3.0<br/>3.0</td>
<td align = "center"><br/>6.0<br/>8.0<br/>8.0<br/>8.0<br/>8.0<br/>8.0<br/>8.0<br/>8.0<br/>8.0<br/>8.0<br/>8.0<br/>8.0<br/>8.0<br/>8.0<br/>8.0<br/>8.0<br/>8.0<br/>8.0<br/>8.0<br/>8.0<br/>8.0<br/>8.0<br/>8.0<br/>8.0<br/>8.0<br/>8.0<br/>8.0<br/>8.0<br/>8.0<br/>8.0</td>
</tr>
</table>';
	    $pdf->writeHTML($table, 0, 0, true, true);

	    $table = '
<b>No. Mahasiswa : 7280<br>Nama Lengkap : AFRIAN SATYA PERMADI, S.H</b>
<br/>
<table border = "2">
<tr>
	<td rowspan = "2" align = "center" width = "40" height = "20" style="vertical-align: middle;height:100px;">&nbsp;<br/>No.</td>
	<td rowspan = "2" align = "center" width = "320" height = "20" >&nbsp;<br/>NAMA MATA KULIAH</td>
	<td rowspan = "2" align = "center" width = "60" height = "20">BOBOT SKS<br/>(X)</td>
	<td colspan = "2" align = "center" width = "130" height = "25">NILAI</td>
	<td rowspan = "2" align = "center" width = "55" height = "20">NILAI BOBOT (Y)</td>
	<td rowspan = "2" align = "center" width = "60" height = "20">&nbsp;<br/>(X Y)</td>
</tr>
<tr>
	<td align = "center" height = "20">ANGKA</td>
	<td align = "center" height = "20">HURUF</td>
</tr>
<tr>
<td align = "center"><br/>1.<br/>2.</td>
<td>&nbsp;FILSAFAT ILMU<br/>&nbsp;SOSIOLOGI<br/>&nbsp;SOSIOLOGI<br/>&nbsp;SOSIOLOGI<br/>&nbsp;SOSIOLOGI<br/>&nbsp;SOSIOLOGI<br/>&nbsp;SOSIOLOGI<br/>&nbsp;SOSIOLOGI<br/>&nbsp;SOSIOLOGI<br/>&nbsp;SOSIOLOGI<br/>&nbsp;SOSIOLOGI<br/>&nbsp;SOSIOLOGI<br/>&nbsp;SOSIOLOGI<br/>&nbsp;SOSIOLOGI<br/>&nbsp;SOSIOLOGI<br/>&nbsp;SOSIOLOGI<br/>&nbsp;SOSIOLOGI<br/>&nbsp;SOSIOLOGI</td>
<td align = "center"><br/>2<br/>2<br/>2<br/>2<br/>2<br/>2<br/>2<br/>2<br/>2<br/>2<br/>2<br/>2<br/>2<br/>2<br/>2<br/>2<br/>2<br/>2</td>
<td align = "center"><br/>90<br/>99<br/>99<br/>99<br/>99<br/>99<br/>99<br/>99<br/>99<br/>99<br/>99<br/>99<br/>99<br/>99<br/>99<br/>99<br/>99<br/>99</td>
<td align = "center"><br/>A<br/>A<br/>A<br/>A<br/>A<br/>A<br/>A<br/>A<br/>A<br/>A<br/>A<br/>A<br/>A<br/>A<br/>A<br/>A<br/>A<br/>A</td>
<td align = "center"><br/>4.0<br/>3.0<br/>3.0<br/>3.0<br/>3.0<br/>3.0<br/>3.0<br/>3.0<br/>3.0<br/>3.0<br/>3.0<br/>3.0<br/>3.0<br/>3.0<br/>3.0<br/>3.0<br/>3.0</td>
<td align = "center"><br/>6.0<br/>8.0<br/>8.0<br/>8.0<br/>8.0<br/>8.0<br/>8.0<br/>8.0<br/>8.0<br/>8.0<br/>8.0<br/>8.0<br/>8.0<br/>8.0<br/>8.0<br/>8.0<br/>8.0<br/>8.0<br/>8.0<br/>8.0<br/>8.0<br/>8.0<br/>8.0<br/>8.0<br/>8.0<br/>8.0<br/>8.0<br/>8.0<br/>8.0<br/>8.0</td>
</tr>
<tr>
<td colspan = "2">	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;JUMLAH</td>
<td align = "center">4</td>
<td colspan = "3"></td>
<td align = "center">14</td>
</tr>
<tr>
<td colspan = "2">	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;INDEX PRESTASI SEMESTER</td>
<td align = "center">3.62</td>
<td colspan = "4"></td>
</tr>
<tr>
<td colspan = "2">	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;IPK/Total SKS</td>
<td colspan = "5">&nbsp;&nbsp;&nbsp;&nbsp;3.62&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;/&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;4</td>
</tr>
</table></>';
	    
	    $pdf->AddPage('P', 'LEGAL');
	    $pdf->writeHTML($table, 0, 0, true, true);

	$pdf->Ln(5);
	$pdf->SetFillColor(255, 255, 255);
	$pdf->MultiCell(188, 5, "JUDUL SKRIPSI :", 'LTR', 'L', 1, 1, '', '', true, 0, false, true, 8, 'B');
	$pdf->MultiCell(35, 5, "", 'LB', 'L', 1, 0, '', '', true, 0, false, true, 23, 'B');
	$pdf->MultiCell(153, 5, "IMPLEMENTASI KEBIJAKAN SENTRALISASI PELAYANAN PENERBITAN BPKB BARU (BBN I) DALAM RANGKA PEMUSATAN DATABASE KENDARAAN BERMOTOR PADA DITLANTAS POLDA DAERAH ISTIMEWA YOGYAKARTA", 'BR', 'C', 1, 0, '', '', true, 0, false, true, 23, 'B');

	$pdf->Ln(30);

	$table = '<table border = "2">
<tr>
	<td rowspan = "2" align = "center" width = "40" height = "20" style="vertical-align: middle;height:100px;">&nbsp;<br/>No.</td>
	<td rowspan = "2" align = "center" width = "360" height = "20" >&nbsp;<br/>S U B Y E K</td>
	<td colspan = "2" align = "center" width = "130" height = "25">NILAI</td>
	<td rowspan = "2" align = "center" width = "140" height = "20">KETERANGAN</td>
</tr>
<tr>
	<td align = "center" height = "20">ANGKA</td>
	<td align = "center" height = "20">HURUF</td>
</tr>
<tr>
<td align = "center"><br/>1.<br/>2.</td>
<td>&nbsp;FILSAFAT ILMU<br/>&nbsp;SOSIOLOGI</td>
<td align = "center"><br/>2<br/>2</td>
<td align = "center"><br/>90<br/>99<br/>99<br/>99</td>
<td align = "center"><br/>A<br/>A</td>
</tr>
</table>';
	

	    $pdf->writeHTML($table, 0, 0, true, true);

$pdf->MultiCell(30, 10, "", 0, 'L', 1, 0, '', '', true, 0, false, true, 15, 'M');
	    $pdf->MultiCell(60, 10, "", 0, 'C', 1, 0, '', '', true, 0, false, true, 15, 'M');
	    $pdf->MultiCell(100, 10, "Jakarta,     Januari 2012\nKETUA SEKOLAH TINGGI ILMU KEPOLISIAN\n\n\n\nDrs. MISRAN MUSA\nKOMISARIS BESAR POLISI NRP. 56060855 ", 0, 'C', 1, 1, '', '', true, 0, false, true, 40, 'B');

?>
</body>
</html>
