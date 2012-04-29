<?php
/**
 *	Page Model for Posterous API wrapper
 *
 *	@author	RJ Zaworski <rj@rjzaworski.com>
 *	@link	https://github.com/rjz/posterous-php
 */
class PosterousPageModel extends PosterousModel 
{
	protected $resource = 'sites/:site_id/pages';
}

?>
