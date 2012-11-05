<?php
class district_site_model extends CI_Model {
	
	function getAll(){
		$sql = "SELECT district.id as DistrictID, district.name AS DistrictName, site.id AS SiteID, site.name AS SiteName FROM site INNER JOIN district WHERE site.districtid=district.id" ; 
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