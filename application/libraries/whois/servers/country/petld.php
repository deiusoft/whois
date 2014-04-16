<?php namespace Whois\Servers\Country;

class Petld extends \Whois\Server
{
	protected $host = 'kero.yachay.pe';
	protected $surplus = array('0');
	protected $allow = array
	(
		'pe', 'com.pe', 'org.pe', 'net.pe', 'edu.pe', 'gob.pe',
		'mil.pe', 'sld.pe'
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
}