<?php 

class Test extends CI_Controller {

	function index() 
	{
		//$this->User_model->set_password('spbo60','pw'); die();
		
		echo $this->User_model->validate_login('spbo60', 'pw');
		
	}
}