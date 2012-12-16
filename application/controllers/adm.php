<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Adm extends Admin_Controller
{	 
	function __construct() 
	{
		parent::__construct();
	}

	function index()
	{
		$data['main_content'] = 'adm/admin' ;
		$data['header_title'] = "Site Administration" ;
		$this->load->view('includes/template', $data);		
	}

	function equipment()
    {
    	$this->isolate_data('equip_items');
		
        $crud = new grocery_CRUD();
		$crud->set_theme('datatables');
		
		$site_id = get_cookie(iQS_COOKIE_SiteID);

		$crud->set_table('equip_items');		
		$crud->set_subject('Equipment');
		
		$crud->columns('equip_type_id', 'name', 'barcode_no');
		$crud->where('equip_items.site_id', $site_id);
		$crud->where('equip_items.equip_status_id !=', iQS_EqStatus_PermOoS);

		$crud->display_as('equip_status_id','Status');
		$crud->display_as('equip_type_id','Type');
		$crud->display_as('name', 'Name');
		$crud->display_as('barcode_no', 'Barcode');						
		
		$crud->order_by('equip_type_id, name', 'ASC');			
		
		$crud->set_relation('equip_status_id', 'equip_status','status');
		// ok now for some awesomeness!! the 4th parameter in this next setting allows only equiptypes that are for this site.
		$crud->set_relation('equip_type_id', 'equip_types', 'name', 'id IN (SELECT equip_type_id AS id FROM site_equip_types WHERE site_id='.$site_id.')');
		
		$crud->fields('equip_status_id', 'site_id', 'equip_type_id', 'name', 'barcode_no');
		
		if ($crud->getState() == 'edit') {
    		$crud->field_type('equip_type_id', 'hidden');
		}
				
		$crud->field_type('site_id', 'hidden', $site_id);
		$crud->field_type('equip_status_id', 'hidden', iQS_EqStatus_InUse);
		
		// data validation
		$crud->required_fields('barcode_no','equip_type_id', 'name');
		$crud->set_rules('name','Name','alpha_dash|min_length['.iQS_EquipItemName_MinLength.']|max_length['.iQS_EquipItemName_MaxLength.']|callback_unique_equip_item_check['.$this->uri->segment(4).']');		
		$crud->set_rules('barcode_no','Barcode','numeric|callback_barcode_len_check|callback_unique_barcode_check['.$this->uri->segment(4).']');		
		
        $output = $crud->render();
		
 		$data['groceryCRUD_output'] = $output ; 
		$data['main_content'] = 'adm/equipment' ;
		$data['header_title'] = "Equipment Admin" ;
		
		$this->load->view('includes/template', $data);				
						
 	}

/*
 * Callback validation function to check the uniqueness of the equipment item being added/edited.
 */
	function unique_equip_item_check($str, $edited_id)
	{
		$var = $this->Equip_Item_model->is_unique_except(
				$edited_id,
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
 * Callback validation function to check the length of the barcode no.
 */

	function barcode_len_check($bc_no)
	{
		if ((strlen($bc_no)==iQS_BC_Length5 || strlen($bc_no) == iQS_BC_Length7)==FALSE){
			$s = 'The %s must be either '.iQS_BC_Length5.' or '.iQS_BC_Length7.' digits in length.';
			$this->form_validation->set_message('barcode_len_check', $s);
			return FALSE;
			}
		return TRUE;			
	}

/* 
 * Callback validation function to check the uniqueness of the barcode_no of the item/member being added/edited.
 */	
	function unique_barcode_check($barcode_no, $edited_id)
	{
		$var = $this->Barcode_model->is_unique_except(
				$edited_id,
				$this->input->post('barcode_no'));
		
		if ($var == FALSE) {
			$s = 'That %s is already in use.';
			$this->form_validation->set_message('unique_barcode_check', $s);
			return FALSE;
			}
		return TRUE;
	}
	
	function users()
    {
    	$this->isolate_data('users');
        
        $crud = new grocery_CRUD();
		$crud->set_theme('datatables');
	
		$site_id = get_cookie(iQS_COOKIE_SiteID);
		
		$crud->set_table('users');
		$crud->set_subject('Users');
		
		$crud->columns('username', 'first_name','last_name', 'barcode_no', 'email', 'phone_no', 'is_active', 'is_site_admin', 'is_super_admin');
		
		$crud->display_as('username','QID');
		$crud->display_as('first_name', 'First Name');
		$crud->display_as('last_name', 'Last Name');	
		$crud->display_as('barcode_no', 'Barcode');
		$crud->display_as('is_active', 'Active?');
		$crud->display_as('site_id', 'Site');
		$crud->display_as('email', 'Work Email');
		$crud->display_as('phone_no', 'Mobile Number');
		$crud->display_as('is_site_admin', 'Site Admin?');
		$crud->display_as('is_super_admin', 'Super Admin?');
		$crud->display_as('password', 'New Password');
		$crud->display_as('passconf', 'Password Confirmation');
				
		$crud->where('users.site_id', $site_id);
		$crud->order_by('barcode_no', 'ASC');
		
		$crud->set_relation('site_id', 'sites', 'name');

		$is_super_admin = $this->session->userdata(iQS_COOKIE_UserIsSuperAdmin);
	
		if ($is_super_admin == TRUE){
			$crud->fields('username', 'first_name','last_name', 'barcode_no', 'email', 'phone_no', 'is_active', 'site_id', 'is_site_admin', 'is_super_admin', 'password', 'passconf');
		} else {
			$crud->fields('username', 'first_name','last_name', 'barcode_no', 'email', 'phone_no', 'is_active', 'site_id', 'is_site_admin', 'password', 'passconf');		
		}
			
		$crud->field_type('site_id', 'hidden', $site_id);
		$crud->field_type('password','password');
		$crud->field_type('passconf','password');
		
		$crud->field_type('is_active','true_false');
		$crud->field_type('is_site_admin','true_false');
		$crud->field_type('is_super_admin','true_false');
		
		// data validation
		$crud->required_fields('username', 'first_name', 'last_name', 'barcode_no', 'is_active', 'email');
		$crud->set_rules('username','QID','alpha_numeric|exact_length['.iQS_Username_ExactLength.']|callback_unique_username_check['.$this->uri->segment(4).']');
		$crud->set_rules('first_name', 'First Name', 'min_length['.iQS_Name_MinLength.']|max_length['.iQS_Name_MaxLength.']');
		$crud->set_rules('last_name', 'Last Name', 'min_length['.iQS_Name_MinLength.']|max_length['.iQS_Name_MaxLength.']');
		$crud->set_rules('barcode_no','Barcode','numeric|callback_barcode_len_check|callback_unique_barcode_check['.$this->uri->segment(4).']');	
		$crud->set_rules('email', 'Email', 'valid_email');
		$crud->set_rules('phone_no', 'Mobile Number','callback_valid_phone_no');
		$crud->set_rules('password', 'Password', 'callback_valid_password');
		$crud->set_rules('passconf', 'Password Confirmation', 'matches[password]');
		
		$crud->callback_insert(array($this, 'encrypt_user_password_then_insert'));
		$crud->callback_update(array($this, 'encrypt_user_password_then_update'));
		
        $output = $crud->render();
 		
 		$data['groceryCRUD_output'] = $output; 
		$data['main_content'] = 'adm/users';
		$data['header_title'] = "User Administration";
		
		$this->load->view('includes/template', $data);				
 	}

/*
 * isolate_data prevents a user directly editing the url to edit or delete a user or equip_item from
 * a site other than the one they are currently administering. 
 *
 */	
	function isolate_data($table) 
	{
        $method = $this->uri->segment(3);
        if ($method == "edit" || $method == 'update_validation' || $method == 'delete') {
			$site_id = get_cookie(iQS_COOKIE_SiteID);
        	$id = $this->uri->segment(4);
			$result = $this->db->get_where($table, array('id' => $id), 1)->row();
			if ($result->site_id != $site_id) {
           		// maybe include the site CSS and tag this error to improve formatting
				echo "You are not logged in to the site for which you are trying edit ". $table . '<br>';
			   	echo "This usually happens if you have manually edited the URL - which you should never do!<br>";
			   	echo "Contact helpdesk if you believe you should not be getting this error.";
				//maybe include link back to main admin page
				exit;
       		}
		return TRUE;		
		}
	}

/*
 * encrypt_user_password_then_update takes the data from the EDIT user form and deals 
 * with encrypting the fake fields required to allow the user to enter their password.
 */ 
	function encrypt_user_password_then_update($post_array, $primary_key)
	{    	
	    if( ! empty($post_array['password'])) {
			$this->User_model->set_password($post_array['username'], $post_array['password']);
	    }
	    unset($post_array['password']);
		unset($post_array['passconf']);
		
	 	return $this->db->update('users',$post_array, array('id' => $primary_key));
	 }

/*
 * encrypt_user_password_then_insert takes the data from the ADD user form and deals 
 * with encrypting the fake fields required to allow the user to enter their password.
 */ 
	function encrypt_user_password_then_insert($post_array)
	{
		$pw = $post_array['password'];
		
		unset($post_array['password']);
		unset($post_array['passconf']);
		
		$res = $this->db->insert('users',$post_array);
		
		if (!empty($pw)) { 
			$this->User_model->set_password($post_array['username'], $pw);
		}
		
		return $res; 
	}

/*
 * Callback validation function to check the validity of the password.
 */
	function valid_password($str)
	{
		// do some password validation
		return TRUE;
	}

/*
 * Callback validation function to check the uniqueness of the equipment item being added/edited.
 */
	function unique_username_check($str, $edited_id)
	{
		$var = $this->User_model->is_unique_except(
				$edited_id,
				$this->input->post('username'));
		echo $var;
		if ($var == FALSE) {
			$s = 'This %s is already taken.';
			$this->form_validation->set_message('unique_username_check', $s);
		}
		return $var;
	}

/*
 * Callback validation function to check the validity of the phone number entered by the user.
 */
	function valid_phone_no($phone_no) 
	{
		if (strlen($phone_no)==0){
			return true;
		} elseif ((strlen($phone_no)<9) || (strlen($phone_no) > 12) || (isNaN(parseInt($phone_no))==FALSE)) {
			$s = 'The %s you have entered does not appear to be valid. It must be between 9 and 12 digits in length.';
			$this->form_validation->set_message('valid_phone_no', $s);
			return FALSE;
		}
		return TRUE;			
	}
}