<div id="container">
	<div id="body">
		<p>		
		<?php 
			if($EquipInUse==FALSE){
				echo "There is no equipment signed out.";
			} else {
				echo $this->table->generate($EquipInUse);
			}
		?>
		</p>