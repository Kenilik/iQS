<div id="container">
	<h1>Site Administration</h1>
	<div id="body">
		<p>
			<?php echo 
				anchor('main/scanner','Home') . ' | ' . 
				anchor('admin/setsite', 'Set Site') . ' | ' . 
				anchor('admin/equipment','View Equipment CRUD') . ' | ' . 
				anchor('admin/members', 'View Staff Members CRUD')
			?>
		</p>
	</div>
</div>
	