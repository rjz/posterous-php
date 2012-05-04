<?php

if (!defined('POSTEROUS_API_TOKEN'))
	define('POSTEROUS_API_TOKEN', 'test_token');

if (!defined('POSTEROUS_API_AUTHSTRING'))
	define('POSTEROUS_API_AUTHSTRING', 'test@example.com:password');

require_once('../posterous.php');

if (!class_exists('PosterousTestCase')):

class PosterousTestCase extends PHPUnit_Framework_TestCase {

	protected
		$subject = 'PosterousTestCase';
    

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

	public function test_foo()
	{
		// ...
	}
}

endif;

?>
