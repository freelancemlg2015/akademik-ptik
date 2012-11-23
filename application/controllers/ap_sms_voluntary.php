<?php

class ap_sms_voluntary extends Controller {

	public function ap_sms_voluntary() {
        parent::Controller();
		$this->load->model("map_sms_voluntary");
    }
	
	public function index($sms_type='all', $date ='all',$order='receive_time', $sort='desc', $offset = '0') {
		$sess_limiter = $this->session->userdata('session_limiter');
		$data['site_url'] =site_url("ap_sms_voluntary/index/$sms_type/$date/$order/$sort");
		$data['filter_url'] ="$sms_type/$date";
		$this->session->set_userdata('session_back_url', $data['site_url'] );
        if (empty($sess_limiter)) {
            $data['limit'] = $this->limit;
        } else {
            $data['limit'] = $sess_limiter;
        }
		$data['sms_type_search'] = $sms_type;
		$data['canGrouping'] = true;
		$data['canRemove'] = true;
		$data['default_show'] = $sess_limiter;
		//if($date!='all') $date = str_replace('_',' and ',$date);
		
		$data['data'] = $this->map_sms_voluntary->get_all($sms_type, $date, $offset, $sess_limiter,$order, $sort);
		//echo $this->db->last_query();
		$data['rows'] = $this->map_sms_voluntary->total_rows;
		$this->load->view("ap_sms_voluntary/index",$data);
    }
	
	public function index_group() {
		$data['canGrouping'] = true;
		$data['canView'] = 'test';
		$data['canAddToVoluntaryReport'] = true;
		$data['canEdit'] = true;
		$data['data'] = $this->map_sms_voluntary->getSMSGroup();
        $this->load->view("ap_sms_voluntary/index_group",$data);
    }
	
	public function sms_group_form($parm='') {
		$id_sms = explode('_',$parm);
		$data['data'] = $this->map_sms_voluntary->get_SMS($id_sms);
		$data['lokasi_hazard'] = $this->map_sms_voluntary->get_hazard();
		$data['probabilty'] = $this->map_sms_voluntary->get_probabilty();
		$data['severity'] = $this->map_sms_voluntary->get_severity();
		$this->load->view("ap_sms_voluntary/sms_group",$data);
	}
	
	public function sms_group_insert(){
		if(strpos($this->input->post('sms_id'),',')>=0) $sms_id = explode(',',$this->input->post('sms_id'));
		else $sms_id = $this->input->post('sms_id');
		//`id_ap_voluntary_sms_join``id_org``id_user``ap_voluntary_sms_rx_parent`
		//`date_join``ssp_description``message_type``join_status``status_report`
		//`tgl_pelaporan``lokasi_kejadian``tgl_kejadian``saran``bentuk_hazard`
		//`tgl_pelaporan_hazard``lokasi_hazard``lokasi_dibandara``lokasi_diluar_bandara`
		//`probabilty``severity``rekomendasi``created_on``created_by``modified_on`
		//`modified_by``active`
		
		$parm['description'] = $this->input->post('description');	
		$parm['message_type'] = $this->input->post('message_type');	
		//$parm['id_org'] = $this->input->post('org');	
		$parm['tgl_pelaporan'] = date('Y-m-d H:i:s');
		$parm['lokasi_kejadian'] = $this->input->post('lokasi_kejadian');	
		$parm['tgl_kejadian'] = rtrim($this->input->post('tgl_kejadian')).':00';	
		$parm['bentuk_hazard'] = $this->input->post('bentuk_hazard');
		$parm['lokasi_hazard'] = $this->input->post('lokasi_hazard');
		$parm['lokasi_dibandara'] = $this->input->post('lokasi_dibandara');
		$parm['lokasi_diluar_bandara'] = $this->input->post('lokasi_diluar_bandara');
		$parm['org_name'] = $this->input->post('org_name');
		$parm['probabilty'] = $this->input->post('probabilty');
		$parm['severity'] = $this->input->post('severity');
		$this->map_sms_voluntary->insertSMSGroup($parm,$sms_id);
		echo $this->db->last_query();
	}
	
	public function sms_group_detail($id_ap_voluntary_sms_join=0){
		$data['mode']='view';
		$data['lokasi_hazard'] = $this->map_sms_voluntary->get_hazard();
		$data['probabilty'] = $this->map_sms_voluntary->get_probabilty();
		$data['severity'] = $this->map_sms_voluntary->get_severity();
		$data['sms_group'] = $this->map_sms_voluntary->getGroupDetail($id_ap_voluntary_sms_join);
		$this->load->view("ap_sms_voluntary/sms_group_form",$data);
	}
	
	public function sms_group_edit($id_ap_voluntary_sms_join=0){
		$data['mode']='edit';
		$data['lokasi_hazard'] = $this->map_sms_voluntary->get_hazard();
		$data['probabilty'] = $this->map_sms_voluntary->get_probabilty();
		$data['severity'] = $this->map_sms_voluntary->get_severity();
		$data['sms_group'] = $this->map_sms_voluntary->getGroupDetail($id_ap_voluntary_sms_join);
		$this->load->view("ap_sms_voluntary/sms_group_form",$data);
	}
	
	public function index_followup() {
		$data['canFollowUp'] = true;
		$data['lokasi_hazard'] = $this->map_sms_voluntary->get_hazard();
		$data['probabilty'] = $this->map_sms_voluntary->get_probabilty();
		$data['severity'] = $this->map_sms_voluntary->get_severity();
		$data['data'] = $this->map_sms_voluntary->getSMSGroup();
        $this->load->view("ap_sms_voluntary/index_followup",$data);
    }
	
	public function follow_up_form($group_id =0){
		$data['mode']='add';
		$data['lokasi_hazard'] = $this->map_sms_voluntary->get_hazard();
		$data['probabilty'] = $this->map_sms_voluntary->get_probabilty();
		$data['severity'] = $this->map_sms_voluntary->get_severity();
		$data['SmsFollowUp'] = $this->map_sms_voluntary->getSmsFollowUp($group_id);
		$this->load->view("ap_sms_voluntary/followup_form",$data);
	}
	
	public function follow_up_view($group_id =0){
		$data['mode']='view';
		$data['lokasi_hazard'] = $this->map_sms_voluntary->get_hazard();
		$data['probabilty'] = $this->map_sms_voluntary->get_probabilty();
		$data['severity'] = $this->map_sms_voluntary->get_severity();
		$data['SmsFollowUp'] = $this->map_sms_voluntary->getSmsFollowUp($group_id);
		$data['returnUrl']= 'ap_sms_voluntary/index_followup';
		$this->load->view("ap_sms_voluntary/followup_form",$data);
	}
	
	function detail($sms_id){
		$data['msg_info'] = $this->map_sms_voluntary->get_SMS($sms_id);;
        $this->load->view("ap_sms_voluntary/sms_detail",$data);
	}
	
	function smsJunk(){
		$strList = $this->input->post('sms_list');
		$list = explode(',',$strList);
		foreach($list as $sms_id){
			$this->map_sms_voluntary->junkSMS($sms_id);
		}
	}
	
	function sendSMS($txNumber ='',$message ='',$gateway ='', $id =0 ){
		//$url = 'http://localhost:2000/index.html';
		$url = GetSystemParameter('sms_send_url');
		
		$fields = array('txNumber'=>$txNumber,
						'message'=>$message,
						'id'=>$id);
		foreach($fields as $key=>$value) { $fields_string .= $key.'='.$value.'&'; }
		$fields_string = rtrim($fields_string, '&');
		$ch = curl_init();
		
		curl_setopt($ch,CURLOPT_URL, $url);
		curl_setopt($ch,CURLOPT_POST, count($fields));
		curl_setopt($ch,CURLOPT_POSTFIELDS, $fields_string);
		
		$result = curl_exec($ch);

	//close connection
		curl_close($ch);
		
		echo $result;
	}
	
	function rxSMS(){
	//`phone_number``receive_time``message`
		$parm['phone_number'] = $this->input->post('txNumber');
		$parm['receive_time'] = $this->input->post('rxTime');
		$parm['message'] = $this->input->post('message');
		$temp = strtolower($parm['message']);
		if(substr($temp, 0, 4) === 'reg#'){
			$aTemp = explode('#',$temp);
			if(count($aTemp)>1) $regParm['name']= $aTemp[1];
			if(count($aTemp)>2){
				$regParm['city_name']= $aTemp[2];
				$regParm['registered_status']= 'registered';
			}
			$this->map_sms_voluntary->doRegistrationPhone($parm['phone_number'],$regParm);
			echo GetSystemParameter('sms_registeration_replay');
		}else{
			$isUnformated = true;
			if(substr($temp, 0, 8) === 'airport#'){
				$parm['message_type'] ='AIRPORT';
				$parm['message'] = substr($parm['message'],8,300);
				$isUnformated = false;
			}else if(substr($temp, 0, 8) === 'airline#'){
				$parm['message_type'] ='AIRLINE';
				$parm['message'] = substr($parm['message'],8,300);
				$isUnformated = false;
			}else if(substr($temp, 0, 6) === 'hubud#'){
				$parm['message_type'] ='HUBUD';
				$parm['message'] = substr($parm['message'],6,300);
				$isUnformated = false;
			}	
			$parm['active'] ='1';	
			$this->map_sms_voluntary->insertSMS($parm);
			$reg_status = $this->map_sms_voluntary->getRegistrationPhoneStatus($parm['phone_number']);
			if($isUnformated) echo GetSystemParameter('sms_replay_unformated');
			else if($reg_status=='Registered') echo GetSystemParameter('sms_replay_registered');
			else echo GetSystemParameter('sms_replay_unregistered');
		}
	}
	
	function settings(){
		$data['sms_registeration_replay'] = GetSystemParameter('sms_registeration_replay');
		$data['sms_replay_unformated'] = GetSystemParameter('sms_replay_unformated');
		$data['sms_replay_registered'] = GetSystemParameter('sms_replay_registered');
		$data['sms_replay_unregistered'] = GetSystemParameter('sms_replay_unregistered');
		$this->load->view("ap_sms_voluntary/settings_form",$data);
	}
	
	function save_settings(){
		SetSystemParameter('sms_replay_unformated',$this->input->post('txt_unformated_replay'));
		SetSystemParameter('sms_replay_unregistered',$this->input->post('txt_unregistered_replay'));
		SetSystemParameter('sms_replay_registered',$this->input->post('txt_replay_registered'));
		SetSystemParameter('sms_registeration_replay',$this->input->post('txt_registeration_replay'));
	}
	
	function convert2voluntary(){
		
	}
	
	function replay_form($sms_id){
		$data['msg_info'] = $this->map_sms_voluntary->get_SMS($sms_id);
		$this->load->view("ap_sms_voluntary/sms_replay",$data);
	}
	
	function replay(){
		$sms_id = $this->input->post('sms_id');
		$msg = $this->input->post('text_message');
		$sms = $this->map_sms_voluntary->get_SMS($sms_id);
		$this->sendSMS($sms['phone_number'], $msg, '',1);
	}
	
	function test($table_name='',$action='' ){
		//$str_json = json_encode(array('id_ap_voluntary_sms_tx'=>'13', 'id_ap_voluntary_sms_rx'=>'1089'));
		//$str_json = '{"id_ap_voluntary_sms_tx":"13","id_ap_voluntary_sms_rx":"1089","phone_number":"9879007","send_time":"2007-04-15 00:05:30","message":"test","status":"request","type":"replay"}';
		//$obj = json_decode($str_json);
		//echo $obj['id_ap_voluntary_sms_tx'];
		
		//echo $obj->message;
		//$obj = json_encode('{"id_ap_voluntary_sms_tx":"13","id_ap_voluntary_sms_rx":"1089","phone_number":"9879007","send_time":"2007-04-15 00:05:30","message":"test","status":"request","type":"replay"}');
		//echo $obj['id_ap_voluntary_sms_tx'];
		//$this->load->library('LibLog');
		//$rows = $this->liblog->getLog('ap_voluntary_sms_tx');
		//foreach($rows as $row){
			//echo $row['phone_number'];
		//}
		//echo 'test';
		//echo '<textarea rows="50" style="width:100%;">'.$this->liblog->generateTriger('ap_voluntary_sms_tx','id_ap_voluntary_sms_tx','INSERT').'</textarea>';
		//echo '<textarea row="50" style="width:100%;">'.$this->liblog->generateTriger($table_name,$action).'</textarea>';
		
		//$parm['phone_number'] = '085710349028';//$this->input->post('txNumber');
		//$parm['receive_time'] = '2012-09-10 00:10:30';//$this->input->post('rxTime');
		//$parm['message'] = 'test';//$this->input->post('message');
		//$this->map_sms_voluntary->insertSMS($parm);		
		//echo $this->db->last_query();
		//echo GetSystemParameter('sms_replay');
		//$this->map_sms_voluntary->insertSMS($parm);
		$reg_status = $this->map_sms_voluntary->getRegistrationPhoneStatus($parm['phone_number']);
		if($reg_status=='Registered') echo GetSystemParameter('sms_replay_registered');
		else echo GetSystemParameter('sms_replay_unregistered');
	}
	
	

}
?>