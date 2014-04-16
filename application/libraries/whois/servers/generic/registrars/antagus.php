<?php namespace Whois\Servers\Generic\Registrars;

class Antagus extends \Whois\Server
{
	protected $host = 'whois.antagus.de';
	protected $surplus = array('0', '1');

	public function __construct($domain)
	{
		$this->domain = $this->get_domain($domain);
		if (!isset($this->query_string))
			$this->query_string = $this->domain;
	}

	public function expires_on()
	{
		if (preg_match('/ Record expires on:[\s]+(.*?)\n/', $this->body, $match))
			return strtotime($match[1]);
		
		return null;
	}
}