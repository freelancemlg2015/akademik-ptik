<?php

/*
 * Imam Syarifudin
 * Transaction Kurikulum : Paket Matakuliah
 * 5/9/2012
 */

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Rencana_mata_pelajaran extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->helper(array('snippets_helper'));
        $this->load->model('crud_model', 'crud');
    }

    function log_date() {
        return date($this->config->item('log_date_format'));
    }

    function index($query_id = 0, $sort_by = 'id', $sort_order = 'desc', $offset = 0) {
        $this->rencana_mata_pelajaran($query_id, $sort_by, $sort_order, $offset);
    }

    function rencana_mata_pelajaran($query_id = 0, $sort_by = 'id', $sort_order = 'desc', $offset = 0) {
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

        $this->load->model('rencana_mata_pelajaran_model', 'rencana_mata_pelajaran');
        $results = $this->rencana_mata_pelajaran->search($query_array, $limit, $offset, $sort_by, $sort_order);
        //echo get_instance()->db->last_query();
        $data['results']     = $results['results'];
        $data['num_results'] = $results['num_rows'];

        // pagination
        $config = array();
        $config['base_url']    = site_url("transaction/rencana_mata_pelajaran/$query_id/$sort_by/$sort_order");
        $config['total_rows']  = $data['num_results'];
        $config['per_page']    = $limit;
        $config['uri_segment'] = 6;
        $config['num_links']   = 6;

        $config = array_merge($config, default_pagination_btn());
        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();
        $data['sort_by']    = $sort_by;
        $data['sort_order'] = $sort_order;

        $data['page_title'] = 'Rencana Mata Pelajaran';

        $data['tools'] = array(
            'transaction/rencana_mata_pelajaran/create' => 'New'
        );

        $this->load->view('transaction/rencana_mata_pelajaran', $data);
    }

    function search() {
        $query_array = array(
            'nama_angkatan'    => $this->input->post('nama_angkatan'),
            'nama_semester'    => $this->input->post('nama_semester'),
            'active'         => 1
        );
        $query_id = $this->input->save_query($query_array);
        redirect("transaction/rencana_mata_pelajaran/view/$query_id");
    }

    function info() {
        $id = $this->uri->segment(3);
        $data['auth'] = $this->auth;
        $criteria = array(
            't_rencana_mata_pelajaran_pokok.id' => $id
        );
        $this->load->model('rencana_mata_pelajaran_model', 'rencana_mata_pelajaran');
        $result = $this->rencana_mata_pelajaran->get_many('', $criteria)->row_array();
        //[debug]echo get_instance()->db->last_query();
        $result_keys = array_keys($result);
        foreach ($result_keys as $result_key) {
            $data[$result_key] = $result[$result_key];
        }
        
        $this->load->model('rencana_mata_pelajaran_model');
        $data['mata_kuliah_info'] = $this->rencana_mata_pelajaran_model->get_matakuliah_info($id);
        
        $this->load->model('rencana_mata_pelajaran_model');
        $data['mahasiswa_info'] = $this->rencana_mata_pelajaran_model->get_mahawasiswa_info($id);

        $data['tools'] = array(
            'transaction/rencana_mata_pelajaran' => 'Back',
            'transaction/rencana_mata_pelajaran/' . $id . '/edit' => 'Edit',
            'transaction/rencana_mata_pelajaran/' . $id . '/delete' => 'Delete'
        );
        $data['page_title'] = 'Detail Rencana Mata Pelajaran';
        $this->load->view('transaction/rencana_mata_pelajaran_info', $data);
    }

    function delete() {
        $id = $this->uri->segment(3);
        $this->crud->use_table('t_rencana_mata_pelajaran_pokok');
        $criteria = array('id' => $id);
        $data_in = array(
            'active'      => 0,
            'modified_on' => logged_info()->on,
            'modified_by' => logged_info()->by
        );
        $this->crud->update($criteria, $data_in);
        redirect('transaction/rencana_mata_pelajaran');
    }

    function create() {
        $data['auth'] = $this->auth;
        $data['action_type'] = __FUNCTION__;
        $transaction_url = 'transaction/rencana_mata_pelajaran/';

        $this->load->library(array('form_validation', 'table'));
        $this->load->helper(array('form', 'snippets'));
        $this->form_validation->set_error_delimiters('<span class="notice">', '</span>');
        if ($this->form_validation->run('rencana_mata_pelajaran_create') === FALSE) {
            //don't do anything
        } else {
            $this->crud->use_table('t_rencana_mata_pelajaran_pokok');
                $data_in = array(
                    'angkatan_id'         => $this->input->post('angkatan_id'),     
                    'mata_kuliah_id'      => $this->input->post('mata_kuliah_id'),
                    'paket_mata_kuliah_id'=> $this->input->post('paket_mata_kuliah_id'),
                    'created_on'          => date($this->config->item('log_date_format')),
                    'created_by'          => logged_info()->on
                );
                $created_id = $this->crud->create($data_in);
            
            $mahasiswa = $this->input->post('mahasiswa_id');
            if($created_id && is_array($mahasiswa)){
                $this->crud->use_table('t_rencana_mata_pelajaran_pokok_detail');
                for($i=0; $i< count($mahasiswa); $i++){
                $data_in = array(
                    'rencana_mata_pelajaran_id' => $created_id,
                    'mahasiswa_id'              => $mahasiswa[$i],
                    'created_on'                => date($this->config->item('log_date_format')),
                    'created_by'                => logged_info()->on,
                    'active'                    => 1   
                );
                $this->crud->create($data_in);  
                }
            }  
            redirect('transaction/rencana_mata_pelajaran/' . $created_id . '/info');
        }
        $data['action_url'] = $transaction_url . __FUNCTION__;
        $data['page_title'] = 'Create Rencana Mata Pelajaran';
        $data['tools'] = array(
            'transaction/rencana_mata_pelajaran' => 'Back'
        );
        
        $this->load->model('rencana_mata_pelajaran_model');
        $data['angkatan_options'] = $this->rencana_mata_pelajaran_model->get_angkatan();
        
        $this->crud->use_table('m_mahasiswa');
        $data['mahasiswa_options'] = $this->crud->retrieve()->result();
                                                                          
        $this->crud->use_table('t_rencana_mata_pelajaran_pokok_detail');
        $data['rencana_mata_pelajaran_detil_options'] = $this->crud->retrieve()->result();
                                                     
        $data['thn_akademik_id_attr'] = '';
        $data['semester_id'] = '';
        $data['program_studi_id'] = ''; 
                
        $this->load->model('rencana_mata_pelajaran_model', 'rencana_mata_pelajaran');
        $data = array_merge($data, $this->rencana_mata_pelajaran->set_default()); //merge dengan arr data dengan default
        
        $this->load->view('transaction/rencana_mata_pelajaran_form', $data);
    }             

    function edit() {
        $data['auth']        = $this->auth;
        $data['action_type'] = __FUNCTION__;
        $transaction_url     = 'transaction/rencana_mata_pelajaran/';
        $id                  = $this->uri->segment(3);

        $this->load->library(array('form_validation', 'table'));
        $this->load->helper(array('form', 'snippets'));
        $this->form_validation->set_error_delimiters('<span class="notice">', '</span>');
        if ($this->form_validation->run('rencana_mata_pelajaran_update') === FALSE) {
            //don't do anything
        } else {
            $this->crud->use_table('t_rencana_mata_pelajaran_pokok');
            $criteria = array(
                'id' => $id
            );
            $data_in = array(
                'angkatan_id'         => $this->input->post('angkatan_id'),    
                'mata_kuliah_id'      => $this->input->post('mata_kuliah_id'),
                'paket_mata_kuliah_id'=> $this->input->post('paket_mata_kuliah_id'),
                'modified_on'         => date($this->config->item('log_date_format')),
                'modified_by'         => logged_info()->on
            );
            
            $this->crud->update($criteria, $data_in);
            
            $this->load->model('rencana_mata_pelajaran_model');
            $this->rencana_mata_pelajaran_model->delete_detail($id);
                                                               
            $mahasiswa = $this->input->post('mahasiswa_id');
            if(is_array($mahasiswa)){
                $this->crud->use_table('t_rencana_mata_pelajaran_pokok_detail');
                for($i=0; $i< count($mahasiswa); $i++){
                    $data_in = array(
                        'rencana_mata_pelajaran_id' => $id,
                        'mahasiswa_id'              => $mahasiswa[$i],
                        'modified_on'               => date($this->config->item('log_date_format')),
                        'modified_by'               => logged_info()->on,
                        'active'                    => 1   
                    );
                    $this->crud->create($data_in);  
                }
            }
             
            redirect('transaction/rencana_mata_pelajaran/' . $id . '/info');
        }
        $data['action_url'] = $transaction_url . $id . '/' . __FUNCTION__;
        $data['page_title'] = 'Update Rencana Mata Pelajaran';
        $data['tools']      = array(
            'transaction/rencana_mata_pelajaran' => 'Back'
        );
        
        $this->crud->use_table('t_rencana_mata_pelajaran_pokok');
        $rencana_mata_pelajaran_data = $this->crud->retrieve(array('id' => $id))->row();
        
        $this->load->model('rencana_mata_pelajaran_model');
        $data['angkatan_options'] = $this->rencana_mata_pelajaran_model->get_angkatan();
        
        $this->crud->use_table('m_mahasiswa');
        $data['mahasiswa_options'] = $this->crud->retrieve()->result();
                                                                          
        $this->crud->use_table('t_rencana_mata_pelajaran_pokok_detil');
        $data['rencana_mata_pelajaran_detil_options'] = $this->crud->retrieve()->result();
        
        $this->load->model('rencana_mata_pelajaran_model');
        $mahasiswa_checked = $this->rencana_mata_pelajaran_model->get_update_mahasiswa($id);
        
        $this->load->model('rencana_mata_pelajaran_model', 'rencana_mata_pelajaran');
        $data = array_merge($data, $this->rencana_mata_pelajaran->set_default()); //merge dengan arr data dengan default
        $data = array_merge($data, (array) $rencana_mata_pelajaran_data);
        if (!(empty($id))){
            $this->crud->use_table('m_angkatan');
            $data['m_angkatan'] = $this->crud->retrieve(array('id' => $data['angkatan_id']))->row();
            $this->load->model('rencana_mata_pelajaran_model');
            $data['m_tahun_akademik'] = $this->rencana_mata_pelajaran_model->get_tahun_angkatan($data['m_angkatan']->tahun_akademik_id);
            
            $thn_akademik_id_attr = '';
            foreach ($data['m_tahun_akademik'] as $row) {
                $thn_akademik_id_attr = $row['tahun_ajar_mulai'].'-'.$row['tahun_ajar_akhir'];
            }                
            $data['thn_akademik_id_attr'] = $thn_akademik_id_attr;

//            $this->crud->use_table('t_paket_mata_kuliah');
//            $data['semester'] = $this->crud->retrieve(array('id' => $data['paket_mata_kuliah_id']))->row();
            $this->load->model('rencana_mata_pelajaran_model');
            $data['semester_options'] = $this->rencana_mata_pelajaran_model->get_update_semester($id);
            $semester_id_attr = '';
            foreach($data['semester_options'] as $row){
                $semester_id_attr = $row['semester_id'];                                
            }
            $data['semester_id'] = $semester_id_attr;
            
//            $this->crud->use_table('t_paket_mata_kuliah');
//            $data['program'] = $this->crud->retrieve(array('id' => $data['paket_mata_kuliah_id']))->row();
            $this->load->model('rencana_mata_pelajaran_model');
            $data['program_options'] = $this->rencana_mata_pelajaran_model->get_update_program_studi($id);
            $program_id_attr = '';
            foreach($data['program_options'] as $row){
                $program_id_attr = $row['paket_mata_kuliah_id'];                                
            }
            $data['program_studi_id'] = $program_id_attr;
            
//            $this->crud->use_table('t_paket_mata_kuliah');
//            $data['mata_kuliah'] = $this->crud->retrieve(array('id' => $data['paket_mata_kuliah_id']))->row();
            $this->load->model('rencana_mata_pelajaran_model');
            $data['mata_kuliah_options'] = $this->rencana_mata_pelajaran_model->get_update_mata_kuliah($id);
            var_dump($data['mata_kuliah_options']);            
            $this->load->model('rencana_mata_pelajaran_model');
            $mahasiswa_data = $this->rencana_mata_pelajaran_model->get_edit_mahasiswa();
            
            $this->load->model('rencana_mata_pelajaran_model');
            $mahasiswa_checked = $this->rencana_mata_pelajaran_model->get_update_mahasiswa($id);
            $checked_mhs = '';
            foreach($mahasiswa_data as $row){
                @$checked = in_array($row['id'], $mahasiswa_checked) ? "checked='checked'" : "";
                $checked_mhs .= "<tr>
                                    <td></td>         
                                    <td>".$row['nim']."</td>
                                    <td>".$row['nama']."</td>
                                    <td style='text-align: center'>
                                        <input type='checkbox' ".$checked." name='mahasiswa_id[]' id='cek' value=".$row['id']." >   
                                    </td>
                                </tr>";                                    
            }
            $data['checked_mahasiswa'] = $checked_mhs;
        }
        $this->load->view('transaction/rencana_mata_pelajaran_form', $data);
    }
    
    function getOptTahunAkademik() {
        $angkatan_id= $this->input->post('angkatan_id');
        $sql = "select distinct a.tahun_ajar_mulai, a.tahun_ajar_akhir from akademik_m_tahun_akademik a ".
                " left join akademik_m_angkatan b on b.tahun_akademik_id=a.id ".
                "where a.active ='1' and b.tahun_akademik_id='$angkatan_id'";
        $query = $this->db->query($sql);
        foreach($query->result_array() as $row){
            echo $row['tahun_ajar_mulai'].'-'.$row['tahun_ajar_akhir'];
        }
    }
    
    function getOptSemester(){
        $this->load->model('rencana_mata_pelajaran_model');
        $angkatan_id = $this->input->post('angkatan_id');
        $data['semester'] = $this->rencana_mata_pelajaran_model->get_semester($angkatan_id);
        echo '<option value="" ></option>';
        foreach($data['semester'] as $row){
            echo '<option value=\''.$row['semester_id'].'\' >'.$row['nama_semester'].'</option>';
        } 
    }
    
    function getOptProgramStudi(){
        $this->load->model('rencana_mata_pelajaran_model');
        $angkatan_id = $this->input->post('angkatan_id');
        $semester_id = $this->input->post('span_semester');
        $data['program'] = $this->rencana_mata_pelajaran_model->get_program_studi($angkatan_id,$semester_id);
        echo '<option value="" ></option>';
        foreach($data['program'] as $row){
            echo '<option value=\''.$row['paket_mata_kuliah_id'].'\' >'.$row['nama_program_studi'].'</option>';
        } 
    }    
    
    function getOptMatakuliah(){
        $this->load->model('rencana_mata_pelajaran_model');
        $angkatan_id = $this->input->post('angkatan_id');
        $semester_id = $this->input->post('span_semester');
        $progran_id  = $this->input->post('span_program');
        $data['mata_kuliah'] = $this->rencana_mata_pelajaran_model->get_mata_kuliah($angkatan_id,$semester_id,$progran_id);
        echo '<option value="" ></option>';
        foreach($data['mata_kuliah'] as $row){
            echo '<option value=\''.$row['mata_kuliah_id'].'\' >'.$row['nama_mata_kuliah'].'</option>';
        } 
    }
    
    function getOptMahasiswa(){
        $this->load->model('rencana_mata_pelajaran_model');
        $angkatan_id = $this->input->post('angkatan_id');    
        $data['mahasiswa'] = $this->rencana_mata_pelajaran_model->get_mahasiswa($angkatan_id);
        foreach($data['mahasiswa'] as $row){
            @$checked = in_array($row['id'], $mahasiswa_checked) ? "checked='checked'" : "";
            echo "<tr>";
                echo "<td></td>";         
                echo "<td>".$row['nim']."</td>";
                echo "<td>".$row['nama']."</td>";
                echo "<td style='text-align: center'>
                        <input type='checkbox' ".$checked." name='mahasiswa_id[]' id='cek' value=".$row['id']." >   
                    </td>";
            echo "</tr>";
        }
    }
}

?>
