<?php

class User_model extends CI_Model {

	function validate()
	{
		$this->db->where('username', $this->input->post('username'));
		$this->db->where('password', $this->input->post('password'));
		$query = $this->db->get('users');
		
		if($query->num_rows == 1){
			return TRUE;
		}
	}
	
	function get($user_id = FALSE)
	{
		if( ! $user_id == FALSE) {
			$q = $this->db->get_where('v_users', array('id' => $user_id));
		} else {
			$q = $this->db->get('v_users');
		}
		
		if( ! $q->num_rows() > 0) {
			$q = FALSE; //return false if there is no User by this UserID
		}
		return $q;
	}
	
	function set_password($username, $plaintext)
	{
		//$this->hashedpassword = $this->hash_password($plaintext);
		$this->db->where('id', $username);
		$this->db->update('users', array('hashed_password' => $this->hash_password($plaintext)));
	}
	
	private function hash_password($password)
	{
		$salt = bin2hex(mcrypt_create_iv(32, MCRYPT_DEV_URANDOM));
		$hash = hash('sha256', $salt . $password);

		return $salt . $hash;
	}
	
	private function validate_password($hashed_password, $password)
	{
		$salt = substr($hashed_password, 0, 64);
		$hash = substr($hashed_password, 64, 64);		
		
		$password_hash = hash('sha256', $salt . $password);
		
		return $password_hash == $hash;
	}
	
	public function validate_login($username, $password)
	{
		$this->db->select('username, first_name, last_name, hashed_password');
		$user = $this->db->get_where('users', array('username' => $username))->row();
		
		if ($user && $this->validate_password($user->hashed_password,$password)) {
			$this->login($user);
			return $username;
		} else {			 
			return FALSE;
		}
	}
	
	private function login($user)
	{
		$newdata = array(
			'is_logged_in' => 1,
			'iqs_username' => $user->username,
			'iqs_firstname' => $user->first_name,
			'iqs_lastname' => $user->last_name);
			//don't forget to also deal with user role
			
		$this->session->set_userdata($newdata);
	}
	private function logout()
	{
		$newdata = array(
			'is_logged_in' => 0,
			'iqs_username' => '',
			'iqs_firstname' => '',
			'iqs_lastname' => '');
			
		$this->session->set_userdata($newdata);
	}
}