<?php namespace Whois\Servers\Country;

class Kgtld extends \Whois\Server
{
	protected $host = 'whois.domain.kg';
	protected $surplus = array('0');
	protected $allow = array
	(
		'kg', 'com.kg', 'org.kg', 'net.kg', 'edu.kg', 'gov.kg', 'mil.kg'
	);

	public function __construct($domain)
	{
		$this->domain = $this->get_domain($domain);
 		if (!isset($this->query_string))
			$this->query_string = $this->domain;
	}

	public function available()
	{
		return preg_match('/Data not found. This domain is available for registration./', $this->body);
	}

	public function expires_on()
	{
		if (preg_match('/Record expires on[\s]+(.*?)\n/', $this->body, $match))
			return strtotime($match[1]);
		
		return null;
	}

	public function created_on()
	{
		if (preg_match('/Record created:[\s]+(.*?)\n/', $this->body, $match))
			return strtotime($match[1]);
		
		return null;
	}

	public function updated_on()
	{
		if (preg_match('/Record last updated on[\s]+(.*?)\n/', $this->body, $match))
			return strtotime($match[1]);
		
		return null;
	}
}