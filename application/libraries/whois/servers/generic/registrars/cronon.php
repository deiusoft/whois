<?php namespace Whois\Servers\Generic\Registrars;

class Cronon extends \Whois\Server
{
	protected $host = 'whois.cronon.net';

	public function __construct($domain)
	{
		$this->domain = $this->get_domain($domain);
		if (!isset($this->query_string))
			$this->query_string = $this->domain;
	}

	public function expires_on()
	{
		if (preg_match('/Expires:[\s]+(.*?)\n/', $this->body, $match))
			return strtotime($match[1]);
		
		return null;
	}
}