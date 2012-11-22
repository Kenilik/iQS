<?php 

class Auth extends CI_Controller {

	function validate_login()
	{
		$username = $this->input->post('username');
		$password =$this->input->post('password');
		
		$this->db->select('username, first_name, last_name, hashed_password');
		$user = $this->db->get_where('users', array('username' => $username))->row();
		
		if ($user && $this->validate_password($user->hashed_password,$password)) {
			$this->login($user);
		} else {
			$this->session->set_flashdata(
				'error',
				'Your login attempt failed.');
		}
		redirect('main/scanner');
	}
	
	private function validate_password($hashed_password, $password)
	{
		$salt = substr($hashed_password, 0, 64);
		$hash = substr($hashed_password, 64, 64);		
		
		$password_hash = hash('sha256', $salt . $password);
		
		return $password_hash == $hash;
	}
	
	private function login($user)
	{
		$newdata = array(
			'is_logged_in' => TRUE,
			'iqs_username' => $user->username,
			'iqs_firstname' => $user->first_name,
			'iqs_lastname' => $user->last_name);
			//don't forget to also deal with user role
			
		$this->session->set_userdata($newdata);
	}
	
	function logout()
	{
		$newdata = array(
			'is_logged_in' => FALSE,
			'iqs_username' => '',
			'iqs_firstname' => '',
			'iqs_lastname' => '');
			
		$this->session->set_userdata($newdata);
		redirect('main/scanner');
	}
}