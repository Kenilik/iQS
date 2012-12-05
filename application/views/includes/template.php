<?php $this->load->view('includes/header', $header_title); ?>

<?php $this->load->view('includes/loginbar'); ?>

<?php $this->load->view('includes/menubar', $theuser); ?>

<div id="main_content">
	<?php $this->load->view($main_content); ?>
</div>

<?php $this->load->view('includes/footer'); ?>