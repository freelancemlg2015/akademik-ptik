<?php

/*
 * Imam Syarifudin
 * Master Tugas Imam : Data Dosen
 * 9/9/2012
 */

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class laporan_daftar_dosen extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->helper(array('snippets_helper'));
        $this->load->model('crud_model', 'crud');
    }

    function log_date() {
        return date($this->config->item('log_date_format'));
    }

    function index($query_id = 0, $sort_by = 'id', $sort_order = 'desc', $offset = 0) {
        $this->dosen($query_id, $sort_by, $sort_order, $offset);
    }

    function dosen($query_id = 0, $sort_by = 'id', $sort_order = 'desc', $offset = 0) {
        $data_type = $this->input->post('data_type');
        $data['auth'] = $this->auth;
        // pagination
        $limit = 20;
        $this->load->library(array('form_validation', 'table', 'pagination'));
        $this->input->load_query($query_id);
        $query_array = array(
            'no_karpeg_dosen' => $this->input->get('no_karpeg_dosen'),
            'nama_dosen' => $this->input->get('nama_dosen'),
            'prodi' => $this->input->get('prodi'),
            'kode_angkatan' => $this->input->get('kode_angkatan'),
            'active' => 1
        );

        $this->load->model('dosen_model', 'dosen');
        $results = $this->dosen->search($query_array, $limit, $offset, $sort_by, $sort_order);
        //echo get_instance()->db->last_query();
        $data['results'] = $results['results'];
        $data['num_results'] = $results['num_rows'];

        // pagination
        $config = array();
        $config['base_url'] = site_url("laporan/laporan_daftar_dosen/$query_id/$sort_by/$sort_order");
        $config['total_rows'] = $data['num_results'];
        $config['per_page'] = $limit;
        $config['uri_segment'] = 6;
        $config['num_links'] = 6;

        $config = array_merge($config, default_pagination_btn());
        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();
        $data['sort_by'] = $sort_by;
        $data['sort_order'] = $sort_order;

        $data['page_title'] = 'Dosen';
        $data['prodi'] = $this->input->get('prodi');
        $data['kode_angkatan'] = $this->input->get('kode_angkatan');

        $data['tools'] = array(
            'laporan/laporan_daftar_dosen/create' => 'New'
        );

        $this->load->view('laporan/laporan_daftar_dosen/laporan_daftar_dosen', $data);
    }

    function search() {
        $query_array = array(
            'no_karpeg_dosen' => '',
            'nama_dosen' => '',
            'prodi' => $this->input->post('prodi'),
            'kode_angkatan' => $this->input->post('kode_angkatan'),
            'active' => 1
        );
        $query_id = $this->input->save_query($query_array);
        redirect("laporan/laporan_daftar_dosen/view/$query_id");
    }

    public function report(){
	    $tinggi_gambar = 25;
	    $lebar_gambar = 25;

	    $this->load->library( 'tcpdf' );
	    $pdf = new daftar_mahasiswa();
	    $pdf->init($this->input->post('kode_angkatan'), $tinggi_gambar, $lebar_gambar);

		$query_array = array(
		    'no_karpeg_dosen' => '',
		    'nama_dosen' => '',
		    'prodi' => $this->input->post('prodi'),
		    'kode_angkatan' => $this->input->post('kode_angkatan'),
		    'active' => 1
		);

		$this->load->model('dosen_model', 'dosen');
		$jumlah_dosen = $this->dosen->count_dosen($query_array);
		$results = $this->dosen->search($query_array, $jumlah_dosen, 0, 'id', 'asc');

		$dt = $results['results'];
		$rs = array();

		$rs = array("pdf" => $pdf,
			  "lebar_gambar" => "25",
			  "tinggi_gambar" => "25",
		    	  'prodi' => $this->input->post('prodi'),
		    	  'jumlah_dosen' => $jumlah_dosen,
		    	  'kode_angkatan' => $this->input->post('kode_angkatan')
			);

		foreach ($dt->result() as $row) {
			$rs['data'][$row->angkatan_id][] = array("nama_dosen" => $row->nama_dosen,
								 "nip_pns" => $row->nip_pns,
								 "kode_angkatan" => $row->kode_angkatan,
								 "nama_pangkat" => $row->nama_pangkat
								); 
		}			
	    	
		
		foreach($rs['data'] as $row){
			$rs['results'] = $row;
			$rs['jumlah_dosen'] = count($row);
		    	$this->load->view("laporan/laporan_daftar_dosen/report", $rs, true);
		}
	    //Close and output PDF document
	    $pdf->Output('DAFTAR DOSEN', 'I');
	}
}

?>
