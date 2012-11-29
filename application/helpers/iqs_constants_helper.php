<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
*--------------------------------------------------------------------------
*	Cookie names used in iQS 
*--------------------------------------------------------------------------
*
*/

define('iQS_COOKIE_SiteID','current_siteid');
define('iQS_COOKIE_SiteName','current_sitename');


/*
*--------------------------------------------------------------------------
*	Constants used in iQS 
*--------------------------------------------------------------------------
*/

define('iQS_EqStatus_InUse','0');
define('iQS_EqStatus_TempOoS','1');
define('iQS_EqStatus_PermOoS','2');

define('iQS_MemStatus_Active','0');
define('iQS_MemStatus_Inactive','1');

define('iQS_ScannerStatus_Default','Default');
define('iQS_ScannerStatus_EquipmentScan','EquipmentScan');
define('iQS_MySQLDateFormat','Y/m/d H:i:s');

define('iQS_EquipScanCDSecs','30');
define('iQS_DisplayFeedbackSecs','5');

define('iQS_BC_Length5',5);
define('iQS_BC_Length7',7);

define('iQS_EquipItemName_MinLength',2);
define('iQS_EquipItemName_MaxLength',25);

/* End of file iqs_constants.php */
/* Location: ./application/libraries/iqs_constants.php */