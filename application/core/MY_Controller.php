<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MY_Controller extends CI_Controller 
{
	protected $the_user = NULL;

    public function __construct() 
    {
        parent::__construct();
		$this->is_site_set_up();
	}

	protected function is_logged_in()
	{
		$is_logged_in = $this->session->userdata(iQS_COOKIE_UserIsLoggedIn);
		return (!isset($is_logged_in) || $is_logged_in != FALSE);
	}

	private function is_site_set_up()
	{
		$is_site_set_up = $this->input->cookie('current_siteid');
		if($is_site_set_up==FALSE) {
			$this->load->view('includes/header', 'Administrator Login Required');
			$this->load->view('includes/loginbar');
			$this->load->view('includes/footer');
		}
	}
}

class Admin_Controller extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
		
        if($this->is_logged_in() && $this->session->userdata(iQS_COOKIE_UserIsSiteAdmin)){
        	//do nothing i.e. don't redirect-allow the user to continue to where they were going.
        }
        else {
			$this->session->set_flashdata('error', 'You do not have administrator access.');
			redirect('main/scanner');
        }
	}  
}

class Super_Admin_Controller extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
		
        if($this->is_logged_in() && $this->session->userdata(iQS_COOKIE_UserIsSuperAdmin)){
        	//do nothing i.e. don't redirect-allow the user to continue to where they were going.
        }
        else {
			$this->session->set_flashdata('error', 'You do not have super administrator access - contact helpdesk.');
			redirect('main/scanner');
        }
	}  
}
