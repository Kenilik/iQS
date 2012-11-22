<?php

class Admin extends CI_Controller {
	
	function __construct() {
		parent::__construct();
		//$this->__is_logged_in();
	}
	
	function __is_logged_in() {
		$is_logged_in = $this->session->userdata('is_logged_in');
		
		if( ! isset($is_logged_in) || $is_logged_in != TRUE)
		{
			echo 'You don\'t have permission to access this page. <a href='.base_url().'index.php/main/scanner>Login</a>';	
			die();
		}		
	}

	function index(){
		$data['main_content'] = 'admin/admin' ;
		$data['header_title'] = "Site Admin" ;
		$this->load->view('includes/template', $data);		
	}
	
	function equipment()
    {
        $crud = new grocery_CRUD();
		
		$crud->set_subject('Equipment');
		$crud->set_theme('datatables');
		
		$crud->set_table('equipment');
		
		$crud->set_relation('EquipTypeID', 'EquipType', 'EquipTypeDescr');
		$crud->set_relation('EquipStatusID', 'EquipStatus','EquipStatusDescr');
		$crud->set_relation('SiteID', 'site', 'sitename');

		$crud->where('equipment.siteid', get_cookie(iQS_COOKIE_SiteID));
		$crud->where('Equipment.EquipStatusID', iQS_EqStatus_InUse);
		$crud->or_where('Equipment.EquipStatusID',iQS_EqStatus_TempOoS);

		$crud->display_as('EquipStatusID','Status');
		$crud->display_as('EquipTypeID','Type');
		$crud->display_as('SiteID','Site');
		$crud->display_as('EquipNo', 'Equipment Number');
		$crud->display_as('BarcodeNo', 'Barcode');						
		
		$crud->order_by('EquipTypeID, EquipNo', 'ASC');			
		
        $output = $crud->render();
		
 		$data['groceryCRUD_output'] = $output ; 
		$data['main_content'] = 'admin/equipment' ;
		$data['header_title'] = "Equipment Admin" ;
		
		$this->load->view('includes/template', $data);				
						
 	}
	
	function members()
    {
        $crud = new grocery_CRUD();
		
		$crud->set_subject('Staff Member');

		$crud->set_table('member');
		
		$crud->set_relation('MemStatusID', 'MemStatus','MemStatusDescr');
		$crud->set_relation('SiteID', 'site', 'sitename');

		$crud->where('member.SiteID', get_cookie(iQS_COOKIE_SiteID));
		$crud->where('member.MemStatusID', iQS_EqStatus_InUse);

		$crud->display_as('FirstName', 'First Name');						
		$crud->display_as('LastName', 'Last Name');						
		$crud->display_as('BarcodeNo', 'Barcode');						
		$crud->display_as('MemStatusID', 'Status');						
		$crud->display_as('SiteID', 'Site');						
		$crud->display_as('isAdmin', 'Administrator?');						

		$crud->order_by('LastName', 'ASC');
	
		//$crud->columns('','');
		
        $output = $crud->render();
 
 		$data['groceryCRUD_output'] = $output ; 
		$data['main_content'] = 'admin/members' ;
		$data['header_title'] = "Member Admin" ;
		
		//krumo($data);
		
		$this->load->view('includes/template', $data);				
 	}

	
	function setsite(){
		$data['sites'] = $this->Site_Group_model->get();
		
		$data['main_content'] = 'admin/setsite';
		$data['header_title'] = "Set Site";
		$this->load->view('includes/template', $data);		
	}
	
}