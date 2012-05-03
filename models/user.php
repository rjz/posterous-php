<?php
/**
 *	User Model for Posterous API wrapper
 *
 *	@author	RJ Zaworski <rj@rjzaworski.com>
 *	@link	https://github.com/rjz/posterous-php
 */
class PosterousUserModel extends PosterousModel {

    protected $resource = 'users';

	protected $has_many = array(
		'subscriptions'
	);
}

?>
