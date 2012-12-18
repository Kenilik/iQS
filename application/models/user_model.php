<?php

class User_model extends CI_Model 
{	
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

	function getSiteAdmins($site_id)
	{
		$q = $this->db->get_where('v_site_admins', array('site_id' => $site_id));
		if( ! $q->num_rows() > 0) {
			$q = FALSE;
		}
		return $q;
	}
	
	function set_password($username, $plaintext)
	{
		$this->db->where('username', $username);
		$this->db->update('users', array('hashed_password' => $this->hash_password($plaintext)));
	}
	
	private function hash_password($password)
	{
		$salt = bin2hex(mcrypt_create_iv(32, MCRYPT_DEV_URANDOM));
		$hash = hash('sha256', $salt . $password);
		
		return $salt . $hash;
	}
	
	public function get_user_roles($username)
	{
		$this->db->select('role_id');
		$this->db->from('user_roles');
		$this->db->join('users', 'user_roles.user_id = users.id');
		$this->db->where('users.username', $username);
		$query = $this->db->get();

		if($query->num_rows == 0){
			return FALSE;
		} else {
			return $query->result();
		}
	}
	
	function is_unique_except($id = 0, $username)
	{
		$this->db->select('id');
		$this->db->from('users');
		$this->db->where('id !=', $id);
		$this->db->where('username', $username);
		
		//can only ever return 1 row due to db constraints. 
		$query = $this->db->get();
		
		return ($query->num_rows() == 0) ? TRUE : FALSE ;		
	}

}