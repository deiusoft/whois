<?php namespace Whois\Servers\Generic\Registrars;

class NetworkSolutions extends \Whois\Server
{
	protected $host = 'whois.networksolutions.com';
	protected $surplus = array('0', '1', '2', '3', '7', 'last', '1');

	public function __construct($domain)
	{
		$this->domain = $this->get_domain($domain);
		if (!isset($this->query_string))
			$this->query_string = $this->domain;
	}

	public function expires_on()
	{
		if (preg_match('/Record expires on[\s]+(.*?)\n/', $this->body, $match))
			return strtotime($match[1]);
		
		return null;
	}

	public function created_on()
	{
		if (preg_match('/Record created on[\s]+(.*?)\n/', $this->body, $match))
			return strtotime($match[1]);
		
		return null;
	}

	public function updated_on()
	{
		if (preg_match('/Database last updated on[\s]+(.*?)\n/', $this->body, $match))
			return strtotime($match[1]);
		
		return null;
	}
}