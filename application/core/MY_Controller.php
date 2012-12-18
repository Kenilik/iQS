<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MY_Controller extends CI_Controller 
{
    public function __construct() 
    {
        parent::__construct();
		$this->is_site_set_up();
		
		$is_site_set_up = $this->is_site_set_up();	
		$is_logged_in = $this->is_logged_in();

		//$this->session->set_flashdata('error','$is_site_set_up: '.$is_site_set_up. '-- $is_logged_in: '.$is_logged_in);
		
		if ($is_site_set_up==FALSE && $is_logged_in==FALSE){
			redirect('login');
		}
	}

	public function is_logged_in()
	{
		$is_logged_in = $this->session->userdata(iQS_COOKIE_UserIsLoggedIn);
		return (!isset($is_logged_in) || $is_logged_in != FALSE);
	}

	public function is_site_set_up()
	{
		$is_site_set_up = $this->input->cookie('current_siteid');
		/*if($is_site_set_up==FALSE) {
			$this->load->view('includes/header', 'Administrator Login Required');
			$this->load->view('includes/loginbar');
			$this->load->view('includes/footer'); 
			die();
		}
		 * 
		 */
	}
	
	protected function check_user_role($role)
	{
		$current_user_roles = explode($this->session->userdata(iQS_COOKIE_UserRoles));
		if (array_search(iQS_UserRole_SuperAdmin, $current_user_roles)){
			return TRUE;
		} else {
			return array_search($role, $current_user_roles);		
		}
	}
}

class Admin_Controller extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
		
        if($this->is_logged_in() && $this->check_user_role(iQS_COOKIE_UserIsSiteAdmin)){
        	//do nothing i.e. don't redirect-allow the user to continue to where they were going.
        }
        else {
			$this->session->set_flashdata('error', 'You do not have administrator access.');
			redirect('help/about');
        }
	}  
}

class Super_Admin_Controller extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
		
		$current_user_roles = explode($this->session->userdata(iQS_COOKIE_UserRoles));
		
		if (array_search(iQS_UserRole_SuperAdmin, $current_user_roles)){
			//do noti
		} else {
			$x = array_search($role, $current_user_roles);		
		}
		
		
		
        if($this->is_logged_in() && $this->check_user_role(iQS_COOKIE_UserIsSuperAdmin)){
        	//do nothing i.e. don't redirect-allow the user to continue to where they were going.
        }
        else {
			$this->session->set_flashdata('error', 'XXX'.$current_user_roles.'XXX '.' XXX '.array_search(iQS_UserRole_SuperAdmin, $current_user_roles).'XXX You do not have super administrator access - contact helpdesk.');
			redirect('help/about');
        }
	}  
}
