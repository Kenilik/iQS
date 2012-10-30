<?php

class Member_model extends CI_Model {

	function validate()
	{
		$this->db->where('qid', $this->input->post('qid'));
		$this->db->where('password', $this->input->post('password'));
		$this->db->where('isAdmin',true);
		$query = $this->db->get('member');
		
		if($query->num_rows == 1)
		{
			return true;
		}
		
	}
	
	function getMember($QID){
		$sql = "SELECT * FROM Member WHERE QID = ?" ;
		$q = $this->db->query($sql, array($QID)) ;
				
		if($q->num_rows()>0) {
			// do nothing return $q
		} else {
			$q=false; //return false if there is no Member by this QID
		} 
		return $q;
	}

	function getAllMembers($paramArr) {
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
		
		$SQL = "SELECT * FROM Member $whereClause order by $sortField $sortOrder $optLimit";
		
		$result = $this->db->query($SQL);

		if($result->num_rows() > 0) {
			$custlist = $result->result();
			return $custlist;
		} else {
			return NULL;
		}
	}
}