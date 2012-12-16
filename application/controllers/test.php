<?php

include_once APPPATH.'classes\User.php';
 
class Test extends MY_Controller
{		
	function index()
	{
		
	$obj = new MyClass();
	echo $obj->public; // Works
	echo $obj->protected; // Fatal Error
	echo $obj->private; // Fatal Error
	$obj->printHello(); // Shows Public, Protected and Private		
		
		
	}	
}

class MyClass
{
    public $public = 'Public';
    protected $protected = 'Protected';
    private $private = 'Private';

    function printHello()
    {
        echo $this->public;
        echo $this->protected;
        echo $this->private;
    }
}

class MyClass2 extends MyClass
{
    // We can redeclare the public and protected method, but not private
    protected $protected = 'Protected2';

    function printHello()
    {
        echo $this->public;
        echo $this->protected;
        echo $this->private;
    }
}


?>