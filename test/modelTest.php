<?php

require('test_helper.php');

class PosterousTestModel extends PosterousModel 
{

	protected $resource = 'tests';

	protected $has_many = array(
		'relatives'
	);

	public function request($method, $url, $object = null) 
	{
		return array(
			'method' => $method,
			'url' => $url,
			'object' => $object
		);
	}
}

class PosterousRelativeModel extends PosterousModel 
{

	protected $resource = 'tests/:test_id/relatives';
	
	public function request($method, $url, $object = null) 
	{
		return array(
			'method' => $method,
			'url' => $url,
			'object' => $object
		);
	}
}

class modelTest extends PosterousTestCase 
{

	protected
		$subject = 'PosterousTestModel';

	public function test_convert_attribute_key ()
	{
		$result = $this->run_protected_method('convert_attribute_key', array(':key'));
		$this->assertEquals('key', $result);
	}

	public function test_model_class_name ()
	{
		$result = $this->run_protected_method('model_class_name', array('test'));
		$this->assertEquals('PosterousTestModel', $result);
	}

	public function test_model_key () 
	{
		$result = $this->run_protected_method('model_key');
		$this->assertEquals('test', $result);
	}

	public function test_parsed_resource_url ()
	{
		$result = $this->run_protected_method('parsed_resource_url');
		$this->assertEquals($this->build_url('tests'), $result);
	}

	public function test_instance_url ()
	{
		$result = $this->run_protected_method('instance_url');
		$this->assertEquals($this->build_url('tests'), $result);

		$this->model->set_attributes(array('id' => 42));

		$result = $this->run_protected_method('instance_url');
		$this->assertEquals($this->build_url('tests/42'), $result);
	}

	public function test_is_new () 
	{
		$this->assertTrue($this->model->is_new());

		$this->model->set_attributes(array('id' => 42));

		$this->assertFalse($this->model->is_new());
	}

	public function test_all () 
	{
		$result = $this->model->all();

		$this->assertEquals('GET', $result['method']);
		$this->assertEquals($this->build_url('tests'), $result['url']);
	}

	public function test_find () 
	{
		$result = $this->model->find(42);

		$this->assertEquals('GET', $result['method']);
		$this->assertEquals($this->build_url('tests/42'), $result['url']);
	}

	public function test_create () 
	{
		$attributes = array(
			'foo' => 'bar'
		);

		$result = $this->model->create($attributes);

		$this->assertEquals('POST', $result['method']);
		$this->assertEquals($this->build_url('tests'), $result['url']);
		$this->assertEquals($attributes, $result['object']['test']);
	}

	public function test_save () 
	{
		$this->model->set_attributes(array('id' => 42));

		$attributes = array(
			'foo' => 'bar'
		);

		$result = $this->model->save($attributes);

		$this->assertEquals('PUT', $result['method']);
		$this->assertEquals($this->build_url('tests/42'), $result['url']);
		$this->assertEquals($attributes, $result['object']['test']);
	}

	public function test_delete () 
	{
		$result = $this->model->delete(42);

		$this->assertEquals('DELETE', $result['method']);
		$this->assertEquals($this->build_url('tests/42'), $result['url']);
	}

	public function test_get_and_set_attribute () 
	{
		$attributes = array(
			'foo' => 'bar'
		);

		$this->model->set_attributes($attributes);

		$result = $this->model->get_attribute('foo');
		$this->assertEquals('bar', $result);
	}

	public function test_get_and_set_instance_attribute () 
	{
		$attributes = array(
			'foo' => 'bar'
		);

		$this->model->set_instance_attributes($attributes);

		$result = $this->model->get_instance_attribute('foo');
		$this->assertEquals('bar', $result);
	}

	public function test_fetch_associated_resource ()
	{
		$this->model->set_attributes(array('id' => 42));

		$result = $this->model->relatives->all();
		$this->assertEquals('GET', $result['method']);
		$this->assertEquals($this->build_url('tests/42/relatives'), $result['url']);
	}
}

?>
