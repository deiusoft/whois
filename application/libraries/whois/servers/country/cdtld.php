<?php namespace Whois\Servers\Country;

class Cdtld extends \Whois\Server
{
	protected $host = 'whois.nic.cd';
	protected $surplus = array('0', '1');
	protected $allow = array('cd');

	public function __construct($domain)
	{
		$this->domain = $this->get_domain($domain);
		if (!isset($this->query_string))
			$this->query_string = $this->domain;
	}

	public function available()
	{
		return preg_match('/Domain Not Found/', $this->body);
	}

	public function expires_on()
	{
		if (preg_match('/Expiration Date:[\s]+(.*?)\n/', $this->body, $match))
			return strtotime($match[1]);
		
		return null;
	}

	public function created_on()
	{
		if (preg_match('/Creation Date:[\s]+(.*?)\n/', $this->body, $match))
			return strtotime($match[1]);
		
		return null;
	}
}