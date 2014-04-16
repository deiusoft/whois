<?php namespace Whois\Servers\Country;

class Lctld extends \Whois\Server
{
	protected $port = 43;
	protected $host = 'whois.nic.lc';
	protected $surplus = array('0');
	protected $delimiter = "\n\r";
	protected $allow = array
	(
		'lc', 'com.lc', 'org.lc', 'net.lc', 'edu.lc', 'gov.lc',
		'l.lc', 'p.lc'
	);

	public function __construct($domain)
	{
		$this->domain = $this->get_domain($domain);
 		if (!isset($this->query_string))
			$this->query_string = $this->domain;
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
		{
			$match[1] = str_replace('before ', '', $match[1]);
			return strtotime($match[1]);
		}

		return null;
	}

	public function updated_on()
	{
		if (preg_match('/Last Updated On:(.*?)\n/', $this->body, $match))
			return strtotime($match[1]);
		
		return null;
	}
}