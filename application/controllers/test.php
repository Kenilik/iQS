<?php

class Test extends CI_Controller {

	function index()
	{
		$this->form_validation->set_rules('username', 'Username', 'required_if[email,em]');
		//$this->form_validation->set_rules('password', 'Password', 'required');
		//$this->form_validation->set_rules('passconf', 'Password Confirmation', 'required|matches[password]');
		$this->form_validation->set_rules('email', 'Email', 'is_unique_with[site_id,equip_type_id]');
		
		if ( ! $this->form_validation->run() == FALSE){
			$this->form_validation->set_message('Success!');	
		}
		$this->load->view('test');
	}
	
	public function username_check($str)
	{
		if ($str == 'test')
		{
			$this->form_validation->set_message('username_check', 'The %s field can not be the word "test"');
			return FALSE;
		}
		else
		{
			return TRUE;
		}
	}
}
?>