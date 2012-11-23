<?php

class ap_serious_accident extends Controller {
    
// join :
// organisasi : DIRECTORATE GENERAL OF CIVIL AVIATION(27)
	var $org_join_access = array(702, 712, 715);
	var $user_join_acces = array(1);
	var $orgtype_join_acces = array();
	
// jabatan : 	AUDITOR GROUP(25),DATABASE GROUP(57), PLANNING GROUP(56)
	var $jabatan_join_acces = array(25,57,56);
	
    var $limit = 5;
    var $month = array( '1'=>'Januari', '2'=>'Februari', '3'=>'Maret', '4'=>'April', '5'=>'Mei', '6'=>'Juni', '7'=>'Juli', '8'=>'Agustus', '9'=>'September', '10'=>'Oktober', '11'=>'November', '12'=>'Desember');
    var $id_pilot = array ( 1=>'Pilot', 2=>'Co-Pilot', 3=>'Student Pilot', 4=>'Flight Instructor', 5=>'Check Pilot', 6=>'Flight Engineer', 7=>'Other Flight Crew');
    var $seat = array ( 1=>'Left', 2=>'Right', 3=>'Center', 4=>'Front', 5=>'Rear', 6=>'Single');
    var $pilot_cert = array ( 1=>'None', 2=>'Private', 3=>'Student', 4=>'Flight Instructor', 5=>'Recreational', 6=>'Sport', 7=>'Commercial', 8=>'Airline Transport', 9=>'Flight Engineer', 10=>'U.S. Military', 11=>'Foreign'); 
    var $injury = array ( 1=>'Fatal', 2=>'Serious Injury', 3=>'Minor Injury', 4=>'No Injury', 5=>'Unknown');
    var $id_passengers = array ( 1=>'Crew', 2=>'Non-Revenue', 3=>'Revenue', 4=>'Non-Occupant', 5=>'FAA');
	var $temp_id_accident =0;
	
	function array2csv($inputName=''){
		$temp = $this->input->post($inputName);
		if(!empty($temp)){
			$result = '';
			foreach($temp as $val) $result .= ','.$val;
			if($result != '') $result = substr( $result,1);
			return $result;
		}
		return '';
	}
	
	function csv2array($parm){
		$array = explode(',',$parm);
		$result = array();
		foreach($array as $val) $result[$val] = $val;
		return $result;
	}
	
	private function canSave($id_accident=0){
		$org_id =  $this->session->userdata("kode_organisasi");
		$accident = $this->map_serious_accident->getMasterData('ap_t_acc_accident', 'id_accident', 'asc', 'id_accident', $id_accident, '*');	
		if($org_id==$accident[0]['id_org']) return true;
		return false;
	}
	
	private function canAddSummary(){
		if($this->session->userdata("id_user")==1) return true;		
		if($this->session->userdata("id_tipeorg")== 1)return true;
		if($this->session->userdata("id_tipeorg")== 3)return true;
		if($this->session->userdata("id_tipeorg")== 4)return false;
		if($this->session->userdata("id_tipeorg")== 15)return true;
		if($this->session->userdata("jabatan")== 50)return true;
		return false;
	}
	
	private function canEditSummary(){
		if($this->session->userdata("id_user")==1) return true;
		if($this->session->userdata("id_tipeorg")== 1)return true;
		if($this->session->userdata("id_tipeorg")== 3)return true;
		if($this->session->userdata("id_tipeorg")== 4)return false;
		if($this->session->userdata("id_tipeorg")== 15)return true;
		if($this->session->userdata("jabatan")== 50)return true;
		return false;
	}
	
	private function canDeleteSummary(){
		if($this->session->userdata("id_user")==1) return true;
		if($this->session->userdata("id_tipeorg")== 1)return true;
		if($this->session->userdata("id_tipeorg")== 3)return true;
		if($this->session->userdata("id_tipeorg")== 4)return false;
		if($this->session->userdata("id_tipeorg")== 15)return true;
		if($this->session->userdata("jabatan")== 50)return true;
		return false;
	}
	
	private function canViewDetail(){
	}
	
	private function canEdit(){
	}
	
	function canJoin(){
		//$jabatan =  $this->session->userdata('jabatan');
		//$id_org = $this->session->userdata('kode_organisasi');
		//$id_user = $this->session->userdata('id_user');
		//$result2 = false;
		//foreach($this->user_join_acces as $item) if($item ==$id_user) $result2 = true;
		//$result1 = false;
		//foreach($this->org_join_access as $item) if($item ==$jabatan) $result1 = true;
		//$result2 = false;
		//foreach($this->org_join_access as $item) if($item ==$id_org) $result2 = true;
		//return $result2;
		//return ($result1 && $result2);
		//echo $this->session->userdata('id_org');
		if($this->session->userdata('id_org')==720){
			$jabatan = $this->session->userdata('jabatan');
			//echo $jabatan;
			if($jabatan== 55 | $jabatan== 57 | $jabatan== 59 | $jabatan== 25) return true;
		}else if($this->session->userdata("id_user")==1) return true;
		return false;
	}
    
    function ap_serious_accident(){
        parent::Controller();
        $this->load->model("map_serious_accident");
    }
    function get_causes(){
        $merk = $this->map_serious_accident->data_master_causes('ap_m_detail_causes', $this->input->post('id'));
        $i=0;
        foreach ($merk as $row){
            $responce->rows[$i]['id'] = $row['id_detail_causes'];
            $responce->rows[$i]['nama'] = $row['detail_causes_name'];
            $i++;
        }
        echo json_encode($responce);
    }
    function get_occ_dtl(){
        $detail = $this->map_serious_accident->getMasterData('ap_m_occ_detail_type', 'id_occ_detail_type', 'asc', 'id_occ_type', $this->input->post('id'), 'id_occ_detail_type, occ_detail_type_name');
        if (count($detail) > 0):
        $i=0;
        foreach ($detail as $row){
            $responce->rows[$i]['id'] = $row['id_occ_detail_type'];
            $responce->rows[$i]['nama'] = $row['occ_detail_type_name'];
            $i++;
        }
        echo json_encode($responce);
        endif;
    }
    function get_register_number(){
		$reg = $this->map_serious_accident->get_data_aircraft('id, reg, kode', 'ap_aircraft', 'tipe', 'asc', 'id_airline', $this->input->post('id'));
        if (count($reg) > 0){
			$i=0;
			foreach ($reg as $row){
				$responce->rows[$i]['id'] = $row['id'];
                $responce->rows[$i]['nama'] = trim($row['kode']).trim($row['reg']);
				$i++;
			}
		}
		else {
			$responce->rows = array();
		}
		echo json_encode($responce);
    }
    function get_aircraft_cat(){
        $reg = $this->map_serious_accident->getMasterData('ap_m_aircraft_category', 'id_aircraft_category', 'asc');
        if (count($reg) > 0){
            $i=0;
            foreach ($reg as $row){
                $responce->rows[$i]['id'] = $row['id_aircraft_category'];
                $responce->rows[$i]['nama'] = $row['aircraft_category_name'];
                $i++;
            }
        }
        else {
            $responce->rows = array();
        }
        echo json_encode($responce);
    }
    function get_phase_flight(){
        $reg = $this->map_serious_accident->getMasterData("ap_pase_flight", "name", "asc");
        if (count($reg) > 0){
            $i=0;
            foreach ($reg as $row){
                $responce->rows[$i]['id'] = $row['id'];
                $responce->rows[$i]['nama'] = $row['name'];
                $i++;
            }
        }
        else {
            $responce->rows = array();
        }
        echo json_encode($responce);
    }
    function get_category(){
		$merk = $this->map_serious_accident->data_master('ap_m_incident_type_category', $this->input->post('id_type'));
        $i=0;
        foreach ($merk as $row){
            $responce->rows[$i]['id'] = $row['id_incident_type_category'];
            $responce->rows[$i]['nama'] = $row['incident_type_cat_name'];
            $i++;
        }
        echo json_encode($responce);
    }
    function get_aircraft_type(){
        $merk = $this->map_serious_accident->get_data_aircraft('tipe', 'ap_aircraft', 'tipe', 'asc', 'id', $this->input->post('id'));
        if (count($merk) > 0){
			$i=0;
			foreach ($merk as $row){
				$responce->rows[$i]['id'] = $row['tipe'];
				$responce->rows[$i]['nama'] = $row['tipe'];
				$i++;
			}
		}
		else {
			$responce->rows = array();
		}
        echo json_encode($responce);
    }
	
	function addCountry(){
		$newCountry = $this->input->post('newValue');
		//echo $newCountry;
		//$this->db->simple_query("INSERT INTO `ap_m_negara`(`id_negara`, `nama_negara`) VALUES (null,'$newCountry')");
		//$country_id = $this->db->insert_id();
		//$responce->rows[0]['id'] = $country_id ;
		//$responce->rows[0]['nama'] = $newCountry;
		//echo json_encode($responce);
	}
	
	function get_province($id_country = 0){
		$provinces = $this->map_serious_accident->getMasterData("ap_m_provinsi", "nama_provinsi", "asc",null,null,'id_provinsi,nama_provinsi');
		$i=0;
        foreach ($provinces as $province){
            $responce->rows[$i]['id'] = $province['id_provinsi'];
            $responce->rows[$i]['nama'] = $province['nama_provinsi'];
            $i++;
        }
        echo json_encode($responce);
	}
	
	function addProvince(){
		$newCountry = $this->input->post('newValue');
	}
	
    function get_district($id_province = 0){
        if($id_province == 0) $districts = $this->map_serious_accident->getMasterData('ap_m_kabupaten', 'nama_kabupaten', 'asc', 'id_provinsi', $this->input->post('id'));
        else $districts = $this->map_serious_accident->getMasterData('ap_m_kabupaten', 'nama_kabupaten', 'asc', 'id_provinsi', $id_province);
		//echo $this->db->last_query();
		$i=0;
        foreach ($districts as $row){
            $responce->rows[$i]['id'] = $row['id_kabupaten'];
            $responce->rows[$i]['nama'] = $row['nama_kabupaten'];
            $i++;
        }
        echo json_encode($responce);
    }
	
	function addCity(){
		$newCountry = $this->input->post('newValue');
		//echo $newCountry;
		//$this->db->simple_query("INSERT INTO `ap_m_negara`(`id_negara`, `nama_negara`) VALUES (null,'$newCountry')");
		//$country_id = $this->db->insert_id();
		//$responce->rows[0]['id'] = $country_id ;
		//$responce->rows[0]['nama'] = $newCountry;
		//echo json_encode($responce);
	}
	
	function get_model(){
		$manufacture_id = $this->input->post('id');
		$models = $this->map_serious_accident->getMasterData('ms_aircraft_model', 'name_aircraft_model', 'asc', 'id_aircraft_make', $manufacture_id,'name_aircraft_model,id_aircraft_model');
		$row =array();
		foreach($models as $model){
			$row[] = array("nama"=>$model['name_aircraft_model'],"id"=>$model['id_aircraft_model'] );
		}
		$responce->rows=$row;
		echo json_encode($responce);
	}
	
	function get_propeller_model(){
		$manufacture_id = $this->input->post('id');
		$models = $this->map_serious_accident->getMasterData('ms_propeller_model', 'name_propeller_model', 'asc', 'id_propeller_make', $manufacture_id,'id_propeller_model,name_propeller_model');
		$row =array();
		foreach($models as $model){
			$row[] = array("nama"=>$model['name_propeller_model'],"id"=>$model['id_propeller_model'] );
		}
		$responce->rows=$row;
		echo json_encode($responce);
	}
	
    function join_match($id){
        $val_date = array();
        $val_airport = array();
        $val_et1 = array();
        $val_et2 = array();
        $data_acc = $this->map_serious_accident->get_serious_in(str_replace("_", ",", $id));
        foreach ($data_acc as $data){
            array_push($val_date, substr($data['acc_datetime_local'], 0, 10));
            array_push($val_airport, $data['nama']);
            array_push($val_et1, $data['et']);
            array_push($val_et2, $data['emergency_type']);
        }
        $val_date = array_unique($val_date);
        $val_airport = array_unique($val_airport);
        $val_et1 = array_unique($val_et1);
        $val_et2 = array_unique($val_et2);
        ((count($val_date) > 1) or (count($val_airport) > 1) or (count($val_et1) > 1) or (count($val_et2) > 1)) ? $match = false : $match = true;
        $responce->match = $match;
        $responce->count = count(explode("_", $id));
        echo json_encode($responce);
    }
    
	function index($search='0',$val='0',$order='0',$by='0',$offset=0) {
		if (is_login_in ()) {
			$query = $this->db->query("SELECT ap_organisasi.id_org
				FROM ap_user
				LEFT JOIN ap_organisasi ON ap_user.kode_organisasi = ap_organisasi.id_org
				LEFT JOIN ap_tipeorg ON ap_organisasi.nm_tipeorg = ap_tipeorg.id_tipeorg
				WHERE ap_tipeorg.nm_tipeorg  ='AIRLINE' AND ap_user.id_user = " . $this->session->userdata("id_user"));
			$airlines_id = ($query->num_rows()>0) ? $query->row()->id_org : 0;
			//echo $this->db->last_query();
            $data['occ_type'] = $this->config->item('occ_type');
			$data['airport'] = $this->map_serious_accident->getMasterData('ap_airport', 'nama', 'asc');
			$data['kabupaten'] = $this->map_serious_accident->getMasterData('ap_m_kabupaten', 'nama_kabupaten', 'asc');
            $sess_limiter = $this->session->userdata('session_limiter');
			(empty($sess_limiter)) ? $data['limit'] = $this->limit : $data['limit']=$sess_limiter;
            $data['offset'] = $offset;
            $data['search'] = $search;
            $data['val'] = $val;
            $data['order'] = $order;
            $data['by'] = $by;
            $data['default']['max_show'] = $data['limit'];
			$data['user_airlines_id'] = $airlines_id ;
			$data['canAdd'] = $this->canAddSummary();
			$data['canEdit'] = $this->canEditSummary();
			$data['canDelete'] = $this->canDeleteSummary();
			//print_r($data);
            for ($i = 1; $i < 31; $i++) if ($i % 5 == 0) $data['max_show'][$i] = $i;
			//echo 'test'.$this->session->userdata("user_id");
            $this->load->view("ap_serious_accident/index", $data);
        } 
        else {
            redirect("login");
        }
    }   

	
	
    function index_join($search='0',$val='0',$order='0',$by='0',$offset=0){
        if (is_login_in ()) {
			$sess_limiter = $this->session->userdata('session_limiter');
            (empty($sess_limiter)) ? $data['limit'] = $this->limit : $data['limit']=$sess_limiter;
            $data['occ_type'] = $this->config->item('occ_type');
            $data['airport'] = $this->map_serious_accident->getMasterData('ap_airport', 'nama', 'asc');
            $data['kabupaten'] = $this->map_serious_accident->getMasterData('ap_m_kabupaten', 'nama_kabupaten', 'asc');
            
			$data['offset'] = $offset;
            $data['search'] = $search;
            $data['val'] = $val;
            $data['order'] = $order;
            $data['by'] = $by;
            $data['default']['max_show'] = $data['limit'];
			$data['canJoin']= $this->canJoin();
            for ($i = 1; $i < 31; $i++) if ($i % 5 == 0) $data['max_show'][$i] = $i;
            $this->load->view("ap_serious_accident/index_join", $data);
        } 
        else {
            redirect("login");
        }
    }
    function index_followup($search='0',$val='0',$order='0',$by='0',$offset=0){
        if (is_login_in ()) {
            $sess_limiter = $this->session->userdata('session_limiter');
            (empty($sess_limiter)) ? $data['limit'] = $this->limit :$data['limit']=$sess_limiter;
            $data['offset'] = $offset;
            $data['search'] = $search;
            $data['val'] = $val;
            $data['order'] = $order;
            $data['by'] = $by;
            $data['default']['max_show'] = $data['limit'];
            for ($i = 1; $i < 31; $i++) if ($i % 5 == 0) $data['max_show'][$i] = $i;
            $this->load->view("ap_serious_accident/index_followup", $data);
        } 
        else {
            redirect("login");
        }
    }
	function index_followup_ssp($search='0',$val='0',$order='0',$by='0',$offset=0){
        if (is_login_in ()) {
            $sess_limiter = $this->session->userdata('session_limiter');
            (empty($sess_limiter)) ? $data['limit'] = $this->limit :$data['limit']=$sess_limiter;
            $data['offset'] = $offset;
            $data['search'] = $search;
            $data['val'] = $val;
            $data['order'] = $order;
            $data['by'] = $by;
            $data['default']['max_show'] = $data['limit'];
            for ($i = 1; $i < 31; $i++) if ($i % 5 == 0) $data['max_show'][$i] = $i;
            $this->load->view("ap_serious_accident/index_followup_ssp", $data);
        } 
        else {
            redirect("login");
        }
    }
	
    function insert($mode=0) {
        $query = $this->db->query("SELECT ap_organisasi.id_org
			FROM ap_user
			LEFT JOIN ap_organisasi ON ap_user.kode_organisasi = ap_organisasi.id_org
			LEFT JOIN ap_tipeorg ON ap_organisasi.nm_tipeorg = ap_tipeorg.id_tipeorg
			WHERE ap_tipeorg.nm_tipeorg  ='AIRLINE' AND ap_user.id_user = " . $this->session->userdata("id_user"));
		
		$airlines_id = ($query->num_rows()>0) ? $query->row()->id_org : 0;
		$data = array(
            "action_form" => "do_insert",
            "airport" => $this->map_serious_accident->getMasterData('ap_airport', 'nama', 'asc'),
            "airlines" => $this->map_serious_accident->getMasterData('ap_airline', 'nama_airline', 'asc'),
            "type" => $this->map_serious_accident->getMasterData("ap_m_emergency_type", "id_emergency_type", "asc"),
            "aircraft_cat" => $this->map_serious_accident->getMasterData("ap_m_aircraft_category", "aircraft_category_name", "asc"),
            "pase_flight" => $this->map_serious_accident->getMasterData("ap_pase_flight", "name", "asc"),
            "causes" => $this->map_serious_accident->getMasterData("ap_m_acc_causes", "causes_name", "asc"),
            "country" => $this->map_serious_accident->getMasterData("ap_m_negara", "nama_negara", "asc"),
            "province" => $this->map_serious_accident->getMasterData("ap_m_provinsi", "nama_provinsi", "asc"),
			"ap_m_occ_type" => $this->map_serious_accident->getMasterData("ap_m_occ_type", "created_on", "asc"),
			"mode" => $mode,
			"airlines_id"=>$airlines_id,
			"ap_m_gmt" => $this->map_serious_accident->getMasterData("ap_m_gmt", "id", "asc")
        );
        $this->load->view("ap_serious_accident/form", $data);
    }
    function update($mode=0){
        $id = $_POST["id"][0];
		$detail = $this->map_serious_accident->getDetail($id);
        $data = array(
            "mode" => $mode,
			"action_form" => "do_update",
            "detail" => $detail,
            "detail2" => $this->map_serious_accident->getDetail2($id),
            "airport" => $this->map_serious_accident->getMasterData('ap_airport', 'nama', 'asc'),
            "airlines" => $this->map_serious_accident->getMasterData('ap_airline', 'nama_airline', 'asc'),
            "aircraft_cat" => $this->map_serious_accident->getMasterData("ap_m_aircraft_category", "aircraft_category_name", "asc"),
            "pase_flight" => $this->map_serious_accident->getMasterData("ap_pase_flight", "name", "asc"),
            "type" => $this->map_serious_accident->getMasterData("ap_m_emergency_type", "id_emergency_type", "asc"),
            "type_detail" => $this->map_serious_accident->getMasterData("ap_m_occ_detail_type", "id_occ_detail_type", "asc", "occ_type", $detail->id_emergency_type),
            "detail_fac" => $this->map_serious_accident->getMasterData("ap_t_acc_facilities", "id_acc_facilities", "asc", "id_accident", $id),
            "kabupaten" => $this->map_serious_accident->getMasterData("ap_m_kabupaten", "nama_kabupaten", "asc", "id_provinsi", $detail->id_provinsi),
            "province" => $this->map_serious_accident->getMasterData("ap_m_provinsi", "nama_provinsi", "asc"),
            "country" => $this->map_serious_accident->getMasterData("ap_m_negara", "nama_negara", "asc"),
            "causes" => $this->map_serious_accident->getMasterData("ap_m_acc_causes", "causes_name", "asc"),
			"ap_m_occ_type" => $this->map_serious_accident->getMasterData("ap_m_occ_type", "created_on", "asc"),
            "causes_dtl" => $this->map_serious_accident->getMasterData("ap_m_detail_causes", "detail_causes_name", "asc", "id_acc_causes", $detail->id_acc_causes)
            
        );
		$data['injury'] = $this->map_serious_accident->getInjury($id);
		$data['detail_person'] = $this->map_serious_accident->getDetailPerson($id);
        //print_r($data["detail"]);
		$this->load->view("ap_serious_accident/form", $data);
    }
    function delete(){
        $this->load->view("ap_serious_accident/delete");
    }
    function detil($id, $join=0){
        $detail = $this->map_serious_accident->getDetail($id);
        $data = array(
            "occ_type" => $this->config->item('occ_type'),
            "detail" => $detail,
            "detail2" => $this->map_serious_accident->getDetail2($id),
            "airport" => $this->map_serious_accident->getMasterData('ap_airport', 'nama', 'asc'),
            "airlines" => $this->map_serious_accident->getMasterData('ap_airline', 'nama_airline', 'asc'),
            "pase_flight" => $this->map_serious_accident->getMasterData("ap_pase_flight", "name", "asc"),
            "type" => $this->map_serious_accident->getMasterData("ap_m_emergency_type", "id_emergency_type", "asc"),
            "type_detail" => $this->map_serious_accident->getMasterData("ap_m_occ_detail_type", "id_occ_detail_type", "asc", "id_occ_type", $detail->id_emergency_type),
            "gmt" => $this->map_serious_accident->getMasterData('ap_m_gmt', 'name', 'asc'),
            "detail_person" => $this->map_serious_accident->getMasterData("ap_t_acc_personnel", "id", "asc", "id_accident", $id),
            "detail_fac" => $this->map_serious_accident->getMasterData("ap_t_acc_facilities", "id_acc_facilities", "asc", "id_accident", $id),
            "kabupaten" => $this->map_serious_accident->getMasterData("ap_m_kabupaten", "nama_kabupaten", "asc", "id_provinsi", $detail->id_provinsi),
            "province" => $this->map_serious_accident->getMasterData("ap_m_provinsi", "nama_provinsi", "asc"),
            "country" => $this->map_serious_accident->getMasterData("ap_m_negara", "nama_negara", "asc"),
			"ap_m_occ_type" => $this->map_serious_accident->getMasterData("ap_m_occ_type", "created_on", "asc"),
            "causes" => $this->map_serious_accident->getMasterData("ap_m_acc_causes", "causes_name", "asc"),
            "causes_dtl" => $this->map_serious_accident->getMasterData("ap_m_detail_causes", "detail_causes_name", "asc", "id_acc_causes", $detail->id_acc_causes),
            "injury" => $this->map_serious_accident->getMasterData("ap_t_acc_injury_to_person", "id_injury_to_person", "asc", "id_accident", $id),
			"join" => $join,
			"aircraft_cat" => $this->map_serious_accident->getMasterData("ap_m_aircraft_category", "aircraft_category_name", "asc")
        );
		//print_r($detail);
		$data['injury'] = $this->map_serious_accident->getInjury($id);
		$data['detail_person'] = $this->map_serious_accident->getDetailPerson($id);
        $this->load->view("ap_serious_accident/form_view", $data);
    }
    function do_insert() {
		//$row = $this->db->select_max('id_accident')->get('ap_t_acc_accident')->row();
        //$max_id = $row->id_accident+1;
		$is_collison = 0;
		if($this->input->post('count_window')>1) $is_collison  = 1;
        $param_acc_accident = array(
            //'id_accident' => $max_id,
            'id_detail_causes' => $this->input->post('acc_causes_det'),
            'id_gmt' => $this->input->post('acc_gmt_val'),//acc_gmt_val
            'id_emergency_type' => $this->input->post('acc_emergency_type2'),
            'id_org' => $this->session->userdata('id_org'),
            'id_airport' => $this->input->post('id_acc_airport'),
            'airport_txt' => $this->input->post('id_acc_airport_new'),
            'emergency_type' => $this->input->post('acc_emergency_type2'),
            'acc_datetime_local' => $this->input->post('acc_datetime'),
            'acc_datetime_utc' => $this->input->post('acc_utc'),
            'id_provinsi' => $this->input->post('id_provinsi'),
			'provinsi_txt' => $this->input->post('provinsi_txt'),
            'id_kabupaten' => $this->input->post('id_kabupaten'),
			'kabupaten_txt' => $this->input->post('kabupaten_txt'),
            'acc_desc' => $this->input->post('acc_desc'),
            'wind_direction' => $this->input->post('acc_wind_direction'),
            'wind_force' => $this->input->post('acc_wind_force'),
            'light_condition' => $this->input->post('acc_light_condition'),
            'landmark_visible' => $this->input->post('acc_land_mark_visible'),
            'acc_report_date' => date('Y-m-d H:m:s'),
            'acc_report_officer_name' => $this->session->userdata('nama_lengkap'),
            'acc_repot_officer_nip' => $this->session->userdata('nipk'),
            'mgm_facilities' => $this->input->post('acc_manager'),
            'facility_type' => $this->input->post('acc_type_facilities'),
            'failure_of_facility' => $this->input->post('acc_failure_facilities'),
            'facility_operator_name' => $this->input->post('acc_operator_name'),
            'facility_operator_licence_num' => $this->input->post('acc_license_number'),
            'victim_death' => $this->input->post(''),
            'victim_injuries' => $this->input->post('acc_amount_victim'),
            'acc_cronology' => $this->input->post('acc_cronology'),
            'acc_impact' => $this->input->post('acc_impact'),
            'acc_location' => $this->input->post('acc_location_txt'),
            'acc_jml_aircraft' => $this->input->post('count_window'),
            'personnel_count' => $this->input->post('personnel_count'),
            'id_user' => $this->session->userdata('id_user'),
            'id_occ_type_detail' => $this->input->post('acc_emergency_dtl'),
            'is_collison' =>$is_collison,
            'occ_loc' => $this->input->post('acc_location_txt'),
            'occ_loc_zip' => $this->input->post('acc_zipcode'),
            'id_country' => $this->input->post('id_country'),
            'country_txt' => $this->input->post('country_txt'),
            'occ_loc_latitude' => $this->input->post('acc_loc_latitude'),
            'occ_loc_longitude' => $this->input->post('acc_loc_longitude'),
            'dangerous_good_desc' => $this->input->post('acc_dangerous_good'),
            'aircraft_position' => $this->input->post('acc_position_aircraft'),
            'passanger_position' => $this->input->post('acc_position_passanger'),
            'cause_txt' => $this->input->post('acc_causes_other'),
            'aircraft_damage' => $this->input->post('acc_aircraft_damage'),
            'aircraft_damage_path' => $this->input->post('acc_aircraft_damage_file'),
            'other_damage' => $this->input->post('acc_damage'),
            'other_damage_path' => $this->input->post('acc_damage_file'),
            'aircraft_information' => $this->input->post('acc_aircraft_inf'),
            'aid_to_navigation' => $this->input->post('acc_aid_navigation'),
            'communication' => $this->input->post('acc_communication'),
            'followup_after_incident' => $this->input->post('acc_fup_incident'),
            'wreckage_impact' => $this->input->post('acc_wreckage_impact'),
            'wreckage_impact_path' => $this->input->post('acc_wreckage_impact_file'),
            'medical_phatologi' => $this->input->post('acc_medical_pathologi'),
            'fire' => $this->input->post('acc_fire'),
            'survival_aspect' => $this->input->post('acc_survival_aspect'),
            'test_research' => $this->input->post('acc_test_research')
        );
		$this->temp_id_accident = $this->map_serious_accident->InsertAccident($param_acc_accident);//$this->db->insert_id();
		
		//$id_accident 
        $jml_fac = $this->input->post('count_window_fac');
        for($i=0;$i<$jml_fac;$i++){
            $i == 0 ? $x = "" : $x = $i+1;
            $param_ap_t_acc_facilities = array(
                'id_accident' => $this->temp_id_accident ,
                'manager' => $this->input->post('acc_manager'.$x),
                'type' => $this->input->post('acc_type_facilities'.$x),
                'damage' => $this->input->post('acc_failure_facilities'.$x),
                'operator_name' => $this->input->post('acc_operator_name'.$x),
                'license_number' => $this->input->post('acc_license_number'.$x),
                'amount_victim' => $this->input->post('acc_amount_victim'.$x)
            );
			
			
             $this->map_serious_accident->InsertFacilities($param_ap_t_acc_facilities);
        }
		
        $jml_collision = $this->input->post('count_window');
		$parent_id = 0;
		for($i=0;$i<$jml_collision;$i++){
            $i == 0 ? $x = "" : $x = $i;           
            $param_aircraft = array(
                //'id_acc_aircraft' => $max_id_acc, 
				'parent_id_aircraft'=>$parent_id,
                'id_accident' => $this->temp_id_accident, 
                'id_org' => $this->input->post('id_aircraft_airlines'.$x), 
                'id_aircraft_category' => $this->input->post('acc_aircraft_cat'.$x), 
                'id_phase_flight' => $this->input->post('acc_flight_phase'.$x), 
                'airlines_txt' => $this->input->post('airlines_txt'.$x), 
                'reg_number' => $this->input->post('aircraft_reg_number_value'.$x), 
				'reg_number_id' => $this->input->post('aircraft_reg_number_id'.$x), 
                'aircraft_type' => $this->input->post('id_aircraft_type_value'.$x), 
                'flight_number' => $this->input->post('aircraft_flight_number'.$x), 
                'arrival' => $this->input->post('id_aircraft_arrival'.$x), 
                'arrival_txt' => $this->input->post('arrival_txt'.$x), 
                'departure' => $this->input->post('id_aircraft_departure'.$x), 
                'departure_txt' => $this->input->post('departure_txt'.$x), 
                'name_of_pilot' => $this->input->post('aircraft_pilot'.$x), 
                'longitude' => $this->input->post('aircraft_longitude'.$x), 
                'latitude' => $this->input->post('aircraft_latitude'.$x), 
                'altitude' => $this->input->post('aircraft_altitude'.$x), 
                'heading' => $this->input->post('aircraft_heading'.$x), 
                'speed_of_aircraft' => $this->input->post('aircraft_speed'.$x), 
                'runway' => $this->input->post('aircraft_runway'.$x), 
                'taxiway' => $this->input->post('aircraft_taxiway'.$x), 
                'aircraft_collor' => $this->input->post('aircraft_color'.$x), 
                'etimat_time_arrival' => $this->input->post('aircraft_eta'.$x), 
                'remaining_time_come' => $this->input->post('aircraft_remaining'.$x), 
                'amount_passenger' => $this->input->post(''), 
                'amount_crew' => $this->input->post(''), 
                'amount_fuel' => $this->input->post(''), 
                'victim_death' => $this->input->post(''), 
                'victim_injuries' => $this->input->post(''), 
                'desc_trouble' => $this->input->post('aircraft_trouble'.$x)
            );
			$id_acc_aircraft= $this->map_serious_accident->InsertAccidentAircraft($param_aircraft);
			if($i==0) $parent_id =$id_acc_aircraft;
			
			$param_acc_injury_to_person = array(
				'id_accident' => $this->temp_id_accident,
				'id_acc_aircraft' => $id_acc_aircraft,
				'fatal_flight_crew' => $this->input->post('fc_fatal'.$x),
				'serious_flight_crew' => $this->input->post('fc_serious'.$x),
				'minor_flight_crew' => $this->input->post('fc_minor'.$x),
				'non_injury_flight_crew' => $this->input->post('fc_non_injury'.$x),
				'total_flight_crew' => $this->input->post('total_fc'.$x),
				'fatal_passanger' => $this->input->post('pass_fatal'.$x),
				'serious_passanger' => $this->input->post('pass_serious'.$x),
				'minor_passanger' => $this->input->post('pass_minor'.$x),
				'nil_injury_passanger' => $this->input->post('pass_non_injury'.$x),
				'total_passanger' => $this->input->post('total_pass'.$x),
				'fatal_total_in_aircraft' => $this->input->post('total_fatal'.$x),
				'serious_total_in_aircraft' => $this->input->post('total_serious'.$x),
				'minor_total_in_aircraft' => $this->input->post('total_minor'.$x),
				'nil_injury_total_in_aircraft' => $this->input->post('total_non_injury'.$x),
				'total_in_aircraft' => $this->input->post('total_in_aircraft'.$x),
				'fatal_other' => $this->input->post('other_fatal'.$x),
				'serious_other' => $this->input->post('other_serious'.$x),
				'minor_other' => $this->input->post('other_minor'.$x),
				'nil_injury_other' => $this->input->post('other_non_injury'.$x),
				'total_other' => $this->input->post('total_other'.$x),
			);	

			$param_acc_injury_to_person['fatal_total_in_aircraft'] = $param_acc_injury_to_person['fatal_flight_crew'] + $param_acc_injury_to_person['fatal_passanger'];
			$param_acc_injury_to_person['serious_total_in_aircraft'] = $param_acc_injury_to_person['serious_flight_crew'] + $param_acc_injury_to_person['serious_passanger'];
			$param_acc_injury_to_person['minor_total_in_aircraft'] = $param_acc_injury_to_person['minor_flight_crew'] + $param_acc_injury_to_person['minor_passanger'];
			$param_acc_injury_to_person['nil_injury_total_in_aircraft'] = $param_acc_injury_to_person['non_injury_flight_crew'] + $param_acc_injury_to_person['nil_injury_passanger'];
			
			$param_acc_injury_to_person['total_flight_crew'] = $param_acc_injury_to_person['fatal_flight_crew'] + $param_acc_injury_to_person['serious_flight_crew'] + $param_acc_injury_to_person['minor_flight_crew'] + $param_acc_injury_to_person['non_injury_flight_crew'];
			$param_acc_injury_to_person['total_passanger'] = $param_acc_injury_to_person['fatal_passanger'] + $param_acc_injury_to_person['serious_passanger'] + $param_acc_injury_to_person['minor_passanger'] + $param_acc_injury_to_person['nil_injury_passanger'];
			$param_acc_injury_to_person['total_in_aircraft'] = $param_acc_injury_to_person['fatal_total_in_aircraft'] + $param_acc_injury_to_person['serious_total_in_aircraft'] + $param_acc_injury_to_person['minor_total_in_aircraft'] + $param_acc_injury_to_person['nil_injury_total_in_aircraft'];
			$param_acc_injury_to_person['total_other'] = $param_acc_injury_to_person['fatal_other'] + $param_acc_injury_to_person['serious_other'] + $param_acc_injury_to_person['minor_other'] + $param_acc_injury_to_person['nil_injury_other'];
				
			$this->map_serious_accident->InsertInjuryPerson($param_acc_injury_to_person);
			
			if($i>0) $personnel_count = $this->input->post('personnel_count'.$i);
			else $personnel_count = $this->input->post('personnel_count');	
			
            if($i == 0) for($j=0; $j<$personnel_count; $j++){
                $param_personnel = array(
                    'id_acc_aircraft' => $id_acc_aircraft,
                    'first_name' => $_POST['person_name'][$j],
                    'identity' => $_POST['person_identity'][$j],
					'aviation_registration'=> $_POST['person_identity_no'][$j]					
                );
				$this->map_serious_accident->InsertAircraftPersonnel($param_personnel);
            }   
        }
    }
    function do_update() {
        $id_accident = $this->input->post('id_accident');
		$is_collison = 0;
		if($this->input->post('count_window')>1) $is_collison  = 1;
        $param_acc_accident = array(
            'id_detail_causes' => $this->input->post('acc_causes_det'),
            'id_gmt' => $this->input->post('acc_gmt_val'),
            'id_emergency_type' => $this->input->post('acc_emergency_type2'),
            'id_org' => $this->session->userdata('id_org'),
            'id_airport' => $this->input->post('id_acc_airport'),
            'airport_txt' => $this->input->post('id_acc_airport_new'),
            'emergency_type' => $this->input->post('acc_emergency_type2'),
            'acc_datetime_local' => $this->input->post('acc_datetime'),
            'acc_datetime_utc' => $this->input->post('acc_utc'),
            'id_provinsi' => $this->input->post('acc_province'),
            'id_kabupaten' => $this->input->post('acc_district'),
            'acc_desc' => $this->input->post('acc_desc'),
            'wind_direction' => $this->input->post('acc_wind_direction'),
            'wind_force' => $this->input->post('acc_wind_force'),
            'light_condition' => $this->input->post('acc_light_condition'),
            'weather_data' => $this->input->post(''),
            'landmark_visible' => $this->input->post('acc_land_mark_visible'),
			'mgm_facilities' => $this->input->post('acc_manager'),
            'facility_type' => $this->input->post('acc_type_facilities'),
            'failure_of_facility' => $this->input->post('acc_failure_facilities'),
            'facility_operator_name' => $this->input->post('acc_operator_name'),
            'facility_operator_licence_num' => $this->input->post('acc_license_number'),
            'victim_death' => $this->input->post(''),
            'victim_injuries' => $this->input->post(''),
            'acc_cronology' => $this->input->post('acc_cronology'),
            'acc_impact' => $this->input->post('acc_impact'),
            'acc_location' => $this->input->post('acc_location_txt'),
            'acc_jml_aircraft' => $this->input->post('count_window'),
            'personnel_count' => $this->input->post('personnel_count'),
            'id_user' => $this->session->userdata('id_user'),
            'id_occ_type_detail' => $this->input->post('acc_emergency_dtl'),
            'is_collison' => $is_collison ,
            'occ_loc' => $this->input->post('acc_location_txt'),
            'occ_loc_zip' => $this->input->post('acc_zipcode'),
            'id_country' => $this->input->post('acc_country'),
            'country_txt' => $this->input->post('country_txt'),
            'occ_loc_latitude' => $this->input->post('acc_loc_latitude'),
            'occ_loc_longitude' => $this->input->post('acc_loc_longitude'),
            'dangerous_good_desc' => $this->input->post('acc_dangerous_good'),
            'aircraft_position' => $this->input->post('acc_position_aircraft'),
            'passanger_position' => $this->input->post('acc_position_passanger'),
            'cause_txt' => $this->input->post('acc_causes_other'),
            'aircraft_damage' => $this->input->post('acc_aircraft_damage'),
            'aircraft_damage_path' => $this->input->post('acc_aircraft_damage_file'),
            'other_damage' => $this->input->post('acc_damage'),
            'other_damage_path' => $this->input->post('acc_damage_file'),
            'aircraft_information' => $this->input->post('acc_aircraft_inf'),
            'aid_to_navigation' => $this->input->post('acc_aid_navigation'),
            'communication' => $this->input->post('acc_communication'),
            'followup_after_incident' => $this->input->post('acc_fup_incident'),
            'wreckage_impact' => $this->input->post('acc_wreckage_impact'),
            'wreckage_impact_path' => $this->input->post('acc_wreckage_impact_file'),
            'medical_phatologi' => $this->input->post('acc_medical_pathologi'),
            'fire' => $this->input->post('acc_fire'),
            'survival_aspect' => $this->input->post('acc_survival_aspect'),
            'test_research' => $this->input->post('acc_test_research')
        );		
		$this->map_serious_accident->UpdateAccident($id_accident,$param_acc_accident);
		//echo $this->db->last_query();
		
        $jml_collision = $this->input->post('count_window');
		$ids = '';
		//echo '$jml_collision'.$jml_collision;
        for($i=0;$i<$jml_collision;$i++){
            $i == 0 ? $x = "" : $x = $i;
            //$row = $this->db->select_max('id_acc_aircraft')->get('ap_t_acc_aircraft')->row();
            //$max_id_acc = $row->id_acc_aircraft+1;
            $param_aircraft = array(
                //'id_acc_aircraft' => $max_id_acc, 
                'id_accident' =>$id_accident, 
                'id_org' => $this->input->post('id_aircraft_airlines'.$x),
                'id_aircraft_category' => $this->input->post('acc_aircraft_cat'.$x),  
                'id_phase_flight' => $this->input->post('acc_flight_phase'.$x), 
                'airlines_txt' => $this->input->post('airlines_txt'.$x), 
                'reg_number' => $this->input->post('aircraft_reg_number_value'.$x),  
				'reg_number_id' => $this->input->post('aircraft_reg_number_id'.$x),
                'aircraft_type' => $this->input->post('id_aircraft_type_value'.$x), 
                'flight_number' => $this->input->post('aircraft_flight_number'.$x), 
                'arrival' => $this->input->post('id_aircraft_arrival'.$x), 
                'arrival_txt' => $this->input->post('arrival_txt'.$x), 
                'departure' => $this->input->post('id_aircraft_departure'.$x), 
                'departure_txt' => $this->input->post('departure_txt'.$x), 
                'name_of_pilot' => $this->input->post('aircraft_pilot'.$x), 
                'longitude' => $this->input->post('aircraft_longitude'.$x), 
                'latitude' => $this->input->post('aircraft_latitude'.$x), 
                'altitude' => $this->input->post('aircraft_altitude'.$x), 
                'heading' => $this->input->post('aircraft_heading'.$x), 
                'speed_of_aircraft' => $this->input->post('aircraft_speed'.$x), 
                'runway' => $this->input->post('aircraft_runway'.$x), 
                'taxiway' => $this->input->post('aircraft_taxiway'.$x), 
                'aircraft_collor' => $this->input->post('aircraft_color'.$x), 
                'etimat_time_arrival' => $this->input->post('aircraft_eta'.$x), 
                'remaining_time_come' => $this->input->post('aircraft_remaining'.$x), 
                'amount_passenger' => $this->input->post(''), 
                'amount_crew' => $this->input->post(''), 
                'amount_fuel' => $this->input->post(''), 
                'victim_death' => $this->input->post(''), 
                'victim_injuries' => $this->input->post(''), 
                'desc_trouble' => $this->input->post('aircraft_trouble'.$x)
            );
			$id_acc_aircraft = $this->input->post('id_acc_aircraft'.$x);
			if($id_acc_aircraft!='') $this->map_serious_accident->UpdateAccidentAircraft($id_acc_aircraft,$param_aircraft);
			else $id_acc_aircraft = $this->map_serious_accident->InsertAccidentAircraft($param_aircraft);
			
			
			if($ids=='') $ids = $id_acc_aircraft;
			else $ids .=','.$id_acc_aircraft;
			
			$param_acc_injury_to_person = array(
				'id_accident' => $id_accident,
				'id_acc_aircraft'=>$id_acc_aircraft,
				'fatal_flight_crew' => $this->input->post('fc_fatal'.$x),
				'serious_flight_crew' => $this->input->post('fc_serious'.$x),
				'minor_flight_crew' => $this->input->post('fc_minor'.$x),
				'non_injury_flight_crew' => $this->input->post('fc_non_injury'.$x),
				'total_flight_crew' => $this->input->post('total_fc'.$x),
				'fatal_passanger' => $this->input->post('pass_fatal'.$x),
				'serious_passanger' => $this->input->post('pass_serious'.$x),
				'minor_passanger' => $this->input->post('pass_minor'.$x),
				'nil_injury_passanger' => $this->input->post('pass_non_injury'.$x),
				'total_passanger' => $this->input->post('total_pass'.$x),
				'fatal_total_in_aircraft' => $this->input->post('total_fatal'.$x),
				'serious_total_in_aircraft' => $this->input->post('total_serious'.$x),
				'minor_total_in_aircraft' => $this->input->post('total_minor'.$x),
				'nil_injury_total_in_aircraft' => $this->input->post('total_non_injury'.$x),
				'total_in_aircraft' => $this->input->post('total_in_aircraft'.$x),
				'fatal_other' => $this->input->post('other_fatal'.$x),
				'serious_other' => $this->input->post('other_serious'.$x),
				'minor_other' => $this->input->post('other_minor'.$x),
				'nil_injury_other' => $this->input->post('other_non_injury'.$x),
				'total_other' => $this->input->post('total_other'.$x),
			);
			
			$param_acc_injury_to_person['fatal_total_in_aircraft'] = $param_acc_injury_to_person['fatal_flight_crew'] + $param_acc_injury_to_person['fatal_passanger'];
			$param_acc_injury_to_person['serious_total_in_aircraft'] = $param_acc_injury_to_person['serious_flight_crew'] + $param_acc_injury_to_person['serious_passanger'];
			$param_acc_injury_to_person['minor_total_in_aircraft'] = $param_acc_injury_to_person['minor_flight_crew'] + $param_acc_injury_to_person['minor_passanger'];
			$param_acc_injury_to_person['nil_injury_total_in_aircraft'] = $param_acc_injury_to_person['non_injury_flight_crew'] + $param_acc_injury_to_person['nil_injury_passanger'];
			
			$param_acc_injury_to_person['total_flight_crew'] = $param_acc_injury_to_person['fatal_flight_crew'] + $param_acc_injury_to_person['serious_flight_crew'] + $param_acc_injury_to_person['minor_flight_crew'] + $param_acc_injury_to_person['non_injury_flight_crew'];
			$param_acc_injury_to_person['total_passanger'] = $param_acc_injury_to_person['fatal_passanger'] + $param_acc_injury_to_person['serious_passanger'] + $param_acc_injury_to_person['minor_passanger'] + $param_acc_injury_to_person['nil_injury_passanger'];
			$param_acc_injury_to_person['total_in_aircraft'] = $param_acc_injury_to_person['fatal_total_in_aircraft'] + $param_acc_injury_to_person['serious_total_in_aircraft'] + $param_acc_injury_to_person['minor_total_in_aircraft'] + $param_acc_injury_to_person['nil_injury_total_in_aircraft'];
			$param_acc_injury_to_person['total_other'] = $param_acc_injury_to_person['fatal_other'] + $param_acc_injury_to_person['serious_other'] + $param_acc_injury_to_person['minor_other'] + $param_acc_injury_to_person['nil_injury_other'];
			
			$id_injury_to_person =  $this->map_serious_accident->getKey('ap_t_acc_injury_to_person','id_acc_aircraft',
									$id_acc_aircraft,'id_injury_to_person');
			//echo "#".$this->db->last_query();
			if($id_injury_to_person>0) $this->map_serious_accident->UpdateInjuryPerson($id_injury_to_person,$param_acc_injury_to_person);
			else $this->map_serious_accident->InsertInjuryPerson($param_acc_injury_to_person);
			//echo $this->db->last_query();
        }        
		$this->map_serious_accident->DeleteUnusedAccidentAircraft($ids,$id_accident);		
		$this->map_serious_accident->DeleteUnusedInjuryPerson($ids,$id_accident);
		
        $jml_fac = $this->input->post('count_window_fac');
        for($i=0;$i<$jml_fac;$i++){
            $i == 0 ? $x = "" : $x = $i+1;
            $param_ap_t_acc_facilities = array(
                'id_accident' => $id_accident,
                'manager' => $this->input->post('acc_manager'.$x),
                'type' => $this->input->post('acc_type_facilities'.$x),
                'damage' => $this->input->post('acc_failure_facilities'.$x),
                'operator_name' => $this->input->post('acc_operator_name'.$x),
                'license_number' => $this->input->post('acc_license_number'.$x),
                'amount_victim' => $this->input->post('acc_amount_victim'.$x)
            );
			$id_acc_facilities = $this->input->post('id_acc_facilities'.$x);
			if($id_acc_facilities=="") $this->map_serious_accident->InsertFacilities($param_ap_t_acc_facilities);
			else $this->map_serious_accident->UpdateFacilities($id_acc_facilities,$param_ap_t_acc_facilities);
			//echo $this->db->last_query();
        }
        
		
        
		
    }
    function do_delete() {
        $id = $this->input->post("id");
        for ($i = 0; $i < count($id); $i++) {
            $this->map_serious_accident->delete($id[$i]);
            echo "#cen_right table tr#id_$id[$i], ";
        }
    }

    function join_form($id_serious){
        $data['id_serious'] = str_replace("_", ",", $id_serious);
        $data['list_serious'] = $this->map_serious_accident->get_serious_in($data['id_serious']);
        $this->load->view("ap_serious_accident/form_join", $data);
    }
	
	
	function join_form_edit($id_parent){
        $list_serious = $this->map_serious_accident->get_serious_in(null, $id_parent);
        $param['substr(a.acc_datetime_local,1,10)'] = substr($list_serious[0]['acc_datetime_local'],0,10);
        $param['a.id_airport'] = $list_serious[0]['id_airport'];
        $param['a.emergency_type'] = $list_serious[0]['et'];
        $param['a.id_emergency_type'] = $list_serious[0]['id_emergency_type'];
		$data['list_serious_add'] = $this->map_serious_accident->get_serious_in(null, $id_parent, $param);
        
		$data['list_serious'] = $list_serious;
        $data['id_parent'] = $id_parent;
        $this->load->view("ap_serious_accident/form_join_edit", $data);
    }
    function do_join(){
        $id_serious = array_filter(explode(",", $this->input->post('id')), 'strlen');
		$this->input->post('parent') ? $parent = $this->input->post('parent') : $parent = $id_serious[0];
        if(count($id_serious) > 0){
			for($i=0;$i<count($id_serious);$i++){
				$param = array();
				$param['id_accident'] = $id_serious[$i];
				$param['id_t_acc_parent'] = $parent;
				$param['id_user'] = $this->session->userdata('id_user');
				$param['id_org_reporter'] = $this->map_serious_accident->get_org($id_serious[$i]);
				$param['join_date'] = date("Y-m-d H:i:s");
				$param['ssp_desc'] = $this->input->post('desc');
				$param['join_status'] = 1;
				$param['status_report'] = 1;
				//$this->map_serious_accident->InsertSSPJoin($param2);
				$this->db->insert('ap_t_acc_ssp_join', $param);
			}
			$param2['ssp_desc'] = $this->input->post('desc');
			$this->map_serious_accident->UpdateSSPJoin($parent,$param2);
			//$this->db->where('id_t_acc_parent', $parent)->update('ap_t_acc_ssp_join', $param2);
			$data['insert'] = TRUE;
			$data['msg'] = "Successfully joining serious accident / incident data.";
			echo json_encode($data);
		}
		else if ($this->input->post('parent')){
			$param['ssp_desc'] = $this->input->post('desc');
			$this->map_serious_accident->UpdateSSPJoin($parent,$param);
			//$this->db->where('id_t_acc_parent', $parent);
			//$this->db->update('ap_t_acc_ssp_join', $param);
			$data['insert'] = TRUE;
			$data['msg'] = "Successfully update serious accident / incident data.";
			echo json_encode($data);
		}
    }
    function detil_join_ssp($id, $id_join_first, $mode=1){
        $data = array(
            "occ_type" => $this->config->item('occ_type'),
            "kabupaten" => $this->map_serious_accident->getMasterData("ap_m_kabupaten", "nama_kabupaten", "asc", "id_provinsi", $detail->id_provinsi),
            "province" => $this->map_serious_accident->getMasterData("ap_m_provinsi", "nama_provinsi", "asc"),
            "country" => $this->map_serious_accident->getMasterData("ap_m_negara", "nama_negara", "asc"),
            "causes" => $this->map_serious_accident->getMasterData("ap_m_acc_causes", "causes_name", "asc"),
            "causes_dtl" => $this->map_serious_accident->getMasterData("ap_m_detail_causes", "detail_causes_name", "asc", "id_acc_causes", $detail->id_acc_causes),
            "injury" => $this->map_serious_accident->getMasterData("ap_t_acc_injury_to_person", "id_injury_to_person", "asc", "id_accident", $id),
            "airport" => $this->map_serious_accident->getMasterData('ap_airport', 'nama', 'asc'),
            "airlines" => $this->map_serious_accident->getMasterData('ap_airline', 'nama_airline', 'asc'),
            "gmt" => $this->map_serious_accident->getMasterData('ap_m_gmt', 'name', 'asc'),
            "type" => $this->map_serious_accident->getMasterData("ap_m_emergency_type", "id_emergency_type", "asc"),
            "pase_flight" => $this->map_serious_accident->getMasterData("ap_pase_flight", "name", "asc"),
            "detil_join" => $this->map_serious_accident->getDetailJoin($id),
			"detail_followup" => $this->map_serious_accident->get_detail_followup($id_join_first, $this->session->userdata('id_user')),
            "id_parent" => $id,
			"id_join" => $id_join_first,
			"mode" => $mode
        );
		$this->load->view("ap_serious_accident/form_join_view", $data);
    }
	function detil_join($id, $id_join_first, $mode=1){
        $detail_followup = $this->map_serious_accident->get_detail_followup($id_join_first, $this->session->userdata('id_user'));
        $data = array(
            "occ_type" => $this->config->item('occ_type'),
            "kabupaten" => $this->map_serious_accident->getMasterData("ap_m_kabupaten", "nama_kabupaten", "asc", "id_provinsi", $detail->id_provinsi),
            "province" => $this->map_serious_accident->getMasterData("ap_m_provinsi", "nama_provinsi", "asc"),
            "country" => $this->map_serious_accident->getMasterData("ap_m_negara", "nama_negara", "asc"),
            "causes" => $this->map_serious_accident->getMasterData("ap_m_acc_causes", "causes_name", "asc"),
            "causes_dtl" => $this->map_serious_accident->getMasterData("ap_m_detail_causes", "detail_causes_name", "asc", "id_acc_causes", $detail->id_acc_causes),
            "injury" => $this->map_serious_accident->getMasterData("ap_t_acc_injury_to_person", "id_injury_to_person", "asc", "id_accident", $id),
            "airport" => $this->map_serious_accident->getMasterData('ap_airport', 'nama', 'asc'),
            "airlines" => $this->map_serious_accident->getMasterData('ap_airline', 'nama_airline', 'asc'),
            "gmt" => $this->map_serious_accident->getMasterData('ap_m_gmt', 'name', 'asc'),
            "type" => $this->map_serious_accident->getMasterData("ap_m_emergency_type", "id_emergency_type", "asc"),
            "pase_flight" => $this->map_serious_accident->getMasterData("ap_pase_flight", "name", "asc"),
            "detil_join" => $this->map_serious_accident->getDetailJoin($id, $this->session->userdata('id_org')),
			"detail_followup" => $detail_followup,
            "id_acc_followup" => $this->map_serious_accident->get_acc_followup(@$detail_followup->id_user, @$detail_followup->id_org),
			"id_parent" => $id, "id_join" => $id_join_first, 
			"mode" => $mode
        );
        $this->load->view("ap_serious_accident/form_join_view", $data);
    }
	function detail_aircraft($id){
		$data['aircraft'] = $this->map_serious_accident->detail_aircraft($id);
		$this->load->view("ap_serious_accident/dtl_aircraft", $data);
	}
	function do_followup(){
        $this->load->library('form_validation');
		log_message('INFO', 'do_followup start');
        $this->form_validation->set_rules('fup_docnam', 'Document Name', 'required');
        $this->form_validation->set_rules('fup_desc', 'Description', 'required');
		if ($this->form_validation->run() == FALSE){
            $data['validation'] = FALSE;
            $data['msg'] = validation_errors();
			log_message('INFO', 'do_followup start 1');
        }
        else {
            log_message('INFO', 'do_followup start 2');
			$data['validation'] = TRUE;
			$config['upload_path'] = './assets/upload/dgca_follow_up/serious_incident/';
			$config['allowed_types'] = 'pdf|doc|docx|xls|xlsx';
			$file_fup = $_FILES['fup_file'];
			if(!empty($file_fup['name'])){
				log_message('INFO', 'do_followup start 3');
				$this->load->library('upload', $config);
				!$this->upload->do_upload('fup_file') ? $upload = FALSE : $upload = TRUE;
				$data['upload'] = $upload;
				($upload == TRUE) ? $desc = $this->upload->data() : $data['msg'] = $this->upload->display_errors();
			}
			else {
				log_message('INFO', 'do_followup start 4');
				$upload = TRUE;
			}
			log_message('INFO', 'do_followup start 5');
			$param['id_t_acc_ssp_join'] = $this->input->post('id_join');
            $param['id_org'] = $this->session->userdata("id_org");
            $param['id_user'] = $this->session->userdata("id_user");
            $param['followup_date'] = $this->input->post('fup_date');
            $param['followup_desc'] = $this->input->post('fup_desc');
            $param['followup_name_file'] = $this->input->post('fup_docnam');
            $param['followup_referense_no'] = $this->input->post('fup_refno');
            $param['followup_file_path'] = @$desc['file_name'];
            $param['id_org_repoter'] = null;
            $param['status_report'] = 1;
			$mode = $this->input->post('mode_input');
			if($upload == TRUE){
				log_message('INFO', 'do_followup start 6');
				if($mode == 1){
					log_message('INFO', 'do_followup start 7');
                    $msg = "mengupdate";
                    $this->do_update();
					$this->map_serious_accident->UpdateFollowUp($this->input->post('id_followup'),$param);
					//$this->db->where('id_t_acc_followup', $this->input->post('id_followup'));
					//$Q = $this->db->update('ap_t_acc_followup', $param);
				}
				else {
					log_message('INFO', 'do_followup start 8');
					$msg = "menginput";
                    $this->do_insert();
					$last_id = $this->temp_id_accident;
					log_message('INFO', 'do_followup last_id : '.$last_id);
					$param_join['id_accident'] = $last_id;
					$param_join['id_t_acc_parent'] = $this->input->post('id_parent');
					$param_join['id_user'] = $this->session->userdata('id_user');
					$param_join['id_org_reporter'] = $this->map_serious_accident->get_org($last_id);
					$param_join['join_date'] = date("Y-m-d H:i:s");
					$param_join['join_status'] = 1;
					$param_join['status_report'] = 1;
					
					$this->map_serious_accident->InsertSSPJoin($param_join);
					$this->map_serious_accident->InsertFollowUp($param);
					//$this->db->insert('ap_t_acc_ssp_join', $param_join);
					//$Q = $this->db->insert('ap_t_acc_followup', $param);
				}
				if($Q) {
					log_message('INFO', 'do_followup start 9');
					$data['insert'] = TRUE;
					$data['msg'] = "Berhasil " .$msg. " data Follow Up.";
				}
				else {
					log_message('INFO', 'do_followup start 10');
					$data['insert'] = FALSE;
					$data['msg'] = "Gagal menginput data Follow Up.";
				}
			}
        }
        echo json_encode($data);
    }
	function followup_form($id=null){
		$detail = $this->map_serious_accident->getDetail($id);
		$data = array(
            "occ_type" => $this->config->item('occ_type'),
            "detail" => $detail,
            "detail2" => $this->map_serious_accident->getDetail2($id),
            "airport" => $this->map_serious_accident->getMasterData('ap_airport', 'nama', 'asc'),
            "airlines" => $this->map_serious_accident->getMasterData('ap_airline', 'nama_airline', 'asc'),
            "pase_flight" => $this->map_serious_accident->getMasterData("ap_pase_flight", "name", "asc"),
            "type" => $this->map_serious_accident->getMasterData("ap_m_emergency_type", "id_emergency_type", "asc"),
            "type_detail" => $this->map_serious_accident->getMasterData("ap_m_occ_detail_type", "id_occ_detail_type", "asc", "occ_type", $detail->id_emergency_type),
            "gmt" => $this->map_serious_accident->getMasterData('ap_m_gmt', 'name', 'asc'),
            "detail_person" => $this->map_serious_accident->getMasterData("ap_t_acc_personnel", "id_acc_aircraft_personnel", "asc", "id_accident", $id),
            "detail_fac" => $this->map_serious_accident->getMasterData("ap_t_acc_facilities", "id_acc_facilities", "asc", "id_accident", $id),
            "kabupaten" => $this->map_serious_accident->getMasterData("ap_m_kabupaten", "nama_kabupaten", "asc", "id_provinsi", $detail->id_provinsi),
            "province" => $this->map_serious_accident->getMasterData("ap_m_provinsi", "nama_provinsi", "asc"),
            "country" => $this->map_serious_accident->getMasterData("ap_m_negara", "nama_negara", "asc"),
            "causes" => $this->map_serious_accident->getMasterData("ap_m_acc_causes", "causes_name", "asc"),
            "causes_dtl" => $this->map_serious_accident->getMasterData("ap_m_detail_causes", "detail_causes_name", "asc", "id_acc_causes", $detail->id_acc_causes),
            "injury" => $this->map_serious_accident->getMasterData("ap_t_acc_injury_to_person", "id_injury_to_person", "asc", "id_accident", $id)
        );
        $this->load->view('ap_serious_accident/form_fup', $data);
	}
    
    function upload(){
        $config['upload_path'] = './assets/upload/serious_accident/';
        $config['allowed_types'] = 'pdf|doc|docx|xls|xlsx|jpg|jpeg|png|gif';
        $this->load->library('upload', $config);
        if ($this->upload->do_upload('file')) {
            $desc = $this->upload->data();
            $data['upload'] = TRUE;
            $data['msg'] = @$desc['file_name'];
			//C:\xampp\htdocs\aplikasi\assets\upload\serious_accident
			$data['url'] = base_url()."assets/upload/serious_accident/".@$desc['orig_name'];//@$desc['file_name'];
			$data['orig_name'] =@$desc['orig_name'];
			$data['file_name'] =@$desc['raw_name'];
        } 
        else {
            $data['upload'] = FALSE;
            $data['msg'] = $this->upload->display_errors();
        }
        echo json_encode($data);
    }
	function doc_print_dlg($id){
		$data['id_accident'] = $id;
		$this->load->view("ap_serious_accident/print_dlg", $data);
	}
	function doc_print($id_serious){
		$type = $this->input->post('print_type');
		$name = $this->input->post('print_title');
		$data = array(
            "type" => $type,
            "name" => $name, 
			"detail" => $this->map_serious_accident->report_dtl($id_serious),
            "aircraft" => $this->map_serious_accident->getDetail2($id_serious),
            "facilities" => $this->map_serious_accident->getMasterData('ap_t_acc_facilities', 'id_acc_facilities', 'asc', 'id_accident', $id_serious),
            "personnel" => $this->map_serious_accident->getMasterData('ap_t_acc_personnel', 'id', 'asc', 'id_accident', $id_serious),
			'InjuryToPerson'=> $this->map_serious_accident->InjuryToPerson($id_serious)
        );
		
		//print_r($data);
		//$data['detail']->occ_type = 'test';
		if ($type == 3){
			$html = $this->load->view("ap_serious_accident/print_1", $data, true);
			$this->load->library('html_to_doc');
			$this->html_to_doc->createDoc($html,empty($name) ? "serious_incident_accident_".date("Y-m-d") : $name,true); 
		}
		else {
			$this->load->view("ap_serious_accident/print_1", $data);
		}		
	}
    
    function otoritas($search='0',$val='0',$order='0',$by='0',$offset=0) {
        if (is_login_in ()) {
            $data['airport'] = $this->map_serious_accident->getMasterData('ap_airport', 'nama', 'asc');
            $data['kabupaten'] = $this->map_serious_accident->getMasterData('ap_m_kabupaten', 'nama_kabupaten', 'asc');
            $sess_limiter = $this->session->userdata('session_limiter');
            (empty($sess_limiter)) ? $data['limit'] = $this->limit : $data['limit']=$sess_limiter;
            $data['offset'] = $offset;
            $data['search'] = $search;
            $data['val'] = $val;
            $data['order'] = $order;
            $data['by'] = $by;
            $data['default']['max_show'] = $data['limit'];
            for ($i = 1; $i < 31; $i++) if ($i % 5 == 0) $data['max_show'][$i] = $i;
            $this->load->view("ap_serious_accident/index_otoritas", $data);
        } 
        else {
            redirect("login");
        }
    }
	
    function chart(){
        $this->load->view("ap_serious_accident/chart");
    }    
    function chart_back($id){
        $data['id'] = $id;
        $this->load->view("serious_accident/index", $data);
    }
    function chart_view($id){
        $data['id_multiseries'] = $id;
        $data['month'] = $this->month;
        $data['bandara'] = $this->input->post('bandara');
        $data['tahun1'] = $this->input->post('tahun1');
        $data['bulan1'] = $this->input->post('bulan1');
        $this->load->view("ap_serious_accident/chart_view_".$id, $data);
    }
    function chart_xml1($bandara='0', $tahun='0', $bulan='0'){
        $data['data'] = $this->map_serious_accident->getMultiSeries1(@$bandara, @$tahun, @$bulan);
        $this->load->view('ap_serious_accident/chart_xml_1', $data);
    }
    function chart_xml2($airline='0', $tahun='0', $bulan='0'){
        $data['data'] = $this->map_serious_accident->getMultiSeries2(@$airline, @$tahun, @$bulan);
        $this->load->view('ap_serious_accident/chart_xml_2', $data);
    }
    function chart_xml3(){
        $data['data'] = $this->map_serious_accident->getMultiSeries3(@$tahun1, @$tahun2);
        $this->load->view('ap_serious_accident/chart_xml_3', $data);
    }
    function chart_xml4($tahun1=0, $tahun2=0){
        $data['data'] = $this->map_serious_accident->getMultiSeries4(@$tahun1, @$tahun2);
        $this->load->view('ap_serious_accident/chart_xml_4', $data);
    }
    function chart_xml5(){
        $data['data'] = $this->map_serious_accident->getMultiSeries5();
        $this->load->view('ap_serious_accident/chart_xml_5', $data);
    }
    
    function do_update_detail(){
        $param_passenger = array(
            'first_name' => $this->input->post('input_name1'),
            'middle_name' => $this->input->post('input_name2'),
            'last_name' => $this->input->post('input_name3'),
            'id_provinsi' => $this->input->post('input_city'),
            'id_kabupaten' => $this->input->post('input_state'),
            'id_country' => $this->input->post('input_country'),
            'zip' => $this->input->post('zip'),
            'seat' => $this->input->post('input_seat'),
            'identity' => $this->input->post('identity'),
            'status' => $this->input->post('status')
        );
		//$this->map_serious_accident->UpdatePassenger
        $this->db->where('id_acc_aircraft', $id_accident);
        $this->db->update('ap_t_acc_aircraft_passengers', $param_passenger);
    }
    
    function form1($id_aircraft){
        $aircraft = $this->map_serious_accident->getMasterData('ap_t_acc_aircraft', 'id_acc_aircraft', 'asc', 'id_acc_aircraft', $id_aircraft, '*');	
		$id_accident = $aircraft[0]['id_accident']; 
		$aircraft = $this->map_serious_accident->getMasterData('ap_t_acc_aircraft', 'id_acc_aircraft', 'asc', 'id_acc_aircraft', $id_aircraft, '*');
        $aircraft_detail = $this->map_serious_accident->getMasterData('ap_t_acc_aircraft_detail', 'id_acc_aircraft', 'asc', 'id_acc_aircraft', $id_aircraft, '*');
        $accident = $this->map_serious_accident->getMasterData('ap_t_acc_accident', 'id_accident', 'asc', 'id_accident', $aircraft[0]['id_accident'], '*');
        $aircraft_cat = $this->map_serious_accident->getMasterData("ap_m_aircraft_category", "aircraft_category_name", "asc");
        $country = $this->map_serious_accident->getMasterData("ap_m_negara", "nama_negara", "asc");
        $province = $this->map_serious_accident->getMasterData("ap_m_provinsi", "nama_provinsi", "asc");
        $kabupaten = $this->map_serious_accident->getMasterData("ap_m_kabupaten", "nama_kabupaten", "asc", "id_provinsi", $accident[0]['id_provinsi']);
        $manufacturer = $this->map_serious_accident->getMasterData('ms_aircraft_make', 'name_aircraft_make', 'asc', null, null, 'id_aircraft_make,name_aircraft_make');
		//$manufacturer = $this->map_serious_accident->getMasterData('ms_aircraft_make', 'code_aircraft_make', 'asc', null, null, 'id_aircraft_make, code_aircraft_make');
		$model = (!empty($aircraft_detail[0]['id_aircraft_make'])) ? $this->map_serious_accident->getMasterData('ms_aircraft_model', 'name_aircraft_model', 'asc', 'id_aircraft_make', $aircraft_detail[0]['id_aircraft_make'], 'id_aircraft_model, name_aircraft_model') : array();
        $propeller_manufacture =  $this->map_serious_accident->getMasterData("ms_propeller_make", "name_propeller_make", "asc", null, null, 'name_propeller_make, id_propeller_make');
		if(!empty($aircraft_detail[0]['id_propeller_make'])) $propeller_model =   $this->map_serious_accident->getMasterData("ms_propeller_model", "name_propeller_model", "asc", "id_propeller_make",  $aircraft_detail[0]['id_propeller_make'], 'id_propeller_model,name_propeller_model');
		else $propeller_model = null;		
		$arr_country[0] = ''; foreach ($country as $negara) $arr_country[$negara['id_negara']] = $negara['nama_negara'];
        $arr_province[0] = ''; foreach ($province as $prop) $arr_province[$prop['id_provinsi']] = $prop['nama_provinsi'];
        $arr_kabupaten[0] = ''; foreach ($kabupaten as $kab) $arr_kabupaten[$kab['id_kabupaten']] = $kab['nama_kabupaten'];
        $airport = $this->map_serious_accident->getMasterData('ap_airport', 'nama', 'asc');
        $arr_airport[0] = ''; foreach ($airport as $ap) $arr_airport[$ap['id']] = '( '.$ap['icao']." - ".$ap['iata'].' ) '.$ap['nama'];
        $arr_manufacturer[0] = ''; foreach ($manufacturer as $manuk) $arr_manufacturer[$manuk['id_aircraft_make']] = $manuk['name_aircraft_make'];
		
        //$arr_model[0] = ''; foreach ($model as $modiel) if (!empty($modiel['name_aircraft_model'])) $arr_model[$modiel['id_aircraft_model']] = $modiel['name_aircraft_model'];
        //print_r($aircraft_detail);
        $data = array(
            "id_aircraft" => $id_aircraft,
            "aircraft" => $aircraft,
            "aircraft_dtl" => $aircraft_detail,
            "aircraft_cat" => $aircraft_cat,
            "country" => $arr_country,
            "province" => $arr_province,
            "kabupaten" => $arr_kabupaten,
            "airport" => $arr_airport,
            "manufacturer" => $arr_manufacturer,
			"model"=>$model,
            //"model" => array(),//$arr_model,
            "accident" => $accident,
			"propeller_manufacture"=>$propeller_manufacture,
			"propeller_model" =>$propeller_model
        );
		$data['canSave'] =$this->canSave($id_accident);
		//echo "test";
		//print_r($data);
        $this->load->view('ap_serious_accident/form_detail_1', $data);
    }
    function submit1($id_acc_aircraft=0){	
		if($id_acc_aircraft==0) return;
        $id_accident = $this->map_serious_accident->getIdAccident($id_acc_aircraft);
		if(!$this->canSave($id_accident)) return;
        $param_accident = array(
            'occ_loc' => $this->input->post('acc_location_txt'),
            'occ_loc_zip' => $this->input->post('acc_zipcode'),
            'id_country' => $this->input->post('acc_country'),
            'id_provinsi' => $this->input->post('acc_province'),
            'id_kabupaten' => $this->input->post('acc_district'),
            'occ_loc_latitude' => $this->input->post('acc_loc_latitude'),
            'occ_loc_longitude' => $this->input->post('acc_loc_longitude'),
            'id_airport' => $this->input->post('id_acc_airport'),
            'acc_datetime_local' => $this->input->post('acc_date_local'),
            'acc_datetime_utc' => $this->input->post('acc_date_utc'),
        );
		$this->map_serious_accident->UpdateAccident($id_accident, $param_accident);
		//echo $this->db->last_query();
        //table ap_t_acc_aircraft
        $param_aircraft = array(
            'id_phase_flight' => $this->input->post('acc_flight_phase'),
			'id_aircraft_category'=>$this->input->post('acc_aircraft_cat')
        );
		$this->map_serious_accident->UpdateAccidentAircraft($id_acc_aircraft, $param_aircraft);
		//$this->db->last_query();
		$tac_std ='';
		$tac_special = '';
		if($tac_std !='') $tac_std = substr( $tac_std,1);
		if($tac_special !='') $tac_special = substr( $tac_special,1);		
		$param_aircraft_detail = array(
            'collision_other' => $this->input->post('acc_other_aircraft'),
            'id_aircraft_make' => $this->input->post('manufacturer'),
            'aircraft_make_name' => $this->input->post('aircraft_make_name'),
            'id_aircraft_model' => $this->input->post('model'),
            'aircraft_model_name' => $this->input->post('aircraft_model_name'),
            'aircraft_serial_number' => $this->input->post('serial_number'),
            'reg_number' => $this->input->post('reg_number'),
            'amateur_built' => $this->input->post('amateur_built'),
            'max_gross_weight' => $this->input->post('max_gross'),
            'weight_at_acc' => $this->input->post('weight_time'),
            'loc_of_center_gravity_at_acc' => $this->input->post('loc_gravity'),
            'loc_of_center_gravity_form' => $this->input->post('loc_gravity_opt'),
            'loc_of_center_gravity_mac' => $this->input->post('loc_gravity_mac'),
            'id_aircraft_category' => $this->input->post('acc_aircraft_cat'),
            'tac_stdr' => $tac_std,
			'tac_stdr_normal' => $this->input->post('tac_stdr_normal'),
			'tac_stdr_utility' => $this->input->post('tac_stdr_utility'),
			'tac_stdr_aerobatic' => $this->input->post('tac_stdr_aerobatic'),
			'tac_stdr_transport' => $this->input->post('tac_stdr_transport'),
			'tac_spc_restricted' => $this->input->post('tac_spc_restricted'),
			'tac_spc_limited' => $this->input->post('tac_spc_limited'),
			'tac_spc_provisional' => $this->input->post('tac_spc_provisional'),
			'tac_spc_experimental' => $this->input->post('tac_spc_experimental'),
			'tac_spc_special_flight' => $this->input->post('tac_spc_special_flight'),
			'tac_spc_light_sport' => $this->input->post('tac_spc_light_sport'),
            'tac_special' => $tac_special,
            'number_of_seats' => $this->input->post('number_seat'),
            'num_of_seat_flight_crew' => $this->input->post('ns_flight_crew'),
            'num_of_seat_cabin_crew' => $this->input->post('ns_cabin_crew'),
            'num_of_seat_passengers' => $this->input->post('ns_passengers'),
            'landing_gear' => $this->input->post('landing_gear'),
            'type_of_maintenance_program' => $this->input->post('maintenance_program'),
            'type_maint_prog_specify' => $this->input->post('maintenance_program_txt'),
            'last_inspection_type' => $this->input->post('last_inspection'),
            'date_last_inspection' => $this->input->post('date_inspection'),
            'airframe_total_time' => $this->input->post('airframe_total'),
            'airframe_hours_measured' => $this->input->post('hours_measured'),
            'ifr_equipped' => $this->input->post('ifr_equipped'),
            'stall_warn_sys_installed' => $this->input->post('stall_warning_sys'),
            'type_fire_extinguishing_sys' => $this->input->post('exti_system'),
            'type_fire_extinguishing_sys_if_specifiy' => $this->input->post('exti_system_txt'),
            'elt_installed' => $this->input->post('elt_installed'),
            'elt_actived' => $this->input->post('elt_activated'),
            'elt_aided_in_loc_acc' => $this->input->post('elt_aided'),
            'elt_manufacture' => $this->input->post('elt_manufacturer'),
            'elt_model' => $this->input->post('elt_model'),
            'elt_seria_number' => $this->input->post('elt_serial_number'),
            'battery_type' => $this->input->post('battery_type'),
            'battery_exp_date' => $this->input->post('battery_date'),
            'engine_type' => $this->input->post('engine_type'),
            'reciprocating_fuel_sys_type' => $this->input->post('reciprocating'),
            'propeller' => $this->input->post('propeller'),
            'id_propeller_make' => $this->input->post('prop_manufacturer'),
            'id_propeller_model' => $this->input->post('prop_model'),
        );
		$id_acc_aircraft_detail =  $this->map_serious_accident->getKey('ap_t_acc_aircraft_detail','id_acc_aircraft',
									$id_acc_aircraft,'id_acc_aircraft_detail');
		//echo $this->db->last_query();
		if($id_acc_aircraft_detail>0) $this->map_serious_accident->UpdateAccidentAircraftDetail($id_acc_aircraft_detail, $param_aircraft_detail); //$this->db->where('id_acc_aircraft_detail', $id_acc_aircraft_detail)->update('ap_t_acc_aircraft_detail', $param_aircraft_detail);						
		else{
			$param_aircraft_detail['id_acc_aircraft']=  $id_acc_aircraft;
			$this->map_serious_accident->InsertAccidentAircraftDetail($param_aircraft_detail);
		}
		//echo $this->db->last_query();
    }
    function form2($id_acc_aircraft){
		$id_accident = $this->map_serious_accident->getIdAccident($id_acc_aircraft);
		$aircraft = $this->map_serious_accident->getMasterData('ap_t_acc_aircraft', 'id_acc_aircraft', 'asc', 'id_acc_aircraft', $id_acc_aircraft, '*');
        $aircraft_own_opr = $this->map_serious_accident->getMasterData('ap_t_acc_aircraft_owner_operator', 'id_acc_aircraft', 'asc', 'id_acc_aircraft', $id_acc_aircraft, '*');
        $aircraft_owner = $this->map_serious_accident->getMasterData('ap_t_acc_aircraft_owner', 'id_acc_aircraft_owner', 'asc', 'id_acc_aircraft_owner_operator', $aircraft_own_opr[0]['id_acc_aircraft_owner_operator'], '*');
        $aircraft_operator = $this->map_serious_accident->getMasterData('ap_t_acc_aircraft_operator', 'id_acc_aircraft_operator', 'asc', 'id_acc_aircraft_owner_operator', $aircraft_own_opr[0]['id_acc_aircraft_owner_operator'], '*');
        $manufacturer = $this->map_serious_accident->getMasterData('ms_aircraft_make', 'name_aircraft_make', 'asc', null, null, 'id_aircraft_make, name_aircraft_make');
        $country = $this->map_serious_accident->getMasterData("ap_m_negara", "nama_negara", "asc");
        $province = $this->map_serious_accident->getMasterData("ap_m_provinsi", "nama_provinsi", "asc");
        $arr_country[0] = ''; foreach ($country as $negara) $arr_country[$negara['id_negara']] = $negara['nama_negara'];
        $arr_province[0] = ''; foreach ($province as $prop) $arr_province[$prop['id_provinsi']] = $prop['nama_provinsi'];
        $arr_manufacturer[0] = ''; foreach ($manufacturer as $manuk) $arr_manufacturer[$manuk['id_aircraft_make']] = $manuk['name_aircraft_make'];
        //print_r($aircraft_owner);
        $data = array(
            "id_aircraft" => $id_acc_aircraft,
            "aircraft" => $aircraft,
            "aircraft_own_opr" => $aircraft_own_opr,
            "owner" => $aircraft_owner,
            "operator" => $aircraft_operator,
            "country" => $arr_country,
            "province" => $arr_province,
            "manufacturer" => $arr_manufacturer
        );
		//print_r($data['aircraft_own_opr']);
		$data['canSave'] = $this->canSave($id_accident);
		//log_message('INFO',print_r($data,true));
        $this->load->view('ap_serious_accident/form_detail_2', $data);
    }
    function submit2($id_acc_aircraft){	
		$id_accident = $this->map_serious_accident->getIdAccident($id_acc_aircraft);
		$commercial_opr ='';
		$regulation_flight = '';
		$temp =$this->input->post('regulation_flight');
		if(!empty($temp)){
			foreach($temp as $val) $regulation_flight .=','.$val;
		}
		
		if($commercial_opr !='') $tac_std = substr( $tac_std,1);
		if($regulation_flight !='') $regulation_flight = substr( $regulation_flight,1);
        $param_owner_opr = array(
            //'id_acc_aircraft_owner_operator' => $max_id,
            'id_acc_aircraft' => $id_acc_aircraft,
            //'id_aircraft' => $this->input->post(''),
            'aircraft_owner_name' => $this->input->post('own_reg_aircraft'),
            //'id_org' => $this->input->post(''),
            'operator_name' => $this->input->post('op_aircraft'),
            'is_same_registered_owner' => $this->input->post('op_same_reg_owner'),
            'rev_sightseeing_flight' => $this->input->post('rev_sight_flight'),
            'air_medical_flight' => $this->input->post('air_medic_flight'),
            'purpose_of_flight' => $this->input->post('purpose_flight'),
            'revenue_operation' => $this->input->post('revenue_opr'),
            'revenue_dom_inter' => $this->input->post('dom_or_int'),
            'cargo_operation' => $this->input->post('carge_opr'),
            'cargo_pass' => $this->input->post('cargo_pass'),
            'cargo_lbs' => $this->input->post('cargo_cargo'),
            'commercial_opr' => $commercial_opr,
			'coch_none' => $this->input->post('coch_none'),
			'coch_flag' => $this->input->post('coch_flag'),
			'coch_supp' => $this->input->post('coch_supp'),
			'coch_air_cargo' => $this->input->post('coch_air_cargo'),
			'coch_foreign' => $this->input->post('coch_foreign'),
			'coch_comm_air' => $this->input->post('coch_comm_air'),
			'coch_on_demand' => $this->input->post('coch_on_demand'),
			'coch_large_heli' => $this->input->post('coch_large_heli'),
			'coch_rotor' => $this->input->post('coch_rotor'),
			'coch_agricultural' => $this->input->post('coch_agricultural'),
			'coch_other' => $this->input->post('coch_other'),
			'regulation_flight'=>$regulation_flight
        );
        $id_acc_aircraft_owner_operator = $this->map_serious_accident->getKey('ap_t_acc_aircraft_owner_operator','id_acc_aircraft',
									$id_acc_aircraft,'id_acc_aircraft_owner_operator');
		if($id_acc_aircraft_owner_operator>0) $this->map_serious_accident->UpdateOwnerOperator($id_acc_aircraft_owner_operator,$param_owner_opr);
		else{
			$id_acc_aircraft_owner_operator = $this->map_serious_accident->InsertOwnerOperator($param_owner_opr);
		}
		echo $this->db->last_query();
		$param_owner = array(
            'id_acc_aircraft_owner_operator' =>$id_acc_aircraft_owner_operator,
            'id_aircraft' => $id_acc_aircraft,
            'aircraft_owner_name' => $this->input->post('own_reg_aircraft'),
            'fractional_ownership' => $this->input->post('own_fractional'),
            'id_country' => $this->input->post('own_country'),
            'id_provinsi' => $this->input->post('own_province'),
            'id_kabupaten' => $this->input->post('own_district'),
            'zip' => $this->input->post('own_zipcode'),
            'first_name_owner' => $this->input->post('own_reg_aircraft'),
            //'middle_name_owner' => $this->input->post('other_own_name2'),
            //'last_name_owner' => $this->input->post('other_own_name3'),
            'id_country_person' => $this->input->post('other_own_country'),
            'id_provinsi_person' => $this->input->post('other_own_province'),
            'id_kabupaten_person' => $this->input->post('other_own_district'),
            'zip_person' => $this->input->post('other_own_zipcode'),
        );		
		$id_acc_aircraft_owner = $this->map_serious_accident->getKey('ap_t_acc_aircraft_owner','id_acc_aircraft_owner_operator',
									$id_acc_aircraft_owner_operator,'id_acc_aircraft_owner');
		echo $this->db->last_query();
		if($id_acc_aircraft_owner>0) $this->map_serious_accident->UpdateOwner($id_acc_aircraft_owner,$param_owner);
		else  $this->map_serious_accident->InsertOwner($param_owner);
		//$this->db->where("id_acc_aircraft_owner",$t_id)->update('ap_t_acc_aircraft_owner', $param_owner);
		//else $this->db->insert('ap_t_acc_aircraft_owner', $param_owner);		
		echo $this->db->last_query();
		//table ap_t_acc_aircraft_operator
        $param_operator = array(
            'id_acc_aircraft_owner_operator' => $id_acc_aircraft_owner_operator,
            'is_same_registered_owner_opr' => $this->input->post('op_same_reg_owner'),
            //'id_org' => $this->input->post(''),
            'aircraft_operator_name' => $this->input->post('op_aircraft'),
            'doing_buss_as' => $this->input->post('op_business'),
            'designator_code' => $this->input->post('op_design_code'),
            'is_same_registered_owner_addrs' => $this->input->post('op_same_reg_owner_addr'),
            'id_country' => $this->input->post('op_country'),
            'id_provinsi' => $this->input->post('op_province'),
            'id_kabupaten' => $this->input->post('op_district'),
            'zip' => $this->input->post('op_zipcode')
        );
        
		$id_acc_aircraft_operator = $this->map_serious_accident->getKey('ap_t_acc_aircraft_operator','id_acc_aircraft_owner_operator',
									$id_acc_aircraft_owner_operator,'id_acc_aircraft_operator');
		if($id_acc_aircraft_operator>0) $this->map_serious_accident->UpdateOperator($id_acc_aircraft_operator,$param_operator);
		else $this->map_serious_accident->InsertOperator($param_operator);
        
		$param_aircraft = array(
            'reg_number' => $this->input->post('reg_number'),
            'aircraft_damage_other' => $this->input->post('damage_other'),
            'mechanical_malfunction' => $this->input->post('mechanical_failure'),
            'mechanical_malfunction_desc' => $this->input->post('desc_malfunction'),
            'total_time_hours' => $this->input->post('total_time'),
            'total_time_cycles' => $this->input->post('total_cycles'),
            'time_since' => $this->input->post('time_since_inspected'),
            'aircraft_damage' => $this->input->post('aircraft_damage'),
            'aircraft_fire' => $this->input->post('aircraft_fire'),
            'aircraft_explosion' => $this->input->post('aircraft_explosion'),
            'damage_property_desc' => $this->input->post('aircraft_damage_desc')
        );	
		$this->map_serious_accident->UpdateAccidentAircraft($id_acc_aircraft, $param_aircraft);
    }
	
    function form3($id_acc_aircraft){
        $data['id_aircraft'] = $id_acc_aircraft;
		$id_accident = $this->map_serious_accident->getIdAccident($id_acc_aircraft);
		$data['airports'] = $this->map_serious_accident->getMasterData('ap_airport', 'nama', 'asc');
		$data['acc_airport'] = $this->map_serious_accident->getMasterData('ap_t_acc_airport_detail', 'id_airport_detail', 'asc', 'id_accident',$id_accident,'*');
		$data['acc_flight_itinerary'] = $this->map_serious_accident->getMasterData('ap_t_acc_flight_itinerary', 'id_flight_itinerary', 'asc', 'id_acc_aircraft',$id_aircraft,'*');
        $data['country'] = $this->map_serious_accident->getMasterData("ap_m_negara", "nama_negara", "asc");
        $data['province'] =$this->map_serious_accident->getMasterData("ap_m_provinsi", "nama_provinsi", "asc");
		$data['canSave'] = $this->canSave($id_accident);
		$this->load->view('ap_serious_accident/form_detail_3', $data);
    }
	
	
    function submit3($id_acc_aircraft){
		$id_accident = $this->map_serious_accident->getIdAccident($id_acc_aircraft); 
		if(!$this->canSave($id_accident)) return;
		$id_airport_detail =0;
		$param_airport = array(
			//'id_airport_detail'=>$this->input->post('id_airport_detail'),
			'id_accident'=>$id_accident,
			'id_airport'=>$this->input->post('id_airport'),
			//'id_airport_detail'=>$this->input->post('id_airport_detail'),
			'airport_elevation'=>$this->input->post('airport_elevation'),
			'airport_identifier'=>$this->input->post('airport_identifier'),
			'approach_segement'=>$this->input->post('approach_segement'),
			'cond_run'=>$this->array2csv('run_land'),
			'cond_run_dry'=>$this->input->post('cond_run_dry'),
			'cond_run_holes'=>$this->input->post('cond_run_holes'),
			'cond_run_ice'=>$this->input->post('cond_run_ice'),
			'cond_run_rough'=>$this->input->post('cond_run_rough'),
			'cond_run_rubber'=>$this->input->post('cond_run_rubber'),
			'cond_run_slush'=>$this->input->post('cond_run_slush'),
			'cond_run_sn_comp'=>$this->input->post('cond_run_sn_comp'),
			'cond_run_sn_crusted'=>$this->input->post('cond_run_sn_crusted'),
			'cond_run_sn_dry'=>$this->input->post('cond_run_sn_dry'),
			'cond_run_sn_wet'=>$this->input->post('cond_run_sn_wet'),
			'cond_run_soft'=>$this->input->post('cond_run_soft'),
			'cond_run_unknown'=>$this->input->post('cond_run_unknown'),
			'cond_run_vegetation'=>$this->input->post('cond_run_vegetation'),
			'cond_run_wet'=>$this->input->post('cond_run_wet'),
			'cond_run_wt_caim'=>$this->input->post('cond_run_wt_caim'),
			'cond_run_wt_choppy'=>$this->input->post('cond_run_wt_choppy'),
			'cond_run_wt_glassy'=>$this->input->post('cond_run_wt_glassy'),
			'distance_fr_airport'=>$this->input->post('distance_fr_airport'),
			'distance_fr_center'=>$this->input->post('distance_fr_center'),
			//'ifr'=>$this->array2csv('ifr'),
			'ifr_adf_ndb'=>$this->input->post('ifr_adf_ndb'),
			'ifr_asr'=>$this->input->post('ifr_asr'),
			'ifr_circling'=>$this->input->post('ifr_circling'),
			'ifr_contact'=>$this->input->post('ifr_contact'),
			'ifr_gps'=>$this->input->post('ifr_gps'),
			'ifr_ils'=>$this->input->post('ifr_ils'),
			'ifr_lda'=>$this->input->post('ifr_lda'),
			'ifr_loc'=>$this->input->post('ifr_loc'),
			'ifr_localizer'=>$this->input->post('ifr_localizer'),
			'ifr_loran'=>$this->input->post('ifr_loran'),
			'ifr_mls'=>$this->input->post('ifr_mls'),
			'ifr_none'=>$this->input->post('ifr_none'),
			'ifr_par'=>$this->input->post('ifr_par'),
			'ifr_practice'=>$this->input->post('ifr_practice'),
			'ifr_rnav'=>$this->input->post('ifr_rnav'),
			'ifr_sdf'=>$this->input->post('ifr_sdf'),
			'ifr_sidestep'=>$this->input->post('ifr_sidestep'),
			'ifr_tacan'=>$this->input->post('ifr_tacan'),
			'ifr_unknown'=>$this->input->post('ifr_unknown'),
			'ifr_visual'=>$this->input->post('ifr_visual'),
			'ifr_vor_dme'=>$this->input->post('ifr_vor_dme'),
			'ifr_vor_tvor'=>$this->input->post('ifr_vor_tvor'),
			'proximity_to_airport'=>$this->input->post('proximity_to_airport'),
			'run_land'=>$this->input->post('run_land'),
			'run_land_asphalt'=>$this->input->post('run_land_asphalt'),
			'run_land_concrete'=>$this->input->post('run_land_concrete'),
			'run_land_dirt'=>$this->input->post('run_land_dirt'),
			'run_land_grass'=>$this->input->post('run_land_grass'),
			'run_land_gravel'=>$this->input->post('run_land_gravel'),
			'run_land_ice'=>$this->input->post('run_land_ice'),
			'run_land_macadam'=>$this->input->post('run_land_macadam'),
			'run_land_metal'=>$this->input->post('run_land_metal'),
			'run_land_snow'=>$this->input->post('run_land_snow'),
			'run_land_unkown'=>$this->input->post('run_land_unkown'),
			'run_land_water'=>$this->input->post('run_land_water'),
			'runway_id'=>$this->input->post('runway_id'),
			'runway_length'=>$this->input->post('runway_length'),
			'runway_widht'=>$this->input->post('runway_widht'),
			'vfr'=>$this->array2csv('vfr'),
			'vfr_forced_landing'=>$this->input->post('vfr_forced_landing'),
			'vfr_full_stop'=>$this->input->post('vfr_full_stop'),
			'vfr_go_around'=>$this->input->post('vfr_go_around'),
			'vfr_none'=>$this->input->post('vfr_none'),
			'vfr_precautionary'=>$this->input->post('vfr_precautionary'),
			'vfr_simulated'=>$this->input->post('vfr_simulated'),
			'vfr_stop_and_go'=>$this->input->post('vfr_stop_and_go'),
			'vfr_straight_in'=>$this->input->post('vfr_straight_in'),
			'vfr_touch_and_go'=>$this->input->post('vfr_touch_and_go'),
			'vfr_traffic_patern'=>$this->input->post('vfr_traffic_patern'),
			'vfr_unknown'=>$this->input->post('vfr_unknown'),
			'vfr_valley'=>$this->input->post('vfr_valley'));
			
		$id_airport_detail = $this->map_serious_accident->getKey('ap_t_acc_airport_detail','id_accident',
									$id_accident,'id_airport_detail');
		
		if($id_airport_detail>0)  $this->map_serious_accident->UpdateAirportDetail($id_airport_detail, $param_airport);
		else $this->map_serious_accident->InsertAirportDetail($param_airport);
		//if($id_airport_detail>0) $this->db->where("id_airport_detail",$id_airport_detail)->update('ap_t_acc_airport_detail', $param_airport);
		//else $this->db->insert('ap_t_acc_airport_detail', $param_airport);
		
		$param_itinerary = array(
			//'id_flight_itinerary'=>$this->input->post('id_flight_itinerary'),
			'id_acc_aircraft'=>$this->input->post('id_acc_aircraft'),
			'id_airport_departure'=>$this->input->post('id_airport_departure'),
			'airport_departure_name'=>$this->input->post('airport_departure_name'),
			'id_provinsi'=>$this->input->post('id_provinsi'),
			'state_itinerary'=>$this->input->post('state_itinerary'),
			'id_kabupaten'=>$this->input->post('id_kabupaten'),
			'city_itinerary'=>$this->input->post('city_itinerary'),
			'id_country'=>$this->input->post('id_country'),
			'country_name'=>$this->input->post('country_name'),
			'time_departure'=>$this->input->post('time_departure'),
			'time_zone_departure'=>$this->input->post('time_zone_departure'),
			'id_airport_destination'=>$this->input->post('id_airport_destination'),
			'airport_name_destination'=>$this->input->post('airport_name_destination'),
			'id_provinsi_destination'=>$this->input->post('id_provinsi_destination'),
			'state_destination'=>$this->input->post('state_destination'),
			'id_kabupaten_destination'=>$this->input->post('id_kabupaten_destination'),
			'city_destination'=>$this->input->post('city_destination'),
			'id_country_destination'=>$this->input->post('id_country_destination'),
			'country_destination'=>$this->input->post('country_destination'),
			'type_flight_plan'=>$this->input->post('type_flight_plan'),
			'type_flight_plan_activated'=>$this->input->post('type_flight_plan_activated'),
			'type_atc_service'=>$this->input->post('type_atc_service'),
			'type_atc_service_none'=>$this->input->post('type_atc_service_none'),
			'type_atc_service_vfr'=>$this->input->post('type_atc_service_vfr'),
			'type_atc_service_spec_vfr'=>$this->input->post('type_atc_service_spec_vfr'),
			'type_atc_service_ifr'=>$this->input->post('type_atc_service_ifr'),
			'type_atc_service_spec_irf'=>$this->input->post('type_atc_service_spec_irf'),
			'type_atc_service_vfr_top'=>$this->input->post('type_atc_service_vfr_top'),
			'type_atc_service_vfr_flight'=>$this->input->post('type_atc_service_vfr_flight'),
			'type_atc_service_trafic'=>$this->input->post('type_atc_service_trafic'),
			'type_atc_service_cruse'=>$this->input->post('type_atc_service_cruse'),
			'type_atc_service_unknown'=>$this->input->post('type_atc_service_unknown'),
			'airspace_acc'=>$this->input->post('airspace_acc'),
			'airspace_acc_class_a'=>$this->input->post('airspace_acc_class_a'),
			'airspace_acc_class_b'=>$this->input->post('airspace_acc_class_b'),
			'airspace_acc_class_c'=>$this->input->post('airspace_acc_class_c'),
			'airspace_acc_class_d'=>$this->input->post('airspace_acc_class_d'),
			'airspace_acc_class_e'=>$this->input->post('airspace_acc_class_e'),
			'airspace_acc_class_g'=>$this->input->post('airspace_acc_class_g'),
			'airspace_acc_class_demo'=>$this->input->post('airspace_acc_class_demo'),
			'airspace_acc_class_warning'=>$this->input->post('airspace_acc_class_warning'),
			'airspace_acc_class_prohibited'=>$this->input->post('airspace_acc_class_prohibited'),
			'airspace_acc_class_restricted'=>$this->input->post('airspace_acc_class_restricted'),
			'airspace_acc_class_military'=>$this->input->post('airspace_acc_class_military'),
			'airspace_acc_class_airport'=>$this->input->post('airspace_acc_class_airport'),
			'airspace_acc_class_jettraining'=>$this->input->post('airspace_acc_class_jettraining'),
			'airspace_acc_class_trsa'=>$this->input->post('airspace_acc_class_trsa'),
			'airspace_acc_class_casr_93'=>$this->input->post('airspace_acc_class_casr_93'),
			'airspace_acc_class_special'=>$this->input->post('airspace_acc_class_special'),
			'airspace_acc_class_atc_area'=>$this->input->post('airspace_acc_class_atc_area'),
			'airspace_acc_class_unknown'=>$this->input->post('airspace_acc_class_unknown'),
			'aircraft_load_desc'=>$this->input->post('aircraft_load_desc'),
			'aircraft_load_desc_none'=>$this->input->post('aircraft_load_desc_none'),
			'aircraft_load_desc_passanger'=>$this->input->post('aircraft_load_desc_passanger'),
			'aircraft_load_desc_cargo'=>$this->input->post('aircraft_load_desc_cargo'),
			'aircraft_load_desc_towglider'=>$this->input->post('aircraft_load_desc_towglider'),
			'aircraft_load_desc_towbanner'=>$this->input->post('aircraft_load_desc_towbanner'),
			'aircraft_load_desc_other'=>$this->input->post('aircraft_load_desc_other'),
			'aircraft_load_desc_parachutists'=>$this->input->post('aircraft_load_desc_parachutists'),
			'aircraft_load_desc_water'=>$this->input->post('aircraft_load_desc_water'),
			'aircraft_load_desc_chemical'=>$this->input->post('aircraft_load_desc_chemical'),
			'aircraft_load_desc_livestock'=>$this->input->post('aircraft_load_desc_livestock'),
			'aircraft_load_desc_unkonwn'=>$this->input->post('aircraft_load_desc_unkonwn'),
			'fuel_onboar_takeof'=>$this->input->post('fuel_onboar_takeof'),
			'fuel_type'=>$this->input->post('fuel_type'),
			'fuel_type_other'=>$this->input->post('fuel_type_other'),
			'evacuation_emergency'=>$this->input->post('evacuation_emergency'),
			'evacuation_method_exit_desc'=>$this->input->post('evacuation_method_exit_desc'),
			'evacuation_aircraft'=>$this->input->post('evacuation_aircraft'));
			
		$id_flight_itinerary = $this->map_serious_accident->getKey('ap_t_acc_flight_itinerary','id_acc_aircraft',
									$id_acc_aircraft,'id_flight_itinerary');
		if($id_flight_itinerary>0) $this->map_serious_accident->UpdateFlightItinerary($id_flight_itinerary,$param_itinerary);
		else $this->map_serious_accident->InsertFlightItinerary($param_itinerary);
    }
	
	
    function form4($id_acc_aircraft){
        $data['id_aircraft'] = $id_acc_aircraft;
		$id_accident = $this->map_serious_accident->getIdAccident($id_acc_aircraft); 
		$data['weather_observation'] = $this->map_serious_accident->getMasterData('ap_t_acc_weather_observation', 'id_weather_observation', 'asc', 'id_accident', $id_accident, '*');	
        $data['canSave'] = $this->canSave($id_accident);
		$this->load->view('ap_serious_accident/form_detail_4', $data);		
    }
    function submit4($id_acc_aircraft){
        $id_accident = $this->map_serious_accident->getIdAccident($id_acc_aircraft); 
		if(!$this->canSave($id_accident)) return;
		$param_weather = array(
		//'id_weather_observation'=>$this->input->post('id_weather_observation'),
		'id_accident'=>$id_accident,
		'facility_id'=>$this->input->post('facility_id'),
		'observation_time'=>$this->input->post('observation_time'),
		'time_zone'=>$this->input->post('time_zone'),
		'distance_acc'=>$this->input->post('distance_acc'),
		'direction_acc'=>$this->input->post('direction_acc'),
		'source'=>$this->input->post('source'),
		'source_national'=>$this->input->post('source_national'),
		'source_flight'=>$this->input->post('source_flight'),
		'source_tv'=>$this->input->post('source_tv'),
		'source_automated'=>$this->input->post('source_automated'),
		'source_commercial'=>$this->input->post('source_commercial'),
		'source_company'=>$this->input->post('source_company'),
		'source_military'=>$this->input->post('source_military'),
		'source_internet'=>$this->input->post('source_internet'),
		'source_unknown'=>$this->input->post('source_unknown'),
		'source_minor'=>$this->input->post('source_minor'),		
		'method'=>$this->input->post('method'),
		'method_inperson'=>$this->input->post('method_inperson'),
		'method_teletype'=>$this->input->post('method_teletype'),
		'method_telephone'=>$this->input->post('method_telephone'),
		'method_aircraft'=>$this->input->post('method_aircraft'),
		'method_tv_radio'=>$this->input->post('method_tv_radio'),
		'method_unknown'=>$this->input->post('method_unknown'),
		'briefing_type_complet'=>$this->input->post('briefing_type_complet'),
		'light_condition'=>$this->input->post('light_condition'),
		'visibility'=>$this->input->post('visibility'),
		'sky_lowest_cloud'=>$this->input->post('sky_lowest_cloud'),
		'ceiling'=>$this->input->post('ceiling'),
		'lowest_cloud'=>$this->input->post('lowest_cloud'),
		'ceiling_height'=>$this->input->post('ceiling_height'),
		'restriction_none'=>$this->input->post('restriction_none'),
		'restriction'=>$this->input->post('restriction'),
		'restriction_blowdust'=>$this->input->post('restriction_blowdust'),
		'restriction_blowsand'=>$this->input->post('restriction_blowsand'),
		'restriction_blowsnow'=>$this->input->post('restriction_blowsnow'),
		'restriction_blowspray'=>$this->input->post('restriction_blowspray'),
		'restriction_dust'=>$this->input->post('restriction_dust'),
		'restriction_fog'=>$this->input->post('restriction_fog'),
		'restriction_ground_fog'=>$this->input->post('restriction_ground_fog'),
		'restriction_haze'=>$this->input->post('restriction_haze'),
		'restriction_icefog'=>$this->input->post('restriction_icefog'),
		'restriction_smoke'=>$this->input->post('restriction_smoke'),
		'restriction_unknown'=>$this->input->post('restriction_unknown'),
		'wind_direction'=>$this->input->post('wind_direction'),
		'wind_direction_if_indicated'=>$this->input->post('wind_direction_if_indicated'),
		'wind_speed'=>$this->input->post('wind_speed'),
		'wind_speed_if_velocity'=>$this->input->post('wind_speed_if_velocity'),
		'wind_gusts'=>$this->input->post('wind_gusts'),
		'wind_gusts_if_velocity'=>$this->input->post('wind_gusts_if_velocity'),
		'type_turbulence'=>$this->input->post('type_turbulence'),
		'type_turbulence_none'=>$this->input->post('type_turbulence_none'),
		'type_turbulence_clear'=>$this->input->post('type_turbulence_clear'),
		'type_turbulence_clouds'=>$this->input->post('type_turbulence_clouds'),
		'type_turbulence_vicinity'=>$this->input->post('type_turbulence_vicinity'),
		'severity_turbulence'=>$this->input->post('severity_turbulence'),
		'notams'=>$this->input->post('notams'),
		'temperature_C'=>$this->input->post('temperature_C'),
		'temperature_F'=>$this->input->post('temperature_F'),
		'altimeter_hg'=>$this->input->post('altimeter_hg'),
		'altimeter_mb'=>$this->input->post('altimeter_mb'),
		'density'=>$this->input->post('density'),
		'dew_point_c'=>$this->input->post('dew_point_c'),
		'dew_point_f'=>$this->input->post('dew_point_f'),
		'icing_forest_amount'=>$this->input->post('icing_forest_amount'),
		'icing_forest_type'=>$this->input->post('icing_forest_type'),
		'icing_actual_amount'=>$this->input->post('icing_actual_amount'),
		'type_precipitation'=>$this->input->post('type_precipitation'),
		'type_precipitation_none'=>$this->input->post('type_precipitation_none'),
		'type_precipitation_rain'=>$this->input->post('type_precipitation_rain'),
		'type_precipitation_snow'=>$this->input->post('type_precipitation_snow'),
		'type_precipitation_hail'=>$this->input->post('type_precipitation_hail'),
		'type_precipitation_rain_shower'=>$this->input->post('type_precipitation_rain_shower'),
		'type_precipitation_freezing'=>$this->input->post('type_precipitation_freezing'),
		'type_precipitation_snow_shower'=>$this->input->post('type_precipitation_snow_shower'),
		'type_precipitation_drizzle'=>$this->input->post('type_precipitation_drizzle'),
		'type_precipitation_ice_pellets'=>$this->input->post('type_precipitation_ice_pellets'),
		'type_precipitation_snow_pellets'=>$this->input->post('type_precipitation_snow_pellets'),
		'type_precipitation_snow_grains'=>$this->input->post('type_precipitation_snow_grains'),
		'type_precipitation_ice_crystal'=>$this->input->post('type_precipitation_ice_crystal'),
		'type_precipitation_ice_pellets_shower'=>$this->input->post('type_precipitation_ice_pellets_shower'),
		'type_precipitation_freezing_drizzle'=>$this->input->post('type_precipitation_freezing_drizzle'),
		'intensity_of_precipitation'=>$this->input->post('intensity_of_precipitation'));
		
		$id_weather_observation = $this->map_serious_accident->getKey('ap_t_acc_weather_observation','id_accident',
									$id_accident,'id_weather_observation');
		
		if($id_weather_observation>0) $this->map_serious_accident->UpdateWeatherObservation($id_weather_observation,$param_weather);
		else $this->map_serious_accident->InsertWeatherObservation($param_weather);
		echo $this->db->last_query();
    }
	
    function form5($id_acc_aircraft){
        $data['id_aircraft'] = $id_acc_aircraft;
		$id_accident = $this->map_serious_accident->getIdAccident($id_acc_aircraft); 
		$data['personnels'] = $this->map_serious_accident->getMasterData('`ap_t_acc_aircraft_personnel', 'id_acc_aircraft_personnel', 'asc', 'identity IN (\'pilot\', \'copilot\' ) and id_acc_aircraft =', $id_acc_aircraft, '*');	
		//echo $this->db->last_query();
		$data['Flight_time'] = array();		
		foreach($data['personnels'] as $Personal){
			$temp = $this->map_serious_accident->getMasterData('ap_t_acc_flight_time', 'id_acc_aircraft_personnel', 
				'asc', 'id_acc_aircraft_personnel', $Personal['id_acc_aircraft_personnel'], 
				'id_acc_flight_time,id_acc_aircraft_personnel,total_time_all_aircraft,total_time_make_model,total_time_airplane_single_engine,total_time_airplane_multi_engine,total_time_night,total_time_all_aircraft_2,total_time_instrument_simulated,total_time_rotorcraft,total_time_glider,total_time_lighter_than_air,pic_all_aircraft,pic_make_model,pic_airplane_single_engine,pic_airplane_multiengine,pic_ninght,pic_instrument_actual,pic_instrument_simulated,pic_rotorcraft,pic_glider,pic_lighter_than_air,time_instructor_all_aircraft,time_instructor_make_model,time_insructor_airplane_single_engine,time_insructor_airplane_multiengine,time_insructor_night,time_insructor_instrument_actual,time_insructor_istrument_simulated,time_insructor_rotorcraft,time_insructor_glider,time_insructor_lighter_thanair,make_model_night,make_model_instrument_actual,make_model_instrument_simulated,last_90_days_all_aircraft,last_90_days_make_model,last_90_days_all_aircraft_2,last_90_days_airplane_single_engine,last_90_days_airplane_multiengine,last_90_days_instrument_actual,last_90_days_instrument_simulated,last_90_days_rotorcraft,last_90_days_glider,last_90_days_lighter_thanair,last_30_days_all_aircraft,last_30_days_make_model,last_30_days_airplane_single_engine,last_30_days_airplane_multiengine,last_30_days_night,last_30_days_instrument_actual,last_30_days_instrument_simulated,last_30_days_rotorcraft,last_30_hours_glider,last_30_days_lighter_thanair,last_24_hours_all_aircraft,last_24_hours_make_model,last_24_hours_airplane_single_engine,last_24_hours_airplane_multiengine,last_24_hours_night,last_24_hours_instrument_actual,last_24_hours_instrument_simulated,last_24_hours_rotorcraft,last_24_hours_glider,last_24_hours_lighter_thanair');
			//echo $this->db->last_query();
			if(!empty($temp)) $data['Flight_time'][$Personal['id_acc_aircraft_personnel']] = $temp[0]; 
		}
		//,id_acc_flight_time,id_acc_aircraft_personnel,total_time_all_aircraft,total_time_make_model,total_time_airplane_single_engine,total_time_airplane_multi_engine,total_time_night,total_time_all_aircraft_2,total_time_instrument_simulated,total_time_rotorcraft,total_time_glider,total_time_lighter_than_air,pic_all_aircraft,pic_make_model,pic_airplane_single_engine,pic_airplane_multiengine,pic_ninght,pic_instrument_actual,pic_instrument_simulated,pic_rotorcraft,pic_glider,pic_lighter_than_air,time_instructor_all_aircraft,time_instructor_make_model,time_insructor_airplane_single_engine,time_insructor_airplane_multiengine,time_insructor_night,time_insructor_instrument_actual,time_insructor_istrument_simulated,time_insructor_rotorcraft,time_insructor_glider,time_insructor_lighter_thanair,make_model_night,make_model_instrument_actual,make_model_instrument_simulated,last_90_days_all_aircraft,last_90_days_make_model,last_90_days_all_aircraft_2,last_90_days_airplane_single_engine,last_90_days_airplane_multiengine,last_90_days_instrument_actual,last_90_days_instrument_simulated,last_90_days_rotorcraft,last_90_days_glider,last_90_days_lighter_thanair,last_30_days_all_aircraft,last_30_days_make_model,last_30_days_airplane_single_engine,last_30_days_airplane_multiengine,last_30_days_night,last_30_days_instrument_actual,last_30_days_instrument_simulated,last_30_days_rotorcraft,last_30_hours_glider,last_30_days_lighter_thanair,last_24_hours_all_aircraft,last_24_hours_make_model,last_24_hours_airplane_single_engine,last_24_hours_airplane_multiengine,last_24_hours_night,last_24_hours_instrument_actual,last_24_hours_instrument_simulated,last_24_hours_rotorcraft,last_24_hours_glider,last_24_hours_lighter_thanair
		$data['person_count'] =count($data['personnels']);
		$data['canSave'] = $this->canSave($id_accident);
        //print_r($data);
		$this->load->view('ap_serious_accident/form_detail_5', $data);
    }
    function submit5($id_acc_aircraft){
        $data['id_aircraft'] = $id_acc_aircraft;
		$id_accident = $this->map_serious_accident->getIdAccident($id_acc_aircraft); 	
		if(!$this->canSave($id_accident)) return;
        $total_record = $this->input->post('total_record');
		$person_num ='';
		for($i = 1; $i<=$total_record; $i++){
			$person_num = $i>1 ? '_'.$i:'';
			$id_acc_aircraft_personnel = $this->input->post('id_acc_aircraft_personnel'.$person_num);
			$param_personnel = array(
				'id_acc_aircraft'=>$aircraft[0]['id_acc_aircraft'],
				'first_name'=>$this->input->post('first_name'.$person_num),
				'middle_name'=>$this->input->post('middle_name'.$person_num),
				'last_name'=>$this->input->post('last_name'.$person_num),
				'aviation_registration'=>$this->input->post('aviation_registration'.$person_num),
				'identity'=>$this->input->post('identity'.$person_num),
				'id_provinci'=>$this->input->post('id_provinci'.$person_num),
				'provinci_name'=>$this->input->post('provinci_name'.$person_num),
				'id_kabupaten'=>$this->input->post('id_kabupaten'.$person_num),
				'kabupaten_name'=>$this->input->post('kabupaten_name'.$person_num),
				'id_country'=>$this->input->post('id_country'.$person_num),
				'country_name'=>$this->input->post('country_name'.$person_num),
				'zip'=>$this->input->post('zip'.$person_num),
				'age_at_time'=>$this->input->post('age_at_time'.$person_num),
				'date_of_birth'=>$this->input->post('date_of_birth'.$person_num),
				'certificate_num'=>$this->input->post('certificate_num'.$person_num),
				'degree_of_injury'=>$this->input->post('degree_of_injury'.$person_num),
				'seat_occupied'=>$this->input->post('seat_occupied'.$person_num),
				'seat_belt_used'=>$this->input->post('seat_belt_used'.$person_num),
				'seat_belt_available'=>$this->input->post('seat_belt_available'.$person_num),
				'shoulder_harness_used'=>$this->input->post('shoulder_harness_used'.$person_num),
				'shoulder_harness_available'=>$this->input->post('shoulder_harness_available'.$person_num),
				'pilot_certificate_none'=>$this->input->post('pilot_certificate_none'.$person_num),
				'pilot_certificate_private'=>$this->input->post('pilot_certificate_private'.$person_num),
				'pilot_certificate_student'=>$this->input->post('pilot_certificate_student'.$person_num),
				'pilot_certificate_flight_instructur'=>$this->input->post('pilot_certificate_flight_instructur'.$person_num),
				'pilot_certificate_recreational'=>$this->input->post('pilot_certificate_recreational'.$person_num),
				'pilot_certificate_sport'=>$this->input->post('pilot_certificate_sport'.$person_num),
				'pilot_certificate_commercial'=>$this->input->post('pilot_certificate_commercial'.$person_num),
				'pilot_certificate_airline_transport'=>$this->input->post('pilot_certificate_airline_transport'),
				'pilot_certificate_us_military'=>$this->input->post('pilot_certificate_us_military'.$person_num),
				'pilot_certificate_foreign'=>$this->input->post('pilot_certificate_foreign'.$person_num),
				'principal_occupation'=>$this->input->post('principal_occupation'.$person_num),
				'medical_certificate'=>$this->input->post('medical_certificate'),
				'medical_certificate_validity'=>$this->input->post('medical_certificate_validity'.$person_num),
				'date_of_last_medical'=>$this->input->post('date_of_last_medical'.$person_num),
				'medic_cert_limitations'=>$this->input->post('medic_cert_limitations'.$person_num),
				'medic_cert_waivers'=>$this->input->post('medic_cert_waivers'.$person_num),
				'date_last_flight_checks'=>$this->input->post('date_last_flight_checks'.$person_num),
				'id_aircraft_make'=>$this->input->post('id_aircraft_make'.$person_num),
				'flight_aircraft_make_name'=>$this->input->post('flight_aircraft_make_name'.$person_num),
				'id_aircraft_model'=>$this->input->post('id_aircraft_model'.$person_num),
				'flight_aircraft_model_name'=>$this->input->post('flight_aircraft_model_name'.$person_num),
				'airplane_rating_none'=>$this->input->post('airplane_rating_none'.$person_num),
				'airplane_rating_single_engine_land'=>$this->input->post('airplane_rating_single_engine_land'.$person_num),
				'airplane_rating_single_engine_sea'=>$this->input->post('airplane_rating_single_engine_sea'.$person_num),
				'airplane_rating_multiengine_land'=>$this->input->post('airplane_rating_multiengine_land'.$person_num),
				'airplane_rating_multiengine_sea'=>$this->input->post('airplane_rating_multiengine_sea'.$person_num),
				'other_rating_none'=>$this->input->post('other_rating_none'.$person_num),
				'other_rating_airship'=>$this->input->post('other_rating_airship'.$person_num),
				'other_rating_free_balloon'=>$this->input->post('other_rating_free_balloon'.$person_num),
				'other_rating_glider'=>$this->input->post('other_rating_glider'.$person_num),
				'other_rating_gyroplane'=>$this->input->post('other_rating_gyroplane'.$person_num),
				'other_rating_helicopter'=>$this->input->post('other_rating_helicopter'.$person_num),
				'instrument_rating_none'=>$this->input->post('instrument_rating_none'.$person_num),
				'instrument_rating_airplane'=>$this->input->post('instrument_rating_airplane'.$person_num),
				'instrument_rating_helicopter'=>$this->input->post('instrument_rating_helicopter'.$person_num),
				'instrument_rating_powered_lift'=>$this->input->post('instrument_rating_powered_lift'.$person_num),
				'instructor_rating_none'=>$this->input->post('instructor_rating_none'.$person_num),
				'instructor_rating_single_engine'=>$this->input->post('instructor_rating_single_engine'.$person_num),
				'instructor_rating_multi_engine'=>$this->input->post('instructor_rating_multi_engine'.$person_num),
				'instructor_rating_gyroplane'=>$this->input->post('instructor_rating_gyroplane'.$person_num),
				'instructor_rating_powered_lift'=>$this->input->post('instructor_rating_powered_lift'.$person_num),
				'instructor_rating_instrument_airplane'=>$this->input->post('instructor_rating_instrument_airplane'),
				'instructor_rating_instrument_helicopter'=>$this->input->post('instructor_rating_instrument_helicopter'),
				'instructor_rating_helicopter'=>$this->input->post('instructor_rating_helicopter'.$person_num),
				'instructor_rating_glider'=>$this->input->post('instructor_rating_glider'.$person_num),
				'instructor_rating_sport'=>$this->input->post('instructor_rating_sport'.$person_num),
				'type_ratings'=>$this->input->post('type_ratings'.$person_num),
				'student_endorsements'=>$this->input->post('student_endorsements'.$person_num),
				'student_endorsements_date'=>$this->input->post('student_endorsements_date'.$person_num)
			);
			if(!empty($id_acc_aircraft_personnel)){
				$this->map_serious_accident->UpdateAircraftPersonnel($id_acc_aircraft_personnel,$param_personnel);
			}else{
				$id_acc_aircraft_personnel =$this->map_serious_accident->InsertAircraftPersonnel( $param_personnel);
			}		
			$Flight_time = array(
				'id_acc_aircraft_personnel'=>$id_acc_aircraft_personnel,
				'total_time_all_aircraft'=>$this->input->post('total_time_all_aircraft'.$person_num),
				'total_time_make_model'=>$this->input->post('total_time_make_model'.$person_num),
				'total_time_airplane_single_engine'=>$this->input->post('total_time_airplane_single_engine'.$person_num),
				'total_time_airplane_multi_engine'=>$this->input->post('total_time_airplane_multi_engine'.$person_num),
				'total_time_night'=>$this->input->post('total_time_night'.$person_num),
				'total_time_all_aircraft_2'=>$this->input->post('total_time_all_aircraft_2'.$person_num),
				'total_time_instrument_simulated'=>$this->input->post('total_time_instrument_simulated'.$person_num),
				'total_time_rotorcraft'=>$this->input->post('total_time_rotorcraft'.$person_num),
				'total_time_glider'=>$this->input->post('total_time_glider'.$person_num),
				'total_time_lighter_than_air'=>$this->input->post('total_time_lighter_than_air'.$person_num),
				'pic_all_aircraft'=>$this->input->post('pic_all_aircraft'.$person_num),
				'pic_make_model'=>$this->input->post('pic_make_model'.$person_num),
				'pic_airplane_single_engine'=>$this->input->post('pic_airplane_single_engine'.$person_num),
				'pic_airplane_multiengine'=>$this->input->post('pic_airplane_multiengine'.$person_num),
				'pic_ninght'=>$this->input->post('pic_ninght'.$person_num),
				'pic_instrument_actual'=>$this->input->post('pic_instrument_actual'.$person_num),
				'pic_instrument_simulated'=>$this->input->post('pic_instrument_simulated'.$person_num),
				'pic_rotorcraft'=>$this->input->post('pic_rotorcraft'.$person_num),
				'pic_glider'=>$this->input->post('pic_glider'.$person_num),
				'pic_lighter_than_air'=>$this->input->post('pic_lighter_than_air'.$person_num),
				'time_instructor_all_aircraft'=>$this->input->post('time_instructor_all_aircraft'.$person_num),
				'time_instructor_make_model'=>$this->input->post('time_instructor_make_model'.$person_num),
				'time_insructor_airplane_single_engine'=>$this->input->post('time_insructor_airplane_single_engine'.$person_num),
				'time_insructor_airplane_multiengine'=>$this->input->post('time_insructor_airplane_multiengine'.$person_num),
				'time_insructor_night'=>$this->input->post('time_insructor_night'.$person_num),
				'time_insructor_instrument_actual'=>$this->input->post('time_insructor_instrument_actual'.$person_num),
				'time_insructor_istrument_simulated'=>$this->input->post('time_insructor_istrument_simulated'.$person_num),
				'time_insructor_rotorcraft'=>$this->input->post('time_insructor_rotorcraft'.$person_num),
				'time_insructor_glider'=>$this->input->post('time_insructor_glider'.$person_num),
				'time_insructor_lighter_thanair'=>$this->input->post('time_insructor_lighter_thanair'.$person_num),
				'make_model_night'=>$this->input->post('make_model_night'.$person_num),
				'make_model_instrument_actual'=>$this->input->post('make_model_instrument_actual'.$person_num),
				'make_model_instrument_simulated'=>$this->input->post('make_model_instrument_simulated'.$person_num),
				'last_90_days_all_aircraft'=>$this->input->post('last_90_days_all_aircraft'.$person_num),
				'last_90_days_make_model'=>$this->input->post('last_90_days_make_model'.$person_num),
				'last_90_days_all_aircraft_2'=>$this->input->post('last_90_days_all_aircraft_2'.$person_num),
				'last_90_days_airplane_single_engine'=>$this->input->post('last_90_days_airplane_single_engine'.$person_num),
				'last_90_days_airplane_multiengine'=>$this->input->post('last_90_days_airplane_multiengine'.$person_num),
				'last_90_days_instrument_actual'=>$this->input->post('last_90_days_instrument_actual'.$person_num),
				'last_90_days_instrument_simulated'=>$this->input->post('last_90_days_instrument_simulated'.$person_num),
				'last_90_days_rotorcraft'=>$this->input->post('last_90_days_rotorcraft'.$person_num),
				'last_90_days_glider'=>$this->input->post('last_90_days_glider'.$person_num),
				'last_90_days_lighter_thanair'=>$this->input->post('last_90_days_lighter_thanair'.$person_num),
				'last_30_days_all_aircraft'=>$this->input->post('last_30_days_all_aircraft'.$person_num),
				'last_30_days_make_model'=>$this->input->post('last_30_days_make_model'.$person_num),
				'last_30_days_airplane_single_engine'=>$this->input->post('last_30_days_airplane_single_engine'.$person_num),
				'last_30_days_airplane_multiengine'=>$this->input->post('last_30_days_airplane_multiengine'.$person_num),
				'last_30_days_night'=>$this->input->post('last_30_days_night'.$person_num),
				'last_30_days_instrument_actual'=>$this->input->post('last_30_days_instrument_actual'.$person_num),
				'last_30_days_instrument_simulated'=>$this->input->post('last_30_days_instrument_simulated'.$person_num),
				'last_30_days_rotorcraft'=>$this->input->post('last_30_days_rotorcraft'.$person_num),
				'last_30_hours_glider'=>$this->input->post('last_30_hours_glider'.$person_num),
				'last_30_days_lighter_thanair'=>$this->input->post('last_30_days_lighter_thanair'.$person_num),
				'last_24_hours_all_aircraft'=>$this->input->post('last_24_hours_all_aircraft'.$person_num),
				'last_24_hours_make_model'=>$this->input->post('last_24_hours_make_model'.$person_num),
				'last_24_hours_airplane_single_engine'=>$this->input->post('last_24_hours_airplane_single_engine'.$person_num),
				'last_24_hours_airplane_multiengine'=>$this->input->post('last_24_hours_airplane_multiengine'.$person_num),
				'last_24_hours_night'=>$this->input->post('last_24_hours_night'.$person_num),
				'last_24_hours_instrument_actual'=>$this->input->post('last_24_hours_instrument_actual'.$person_num),
				'last_24_hours_instrument_simulated'=>$this->input->post('last_24_hours_instrument_simulated'.$person_num),
				'last_24_hours_rotorcraft'=>$this->input->post('last_24_hours_rotorcraft'.$person_num),
				'last_24_hours_glider'=>$this->input->post('last_24_hours_glider'.$person_num),
				'last_24_hours_lighter_thanair'=>$this->input->post('last_24_hours_lighter_thanair'.$person_num)
			);
			$id_acc_flight_time =  $this->map_serious_accident->getKey('ap_t_acc_flight_time','id_acc_aircraft_personnel',
									$id_acc_aircraft_personnel,'id_acc_flight_time');
			if($id_acc_flight_time>0) $this->map_serious_accident->UpdateFlightTime($id_acc_flight_time,$Flight_time);//$this->map_serious_accident->UpdateFlightTime($id_acc_flight_time,$Flight_time);
			else $this->map_serious_accident->InsertFlightTime($Flight_time);//$this->map_serious_accident->InsertFlightTime( $Flight_time);
		}
		//print_r($_POST);        
    }
    function form6($id_acc_aircraft){
		$id_accident = $this->map_serious_accident->getIdAccident($id_acc_aircraft);  
        $data['id_aircraft'] = $id_acc_aircraft;
		$crew = $this->map_serious_accident->getMasterData('ap_t_acc_aircraft_personnel', 'id_acc_aircraft_personnel', 'asc', 'id_acc_aircraft', $id_aircraft, '*');
        //$data['crews'] = $crew;
		$Q = $this->db->query("SELECT * FROM `ap_t_acc_aircraft_personnel` WHERE `id_acc_aircraft` = $id_acc_aircraft AND `identity` NOT IN  ('pilot','copilot')");
		$data['crews'] =$Q->result_array();
		$data['passengers'] = $this->map_serious_accident->getMasterData('ap_t_acc_aircraft_passengers', 'id_passenger', 'asc', 'id_acc_aircraft', $id_aircraft, '*');
        $data['canSave'] = $this->canSave($id_accident);
		$this->load->view('ap_serious_accident/form_detail_6', $data);
    }
    function submit6($id_acc_aircraft){
		$id_accident = $this->map_serious_accident->getIdAccident($id_acc_aircraft); 
		if(!$this->canSave($id_accident)) return;
        $count_personnel = $this->input->post('count_crew');
        for($i=1;$i<=$count_personnel;$i++){
            $i == 1 ? $person_num = "" : $person_num ="_".$i;
            $param_aircraft_personnel = array(
				'id_acc_aircraft'=>$id_acc_aircraft,
				'first_name'=>$this->input->post('first_name'.$person_num),
				'middle_name'=>$this->input->post('middle_name'.$person_num),
				'last_name'=>$this->input->post('last_name'.$person_num),
				'aviation_registration'=>$this->input->post('aviation_registration'.$person_num),
				'identity'=>$this->input->post('identity'.$person_num),
				'id_provinci'=>$this->input->post('id_provinci'.$person_num),
				'provinci_name'=>$this->input->post('provinci_name'.$person_num),
				'id_kabupaten'=>$this->input->post('id_kabupaten'.$person_num),
				'kabupaten_name'=>$this->input->post('kabupaten_name'.$person_num),
				'id_country'=>$this->input->post('id_country'.$person_num),
				'country_name'=>$this->input->post('country_name'.$person_num),
				'zip'=>$this->input->post('zip'.$person_num),
				'age_at_time'=>$this->input->post('age_at_time'.$person_num),
				'date_of_birth'=>$this->input->post('date_of_birth'.$person_num),
				'certificate_num'=>$this->input->post('certificate_num'.$person_num),
				'degree_of_injury'=>$this->input->post('degree_of_injury'.$person_num),
				'seat_occupied'=>$this->input->post('seat_occupied'.$person_num),
				'seat_belt_used'=>$this->input->post('seat_belt_used'.$person_num),
				'seat_belt_available'=>$this->input->post('seat_belt_available'.$person_num),
				'shoulder_harness_used'=>$this->input->post('shoulder_harness_used'.$person_num),
				'shoulder_harness_available'=>$this->input->post('shoulder_harness_available'.$person_num),
				'pilot_certificate_none'=>$this->input->post('pilot_certificate_none'.$person_num),
				'pilot_certificate_private'=>$this->input->post('pilot_certificate_private'.$person_num),
				'pilot_certificate_student'=>$this->input->post('pilot_certificate_student'.$person_num),
				'pilot_certificate_flight_instructur'=>$this->input->post('pilot_certificate_flight_instructur'.$person_num),
				'pilot_certificate_recreational'=>$this->input->post('pilot_certificate_recreational'.$person_num),
				'pilot_certificate_sport'=>$this->input->post('pilot_certificate_sport'.$person_num),
				'pilot_certificate_commercial'=>$this->input->post('pilot_certificate_commercial'.$person_num),
				'pilot_certificate_airline_transport'=>$this->input->post('pilot_certificate_airline_transport'),
				'pilot_certificate_us_military'=>$this->input->post('pilot_certificate_us_military'.$person_num),
				'pilot_certificate_foreign'=>$this->input->post('pilot_certificate_foreign'.$person_num),
				'principal_occupation'=>$this->input->post('principal_occupation'.$person_num)
			);
			if($this->input->post("id_acc_aircraft_personnel".$person_num)=="") $this->map_serious_accident->InsertAirCraftPersonnel($param_aircraft_personnel);// $this->db->insert('ap_t_acc_aircraft_personnel', $param_aircraft_personnel);
			else{
				$id_acc_aircraft_personnel =$this->input->post("id_acc_aircraft_personnel".$person_num);
				$this->map_serious_accident->UpdateAirCraftPersonnel($id_acc_aircraft_personnel,$param_aircraft_personnel);
			}
        }
		$del_person_id = $this->input->post('del_person_id');
		if(strlen ($del_person_id)>0) $this->map_serious_accident->DeleteAircraftPersonnel($del_person_id);
		$passenger_count = $this->input->post("passenger_count");
        for($i=0; $i<$passenger_count; $i++){
            $param_passengers = array(
                'id_acc_aircraft' => $id_acc_aircraft,
                'first_name' => $_POST['input_name1'][$i],
                'middle_name' => $_POST['input_name2'][$i],
                'last_name' => $_POST['input_name3'][$i],
                'id_provinsi' => $_POST[''][$i],
                'id_kabupaten' => $_POST[''][$i],
                'id_country' => $_POST[''][$i],
                'zip' => $_POST['input_zip'][$i],
                'seat' => $_POST['input_seat'][$i],
                'identity' => $_POST['input_id'][$i],
                'status' => $_POST['input_stat'][$i]
            );
			if($_POST['id_passenger'][$i]!=""){
				$this->map_serious_accident->UpdatePassenger($_POST['id_passenger'][$i],$param_passengers);
			}else{
				$this->map_serious_accident->InsertPassenger($param_passengers); 
			}
			//echo $this->db->last_query();
            //
        }
		$del_pessanger_id = $this->input->post('del_pessanger_id');
		if(strlen ($del_pessanger_id)>0) $this->map_serious_accident->DeletePassenger($del_pessanger_id); 
    }
    function form7($id_acc_aircraft){
        $id_accident = $this->map_serious_accident->getIdAccident($id_acc_aircraft);
		$data['id_aircraft'] = $id_acc_aircraft;
        $Q = $this->db->select('id_accident')->get_where('ap_t_acc_aircraft', array('id_acc_aircraft'=>$id_acc_aircraft))->row();
        $data['accident'] = $this->map_serious_accident->getMasterData('ap_t_acc_accident', 'id_accident', 'asc', 'id_accident', $Q->id_accident, 'id_accident,flight_history,recommendation');
        $data['canSave'] = $this->canSave($id_accident);
		$this->load->view('ap_serious_accident/form_detail_7', $data);
    }
    function submit7($id_acc_aircraft){
        //$id_aircraft = $this->input->post('id_acc_aircraft');
		$data['id_aircraft'] = $id_acc_aircraft;
        $id_accident = $this->map_serious_accident->getIdAccident($id_acc_aircraft);
		if(!$this->canSave($id_accident)) return;
        $param_accident = array(
            'flight_history' => $this->input->post('flight_history'),
            'recommendation' => $this->input->post('recommendation')
        );
		$this->map_serious_accident->UpdateAccident($id_accident, $param_accident);
		echo $this->db->last_query();
    }
    function form8($id_acc_aircraft){
        $id_accident = $this->map_serious_accident->getIdAccident($id_acc_aircraft); 
		$data['id_aircraft'] = $id_acc_aircraft;
        $Q = $this->db->select('id_accident')->get_where('ap_t_acc_aircraft', array('id_acc_aircraft'=>$id_acc_aircraft))->row();
        $data['accident'] = $this->map_serious_accident->getMasterData('ap_t_acc_accident', 'id_accident', 'asc', 'id_accident', $Q->id_accident, 'additional_information,date_of_this_report,name_of_pilot_or_operator,name_of_person_filling_report,title_of_person_filling_report,ntsb_no,reviewed_by_ntsb,name_of_investigator,date_report_received,signature_of_pilot_or_operator,signature2');
        $data['canSave'] = $this->canSave($id_accident);
		$this->load->view('ap_serious_accident/form_detail_8', $data);
    }
    function submit8($id_acc_aircraft){		
        $id_accident = $this->map_serious_accident->getIdAccident($id_acc_aircraft); 
		$data['id_aircraft'] = $id_acc_aircraft;
		if(!$this->canSave($id_accident)) return;
        $param_accident = array(
            'additional_information' => $this->input->post('add_info'),
            'date_of_this_report' => $this->input->post('date_report'),
			'signature_of_pilot_or_operator'=> $this->input->post('signature_of_pilot_or_operator'),
            'name_of_pilot_or_operator' => $this->input->post('print_name'),
            'name_of_person_filling_report' => $this->input->post('print_name2'),
            'title_of_person_filling_report' => $this->input->post('title'),
            'ntsb_no' => $this->input->post('ntsb_no'),
            'reviewed_by_ntsb' => $this->input->post('ntsb_office'),
            'name_of_investigator' => $this->input->post('ntsb_investigator'),
            'date_report_received' => $this->input->post('date_report2'),
			'signature2' => $this->input->post('signature2')
        );
		$this->map_serious_accident->UpdateAccident($id_accident, $param_accident);
		echo $this->db->last_query();
    }
	
	function ddAirCraftModel($manufacture_id){
		$result = $this->map_serious_accident->getMasterData("ms_aircraft_model","name_aircraft_model", "name_aircraft_model","id_aircraft_make",$manufacture_id,"name_aircraft_model,id_aircraft_model");		
		foreach($result as $item) echo "<option value=\"".$item['id_aircraft_make']."\">".$item['name_aircraft_model']."</option>";
    }
	
	function Report($year = 0, $strAirports='all', $airlines  ='all'){
		$queryCount ="";
		$queryInList ="";
		$num = 1;
		if( $strAirports!='all'){
			$airports = explode("_",$strAirports);//array(122,222,223,224);
			foreach($airports as $airport){
			$queryCount .=",SUM(IF(b.id_airport = $airport,1,0)) AS airport_$airport";
			$queryInList .=",$airport";
			$num++;
		}}
		$strFilter = "";
		$queryInList  = substr($queryInList ,1);
		if($year>0) $strFilter = " YEAR(b.acc_datetime_local) = $year ";
		if($queryInList!=""){
			if($strFilter!="") $strFilter .="  AND id_airport IN ($queryInList)";
			else $strFilter =" id_airport IN ($queryInList)";
		}
		if($airlines != 'all'){
			$airlines = str_replace("_",",",$airlines);
			if($strFilter!="") $strFilter .="  AND a.id_org IN ($airlines)";
			else $strFilter =" a.id_org IN ($airlines)";
		}
		$strQuery = "SELECT a.id_org,c.nama_airline, c.kd_IATA ";
		$strQuery .=$queryCount;
		$strQuery .= " FROM ap_t_acc_aircraft a LEFT JOIN ap_t_acc_accident b ON a.id_accident = b.id_accident ";
		$strQuery .= " LEFT JOIN ap_airline c ON a.id_org = c.id_org";
		$strQuery .=" WHERE ". $strFilter;
		$strQuery .= "GROUP BY a.id_org";
		$query = $this->db->query($strQuery);
		$data["data"] = $query->result_array();
		if($airlines =='all') $query = $this->db->query("select a.id, a.nama, a.iata FROM ap_airport a ");
		else $query = $this->db->query("select  a.id, a.nama, a.iata FROM ap_airport a WHERE a.id IN (".str_replace("_",",",$strAirports).")");
		$airports = array();
		foreach($query->result() as $airport){
			$airports[] = array("nama"=>$airport->nama,"id"=>$airport->id,"iata"=>$airport->iata );
		}
		$data["airports"] = $airports;
		$this->load->view("ap_serious_accident/accident byAirpotMonth", $data);
	}	
	
	function password($password = ''){
		echo md5($password);
	}
	
}

?>