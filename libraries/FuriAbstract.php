<?php defined('SYSPATH') OR die('No direct access allowed.');

abstract class FuriAbstract {

	public function __construct()
	{
		// Load default options from config file
		$default_options = Kohana::config('furi.defaults.options');

		foreach (  $default_options as $option => $value )
		{
			$this->set_option($option, $value);
		}
	}

/* ----------------------------------------------------------------------------
	Interface Methods
---------------------------------------------------------------------------- */

	public function get($url)
	{
		return $this->method('GET')->request($url);
	}

	public function post($url, $data)
	{
		$this->set_option('postfields', $data);
		return $this->method('POST')->request($url);
	}

	public function put($url, $file)
	{
		$this->set_option('infile', $file);
		return $this->method('PUT')->request($url);
	}

	public function delete($url)
	{
		return $this->method('DELETE')->request($url);
	}

	public function copy_cookies()
	{
		if ( is_array($_COOKIE) )
		{
			$cookies = array();
			foreach ( $_COOKIE as $key => $value )
			{
				$cookies[] = $key . '=' . $value;
			}

			$this->set_header('Cookie: ' . implode('; ', $cookies));
		}
	}

	// @todo unsure if/how this behaves with HTTP-X headers
	public function copy_headers()
	{
		foreach ( $_SERVER as $key => $value )
		{
			if ( 'HTTP_' == substr($key, 0, 5) )
			{
				$key = str_replace('HTTP_', '', $key);
				$key = str_replace('_', '-', $key);
				$key = strtolower($key);
				$key = ucwords($key);

				if ( $key != 'Cookie' )
				{
					$this->set_header($key . ': ' . $value);
				}
			}
		}
	}

} // End FuriAbstract