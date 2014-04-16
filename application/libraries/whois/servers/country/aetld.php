<?php namespace Whois\Servers\Country;

class Aetld extends \Whois\Server
{
	protected $host = 'whois.aeda.net.ae';
	protected $delimiter = "\n\r";
	protected $allow = array
	(
		'ae', 'co.ae', 'net.ae', 'gov.ae', 'ac.ae', 'sch.ae', 'org.ae',
		'mil.ae', 'pro.ae', 'name.ae'
	);

	public function __construct($domain)
	{
		$this->domain = $this->get_domain($domain);
 		if (!isset($this->query_string))
			$this->query_string = $this->domain;
	}

	public function available()
	{
		return preg_match('/No Data Found/', $this->body);
	}
}