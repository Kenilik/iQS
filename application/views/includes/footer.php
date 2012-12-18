<p class="footer">Page rendered in <strong>{elapsed_time}</strong> seconds</p>
<?php
	echo '<font size=1><pre>'; print_r($this->session->all_userdata()); 
	echo '[site_id] => '.$this->input->cookie(iQS_COOKIE_SiteID).'<br>';
	echo '[site_name] => '.$this->input->cookie(iQS_COOKIE_SiteName).'<br>';	
	echo '</pre>';
?>
</body>
</html><!--end footer>