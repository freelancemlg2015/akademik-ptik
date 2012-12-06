<?php

/*
 * Imam Syarifudin
 * Transaction Kurikulum : Paket Matakuliah
 * 5/9/2012
 */

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Paket_matakuliah extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->helper(array('snippets_helper'));
        $this->load->model('crud_model', 'crud');
    }

    function log_date() {
        return date($this->config->item('log_date_format'));
    }

    function index($query_id = 0, $sort_by = 'id', $sort_order = 'desc', $offset = 0) {
        $this->paket_matakuliah($query_id, $sort_by, $sort_order, $offset);
    }

    function paket_matakuliah($query_id = 0, $sort_by = 'id', $sort_order = 'desc', $offset = 0) {
        $data_type    = $this->input->post('data_type');
        $data['auth'] = $this->auth;
        // pagination
        $limit = 20;
        $this->load->library(array('form_validation', 'table', 'pagination'));
        $this->input->load_query($query_id);
        $query_array = array(
            'nama_angkatan'    => $this->input->get('nama_angkatan'),
            'nama_semester'    => $this->input->get('nama_semester'),
            'active'           => 1
        );

        $this->load->model('paket_matakuliah_model', 'paket_matakuliah');
        $results = $this->paket_matakuliah->search($query_array, $limit, $offset, $sort_by, $sort_order);
        //echo get_instance()->db->last_query();
        $data['results']     = $results['results'];
        $data['num_results'] = $results['num_rows'];

        // pagination
        $config = array();
        $config['base_url']    = site_url("transaction/paket_matakuliah/$query_id/$sort_by/$sort_order");
        $config['total_rows']  = $data['num_results'];
        $config['per_page']    = $limit;
        $config['uri_segment'] = 6;
        $config['num_links']   = 6;

        $config = array_merge($config, default_pagination_btn());
        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();
        $data['sort_by']    = $sort_by;
        $data['sort_order'] = $sort_order;

        $data['page_title'] = 'Paket Matakuliah';

        $data['tools'] = array(
            'transaction/paket_matakuliah/create' => 'New'
        );

        $this->load->view('transaction/paket_matakuliah', $data);
    }

    function search() {
        $query_array = array(
            'nama_angkatan'    => $this->input->post('nama_angkatan'),
            'nama_semester'    => $this->input->post('nama_semester'),
            'active'           => 1
        );
        $query_id = $this->input->save_query($query_array);
        redirect("transaction/paket_matakuliah/view/$query_id");
    }

    function info() {
        $id = $this->uri->segment(3);
        $data['auth'] = $this->auth;
        $criteria = array(
            't_paket_mata_kuliah.id' => $id
        );
        $this->load->model('paket_matakuliah_model', 'paket_matakuliah');
        $result = $this->paket_matakuliah->get_many('', $criteria)->row_array();
        //[debug]echo get_instance()->db->last_query();
        $result_keys = array_keys($result);
        foreach ($result_keys as $result_key) {
            $data[$result_key] = $result[$result_key];
        }
        
        $this->load->model('paket_matakuliah_model');
        $data['paket_detil_options'] = $this->paket_matakuliah_model->get_paket_matakuliah_detil($id);
        
        $data['tools'] = array(
            'transaction/paket_matakuliah' => 'Back',
            'transaction/paket_matakuliah/' . $id . '/edit' => 'Edit',
            'transaction/paket_matakuliah/' . $id . '/delete' => 'Delete'
        );
        $data['page_title'] = 'Detail Paket Matakuliah';
        $this->load->view('transaction/paket_matakuliah_info', $data);
    }

    function delete() {
        $id = $this->uri->segment(3);
        $this->crud->use_table('t_paket_mata_kuliah');
        $criteria = array('id' => $id);
        $data_in = array(
            'active'      => 0,
            'modified_on' => logged_info()->on,
            'modified_by' => logged_info()->by
        );
        $this->crud->update($criteria, $data_in);
        redirect('transaction/paket_matakuliah');
    }

    function create() {      
        $data['auth'] = $this->auth;
        $data['action_type'] = __FUNCTION__;
        $transaction_url = 'transaction/paket_matakuliah/';

        $this->load->library(array('form_validation', 'table'));
        $this->load->helper(array('form', 'snippets'));
        $this->form_validation->set_error_delimiters('<span class="notice">', '</span>');
        if ($this->form_validation->run('paket_matakuliah_create') === FALSE) {
            //don't do anything
        } else {
                                                       
            $kelompok = $this->input->post('kelompok_mata_kuliah_id'); 
            for($t=0; $t< count($kelompok); $t++){
                $pt = explode('-', $kelompok[$t]);    
                if(is_array($pt)){
                    if($t==0){
                        $this->crud->use_table('t_paket_mata_kuliah');
                        $data_in = array(
                            'angkatan_id'        => $this->input->post('angkatan_id'), 
                            'program_studi_id'   => $this->input->post('program_studi_id'),
                            'plot_mata_kuliah_id'=> $pt[1],                           
                            'created_on'         => date($this->config->item('log_date_format')),
                            'created_by'         => logged_info()->on
                        );                   
                        $created_id = $this->crud->create($data_in);
                    }
                        $this->crud->use_table('t_paket_mata_kuliah_detail');
                        $data_in_query = array(
                            'paket_mata_kuliah_id'    => $created_id,
                            'kelompok_mata_kuliah_id' => $pt[0],
                            'plot_mata_kuliah_id'     => $pt[1],
                            'created_on'              => date($this->config->item('log_date_format')),
                            'created_by'              => logged_info()->on 
                        );
                        $this->crud->create($data_in_query);
                }
            }
            redirect('transaction/paket_matakuliah/' . $created_id . '/info');
        }
        $data['action_url'] = $transaction_url . __FUNCTION__;
        $data['page_title'] = 'Create Paket Mata Kuliah';
        $data['tools'] = array(
            'transaction/paket_matakuliah' => 'Back'
        );
        
        $this->load->model('paket_matakuliah_model');
        $data['angkatan_options'] = $this->paket_matakuliah_model->get_angkatan();
                                                                                                                                                                                                      
        //$this->load->model('paket_matakuliah_model');
        $data['plot_mata_kuliah_options'] = ''; //$this->paket_matakuliah_model->get_semester();
               
        $this->crud->use_table('m_program_studi');
        $data['program_studi_options'] = $this->crud->retrieve()->result();
        
        $this->crud->use_table('m_kelompok_matakuliah');
        $data['kelompok_matakuliah_options'] = $this->crud->retrieve()->result();
        
        $this->crud->use_table('t_paket_mata_kuliah_detail');
        $data['paket_mata_kuliah_detil_options'] = $this->crud->retrieve()->result();
        
        $data['matakuliah_detil_options'] = '';
        $data['thn_akademik_id_attr'] = '';
        $data['semester_id_attr'] = '';                                                   
        
        $this->crud->use_table('m_angkatan');
        $data['m_angkatan'] = '';
        $this->load->model('paket_matakuliah_model');
        $data['m_tahun_akademik'] = $this->paket_matakuliah_model->get_tahun_angkatan();
        
        $this->load->model('paket_matakuliah_model', 'paket_matakuliah');
        $data = array_merge($data, $this->paket_matakuliah->set_default()); //merge dengan arr data dengan default
        
        $this->load->view('transaction/paket_matakuliah_form', $data);
    }

    function edit() {
        $data['auth']        = $this->auth;
        $data['action_type'] = __FUNCTION__;
        $master_url          = 'transaction/paket_matakuliah/';
        $id                  = $this->uri->segment(3);

        $this->load->library(array('form_validation', 'table'));
        $this->load->helper(array('form', 'snippets'));
        $this->form_validation->set_error_delimiters('<span class="notice">', '</span>');
        if ($this->form_validation->run('paket_matakuliah_update') === FALSE) {
            //don't do anything
        } else {
            $kelompok = $this->input->post('kelompok_mata_kuliah_id');
            for($t=0; $t< count($kelompok); $t++){
                $pr = explode("-", $kelompok[$t]);
                if(is_array($pr)){
                    if($t==0){
                        $this->crud->use_table('t_paket_mata_kuliah');
                        $criteria = array(
                            'id' => $id
                        );
                        $data_in = array(
                            'angkatan_id'             => $this->input->post('angkatan_id'),
                            'program_studi_id'        => $this->input->post('program_studi_id'),
                            'plot_mata_kuliah_id'     => $pr[1],                          
                            'modified_on'             => date($this->config->item('log_date_format')),
                            'modified_by'             => logged_info()->on
                        );
                        $this->crud->update($criteria, $data_in);
                        $this->load->model('paket_matakuliah_model');
                        $this->paket_matakuliah_model->delete_detail($id);    
                    }
                        $this->crud->use_table('t_paket_mata_kuliah_detail');
                        $data_in_query = array(
                            'paket_mata_kuliah_id'    => $id,
                            'kelompok_mata_kuliah_id' => $pr[0],
                            'plot_mata_kuliah_id'     => $pr[1],
                            'modified_on'             => date($this->config->item('log_date_format')),
                            'modified_by'             => logged_info()->on
                        );                       
                        $this->crud->create($data_in_query);                   
                }                
            }
            redirect('transaction/paket_matakuliah/' . $id . '/info');
        }
        $data['action_url'] = $master_url . $id . '/' . __FUNCTION__;
        $data['page_title'] = 'Update Paket Matakuliah';
        $data['tools']      = array(
            'transaction/paket_matakuliah' => 'Back'
        );
        
        $this->crud->use_table('t_paket_mata_kuliah');
        $paket_matakuliah_data = $this->crud->retrieve(array('id' => $id))->row();
        
        $this->load->model('paket_matakuliah_model');
        $data['angkatan_options'] = $this->paket_matakuliah_model->get_angkatan();                  
                                                                              
        $this->crud->use_table('m_program_studi');
        $data['program_studi_options'] = $this->crud->retrieve()->result();
                                                                                   
        $this->crud->use_table('t_plot_mata_kuliah');
        $data['plot_mata_kuliah_options'] = $this->crud->retrieve()->result();
        
        $this->crud->use_table('t_paket_mata_kuliah_detail');
        $data['paket_mata_kuliah_detil_options'] = $this->crud->retrieve()->result();
                                                                                                              
        $this->load->model('paket_matakuliah_model', 'paket_matakuliah');
        $data = array_merge($data, $this->paket_matakuliah->set_default()); //merge dengan arr data dengan default
        $data = array_merge($data, (array) $paket_matakuliah_data);
        if (!(empty($id))){
            $this->crud->use_table('m_angkatan');
            $data['m_angkatan'] = $this->crud->retrieve(array('id' => $data['angkatan_id']))->row();
            $this->load->model('paket_matakuliah_model');
            $data['m_tahun_akademik'] = $this->paket_matakuliah_model->get_tahun_angkatan($data['m_angkatan']->tahun_akademik_id);
            
            $thn_akademik_id_attr = '';
            foreach ($data['m_tahun_akademik'] as $row) {
                $thn_akademik_id_attr = $row['tahun_ajar_mulai'].'-'.$row['tahun_ajar_akhir'];
            }                
            $data['thn_akademik_id_attr'] = $thn_akademik_id_attr;
            
            $this->crud->use_table('t_plot_mata_kuliah');
            $data['t_plot_mata_kuliah'] = $this->crud->retrieve(array('id' => $data['plot_mata_kuliah_id']))->row();
            $this->load->model('paket_matakuliah_model');
            $data['semester_data_options'] = $this->paket_matakuliah_model->get_semester($data['t_plot_mata_kuliah']->angkatan_id);
                       
            $this->crud->use_table('t_plot_mata_kuliah');
            $data['t_plot_semester'] = $this->crud->retrieve(array('id' => $data['plot_mata_kuliah_id']))->row();
			$this->load->model('paket_matakuliah_model');                                                                      
            $plot_mata_semester = $this->paket_matakuliah_model->get_update_semester($data['t_plot_semester']->semester_id);
            $plot_paket_semester = '';
            foreach($plot_mata_semester  as $row){
                $plot_paket_semester .= $row['group_id'];
            }
            $data['semester_id_attr'] = $plot_paket_semester ;    
            
            $this->crud->use_table('t_plot_mata_kuliah');
            $data['t_plot_mata_kuliah'] = $this->crud->retrieve(array('id' => $data['plot_mata_kuliah_id']))->row();
            $this->load->model('paket_matakuliah_model');
            $detail_plot = $this->paket_matakuliah_model->get_plot_matakuliah($data['t_plot_mata_kuliah']->semester_id);
            $this->load->model('paket_matakuliah_model');
            $matakuliah_detil_options = $this->paket_matakuliah_model->get_matakuliah_detil($id);
            
            $plot_opt = '';
            foreach($detail_plot as $row){
                @$checked = in_array($row['kelompok_mata_kuliah_id'], $matakuliah_detil_options) ? "checked='checked'" : "";
                $plot_opt .= "<tr>
                       <td><input type='checkbox' $checked name='kelompok_mata_kuliah_id[]' value=".$row['kelompok_mata_kuliah_id'].'-'.$row['id'].">"."&nbsp;&nbsp;".$row['nama_kelompok_mata_kuliah']."</td><br>
                  </tr>";
            }
            $data['plot_detail_checked'] = $plot_opt;                                                      
          
        }   
        $this->load->view('transaction/paket_matakuliah_form', $data);
    }
    
    function getOptTahunAkademik() {
        $angkatan_id= $this->input->post('angkatan_id');
		$sql = "select distinct a.tahun_ajar_mulai, a.tahun_ajar_akhir from akademik_m_tahun_akademik a ".
				" left join akademik_m_angkatan b on b.tahun_akademik_id=a.id ".
				"where a.active ='1' and b.tahun_akademik_id='$angkatan_id'";
        $query = $this->db->query($sql);
		//echo  '<pre>'.$this->db->last_query().'</pre><br>';
        foreach($query->result_array() as $row){
            echo $row['tahun_ajar_mulai'].'-'.$row['tahun_ajar_akhir'];
        }
    }
         
    function getOptSemester(){
        $this->load->model('paket_matakuliah_model');
        $angkatan_id = $this->input->post('angkatan_id');
        $semester = $this->paket_matakuliah_model->get_semester($angkatan_id);
        echo '<option value="" ></option>';
        foreach($semester as $row){
            echo '<option value=\''.$row['group_id'].'\' >'.$row['nama_semester'].'</option>';
        } 
    }
    
    function getOptKelompokMatakuliah(){          
        $this->load->model('paket_matakuliah_model');
        $angkatan = $this->input->post('angkatan_id');
        $semester = $this->input->post('span_semester');
        $data = $this->paket_matakuliah_model->get_kelompok_mata_kuliah($angkatan,$semester);
        //print_r($kelompok_mata_kuliah_id);
        foreach($data as $row){
            @$checked = in_array($row['kelompok_mata_kuliah_id'], $mata_detil_options) ? "checked='checked'" : "";
            echo "<tr>
                   <td><input type='checkbox' $checked name='kelompok_mata_kuliah_id[]' value=".$row['kelompok_mata_kuliah_id'].'-'.$row['id'].">"."&nbsp;&nbsp;".$row['nama_kelompok_mata_kuliah']."</td>
              </tr>";
                        
        }
    }
}

?>
