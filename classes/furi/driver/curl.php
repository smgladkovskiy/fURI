<?php defined('SYSPATH') or die('No direct access allowed.');
/**
 * cURL fURI Driver
 * 
 * @todo  test switching back and forth between GET and POST
 * @todo  add support for multi handles?
 * @todo  add support for cookie file
 * 
 * @package fURI
 * @author  Beau Dacious <beau@cxzcxz.com>
 * @author  avis <smgladkovskiy@gmail.com>
 */
class Furi_Driver_cURL extends Furi_Core implements Furi_Driver_Interface {

	// cURL handle
	protected $ch;
	
	public function __construct($config = array())
	{
		parent::__construct($config);
		// Create a cURL handle
		$this->ch = curl_init();
		
		// Set global cURL options
		curl_setopt($this->ch, CURLOPT_RETURNTRANSFER, TRUE);
	}

	public function __destruct()
	{
		curl_close($this->ch);
		parent::__destruct();
	}

	public function get($uri)
	{
		curl_setopt($this->ch, CURLOPT_URL,     $uri);
		curl_setopt($this->ch, CURLOPT_HTTPGET, TRUE);
		
		return curl_exec($this->ch);
	}
	
	public function post($uri, $data)
	{
		curl_setopt($this->ch, CURLOPT_URL,        $uri);
		curl_setopt($this->ch, CURLOPT_POST,       TRUE);
		curl_setopt($this->ch, CURLOPT_POSTFIELDS, $data);
		
		return curl_exec($this->ch);
	}

} // End Furi_cURL_Driver