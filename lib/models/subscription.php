<?php
/**
 *	Subscription Model for Posterous API wrapper
 *
 *	@author	RJ Zaworski <rj@rjzaworski.com>
 *	@link	https://github.com/rjz/posterous-php
 */
class PosterousSubscriptionModel extends PosterousModel {

    protected $resource = 'users/:user_id/subscriptions';
}

?>
