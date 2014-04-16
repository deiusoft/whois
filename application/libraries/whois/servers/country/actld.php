<?php namespace Whois\Servers\Country;

class Actld extends \Whois\Server
{
	protected $host = 'whois.nic.ac';
	protected $allow = array
	(
		'ac', 'com.ac', 'net.ac', 'gov.ac', 'org.ac', 'mil.ac'
	);

	public function __construct($domain)
	{
		$this->domain = $this->get_domain($domain);
 		if (!isset($this->query_string))
			$this->query_string = $this->domain;
	}

	public function available()
	{
		return preg_match('/Domain \"'.$this->domain.'\" - Available/i', $this->body);
	}
}