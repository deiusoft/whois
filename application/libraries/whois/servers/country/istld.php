<?php namespace Whois\Servers\Country;

class Istld extends \Whois\Server
{
	protected $host = 'whois.isnic.is';
	protected $surplus = array('0');
	protected $allow = array
	(
		'is', 'com.is', 'org.is', 'net.is', 'edu.is', 'gov.is', 'idv.is'
	);

	public function __construct($domain)
	{
		$this->domain = $this->get_domain($domain);
 		if (!isset($this->query_string))
			$this->query_string = $this->domain;
	}

	public function available()
	{
		return preg_match('/% No entries found for query \"'.$this->domain.'\"./i', $this->body);
	}

	public function expires_on()
	{
		if (preg_match('/expires:[\s]+(.*?)\n/', $this->body, $match))
			return strtotime($match[1]);
		
		return null;
	}

	public function created_on()
	{
		if (preg_match('/created:[\s]+(.*?)\n/', $this->body, $match))
			return strtotime($match[1]);
		
		return null;
	}
}