<div id="container">
	<h1>Set iQuickScan Site</h1>
	<div id="body">
		<p>
			<a href=<?php echo site_url(); ?>/site/home>Home</a>
		</p>

		<p>
			Current site is: <?php echo get_cookie(iQS_COOKIE_SiteName)?>
		</p>

		<p>
			Choose the site for which equipment will be signed in and out from this location:
		
		<?php 
			// the controller will return false if no sites set up - which should never happen
			if(! $sites == FALSE){
				echo '<select id="site_select" onclick()>';
				foreach ($sites->result() as $site) {
					echo '<option value=' . $site->site_id . '>'. $site->site_group_name . ' - ' . $site->site_name.'</option>'; 
				}
				echo '</select>';
				echo '<button type="button" onclick="setSite()">Set Site</button>';
			} else {
				echo 'There are no sites set up.';
			}
		?>
		</p>
		
	</div>
	
	<script type="text/javascript">
		function setSite() {
			x=document.getElementById("site_select");
			setCookie('<?php echo iQS_COOKIE_SiteID;?>', x.value, 3650, '/', '', '' );	
			setCookie('<?php echo iQS_COOKIE_SiteName;?>', x.options[x.selectedIndex].text, 3650,'/', '', '' );	
			location.reload();
		}

	</script>

</div>