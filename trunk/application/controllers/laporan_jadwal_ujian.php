<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Laporan_jadwal_ujian extends CI_Controller {
	function __construct() {
        parent::__construct();
        $this->load->helper(array('snippets_helper'));
        $this->load->model('crud_model', 'crud');
    }
	function log_date() {
        return date($this->config->item('log_date_format'));
    }

    function index($query_id = 0, $sort_by = 'tanggal, waktu_mulai, waktu_selesai', $sort_order = 'asc', $offset = 0) {
        $this->jadwal_ujian($query_id, $sort_by, $sort_order, $offset);
    }

    function jadwal_ujian($query_id = 0, $sort_by = 'tanggal, waktu_mulai, waktu_selesai', $sort_order = 'asc', $offset = 0) {
        $data_type = $this->input->post('data_type');
        $data['auth'] = $this->auth;
        // pagination
        $limit = 20;
        $this->load->library(array('form_validation', 'table', 'pagination'));
        $this->input->load_query($query_id);
        $query_array = array(
            'nama_dosen' => $this->input->get('nama_dosen'),
            'nama_ruang' => $this->input->get('nama_ruang'),
            'kode_semester' => $this->input->get('kode_semester'),
            'kode_angkatan' => $this->input->get('kode_angkatan'),
            'minggu' => $this->input->get('minggu'),
            'active' => 1
        );

        $this->load->model('jadwal_ujian_model', 'jadwal_ujian');
        $results = $this->jadwal_ujian->search($query_array, $limit, $offset, $sort_by, $sort_order);
        //echo get_instance()->db->last_query();
        $data['results'] = $results['results'];
        $data['num_results'] = $results['num_rows'];

        // pagination
        $config = array();
        $config['base_url'] = site_url("laporan/laporan_jadwal_ujian/$query_id/$sort_by/$sort_order");
        $config['total_rows'] = $data['num_results'];
        $config['per_page'] = $limit;
        $config['uri_segment'] = 6;
        $config['num_links'] = 6;

        $config = array_merge($config, default_pagination_btn());
        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();
        $data['sort_by'] = $sort_by;
        $data['sort_order'] = $sort_order;

        $data['page_title'] = 'Jadwal Ujian';
        $data['minggu'] = $this->input->get('minggu');
        $data['kode_semester'] = $this->input->get('kode_semester');
        $data['kode_angkatan'] = $this->input->get('kode_angkatan');

        $data['tools'] = array(
            //'laporan/laporan_jadwal_ujian/create' => 'New'
        );

        $this->load->view('laporan/laporan_jadwal_ujian/laporan_jadwal_ujian', $data);
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
        redirect("laporan/laporan_jadwal_ujian/view/$query_id");
    }
	public function report()
	{
	    $tinggi_gambar = 25;
	    $lebar_gambar = 25;
	    $this->load->library( 'tcpdf' );
	    $pdf = tcpdf();
	    $this->load->model('jadwal_ujian_model', 'jadwal_ujian');
	    $query_array = array(
		    'nama_dosen' => '',
		    'nama_ruang' => '',
		    'kode_mata_kuliah' => '',
		    'nama_mata_kuliah' => '',
		    'kode_semester' => $this->input->post('kode_semester'),
		    'kode_angkatan' => $this->input->post('kode_angkatan'),
		    'minggu' => $this->input->post('minggu'),
		    'active' => 1
		);

	    $jumlah_matakuliah = $this->jadwal_ujian->count_jadwal_ujian($query_array);
		//function search($query_array, $limit, $offset, $sort_by='id', $sort_order) {
		//order by tanggal, jam_mulai, jam_selesai
		$results = $this->jadwal_ujian->search($query_array, $jumlah_matakuliah, 0, "tanggal, waktu_mulai, waktu_selesai", 'asc');
	    $dt = $results['results'];	 
	
	    $res = array();
	    $res['data'] = array();
		$i=1;
	    foreach ($dt->result() as $row) {
			// Inisialisasi
			if(empty($res['data'][$row->nama_hari]['nama_mata_kuliah']))
				$res['data'][$row->nama_hari]['nama_mata_kuliah'] = '';
			if(empty($res['data'][$row->nama_hari]['jam']))
				$res['data'][$row->nama_hari]['jam'] = '';
			if(empty($res['data'][$row->nama_hari]['metode']))
				$res['data'][$row->nama_hari]['metode'] = '';
			if(empty($res['data'][$row->nama_hari]['nama_dosen']))
				$res['data'][$row->nama_hari]['nama_dosen'] = '';
			if(empty($res['data'][$row->nama_hari]['nama_ruang']))
				$res['data'][$row->nama_hari]['nama_ruang'] = '';
			// data
			if(!empty($row->nama_hari)){
				
				$res['data'][$row->nama_hari]['hari'] = $row->nama_hari."<br/>".date('d-M-Y',strtotime($row->tanggal));
				$res['data'][$row->nama_hari]['nama_mata_kuliah'] .= $row->nama_mata_kuliah."<br/>";
				$res['data'][$row->nama_hari]['jam'] .= date('H:i',strtotime($row->tanggal." ".$row->waktu_mulai))." - ".date('H:i',strtotime($row->tanggal." ".$row->waktu_selesai))."<br/>";
				$res['data'][$row->nama_hari]['metode'] .= $row->kode_ujian."<br/>";
				$res['data'][$row->nama_hari]['nama_dosen'] .= $row->nama_dosen."<br/>";
				$res['data'][$row->nama_hari]['nama_ruang'] .= $row->nama_ruang."<br/>";
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
	    $this->load->view("laporan/laporan_jadwal_ujian/report", $data, true);
	    //Close and output PDF document
	    $pdf->Output('JADWAL UJIAN', 'I');
	}
	
	function ConvertRomawi($n){
		$hasil = '';
		$iromawi = array('','I','II','III','IV','V','VI','VII','VIII','IX','X',20=>'XX',30=>'XXX',40=>'XL',50=>'L',
			60=>'LX',70=>'LXX',80=>'LXXX',90=>'XC',100=>'C',200=>'CC',300=>'CCC',400=>'CD',500=>'D',600=>'DC',700=>'DCC',
			800=>'DCCC',900=>'CM',1000=>'M',2000=>'MM',3000=>'MMM');
		if(array_key_exists($n,$iromawi)){
			$hasil = $iromawi[$n];
		}elseif($n >= 11 && $n <= 99){
			$i = $n % 10;
			$hasil = $iromawi[$n-$i] . Romawi($n % 10);
		}elseif($n >= 101 && $n <= 999){
			$i = $n % 100;
			$hasil = $iromawi[$n-$i] . Romawi($n % 100);
		}else{
			$i = $n % 1000;
			$hasil = $iromawi[$n-$i] . Romawi($n % 1000);
		}
		return $hasil;
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
