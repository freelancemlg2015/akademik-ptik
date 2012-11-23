<?php
class map_serious_accident extends Model {
    
    var $table = "ap_t_acc_accident";

    function map_serious_accident() {
        parent::Model();
    }
    function getTypeIncident(){
        $data = array();
        $Q = $this->db->order_by('id_incident_type', 'asc')->get('ap_m_incident_type');
        foreach ($Q->result_array() as $row) $data[] = $row;
        $Q->free_result();
        return $data;
    }
    
	function count_parent($search, $val, $user=null) {
        $jabatan = $this->session->userdata('id_jabatan');
		$org_type = $this->session->userdata('id_tipeorg');
        $this->db->select('a.id_accident, f.nm_org, f.nm_tipeorg, a.acc_datetime_local, a.id_emergency_type, b.emergency_type as dtl_emergency_type, c.nama_kabupaten, g.nama_provinsi, a.acc_jml_aircraft, a.acc_desc, d.nama as airport, a.airport_txt, a.acc_location, h.id_t_acc_parent');
        $this->db->join('ap_m_emergency_type b', 'a.id_emergency_type = b.id_emergency_type', 'left');
        $this->db->join('ap_m_kabupaten c', 'a.id_kabupaten = c.id_kabupaten', 'left');
        $this->db->join('ap_airport d', 'a.id_airport = d.id', 'left');
        $this->db->join('ap_user e', 'a.id_user = e.id_user', 'left');
        $this->db->join('ap_organisasi f', 'e.kode_organisasi = f.id_org', 'inner');
        $this->db->join('ap_m_provinsi g', 'g.id_provinsi = a.id_provinsi', 'inner');
		$this->db->join('ap_t_acc_ssp_join h', 'h.id_accident = a.id_accident', 'left');
        //if ($jabatan != 2) if ($user) $this->db->where('f.id_org', $this->session->userdata('id_org'));
		if ($user){
			if($org_type == 1) {
				$this->db->where('f.id_org', $this->session->userdata('id_org'));
				/*
				$this->db->or_where('a.id_accident IN (SELECT b.`id_accident`
					FROM `ap_t_acc_ssp_join` a
					LEFT JOIN `ap_t_acc_ssp_join` b ON a.`id_t_acc_parent` = b.`id_t_acc_parent`
					LEFT JOIN `ap_organisasi` c ON b.`id_org_reporter` = c.`id_org`
					WHERE a.`id_org_reporter` ='.$this->session->userdata('id_org').'  AND c.`nm_tipeorg` = 4)');*/	
			}else if($jabatan != 2) {
				$this->db->where('f.id_org', $this->session->userdata('id_org'));
				$this->db->or_where('f.nm_tipeorg', 4);
			}
		}
        if ($search == 'join'){
            $value = explode("_", $val);
            $this->db->like('acc_datetime_local', $value[0]);
            $this->db->like('d.id', $value[1]);
            $this->db->like('c.id_kabupaten', $value[2]);
        }
        else {
            $search <> '0' && $val <> '0' ? $this->db->like($search, $val) : '';
        }
        //$order <> '0' && $by <> '0' ? $this->db->order_by($order, $by) : $this->db->order_by("a.id_accident","desc");
		return $this->db->get("ap_t_acc_accident a")->num_rows();
    }
	function get_all($limit, $offset, $search='0', $val='0', $order='0', $by='0', $user=null) {
        $jabatan = $this->session->userdata('id_jabatan');
		$org_type = $this->session->userdata('id_tipeorg');
        $this->db->select('a.id_accident, f.nm_org, f.nm_tipeorg, a.acc_datetime_local, a.id_emergency_type, b.emergency_type as dtl_emergency_type, c.nama_kabupaten, g.nama_provinsi, a.acc_jml_aircraft, a.acc_desc, d.nama as airport, a.airport_txt, a.acc_location, h.id_t_acc_parent');
        $this->db->join('ap_m_emergency_type b', 'a.id_emergency_type = b.id_emergency_type', 'left');
        $this->db->join('ap_m_kabupaten c', 'a.id_kabupaten = c.id_kabupaten', 'left');
        $this->db->join('ap_airport d', 'a.id_airport = d.id', 'left');
        $this->db->join('ap_user e', 'a.id_user = e.id_user', 'left');
        $this->db->join('ap_organisasi f', 'e.kode_organisasi = f.id_org', 'left');
        $this->db->join('ap_m_provinsi g', 'g.id_provinsi = a.id_provinsi', 'left');
		$this->db->join('ap_t_acc_ssp_join h', 'h.id_accident = a.id_accident', 'left');
        //if ($jabatan != 2) if ($user) $this->db->where('f.id_org', $this->session->userdata('id_org'));
		if ($user){
			if($org_type == 1) {
				$this->db->where('f.id_org', $this->session->userdata('id_org'));
				/*$this->db->or_where('a.id_accident IN (SELECT b.`id_accident`
					FROM `ap_t_acc_ssp_join` a
					LEFT JOIN `ap_t_acc_ssp_join` b ON a.`id_t_acc_parent` = b.`id_t_acc_parent`
					LEFT JOIN `ap_organisasi` c ON b.`id_org_reporter` = c.`id_org`
					WHERE a.`id_org_reporter` ='.$this->session->userdata('id_org').'  AND c.`nm_tipeorg` = 4)');	*/
			
			}else if($jabatan != 52 && $org_type == 15) {
				$this->db->where('a.id_org', $this->session->userdata('id_org'));
				$this->db->or_where('d.id_org_otoritas', $this->session->userdata('id_org'));
			}else if($jabatan != 2) {
				$this->db->where('f.id_org', $this->session->userdata('id_org'));
				$this->db->or_where('f.nm_tipeorg', 4);
			}
		}
        if ($search == 'join'){
            $value = explode("_", $val);
            $this->db->like('acc_datetime_local', $value[0]);
            $this->db->like('d.id', $value[1]);
            $this->db->like('c.id_kabupaten', $value[2]);
        }
        else {
            $search <> '0' && $val <> '0' ? $this->db->like($search, $val) : '';
        }
        $order <> '0' && $by <> '0' ? $this->db->order_by($order, $by) : $this->db->order_by("a.id_accident","desc");
        $this->db->limit($limit,$offset);
        $Q = $this->db->get("ap_t_acc_accident a");
		log_message('DEBUG','69 '.$this->db->last_query());
        //echo $this->db->last_query();
        return $Q;
    }
    function count_join($search, $val, $user=null){
		$value = explode("_", $val);
		$this->db->select("a.id_accident");
		$this->db->join('ap_m_emergency_type b', 'a.id_emergency_type = b.id_emergency_type', 'left');
        $this->db->join('ap_m_kabupaten c', 'a.id_kabupaten = c.id_kabupaten', 'left');
        $this->db->join('ap_airport d', 'a.id_airport = d.id', 'left');
        $this->db->join('ap_user e', 'a.id_user = e.id_user', 'left');
        $this->db->join('ap_organisasi f', 'e.kode_organisasi = f.id_org', 'inner');
		$this->db->where('a.id_accident NOT IN (SELECT id_accident FROM ap_t_acc_ssp_join)', null, false);
        $this->db->like('acc_datetime_local', @$value[0])->like('d.id', @$value[1])->like('c.id_kabupaten', @$value[2]);
		return $this->db->get("ap_t_acc_accident a")->num_rows();
	}
	function get_join($limit, $offset, $search='0', $val='0', $order='0', $by='0', $user=null){
        $value = explode("_", $val);
        $this->db->select('a.id_accident, f.nm_org, a.acc_datetime_local, a.id_emergency_type, a.emergency_type as emergency_type, b.emergency_type as dtl_emergency_type, c.nama_kabupaten, g.nama_provinsi, a.acc_jml_aircraft, a.acc_desc, d.nama as airport, a.acc_location');
        $this->db->join('ap_m_emergency_type b', 'a.id_emergency_type = b.id_emergency_type', 'left');
        $this->db->join('ap_m_kabupaten c', 'a.id_kabupaten = c.id_kabupaten', 'left');
        $this->db->join('ap_airport d', 'a.id_airport = d.id', 'left');
        $this->db->join('ap_user e', 'a.id_user = e.id_user', 'left');
        $this->db->join('ap_organisasi f', 'e.kode_organisasi = f.id_org', 'inner');
        $this->db->join('ap_m_provinsi g', 'g.id_provinsi = a.id_provinsi', 'inner');
        $this->db->where('a.id_accident NOT IN (SELECT id_accident FROM ap_t_acc_ssp_join)', null, false);
        $this->db->like('acc_datetime_local', @$value[0])->like('d.id', @$value[1])->like('c.id_kabupaten', @$value[2]);
        $order <> '0' && $by <> '0' ? $this->db->order_by($order, $by) : $this->db->order_by("a.id_accident","desc");
        $this->db->limit($limit,$offset);
        $Q = $this->db->get("ap_t_acc_accident a");
        //echo $this->db->last_query();
        return $Q;
    }
    function count_parent2($search, $val){
		$this->db->select('a.id_t_acc_ssp_join');
        $this->db->join('ap_organisasi b', 'a.id_org_reporter = b.id_org', 'left');
        $this->db->join('ap_t_acc_followup c', 'a.id_t_acc_ssp_join = c.id_t_acc_ssp_join', 'left');
        $this->db->group_by('id_t_acc_parent');
		$search <> '0' && $val <> '0' ? $this->db->like($search, $val) : '';
        return $this->db->get('ap_t_acc_ssp_join a')->num_rows();
    }
	function get_all2($limit, $offset, $search='0', $val='0', $order='0', $by='0'){
        $this->db->select('a.id_t_acc_ssp_join, join_date, GROUP_CONCAT(b.nm_org) AS reported_from, ssp_desc, join_status, id_t_acc_followup, a.id_t_acc_parent');
        $this->db->join('ap_organisasi b', 'a.id_org_reporter = b.id_org', 'left');
        $this->db->join('ap_t_acc_followup c', 'a.id_t_acc_ssp_join = c.id_t_acc_ssp_join', 'left');
		$search <> '0' && $val <> '0' ? $this->db->like($search, $val) : '';
        $order <> '0' && $by <> '0' ? $this->db->order_by($order, $by) : $this->db->order_by("a.id_accident","desc");
        $this->db->limit($limit,$offset);
		$Q = $this->db->group_by('a.id_t_acc_parent')->get('ap_t_acc_ssp_join a');
		//echo $this->db->last_query();
        return $Q;
    }
    function get_aircraft($id_accident){
        $Q = $this->db->select('id_acc_aircraft, id_org')->get_where('ap_t_acc_aircraft', array("id_accident" => $id_accident));
        return $Q->result_array();
    }
    
    function getMasterData($table, $order, $sort, $where=null, $param=null, $field=null){
        $data = array();
        if ($field != null) $this->db->select($field);
        if ($where != null) $this->db->where($where, $param);
        $Q = $this->db->order_by($order, $sort)->get($table);
        foreach ($Q->result_array() as $row) $data[] = $row;
        $Q->free_result();
        return $data;
    }
    function data_master($table, $param=null, $field=null){
        $data = array();
        $param ? $this->db->where('id_incident_type', $param) : '';
        $field ? $this->db->select($field) : '';
        $Q = $this->db->order_by('incident_type_cat_name', 'asc')->get($table);
        foreach ($Q->result_array() as $row) $data[] = $row;
        $Q->free_result();
        return $data;
    }
    function data_master_causes($table, $param=null, $field=null){
        $data = array();
        $param ? $this->db->where('id_acc_causes', $param) : '';
        $field ? $this->db->select($field) : '';
        $Q = $this->db->order_by('detail_causes_name', 'asc')->get($table);
        foreach ($Q->result_array() as $row) $data[] = $row;
        $Q->free_result();
        return $data;
    }
    function getDetail($id){
        $this->db->select('a.*, CONCAT("(", icao, " - ", iata, ") ", nama) as nama_airport, c.id_acc_causes, e.id_org, d.username', false);
        $this->db->join('ap_airport b', 'a.id_airport=b.id', 'left');
        $this->db->join('ap_m_detail_causes c', 'a.id_detail_causes=c.id_detail_causes', 'left');
        $this->db->join('ap_user d', 'a.id_user=d.id_user', 'left');
        $this->db->join('ap_organisasi e', 'd.kode_organisasi=e.id_org', 'left');
        $Q = $this->db->get_where("ap_t_acc_accident a", array('a.id_accident' => $id));
        $Q->num_rows() > 0 ? $data = $Q->row() : $data = array();
        $Q->free_result();
        //echo $this->db->last_query();
		return $data;
    }
    function getDetail2($id){
        $data = array();
        $this->db->select(
        'a.*, c.id as arr_id, concat("(",c.icao," - ",c.iata, ") ", c.nama) as arr_nama, c.lat as arr_lat, c.lng as arr_lng, 
        d.id as dep_id, concat("(",d.icao," - ",d.iata, ") ", d.nama) as dep_nama, d.lat as dep_lat, d.lng as dep_lng, e.id_airline, e.nama_airline', false);
        $this->db->join('ap_t_flight_number b', 'a.id_acc_aircraft = b.id_acc_aircraft', 'left');
        $this->db->join('ap_airport c', 'a.arrival = c.id', 'left');
        $this->db->join('ap_airport d', 'a.departure = d.id', 'left');
        $this->db->join('ap_airline e', 'a.id_org = e.id_org', 'left');
        $Q = $this->db->get_where('ap_t_acc_aircraft a', array('a.id_accident' => $id));
		
        if ($Q->num_rows() > 0){ foreach ($Q->result_array() as $row) $data[] = $row; }
        $Q->free_result();
        //echo $this->db->last_query();
        return $data;
    }
	
	function getInjury($id_accident){
		$this->db->select('*');
		$this->db->where("id_acc_aircraft IN (SELECT `id_acc_aircraft` FROM `ap_t_acc_aircraft` WHERE `id_accident` =$id_accident)");
		$Query = $this->db->get('ap_t_acc_injury_to_person');
		$data = array();
		foreach($Query->result_array() as $row){
			$data[$row['id_acc_aircraft']] =$row;
		}
		$Query->free_result();
		return $data;
	}
	
	function getDetailPerson($id_accident){
		$this->db->select('*');
		$this->db->where("id_acc_aircraft IN (SELECT `id_acc_aircraft` FROM `ap_t_acc_aircraft` WHERE `id_accident` =$id_accident)");
		$Query = $this->db->get('ap_t_acc_aircraft_personnel');
		$data = array();
		foreach($Query->result_array() as $row){
			$data[$row['id_acc_aircraft']][] =$row;
		}
		$Query->free_result();
		return $data;
	}
	
    function delete($id){
        $sql = "
        DELETE a, b, c, d, e
        FROM ap_t_acc_accident a
        LEFT JOIN ap_t_acc_aircraft b ON a.id_accident = b.id_accident
        LEFT JOIN ap_t_flight_number c ON b.id_acc_aircraft = c.id_acc_aircraft
        LEFT JOIN ap_t_acc_facilities d ON d.id_accident = a.id_accident
        LEFT JOIN ap_t_acc_personnel e ON e.id_accident = a.id_accident
        WHERE a.id_accident = ".$id."";
        $this->db->query($sql);
    }
    function get_serious_in($id, $id_parent=null, $param=null){
		$this->db->join('ap_m_emergency_type b', 'a.id_emergency_type = b.id_emergency_type', 'left');
        $this->db->join('ap_m_kabupaten c', 'a.id_kabupaten = c.id_kabupaten', 'left');
        $this->db->join('ap_user d', 'a.id_user = d.id_user', 'left');
        $this->db->join('ap_organisasi e', 'd.kode_organisasi = e.id_org', 'left');
        $this->db->join('ap_airport f', 'a.id_airport = f.id', 'left');
        $this->db->join('ap_t_acc_aircraft g', 'a.id_accident = g.id_accident', 'left');
        $this->db->join('ap_airline h', 'g.id_org = h.id_airline', 'left');
        if ($param){
			$this->db->select('a.id_accident, a.id_airport, a.id_emergency_type, a.acc_datetime_local, e.nm_org, b.emergency_type, a.emergency_type as et, f.nama, c.nama_kabupaten, group_concat(nama_airline) as airline');
			for ($i=0;$i<count($param);$i++){
                $idx = key($param);
                $this->db->where($idx, $param[$idx]);
                next($param);
            }
			$this->db->where('a.id_accident NOT IN(SELECT id_accident from ap_t_acc_ssp_join)', null, false);
		}
		else if ($id){
			$this->db->select('a.id_accident, a.id_airport, a.id_emergency_type, a.acc_datetime_local, e.nm_org, b.emergency_type, a.emergency_type as et, f.nama, c.nama_kabupaten, group_concat(nama_airline) as airline');
			$this->db->where('a.id_accident in ('.$id.')', null, false);
		}
		else {
			$this->db->select('a.id_accident, a.id_airport, a.id_emergency_type, a.acc_datetime_local, e.nm_org, b.emergency_type, a.emergency_type as et, f.nama, c.nama_kabupaten, group_concat(nama_airline) as airline, i.ssp_desc');
			$this->db->join('ap_t_acc_ssp_join i', 'i.id_accident = a.id_accident', 'left');
			$this->db->where('i.id_t_acc_parent', $id_parent);
		}
		$this->db->group_by('a.id_accident');
        $Q = $this->db->get("ap_t_acc_accident a")->result_array();
		//echo $this->db->last_query();
        return $Q;
    }
    function get_org($id_serious_accident){
        $this->db->select('c.id_org');
        $this->db->join('ap_user b', 'a.id_user = b.id_user', 'left');
        $this->db->join('ap_organisasi c', 'b.kode_organisasi = c.id_org', 'left');
        $this->db->where('a.id_accident', $id_serious_accident);
        $Q = $this->db->get('ap_t_acc_accident a')->row();
        return !empty($Q->id_org) ? $Q->id_org : null;
    }
    function getDetailJoin($id, $id_org=null){
		$this->db->select('a.*, b.nm_org');
        $this->db->join('ap_organisasi b', 'b.id_org = a.id_org_reporter', 'left');
        $this->db->where('id_t_acc_parent', $id);
		if ($id_org) $this->db->where('(a.id_org_reporter = '.$id_org.' OR b.nm_tipeorg != 4 )', null, false);
		$Q = $this->db->get('ap_t_acc_ssp_join a');
		//echo $this->db->last_query();
		return $Q->result_array();
    }
    function detail_aircraft($id){
		$this->db->select('a.id_acc_aircraft, a.airlines_txt, a.arrival_txt, a.departure_txt, a.reg_number, a.aircraft_type, a.flight_number, CONCAT("(",b.icao," - ",b.iata,") ",b.nama) as arrival, CONCAT("(",c.icao," - ",c.iata,") ",c.nama) as departure, d.nama_airline', false);
		$this->db->join('ap_airport b', 'a.arrival = b.id', 'left');
		$this->db->join('ap_airport c', 'a.departure = c.id', 'left');
		$this->db->join('ap_airline d', 'a.id_org = d.id_org', 'left');
		$Q = $this->db->get_where("ap_t_acc_aircraft a", array("id_accident"=>$id))->result_array();
		//echo $this->db->last_query();
        return $Q;
	}
	function report_dtl($id){
		$this->db->select('
		a.acc_datetime_local, a.acc_datetime_utc, a.emergency_type as et_1, b.emergency_type as et_2, f.occurrance_type as occurrance, e.occ_detail_type_name as occurrance_detail  ,c.nama_kabupaten,
		CONCAT("(",d.icao," - ",d.iata,") ",d.nama) as airport, a.dangerous_good_desc, a.passanger_position,a.survival_aspect, 
		a.wind_direction, a.wind_force, a.light_condition, a.weather_data, a.landmark_visible, a.acc_cronology, a.acc_impact, a.personnel_count', false);
		$this->db->join('ap_m_emergency_type b', 'a.id_emergency_type = b.id_emergency_type', 'left');
		$this->db->join('ap_m_kabupaten c', 'a.id_kabupaten = c.id_kabupaten', 'left');
		$this->db->join('ap_airport d', 'a.id_airport = d.id', 'left');
		$this->db->join('ap_m_occ_detail_type e',' a.id_occ_type_detail = e.id_occ_detail_type');
		$this->db->join('ap_m_occ_type f',' e.id_occ_type = f.id_occ_type');
		$Q = $this->db->get_where("ap_t_acc_accident a", array("id_accident"=>$id))->row();
		//echo $this->db->last_query();
		return $Q;
	}
	
	function InjuryToPerson($id_accident =0 ){
		$Q = $this->db->query('select sum(a.fatal_flight_crew) as fatal_flight_crew , sum(a.fatal_passanger) as fatal_passanger, sum(a.fatal_total_in_aircraft) as fatal_total_in_aircraft, sum(a.fatal_other) as fatal_other, 
				sum(a.serious_flight_crew) as serious_flight_crew, sum(a.serious_passanger) as serious_passanger, sum(a.serious_total_in_aircraft) as serious_total_in_aircraft,
				sum(a.minor_flight_crew) as minor_flight_crew, sum(a.minor_passanger) as minor_passanger, sum(a.minor_total_in_aircraft) as minor_total_in_aircraft, 
				sum(a.non_injury_flight_crew) as non_injury_flight_crew, sum(a.nil_injury_passanger) as nil_injury_passanger, sum(a.nil_injury_total_in_aircraft) as nil_injury_total_in_aircraft
			from ap_t_acc_injury_to_person a
			left join ap_t_acc_aircraft b on a.id_acc_aircraft = b.id_acc_aircraft
			where b.id_accident =' . $id_accident);
		return $Q->row();
	}
	
	function get_data_aircraft($field, $table, $order, $sort, $where=null, $param=null){
        $this->db->select($field)->distinct();
		if ($where != null) $this->db->where($where, $param);
        $Q = $this->db->order_by($order, $sort)->get($table)->result_array();
        //echo $this->db->last_query()."<br>";
        //$Q->free_result();
        return $Q;
    }
	function get_detail_followup($id_join_first, $id_user){
        $Q = $this->db->get_where('ap_t_acc_followup', array('id_t_acc_ssp_join'=>$id_join_first, 'id_user'=>$id_user))->row();
        return $Q;
    }
    function get_acc_followup($id_user, $id_org_reporter){
        $Q = $this->db->select('id_accident')->get_where('ap_t_acc_ssp_join', array('id_user'=>$id_user, 'id_org_reporter'=>$id_org_reporter))->row();
        return $Q;
    }
	
    function getMultiSeries1($id_airport=0, $tahun=0, $bulan=0){
        $this->db->select('YEAR(a.acc_datetime_local) AS tahun, MONTH(a.acc_datetime_local) AS bulan, b.id, b.icao, b.iata, b.nama, COUNT(a.id_airport) AS jml_accident');
        $this->db->join('ap_airport b', 'a.id_airport = b.id', 'left');
        $this->db->group_by('a.id_airport')->order_by('b.nama', 'ASC');
        if ($id_airport != 0) $this->db->where('b.id', $id_airport);
        if ($tahun != 0) $this->db->where('YEAR(a.acc_datetime_local)', $tahun);
        if ($bulan != 0) $this->db->where('MONTH(a.acc_datetime_local)', $bulan);
        $Q = $this->db->get('ap_t_acc_accident a');
        return $Q->result_array();
    }
    function getMultiSeries2($id_airline=0, $tahun=0, $bulan=0){
        $this->db->select('b.id_org, c.nama_airline, c.kd_ICAO, c.kd_IATA, COUNT(b.id_org) AS jml_accident');
        $this->db->join('ap_t_acc_aircraft b', 'a.id_accident = b.id_accident', 'left');
        $this->db->join('ap_airline c', 'c.id_org = b.id_org', 'left');
        $this->db->group_by('b.id_org')->order_by('c.nama_airline', 'ASC');
        $this->db->where("b.id_org !=", 0);
        if ($id_airline != 0) $this->db->where('b.id_org', $id_airline);
        if ($tahun != 0) $this->db->where('YEAR(a.acc_datetime_local)', $tahun);
        if ($bulan != 0) $this->db->where('MONTH(a.acc_datetime_local)', $bulan);
        $Q = $this->db->get('ap_t_acc_accident a');
        return $Q->result_array();
    }
    function getMultiSeries3(){
        $this->db->select('d.nm_org, COUNT(b.id_org) AS jml_accident, c.nama_airline');
        $this->db->join('ap_t_acc_aircraft b', 'a.id_accident = b.id_accident', 'left');
        $this->db->join('ap_airline c', 'c.id_airline = b.id_org', 'left');
        $this->db->join('ap_user e', 'a.id_user = e.id_user', 'left');
        $this->db->join('ap_organisasi d', 'd.id_org = e.kode_organisasi', 'left');
        $this->db->group_by('d.id_org, b.id_org')->order_by('d.id_org, b.id_org', 'ASC');
        $Q = $this->db->get('ap_t_acc_accident a');
        return $Q->result_array();
    }
    function getMultiSeries4($tahun1=0, $tahun2=0){
        $this->db->select('COUNT(id_accident) AS jml_accident, YEAR(acc_datetime_local) AS tahun', false);
        if ($tahun1 != 0) $this->db->where('YEAR(acc_datetime_local) BETWEEN '.$tahun1.' AND '.$tahun2, null, false);
        $Q = $this->db->group_by('YEAR(acc_datetime_local)', false)->get('ap_t_acc_accident');
        foreach ($Q->result_array() as $row) $data[] = $row;
        $Q->free_result();
        //echo $this->db->last_query();
        return $data;
    }
    
	function getMultiSeries5(){
		$result = $this->db->query("SELECT
			  CASE a.id_emergency_type
				  WHEN 1 THEN 'Accident'
				  WHEN 2 THEN 'Serious Incident'
				  WHEN 3 THEN 'Incident'
				  WHEN 4 THEN 'Occurrence'
				  ELSE ''
			  END AS emergency_type,
			  count(*) as 'jml_accident'
			FROM ap_t_acc_accident a
			GROUP BY a.id_emergency_type");
		return $result ->result_array(); 
	}
	
    function count_otoritas($search, $val){
        $id_org = $this->session->userdata('id_org');
        $id_jbt = $this->session->userdata('id_jabatan');
        $this->db->select("a.id_accident");
        $this->db->join('ap_m_emergency_type b', 'a.id_emergency_type = b.id_emergency_type', 'left');
        $this->db->join('ap_m_kabupaten c', 'a.id_kabupaten = c.id_kabupaten', 'left');
        $this->db->join('ap_airport d', 'a.id_airport = d.id', 'left');
        $this->db->join('ap_user e', 'a.id_user = e.id_user', 'left');
        $this->db->join('ap_organisasi f', 'e.kode_organisasi = f.id_org', 'inner');
        $this->db->where('a.id_org', $id_org);
        $this->db->or_where('d.id_org_otoritas', $id_org);
        $search <> '0' && $val <> '0' ? $this->db->like($search, $val) : '';
        return $this->db->get("ap_t_acc_accident a")->num_rows();
    }
    function get_otoritas($limit, $offset, $search='0', $val='0', $order='0', $by='0'){
        $id_org = $this->session->userdata('id_org');
        $id_jbt = $this->session->userdata('id_jabatan');
        $this->db->select('a.id_accident, f.nm_org, a.acc_datetime_local, a.emergency_type as emergency_type, b.emergency_type as dtl_emergency_type, c.nama_kabupaten, a.acc_jml_aircraft, a.acc_desc, d.nama as airport, a.airport_txt');
        $this->db->join('ap_m_emergency_type b', 'a.id_emergency_type = b.id_emergency_type', 'left');
        $this->db->join('ap_m_kabupaten c', 'a.id_kabupaten = c.id_kabupaten', 'left');
        $this->db->join('ap_airport d', 'a.id_airport = d.id', 'left');
        $this->db->join('ap_user e', 'a.id_user = e.id_user', 'left');
        $this->db->join('ap_organisasi f', 'e.kode_organisasi = f.id_org', 'inner');
        $this->db->where('a.id_org', $id_org);
        $this->db->or_where('d.id_org_otoritas', $id_org);
        $search <> '0' && $val <> '0' ? $this->db->like($search, $val) : '';
        $order <> '0' && $by <> '0' ? $this->db->order_by($order, $by) : $this->db->order_by("a.id_accident","desc");
        $this->db->limit($limit,$offset);
        $Q = $this->db->get("ap_t_acc_accident a");
        //echo $this->db->last_query();
        return $Q;
    }
    function getIdAccident($id_acc_aircraft){
        $Q = $this->db->select('id_accident')->get_where('ap_t_acc_aircraft', array('id_acc_aircraft' => $id_acc_aircraft))->row();
        //echo $this->db->last_query();
		return $Q->id_accident;
    }
	
	function getYearReport($year=0, $month = 0){
		$query = $this->db->query("SELECT a.id_airport, b.nama, b.iata 
			  sum(IF(MONTH(a.acc_datetime_local)=1,1,0)) AS month_1,
			  sum(IF(MONTH(a.acc_datetime_local)=2,1,0)) AS month_2,
			  sum(IF(MONTH(a.acc_datetime_local)=3,1,0)) AS month_3,
			  sum(IF(MONTH(a.acc_datetime_local)=4,1,0)) AS month_4,
			  sum(IF(MONTH(a.acc_datetime_local)=5,1,0)) AS month_5,
			  sum(IF(MONTH(a.acc_datetime_local)=6,1,0)) AS month_6,
			  sum(IF(MONTH(a.acc_datetime_local)=7,1,0)) AS month_7,
			  sum(IF(MONTH(a.acc_datetime_local)=8,1,0)) AS month_8,
			  sum(IF(MONTH(a.acc_datetime_local)=9,1,0)) AS month_9,
			  sum(IF(MONTH(a.acc_datetime_local)=10,1,0)) AS month_10,
			  sum(IF(MONTH(a.acc_datetime_local)=11,1,0)) AS month_11,
			  sum(IF(MONTH(a.acc_datetime_local)=12,1,0)) AS month_12, 
			  COUNT(*) as total
			FROM ap_t_acc_accident a
			LEFT JOIN ap_airport b ON a.id_airport = b.id
			WHERE YEAR(a.acc_datetime_local) =$year
			GROUP BY a.id_airport, b.nama, b.iata");
		return $query->result();
	}
	
	function getKey($Table ='',$KeyField ='', $Key = 0, $ReturnField = ''  ){
		$Query = $this->db->select($ReturnField)->where($KeyField,$Key)->get($Table);
		if($Query->num_rows()<1) return false;
		$temp = $Query->row_array();
		return $temp[$ReturnField];
	}
	
	function InsertAccident( $data){
		 $this->db->insert('ap_t_acc_accident', $data);
		 return $this->db->insert_id();
	}
	
	function UpdateAccident($id_accident, $data){
		 $this->db->where('id_accident', $id_accident)->update('ap_t_acc_accident', $data);
	}
	
	function InsertAccidentAircraft($data){
		$this->db->insert('ap_t_acc_aircraft', $data);
		return $this->db->insert_id();
	}
	
	function UpdateAccidentAircraft($id_acc_aircraft, $data){
		$this->db->where('id_acc_aircraft', $id_acc_aircraft)->update('ap_t_acc_aircraft', $data);
	}
	
	function DeleteUnusedAccidentAircraft($id_acc_aircraft,$id_accident){
		$this->db->where('id_accident' ,$id_accident);
		if(strpos($id_acc_aircraft, ",")===false) $id_acc_aircrafts =$id_acc_aircraft;
		else if(is_array($id_acc_aircraft)) $id_acc_aircrafts = $id_acc_aircraft;
		else $id_acc_aircrafts = explode(',',$id_acc_aircraft);
		$this->db->where_not_in('id_acc_aircraft',$id_acc_aircrafts);
		$this->db->delete('ap_t_acc_aircraft');
	}
	
	function InsertAccidentAircraftDetail($data){
		$this->db->insert('ap_t_acc_aircraft_detail', $data);
		$this->db->insert_id();
	}
	
	function UpdateAccidentAircraftDetail($id_acc_aircraft_detail, $data){
		 $this->db->where('id_acc_aircraft_detail', $id_acc_aircraft_detail)->update('ap_t_acc_aircraft_detail', $data);
	}
	
	function InsertOwnerOperator( $data){
		$this->db->insert('ap_t_acc_aircraft_owner_operator', $data);
		return $this->db->insert_id();
	}
	
	function UpdateOwnerOperator($id_acc_aircraft_owner_operator, $data){
		$this->db->where("id_acc_aircraft_owner_operator",$id_acc_aircraft_owner_operator)->update('ap_t_acc_aircraft_owner_operator', $data);
	}
	
	function InsertOwner( $data){
		$this->db->insert('ap_t_acc_aircraft_owner', $data);
		return $this->db->insert_id();
	}
	
	function UpdateOwner($id_acc_aircraft_owner, $data){
		$this->db->where("id_acc_aircraft_owner",$id_acc_aircraft_owner)->update('ap_t_acc_aircraft_owner', $data);
	}
	
	function InsertOperator($data){
		$this->db->insert('ap_t_acc_aircraft_operator', $data);
		return $this->db->insert_id();
	}
	
	function UpdateOperator($id_acc_aircraft_operator, $data){
		$this->db->where("id_acc_aircraft_operator",$id_acc_aircraft_operator)->update('ap_t_acc_aircraft_operator', $data);
	}
	
	function InsertAircraftPersonnel($data){
		$this->db->insert('ap_t_acc_aircraft_personnel', $data);
		return $this->db->insert_id();
	}
	
	function UpdateAircraftPersonnel($id_acc_aircraft_personnel,$data){
		$this->db->where('id_acc_aircraft_personnel', $id_acc_aircraft_personnel);
		$this->db->update('ap_t_acc_aircraft_personnel', $data);
	}
	
	function DeleteAircraftPersonnel($id_acc_aircraft_personnels){
		$this->db->simple_query("DELETE FROM ap_t_acc_aircraft_personnel WHERE id_acc_aircraft_personnel in ($id_acc_aircraft_personnels)");
	}
	
	function InsertFlightTime($data){
		$this->db->insert('ap_t_acc_flight_time', $data);
		return $this->db->insert_id();
	}
	
	function UpdateFlightTime($id_acc_flight_time, $data){
		$this->db->where('id_acc_flight_time', $id_acc_flight_time);
		$this->db->update('ap_t_acc_flight_time', $data);
	}
	
	function InsertAirportDetail($data){
		$this->db->insert('ap_t_acc_airport_detail', $data);
		return $this->db->insert_id();
	}
	
	function UpdateAirportDetail($id_airport_detail,$data){
		$this->db->where("id_airport_detail",$id_airport_detail)->update('ap_t_acc_airport_detail', $data);
	}
	
	function InsertFlightItinerary($data){
		$this->db->insert('ap_t_acc_flight_itinerary', $data);
		return $this->db->insert_id();
	}
	
	function UpdateFlightItinerary($id_flight_itinerary,$data){
		$this->db->where("id_flight_itinerary",$id_flight_itinerary)->update('ap_t_acc_flight_itinerary', $data);
	}
	
	function InsertWeatherObservation($data){
		$this->db->insert('ap_t_acc_weather_observation',$data);
		return $this->db->insert_id();
	}
	
	function UpdateWeatherObservation($id_weather_observation,$data){
		 $this->db->where('id_weather_observation',$id_weather_observation)->update('ap_t_acc_weather_observation',$data);
	}
	
	function InsertPassenger($data){
		$this->db->insert('ap_t_acc_aircraft_passengers', $data); 
	}
	
	function UpdatePassenger($id_passenger,$data){
		$this->db->where('id_passenger', $id_passenger);
		$this->db->update('ap_t_acc_aircraft_passengers', $data);
	}
	
	function DeletePassenger($id_passengers){
		$this->db->simple_query("DELETE FROM ap_t_acc_aircraft_passengers WHERE id_passenger in ($id_passengers)");
	}
	
	function InsertSSPJoin($parent,$param){
		$this->db->insert('ap_t_acc_ssp_join', $param);
		return $this->db->insert_id();
	}
	function UpdateSSPJoin($parent,$param){
		$this->db->where('id_t_acc_parent', $parent);
		$this->db->update('ap_t_acc_ssp_join', $param);
	}
	
	function InsertFacilities($data){
		$this->db->insert('ap_t_acc_facilities', $data);
		return $this->db->insert_id();
	}
	
	function UpdateFacilities($id_acc_facilities, $data){
		$this->db->where('id_acc_facilities', $id_acc_facilities);
		$this->db->update('ap_t_acc_facilities', $data);
	}
	
	function InsertInjuryPerson($data){
		$this->db->insert('ap_t_acc_injury_to_person', $data);
		return $this->db->insert_id();
	}
	
	function UpdateInjuryPerson($id_injury_to_person,$data){
		$this->db->where('id_injury_to_person', $id_injury_to_person);
		$this->db->update('ap_t_acc_injury_to_person', $data);
	}
	
	function DeleteUnusedInjuryPerson($id_injury_to_person,$id_accident){
		if(strpos($id_injury_to_person, ",")===false) $id_injury_to_persons =$id_injury_to_person;
		else if(is_array($id_injury_to_person)) $id_injury_to_persons = $id_injury_to_person;
		else $id_injury_to_persons = explode(',',$id_injury_to_person);
		$this->db->where_not_in('id_injury_to_person', $id_injury_to_persons);
		$this->db->where('id_accident',$id_accident);
		$this->db->delete('ap_t_acc_injury_to_person');
	}
	
	function InsertFollowUp($data){
		$this->db->insert('ap_t_acc_followup', $param);
		return $this->db->insert_id();
	}
	
	function UpdateFollowUp($id_followup = 0, $data){
		$this->db->where('id_t_acc_followup', $id_followup);
		$Q = $this->db->update('ap_t_acc_followup', $data);
	}
	
    /*SELECT a.aircraft_type, 
sum(if(b.emergency_type = 1,1,0)) AS Incident,
sum(if(b.emergency_type = 2,1,0)) AS Accident,
sum(if(b.emergency_type = 3,1,0)) AS `Serious Incident`,
sum(if(b.emergency_type = 4,1,0)) AS Occurrence,
COUNT(*) AS total
FROM ap_t_acc_aircraft a
LEFT JOIN ap_t_acc_accident b ON a.id_accident = b.id_accident
WHERE a.parent_id_aircraft = 0
GROUP BY a.aircraft_type*/
}
?>