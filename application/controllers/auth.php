<?php 

include_once APPPATH.'classes\User.php';

class Auth extends MY_Controller
{
	function validate_login($redirect = 'main/scanner')
	{
		
		$username = $this->input->post('username');
		$password = $this->input->post('password');
		
		$this->db->from('users');
		$this->db->where('username', $username);
		$this->db->where('is_active', TRUE);
		
		$user = $this->db->get()->row();
		
		if ($user && $this->validate_password($user->hashed_password, $password)) {
			$this->login($user);
		} else {
			$this->session->set_flashdata('error', 'Your login attempt failed.');
		}
		
		redirect($redirect);
	}
	
	private function validate_password($hashed_password, $password)
	{
		return true;
		$salt = substr($hashed_password, 0, 64);
		$hash = substr($hashed_password, 64, 64);		
		
		$password_hash = hash('sha256', $salt . $password);
		
		return $password_hash == $hash;
	}
	
	private function login($user)
	{			
		$newdata = array(
			iQS_COOKIE_UserIsLoggedIn => TRUE,
			iQS_COOKIE_Username => $user->username,
			iQS_COOKIE_UserIsSiteAdmin => $user->is_site_admin,
			iQS_COOKIE_UserIsSuperAdmin => $user->is_super_admin);
			
		$this->session->set_userdata($newdata);
	}
	
	function logout()
	{
		$newdata = array(
			iQS_COOKIE_UserIsLoggedIn => '',
			iQS_COOKIE_Username => '',
			iQS_COOKIE_UserIsSiteAdmin => '',
			iQS_COOKIE_UserIsSuperAdmin => '');
		$this->session->unset_userdata($newdata);
		
		redirect('main/scanner');
	}
}