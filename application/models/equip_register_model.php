<?php

class Equip_Register_model extends CI_Model {
	
	// return single row with barcode number lookup
	function getBarcodeNo($barcode_no)  
	{
		$q = $this->db->get_where('v_all_barcodes', array('barcode_no' => $barcode_no));				
		if( ! $q->num_rows()>0) {
			$q=FALSE;
		} 
		return $q;
	}

	// returns single row with barcode lookup result for a given user_id
	function getBarcodeByUser($user_id) 
	{ 			
		$q = $this->db->get_where('v_all_barcodes', array('barcode_type' => 'user', 'id'=> $user_id));		
		if( ! $q->num_rows()>0) {
			$q=FALSE;
		} 
		return $q;
	}
	
	// returns a query result of the equipment currently in use for a given User
	function getEquipInUseByUser($user_id)
	{ 		
		$q = $this->db->get_where('v_equip_in_use', array('user_id' => $user_id));
		if( ! $q->num_rows()>0) {
			$q=FALSE; //return false if there is no equip in use for this QID
		} 
		return $q;
	}
	
	// returns a query result of the equipment currently in use for a given item of equipment or for all equipment
	function getEquipIDInUse($equip_item_id = FALSE)
	{ 
		if ($equip_item_id == FALSE) {
			$q = $this->db->get('v_equip_in_use') ;			
		} else {
			$q = $this->db->get_where('v_equip_in_use', array('equip_item_id' => $equip_item_id)) ;			
		}
		
		if( ! $q->num_rows()>0) {
			$q=FALSE; //return false if this equip item is not in use
		} 
		return $q;
	}
	
	function signEquipIn($equip_item_id, $dt)
	{		
		$data = array('dt_in' => $dt);
		
		$this->db->where('equip_item_id',$equip_item_id);
		$this->db->where('dt_in',NULL);
			
		$q = $this->db->update('equip_register', $data);
		
		return $q;
	}
	
	function signEquipOut($user_id, $equip_item_id, $dt)
	{
		$data = array(
			'user_id'=> $user_id,
			'equip_item_id' => $equip_item_id,
			'dt_out' => $dt
			);
		$q = $this->db->insert('equip_register',$data);
		return $q;
	}
	
}