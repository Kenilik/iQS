<!-- begin loginbar-->
<div id="login_bar" align='right'>
    	
	    <?php    	
	    	$site = $this->input->cookie('thissiteid') ;
			if($site === FALSE) {
				// cookie doesn't exist
				// admin user needs to login to set up site
				if($this->session->userdata('is_logged_in') === TRUE) {
					echo $this->session->userdata('qid') . " is logged in.";
					echo form_open('login/logout') . form_submit('submit', 'logout');
					
				} else {
					echo form_open('login/validate_credentials');
					echo form_input('qid');
					echo form_password('password');
					echo form_submit('submit', 'login');
					//echo anchor('login/signup', 'Create Account');
					echo form_close();
					echo 'Administrator must log in to configure this iQuickScan site.';				
	
				}
				
			} else {
				// cookie exists now need to check if admin is logged in
								
			}
			echo $site;
	     
		?>
    	
</div><!-- end loginbar-->