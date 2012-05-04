<?php
/**
 *	Association Proxy for Posterous v2 API
 *
 *	Reference: https://posterous.com/api/
 *
 *	@author	RJ Zaworski <rj@rjzaworski.com>
 *	@link	https://github.com/rjz/posterous-php
 */
class PosterousModelProxy
{
	protected

		/**
		 *	The proxied object
		 *	@type	object
		 */
		$model = null,

		/**
		 *	The class name of the proxied object
		 *	@type	string
		 */
		$proxy_class = null,

		/**
		 *	The parent object
		 *	@type	object
		 */
		$proxy_parent = null;

	/**
	 *	We can build it!
	 *	@param	object	the class this proxy is standing in for
	 */
	public function __construct($proxy_klass, $parent)
	{
		$this->proxy_class = $proxy_klass;
		$this->proxy_parent = $parent;
	}

	/**
	 *	Just some magic
	 */
	public function __call($name, $args) 
	{
		$callback = array($this->get_instance(), $name);
		return call_user_func_array($callback, $args);
	}

	/**
	 *	Create or retrieve the model instance this proxy acts on behalf of
	 */
	public function get_instance()
	{
		$attributes = array();

		if (!class_exists($this->proxy_class)) {
			throw new PosterousException('Attempted to proxy non-existent class: ' . $this->proxy_class);
		}

		if ($this->model === null) {
			$model_class = $this->proxy_class;
			$this->model = new $model_class($attributes, $this->proxy_parent);
		}

		return $this->model;
	}
}

?>
