<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Laporan_daftar_matakuliah_paket extends CI_Controller {

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
        $this->mata_kuliah($query_id, $sort_by, $sort_order, $offset);
    }

    function mata_kuliah($query_id = 0, $sort_by = 'id', $sort_order = 'desc', $offset = 0) {
        $data_type = $this->input->post('data_type');
        $data['auth'] = $this->auth;
        // pagination
        $limit = 20;
        $this->load->library(array('form_validation', 'table', 'pagination'));
        $this->input->load_query($query_id);
        $query_array = array(
            'kode_mata_kuliah' => $this->input->get('kode_mata_kuliah'),
            'nama_mata_kuliah' => $this->input->get('nama_mata_kuliah'),
            'kode_semester' => $this->input->get('kode_semester'),
            'kode_angkatan' => $this->input->get('kode_angkatan'),
            'active' => 1
        );

        $this->load->model('mata_kuliah_model', 'mata_kuliah');
        $results = $this->mata_kuliah->search($query_array, $limit, $offset, $sort_by, $sort_order);
        //echo get_instance()->db->last_query();
        $data['results'] = $results['results'];
        $data['num_results'] = $results['num_rows'];

        // pagination
        $config = array();
        $config['base_url'] = site_url("laporan/laporan_daftar_matakuliah_paket/$query_id/$sort_by/$sort_order");
        $config['total_rows'] = $data['num_results'];
        $config['per_page'] = $limit;
        $config['uri_segment'] = 6;
        $config['num_links'] = 6;

        $config = array_merge($config, default_pagination_btn());
        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();
        $data['sort_by'] = $sort_by;
        $data['sort_order'] = $sort_order;

        $data['page_title'] = 'Mata Kuliah';
        $data['kode_semester'] = $this->input->get('kode_semester');
        $data['kode_angkatan'] = $this->input->get('kode_angkatan');

        $data['tools'] = array(
            'laporan/laporan_daftar_matakuliah_paket/create' => 'New'
        );

        $this->load->view('laporan/laporan_daftar_matakuliah_paket/laporan_daftar_matakuliah_paket', $data);
    }

    function search() {
        $query_array = array(
            'kode_mata_kuliah' => $this->input->post('kode_mata_kuliah')==0?"":$this->input->post('kode_mata_kuliah'),
            'nama_mata_kuliah' => $this->input->post('nama_mata_kuliah')==0?"":$this->input->post('nama_mata_kuliah'),
            'kode_semester' => $this->input->post('kode_semester'),
            'kode_angkatan' => $this->input->post('kode_angkatan'),
            'active' => 1
        );
        $query_id = $this->input->save_query($query_array);
        redirect("laporan/laporan_daftar_matakuliah_paket/view/$query_id");
    }

	public function report(){
		$tinggi_gambar = 30;
	    $lebar_gambar = 35;

	    $this->load->library( 'tcpdf' );
	    $pdf = tcpdf();

	    // set document information
	    
	     $query_array = array(
		    'nama_dosen' => '',
		    'nama_ruang' => '',
		    'kode_mata_kuliah' => '',
		    'nama_mata_kuliah' => '',
		    'kode_semester' => $this->input->post('kode_semester'),
		    'kode_angkatan' => $this->input->post('kode_angkatan'),
		    'active' => 1
		);


	    $this->load->model('mata_kuliah_model', 'mata_kuliah');

	    $jumlah_matakuliah = $this->mata_kuliah->count_mata_kuliah($query_array);

            $results = $this->mata_kuliah->search($query_array, $jumlah_matakuliah, 0, "nama_matakuliah", 'asc');

	    $dt = $results['results'];
	
	    $res = array();

	    foreach ($dt->result() as $row) {
		$res[$row->nama_angkatan."-".$row->semester]['data'][] = array("nama_mata_kuliah" => $row->nama_mata_kuliah,
								      "sks" => $row->sks_mata_kuliah
								      
									);
		$res[$row->nama_angkatan."-".$row->semester]['attribute'] = array(
								      "kode_semester" => $row->semester,
								      "kode_angkatan" => $row->nama_angkatan,
			 					      "tinggi_gambar" => $tinggi_gambar,
			  					      "lebar_gambar" => $lebar_gambar
									);
		$res[$row->nama_angkatan."-".$row->semester]['jumlah_sks'] = empty($res[$row->nama_angkatan."-".$row->semester]['jumlah_sks']) ? "0" :$res[$row->nama_angkatan."-".$row->semester]['jumlah_sks']; 
		$res[$row->nama_angkatan."-".$row->semester]['jumlah_sks'] += $row->sks_mata_kuliah;
	    }
	
	    foreach($res as $data_row){
		//var_dump($data_row);
		$this->load->view("laporan/laporan_daftar_matakuliah_paket/report", array("data" => $data_row, "pdf" => $pdf), true);
	    }
		//exit;
	    /*$data = array("pdf" => $pdf,
			  "tinggi_gambar" => $tinggi_gambar,
			  "kode_semester" => $this->input->post('kode_semester'),
			  "kode_angkatan" => $this->input->post('kode_angkatan'),
			  "results" => $results['results'],
			  "lebar_gambar" => $lebar_gambar
			);
	     
	    $this->load->view("laporan/laporan_daftar_matakuliah_paket/report", $data, true);*/
	    //Close and output PDF document
	    $pdf->Output('Mata Kuliah Semester.pdf', 'I');
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
