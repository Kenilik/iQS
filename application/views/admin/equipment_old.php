<div id="container">
	<h1>Equipment List</h1>
	<div id="body">
		<p>
			<a href="admin">Site Admin</a>
		</p>
		<p>
			Maintain Equipment for:
		</p>	

		<p>
			<?php 
				if(is_string($EqItem)){
					echo $q;
				} else {
					echo $this->table->generate($EqItem);
				}
			?>
		</p>
	</div>
</div>