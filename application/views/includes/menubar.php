<div id='menubar'>
<?php

	$show_for_all = FALSE;
	$show_for_site_admin = FALSE;
	$show_for_super_admin = FALSE;
	
	if (!is_null($theuser)){
		$show_for_site_admin = !($theuser->is_site_admin==TRUE || $theuser->is_super_admin==TRUE);
		$show_for_super_admin = !($theuser->is_super_admin==TRUE);		
	}
	
	$nav = array();
	$nav['main'] = array('location'=>'main/scanner', 'label' => 'Scanner', 'parent_id' => 0, 'hidden' => $show_for_all);
	$nav['equipinuse'] = array('location'=>'main/equipinuse', 'label' => 'Equipment In Use', 'parent_id' => 0, 'hidden' => $show_for_all);
	$nav['equipaudit'] = array('location'=>'main/equipaudit', 'label' => 'Equipment Audit', 'parent_id' => 0, 'hidden' => $show_for_all);
	
	$nav['admin'] = array('location'=>'admin', 'label' => 'System Administration', 'parent_id' => 0, 'hidden' => $show_for_site_admin);
		$nav['admin/equip'] = array('location'=>'admin/equipment', 'label'=> 'Equipment Admin', 'parent_id' => 'admin', 'hidden' => $show_for_site_admin);
			$nav['admin/equip_manage'] = array('location'=>'admin/equipmanage', 'label'=> 'Equipment Management', 'parent_id' => 'admin/equip', 'hidden' => $show_for_site_admin);
			$nav['admin/equip_oos'] = array('location'=>'admin/equipoos', 'label'=> 'Equipment Out of Service', 'parent_id' => 'admin/equip', 'hidden' => $show_for_site_admin);
					
		$nav['admin/user'] = array('location'=>'admin/user', 'label'=> 'User Admin', 'parent_id' => 'admin', 'hidden' => $show_for_site_admin);
		$nav['admin/site'] = array('location'=>'admin/site', 'label'=> 'Site Admin', 'parent_id' => 'admin', 'hidden' => $show_for_super_admin);
			$nav['admin/site_manage'] = array('location'=>'admin/sitemanage', 'label'=> 'Site Management', 'parent_id' => 'admin/site', 'hidden' => $show_for_super_admin);
			$nav['admin/site_setup'] = array('location'=>'admin/sitesetup', 'label'=> 'Site Setup', 'parent_id' => 'admin/site', 'hidden' => $show_for_super_admin);

	$nav['about'] = array('location' => 'main/about', 'label' => 'About', 'parent_id' => 0, 'hidden' => $show_for_all);
	$nav['test'] = array('location' => 'test/test', 'label' => 'Test', 'parent_id' => 0, 'hidden' => $show_for_all);
	
	$active = $this->uri->segment(1).$this->uri->segment(2);
	
	$this->menu->delimiter =  '&nbsp;|&nbsp;';
	
	$menu = $this->menu->render_delimited($nav);//, $active, $nav[$active]['parent_id']);	
	
	echo $menu;
?>
</div>