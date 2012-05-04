<?php
/**
 *	Comment Model for Posterous API wrapper
 *
 *	@author	RJ Zaworski <rj@rjzaworski.com>
 *	@link	https://github.com/rjz/posterous-php
 */
class PosterousCommentModel extends PosterousModel {

    protected $resource = '/sites/:site_id/posts/:post_id/comments';
}

?>
