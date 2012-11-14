<?php

class Equip_Item_model extends CI_Model {
	
	function get($equip_type_id = FALSE)
	{
		if ($equip_type_id == FALSE) {
			$q = $this->db->get('equip_items');
		} else {
			$q = $this->db->get_where('equip_items', array('id' => $equip_type_id));
		}
	
		if( ! $q->num_rows()>0){
			$q = FALSE;
		}
		return $q;
	}

}
