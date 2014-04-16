<?php namespace Whois\Servers\Country;

class Qatld extends \Whois\Server
{
	protected $host = 'whois.registry.qa';
	protected $delimiter = "\n\r";
	protected $allow = array
	(
		'qa', 'com.qa', 'org.qa', 'net.qa', 'edu.qa', 'gov.qa',
		'mil.qa', 'name.qa', 'sch.qa'
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