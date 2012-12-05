<?php
function pdf()
{
     $this->load->helper(array('dompdf', 'file'));
	 
     // page info here, db calls, etc.     
     $html = $this->load->view('controller/viewfile', $data, true);
     pdf_create($html, 'filename');

	/* or if you want to write it to disk and/or send it as an attachment
	 * $data = pdf_create($html, '', false);
     * write_file('name', $data);  DONT FORGET TO LOAD FILE HELPER	 * 
	 */
}
?>