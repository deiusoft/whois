<?php namespace Whois\Servers\Country;

class Ietld extends \Whois\Server
{
	protected $host = 'whois.domainregistry.ie';
	protected $surplus = array('0');
	protected $allow = array('ie');

	public function __construct($domain)
	{
		$this->domain = $this->get_domain($domain);
 		if (!isset($this->query_string))
			$this->query_string = $this->domain;
	}

	public function available()
	{
		return preg_match('/% Not Registered/', $this->body);
	}

	public function created_on()
	{
		if (preg_match('/registration:[\s]+(.*?)\n/', $this->body, $match))
			return strtotime($match[1]);
		
		return null;
	}

	public function updated_on()
	{
		if (preg_match('/renewal:[\s]+(.*?)\n/', $this->body, $match))
			return strtotime($match[1]);
		
		return null;
	}
}