<?php namespace Whois\Servers\Country;

class Lvtld extends \Whois\Server
{
	protected $host = 'whois.nic.lv';
	protected $surplus = array('last', '1');
	protected $allow = array
	(
		'lv', 'com.lv', 'org.lv', 'net.lv', 'edu.lv', 'gov.lv',
		'mil.lv', 'id.lv', 'asn.lv', 'conf.lv'
	);

	public function __construct($domain)
	{
		$this->domain = $this->get_domain($domain);
 		if (!isset($this->query_string))
			$this->query_string = $this->domain;
	}

	public function available()
	{
		return preg_match('/Status: free/', $this->body);
	}

	public function expires_on()
	{
		if (preg_match('/Expires:[\s]+(.*?)\n/', $this->body, $match))
			return strtotime($match[1]);
		
		return null;
	}

	public function created_on()
	{
		if (preg_match('/Registered:[\s]+(.*?)\n/', $this->body, $match))
			return strtotime($match[1]);
		
		return null;
	}

	public function updated_on()
	{
		if (preg_match('/Changed:[\s]+(.*?)\n/', $this->body, $match))
			return strtotime($match[1]);
		
		return null;
	}
}