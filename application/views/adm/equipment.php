<?php $output = $groceryCRUD_output->output; ?>
<div id="container">
	<h1>Equipment List - CRUD</h1>
	<div id="body">
		<p>
			<?php echo anchor('adm', 'Site Admin') ?>
		</p>
		<p>
			Maintain Equipment for: <?php echo $this->input->cookie(iQS_COOKIE_SiteName); ?>
		</p>	
		<p>
			<?php echo $output; ?>
		</p>
	</div>
</div>
<!--end main_content-->