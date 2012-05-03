<?php

require('test_helper.php');

class siteModelTest extends PosterousTestCase {

	protected
		$subject = 'PosterousSiteModel';

	public function test_parsed_resource_url ()
	{
		$result = $this->run_protected_method('parsed_resource_url');
		$this->assertEquals($this->build_url('sites'), $result);
	}

	public function test_instance_url ()
	{
		$result = $this->run_protected_method('instance_url');
		$this->assertEquals($this->build_url('sites'), $result);

		$this->model->set_attributes(array('id' => 23));

		$result = $this->run_protected_method('instance_url');
		$this->assertEquals($this->build_url('sites/23'), $result);
	}

	public function test_relation_contributors ()
	{
	}

	public function test_relation_subscribers ()
	{
	}

	public function test_relation_pages ()
	{
	}

	public function test_relation_posts ()
	{
	}

	public function test_relation_tags ()
	{
	}

}

?>
