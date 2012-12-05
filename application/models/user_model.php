<?php

class User_model extends CI_Model {

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
	
	public function get_admin_roles($user_id)
	{
		$this->db->select('role_id');
		$this->db->from('user_admin_roles');
		$this->db->where('user_id', $user_id);
		$query = $this->db->get();

		if($query->num_rows == 0){
			return FALSE;
		} else {
			return $query->result();
		}
	}
	
/*
	function validate()
	{
		$this->db->where('username', $this->input->post('username'));
		$this->db->where('password', $this->input->post('password'));
		$query = $this->db->get('users');
		
		if($query->num_rows == 1){
			return TRUE;
		}
	}
 * 
 */
}