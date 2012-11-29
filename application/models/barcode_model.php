<?php

class Barcode_model extends CI_Model {
 
/*
 * is_unique_except()
 *
 * This function enforces the database uniqueness of equip_items by site, when 
 * added or edited by the grocery_CRUD. The db has a unique logical composite key 
 * of site_id, equip_type_id, $name. These values are parameters to this function 
 * along with an optional id. This id is passed in when an item is being edited and 
 * that item id is excluded from the database check for uniqueness.
 *   
 * @return FALSE = there is already an item with this site_id, equip_type_id, $name
 * @return TRUE = item is unique with these parameters
 *   
 */
	function is_unique_except($id = 0, $barcode_no)
	{
		$this->db->select('id');
		$this->db->from('v_all_barcodes');
		$this->db->where('id !=', $id);
		$this->db->where('barcode_no', $barcode_no);
		
		//can only ever return 1 row due to db constraints. 
		$query = $this->db->get();
		
		return ($query->num_rows() == 0) ? TRUE : FALSE ;		
	}
	
}		
		
	