<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Login extends CI_Controller
{
	function index()
	{
		// check if the user is already
		$is_logged_in = $this->session->userdata(iQS_COOKIE_UserIsLoggedIn);
		if (!isset($is_logged_in) || $is_logged_in != FALSE){
			redirect('main');
		}

		echo '<div id=login_error>' . $this->session->flashdata('error') . '</div>';
			
		echo form_open('auth/validate_login');
		echo form_input('username', 'spbo60');
		echo form_password('password');
		echo form_submit('submit', 'login');
		echo form_close();
		
		$this->load->view('includes/footer');
	}
}