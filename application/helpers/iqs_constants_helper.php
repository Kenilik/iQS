<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
*--------------------------------------------------------------------------
*	Cookie names used in iQS 
*--------------------------------------------------------------------------
*
*/

define('iQS_COOKIE_SiteID','current_siteid');
define('iQS_COOKIE_SiteName','current_sitename');
define('iQS_COOKIE_UserIsLoggedIn','user_is_logged_in');
define('iQS_COOKIE_Username','username');
define('iQS_COOKIE_UserIsSiteAdmin','user_is_site_admin');
define('iQS_COOKIE_UserIsSuperAdmin','user_is_super_admin');
define('iQS_COOKIE_UserRoles','user_roles');

/*
*--------------------------------------------------------------------------
*	Constants used in iQS 
*--------------------------------------------------------------------------
*/

define('iQS_EqStatus_InUse','0');
define('iQS_EqStatus_TempOoS','1');
define('iQS_EqStatus_PermOoS','2');

define('iQS_UserStatus_Active','0');
define('iQS_UserStatus_Inactive','1');

define('iQS_ScannerStatus_Default','Default');
define('iQS_ScannerStatus_EquipmentScan','EquipmentScan');
define('iQS_MySQLDateFormat','Y/m/d H:i:s');

define('iQS_EquipScanCDSecs','15');
define('iQS_DisplayFeedbackSecs','5');

define('iQS_BC_Length5',5);
define('iQS_BC_Length7',7);

define('iQS_EquipItemName_MinLength',2);
define('iQS_EquipItemName_MaxLength',25);

define('iQS_Username_MinLength',6);
define('iQS_Username_MaxLength',6);
define('iQS_Username_ExactLength',6);

define('iQS_Name_MinLength',2);
define('iQS_Name_MaxLength',45);

/*
*--------------------------------------------------------------------------
*	Roles used in iQS 
*--------------------------------------------------------------------------
*/
define('iQS_UserRole_SuperAdmin',		10);
define('iQS_UserRole_SiteAdmin',		11);
define('iQS_UserRole_FirearmsUser',		12);
define('iQS_UserRole_FirearmsAdmin',	13);
define('iQS_UserRole_DragerUser',		14);
define('iQS_UserRole_DragerAdmin',		15);

/* End of file iqs_constants.php */
/* Location: ./application/libraries/iqs_constants.php */