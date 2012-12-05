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
		$is_logged_in = $this->session->userdata('is_logged_in');
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
		
		krumo($this->the_user);
		
        if($this->is_logged_in() && $this->the_user->is_site_admin){            	
			//do nothing
            //$data->the_user = $this->the_user;
            //$this->load->vars($data);
        }
        else {
			$this->session->set_flashdata('error', 'You do not have administrator access.');
			die();
			redirect('main/scanner');
        }
	}  
}

/*
class Super_Admin_Controller extends MY_Controller {

    public function __construct() {

        parent::__construct();

        if($this->ion_auth->in_group('super')) {
            $this->the_user = $this->ion_auth->user()->row();
            $data->the_user = $this->the_user;
            $this->load->vars($data);
        }
        else {
			$this->session->set_flashdata('error', 'You do not have administrator access. Contact your system administrator.');
			redirect('main/scanner');
        }
    }

	private function is_logged_in() 
	{
		$is_logged_in = $this->session->userdata('is_logged_in');		
		return ( ! isset($is_logged_in) || $is_logged_in != TRUE);
	}
 * 
 */