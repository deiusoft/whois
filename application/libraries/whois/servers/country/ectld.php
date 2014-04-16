<?php namespace Whois\Servers\Country;

class Ectld extends \Whois\Server
{
	protected $host = 'whois.nic.ec';
	protected $surplus = array('0', '1');	
	protected $allow = array
	(
		'ec', 'com.ec', 'net.ec', 'edu.ec', 'org.ec', 'gov.ec',
		'info.ec', 'fin.ec', 'med.ec', 'pro.ec', 'gob.ec', 'mil.ec'
	);

	public function __construct($domain)
	{
		$this->domain = $this->get_domain($domain);
 		if (!isset($this->query_string))
			$this->query_string = $this->domain;
	}

	public function available()
	{
		return preg_match('/Status: Not Registered/', $this->body);
	}

	public function expires_on()
	{
		if (preg_match('/Expires:[\s]+(.*?)\n/', $this->body, $match))
			return strtotime($match[1]);
		
		return null;
	}

	public function created_on()
	{
		if (preg_match('/Created:[\s]+(.*?)\n/', $this->body, $match))
			return strtotime($match[1]);
		
		return null;
	}

	public function updated_on()
	{
		if (preg_match('/Modified:[\s]+(.*?)\n/', $this->body, $match))
			return strtotime($match[1]);
		
		return null;
	}
}