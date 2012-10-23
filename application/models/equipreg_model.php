<?php

//include "/application/classes/BarcodeType.class.php";

class equipreg_model extends CI_Model {
	
	function lookupBarcodeByBCNo($barcodeno) { // returns single row with barcode lookup result
		
		$sql = "SELECT * FROM qAllBarcodeInfo WHERE BarcodeNo = ?" ;
		$q = $this->db->query($sql, array($barcodeno)) ;
				
		if($q->num_rows()>0) {
			// do nothing return $q
		} else {
			$q='Barcode ' . $barcodeno . ' does not exist in the system!';
		} 
		return $q;
	}
	
	function lookupBarcodeByQID($QID) { // returns single row with barcode lookup result
		
		$sql = "SELECT * FROM qAllBarcodeInfo WHERE ID = ?" ;
		$q = $this->db->query($sql, array($QID)) ;
				
		if($q->num_rows()>0) {
			// do nothing return $q
		} else {
			$q='QID ' . $QID. ' does not exist in the system!';
		} 
		return $q;
	}

	function getMemberEquipInUse($QID) { // returns a query result of the equipment currently in use for a given QID
		$sql = "SELECT * FROM qEquipInUse WHERE QID = ?" ;
		$q = $this->db->query($sql, array($QID)) ;
				
		if($q->num_rows()>0) {
			// do nothing return $q
		} else {
			$q=false; //return false if there is no equip in use for this QID
		} 
		return $q;
	}
	
	function getEquipIDInUse($EquipID = FALSE) { // returns a query result of the equipment currently in use for a given QID
		if ($EquipID == FALSE) {
			$sql = "SELECT * FROM qEquipInUse" ;
			$q = $this->db->query($sql) ;			
		} else {
			$sql = "SELECT * FROM qEquipInUse WHERE EquipID = ?" ;
			$q = $this->db->query($sql, array($EquipID)) ;			
		}
		
		if($q->num_rows()>0) {
			// do nothing return $q
		} else {
			$q=false; //return false if this Equip is not in use
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
	
	function signEquipOut($QID, $EquipID, $dt){
		$data = array(
			'QID'=> $QID,
			'EquipID' => $EquipID, 
			'DTOut' => $dt
			);
		$q = $this->db->insert('EquipRegister',$data);
		return $q;		
	}
	
}