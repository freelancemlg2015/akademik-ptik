<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Laporan_lembar_hasil_studi extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -  
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in 
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
	public function index()
	{

	    $this->load->library( 'tcpdf' );
	    $pdf = tcpdf();

	    // set document information
	    $pdf->SetCreator(PDF_CREATOR);
	    $pdf->SetAuthor("PTIK");
	    $pdf->SetTitle("DAFTAR MATA KULIAH");
	    $pdf->SetSubject("TCPDF Tutorial");
	    $pdf->SetKeywords("laporan, report, lembar hasil studi, ptik");
	    // remove default header/footer
	    $pdf->setPrintHeader(false);
	    $pdf->setPrintFooter(false);
	    //set margins
	    $pdf->SetMargins(15, 5, PDF_MARGIN_RIGHT);

	    //set auto page breaks
	    $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

	    //set image scale factor
	    $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO); 

	    //initialize document
	    $pdf->AliasNbPages();

	    // add a page
	    $pdf->AddPage('P', 'LEGAL');
	
	    $pdf->SetFont('helvetica', '', 12);
	
	    $pdf->setCellMargins(10);

	    $pdf->Cell(45, 0, 'PERGURUAN TINGGI ILMU KEPOLISIAN', 0, 1, 'C', 0, '', 0);
	    $pdf->Cell(45, 0, 'DIREKTORAT AKADEMIK', 0, 1, 'C', 0, '', 0);

	    $pdf->Ln(15);

	    $pdf->SetFont('helvetica', 'B', 16);
	    $pdf->Cell(135, 0, 'LEMBAR HASIL STUDI', 0, 1, 'C', 0, '', 0);
	    $pdf->SetFont('helvetica', '', 14);
	    $pdf->setCellMargins(25);
	    $pdf->Cell(110, 0, 'MAHASISWA PTIK ANGK. KE-57 SEMESTER I', 'B', 1, 'C', 0, '', 0);
	   
	    $pdf->Ln(10);

	    $pdf->SetFont('helvetica', '', 16);

	    $pdf->setCellMargins(0);

	    $pdf->SetFont('times', '', 11);

	    $data = array("pdf", $pdf);

	    $f1 = $this->load->view("laporan_lembar_hasil_studi/report", $data, true);
	    $pdf->writeHTML($f1, 0, 0, true, true);
	    //Close and output PDF document
	    $pdf->Output('LEMBAR HASIL STUDI', 'I');
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
