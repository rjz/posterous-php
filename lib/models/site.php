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
		'contributors',
		'subscribers',
		'pages',
		'posts',
		'tags'
	);

	static function primary ()
	{
		return $this;
	}

	/**
	 *	Overload to set default site to primary site
	 */
	public function __construct ($attributes = null, $parent = null)
	{
		if ($attributes === null)
		{
			$attributes = array('id' => 'primary');
		}
		parent::__construct($attributes, $parent);
	}
}

?>
