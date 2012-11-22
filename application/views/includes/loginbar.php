<div id="login_bar">
    	
	    <?php    	
	    	//cannot use the seesion helper as this is set in javascript in the set site admin function
	    	$siteid = $this->input->cookie('current_siteid');
			$sitename = $this->input->cookie('current_sitename');
			
			echo '<table><tr><td align="left">';
			
			if ($siteid==FALSE) {
				echo '<font align=left color=red>Site Administrator must login and configure this location before iQuickScan can be used.</font>';
			} else {
				echo '<font align=left>iQuickScan for ' . $sitename . ' @ : clock ';
			}
			echo '</td><td align="right">';
			//krumo($this->session->userdata('is_logged_in') );
			if($this->session->userdata('is_logged_in') == TRUE) {
				echo form_open('auth/logout') . $this->session->userdata('iqs_username') . " is logged in. " . form_submit('submit', 'logout') . form_close();
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
    	<script>
    		
    		
    	</script>
</div><!-- end loginbar-->