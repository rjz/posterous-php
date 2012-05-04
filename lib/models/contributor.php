<?php
/**
 *	Site Contributor Model for Posterous API wrapper
 *
 *	@author	RJ Zaworski <rj@rjzaworski.com>
 *	@link	https://github.com/rjz/posterous-php
 */
class PosterousContributorModel extends PosterousModel {

    protected $resource = '/sites/:site_id/contributors';
}

?>
