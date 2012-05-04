<?php

require('test_helper.php');

class tagModelTest extends PHPUnit_Framework_TestCase {

	protected function run_protected_method ($method, $args = array())
	{
		$method = new ReflectionMethod(get_class($this->model), $method);
		$method->setAccessible(true);

		return $method->invokeArgs($this->model, $args);
	}

	protected function build_url($path)
	{
		return 'https://posterous.com/api/2/' . $path;
	}

	public function setUp ()
	{
		$this->model = new PosterousTagModel(array('site_id' => 42));
	}

	public function test_parsed_resource_url ()
	{
		$result = $this->run_protected_method('parsed_resource_url');
		$this->assertEquals($this->build_url('sites/42/tags'), $result);
	}
}

?>
