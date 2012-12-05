<?php 

include_once APPPATH.'classes\User.php';

class Auth extends MY_Controller
{
	function validate_login()
	{
		$username = $this->input->post('username');
		$password =$this->input->post('password');
		
		$this->db->from('users');
		$this->db->where('username', $username);
		
		$user = $this->db->get()->row('User');
		
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
		$this->the_user = $user;
		$newdata = array(
			'is_logged_in' => TRUE,
			'iqs_username' => $user->username,
			'iqs_firstname' => $user->first_name,
			'iqs_lastname' => $user->last_name);
			
		$this->session->set_userdata($newdata);
	}
	
	function logout()
	{
		$this->the_user = NULL;
		$newdata = array(
			'is_logged_in' => FALSE,
			'iqs_username' => '',
			'iqs_firstname' => '',
			'iqs_lastname' => '');
			
		$this->session->set_userdata($newdata);
		redirect('main/scanner');
	}
}