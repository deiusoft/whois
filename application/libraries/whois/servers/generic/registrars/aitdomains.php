<?php namespace Whois\Servers\Generic\Registrars;

class AitDomains extends \Whois\Server
{
	protected $host = 'whois.aitdomains.com';
	protected $surplus = array('0', '1');

	public function __construct($domain)
	{
		$this->domain = $this->get_domain($domain);
		if (!isset($this->query_string))
			$this->query_string = $this->domain;
	}

	public function expires_on()
	{
		if (preg_match('/Expire on[\.]+[\s]+(.*?)\n/', $this->body, $match))
			return strtotime($match[1]);
		
		return null;
	}

	public function created_on()
	{
		if (preg_match('/Record Created on[\.]+[\s]+(.*?)\n/', $this->body, $match))
			return strtotime($match[1]);
		
		return null;
	}

	public function updated_on()
	{
		if (preg_match('/Record last updated on[\.]+[\s]+(.*?)\n/', $this->body, $match))
			return strtotime($match[1]);
		
		return null;
	}
}