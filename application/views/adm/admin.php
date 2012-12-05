<div id="container">
	<h1>Site Administration</h1>
	<div id="body">
		<p>
			<?php echo 
				anchor('main/scanner','Home') . ' | ' . 
				anchor('adm/setsite', 'Set Site') . ' | ' . 
				anchor('adm/equipment','View Equipment CRUD') . ' | ' . 
				anchor('adm/members', 'View Staff Members CRUD')
			?>
		</p>
	</div>
</div>
	