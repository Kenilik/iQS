<?php
class district_site_model extends CI_Model {
	
	function getAll(){
		$sql = "SELECT district.districtid, district.districtname, site.siteid, site.sitename FROM site INNER JOIN district WHERE site.districtid=district.districtid" ; 
		$query = $this->db->query($sql) ;
		
		if ($query->num_rows()>0) {
			// do nothing and return $q
			$q = $query->result();
		} else {
			$q = 'There are no districts / sites set up in the system.' ;
		}
		
		return $q;
	}
}