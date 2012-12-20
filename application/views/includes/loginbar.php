<div id="login_bar">
	    <?php    	
	    	//cannot use the session helper as this cookie is set in javascript in the set site admin function
	    	
	    	$siteid = $this->input->cookie(iQS_COOKIE_SiteID);
			$sitename = $this->input->cookie(iQS_COOKIE_SiteName);
					
			echo '<table><tr><td align="left">';
			
			if ($siteid===FALSE) {
				if ($this->session->userdata(iQS_COOKIE_UserIsLoggedIn)!==FALSE){
					echo '<font color=red>Admin Mode</font>';
				}
			} else {
				echo 'iQuickScan for <span id="site_name">'.$sitename.'</span> @ : clock';
			}
			echo '</td><td align="right">';
			
			if($this->session->userdata(iQS_COOKIE_UserIsLoggedIn) == TRUE) {
				echo form_open('auth/logout') . $this->session->userdata(iQS_COOKIE_Username) . " is logged in. " . form_submit('submit', 'logout') . form_close();
				echo '</td><td><div id=login_error>' . $this->session->flashdata('error') . '</div></td><td>';
			} else {
				echo '</td><td><div id=login_error>' . $this->session->flashdata('error') . '</div></td><td>';
				echo form_open('auth/validate_login');
				echo form_input('username');
				echo form_password('password');
				echo form_submit('submit', 'login');
				echo form_close();
				//echo 'Administrator must log in to configure this iQuickScan site.';				
			}
			echo '</td></tr></table>';
		?>
</div><!-- end loginbar-->