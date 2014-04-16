<?php namespace Whois\Servers\Generic\Registrars;

class Cdmon extends \Whois\Server
{
	protected $host = 'whois.cdmon.com';
	protected $surplus = array('last', '3');
	protected $delimiter = "\n\r";

	public function __construct($domain)
	{
		$this->domain = $this->get_domain($domain);
		if (!isset($this->query_string))
			$this->query_string = $this->domain;
	}

	public function expires_on()
	{
		if (preg_match('/Record expires on :(.*?)\n/', $this->body, $match))
			return strtotime($match[1]);
		
		return null;
	}

	public function created_on()
	{
		if (preg_match('/Record created on :(.*?)\n/', $this->body, $match))
			return strtotime($match[1]);
		
		return null;
	}

	public function updated_on()
	{
		if (preg_match('/Record last updated on :(.*?)\n/', $this->body, $match))
			return strtotime($match[1]);
		
		return null;
	}
}