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
include_once('exception.php');
include_once('model.php');

if (!extension_loaded('curl')) 
{
	throw new PosterousException('CURL is required to interact with the Posterous API');
}

// API Models
include_once('models/comment.php');
include_once('models/like.php');
include_once('models/post.php');
include_once('models/site.php');

?>
