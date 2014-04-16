<?php namespace Whois\Servers\Country;

class Imtld extends \Whois\Server
{
	protected $host = 'whois.nic.im';
	protected $allow = array
	(
		'im', 'com.im', 'org.im', 'net.im', 'plc.co.im',
		'gov.im', 'ltd.co.im', 'co.im', 'am.im'
	);

	public function __construct($domain)
	{
		$this->domain = $this->get_domain($domain);
 		if (!isset($this->query_string))
			$this->query_string = $this->domain;
	}

	public function available()
	{
		return preg_match('/The domain '.$this->domain.' was not found./', $this->body);
	}

	public function expires_on()
	{
		if (preg_match('/Expiry Date:[\s]+(.*?)\n/', $this->body, $match))
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
		if (preg_match('/Last modified:[\s]+(.*?)\n/', $this->body, $match))
			return strtotime($match[1]);
		
		return null;
	}
}