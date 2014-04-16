<?php namespace Whois\Servers\Country;

class Dmtld extends \Whois\Server
{
	protected $host = 'whois.nic.dm';
	protected $surplus = array('0');
	protected $allow = array
	(
		'dm', 'com.dm', 'net.dm', 'org.dm'
	);

	public function __construct($domain)
	{
		$this->domain = $this->get_domain($domain);
 		if (!isset($this->query_string))
			$this->query_string = $this->domain;
	}

	public function available()
	{
		return preg_match('/not found.../', $this->body);
	}

	public function expires_on()
	{
		if (preg_match('/expiration date:[\s]+(.*?)\n/', $this->body, $match))
			return strtotime($match[1]);
		
		return null;
	}

	public function created_on()
	{
		if (preg_match('/created date:[\s]+(.*?)\n/', $this->body, $match))
			return strtotime($match[1]);
		
		return null;
	}

	public function updated_on()
	{
		if (preg_match('/updated date:[\s]+(.*?)\n/', $this->body, $match))
			return strtotime($match[1]);
		
		return null;
	}
}