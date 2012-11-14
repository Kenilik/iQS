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
	
	function set_password($user_id, $plaintext)
	{
		$this->hashedpassword = $this->hash_password($plaintext);
		//$this->db->update
	}
	
	function hash_password($password)
	{
		$salt = bin2hex(mcrypt_create_iv(32, MCRYPT_DEV_URANDOM));
		$hash = hash('sha256', $salt . $password);

		return $salt . $hash;
	}
	
	function validate_password($password)
	{
		$salt = substr($this->hashedpassword, 0, 64);
		$hash = substr($this->hashedpassword, 64, 64);		
		
		$password_hash = hash('sha256', $salt . $password);
		
		return $password_hash == $hash;
	}
	
	public static function validate_login($username, $password)
	{
		$user = User::find_by_username($username);
		
		if ($user && $user->validate_password($password)) {
			User::login($user->id);
			return $user;
		} else {			 
			return FALSE;
		}
		
	}
	
	public static function login($username)
	{
		$user = User::find_by_username($username);
		$newdata = array(
			'iqs_username' => $user->username,
			'iqs_firstname' => $user->firstname,
			'iqs_lastname' => $user->firstname);
			//don't foget to also deal with user role
		$this->session->set_userdata($newdata);
	}
}