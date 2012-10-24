<?php

class Auth extends CI_Controller {
	
	function index()
	{
		$data['main_content'] = 'home';
		$data['header_title'] = '';
		$this->load->view('includes/template', $data);		
	}
	
	function validate_credentials()
	{		
		$query = $this->member_model->validate();
		
		if($query) // if the user's credentials validated...
		{
			$data = array(
				'qid' => $this->input->post('qid'),
				'is_logged_in' => TRUE
			);
			$this->session->set_userdata($data);
			redirect('site/home');
		}
		else // incorrect username or password
		{
			echo 'Wrong password';
			$this->index();
		}
	}	
	
	function logout()
	{
		$this->session->sess_destroy();
		redirect('site/home');
	}

}