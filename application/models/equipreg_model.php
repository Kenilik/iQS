<?php

//include "/application/classes/BarcodeType.class.php";

class equipreg_model extends CI_Model {
	
	function lookupBarcode($barcodeno) { // returns single row with barcode lookup result
		
		$sql = "SELECT * FROM qAllBarcodeInfo WHERE BarcodeNo = ?" ;
		$q = $this->db->query($sql, array($barcodeno)) ;
				
		if( ! $q->num_rows()>0) {
			$q=FALSE;
		} 
		return $q;
	}
	
	function lookupBarcodeByUser($UserID) { // returns single row with barcode lookup result
		
		$sql = "SELECT * FROM qAllBarcodeInfo WHERE BarcodeType = 'User' AND ID = ?" ;
		$q = $this->db->query($sql, array($UserID)) ;
				
		if( ! $q->num_rows()>0) {
			$q=FALSE;
		} 
		return $q;
	}

	function getEquipInUseByUser($UserID) { // returns a query result of the equipment currently in use for a given User
		$sql = "SELECT * FROM qEquipInUse WHERE UserID = ?" ;
		$q = $this->db->query($sql, array($UserID)) ;
				
		if( ! $q->num_rows()>0) {
			$q=FALSE; //return false if there is no equip in use for this QID
		} 
		return $q;
	}
	
	function getEquipIDInUse($EquipID = FALSE) { // returns a query result of the equipment currently in use for a given item of equipment or for all equipment
		if ($EquipID == FALSE) {
			$sql = "SELECT * FROM qEquipInUse" ;
			$q = $this->db->query($sql) ;			
		} else {
			$sql = "SELECT * FROM qEquipInUse WHERE EquipID = ?" ;
			$q = $this->db->query($sql, array($EquipID)) ;			
		}
		
		if( ! $q->num_rows()>0) {
			$q=FALSE; //return false if this Equip is not in use
		} 
		return $q;
	}
	
	function signEquipIn($EquipID, $dt){
		$data = array('DTIn' => $dt);
		$this->db->where('EquipID',$EquipID);
		$this->db->where('DTIn',NULL);
			
		$q = $this->db->update('EquipRegister',$data);
		return $q;
	}
	
	function signEquipOut($UserID, $EquipID, $dt){
		$data = array(
			'UserID'=> $UserID,
			'EquipID' => $EquipID,
			'DTOut' => $dt
			);
		$q = $this->db->insert('EquipRegister',$data);
		return $q;		
	}
	
}