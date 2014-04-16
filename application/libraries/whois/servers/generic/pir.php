<?php namespace Whois\Servers\Generic;

class Pir extends \Whois\Server
{
	protected $host = 'whois.pir.org';
	protected $surplus = array('0');
	protected $delimiter = "\n\r";
	protected $allow = array('org');

	public function __construct($domain)
	{
		$this->domain = $this->get_domain($domain);
 		if (!isset($this->query_string))
			$this->query_string = $this->domain;
	}

	public function next()
	{
		if (preg_match('/Sponsoring Registrar:Network Solutions/', $this->body))
			return 'whois.networksolutions.com';
		
		return null;
	}

	public function available()
	{
		return preg_match('/NOT FOUND/', $this->body);
	}

	public function expires_on()
	{
		if (preg_match('/Expiration Date:(.*?)\n/', $this->body, $match))
			return strtotime($match[1]);
		
		return null;
	}

	public function created_on()
	{
		if (preg_match('/Created On:(.*?)\n/', $this->body, $match))
			return strtotime($match[1]);
		
		return null;
	}

	public function updated_on()
	{
		if (preg_match('/Last Updated On:(.*?)\n/', $this->body, $match))
			return strtotime($match[1]);
		
		return null;
	}
}
