<?php
/**
 *	Post Model for Posterous API wrapper
 *
 *	@author	RJ Zaworski <rj@rjzaworski.com>
 *	@link	https://github.com/rjz/posterous-php
 */
class PosterousPostModel extends PosterousModel 
{
	protected $resource = 'sites/:site_id/posts';

	protected $has_many = array(
		'comments',
		'likes'
	);
}

?>
