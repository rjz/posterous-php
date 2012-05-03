<?php

require('posterous.php');

class fooProxyParent {}

class fooProxy {

	public function __construct ($attrs, $parent) 
	{
		$this->attrs = $attrs;
		$this->parent = $parent;
	}

	public function bar () 
	{
		return 'bar';
	}
}

class proxyTest extends PHPUnit_Framework_TestCase
{

	public function setUp() 
	{
		$this->model = new fooProxyParent();
		$this->proxy_model = new PosterousModelProxy('fooProxy', $this->model);
	}

	public function test_persistence ()
	{
		$instance = $this->proxy_model->get_instance();
		$this->assertEquals($instance, $this->proxy_model->get_instance());
	}

	public function test_call_proxy ()
	{
		$this->assertEquals('bar', $this->proxy_model->bar());
	}

}

?>
