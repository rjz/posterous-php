A quick and dirty PHP wrapper for the [Posterous API](https://posterous.com/api) that riffs pretty heavily on [the official gem](https://github.com/posterous/posterous-gem).

*This project provides a very rough outline of a few key pieces of the API.* If you're willing to contribute, please don't hesitate to fork and submit a pull request or two!

Requirements
------------

 * PHP 5.3+
 * [CURL](http://curl.haxx.se/libcurl/php/)

Quick Start
-----------

Define your account settings and include the API:

    define('POSTEROUS_API_AUTHSTRING', 'you@example.com:password');
    define('POSTEROUS_API_TOKEN', 'YOUR-API-TOKEN');

	require_once('posterous/posterous.php');

    $site = new PosterousSiteModel();
    $site_data = $site->find('primary');

Reference
---------

Get all posts from primary site:

    $site = new PosterousSiteModel();
    $posts = $site->posts->all();

Save a post:

	$attributes = array(
      'title' => 'new post',
      'body' => 'can haz cheezburger',
      'display_date' => '2011-04-20'
    );

    $post = new PosterousPostModel(array('site_id' => 12345));
    $result = $post->create($attributes);

Update a post:

    $attributes = array(
      'title' => 'updated post',
      'body' => 'i could haz cheezburger, now me hungry',
      'display_date' => '2011-04-20'
    );

    $post = new PosterousPostModel(array('site_id' => 12345, 'id' => 1234567));
    $result = $post->save($attributes);

Delete a post:

    $post = new PosterousPostModel(array('site_id' => 12345, 'id' => 1234567));
    $post->delete();

Resource Types Supported
-------------------

* Comment
* Contributor
* Like
* Page
* Post
* Profile
* Site
* Subscriber
* Subscription
* Tag
* User

Todo
----

* Complete implementation
   - Complete models
   - Association lookups
   - API responses
* Expand test coverage
* Write documentation

Author
------

RJ Zaworski <rj@rjzaworski.com>

License
-------

This code is released under the JSON License. You can read the license [here](http://www.json.org/license.html).
