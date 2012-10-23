<?php
//BarcodeType.class.php

class BarcodeType_class {

	public $id;
	public $barcodetype;
	public $barcodeno;

	//Constructor is called whenever a new object is created.
	//Takes an associative array with the DB row as an argument.
	function __construct($data) {
		$this->id = (isset($data['id'])) ? $data['id'] : "";
		$this->barcodetype = (isset($data['barcodetype'])) ? $data['barcodetype'] : "";
		$this->barcodeno = (isset($data['barcodeno'])) ? $data['barcodeno'] : "";
	}
		
}