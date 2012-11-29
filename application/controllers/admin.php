<?php

class Admin extends CI_Controller {
	
	function __construct() 
	{
		parent::__construct();
		//$this->__is_logged_in();
	}
	
	function __is_logged_in() 
	{
		$is_logged_in = $this->session->userdata('is_logged_in');
		
		if( ! isset($is_logged_in) || $is_logged_in != TRUE)
		{
			echo 'You don\'t have permission to access this page. <a href='.base_url().'index.php/main/scanner>Login</a>';	
			die();
		}		
	}

	function index()
	{
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
		$crud->where('equip_items.site_id', $site_id);
		$crud->where('equip_items.equip_status_id !=', iQS_EqStatus_PermOoS);
				
		$crud->set_relation('equip_status_id', 'equip_status','status');
		// ok now for some awesomeness!! the 4th parameter in this next setting allows only equiptypes that are for this site.
		$crud->set_relation('equip_type_id', 'equip_types', 'name', 'id IN (SELECT equip_type_id AS id FROM site_equip_types WHERE site_id='.$site_id.')');
		
		$crud->add_fields('equip_status_id', 'site_id', 'equip_type_id', 'name', 'barcode_no');
		$crud->edit_fields('equip_status_id', 'site_id', 'equip_type_id', 'name', 'barcode_no');
		//$crud->callback_edit_field('equip_type_id', array($this,'edit_equip_type_field_callback'));
		
		$crud->field_type('site_id', 'hidden', $site_id);
		$crud->field_type('equip_status_id', 'hidden', iQS_EqStatus_InUse);
		
		if ($this->uri->segment(4)!= FALSE){$crud->field_type('equip_type_id', 'hidden');}
		
		// data validation
		$crud->required_fields('barcode_no','equip_type_id', 'name');
		$crud->set_rules('name','Name','alpha_dash|min_length['.iQS_EquipItemName_MinLength.']|max_length['.iQS_EquipItemName_MaxLength.']|callback_unique_equip_item_check['.$this->uri->segment(4).']');		
		$crud->set_rules('barcode_no','Barcode','numeric|callback_barcode_no_check|callback_unique_barcode_no_check['.$this->uri->segment(4).']');		
		
		$crud->display_as('equip_status_id','Status');
		$crud->display_as('equip_type_id','Type');
		$crud->display_as('name', 'Name');
		$crud->display_as('barcode_no', 'Barcode');						
		
		$crud->order_by('equip_type_id, name', 'ASC');			
			
		//krumo($crud);
		
        $output = $crud->render();
		
 		$data['groceryCRUD_output'] = $output ; 
		$data['main_content'] = 'admin/equipment' ;
		$data['header_title'] = "Equipment Admin" ;
		
		$this->load->view('includes/template', $data);				
						
 	}

	function edit_equip_type_field_callback($value = '', $primary_key = null){
		return '<input type="hidden" value="'.$value.'" name="equip_type_id"';
	}

/*
 * Callback validation function to check the uniqueness of the item being added/edited.
 */
	function unique_equip_item_check($str, $edited_equip_item_id)
	{
		$var = $this->Equip_Item_model->is_unique_except(
				$edited_equip_item_id,
				$this->input->post('site_id'),
				$this->input->post('equip_type_id'),
				$this->input->post('name'));
		
		if ($var == FALSE) {
			$s = 'You already have an equipment item of this type with this name.';
			$this->form_validation->set_message('unique_equip_item_check', $s);
			return FALSE;
			}
		return TRUE;			
	}

/* 
 * Callback validation function to check the uniqueness of the barcode_no being added/edited.
 */	
	function unique_barcode_no_check($barcode_no, $edited_id)
	{
		$var = $this->Barcode_model->is_unique_except(
				$edited_id,
				$this->input->post('barcode_no'));
		
		if ($var == FALSE) {
			$s = 'That %s is already in use.';
			$this->form_validation->set_message('unique_barcode_no_check', $s);
			return FALSE;
			}
		return TRUE;			
	}
	
	function barcode_no_check($bc_no)
	{
		if ((strlen($bc_no)==iQS_BC_Length5 || strlen($bc_no) == iQS_BC_Length7)==FALSE){
			$s = 'The %s must be either '.iQS_BC_Length5.' or '.iQS_BC_Length7.' digits in length.';
			$this->form_validation->set_message('barcode_no_check', $s);
			return FALSE;
			}
		return TRUE;			
	}
	
	function members()
    {
        $crud = new grocery_CRUD();
		
		$crud->set_subject('Staff Member');

		$crud->set_table('users');
		
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
		
        $output = $crud->render();
 
 		$data['groceryCRUD_output'] = $output ; 
		$data['main_content'] = 'admin/members' ;
		$data['header_title'] = "Member Admin" ;
		
		$this->load->view('includes/template', $data);				
 	}

	
	function setsite(){
		$data['sites'] = $this->Site_Group_model->get();
		
		$data['main_content'] = 'admin/setsite';
		$data['header_title'] = "Set Site";
		$this->load->view('includes/template', $data);		
	}
}