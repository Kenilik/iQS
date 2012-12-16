<?php  $output = $groceryCRUD_output->output; ?>
<div id="container">
	<div id="body">
		<p>
			<h3>Maintain Members for: <?php echo $this->input->cookie(iQS_COOKIE_SiteName); ?></h3>
		</p>	
		<p>
			<?php echo $output; ?>
		</p>
	</div>
</div>
<!--end main_content-->