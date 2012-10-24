<div id="login_bar">
    	
	    <?php    	
	    	$siteid = $this->input->cookie('current_siteid') ;
			$sitename = $this->input->cookie('current_sitename') ;
			echo '<table><tr><td align="left">';
			if ($siteid==FALSE) {
				echo '<font align=left color=red>Site Administrator must login and configure this location before iQuickScan can be used.</font>';
			} else {
				echo '<font align=left>iQuickScan for ' . $sitename . ' @ : clock ';
			}
			echo '</td><td align="right">';

			if($this->session->userdata('is_logged_in') === TRUE) {
				echo form_open('auth/logout') . $this->session->userdata('qid') . " is logged in. " . form_submit('submit', 'logout') . form_close();
				
			} else {
				echo form_open('auth/validate_credentials');
				echo form_input('qid');
				echo form_password('password');
				echo form_submit('submit', 'login');
				echo form_close();
				//echo 'Administrator must log in to configure this iQuickScan site.';				
			}
			echo '</td></tr></table>';
		?>
    	
</div><!-- end loginbar-->