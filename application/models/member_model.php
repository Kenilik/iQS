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
	
}