<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Sadm extends Super_Admin_Controller
{		
	function __construct() 
	{
		parent::__construct();
	}
	
	function setsite()
	{
		//cannot use the session helper as this cookie should not expire like the session helper cookies do.	
		if ($this->input->post('ajax')) {
			$newdata = array(
				'name' => iQS_COOKIE_SiteID,
				'value'=> $this->input->post('site_id'),
				'expire' => 0,
				'path' => '/'
			);
			$this->input->set_cookie($newdata);

			$newdata = array(
				'name' => iQS_COOKIE_SiteName,
				'value'=> $this->input->post('site_name'),
				'expire' => 0,
				'path' => '/'
			);
			
			$this->input->set_cookie($newdata);
			
			echo $this->input->post('site_name');
			
		} else {
			$data['main_content'] = 'sadm/setsite';
			$data['header_title'] = "Set Site";
			$data['sites'] = $this->Site_Group_model->getSites();
			$this->load->view('includes/template', $data);				
		}
	}
	function sites()
	{
		if ($this->input->post('ajax')) {
			
	        $crud = new grocery_CRUD();
			$crud->set_theme('datatables');
			
			$site_group_id = $this->input->post('site_group_id');
	
			$crud->set_table('sites');		
			$crud->set_subject('Sites');
			
			$crud->columns('id', 'name', 'site_group_id');
			$crud->where('sites.site_group_id', $site_group_id);
	
			$crud->display_as('name', 'Name');
			
			$crud->order_by('name');			
			
			$crud->set_relation('site_group_id', 'site_groups','name');
			
			$crud->fields('id', 'name', 'site_group_id');
			
			$crud->field_type('id', 'hidden');
	    	$crud->field_type('site_group_id', 'hidden', $site_group_id);
			
			// data validation
			$crud->required_fields('name');
			$crud->set_rules('name','Name','alpha_dash|min_length[2]|max_length[45]');		
			
	        $output = $crud->render();
			echo $output->output;
			
		} else {
			$data['main_content'] = 'sadm/sites';
			$data['header_title'] = 'Site Administration';
			$data['site_groups'] = $this->Site_Group_model->getSiteGroups();
			$this->load->view('includes/template', $data);	
		}
		
	}
	
}