<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Laporan_nilai_akademik extends CI_Controller {

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
	
	    $tinggi_gambar = 25;
	    $lebar_gambar = 25;

	    $this->load->library( 'tcpdf' );
	    $pdf = tcpdf();

	    

	    $data = array("pdf" => $pdf,
			  "lebar_gambar" => "25",
			  "tinggi_gambar" => "25",
			);

	    $this->load->view("laporan_nilai_akademik/report", $data, true);
	    //Close and output PDF document
	    $pdf->Output('NILAI AKADEMIK', 'I');
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
