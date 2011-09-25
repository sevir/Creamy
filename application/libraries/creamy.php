<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class creamy {

	var $CI; //CodeIgniter instance

	public function __construct()
	{
		$this->CI =& get_instance();
	}
}

/* eof file application/libraries/creamy.php */