<?php namespace Whois\Servers\Country;

class Gytld extends \Whois\Server
{
	protected $host = 'whois.registry.gy';
	protected $surplus = array('last', '2');
	protected $allow = array
	(
		'gy', 'com.gy', 'org.gy', 'co.gy', 'net.gy', 'gov.gy', 'edu.gy'
	);

	public function __construct($domain)
	{
		$this->domain = $this->get_domain($domain);
 		if (!isset($this->query_string))
			$this->query_string = $this->domain;
	}

	public function available()
	{
		return preg_match('/Domain Status: Available/', $this->body);
	}

	public function expires_on()
	{
		if (preg_match('/Registry Expiry Date:[\s]+(.*?)\n/', $this->body, $match))
			return strtotime($match[1]);
		
		return null;
	}

	public function created_on()
	{
		if (preg_match('/Creation Date:[\s]+(.*?)\n/', $this->body, $match))
			return strtotime($match[1]);
		
		return null;
	}

	public function updated_on()
	{
		if (preg_match('/Updated Date:[\s]+(.*?)\n/', $this->body, $match))
			return strtotime($match[1]);
		
		return null;
	}
}