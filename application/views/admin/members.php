<?php 

$output = $groceryCRUD_output->output;
$css_files = $groceryCRUD_output->css_files;
$js_files = $groceryCRUD_output->js_files;

?>

<?php foreach($css_files as $file): ?>
	<link type="text/css" rel="stylesheet" href="<?php echo $file; ?>" />
<?php endforeach; ?>

<?php foreach($js_files as $file): ?>
 
    <script src="<?php echo $file; ?>"></script>
<?php endforeach; ?>
 
<style type='text/css'>
a:hover
{
    text-decoration: underline;
}
</style>

<script type="text/javascript">
$(document).ready(function() {
  $('#quickSearchButton').trigger('click');
});
</script>

<div id="container">
	<h1>Staff Member List - CRUD</h1>
	<div id="body">
		<p>
			<a href="admin">Site Admin</a>
		</p>
		<p>
			Maintain Members for:
		</p>	

		<p>
			<?php echo $output; ?>
		</p>
	</div>
</div>