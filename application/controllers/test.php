<?php

include_once APPPATH.'classes\User.php';
 
class Test extends Admin_Controller {
		
	function index()
	{
		$query = $this->db->query('SELECT * FROM v_users WHERE id = 170;');
		$this->the_user = $query->row('User');
				
		$data['main_content'] = 'test' ;
		$data['header_title'] = "Test" ;
		$data['theuser'] = $this->the_user;

		$this->load->view('includes/template', $data);				
		
		
		
	}
	
}
?>