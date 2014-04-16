<?php namespace Whois\Servers\Country;

class Omtld extends \Whois\Server
{
	protected $host = 'whois.registry.om';
	protected $allow = array
	(
		'om', 'com.om', 'org.om', 'net.om', 'edu.om', 'gov.om',
		'co.om', 'museum.om', 'med.om', 'pro.om'
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

	public function updated_on()
	{
		if (preg_match('/Last Modified:[\s]+(.*?)\n/', $this->body, $match))
			return strtotime($match[1]);
		
		return null;
	}
}