<div id="container">
	<div id='body'>
	<p>This is the about page for iQuickScan</p> 
	<?php	
		if ( ! $SiteAdmins==FALSE) {
			echo '<p>The administrator(s) for this location are:</p>';
			echo $this->table->generate($SiteAdmins);
		} else {
			echo "There are no administrators set up for this location.";
		}
	?>