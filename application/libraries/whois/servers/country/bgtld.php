<?php namespace Whois\Servers\Country;

class Bgtld extends \Whois\Server
{
	protected $host = 'whois.register.bg';
	protected $allow = array
	(
		'bg', 'com.au', 'net.au', 'edu.au', 'org.au', 'gov.au'
	);

	public function __construct($domain)
	{
		$this->domain = $this->get_domain($domain);
 		if (!isset($this->query_string))
			$this->query_string = $this->domain;
	}

	public function available()
	{
		return preg_match('/Domain name '.$this->domain.' does not exist in database!/i', $this->body);
	}

	public function expires_on()
	{
		if (preg_match('/expires at:[\s]+(.*?)\n/', $this->body, $match))
		{
			$match[1] = str_replace('/', '-', $match[1]);
			return strtotime($match[1]);
		}
		
		return null;
	}

	public function created_on()
	{
		if (preg_match('/activated on:[\s]+(.*?)\n/', $this->body, $match))
		{
			$match[1] = str_replace('/', '-', $match[1]);
			return strtotime($match[1]);
		}
			
		
		return null;
	}
}