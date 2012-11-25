<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
class MY_Form_validation extends CI_Form_validation {
 
	protected $CI;
 
	function __construct()
	{
		parent::__construct();
		//$this->CI =& get_instance();
	}
		
	/**
	 * Required if another field has a value (related fields) or if a field has a certain value
	 *
	 * @access  public
	 * @param   string  $str
	 * @param   string  $field
	 * @return  bool
	 * 
	 * Usage:
	 * $this->form_validation->set_rules('bar', 'Bar', 'required_if[foo]'); // required if field 'foo' has a value
	 * $this->form_validation->set_rules('foobar', 'Foo Bar', 'required_if[foo,bar]'); // required if field 'foo' has a value of 'bar'
	 */
	
	function required_if($str, $field)
	{
		list($fld, $val) = explode(',', $field, 2);
	 
		$this->CI->form_validation->set_message('required_if', 'The %s field is required.');
	 	krumo($_POST);
		krumo($fld);
		krumo($val);
		// $fld is filled out
		if (isset($_POST[$fld])) {
			// Must have specific value
			if ($val){
				// Not the specific value we are looking for
				if ($_POST[$fld] == $val AND ! $str){
					return FALSE;
				}
			}
			return TRUE;
		}
	 
		return FALSE;
	}
	
	
	//is_unique_with[site_id,equip_type_id]
	//$str = value of field on which rule is set
	function is_unique_with($str, $fields)
	{
		//$fields	= explode(',', $fields);
		$this->CI->form_validation->set_message('is_unique_with', "STR{$str}  FIELD{$fields}");
		return TRUE;
		
	}
	
}