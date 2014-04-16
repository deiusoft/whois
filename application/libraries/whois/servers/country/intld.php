<?php namespace Whois\Servers\Country;

class Intld extends \Whois\Server
{
	protected $host = 'whois.inregistry.net';
	protected $surplus = array('0');
	protected $delimiter = "\n\r";
	protected $allow = array
	(
		'in', 'co.in', 'firm.in', 'net.in', 'org.in', 'gen.in',
		'ind.in', 'ac.in', 'edu.in', 'res.in', 'ernet.in', 'gov.in',
		'mil.in', 'nic.in'
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