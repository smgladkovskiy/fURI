<?php defined('SYSPATH') or die('No direct access allowed.');
/**
 * Remote content fetching library.
 * 
 * @package fURI
 * @author  Beau Dacious <beau@cxzcxz.com>
 * @author  avis <smgladkovskiy@gmail.com>
 */
class Furi_Core {
	
	// Configuration
	protected $config;

	// fURI instance
	public static $instance;
	
	/**
	 * Create an instance of fURI.
	 * 
	 * @return object
	 */
	public static function factory($config = array())
	{
		$config = Kohana::config('furi');

		// Check for 'auto' driver and adjust configuration
		if ( strtolower($config->driver == 'auto') )
		{
			if ( function_exists('curl_init') )
			{
				$config->driver = 'cURL';
			}
			else
			{
				$config->driver = 'Stream';
			}
		}
		$driver = 'Furi_Driver_' . $config->driver;

		$fury = new $driver($config->as_array());
		
		return $fury;
	}

	/**
	 * Return a static instance of fURI.
	 * 
	 * @return  object
	 */
	public static function instance($config = array())
	{
		$config = Kohana::config('furi');

		// Check for 'auto' driver and adjust configuration
		if ( strtolower($config->driver == 'auto') )
		{
			if ( function_exists('curl_init') )
			{
				$config->driver = 'cURL';
			}
			else
			{
				$config->driver = 'Stream';
			}
		}

		$driver = 'Furi_Driver_' . $config->driver;

		if( ! is_object(self::$instance))
		{
			if ( ! Kohana::auto_load($driver) )
			{
				throw new Kohana_Exception('core.driver_not_found', $config['driver'], get_class($this));
			}
			
			self::$instance = new $driver($config->as_array());
		}

		return self::$instance;
	}

	public function __construct($config = array())
	{
		// Append default fURI configuration
		$config += Kohana::config('furi')->as_array();

		// Save the config in the object
		$this->config = $config;
	}
	
	public function get($uri)
	{
		return $this->get($uri);
	}
	
	public function post($uri, $data)
	{
		if ( ! is_array($data) )
		{
			if ( is_string($data) )
			{
				$query = $data;
				$data = array();
				
				parse_str($query, $data);
			}
			elseif ( is_object($data) )
			{
				$data = (array) $data;
			}
			else
			{
				// Unsupported type
				return FALSE;
			}
		}
		
		return $this->post($uri, $data);
	}

} // End Furi_Core