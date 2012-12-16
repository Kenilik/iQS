<?php $output = isset($groceryCRUD_output) ? $groceryCRUD_output->output :''; ?>
<div id="container">
	<div id="body">
		<?php 
			echo '<p>Choose the group:'.'<select id="site_group_select">';
				foreach ($site_groups->result() as $site_group) {
					echo '<option value=' . $site_group->id . '>'. $site_group->name .'</option>'; 
				}
				echo '</select></p>';			
		?>
		<p>Sites</p>
		<p><div id="gcrudoutput"><?php echo $output; ?></div></p>
		
	</div>
</div>
<script type="text/javascript">
	$('#site_group_select').change(function(){
		var form_data = {
			site_group_id: $('#site_group_select').val(),
			site_group_name: $('#site_group_select :selected').text(),
			ajax: '1'
		};

		$.ajax({
			url: "<?php echo site_url('sadm/sites') ?>",
			type: 'POST',
			data: form_data,
			success: function(msg){
				$('#gcrudoutput').html(msg);
			}
		});
		return false;
	});	
</script>

<!--end main_content-->