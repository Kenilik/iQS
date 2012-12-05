<div id="container">
	<h1>Welcome to iQuickScan!</h1>

	<div id="body">
		<p>
			<a href="../main/scanner">Home</a>	
			<?php 
				if($this->session->userdata('is_logged_in') === TRUE){
					echo '<a href="../adm">Site Administration</a>' ; 
				}	
			?>
		</p>
		<p>
		<?php 
			if($EquipInUse==FALSE){
				echo "There is no equipment signed out.";
			} else {
				echo $this->table->generate($EquipInUse);
			}
		?>
		</p>