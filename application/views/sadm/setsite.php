<div id="container">
	<h1>Set iQuickScan Site</h1>
	<div id="body">
		<?php 
			echo '<p>Choose the site for which equipment will be signed in and out from this PC:'.form_open('sadm/setsite').'<select id="site_select">';
				foreach ($sites->result() as $site) {
					echo '<option value=' . $site->site_id . '>'. $site->site_group_name . ' - ' . $site->site_name.'</option>'; 
				}
				echo '</select>';
			echo form_close().'</p>';
			
		?>		
	</div>
</div>	
<script type="text/javascript">
	$('#site_select').change(function(){
		var form_data = {
			site_id: $('#site_select').val(),
			site_name: $('#site_select :selected').text(),
			ajax: '1'
		};

		$.ajax({
			url: "<?php echo site_url('sadm/setsite') ?>",
			type: 'POST',
			data: form_data,
			success: function(msg){
				$('#site_name').html(msg);
			}
		});
		return false;
	});	
</script>

