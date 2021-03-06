<?php namespace Whois\Servers\Generic\Registrars;

class UnitedDomains extends \Whois\Server
{
	protected $host = 'whois.udag.net';
	protected $surplus = array('0', 'last', '1');
	protected $delimiter = "\n\r";

	public function __construct($domain)
	{
		$this->domain = $this->get_domain($domain);
		if (!isset($this->query_string))
			$this->query_string = $this->domain;
	}

	public function expires_on()
	{
		if (preg_match('/expire date:[\s]+(.*?)\n/', $this->body, $match))
			return strtotime($match[1]);
		
		return null;
	}

	public function created_on()
	{
		if (preg_match('/create date:[\s]+(.*?)\n/', $this->body, $match))
			return strtotime($match[1]);
		
		return null;
	}
}