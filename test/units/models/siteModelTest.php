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
		$this->assertEquals($this->build_url('sites/primary'), $result);

		$this->model->set_attributes(array('id' => 23));

		$result = $this->run_protected_method('instance_url');
		$this->assertEquals($this->build_url('sites/23'), $result);
	}

	public function test_relation_contributors ()
	{
		$this->model->set_attributes(array('id' => 42));
		$contributors = $this->model->contributors;

	    $this->assertEquals('PosterousContributorModel', get_class($contributors));
	}

	public function test_relation_subscribers ()
	{
		$this->model->set_attributes(array('id' => 42));
		$subscribers = $this->model->subscribers;

	    $this->assertEquals('PosterousSubscriberModel', get_class($subscribers));
	}

	public function test_relation_pages ()
	{
		$this->model->set_attributes(array('id' => 42));
		$pages = $this->model->pages;

	    $this->assertEquals('PosterousPageModel', get_class($pages));
	}

	public function test_relation_posts ()
	{
		$this->model->set_attributes(array('id' => 42));
		$posts = $this->model->posts;

	    $this->assertEquals('PosterousPostModel', get_class($posts));
	}

	public function test_relation_tags ()
	{
		$this->model->set_attributes(array('id' => 42));
		$tags = $this->model->tags;

	    $this->assertEquals('PosterousTagModel', get_class($tags));
	}
}

?>
