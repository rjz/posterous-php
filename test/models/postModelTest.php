<?php

require('posterous.php');

class postModelTest extends PHPUnit_Framework_TestCase 
{
	protected function run_protected_method ($method, $args = array())
	{
		$method = new ReflectionMethod('PosterousPostModel', $method);
		$method->setAccessible(true);

		return $method->invokeArgs($this->model, $args);
	}

	protected function build_url($path)
	{
		return 'https://posterous.com/api/2/' . $path;
	}

	public function setUp ()
	{
		$this->model = new PosterousPostModel(array('site_id' => 42));
	}

	public function test_parsed_resource_url ()
	{
		$result = $this->run_protected_method('parsed_resource_url');
		$this->assertEquals($this->build_url('sites/42/posts'), $result);
	}

	public function test_instance_url ()
	{
		$result = $this->run_protected_method('instance_url');
		$this->assertEquals($this->build_url('sites/42/posts'), $result);

		$this->model->set_attributes(array('id' => 23));

		$result = $this->run_protected_method('instance_url');
		$this->assertEquals($this->build_url('sites/42/posts/23'), $result);
	}
}

?>
