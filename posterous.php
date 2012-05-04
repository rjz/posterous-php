<?php
/**
 *	Wrapper for Posterous v2 API
 *
 *	@author	RJ Zaworski <rj@rjzaworski.com>
 *	@link	https://github.com/rjz/posterous-php
 */

// replace this with your Posterous login:
// define('POSTEROUS_API_AUTHSTRING', 'you@example.com');

// replace this with your Posterous API token:
// define('POSTEROUS_API_TOKEN', 'your-posterous-api-token');

// Base classes
include_once('lib/exception.php');
include_once('lib/model.php');
include_once('lib/proxy.php');

if (!extension_loaded('curl')) 
{
	throw new PosterousException('CURL is required to interact with the Posterous API');
}

// API Models
include_once('lib/models/comment.php');
include_once('lib/models/contributor.php');
include_once('lib/models/like.php');
include_once('lib/models/page.php');
include_once('lib/models/post.php');
include_once('lib/models/profile.php');
include_once('lib/models/site.php');
include_once('lib/models/subscriber.php');
include_once('lib/models/subscription.php');
include_once('lib/models/tag.php');
include_once('lib/models/user.php');

?>
