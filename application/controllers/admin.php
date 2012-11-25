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
		
		$site_id = get_cookie(iQS_COOKIE_SiteID);
		
		$crud->set_subject('Equipment');
		$crud->set_theme('datatables');
		
		$crud->set_table('equip_items');
		
		$crud->columns('equip_type_id', 'name', 'barcode_no');
		
		$crud->set_relation('equip_type_id', 'equip_types', 'name');
		$crud->set_relation('equip_status_id', 'equip_status','status');
		$crud->where('equip_items.site_id', $site_id);
		$crud->where('equip_items.equip_status_id !=', iQS_EqStatus_PermOoS);
		
		$crud->add_fields('equip_status_id', 'site_id', 'equip_type_id', 'name', 'barcode_no');
		$crud->edit_fields('equip_status_id', 'site_id', 'name', 'barcode_no');
		
		$crud->field_type('site_id', 'hidden', $site_id);
		$crud->field_type('equip_status_id', 'hidden', iQS_EqStatus_InUse);
		
		// data validation
		$crud->required_fields('equip_type_id', 'name');//, 'barcode_no');
		//$crud->set_rules('barcode_no','Barcode','is_unique[v_all_barcodes.barcode_no]');
		$crud->set_rules('name', 'Name', 'is_unique_with[site_id]');
		$crud->set_rules('barcode_no', 'Barcode','required_if[name,1000]');
		
		$crud->display_as('equip_status_id','Status');
		$crud->display_as('equip_type_id','Type');
		$crud->display_as('name', 'Name');
		$crud->display_as('barcode_no', 'Barcode');						
		
		$crud->order_by('equip_type_id, name', 'ASC');			
		
		//$crud->callback_before_insert($this, 'add_equip_item_callback');
			
		//krumo($crud);
		
        $output = $crud->render();
		
 		$data['groceryCRUD_output'] = $output ; 
		$data['main_content'] = 'admin/equipment' ;
		$data['header_title'] = "Equipment Admin" ;
		
		$this->load->view('includes/template', $data);				
						
 	}
	
	function add_equip_item_callback($post_array)
	{
	
		return $post_array;
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