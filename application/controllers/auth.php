<?php 

class Auth extends MY_Controller
{
	function validate_login($redirect = 'main')
	{
		echo 'validate_login'; 
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
		return TRUE;
		$salt = substr($hashed_password, 0, 64);
		$hash = substr($hashed_password, 64, 64);		
		
		$password_hash = hash('sha256', $salt . $password);
		
		return $password_hash == $hash;
	}
	
	private function login($user)
	{
		echo 'Login';
		$user_roles = $this->get_user_roles_as_string_array($user->username);
		$newdata = array(
			iQS_COOKIE_UserIsLoggedIn => TRUE,
			iQS_COOKIE_Username => $user->username,
			iQS_COOKIE_UserRoles => $user_roles);
			
		$this->session->set_userdata($newdata);
	}
	
	public function logout()
	{
		$newdata = array(
			iQS_COOKIE_UserIsLoggedIn => '',
			iQS_COOKIE_Username => '',
			iQS_COOKIE_UserRoles => '');
		$this->session->unset_userdata($newdata);
		
		redirect('login');
	}
	
	private function get_user_roles_as_string_array($username)
	{
		$user_roles = $this->User_model->get_user_roles($username);
		if (!$user_roles==FALSE){
			$s='';
			foreach ($user_roles as $user_role){
				$s = $s.$user_role->role_id.',';	
			}
			return substr($s, 0, -1); // remove the last |
		} else {
			return '';
		}
	}
	
}