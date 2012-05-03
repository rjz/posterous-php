<?php

require('test_helper.php');

class userModelTest extends PosterousTestCase 
{
	protected
		$subject = 'PosterousUserModel';

	public function test_parsed_resource_url ()
	{
		$result = $this->run_protected_method('parsed_resource_url');
		$this->assertEquals($this->build_url('users'), $result);
	}

	public function test_instance_url ()
	{
		$result = $this->run_protected_method('instance_url');
		$this->assertEquals($this->build_url('users/me'), $result);
	}

	public function test_user_subscriptions ()
	{
		$this->model->set_attributes(array('id' => 42));

		$subscriptions = $this->model->subscriptions->all();
		print_r($subscriptions);
	}
}

?>
