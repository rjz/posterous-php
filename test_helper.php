<?php

if (!class_exists('PosterousTestCase')):

require('posterous.php');

class PosterousTestCase extends PHPUnit_Framework_TestCase {

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
		$this->model = new $this->subject;
	}
}

endif;

?>
