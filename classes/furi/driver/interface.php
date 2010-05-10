<?php defined('SYSPATH') or die('No direct access allowed.');

/**
 * fURI driver interface, must be implemented by all drivers.
 *
 * @package fURI
 * @author  Beau Dacious <beau@cxzcxz.com>
 * @author  avis <smgladkovskiy@gmail.com>
 */
interface Furi_Driver_Interface {

	public function get($uri);
	public function post($uri, $data);

} // End Furi_Driver