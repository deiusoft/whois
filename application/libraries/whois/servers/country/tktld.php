<?php namespace Whois\Servers\Country;

class Tktld extends \Whois\Server
{
	protected $host = 'whois.dot.tk';
	protected $surplus = array('0');
	protected $allow = array('tk');

	public function __construct($domain)
	{
		$this->domain = $this->get_domain($domain);
 		if (!isset($this->query_string))
			$this->query_string = $this->domain;
	}

	public function available()
	{
		return preg_match('/Invalid query or domain name not known in Dot TK Domain Registry/', $this->body);
	}

	public function expires_on()
	{
		if (preg_match('/Record will expire on:[\s]+(.*?)\n/', $this->body, $match))
			return strtotime($match[1]);
		
		return null;
	}

	public function created_on()
	{
		if (preg_match('/Domain registered:[\s]+(.*?)\n/', $this->body, $match))
			return strtotime($match[1]);
		
		return null;
	}
}