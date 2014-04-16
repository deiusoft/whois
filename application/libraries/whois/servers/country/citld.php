<?php namespace Whois\Servers\Country;

class Citld extends \Whois\Server
{
	protected $host = 'whois.nic.ci';
	protected $allow = array
	(
		'ci', 'com.ci', 'co.ci', 'net.ci', 'edu.ci', 'ed.ci', 'ac.ci',
		'org.ci', 'or.ci', 'go.ci', 'asso.ci', 'aeroport.ci',
		'int.ci', 'presse.ci'
	);

	public function __construct($domain)
	{
		$this->domain = $this->get_domain($domain);
 		if (!isset($this->query_string))
			$this->query_string = $this->domain;
	}

	public function available()
	{
		return preg_match('/Domain '.$this->domain.' not found/', $this->body);
	}

	public function expires_on()
	{
		if (preg_match('/Expiration date:[\s]+(.*?)\n/', $this->body, $match))
			return strtotime($match[1]);
		
		return null;
	}

	public function created_on()
	{
		if (preg_match('/Created:[\s]+(.*?)\n/', $this->body, $match))
			return strtotime($match[1]);
		
		return null;
	}
}