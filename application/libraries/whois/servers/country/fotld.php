<?php namespace Whois\Servers\Country;

class Fotld extends \Whois\Server
{
	protected $host = 'whois.nic.fo';
	protected $surplus = array('0');
	protected $delimiter = "\n\r";
	protected $allow = array('fo');

	public function __construct($domain)
	{
		$this->domain = $this->get_domain($domain);
		if (!isset($this->query_string))
			$this->query_string = $this->domain;
	}

	public function available()
	{
		return preg_match('/%ERROR:101: no entries found/', $this->body);
	}

	public function expires_on()
	{
		if (preg_match('/expire:[\s]+(.*?)\n/', $this->body, $match))
			return strtotime($match[1]);
		
		return null;
	}

	public function created_on()
	{
		if (preg_match('/registered:[\s]+(.*?)\n/', $this->body, $match))
			return strtotime($match[1]);
		
		return null;
	}

	public function updated_on()
	{
		if (preg_match('/changed:[\s]+(.*?)\n/', $this->body, $match))
			return strtotime($match[1]);
		
		return null;
	}
}