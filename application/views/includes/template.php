<?php $this->load->view('includes/header', $header_title); ?>

<?php $this->load->view('includes/loginbar'); ?>

<div id="main_content">
	<?php $this->load->view($main_content); ?>
</div>

<?php $this->load->view('includes/footer'); ?>