<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

include APPPATH . 'classes/Barcode.php';

class User extends Barcode {
	var $EquipInUse = FALSE;

	function getEquipInUse($user_id)
	{
		$ci =& get_instance();
		$this->EquipInUse = $ci->Equip_Register_model->getEquipInUseByUserTest($user_id, TRUE);
	}
	
	

}
