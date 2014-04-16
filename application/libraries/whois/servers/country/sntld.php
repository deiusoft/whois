<?php namespace Whois\Servers\Country;

class Sntld extends \Whois\Server
{
	protected $host = 'whois.nic.sn';
	protected $allow = array
	(
		'sn', 'com.sn', 'org.sn', 'art.sn', 'edu.sn', 'gouv.sn',
		'perso.sn', 'univ.sn'
	);

	public function __construct($domain)
	{
		$this->domain = $this->get_domain($domain);
 		if (!isset($this->query_string))
			$this->query_string = $this->domain;
	}
}