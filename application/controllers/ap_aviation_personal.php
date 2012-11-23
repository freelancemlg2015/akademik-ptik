<?php

class ap_aviation_personal extends Controller {

	var $main_organisasi = 0;

	public function ap_aviation_personal() {
        parent::Controller();
		$this->load->model("map_aviation_personal");
		$this->main_organisasi = $this->map_aviation_personal->getMainOrganizationId($this->session->userdata('id_org'));
    }
	
	public function index($search = '0', $val = '0', $order = '0', $by = '0', $offset = 0, $menu_id = 0) {
		$data['Organizations'] = $this->map_aviation_personal->getOrganization();
		$this->load->view("ap_aviation_personal/index",$data);
	}
	
	function index_category($search = '0', $val = '0', $order = '0', $by = '0', $offset = 0) {
		$data['Organizations'] = $this->map_aviation_personal->getOrganization();
		$data['PersonalCategories'] = $this->map_aviation_personal->getAllPersonalCategory();
		$this->load->view("ap_aviation_personal/index_category",$data);
	}
	
	function viewPersonalCategory($PersonalCategories =0){
		echo $PersonalCategories;
	}
	
	function index_personal($search = '0', $val = '0', $order = '0', $by = '0', $offset = 0) {
		$data['Organizations'] = $this->map_aviation_personal->getOrganization();		
		$this->load->view("ap_aviation_personal/index_personal",$data);
	}
	
	function index_position($search = '0', $val = '0', $order = '0', $by = '0', $offset = 0) {
		$data['Organizations'] = $this->map_aviation_personal->getOrganization();
		$this->load->view("ap_aviation_personal/index_position",$data);
	}
	
	function index_license($search = '0', $val = '0', $order = '0', $by = '0', $offset = 0) {
		$data['Organizations'] = $this->map_aviation_personal->getOrganization();
		$this->load->view("ap_aviation_personal/index_license",$data);
	}
	
	function index_rating($search = '0', $val = '0', $order = '0', $by = '0', $offset = 0) {
		$data['Organizations'] = $this->map_aviation_personal->getOrganization();
		$this->load->view("ap_aviation_personal/index_rating",$data);
	}
	
	function organization_type(){
		$id=$this->input->post('id');
		$list = $this->map_aviation_personal->getCategory($id);
		foreach($list as $item)	$data['rows'][] = array('id'=>$item['id_tipeorg'], 'nama'=>$item['nm_tipeorg']);
		echo json_encode($data);
	}
	
	
	function personal_category($organization_id = 0){
		$organization_type = $this->input->post('id');
		$personal_categories = $this->map_aviation_personal->getPersonalCategoriesByOrg($organization_id,$organization_type); 
		$rows = array();
		$i =0;
		foreach($personal_categories as $item){
			$nama ='';
			if($item['l3']>0) $nama .='---';
			if($item['l2']>0) $nama .='---';
			$nama .= $item['personal_category'];
			$rows[$i++] = array('id'=>$item['id_personal_category'],'nama'=>$nama );
		}
		$result['rows'] = $rows;
		echo json_encode($result);
	}
	
	function formAddPersonalCategory(){
		$data = array();
		$data['Organizations'] = $this->map_aviation_personal->getOrganization();
		echo $this->load->view("ap_aviation_personal/form_personal_category",$data);;
	}
	
	function do_insert_personal_category(){
		$parm = array('personal_category'=> $this->input->post('personal_category'), 
					  'id_aviation_category'=> $this->input->post('organization_type'),
					  'id_org'=> $this->input->post('organization_id'),
					   'created_on'=>date('Y-m-d H:i:s'), 
					   'created_by'=>$this->session->userdata('id_user'),
					   'active'=>1);
		if($this->input->post('parent_id')!='') $parm ['parent_id'] = $this->input->post('parent_id');
		$id_personal_category = $this->map_aviation_personal->insert_personal_category($parm);
		$result['status'] = 'ok';
		$result['id_personal_category'] = $id_personal_category;
		echo json_encode($result);
	}
	
	function formEditPersonalCategory($personal_category_id = 0){
		$data = array();
		$data['Organizations'] = $this->map_aviation_personal->getOrganization();
		$data['form_mode'] ='edit';
		echo $this->load->view("ap_aviation_personal/form_personal_category",$data);;
	}
	
	
	function do_update_personal_category(){
		$id_personal_category = $this->input->post('');
		$parm = array('personal_category'=> $this->input->post('personal_category'), 
					  'id_aviation_category'=> $this->input->post('organization_type'),
					  'id_org'=> $this->input->post('organization_id'),
					  'modified_on'=>date('Y-m-d H:i:s'), 
					  'modified_by'=>$this->session->userdata('id_user'));
		if($this->input->post('')!='') $parm ['parent_id'] = $this->input->post('');
		$this->map_aviation_personal->update_personal_category($id_personal_category, $parm);
	}
	
	function formAddPersonalPosition(){
		$data = array();
		$data['Organizations'] = $this->map_aviation_personal->getOrganization();
		echo $this->load->view("ap_aviation_personal/form_personal_position",$data);;
	}
	
	function formEditPersonalPosition($personal_positon_id = 0){
		$data = array();
		$data['Organizations'] = $this->map_aviation_personal->getOrganization();
		$data['form_mode'] ='edit';
		echo $this->load->view("ap_aviation_personal/form_personal_position",$data);;
	}
	
	function do_insert_personal_position(){
	}
	
	function do_update_personal_position(){
	}
	
	function formAddPersonalLicense(){
		$data = array();
		$data['Organizations'] = $this->map_aviation_personal->getOrganization();
		echo $this->load->view("ap_aviation_personal/form_personal_license",$data);
	}
	
	function formEditPersonalLicense(){
		$data = array();
		$data['Organizations'] = $this->map_aviation_personal->getOrganization();
		$data['form_mode'] ='edit';
		echo $this->load->view("ap_aviation_personal/form_personal_license",$data);
	}
	
	function do_insert_personal_lincense(){
	}
	
	function do_update_personal_license(){
	}
	
	function formAddPersonalRating(){
		$data = array();
		$data['Organizations'] = $this->map_aviation_personal->getOrganization();
		echo $this->load->view("ap_aviation_personal/form_personal_rating",$data);
	}
	
	function formEditPersonalRating(){
		$data = array();
		$data['Organizations'] = $this->map_aviation_personal->getOrganization();
		$data['form_mode'] ='edit';
		echo $this->load->view("ap_aviation_personal/form_personal_rating",$data);
	}
	
	function do_insert_personal_rating(){
	}
	
	function do_update_personal_rating(){
	}
	
	function insert(){
		$data= array();
		$data['organizations'] =$this->map_aviation_personal->getOrganization();
		$language_profiency = array(
								array('language_profiency_id'=>'1','language'=>'Bhs Indonesia', 'profiency_speak'=>'10','profiency_read'=>'9', 'profiency_write'=>'8','ICAO_Level'=>'10'),
								array('language_profiency_id'=>'2', 'language'=>'English', 'profiency_speak'=>'10','profiency_read'=>'9', 'profiency_write'=>'8','ICAO_Level'=>'10')
							);
		$person = array('language_profiency'=>$language_profiency);
		$data['person'] = $person;
		$this->load->view("ap_aviation_personal/form",$data);
	}
	
	
	
	function do_insert(){
		$parm = array(
			'id_kabupaten'=>$this->input->post('txt_id_kabupaten'),
			'text_kabupaten'=>$this->input->post('txt_text_kabupaten'),
			'id_province'=>$this->input->post('txt_id_province'),
			'text_province'=>$this->input->post('txt_text_province'),
			'id_negara'=>$this->input->post('txt_id_negara'),
			'text_negara'=>$this->input->post('txt_text_negara'),
			'id_org'=>$this->input->post('id_org'),
			'full_name'=>$this->input->post('txt_full_name'),
			'first_name'=>$this->input->post('personal_first_name'),
			'middle_name'=>$this->input->post('personal_idle_name'),
			'last_name'=>$this->input->post('personal_last_name'),
			'home_address'=>$this->input->post('personal_address'),
			'office_address'=>$this->input->post('txt_office_address'),
			'office_phone'=>$this->input->post('txt_office_phone'),
			'office_phone_ext'=>$this->input->post('txt_office_phone_ext'),
			'home_phone'=>$this->input->post('personal_home_phone'),
			'mobile_number'=>$this->input->post('txt_mobile_number'),
			'employee_identification'=>$this->input->post('txt_employee_identification'),
			'level'=>$this->input->post('txt_level'),
			'email'=>$this->input->post('personal_email'),
			'date_of_birth'=>$this->input->post('txt_date_of_birth'),
			'marital_status'=>$this->input->post('personal_martial_id'),
			'gender'=>$this->input->post('personal_gender_id'),
			'identified_type'=>$this->input->post('txt_identified_type'),
			'identified_number'=>$this->input->post('txt_identified_number'),
			'created_on'=>date('Y-m-d H:m:s'),
			'created_by'=>$this->session->userdata('id_user'),
			'active'=>'1');
		print_r($this->input->post('language'));
	}
	
	function skill_content(){
		//echo 'skill_content';
		$this->load->view('ap_aviation_personal/skill_content');
	}
	
	function upload(){
		$config['upload_path'] = './assets/upload/personal/';
        $config['allowed_types'] = 'jpg|jpeg|png|gif';
        $this->load->library('upload', $config);
        if ($this->upload->do_upload('file')) {
            $desc = $this->upload->data();
            $data['upload'] = TRUE;
            $data['msg'] = @$desc['file_name'];
			//C:\xampp\htdocs\aplikasi\assets\upload\serious_accident
			$data['url'] = base_url()."assets/upload/personal/".@$desc['orig_name'];//@$desc['file_name'];
			$data['orig_name'] =@$desc['orig_name'];
			$data['file_name'] =@$desc['raw_name'];
        } 
        else {
            $data['upload'] = FALSE;
            $data['msg'] = $this->upload->display_errors();
        }
        echo json_encode($data);
	}
	
	function loadForm($form_name = ''){
		if($form_name!=''){
			$this->load->view("ap_aviation_personal/" .$form_name,$data);
		}
	}
	
} ?>