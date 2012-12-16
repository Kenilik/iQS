<?php
	$dont_hide = FALSE;
	$dont_hide_for_site_admin = ! ($this->session->userdata(iQS_COOKIE_UserIsSiteAdmin) || $this->session->userdata(iQS_COOKIE_UserIsSuperAdmin));
	$dont_hide_for_super_admin = ! $this->session->userdata(iQS_COOKIE_UserIsSuperAdmin);
	
	$css_classes = array();
	$css_classes[0][0] = 'h2'; $css_classes[0][1] = 'h2'; $css_classes[0][2] = 'h2'; $css_classes[0][3] = 'h2';	$css_classes[0][4] = 'h2';	$css_classes[0][5] = 'h2'; 
	
	$this->menu->styles = $css_classes;
	$this->menu->first_class = '';
	$this->menu->last_class = '';
	
	$nav = array();
	$nav['main/scanner'] 	= array('label' => 'Home - Scanner', 			'parent_id' => 0, 			'hidden' => $dont_hide);
	$nav['main/equipinuse'] = array('label' => 'Equipment In Use', 			'parent_id' => 0, 			'hidden' => $dont_hide);
	$nav['main/equipaudit'] = array('label' => 'Equipment Audit', 			'parent_id' => 0, 			'hidden' => $dont_hide);
	
	$nav['adm/admin'] 		= array('label' => 'System Administration', 	'parent_id' => 0, 			'hidden' => $dont_hide_for_site_admin);
	$nav['adm/users'] 		= array('label' => 'User Administration', 		'parent_id' => 'adm/admin', 'hidden' => $dont_hide_for_site_admin);
	$nav['adm/equipment'] 	= array('label' => 'Equipment Administration',	'parent_id' => 'adm/admin', 'hidden' => $dont_hide_for_site_admin);
	$nav['adm/equipoos'] 	= array('label' => 'Equipment Out of Service', 	'parent_id' => 'adm/admin', 'hidden' => $dont_hide_for_site_admin);
	$nav['adm/site'] 		= array('label' => 'Site Administration', 		'parent_id' => 'adm/admin', 'hidden' => $dont_hide_for_super_admin);
	$nav['sadm/sites'] 		= array('label' => 'Site Management', 			'parent_id' => 'adm/site', 	'hidden' => $dont_hide_for_super_admin);
	$nav['sadm/setsite'] 	= array('label' => 'Site Setup', 				'parent_id' => 'adm/site', 	'hidden' => $dont_hide_for_super_admin);

	$nav['main/about'] 		= array('label' => 'About iQuickScan',			'parent_id' => 0, 			'hidden' => $dont_hide);
	$nav['test/test'] 		= array('label' => 'Test', 						'parent_id' => 0, 			'hidden' => $dont_hide);
	
	$active = $this->uri->segment(1).'/'.$this->uri->segment(2);
	$menu = $this->menu->render($nav, $active, NULL, 'basic');
	echo "<div id='menu'>".$menu."</div>";
?>