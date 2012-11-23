<?php

class map_aviation_personal extends Model {

	 function map_aviation_personal() {
        parent::Model();
    }
	
	function get_all($id_org='0', $offset , $limit, $val='0', $search='0',$order='0', $by='0') {
		$this->db->select('a.id_t_personnel_management, a.id_kabupaten, a.text_kabupaten, a.id_province, a.text_province, a.id_negara, a.text_negara, a.id_org, a.full_name, a.first_name, a.middle_name, a.last_name, a.home_address, a.office_address, a.office_phone, a.office_phone_ext, a.home_phone, a.mobile_number, a.employee_identification, a.level, a.email, a.date_of_birth, a.marital_status, a.gender, a.identified_type, a.identified_number, a.created_on, a.created_by, a.modified_on, a.modified_by, a.active');
		$this->db->where('a.active','1');
		if($id_org!=0) $this->db->where('a.id_org', $id_org); 
		$query = $this->db->get('t_personnel_management a');	
		return $query->result_array();
	}
	
	function insert($parm = null){
		if(empty($parm)) return;
		$this->db->insert('t_personnel_management',$parm);
		return $this->db->insert_id();
	}
	
	function insert_personal_category($parm = null){
		if(empty($parm)) return -1;
		$this->db->insert('m_aviation_personal_category',$parm);
		return $this->db->insert_id();
	}
	
	function update_personal_category($id_personal_category = 0,$parm = null){
		if(empty($parm) |$id_personal_category == 0 ) return -1;
		$this->db->where('id_personal_category',$id_personal_category );
		$this->db->update('m_aviation_personal_category',$parm);
	}
	
	function getMainOrganizationId($id_org){
		$query = $this->db->query("select case 
			when t1.id_parent = 0 then t1.id_org
			when t2.id_parent = 0 then t2.id_org
			else t2.id_org end as main_organisasi
		from ap_organisasi t1
		left join ap_organisasi t2 on t1.id_parent = t2.id_org
		left join ap_organisasi t3 on t2.id_parent = t3.id_org
		where t1.id_org = $id_org");
		$temp = $query->row_array();
		return $temp['main_organisasi'];
	}
	
	function getAllPersonalCategory(){
		$query = $this->db->query("select a.nm_org, b.nm_tipeorg,t.* from (
			select t1.id_personal_category,t1.personal_category,t1.id_org, t1.id_aviation_category,
			case when not isnull(t3.id_personal_category) then t3.id_personal_category
				 when not isnull(t2.id_personal_category) then t2.id_personal_category
				 else t1.id_personal_category end as l1,
			case when not isnull(t3.id_personal_category) then t2.id_personal_category
				 when not isnull(t2.id_personal_category) then t1.id_personal_category
				 else 0 end as l2,
			case when not isnull(t3.id_personal_category) and not isnull(t2.id_personal_category) then t1.id_personal_category
				 else 0 end as l3
			from m_aviation_personal_category t1
			left join m_aviation_personal_category t2 on t1.parent_id = t2.id_personal_category
			left join m_aviation_personal_category t3 on t2.parent_id = t3.id_personal_category) t
			left join ap_organisasi a on t.id_org= a.id_org
			left join ap_tipeorg b on t.id_aviation_category = b.id_tipeorg
			order by t.l1, t.l2, t.l3");
		return $query->result_array();
	}
	
	function getPersonalCategory($personal_category_id =0){
		$query = $this->db->query("select a.nm_org, b.nm_tipeorg,t.* from (
			select t1.id_personal_category,t1.personal_category,t1.id_org, t1.id_aviation_category,
			case when not isnull(t3.id_personal_category) then t3.id_personal_category
				 when not isnull(t2.id_personal_category) then t2.id_personal_category
				 else t1.id_personal_category end as l1,
			case when not isnull(t3.id_personal_category) then t2.id_personal_category
				 when not isnull(t2.id_personal_category) then t1.id_personal_category
				 else 0 end as l2,
			case when not isnull(t3.id_personal_category) and not isnull(t2.id_personal_category) then t1.id_personal_category
				 else 0 end as l3
			from m_aviation_personal_category t1
			left join m_aviation_personal_category t2 on t1.parent_id = t2.id_personal_category
			left join m_aviation_personal_category t3 on t2.parent_id = t3.id_personal_category) t
			left join ap_organisasi a on t.id_org= a.id_org
			left join ap_tipeorg b on t.id_aviation_category = b.id_tipeorg
			order by t.l1, t.l2, t.l3");		
		return $query->row_array();
	}
	
	function getPersonalCategoriesByOrg($id_org =0, $org_tipe = 0){
		$query = $this->db->query("select a.nm_org, b.nm_tipeorg,t.* from (
			select t1.id_personal_category,t1.personal_category,t1.id_org, t1.id_aviation_category,
			case when not isnull(t3.id_personal_category) then t3.id_personal_category
				 when not isnull(t2.id_personal_category) then t2.id_personal_category
				 else t1.id_personal_category end as l1,
			case when not isnull(t3.id_personal_category) then t2.id_personal_category
				 when not isnull(t2.id_personal_category) then t1.id_personal_category
				 else 0 end as l2,
			case when not isnull(t3.id_personal_category) and not isnull(t2.id_personal_category) then t1.id_personal_category
				 else 0 end as l3
			from m_aviation_personal_category t1
			left join m_aviation_personal_category t2 on t1.parent_id = t2.id_personal_category
			left join m_aviation_personal_category t3 on t2.parent_id = t3.id_personal_category) t
			left join ap_organisasi a on t.id_org= a.id_org
			left join ap_tipeorg b on t.id_aviation_category = b.id_tipeorg
			where t.id_org = $id_org and t.id_aviation_category = $org_tipe
			order by t.l1, t.l2, t.l3");
		return $query->result_array();
	}
	
	function getOrganization(){
		$query = $this->db->query('select * from ap_organisasi a where a.nm_tipeorg = 4 and a.id_parent =0;');
		return $query->result_array();
	}
	
	function getCategory($organization_id = 0){
		$this->db->select('b.nm_org, c.nm_tipeorg, c.id_tipeorg');
		$this->db->join('ap_organisasi b','a.id_org = b.id_org');
		$this->db->join('ap_tipeorg c','a.id_tipeorg = c.id_tipeorg');
		if($organization_id >0) $this->db->where('a.id_org',$organization_id); 
		$query=$this->db->get('ap_m_org_authority a');
		return $query->result_array();
	}

} ?>