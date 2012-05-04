<?php
/**
 *	Base model for RESTful (ish) interactions with the Posterous v2 API
 *
 *	Reference: https://posterous.com/api/
 *
 *	@author	RJ Zaworski <rj@rjzaworski.com>
 *	@link	https://github.com/rjz/posterous-php
 */
class PosterousModel 
{
	protected

		/**
		 *	Hash of model attributes
		 *	@type array
		 */
		$attributes = array(),

		/**
		 *	A parent model this resource belongs to
		 *	@type array
		 */
		$parent = null;

	protected

		/**
		 *	Define in subclasses to describe plural child resources
		 *	@type array
		 */
		$has_many = array(),

		/**
		 *	Define in subclasses to describe single child resources
		 *	@type array
		 */
		$has_one = array(),

		/**
		 *	Define in subclasses to describe base resource URL
		 *	@type array
		 */
		$resource = '';

	/**
	 *	Infer the key of the current model
	 *	@param	object	$model to determine the key of
	 *	@return	string
	 */
	protected function model_key ($model = null) 
	{
		if (!$model) {
			$model = $this;
		}

		preg_match('#Posterous(.*)Model#', get_class($model), $class_name);

		if (count($class_name) < 2) 
		{
			return '';
		}

		return strtolower($class_name[1]);
	}

	/**
	 *	Get the class corresponding to a given key
	 *	@param	string	$key of the model
	 *	@return	string	the class name corresponding to $key
	 */
	protected function model_class_name ($key) 
	{
		return 'Posterous' . ucfirst($this->convert_attribute_key($key, true)) . 'Model';
	}

	/**
	 *	Return the base resource URL that describes this model
	 *	@return	string
	 */
	protected function parsed_resource_url () 
	{
		$resource_url = rtrim('https://posterous.com/api/2/' . $this->resource, '/');
		return preg_replace_callback('#(?:\:)[^\/]+#', array($this, 'get_attribute'), $resource_url);
	}

	/**
	 *	Return the resource URL that describes this instance of this model
	 *	@return string
	 */
	protected function instance_url () 
	{
		$url = $this->parsed_resource_url();

		if (!$this->is_new()) {
			return $url . '/' . $this->attributes['id'];
		}

		return $url;
	}

	/**
	 *	Cleans up a key string for use with the attributes hash
	 *	@param	string	$key to clean up
	 *	@return	string	the cleaned key
	 */
	protected function convert_attribute_key($key, $singular = false)
	{
		// handle wrapping array (e.g. from preg_replace)
		if (is_array($key)) 
		{
			$key = $key[0];
		}

		// handle symbol-style key
		if ($key[0] == ':') 
		{
			$key = substr($key, 1);
		}

		if ($singular && substr($key, -1) == 's') 
		{
			$key = substr($key, 0, -1);	
		}

		return $key;
	}

	/**
	 *	Magic: initialize
	 *	@param	array	$attributes to set when model is initialized
	 *	@param	object	$parent model to assign this child to
	 */
	public function __construct ($attributes = null, $parent = null) {

		if (is_array($attributes)) {
			$this->attributes = $attributes;
		}

		if ($parent) {
			$this->parent = $parent;
			while ($parent) {
				$this->attributes[$parent->model_key() . '_id'] = $parent->get_attribute('id');
				$parent = $parent->parent;
			}
		}
	}

	/**
	 *	Magic: retrieve arbitrary child resources
	 *	@param	string	$key to look up
	 */
	public function __get ($key)
	{
		if ($this->is_new()) {
			throw new Exception("Failed looking up relative of new model: $key");
		}

		// check if $key corresponds to a known plural resource
		if (in_array($key, $this->has_many) || in_array($key, $this->has_one))
		{
			if (class_exists($class_name = $this->model_class_name($key)))
			{
				$obj = new $class_name(array(), $this);
				return $obj;
			}
		}

		// Nope? Eh.. dump it.
		throw new Exception("Failed looking up unknown relationship: $key");
	}

	/**
	 *	Determine if this model is new or not
	 *	@return	boolean
	 */
	public function is_new () 
	{
		return !isset($this->attributes['id']);
	}

	/**
	 *	Return all matching models
	 *	@return	array
	 */
	public function all () 
	{
		return $this->request('GET', $this->parsed_resource_url());
	}

	/**
	 *	Return a single model by ID
	 *	@param	number	(optional) $id of the model to find. If blank, the
	 *					id in the attributes hash will be used instead
	 *	@return	object
	 */
	public function find ($id = -1) 
	{
		if ($id > -1) 
		{
			$this->attributes['id'] = $id;
		}

		assert(isset($this->attributes['id']));

		return $this->request('GET', $this->instance_url());
	}

	/**
	 *	Create a new instance of this model
	 *	@param	array	(optional) instance $attributes to assign before creating
	 *	@return	object	a copy of the object created by the request
	 */
	public function create ($attributes = null)
	{
		if ($attributes) {
			$this->set_instance_attributes($attributes);
		}

		return $this->request('POST', $this->parsed_resource_url(), $this->attributes);
	}
	/**
	 *	Save this instance of this model
	 *	@param	array	(optional) instance $attributes to assign before creating
	 *	@return	object	a copy of the object updated by the request
	 */
	public function save ($attributes = null)
	{
		if ($attributes) {
			$this->set_instance_attributes($attributes);
		}

		assert(isset($this->attributes['id']));

		return $this->request('PUT', $this->instance_url(), $this->attributes);
	}

	/**
	 *	Delete a model
	 *	@param	number	(optional) $id of the model to find. If blank, the
	 *					id in the attributes hash will be used instead
	 */
	public function delete ($id = -1) 
	{
		if ($id > -1) 
		{
			$this->attributes['id'] = $id;
		}

		return $this->request('DELETE', $this->instance_url());
	}

	/**
	 *	Retrieve a variable from the attributes hash
	 *	@param	string	$key of the variable to set
	 */
	public function get_attribute ($key) 
	{
		$key = $this->convert_attribute_key($key);

		if (array_key_exists($key, $this->attributes)) 
		{
			return $this->attributes[$key];
		}

		return null;
	}

	/**
	 *	Set raw variables in the attributes hash
	 *	@param	array	$hash of attributes to set
	 */
	public function set_attributes ($hash)
	{
		$object_hash = array();
		foreach ($hash as $key => $value) {
			$key = $this->convert_attribute_key($key);
			$object_hash[$key] = $value;
		}
		$this->attributes = ($object_hash + $this->attributes);
	}

	/**
	 *	Get the current value of an instance attribute
	 *	@param	string	$key of attribute to retrieve
	 *	@return	mixed
	 */
	public function get_instance_attribute ($key)
	{
		$model_key = $this->model_key();
		$hash = $this->attributes;

		// check that model key is defined in attribute hash
		if (isset($hash[$model_key]) && is_array($hash = $hash[$model_key]) && isset($hash[$key])) 
		{
			return $hash[$key];
		}

		return null;
	}

	/**
	 *	Set instance variables in the attributes hash. For posts,
	 *	this means everything within `$attributes['post']`.
	 *	@param	array	$hash of attributes to set
	 */
	public function set_instance_attributes ($hash) 
	{
		$model_key = $this->model_key();
		$object_hash = array();

		// if instance attributes have already been set, copy them
		// over to the temporary hash:
		if (isset($this->attributes[$model_key]))
		{
			$object_hash = $this->attributes[$model_key];
		}

		// if `$hash` contains a subarray of instance data, use 
		// its contents instead of the top-level hash:
		if (isset($hash[$model_key]) && is_array($hash[$model_key])) 
		{
			$hash = $hash[$model_key];
		}

		// copy
		foreach ($hash as $key => $value) {
			$key = $this->convert_attribute_key($key);
			$object_hash[$key] = $value;
		}

		$this->attributes[$model_key] = $object_hash; 
	}

	/**
	 * Send a POST requst using cURL 
	 * @param string $method to use
	 * @param string $url to request 
	 * @param array $post values to send 
	 * @param array $options for cURL 
	 * @return string 
	 */ 
	protected function curl_post($method, $url, $post) 
	{
		$defaults = array( 
			CURLOPT_CUSTOMREQUEST => $method,
			CURLOPT_HEADER => 0, 
			CURLOPT_URL => $url,
			CURLOPT_USERPWD => POSTEROUS_API_AUTHSTRING,
			CURLOPT_FRESH_CONNECT => 1,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_FORBID_REUSE => 1, 
			CURLOPT_TIMEOUT => 4, 
			CURLOPT_POSTFIELDS => http_build_query($post) 
		); 

		$ch = curl_init(); 
		curl_setopt_array($ch, $defaults);
		// FIXME: cheap hack to avoid verifying the SSL certificate
		//        sent by the API
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		if (! $result = curl_exec($ch)) 
		{
			trigger_error(curl_error($ch)); 
		}
		curl_close($ch);

		return $result; 
	} 

	/** 
	 * Send a GET requst using cURL 
	 * @param string $url to request 
	 * @param array $get values to send 
	 * @param array $options for cURL 
	 * @return string 
	 */ 
	protected function curl_get($url, $get) 
	{
		$defaults = array( 
			CURLOPT_URL => $url . (strpos($url, '?') === false ? '?' : '') . http_build_query($get),
			CURLOPT_USERPWD => POSTEROUS_API_AUTHSTRING,
			CURLOPT_HEADER => 0, 
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_TIMEOUT => 4 
		); 

		$ch = curl_init(); 
		curl_setopt_array($ch, $defaults); 
		// FIXME: cheap hack to avoid verifying the SSL certificate
		//        sent by the API
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

		if (!$result = curl_exec($ch))
		{
			trigger_error(curl_error($ch));
		}
		curl_close($ch); 
		return $result; 
	} 

	/** 
	 * Send a GET requst using cURL 
	 * @param string $url to request 
	 * @param array $get values to send 
	 * @param array $options for cURL 
	 * @return string 
	 */
	protected function request($method, $url, $object = null)
	{
		$method = strtoupper($method);

		if (!$object) {
			$object = array();
		}

		$object += array(
			'api_token' => POSTEROUS_API_TOKEN
		);

		if ($method == 'GET') 
		{
			$result = $this->curl_get($url, $object);
		}
		else
		{
			$result = $this->curl_post($method, $url, $object);
		}

		return json_decode($result);
	}
}
