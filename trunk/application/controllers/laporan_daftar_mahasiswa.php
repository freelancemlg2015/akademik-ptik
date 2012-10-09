<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Laporan_daftar_mahasiswa extends CI_Controller {

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
function __construct() {
        parent::__construct();
        $this->load->helper(array('snippets_helper'));
        $this->load->model('crud_model', 'crud');
    }
    
    function log_date() {
        return date($this->config->item('log_date_format'));
    }

    function index($query_id = 0, $sort_by = 'id', $sort_order = 'desc', $offset = 0) {
        $this->mahasiswa($query_id, $sort_by, $sort_order, $offset);
    }

    function mahasiswa($query_id = 0, $sort_by = 'id', $sort_order = 'desc', $offset = 0) {
        $data_type = $this->input->post('data_type');
        $data['auth'] = $this->auth;
        // pagination
        $limit = 20;
        $this->load->library(array('form_validation', 'table', 'pagination'));
        $this->input->load_query($query_id);
        $query_array = array(
            'nim' => $this->input->get('nim'),
            'nama' => $this->input->get('nama'),
            'kode_angkatan' => $this->input->get('kode_angkatan'),
            'active' => 1
        );

        $this->load->model('mahasiswa_model', 'mahasiswa');
        $results = $this->mahasiswa->search($query_array, $limit, $offset, $sort_by, $sort_order);
        //echo get_instance()->db->last_query();
        $data['results'] = $results['results'];
        $data['num_results'] = $results['num_rows'];

        // pagination
        $config = array();
        $config['base_url'] = site_url("master/mahasiswa/$query_id/$sort_by/$sort_order");
        $config['total_rows'] = $data['num_results'];
        $config['per_page'] = $limit;
        $config['uri_segment'] = 6;
        $config['num_links'] = 6;

        $config = array_merge($config, default_pagination_btn());
        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();
        $data['sort_by'] = $sort_by;
        $data['sort_order'] = $sort_order;
	$data['kode_angkatan'] = $this->input->get('kode_angkatan');

        $data['page_title'] = 'Daftar Mahasiswa';


        $this->load->view('laporan/laporan_daftar_mahasiswa/laporan_daftar_mahasiswa', $data);
    }

    function search() {
        $query_array = array(
            'kode_angkatan' => $this->input->post('kode_angkatan'),
            'active' => 1
        );
        $query_id = $this->input->save_query($query_array);
        redirect("laporan/laporan_daftar_mahasiswa/view/$query_id");
    }
	public function report(){
	    $tinggi_gambar = 25;
	    $lebar_gambar = 25;

	    $this->load->library( 'tcpdf' );
	    $pdf = new daftar_mahasiswa();
	    $pdf->init($this->input->post('kode_angkatan'), $tinggi_gambar, $lebar_gambar);

		$query_array = array(
		    'nim' => $this->input->post('nim'),
		    'nama' => $this->input->post('nama'),
		    'kode_angkatan' => $this->input->post('kode_angkatan'),
		    'active' => 1
		);

		$this->load->model('mahasiswa_model', 'mahasiswa');
		$jumlah_mahasiswa = $this->mahasiswa->count_mahasiswa($query_array);
		$results = $this->mahasiswa->search($query_array, $jumlah_mahasiswa, 0, 'id', 'asc');

	    $data = array("pdf" => $pdf,
			  "lebar_gambar" => "25",
			  "tinggi_gambar" => "25",
		    	  'jumlah_mahasiswa' => $jumlah_mahasiswa,
		    	  'kode_angkatan' => $this->input->post('kode_angkatan'),
			  "results"	 => $results['results']
			);

	    $this->load->view("laporan/laporan_daftar_mahasiswa/report", $data, true);
	    //Close and output PDF document
	    $pdf->Output('DAFTAR MAHASISWA', 'I');
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
