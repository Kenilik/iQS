<?php

class User_model extends CI_Model {

	function validate()
	{
		$this->db->where('username', $this->input->post('username'));
		$this->db->where('password', $this->input->post('password'));
		$query = $this->db->get('user');
		
		if($query->num_rows == 1){
			return TRUE;
		}
		
	}
	
	function getUser($UserID){
		$sql = "SELECT * FROM user WHERE ID = ?" ;
		$q = $this->db->query($sql, array($UserID)) ;
				
		if( ! $q->num_rows()>0) {
			$q=FALSE; //return false if there is no User by this UserID
		} 
		return $q;
	}

	function getAllUsers($paramArr) {
		$start = isset($paramArr['start'])?$paramArr['start']:NULL;
		$limit = isset($paramArr['limit'])?$paramArr['start']:NULL;
		$sortField = isset($paramArr['sortField'])?$paramArr['sortField']:'LastName';
		$sortOrder = isset($paramArr['sortOrder'])?$paramArr['sortOrder']:'asc';
		$whereParam = isset($paramArr['whereParam'])?$paramArr['whereParam']:NULL;
		
		if( ! empty($start) && ! empty($limit)){
			$optLimit = "limit $start,$limit";
		} else {
			$optLimit = NULL;
		}

		if( ! empty($whereParam)) {
			$whereParam = "and (".$whereParam.")";
		}
		$whereClause = "where true ".$whereParam;
		
		$SQL = "SELECT * FROM user $whereClause order by $sortField $sortOrder $optLimit";
		
		$result = $this->db->query($SQL);

		if($result->num_rows() > 0) {
			$userlist = $result->result();
			return $userlist;
		} else {
			return FALSE;
		}
	}
}