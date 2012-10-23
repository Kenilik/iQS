<?php

class equipment_model extends CI_Model {
	
	
	function getAll($EqTypeID = FALSE){
		if ($EqTypeID === FALSE) {
			$q = $this->db->get("equipment") ;
		} else {
			$sql = "SELECT * FROM Equipment WHERE EquipTypeID = ?" ; 
			$q = $this->db->query($sql, $EqTypeID) ;
		}
		
		if($q->num_rows()>0){
			// do nothing and return $q
		} else {
			$q = 'There are no equipment items of type ' . $EqTypeID . ' in the system.' ;
		}
		return $q;
	}


}
