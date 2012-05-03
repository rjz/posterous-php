<?php
/**
 *	Site Subscriber Model for Posterous API wrapper
 *
 *	@author	RJ Zaworski <rj@rjzaworski.com>
 *	@link	https://github.com/rjz/posterous-php
 */
class PosterousSubscriberModel extends PosterousModel {

    protected $resource = '/sites/:site_id/subscribers';
}

?>
