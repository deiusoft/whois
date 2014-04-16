<?php namespace Whois\Servers\Country;

class Nctld extends \Whois\Server
{
	protected $host = 'whois.nc';
	protected $surplus = array('0', 'last', '1');
	protected $allow = array
	(
		'nc', 'asso.nc'
	);

	public function __construct($domain)
	{
		$this->domain = $this->get_domain($domain);
 		if (!isset($this->query_string))
			$this->query_string = $this->domain;
	}

	public function available()
	{
		return preg_match('/No entries found in the .nc database/', $this->body);
	}

	public function expires_on()
	{
		if (preg_match('/Expires on :[\s]+(.*?)\n/', $this->body, $match))
			return strtotime($match[1]);
		
		return null;
	}

	public function created_on()
	{
		if (preg_match('/Created on :[\s]+(.*?)\n/', $this->body, $match))
			return strtotime($match[1]);
		
		return null;
	}

	public function updated_on()
	{
		if (preg_match('/Last updated on :[\s]+(.*?)\n/', $this->body, $match))
			return strtotime($match[1]);
		
		return null;
	}
}