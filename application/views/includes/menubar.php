<?php	
	$current_user_role = explode(',',$this->session->userdata(iQS_COOKIE_UserRoles));
		
	$is_super_admin = (array_search(iQS_UserRole_SuperAdmin, $current_user_role)!==FALSE); 
	$is_site_admin = (array_search(iQS_UserRole_SiteAdmin, $current_user_role)!==FALSE); 

	$site_is_set = $this->input->cookie(iQS_COOKIE_SiteID)!==FALSE;
	
	$css_classes = array();
	$css_classes[0][0] = 'h2'; $css_classes[0][1] = 'h2'; $css_classes[0][2] = 'h2'; $css_classes[0][3] = 'h2';	$css_classes[0][4] = 'h2';	$css_classes[0][5] = 'h2'; 
	$this->menu->styles = $css_classes;	
	
	
	$nav = array();
	
	$nav['main/scanner'] 	= array('label' => 'Scanner', 					'parent_id' => 0, 			'hidden' => !$site_is_set);
	$nav['main/equipinuse'] = array('label' => 'Equipment In Use', 			'parent_id' => 0, 			'hidden' => !$site_is_set);
	$nav['main/equipaudit'] = array('label' => 'Equipment Audit', 			'parent_id' => 0, 			'hidden' => !$site_is_set);
	
	$nav['adm/admin'] 		= array('label' => 'System Administration', 	'parent_id' => 0, 			'hidden' => ($is_super_admin) ? FALSE : (($is_site_admin) ? FALSE : TRUE));
	$nav['adm/users'] 		= array('label' => 'User Administration', 		'parent_id' => 'adm/admin', 'hidden' => ($is_super_admin) ? FALSE : (($is_site_admin) ? FALSE : TRUE));
	$nav['adm/equipment'] 	= array('label' => 'Equipment Administration',	'parent_id' => 'adm/admin', 'hidden' => ($is_super_admin) ? FALSE : (($is_site_admin) ? FALSE : TRUE));
	$nav['adm/equipoos'] 	= array('label' => 'Equipment Out of Service', 	'parent_id' => 'adm/admin', 'hidden' => ($is_super_admin) ? FALSE : (($is_site_admin) ? FALSE : TRUE));
	
	$nav['adm/site'] 		= array('label' => 'Site Administration', 		'parent_id' => 'adm/admin', 'hidden' => !$is_super_admin);
	$nav['sadm/sites'] 		= array('label' => 'Site Management', 			'parent_id' => 'adm/site', 	'hidden' => !$is_super_admin);
	$nav['sadm/setsite'] 	= array('label' => 'Site Setup', 				'parent_id' => 'adm/site', 	'hidden' => !$is_super_admin);

	$nav['help/about'] 		= array('label' => 'About iQuickScan',			'parent_id' => 0, 			'hidden' => FALSE);
	$nav['test/test'] 		= array('label' => 'Test', 						'parent_id' => 0, 			'hidden' => FALSE);
	
	$active = $this->uri->segment(1).'/'.$this->uri->segment(2);

	$menu = $this->menu->render($nav, $active, NULL, 'basic');

	$breadcrumb = $this->menu->render($nav, $active, 0, 'breadcrumb');

	echo "<div id='menu'>".$menu."</div>";
	echo "<div id='bc'>".$breadcrumb."</div>";
?>