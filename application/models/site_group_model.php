<?php
class Site_Group_model extends CI_Model {
	
	function get($site_id = FALSE)
	{
		if( ! $site_id ==FALSE) {
			$q = $this->db->get_where('v_sites', array('site_id' => $site_id));
		} else {
			$q = $this->db->get('v_sites');
		}

		if( ! $q->num_rows()>0) {
			$q=FALSE;
		} 
		return $q;
	}
}