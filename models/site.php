<?php
/**
 *	Site Model for Posterous API wrapper
 *
 *	@author	RJ Zaworski <rj@rjzaworski.com>
 *	@link	https://github.com/rjz/posterous-php
 */
class PosterousSiteModel extends PosterousModel 
{
	
	protected $resource = 'sites';

	protected $has_many = array(
		'pages',
		'posts',
		'tags'
	);

	static function primary() 
	{
		return $this;
	}
}

?>
