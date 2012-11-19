<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
class Laporan_kalender_akademik extends CI_Controller {

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

    function index($query_id = 0, $sort_by = 'plot_semester_id, nama_kegiatan', $sort_order = 'asc', $offset = 0) {
        $this->kalender_akademik($query_id, $sort_by, $sort_order, $offset);
    }

    function kalender_akademik($query_id = 0, $sort_by = 'plot_semester_id, nama_kegiatan', $sort_order = 'asc', $offset = 0) {
        $data_type = $this->input->post('data_type');
		
        $data['auth'] = $this->auth;
        // pagination
        $limit = 20;
        $this->load->library(array('form_validation', 'table', 'pagination'));
        $this->input->load_query($query_id);
        $query_array = array(
            'plot_semester_id' => $this->input->get('plot_semester_id'),
            'tgl_mulai_kegiatan' => $this->input->get('tgl_mulai_kegiatan'),
            'tgl_akhir_kegiatan' => $this->input->get('tgl_akhir_kegiatan'),
            'nama_kegiatan' => $this->input->get('nama_kegiatan'),
            'active' => 1
        );

        $this->load->model('kalender_akademik_model', 'kalender_akademik');
        $results = $this->kalender_akademik->search($query_array, $limit, $offset, $sort_by, $sort_order);
        //echo get_instance()->db->last_query();
        $data['results'] = $results['results'];
        $data['num_results'] = $results['num_rows'];

        // pagination
        $config = array();
        $config['base_url'] = site_url("laporan/laporan_kalender_akademik/$query_id/$sort_by/$sort_order");
        $config['total_rows'] = $data['num_results'];
        $config['per_page'] = $limit;
        $config['uri_segment'] = 6;
        $config['num_links'] = 6;

        $config = array_merge($config, default_pagination_btn());
        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();
        $data['sort_by'] = $sort_by;
        $data['sort_order'] = $sort_order;

        $data['page_title'] = 'Kalender Akademik';
        $data['plot_semester_id'] = $this->input->get('plot_semester_id');
        $data['nama_kegiatan'] = $this->input->get('nama_kegiatan');
        $data['nama_kegiatan'] = $this->input->get('nama_kegiatan');

        $data['tools'] = array(
            //'laporan/laporan_jadwal_perkuliahan/create' => 'New'
        );

        $this->load->view('laporan/laporan_kalender_akademik/laporan_kalender_akademik', $data);
    }

    function search() {
        $query_array = array(
            'nama_dosen' => '',
            'nama_ruang' => '',
            'kode_semester' => $this->input->post('kode_semester'),
            'kode_angkatan' => $this->input->post('kode_angkatan'),
            'minggu' => $this->input->post('minggu'),
            'active' => 1
        );
        $query_id = $this->input->save_query($query_array);
        redirect("laporan/laporan_kalender_akademik/view/$query_id");
    }
	public function report()
	{
	    $tinggi_gambar = 25;
	    $lebar_gambar = 25;
	    $this->load->library( 'tcpdf' );
	    $pdf = tcpdf();
	    $this->load->model('kalender_akademik_model', 'kalender_akademik');
	    $query_array = array(
		    'nama_kegiatan' => '',
		    'nama_kegiatan' => '',
		    'nama_kegiatan' => $this->input->post('nama_kegiatan'),
		    'nama_kegiatan' => $this->input->post('nama_kegiatan'),
		    'active' => 1
		);

	    $jumlah_matakuliah = $this->kalender_akademik->count_kalender_akademik($query_array);
		//function search($query_array, $limit, $offset, $sort_by='id', $sort_order) {
		//order by tanggal, jam_mulai, jam_selesai
		$results = $this->kalender_akademik->search($query_array, $jumlah_matakuliah, 0, "plot_semester_id, nama_kegiatan", 'asc');
	    $dt = $results['results'];	 
	
	    $res = array();
	    $res['data'] = array();
		$i=1;
	    foreach ($dt->result() as $row) {
			// Inisialisasi
			if(empty($res['data'][$row->nama_kegiatan]['nama_kegiatan']))
				$res['data'][$row->nama_kegiatan]['nama_kegiatan'] = '';
			if(empty($res['data'][$row->nama_kegiatan]['nama_kegiatan']))
				$res['data'][$row->nama_kegiatan]['nama_kegiatan'] = '';
			if(empty($res['data'][$row->nama_kegiatan]['nama_kegiatan']))
				$res['data'][$row->nama_kegiatan]['nama_kegiatan'] = '';
			// data
			if(!empty($row->nama_kegiatan)){
				if($row->nama_kegiatan==0) {
					$display_event = $row->nama_kegiatan;
					//$display_unit = $this->ConvertRomawi($i);
					$i++;
				} else {
					$display_event = $row->nama_kegiatan;
					//$display_unit = '&nbsp;';
				}
				$res['data'][$row->nama_kegiatan]['nama_kegiatan'] = $row->nama_kegiatan."<br/>";
				//$res['data'][$row->nama_kegiatan]['nama_kegiatan'] .= $display_event."<br/>";
				//$res['data'][$row->nama_kegiatan]['nama_kegiatan'] .= $display_unit."<br/>";
			}
			
			$res['attribute'] = array(
										  "kode_semester" => $this->input->post('kode_semester'),
										  "kode_angkatan" => $this->input->post('kode_angkatan'),
										  "minggu" => $this->input->post('minggu'),
										  "tinggi_gambar" => $tinggi_gambar,
										  "lebar_gambar" => $lebar_gambar
										);
		}
	    $res['pdf'] = $pdf;
	    $data = $res;
	    $this->load->view("laporan/laporan_kalender_akademik/report", $data, true);
	    //Close and output PDF document
	    $pdf->Output('KALENDER AKADEMIK', 'I');
	}

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
