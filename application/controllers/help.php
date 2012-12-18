<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Help extends CI_Controller { 

	function index()
	{
		$this->about();
	}

	function about()
	{
		$data['SiteAdmins'] = $this->User_model->getSiteAdmins(get_cookie(iQS_COOKIE_SiteID));

		$data['main_content'] = 'helpabout';
		$data['header_title'] = "About iQuickScan";
		$this->load->view('includes/template', $data);				
	}
}